<?php

namespace App\Controllers;

use App\Models\Mventa;
use App\Models\MdetalleVenta;
use App\Models\Mproducto;
use App\Models\Mcliente;

class Home extends BaseController
{
    public function index()
    {
        $dias = 15;

        // Ajusta si tus modelos se llaman distinto:
        $ventaModel    = new Mventa();
        $detalleModel  = new MdetalleVenta();
        $productoModel = new Mproducto();
        $clienteModel  = new Mcliente();

        // FECHAS
        $hoyInicio = date('Y-m-d 00:00:00');
        $hoyFin    = date('Y-m-d 23:59:59');

        $mesInicio = date('Y-m-01 00:00:00');
        $mesFin    = date('Y-m-t 23:59:59');

        $inicioRango = date('Y-m-d 00:00:00', strtotime("-" . ($dias - 1) . " days"));
        $finRango    = $hoyFin;

        // KPIs (asumo venta.total y venta.estado=1)
        $ventasHoy = (int)$ventaModel->where('estado', 1)
            ->where('fecha >=', $hoyInicio)
            ->where('fecha <=', $hoyFin)
            ->countAllResults();

        $ingresosHoy = (float)($ventaModel->select('COALESCE(SUM(total),0) as s')
            ->where('estado', 1)
            ->where('fecha >=', $hoyInicio)
            ->where('fecha <=', $hoyFin)
            ->get()->getRow()->s ?? 0);

        $ventasMes = (int)$ventaModel->where('estado', 1)
            ->where('fecha >=', $mesInicio)
            ->where('fecha <=', $mesFin)
            ->countAllResults();

        $ingresosMes = (float)($ventaModel->select('COALESCE(SUM(total),0) as s')
            ->where('estado', 1)
            ->where('fecha >=', $mesInicio)
            ->where('fecha <=', $mesFin)
            ->get()->getRow()->s ?? 0);

        $clientesActivos  = (int)$clienteModel->where('estado', 1)->countAllResults();
        $productosActivos = (int)$productoModel->where('estado', 1)->countAllResults();

        // GRAFICA: ventas por día (últimos N días)
        $rows = $ventaModel->select("DATE(fecha) as dia, COUNT(*) as cant, COALESCE(SUM(total),0) as total")
            ->where('estado', 1)
            ->where('fecha >=', $inicioRango)
            ->where('fecha <=', $finRango)
            ->groupBy('DATE(fecha)')
            ->orderBy('dia', 'ASC')
            ->findAll();

        $map = [];
        foreach ($rows as $r) $map[$r['dia']] = $r;

        $chartLabels = [];
        $chartCantidad = [];
        $chartTotal = [];

        for ($i = $dias - 1; $i >= 0; $i--) {
            $d = date('Y-m-d', strtotime("-$i days"));
            $chartLabels[] = date('d/m', strtotime($d));
            $chartCantidad[] = isset($map[$d]) ? (int)$map[$d]['cant'] : 0;
            $chartTotal[] = isset($map[$d]) ? (float)$map[$d]['total'] : 0;
        }

        // TOP PRODUCTOS (si detalle_venta tiene cantidad e importe)
        $topProductos = $detalleModel
            ->select("producto.nombre, SUM(detalle_venta.cantidad) as cantidad, COALESCE(SUM(detalle_venta.importe),0) as importe")
            ->join('venta', 'venta.idventa = detalle_venta.idventa')
            ->join('producto', 'producto.idproducto = detalle_venta.idproducto')
            ->where('venta.estado', 1)
            ->where('venta.fecha >=', $inicioRango)
            ->where('venta.fecha <=', $finRango)
            ->groupBy('producto.nombre')
            ->orderBy('cantidad', 'DESC')
            ->limit(5)
            ->findAll();

        // STOCK BAJO
        $stockMin = 5;
        $stockBajo = $productoModel
            ->select('idproducto, nombre, stock')
            ->where('estado', 1)
            ->where('stock <=', $stockMin)
            ->orderBy('stock', 'ASC')
            ->limit(8)
            ->findAll();

        return view('admin/dashboard', [
            'title'       => 'Helpnet',
            'active'      => 'dashboard',
            'pageTitle'   => 'Dashboard',
            'pageSub'     => 'Panel principal',

            'dias' => $dias,

            'ventasHoy' => $ventasHoy,
            'ingresosHoy' => $ingresosHoy,
            'ventasMes' => $ventasMes,
            'ingresosMes' => $ingresosMes,

            'clientesActivos' => $clientesActivos,
            'productosActivos' => $productosActivos,

            'chartLabels' => $chartLabels,
            'chartCantidad' => $chartCantidad,
            'chartTotal' => $chartTotal,

            'topProductos' => $topProductos,
            'stockBajo' => $stockBajo,
            'stockMin' => $stockMin,
        ]);
    }
}
