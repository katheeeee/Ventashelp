<?php

namespace App\Controllers\ventas;

use App\Controllers\BaseController;
use App\Models\mventa;
use App\Models\mdetalle_venta;
use App\Models\mcliente;
use App\Models\mproducto;
use App\Models\mtipo_documento;

class cventa extends BaseController
{
    protected $venta;
    protected $detalle;

    public function __construct()
    {
        $this->venta   = new mventa();
        $this->detalle = new mdetalle_venta();
    }

    // =========================
    // NUEVA VENTA
    // =========================
    public function add()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'active'         => 'ventas',
            'subactive'      => 'venta_add',
            'tipos_documento'=> (new mtipo_documento())->where('estado',1)->findAll(),
            'clientes'       => (new mcliente())->where('estado',1)->findAll(),
            'productos'      => (new mproducto())
                                ->select('producto.*, unmedida.nombre AS unmedida')
                                ->join('unmedida','unmedida.idunmedida = producto.idunmedida')
                                ->where('producto.estado',1)
                                ->findAll(),
        ];

        return view('admin/venta/vadd', $data);
    }

    // =========================
    // GUARDAR VENTA
    // =========================
    public function store()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $ids       = $this->request->getPost('idproducto');
        $cantidades= $this->request->getPost('cantidad');
        $precios   = $this->request->getPost('precio');

        if (!$ids) {
            return redirect()->back()->with('error', ['Debe agregar productos']);
        }

        // ====== CALCULAR TOTALES ======
        $subtotal = 0;
        foreach ($ids as $i => $idp) {
            $subtotal += $cantidades[$i] * $precios[$i];
        }

        $igv   = round($subtotal * 0.18, 2);
        $total = round($subtotal + $igv, 2);

        // ====== INSERT CABECERA ======
        $idventa = $this->venta->insert([
            'fecha'            => $this->request->getPost('fecha'),
            'serie'            => $this->request->getPost('serie'),
            'num_documento'    => $this->request->getPost('num_documento'),
            'idtipo_documento' => $this->request->getPost('idtipo_documento'),
            'idcliente'        => $this->request->getPost('idcliente'),
            'subtotal'         => $subtotal,
            'igv'              => $igv,
            'total'            => $total,
            'estado'           => 1,
            'idusuario'        => session('idusuario'),
            'fecharegistro'    => date('Y-m-d H:i:s'),
            'usuarioregistro'  => session('idusuario'),
        ], true);

        // ====== INSERT DETALLE ======
        foreach ($ids as $i => $idp) {
            $this->detalle->insert([
                'idventa'   => $idventa,
                'idproducto'=> $idp,
                'precio'    => $precios[$i],
                'cantidad'  => $cantidades[$i],
                'importe'   => $cantidades[$i] * $precios[$i],
                'estado'    => 1,
            ]);
        }

        return redirect()->to(base_url('ventas/add'))
            ->with('success', 'Venta registrada correctamente');
    }
}
