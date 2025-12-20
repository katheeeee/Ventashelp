<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;
use App\Models\mtipo_cliente;

class ctipo_cliente extends BaseController
{
    public function index()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mtipo_cliente();

        return view('admin/tipo_cliente/vlist', [
            'active'    => 'mantenimiento',
            'subactive' => 'tipo_cliente',
            'tipos'     => $model->findAll(),
        ]);
    }

    public function add()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        return view('admin/tipo_cliente/vadd', [
            'active'    => 'mantenimiento',
            'subactive' => 'tipo_cliente',
        ]);
    }

    public function store()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $rules = [
            'nombre'      => 'required',
            'descripcion' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getErrors());
        }

        $model = new mtipo_cliente();
        $model->insert([
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => 1
        ]);

        return redirect()->to(base_url('mantenimiento/tipo_cliente'))
            ->with('success', 'Tipo de cliente guardado correctamente');
    }

    public function edit($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mtipo_cliente();

        return view('admin/tipo_cliente/vedit', [
            'active'    => 'mantenimiento',
            'subactive' => 'tipo_cliente',
            'tc'        => $model->find($id),
        ]);
    }

    public function update($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $rules = [
            'nombre'      => 'required',
            'descripcion' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getErrors());
        }

        $model = new mtipo_cliente();
        $model->update($id, [
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => $this->request->getPost('estado'),
        ]);

        return redirect()->to(base_url('mantenimiento/tipo_cliente'))
            ->with('success', 'Tipo de cliente actualizado correctamente');
    }

    public function view($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mtipo_cliente();

        return view('admin/tipo_cliente/vview', [
            'active'    => 'mantenimiento',
            'subactive' => 'tipo_cliente',
            'tc'        => $model->find($id),
        ]);
    }

    public function delete($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mtipo_cliente();
        $model->delete($id);

        return redirect()->to(base_url('mantenimiento/tipo_cliente'));
    }
}
