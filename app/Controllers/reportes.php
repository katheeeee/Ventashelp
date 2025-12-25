<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class reportes extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // =========================
    // vista principal
    // =========================
    public function index()
    {
        return view('reportes/index', [
            'title' => 'reportes de ventas',
            'active' => 'reportes'
        ]);
    }

    // =========================
    // resumen general
    // =========================
    public function resumen()
    {
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

        return $this->response->setJSON(
            $builder->get()->getRowArray()
        );
    }

    // =========================
    // ventas por dia (grafica)
    // =========================
    public function ventas_diarias()
    {
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

        return $this->response->setJSON(
            $builder->get()->getResultArray()
        );
    }

    // =========================
    // top productos
    // =========================
    public function top_productos()
    {
        return $this->response->setJSON(
            $this->db->table('detalle_venta dv')
                ->select('p.nombre, sum(dv.cantidad) as total_vendido')
                ->join('producto p', 'p.idproducto = dv.idproducto')
                ->join('venta v', 'v.idventa = dv.idventa')
                ->where('v.estado', 1)
                ->groupBy('p.idproducto')
                ->orderBy('total_vendido', 'desc')
                ->limit(10)
                ->get()
                ->getResultArray()
        );
    }

    // =========================
    // top clientes
    // =========================
    public function top_clientes()
    {
        return $this->response->setJSON(
            $this->db->table('venta v')
                ->select('c.nombre, sum(v.total) as total_comprado')
                ->join('cliente c', 'c.idcliente = v.idcliente')
                ->where('v.estado', 1)
                ->groupBy('c.idcliente')
                ->orderBy('total_comprado', 'desc')
                ->limit(10)
                ->get()
                ->getResultArray()
        );
    }
}
