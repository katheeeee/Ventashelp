<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;
use App\Models\mproveedor;
use App\Models\mtipo_documento;
use App\Models\mtipo_cliente;

class cproveedor extends BaseController
{
    protected $proveedor;

    public function __construct()
    {
        $this->proveedor = new mproveedor();
    }

    public function index()
{
    $data = [
        'active'    => 'mantenimiento',
        'subactive' => 'proveedor',
        'registros' => $this->proveedor->listarConTipos()
    ];

    return view('admin/proveedor/vlist', $data);
}


    public function add()
{
    if (!session()->get('login')) {
        return redirect()->to(base_url('login'));
    }

    $mTipoDocumento = new \App\Models\mtipo_documento();
    $mTipoCliente   = new \App\Models\mtipo_cliente();

    $data = [
        'active'           => 'mantenimiento',
        'subactive'        => 'proveedor',
        'tipos_documento'  => $mTipoDocumento->findAll(),
        'tipos_cliente'    => $mTipoCliente->findAll(),
    ];

    return view('admin/proveedor/vadd', $data);
}


    public function store()
    {
        $this->proveedor->insert([
            'codigo'          => $this->request->getPost('codigo'),
            'nombre'          => $this->request->getPost('nombre'),
            'direccion'       => $this->request->getPost('direccion'),
            'telefono'        => $this->request->getPost('telefono'),
            'idtipo_documeto' => $this->request->getPost('idtipo_documeto'),
            'idtipo_cliente'  => $this->request->getPost('idtipo_cliente'),
            'estado'          => 1,
        ]);

        return redirect()->to(base_url('mantenimiento/proveedor'))
            ->with('success', 'Proveedor registrado');
    }

   public function edit($id)
{
    if (!session()->get('login')) {
        return redirect()->to(base_url('login'));
    }

    $data = [
        'active'          => 'mantenimiento',
        'subactive'       => 'proveedor',

        // registro
        'proveedor'       => $this->proveedor->find($id),

        // combos
        'tipos_documento' => (new \App\Models\mtipo_documento())->findAll(),
        'tipos_cliente'   => (new \App\Models\mtipo_cliente())->findAll(),
    ];

    return view('admin/proveedor/vedit', $data);
}


    public function update($id)
    {
        $this->proveedor->update($id, [
            'codigo'          => $this->request->getPost('codigo'),
            'nombre'          => $this->request->getPost('nombre'),
            'direccion'       => $this->request->getPost('direccion'),
            'telefono'        => $this->request->getPost('telefono'),
            'idtipo_documeto' => $this->request->getPost('idtipo_documeto'),
            'idtipo_cliente'  => $this->request->getPost('idtipo_cliente'),
            'estado'          => $this->request->getPost('estado'),
        ]);

        return redirect()->to(base_url('mantenimiento/proveedor'))
            ->with('success', 'Proveedor actualizado');
    }

    public function view($id)
{
    if (!session()->get('login')) {
        return redirect()->to(base_url('login'));
    }

    $proveedor = $this->proveedor
        ->select('proveedor.*,
                  tipo_documento.nombre AS tipo_documento,
                  tipo_cliente.nombre AS tipo_cliente')
        ->join('tipo_documento', 'tipo_documento.idtipo_documento = proveedor.idtipo_documeto')
        ->join('tipo_cliente', 'tipo_cliente.idtipo_cliente = proveedor.idtipo_cliente')
        ->find($id);

    $data = [
        'active'    => 'mantenimiento',
        'subactive' => 'proveedor',
        'proveedor' => $proveedor
    ];

    return view('admin/proveedor/vview', $data);
}


    public function delete($id)
    {
        $this->proveedor->delete($id);
        return redirect()->to(base_url('mantenimiento/proveedor'));
    }
}
