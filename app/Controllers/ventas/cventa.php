<?php

namespace App\Controllers\ventas;

use App\Controllers\BaseController;
use App\Models\mventa;
use App\Models\mdetalle_venta;
use App\Models\mproducto;
use App\Models\mcliente;
use App\Models\mtipo_documento;

class cventa extends BaseController
{
    protected $venta;
    protected $detalle;
    protected $producto;
    protected $cliente;

    public function __construct()
    {
        $this->venta     = new mventa();
        $this->detalle   = new mdetalle_venta();
        $this->producto  = new mproducto();
        $this->cliente   = new mcliente();
    }

    public function index()
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        $registros = $this->venta
            ->select('venta.*, cliente.nombre as cliente')
            ->join('cliente', 'cliente.idcliente = venta.idcliente')
            ->orderBy('venta.idventa', 'DESC')
            ->findAll();

        return view('admin/venta/vlist', [
            'active'    => 'ventas',
            'subactive' => 'venta_list',
            'registros' => $registros,
        ]);
    }

    public function add()
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        // ✅ Usamos tipo_documento como "comprobante"
        $tipos = (new mtipo_documento())->findAll();

        return view('admin/venta/vadd', [
            'active'          => 'ventas',
            'subactive'       => 'venta_add',
            'tipos_documento' => $tipos,
        ]);
    }

    // ✅ AJAX: lista productos (para el modal)
    public function ajaxProductos()
    {
        if (!session()->get('login')) return $this->response->setStatusCode(403);

        $q = trim($this->request->getGet('q') ?? '');

        $data = $this->producto
            ->select('producto.idproducto, producto.codigo, producto.nombre, producto.imagen, producto.precio, producto.stock,
                      unmedida.nombre as unmedida')
            ->join('unmedida', 'unmedida.idunmedida = producto.idunmedida')
            ->like('producto.nombre', $q)
            ->orLike('producto.codigo', $q)
            ->findAll(200);

        // imagen default
        foreach ($data as &$r) {
            $r['imagen'] = (!empty($r['imagen'])) ? $r['imagen'] : 'no.jpg';
            $r['img_url'] = base_url('uploads/productos/' . $r['imagen']);
        }

        return $this->response->setJSON($data);
    }

    // ✅ AJAX: lista clientes (para el select buscable)
    public function ajaxClientes()
    {
        if (!session()->get('login')) return $this->response->setStatusCode(403);

        $q = trim($this->request->getGet('q') ?? '');

        $data = $this->cliente
            ->select('idcliente, nombre, codigo')
            ->like('nombre', $q)
            ->orLike('codigo', $q)
            ->findAll(200);

        return $this->response->setJSON($data);
    }

    public function store()
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        // ✅ OJO: tú dijiste que tu llave usuario es idtipo_usuario (o similar).
        // Aquí yo usaré lo que tengas guardado en sesión.
        // Cambia 'idtipo_usuario' por tu sesión real.
        $idUsuario = session('idtipo_usuario') ?? session('idusuario') ?? null;

        $rules = [
            'idtipo_documento' => 'required|integer',
            'serie'            => 'required',
            'num_documento'    => 'required',
            'fecha'            => 'required',
            'idcliente'        => 'required|integer',
            'subtotal'         => 'required',
            'igv'              => 'required',
            'total'            => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $items = $this->request->getPost('items'); // JSON string
        $items = json_decode($items, true);

        if (!is_array($items) || count($items) === 0) {
            return redirect()->back()->withInput()->with('error', ['Debes agregar al menos 1 producto.']);
        }

        // ✅ Insert cabecera venta
        $idventa = $this->venta->insert([
            'fecha'           => $this->request->getPost('fecha'),
            'subtotal'        => $this->request->getPost('subtotal'),
            'igv'             => $this->request->getPost('igv'),
            'descuento'       => $this->request->getPost('descuento') ?? 0,
            'total'           => $this->request->getPost('total'),
            'serie'           => $this->request->getPost('serie'),
            'num_documento'   => $this->request->getPost('num_documento'),
            'idtipo_documento'=> $this->request->getPost('idtipo_documento'),
            'idcliente'       => $this->request->getPost('idcliente'),
            'idusuario'       => $idUsuario ?? 1, // si tu DB NO permite null
            'estado'          => 1,
            'fecharegistro'   => date('Y-m-d H:i:s'),
            'usuarioregistro' => $idUsuario ?? 1,
        ], true);

        // ✅ Insert detalle + actualizar stock
        foreach ($items as $it) {
            $idproducto = (int)$it['idproducto'];
            $precio     = (float)$it['precio'];
            $cantidad   = (float)$it['cantidad'];
            $importe    = (float)$it['importe'];

            $this->detalle->insert([
                'estado'       => 1,
                'precio'       => $precio,
                'cantidad'     => $cantidad,
                'importe'      => $importe,
                'idproducto'   => $idproducto,
                'idventa'      => $idventa,
                'fecharegistro'=> date('Y-m-d H:i:s'),
            ]);

            // bajar stock
            $p = $this->producto->find($idproducto);
            if ($p) {
                $nuevoStock = (int)$p['stock'] - (int)$cantidad;
                if ($nuevoStock < 0) $nuevoStock = 0;
                $this->producto->update($idproducto, ['stock' => $nuevoStock]);
            }
        }

        return redirect()->to(base_url('ventas'))
            ->with('success', 'Venta registrada correctamente');
    }

    public function view($id)
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        $cab = $this->venta
            ->select('venta.*, cliente.nombre as cliente, tipo_documento.nombre as tipo_documento')
            ->join('cliente', 'cliente.idcliente = venta.idcliente')
            ->join('tipo_documento', 'tipo_documento.idtipo_documento = venta.idtipo_documento')
            ->find($id);

        $det = $this->detalle
            ->select('detalle_venta.*, producto.codigo, producto.nombre, producto.imagen')
            ->join('producto', 'producto.idproducto = detalle_venta.idproducto')
            ->where('detalle_venta.idventa', $id)
            ->findAll();

        return view('admin/venta/vview', [
            'active'    => 'ventas',
            'subactive' => 'venta_list',
            'cab'       => $cab,
            'det'       => $det,
        ]);
    }
}
