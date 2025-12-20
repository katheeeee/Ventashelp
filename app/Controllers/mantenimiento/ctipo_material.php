<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;
use App\Models\mtipo_material;

class ctipo_material extends BaseController
{
    public function index()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mtipo_material();

        $data = [
            'active'       => 'mantenimiento',
            'subactive'    => 'tipo_material',
            'tipos'        => $model->findAll(),
        ];

        return view('admin/tipo_material/vlist', $data);
    }

    public function add()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        return view('admin/tipo_material/vadd', [
            'active'    => 'mantenimiento',
            'subactive' => 'tipo_material',
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
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $model = new mtipo_material();
        $model->insert([
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => 1
        ]);

        return redirect()->to(base_url('mantenimiento/tipo_material'))
            ->with('success', 'Tipo de material guardado correctamente');
    }

    public function edit($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mtipo_material();

        return view('admin/tipo_material/vedit', [
            'active'    => 'mantenimiento',
            'subactive' => 'tipo_material',
            'tm'        => $model->find($id),
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
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $model = new mtipo_material();
        $model->update($id, [
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => $this->request->getPost('estado'),
        ]);

        return redirect()->to(base_url('mantenimiento/tipo_material'))
            ->with('success', 'Tipo de material actualizado correctamente');
    }

    public function view($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mtipo_material();

        return view('admin/tipo_material/vview', [
            'active'    => 'mantenimiento',
            'subactive' => 'tipo_material',
            'tm'        => $model->find($id),
        ]);
    }

    public function delete($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mtipo_material();
        $model->delete($id);

        return redirect()->to(base_url('mantenimiento/tipo_material'));
    }
}
