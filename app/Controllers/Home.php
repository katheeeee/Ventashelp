<?php

namespace App\Controllers;

use App\Models\mventa;
use App\Models\mdetalle_venta;
use App\Models\mproducto;
use App\Models\mcliente;

class Home extends BaseController
{
    public function index()
    {
        $dias = 15;

        $ventaModel    = new mventa();
        $detalleModel  = new mdetalle_venta();
        $productoModel = new mproducto();
        $clienteModel  = new mcliente();

        // =========================
        // FECHAS
        // =========================
        $hoyInicio = date('Y-m-d 00:00:00');
        $hoyFin    = date('Y-m-d 23:59:59');

        $mesInicio = date('Y-m-01 00:00:00');
        $mesFin    = date('Y-m-t 23:59:59');

        $inicioRango = date('Y-m-d 00:00:00', strtotime("-" . ($dias - 1) . " days"));
        $finRango    = $hoyFin;

        // =========================
        // KPIs
        // =========================
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

        // =========================
        // GRÁFICA: ventas por día (últimos N días)
        // =========================
        $rows = $ventaModel->select("DATE(fecha) as dia, COUNT(*) as cant, COALESCE(SUM(total),0) as total")
            ->where('estado', 1)
            ->where('fecha >=', $inicioRango)
            ->where('fecha <=', $finRango)
            ->groupBy('DATE(fecha)')
            ->orderBy('dia', 'ASC')
            ->findAll();

        // rellenar días sin ventas con 0 (para la gráfica)
        $map = [];
        foreach ($rows as $r) $map[$r['dia']] = $r;

        $chartLabels   = [];
        $chartCantidad = [];
        $chartTotal    = [];

        for ($i = $dias - 1; $i >= 0; $i--) {
            $d = date('Y-m-d', strtotime("-$i days"));
            $chartLabels[] = date('d/m', strtotime($d));

            $chartCantidad[] = isset($map[$d]) ? (int)$map[$d]['cant'] : 0;
            $chartTotal[]    = isset($map[$d]) ? (float)$map[$d]['total'] : 0;
        }

        // =========================
        // TOP PRODUCTOS (por cantidad) en el rango
        // =========================
        $topProductos = $detalleModel
            ->select("p.nombre, SUM(d.cantidad) as cantidad, COALESCE(SUM(d.importe),0) as importe")
            ->from('detalle_venta d')
            ->join('venta v', 'v.idventa = d.idventa')
            ->join('producto p', 'p.idproducto = d.idproducto')
            ->where('v.estado', 1)
            ->where('v.fecha >=', $inicioRango)
            ->where('v.fecha <=', $finRango)
            ->groupBy('p.nombre')
            ->orderBy('cantidad', 'DESC')
            ->limit(5)
            ->findAll();

        // =========================
        // STOCK BAJO
        // =========================
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
