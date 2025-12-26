<?php

namespace App\Controllers\reportes;

use App\Controllers\BaseController;

class creportesdata extends BaseController
{
    private function solo_logueado()
    {
        if (!session()->get('login')) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'no autorizado']);
        }
        return null;
    }

    public function ventas_diarias_data()
    {
        if ($r = $this->solo_logueado()) return $r;

        $desde = $this->request->getGet('desde') ?? date('Y-m-01');
        $hasta = $this->request->getGet('hasta') ?? date('Y-m-d');

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

        // formato para chart
        $labels = [];
        $totales = [];

        foreach ($rows as $r) {
            $labels[]  = $r['dia'];
            $totales[] = (float)$r['total'];
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'data'   => $totales
        ]);
    }

    public function top_productos_data()
    {
        if ($r = $this->solo_logueado()) return $r;

        $desde = $this->request->getGet('desde') ?? date('Y-m-01');
        $hasta = $this->request->getGet('hasta') ?? date('Y-m-d');
        $limit = (int)($this->request->getGet('limit') ?? 10);

        $db = \Config\Database::connect();

        $q = $db->table('detalle_venta dv')
            ->select('p.nombre, SUM(dv.cantidad) as cantidad')
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

        $labels = [];
        $data = [];

        foreach ($rows as $r) {
            $labels[] = $r['nombre'];
            $data[]   = (float)$r['cantidad'];
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'data'   => $data
        ]);
    }

    public function top_clientes_data()
    {
        if ($r = $this->solo_logueado()) return $r;

        $desde = $this->request->getGet('desde') ?? date('Y-m-01');
        $hasta = $this->request->getGet('hasta') ?? date('Y-m-d');
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
        $data = [];

        foreach ($rows as $r) {
            $labels[] = $r['nombre'];
            $data[]   = (float)$r['total'];
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'data'   => $data
        ]);
    }
}
