<?php

namespace App\Controllers\movimientos;

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
        $this->venta    = new mventa();
        $this->detalle  = new mdetalle_venta();
    }

    public function add()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        // combos
        $tipos_documento = (new mtipo_documento())
            ->select('idtipo_documento, nombre')
            ->where('estado', 1)
            ->findAll();

        $clientes = (new mcliente())
            ->select('idcliente, nombre')
            ->where('estado', 1)
            ->orderBy('nombre', 'ASC')
            ->findAll();

        $productos = (new mproducto())
            ->select('producto.idproducto, producto.codigo, producto.nombre, producto.precio, producto.stock, producto.imagen, unmedida.nombre AS unmedida')
            ->join('unmedida', 'unmedida.idunmedida = producto.idunmedida')
            ->where('producto.estado', 1)
            ->orderBy('producto.nombre', 'ASC')
            ->findAll();

        $data = [
            'active'         => 'ventas',      // para tu aside
            'subactive'      => 'venta_add',    // para marcar "Agregar"
            'tipos_documento'=> $tipos_documento,
            'clientes'       => $clientes,
            'productos'      => $productos,
            'igv_rate'       => 0.18,
        ];

        return view('admin/venta/vadd', $data);
    }

    public function store()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        // ====== VALIDACIÓN BÁSICA ======
        $rules = [
            'fecha'            => 'required',
            'idtipo_documento' => 'required|integer',
            'idcliente'        => 'required|integer',
            'serie'            => 'permit_empty|max_length[30]',
            'num_documento'    => 'permit_empty|max_length[15]',

            // arrays del detalle
            'idproducto'       => 'required',
            'cantidad'         => 'required',
            'precio'           => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        // ====== DETALLE (arrays) ======
        $ids       = (array) $this->request->getPost('idproducto');
        $cantidades= (array) $this->request->getPost('cantidad');
        $precios   = (array) $this->request->getPost('precio');

        if (count($ids) === 0) {
            return redirect()->back()->withInput()->with('error', ['Agrega al menos un producto.']);
        }

        // recalcular en backend (no confiar en JS)
        $subtotal = 0.0;
        $items = [];

        foreach ($ids as $i => $idprod) {
            $idprod = (int)$idprod;
            $cant   = (float)($cantidades[$i] ?? 0);
            $prec   = (float)($precios[$i] ?? 0);

            if ($idprod <= 0 || $cant <= 0 || $prec < 0) continue;

            $importe = $cant * $prec;
            $subtotal += $importe;

            $items[] = [
                'idproducto' => $idprod,
                'cantidad'   => $cant,
                'precio'     => $prec,
                'importe'    => $importe,
            ];
        }

        if (count($items) === 0) {
            return redirect()->back()->withInput()->with('error', ['Detalle inválido.']);
        }

        $igv_rate = 0.18;
        $igv      = round($subtotal * $igv_rate, 2);
        $descuento= (float)($this->request->getPost('descuento') ?? 0);
        if ($descuento < 0) $descuento = 0;

        $total    = round(($subtotal + $igv) - $descuento, 2);

        // ====== INSERT CABECERA ======
        $fecha = $this->request->getPost('fecha'); // si guardas como varchar(20) ok

        $idventa = $this->venta->insert([
            'fecha'            => $fecha,
            'subtotal'         => round($subtotal, 2),
            'igv'              => $igv,
            'descuento'        => round($descuento, 2),
            'total'            => $total,
            'estado'           => 1,
            'serie'            => $this->request->getPost('serie'),
            'num_documento'    => $this->request->getPost('num_documento'),
            'idtipo_documento' => (int)$this->request->getPost('idtipo_documento'),
            'idcliente'        => (int)$this->request->getPost('idcliente'),
            'idusuario'        => (int)(session('idusuario') ?? 1),
            'fecharegistro'    => date('Y-m-d H:i:s'),
            'usuarioregistro'  => (int)(session('idusuario') ?? 1),
        ], true);

        // ====== INSERT DETALLE ======
        foreach ($items as $it) {
            $this->detalle->insert([
                'idventa'       => $idventa,
                'idproducto'    => $it['idproducto'],
                'precio'        => $it['precio'],
                'cantidad'      => $it['cantidad'],
                'importe'       => round($it['importe'], 2),
                'estado'        => 1,
                'fecharegistro' => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to(base_url('ventas/add'))
            ->with('success', 'Venta registrada correctamente.');
    }
}
