<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;
use App\Models\mcliente;
use App\Models\mtipo_documento;
use App\Models\mtipo_cliente;

class ccliente extends BaseController
{
public function index()
{
    $model = new \App\Models\mcliente();

    $data = [
        'active'    => 'mantenimiento',
        'subactive' => 'cliente',
        'clientes'  => $model->listarConTipos()
    ];

    return view('admin/cliente/vlist', $data);
}


    public function add()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $mDoc = new mtipo_documento();
        $mTc  = new mtipo_cliente();

        return view('admin/cliente/vadd', [
            'active'          => 'mantenimiento',
            'subactive'       => 'cliente',
            'tipos_documento' => $mDoc->findAll(),
            'tipos_cliente'   => $mTc->findAll(),
        ]);
    }

    public function store()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $rules = [
            'codigo'           => 'required|is_unique[cliente.codigo]',
            'nombre'           => 'required',
            'idtipo_documento' => 'required|integer',
            'idtipo_cliente'   => 'required|integer',
        ];

        $messages = [
            'codigo' => [
                'required'  => 'El código es obligatorio',
                'is_unique' => 'El código ya existe, intente con otro',
            ],
            'nombre' => [
                'required' => 'El nombre es obligatorio',
            ],
            'idtipo_documento' => [
                'required' => 'Seleccione el tipo de documento',
            ],
            'idtipo_cliente' => [
                'required' => 'Seleccione el tipo de cliente',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getErrors());
        }

        $model = new mcliente();
        $model->insert([
            'codigo'           => $this->request->getPost('codigo'),
            'nombre'           => $this->request->getPost('nombre'),
            'direccion'        => $this->request->getPost('direccion'),
            'telefono'         => $this->request->getPost('telefono'),
            'idtipo_documento' => (int)$this->request->getPost('idtipo_documento'),
            'idtipo_cliente'   => (int)$this->request->getPost('idtipo_cliente'),
            'estado'           => 1,
            'hobby'            => $this->request->getPost('hobby')
        ]);

        return redirect()->to(base_url('mantenimiento/cliente'))
            ->with('success', 'Cliente guardado correctamente');
    }

    public function edit($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mcliente();
        $mDoc  = new mtipo_documento();
        $mTc   = new mtipo_cliente();

        return view('admin/cliente/vedit', [
            'active'          => 'mantenimiento',
            'subactive'       => 'cliente',
            'cli'             => $model->find($id),
            'tipos_documento' => $mDoc->findAll(),
            'tipos_cliente'   => $mTc->findAll(),
        ]);
    }

    public function update($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $rules = [
            'codigo'           => "required|is_unique[cliente.codigo,idcliente,$id]",
            'nombre'           => 'required',
            'idtipo_documento' => 'required|integer',
            'idtipo_cliente'   => 'required|integer',
        ];

        $messages = [
            'codigo' => [
                'required'  => 'El código es obligatorio',
                'is_unique' => 'El código ya existe, intente con otro',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getErrors());
        }

        $model = new mcliente();
        $model->update($id, [
            'codigo'           => $this->request->getPost('codigo'),
            'nombre'           => $this->request->getPost('nombre'),
            'direccion'        => $this->request->getPost('direccion'),
            'telefono'         => $this->request->getPost('telefono'),
            'idtipo_documento' => (int)$this->request->getPost('idtipo_documento'),
            'idtipo_cliente'   => (int)$this->request->getPost('idtipo_cliente'),
            'estado'           => (int)$this->request->getPost('estado'),
            'hobby'            => $this->request->getPost('hobby')
        ]);

        return redirect()->to(base_url('mantenimiento/cliente'))
            ->with('success', 'Cliente actualizado correctamente');
    }

    public function view($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mcliente();

        return view('admin/cliente/vview', [
            'active'    => 'mantenimiento',
            'subactive' => 'cliente',
            'cli'       => $model->find($id),
        ]);
    }

    public function delete($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mcliente();
        $model->delete($id);

        return redirect()->to(base_url('mantenimiento/cliente'));
    }
}
