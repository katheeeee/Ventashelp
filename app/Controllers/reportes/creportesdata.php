<?php

namespace App\Controllers\reportes;

use App\Controllers\BaseController;

class creportesdata extends BaseController
{
    private function auth_or_403()
    {
        if (!session()->get('login')) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'no autorizado']);
        }
        return null;
    }

    private function fechas()
    {
        // input type="date" manda YYYY-MM-DD
        $desde = $this->request->getGet('desde') ?? date('Y-m-01');
        $hasta = $this->request->getGet('hasta') ?? date('Y-m-d');

        // por si viene vacío
        if (!$desde) $desde = date('Y-m-01');
        if (!$hasta) $hasta = date('Y-m-d');

        return [$desde, $hasta];
    }

    public function ventas_diarias_data()
    {
        if ($r = $this->auth_or_403()) return $r;
        [$desde, $hasta] = $this->fechas();

        $db = \Config\Database::connect();

        $q = $db->table('venta')
            ->select('DATE(fecha) as dia, COUNT(*) as nro_ventas, SUM(total) as total')
            ->where('DATE(fecha) >=', $desde)
            ->where('DATE(fecha) <=', $hasta);

        if ($db->fieldExists('estado', 'venta')) {
            $q->where('estado', 1);
        }

        $rows = $q->groupBy('DATE(fecha)')
            ->orderBy('dia', 'ASC')
            ->get()->getResultArray();

        // Normaliza valores a números
        foreach ($rows as &$r) {
            $r['nro_ventas'] = (int)($r['nro_ventas'] ?? 0);
            $r['total'] = (float)($r['total'] ?? 0);
        }

        return $this->response->setJSON($rows);
    }

    public function top_productos_data()
    {
        if ($r = $this->auth_or_403()) return $r;
        [$desde, $hasta] = $this->fechas();
        $limit = (int)($this->request->getGet('limit') ?? 10);

        $db = \Config\Database::connect();

        $q = $db->table('detalle_venta dv')
            ->select('p.nombre as nombre, SUM(dv.cantidad) as cantidad, SUM(dv.importe) as total')
            ->join('venta v', 'v.idventa = dv.idventa', 'inner')
            ->join('producto p', 'p.idproducto = dv.idproducto', 'inner')
            ->where('DATE(v.fecha) >=', $desde)
            ->where('DATE(v.fecha) <=', $hasta);

        if ($db->fieldExists('estado', 'venta')) {
            $q->where('v.estado', 1);
        }

        $rows = $q->groupBy('dv.idproducto')
            ->orderBy('cantidad', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();

        foreach ($rows as &$r) {
            $r['cantidad'] = (float)($r['cantidad'] ?? 0);
            $r['total'] = (float)($r['total'] ?? 0);
        }

        return $this->response->setJSON($rows);
    }

    public function top_clientes_data()
    {
        if ($r = $this->auth_or_403()) return $r;
        [$desde, $hasta] = $this->fechas();
        $limit = (int)($this->request->getGet('limit') ?? 10);

        $db = \Config\Database::connect();

        $q = $db->table('venta v')
            ->select('c.nombre as nombre, COUNT(*) as nro_ventas, SUM(v.total) as total')
            ->join('cliente c', 'c.idcliente = v.idcliente', 'inner')
            ->where('DATE(v.fecha) >=', $desde)
            ->where('DATE(v.fecha) <=', $hasta);

        if ($db->fieldExists('estado', 'venta')) {
            $q->where('v.estado', 1);
        }

        $rows = $q->groupBy('v.idcliente')
            ->orderBy('total', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();

        foreach ($rows as &$r) {
            $r['nro_ventas'] = (int)($r['nro_ventas'] ?? 0);
            $r['total'] = (float)($r['total'] ?? 0);
        }

        return $this->response->setJSON($rows);
    }

    public function resumen_data()
    {
        if ($r = $this->auth_or_403()) return $r;
        [$desde, $hasta] = $this->fechas();

        $db = \Config\Database::connect();

        // KPIs
        $k = $db->table('venta')
            ->select('COUNT(*) as ventas, SUM(total) as total, COUNT(DISTINCT idcliente) as clientes')
            ->where('DATE(fecha) >=', $desde)
            ->where('DATE(fecha) <=', $hasta);

        if ($db->fieldExists('estado', 'venta')) {
            $k->where('estado', 1);
        }

        $kpi = $k->get()->getRowArray() ?? ['ventas'=>0,'total'=>0,'clientes'=>0];

        // productos vendidos (distintos) en el rango
        $p = $db->table('detalle_venta dv')
            ->select('COUNT(DISTINCT dv.idproducto) as productos')
            ->join('venta v', 'v.idventa = dv.idventa', 'inner')
            ->where('DATE(v.fecha) >=', $desde)
            ->where('DATE(v.fecha) <=', $hasta);

        if ($db->fieldExists('estado', 'venta')) {
            $p->where('v.estado', 1);
        }

        $prod = $p->get()->getRowArray() ?? ['productos' => 0];

        // Por comprobante (usa idtipo_documento si lo tienes en venta)
        $pc = $db->table('venta v')
            ->select('td.nombre as nombre, SUM(v.total) as total')
            ->join('tipo_documento td', 'td.idtipo_documento = v.idtipo_documento', 'left')
            ->where('DATE(v.fecha) >=', $desde)
            ->where('DATE(v.fecha) <=', $hasta);

        if ($db->fieldExists('estado', 'venta')) {
            $pc->where('v.estado', 1);
        }

        $por_comprobante = $pc->groupBy('v.idtipo_documento')
            ->orderBy('total', 'DESC')
            ->get()->getResultArray();

        foreach ($por_comprobante as &$r) {
            $r['nombre'] = $r['nombre'] ?: 'sin tipo';
            $r['total'] = (float)($r['total'] ?? 0);
        }

        return $this->response->setJSON([
            'kpis' => [
                'ventas' => (int)($kpi['ventas'] ?? 0),
                'total' => (float)($kpi['total'] ?? 0),
                'clientes' => (int)($kpi['clientes'] ?? 0),
                'productos' => (int)($prod['productos'] ?? 0),
            ],
            'por_comprobante' => $por_comprobante
        ]);
    }
}
