<?php

namespace App\Controllers\reportes;

use App\Controllers\BaseController;

class cexportar extends BaseController
{
    private function solo_logueado()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }
        return null;
    }

    private function csv_download(string $filename, array $headers, array $rows)
    {
        $this->response->setHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="'.$filename.'"');
        $this->response->setHeader('Pragma', 'no-cache');
        $this->response->setHeader('Expires', '0');

        // Excel-friendly UTF-8 BOM
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($out, $headers);

        foreach ($rows as $r) {
            fputcsv($out, $r);
        }

        fclose($out);
        return $this->response;
    }

    // ✅ EXPORT: ventas diarias
    public function ventas_diarias()
    {
        if ($r = $this->solo_logueado()) return $r;

        $desde = $this->request->getGet('desde') ?? date('Y-m-01');
        $hasta = $this->request->getGet('hasta') ?? date('Y-m-d');

        $db = \Config\Database::connect();

        // AJUSTA: nombres de tabla/campos según tu BD
        // - venta: fecha, total, estado
        $q = $db->table('venta')
            ->select('DATE(fecha) as dia, COUNT(*) as nro_ventas, SUM(total) as total')
            ->where('DATE(fecha) >=', $desde)
            ->where('DATE(fecha) <=', $hasta);

        // si tienes estado (ej 1=activo)
        if ($db->fieldExists('estado', 'venta')) {
            $q->where('estado', 1);
        }

        $rowsDb = $q->groupBy('DATE(fecha)')
            ->orderBy('dia', 'ASC')
            ->get()->getResultArray();

        $rows = [];
        foreach ($rowsDb as $rdb) {
            $rows[] = [
                $rdb['dia'],
                (int)$rdb['nro_ventas'],
                number_format((float)$rdb['total'], 2, '.', '')
            ];
        }

        $fname = "ventas_diarias_{$desde}_{$hasta}.csv";
        return $this->csv_download($fname, ['dia','nro_ventas','total'], $rows);
    }

    // ✅ EXPORT: top productos (más vendidos)
    public function top_productos()
    {
        if ($r = $this->solo_logueado()) return $r;

        $desde = $this->request->getGet('desde') ?? date('Y-m-01');
        $hasta = $this->request->getGet('hasta') ?? date('Y-m-d');
        $limit = (int)($this->request->getGet('limit') ?? 10);

        $db = \Config\Database::connect();

        // AJUSTA: detalle_venta: idventa, idproducto, cantidad, importe
        //         producto: idproducto, nombre, codigo
        $q = $db->table('detalle_venta dv')
            ->select('p.codigo, p.nombre, SUM(dv.cantidad) as cantidad, SUM(dv.importe) as total')
            ->join('venta v', 'v.idventa = dv.idventa', 'inner')
            ->join('producto p', 'p.idproducto = dv.idproducto', 'inner')
            ->where('DATE(v.fecha) >=', $desde)
            ->where('DATE(v.fecha) <=', $hasta);

        if ($db->fieldExists('estado', 'venta')) {
            $q->where('v.estado', 1);
        }

        $rowsDb = $q->groupBy('dv.idproducto')
            ->orderBy('cantidad', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();

        $rows = [];
        foreach ($rowsDb as $rdb) {
            $rows[] = [
                $rdb['codigo'],
                $rdb['nombre'],
                number_format((float)$rdb['cantidad'], 2, '.', ''),
                number_format((float)$rdb['total'], 2, '.', '')
            ];
        }

        $fname = "top_productos_{$desde}_{$hasta}.csv";
        return $this->csv_download($fname, ['codigo','producto','cantidad','total'], $rows);
    }

    // ✅ EXPORT: top clientes (los que más compran)
    public function top_clientes()
    {
        if ($r = $this->solo_logueado()) return $r;

        $desde = $this->request->getGet('desde') ?? date('Y-m-01');
        $hasta = $this->request->getGet('hasta') ?? date('Y-m-d');
        $limit = (int)($this->request->getGet('limit') ?? 10);

        $db = \Config\Database::connect();

        // AJUSTA: venta: idcliente, total
        //         cliente: idcliente, nombre, codigo
        $q = $db->table('venta v')
            ->select('c.codigo, c.nombre, COUNT(*) as nro_ventas, SUM(v.total) as total')
            ->join('cliente c', 'c.idcliente = v.idcliente', 'inner')
            ->where('DATE(v.fecha) >=', $desde)
            ->where('DATE(v.fecha) <=', $hasta);

        if ($db->fieldExists('estado', 'venta')) {
            $q->where('v.estado', 1);
        }

        $rowsDb = $q->groupBy('v.idcliente')
            ->orderBy('total', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();

        $rows = [];
        foreach ($rowsDb as $rdb) {
            $rows[] = [
                $rdb['codigo'],
                $rdb['nombre'],
                (int)$rdb['nro_ventas'],
                number_format((float)$rdb['total'], 2, '.', '')
            ];
        }

        $fname = "top_clientes_{$desde}_{$hasta}.csv";
        return $this->csv_download($fname, ['codigo','cliente','nro_ventas','total'], $rows);
    }
}
