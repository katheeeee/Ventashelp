<?php

namespace App\Controllers\reportes;

use App\Controllers\BaseController;

class creportesdata extends BaseController
{
    // =====================================================
    // RESUMEN (KPIs + DONUT POR COMPROBANTE)
    // =====================================================
    public function resumen_data()
    {
        if (!session()->get('login')) {
            return $this->response->setStatusCode(403);
        }

        $desde = $this->request->getGet('desde') ?? date('Y-m-01');
        $hasta = $this->request->getGet('hasta') ?? date('Y-m-d');

        $db = \Config\Database::connect();

        $usaEstado = $db->fieldExists('estado', 'venta');

        // -----------------------------
        // KPIs
        // -----------------------------
        $qVentas = $db->table('venta')
            ->where('DATE(fecha) >=', $desde)
            ->where('DATE(fecha) <=', $hasta);

        if ($usaEstado) {
            $qVentas->where('estado', 1);
        }

        $ventas = $qVentas->countAllResults(false);

        $rowTotal = $qVentas->selectSum('total')->get()->getRowArray();
        $total = (float)($rowTotal['total'] ?? 0);

        $qClientes = $db->table('venta')
            ->select('idcliente')
            ->where('DATE(fecha) >=', $desde)
            ->where('DATE(fecha) <=', $hasta);

        if ($usaEstado) {
            $qClientes->where('estado', 1);
        }

        $clientes = $qClientes->groupBy('idcliente')->countAllResults(false);

        $qProductos = $db->table('detalle_venta dv')
            ->select('dv.idproducto')
            ->join('venta v', 'v.idventa = dv.idventa', 'inner')
            ->where('DATE(v.fecha) >=', $desde)
            ->where('DATE(v.fecha) <=', $hasta);

        if ($usaEstado) {
            $qProductos->where('v.estado', 1);
        }

        $productos = $qProductos->groupBy('dv.idproducto')->countAllResults(false);

        // -----------------------------
        // DONUT: ventas por comprobante
        // -----------------------------
        $qComp = $db->table('venta v')
            ->select('tc.nombre as nombre, SUM(v.total) as total')
            ->join(
                'tipo_comprobante tc',
                'tc.idtipo_comprobante = v.idtipo_comprobante',
                'left'
            )
            ->where('DATE(v.fecha) >=', $desde)
            ->where('DATE(v.fecha) <=', $hasta);

        if ($usaEstado) {
            $qComp->where('v.estado', 1);
        }

        $por_comprobante = $qComp
            ->groupBy('v.idtipo_comprobante')
            ->orderBy('total', 'DESC')
            ->get()->getResultArray();

        foreach ($por_comprobante as &$x) {
            $x['nombre'] = $x['nombre'] ?: 'sin tipo';
            $x['total']  = (float)($x['total'] ?? 0);
        }

        return $this->response->setJSON([
            'kpis' => [
                'ventas'    => (int)$ventas,
                'total'     => $total,
                'clientes'  => (int)$clientes,
                'productos' => (int)$productos,
            ],
            'por_comprobante' => $por_comprobante
        ]);
    }

    // =====================================================
    // VENTAS DIARIAS (BARRAS)
    // =====================================================
    public function ventas_diarias_data()
    {
        if (!session()->get('login')) {
            return $this->response->setStatusCode(403);
        }

        $desde = $this->request->getGet('desde') ?? date('Y-m-01');
        $hasta = $this->request->getGet('hasta') ?? date('Y-m-d');

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

        return $this->response->setJSON($rows);
    }

    // =====================================================
    // TOP PRODUCTOS
    // =====================================================
    public function top_productos_data()
    {
        if (!session()->get('login')) {
            return $this->response->setStatusCode(403);
        }

        $desde = $this->request->getGet('desde') ?? date('Y-m-01');
        $hasta = $this->request->getGet('hasta') ?? date('Y-m-d');

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
            ->limit(10)
            ->get()->getResultArray();

        return $this->response->setJSON($rows);
    }

    // =====================================================
    // TOP CLIENTES
    // =====================================================
    public function top_clientes_data()
    {
        if (!session()->get('login')) {
            return $this->response->setStatusCode(403);
        }

        $desde = $this->request->getGet('desde') ?? date('Y-m-01');
        $hasta = $this->request->getGet('hasta') ?? date('Y-m-d');

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
            ->limit(10)
            ->get()->getResultArray();

        return $this->response->setJSON($rows);
    }
}
