<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;
use App\Models\munmedida;

class cunmedida extends BaseController
{
    public function index()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new munmedida();

        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'unmedida',
            'unidades'  => $model->findAll(),
        ];

        return view('admin/unmedida/vlist', $data);
    }

    public function add()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        return view('admin/unmedida/vadd', [
            'active'    => 'mantenimiento',
            'subactive' => 'unmedida',
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

        $messages = [
            'nombre' => ['required' => 'El nombre es obligatorio'],
            'descripcion' => ['required' => 'La descripción es obligatoria'],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getErrors());
        }

        $model = new munmedida();
        $model->insert([
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => 1
        ]);

        return redirect()->to(base_url('mantenimiento/unmedida'))
            ->with('success', 'Unidad de medida guardada correctamente');
    }

    public function edit($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new munmedida();

        return view('admin/unmedida/vedit', [
            'active'    => 'mantenimiento',
            'subactive' => 'unmedida',
            'um'        => $model->find($id),
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

        $model = new munmedida();
        $model->update($id, [
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => $this->request->getPost('estado'),
        ]);

        return redirect()->to(base_url('mantenimiento/unmedida'))
            ->with('success', 'Unidad de medida actualizada correctamente');
    }

    public function view($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new munmedida();

        return view('admin/unmedida/vview', [
            'active'    => 'mantenimiento',
            'subactive' => 'unmedida',
            'um'        => $model->find($id),
        ]);
    }

    public function delete($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new munmedida();
        $model->delete($id);

        return redirect()->to(base_url('mantenimiento/unmedida'));
    }
}
