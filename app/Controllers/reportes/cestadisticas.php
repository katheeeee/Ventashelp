<?php

namespace App\Controllers\reportes;

use App\Controllers\BaseController;

class cestadisticas extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function resumen()
    {
        if (!session()->get('login')) return $this->response->setStatusCode(403);

        $desde = $this->request->getGet('desde');
        $hasta = $this->request->getGet('hasta');

        $builder = $this->db->table('venta')
            ->select('
                count(idventa) as total_ventas,
                sum(total) as total_vendido,
                sum(igv) as total_igv,
                avg(total) as ticket_promedio
            ')
            ->where('estado', 1);

        if ($desde && $hasta) {
            $builder->where('date(fecha) >=', $desde)
                    ->where('date(fecha) <=', $hasta);
        }

        return $this->response->setJSON($builder->get()->getRowArray());
    }

    public function ventas_diarias()
    {
        if (!session()->get('login')) return $this->response->setStatusCode(403);

        $desde = $this->request->getGet('desde');
        $hasta = $this->request->getGet('hasta');

        $builder = $this->db->table('venta')
            ->select('date(fecha) as fecha, sum(total) as total')
            ->where('estado', 1)
            ->groupBy('date(fecha)')
            ->orderBy('fecha', 'asc');

        if ($desde && $hasta) {
            $builder->where('date(fecha) >=', $desde)
                    ->where('date(fecha) <=', $hasta);
        }

        return $this->response->setJSON($builder->get()->getResultArray());
    }

    public function top_productos()
    {
        if (!session()->get('login')) return $this->response->setStatusCode(403);

        $desde = $this->request->getGet('desde');
        $hasta = $this->request->getGet('hasta');

        $builder = $this->db->table('detalle_venta dv')
            ->select('p.nombre, sum(dv.cantidad) as total_vendido')
            ->join('producto p', 'p.idproducto = dv.idproducto')
            ->join('venta v', 'v.idventa = dv.idventa')
            ->where('v.estado', 1)
            ->groupBy('p.idproducto')
            ->orderBy('total_vendido', 'desc')
            ->limit(10);

        if ($desde && $hasta) {
            $builder->where('date(v.fecha) >=', $desde)
                    ->where('date(v.fecha) <=', $hasta);
        }

        return $this->response->setJSON($builder->get()->getResultArray());
    }

    public function top_clientes()
    {
        if (!session()->get('login')) return $this->response->setStatusCode(403);

        $desde = $this->request->getGet('desde');
        $hasta = $this->request->getGet('hasta');

        $builder = $this->db->table('venta v')
            ->select('c.nombre, sum(v.total) as total_comprado')
            ->join('cliente c', 'c.idcliente = v.idcliente')
            ->where('v.estado', 1)
            ->groupBy('c.idcliente')
            ->orderBy('total_comprado', 'desc')
            ->limit(10);

        if ($desde && $hasta) {
            $builder->where('date(v.fecha) >=', $desde)
                    ->where('date(v.fecha) <=', $hasta);
        }

        return $this->response->setJSON($builder->get()->getResultArray());
    }
}
