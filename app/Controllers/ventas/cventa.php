<?php

namespace App\Controllers\ventas;

use App\Controllers\BaseController;
use App\Models\mventa;
use App\Models\mdetalle_venta;
use App\Models\mcliente;
use App\Models\mproducto;
use App\Models\mtipo_comprobante;

class cventa extends BaseController
{
    protected $venta;
    protected $detalle;

    public function __construct()
    {
        $this->venta   = new mventa();
        $this->detalle = new mdetalle_venta();
    }

    public function index()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        // listado (cabecera)
        $registros = $this->venta
            ->select('venta.*, cliente.nombre AS cliente, tipo_comprobante.nombre AS comprobante')
            ->join('cliente', 'cliente.idcliente = venta.idcliente')
            ->join('tipo_comprobante', 'tipo_comprobante.idtipo_comprobante = venta.idtipo_comprobante')
            ->orderBy('venta.idventa', 'DESC')
            ->findAll();

        $data = [
            'active'    => 'ventas',
            'subactive' => 'ventas_list',
            'registros' => $registros,
        ];

        return view('admin/venta/vlist', $data);
    }

    public function add()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        // combos
        $data = [
            'active'        => 'ventas',
            'subactive'     => 'ventas_add',
            'clientes'      => (new mcliente())->where('estado', 1)->findAll(),
            'comprobantes'  => (new mtipo_comprobante())->where('estado', 1)->findAll(),
            'productos'     => (new mproducto())
                                ->select('producto.*,
                                         categoria.nombre AS categoria,
                                         marca.nombre AS marca,
                                         color.nombre AS color,
                                         tipo_material.nombre AS tipo_material,
                                         unmedida.nombre AS unmedida')
                                ->join('categoria', 'categoria.idcategoria = producto.idcategoria')
                                ->join('marca', 'marca.idmarca = producto.idmarca')
                                ->join('color', 'color.idcolor = producto.idcolor')
                                ->join('tipo_material', 'tipo_material.idtipo_material = producto.idtipo_material')
                                ->join('unmedida', 'unmedida.idunmedida = producto.idunmedida')
                                ->where('producto.estado', 1)
                                ->findAll(),
        ];

        return view('admin/venta/vadd', $data);
    }

    public function store()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        // arrays del detalle
        $idproducto = $this->request->getPost('idproducto') ?? [];
        $precio     = $this->request->getPost('precio') ?? [];
        $cantidad   = $this->request->getPost('cantidad') ?? [];
        $importe    = $this->request->getPost('importe') ?? [];

        if (count($idproducto) === 0) {
            return redirect()->back()->withInput()->with('error', ['Agrega al menos 1 producto.']);
        }

        $rules = [
            'fecha'             => 'required',
            'serie'             => 'required',
            'idtipo_comprobante'=> 'required|integer',
            'idcliente'         => 'required|integer',
            'descuento'         => 'permit_empty|decimal',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $idCliente = (int)$this->request->getPost('idcliente');
            $cliente   = (new mcliente())->find($idCliente);

            // Si tu venta tiene idtipo_documento NOT NULL, lo llenamos desde cliente
            $idTipoDoc = $cliente['idtipo_documento'] ?? 0;

            // totals (vienen del form)
            $subtotal  = (float)$this->request->getPost('subtotal');
            $igv       = (float)$this->request->getPost('igv');
            $descuento = (float)($this->request->getPost('descuento') ?? 0);
            $total     = (float)$this->request->getPost('total');

            $idUsuario = session('idusuario') ?? session('id') ?? 1;

            $this->venta->insert([
                'fecha'             => $this->request->getPost('fecha'),
                'serie'             => $this->request->getPost('serie'),
                'subtotal'          => $subtotal,
                'igv'               => $igv,
                'descuento'         => $descuento,
                'total'             => $total,
                'estado'            => 1,
                'idtipo_comprobante'=> (int)$this->request->getPost('idtipo_comprobante'),
                'idusuario'         => (int)$idUsuario,
                'idcliente'         => $idCliente,
                'fecharegistro'     => date('Y-m-d H:i:s'),
                'usuarioregistro'   => (int)$idUsuario,
                'idtipo_documento'  => (int)$idTipoDoc,
            ]);

            $idVenta = $this->venta->getInsertID();

            // detalles + descuento de stock
            $prodModel = new mproducto();

            for ($i = 0; $i < count($idproducto); $i++) {
                $pid = (int)$idproducto[$i];
                $pre = (float)$precio[$i];
                $can = (float)$cantidad[$i];
                $imp = (float)$importe[$i];

                $this->detalle->insert([
                    'estado'       => 1,
                    'precio'       => $pre,
                    'cantidad'     => $can,
                    'importe'      => $imp,
                    'idproducto'   => $pid,
                    'idventa'      => $idVenta,
                    'fecharegistro'=> date('Y-m-d H:i:s'),
                ]);

                // baja stock: stock = stock - cantidad
                $prodModel->set('stock', "stock - {$can}", false)
                          ->where('idproducto', $pid)
                          ->update();
            }

            if ($db->transStatus() === false) {
                throw new \Exception('Transacción falló.');
            }

            $db->transCommit();
            return redirect()->to(base_url('ventas'))->with('success', 'Venta registrada con éxito');

        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', [$e->getMessage()]);
        }
    }

    public function view($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $cab = $this->venta
            ->select('venta.*, cliente.nombre AS cliente, tipo_comprobante.nombre AS comprobante')
            ->join('cliente', 'cliente.idcliente = venta.idcliente')
            ->join('tipo_comprobante', 'tipo_comprobante.idtipo_comprobante = venta.idtipo_comprobante')
            ->find($id);

        $det = $this->detalle
            ->select('detalle_venta.*, producto.codigo, producto.nombre, producto.imagen, unmedida.nombre AS unmedida')
            ->join('producto', 'producto.idproducto = detalle_venta.idproducto')
            ->join('unmedida', 'unmedida.idunmedida = producto.idunmedida')
            ->where('detalle_venta.idventa', $id)
            ->findAll();

        $data = [
            'active'    => 'ventas',
            'subactive' => 'ventas_list',
            'cab'       => $cab,
            'det'       => $det,
        ];

        return view('admin/venta/vview', $data);
    }

    public function delete($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        // OJO: esto elimina cabecera; si quieres, primero elimina detalles.
        (new mdetalle_venta())->where('idventa', $id)->delete();
        $this->venta->delete($id);

        return redirect()->to(base_url('ventas'))->with('success', 'Venta eliminada');
    }
}
