<?php

namespace App\Controllers\reportes;

use App\Controllers\BaseController;

class creportesdata extends BaseController
{
    private function rango_fechas(): array
    {
        $desde = $this->request->getGet('desde') ?? date('Y-m-01');
        $hasta = $this->request->getGet('hasta') ?? date('Y-m-d');
        return [$desde, $hasta];
    }

    public function ventas_diarias_data()
    {
        [$desde, $hasta] = $this->rango_fechas();

        $db = \Config\Database::connect();

        $q = $db->table('venta')
            ->select('DATE(fecha) as dia, SUM(total) as total')
            ->where('DATE(fecha) >=', $desde)
            ->where('DATE(fecha) <=', $hasta);

        if ($db->fieldExists('estado', 'venta')) {
            $q->where('estado', 1);
        }

        $rows = $q->groupBy('DATE(fecha)')
            ->orderBy('dia', 'ASC')
            ->get()->getResultArray();

        // formato chartjs
        $labels = [];
        $data   = [];

        foreach ($rows as $r) {
            $labels[] = $r['dia'];
            $data[]   = (float)$r['total'];
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'data'   => $data
        ]);
    }

    public function top_productos_data()
    {
        [$desde, $hasta] = $this->rango_fechas();
        $limit = (int)($this->request->getGet('limit') ?? 10);

        $db = \Config\Database::connect();

        $q = $db->table('detalle_venta dv')
            ->select('p.nombre, SUM(dv.cantidad) as cantidad, SUM(dv.importe) as total')
            ->join('venta v', 'v.idventa = dv.idventa', 'inner')
            ->join('producto p', 'p.idproducto = dv.idproducto', 'inner')
            ->where('DATE(v.fecha) >=', $desde)
            ->where('DATE(v.fecha) <=', $hasta);

        if ($db->fieldExists('estado', 'venta')) {
            $q->where('v.estado', 1);
        }

        $rows = $q->groupBy('dv.idproducto')
            ->orderBy('total', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();

        $labels = [];
        $data   = [];

        foreach ($rows as $r) {
            $labels[] = $r['nombre'];
            $data[]   = (float)$r['total']; // total vendido por producto
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'data'   => $data
        ]);
    }

    public function top_clientes_data()
    {
        [$desde, $hasta] = $this->rango_fechas();
        $limit = (int)($this->request->getGet('limit') ?? 10);

        $db = \Config\Database::connect();

        $q = $db->table('venta v')
            ->select('c.nombre, SUM(v.total) as total')
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

        $labels = [];
        $data   = [];

        foreach ($rows as $r) {
            $labels[] = $r['nombre'];
            $data[]   = (float)$r['total']; // total vendido por cliente
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'data'   => $data
        ]);
    }
}
