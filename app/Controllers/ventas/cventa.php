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
            ->join('cliente', 'cliente.idcliente = venta.idcliente', 'left')
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

        $tipos = (new mtipo_documento())
            ->where('estado', 1)
            ->orderBy('nombre', 'ASC')
            ->findAll();

        return view('admin/venta/vadd', [
            'active'          => 'ventas',
            'subactive'       => 'venta_add',
            'tipos_documento' => $tipos,
        ]);
    }

    // ✅ AJAX Clientes
    public function ajaxClientes()
    {
        if (!session()->get('login')) return $this->response->setStatusCode(403);

        $q = trim($this->request->getGet('q') ?? '');

        $builder = $this->cliente->select('idcliente, codigo, nombre');

        if ($q !== '') {
            $builder->groupStart()
                ->like('nombre', $q)
                ->orLike('codigo', $q)
                ->groupEnd();
        }

        if ($this->cliente->db->fieldExists('estado', 'cliente')) {
            $builder->where('estado', 1);
        }

        $data = $builder->orderBy('nombre', 'ASC')->findAll(50);

        return $this->response->setJSON($data);
    }

    // ✅ AJAX Productos
    public function ajaxProductos()
    {
        if (!session()->get('login')) return $this->response->setStatusCode(403);

        $q = trim($this->request->getGet('q') ?? '');

        $builder = $this->producto
            ->select('producto.idproducto, producto.codigo, producto.nombre, producto.imagen, producto.precio, producto.stock,
                      unmedida.nombre as unmedida')
            ->join('unmedida', 'unmedida.idunmedida = producto.idunmedida', 'left'); // ✅ left

        if ($q !== '') {
            $builder->groupStart()
                ->like('producto.nombre', $q)
                ->orLike('producto.codigo', $q)
                ->groupEnd();
        }

        if ($this->producto->db->fieldExists('estado', 'producto')) {
            $builder->where('producto.estado', 1);
        }

        $data = $builder->orderBy('producto.nombre', 'ASC')->findAll(100);

        foreach ($data as &$r) {
            $r['imagen']  = $r['imagen'] ?: 'no.jpg';
            $r['img_url'] = base_url('uploads/productos/' . $r['imagen']);
        }

        return $this->response->setJSON($data);
    }

    public function store()
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        $idUsuario = session('idusuario') ?? 1;

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

        $items = json_decode($this->request->getPost('items') ?? '[]', true);

        if (!is_array($items) || count($items) === 0) {
            return redirect()->back()->withInput()->with('error', ['Debes agregar al menos 1 producto.']);
        }

        // ✅ fecha input type="date" -> YYYY-MM-DD
        // la guardamos como DATETIME: YYYY-MM-DD 00:00:00
        $fecha = $this->request->getPost('fecha');
        $fecha = $fecha ? ($fecha . ' 00:00:00') : date('Y-m-d H:i:s');

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $idventa = $this->venta->insert([
                'fecha'            => $fecha,
                'subtotal'         => (float)$this->request->getPost('subtotal'),
                'igv'              => (float)$this->request->getPost('igv'),
                'descuento'        => (float)($this->request->getPost('descuento') ?? 0),
                'total'            => (float)$this->request->getPost('total'),
                'serie'            => $this->request->getPost('serie'),
                'num_documento'    => $this->request->getPost('num_documento'),
                'idtipo_documento' => (int)$this->request->getPost('idtipo_documento'),
                'idcliente'        => (int)$this->request->getPost('idcliente'),
                'idusuario'        => (int)$idUsuario,
                'estado'           => 1,
                // si ya tienes DEFAULT CURRENT_TIMESTAMP en DB, esto es opcional:
                'fecharegistro'    => date('Y-m-d H:i:s'),
                'usuarioregistro'  => (int)$idUsuario,
            ], true);

            if (!$idventa) {
                throw new \Exception('No se pudo registrar la cabecera de la venta.');
            }

            foreach ($items as $it) {
                $idproducto = (int)($it['idproducto'] ?? 0);
                $precio     = (float)($it['precio'] ?? 0);
                $cantidad   = (int)($it['cantidad'] ?? 0);

                if ($idproducto <= 0 || $cantidad <= 0) {
                    continue;
                }

                $p = $this->producto->find($idproducto);
                if (!$p) {
                    throw new \Exception("Producto no existe (ID: {$idproducto}).");
                }

                if ((int)$p['stock'] < $cantidad) {
                    throw new \Exception("Stock insuficiente para {$p['nombre']} (Stock: {$p['stock']}).");
                }

                $importe = round($precio * $cantidad, 2);

                $okDet = $this->detalle->insert([
                    'estado'        => 1,
                    'precio'        => $precio,
                    'cantidad'      => $cantidad,
                    'importe'       => $importe,
                    'idproducto'    => $idproducto,
                    'idventa'       => $idventa,
                    'fecharegistro' => date('Y-m-d H:i:s'),
                ]);

                if (!$okDet) {
                    throw new \Exception("No se pudo guardar el detalle del producto: {$p['nombre']}");
                }

                // ✅ bajar stock
                $nuevoStock = (int)$p['stock'] - $cantidad;
                $this->producto->update($idproducto, ['stock' => $nuevoStock]);
            }

            if ($db->transStatus() === false) {
                throw new \Exception('Error en la transacción.');
            }

            $db->transCommit();

            return redirect()->to(base_url('ventas'))
                ->with('success', 'Venta registrada correctamente');

        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()
                ->with('error', ['Error: ' . $e->getMessage()]);
        }
    }

    public function view($id)
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        $cab = $this->venta
            ->select('venta.*, cliente.nombre as cliente, tipo_documento.nombre as tipo_documento')
            ->join('cliente', 'cliente.idcliente = venta.idcliente', 'left')
            ->join('tipo_documento', 'tipo_documento.idtipo_documento = venta.idtipo_documento', 'left')
            ->find($id);

        $det = $this->detalle
            ->select('detalle_venta.*, producto.codigo, producto.nombre, producto.imagen')
            ->join('producto', 'producto.idproducto = detalle_venta.idproducto', 'left')
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
