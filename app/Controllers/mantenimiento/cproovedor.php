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
            'active'     => 'mantenimiento',
            'subactive'  => 'proveedor',
            'registros'  => $this->proveedor->findAll()
        ];

        return view('admin/proveedor/vlist', $data);
    }

    public function add()
    {
        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'proveedor',
            'tipos_doc' => (new mtipo_documento())->findAll(),
            'tipos_cli' => (new mtipo_cliente())->findAll(),
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
        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'proveedor',
            'p'         => $this->proveedor->find($id),
            'tipos_doc' => (new mtipo_documento())->findAll(),
            'tipos_cli' => (new mtipo_cliente())->findAll(),
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
        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'proveedor',
            'p'         => $this->proveedor->find($id),
        ];

        return view('admin/proveedor/vview', $data);
    }

    public function delete($id)
    {
        $this->proveedor->delete($id);
        return redirect()->to(base_url('mantenimiento/proveedor'));
    }
}
