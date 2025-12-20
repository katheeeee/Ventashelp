<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;
use App\Models\mcolor;

class ccolor extends BaseController
{
    public function index()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mcolor();

        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'color',
            'colores'   => $model->findAll(),
        ];

        return view('admin/color/vlist', $data);
    }

    public function add()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'color',
        ];

        return view('admin/color/vadd', $data);
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

        $model = new mcolor();
        $model->insert([
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => 1
        ]);

        return redirect()->to(base_url('mantenimiento/color'))
            ->with('success', 'Color guardado correctamente');
    }

    public function edit($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mcolor();

        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'color',
            'col'       => $model->find($id),
        ];

        return view('admin/color/vedit', $data);
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

        $model = new mcolor();
        $model->update($id, [
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => $this->request->getPost('estado'),
        ]);

        return redirect()->to(base_url('mantenimiento/color'))
            ->with('success', 'Color actualizado correctamente');
    }

    public function view($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mcolor();

        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'color',
            'col'       => $model->find($id),
        ];

        return view('admin/color/vview', $data);
    }

    public function delete($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mcolor();
        $model->delete($id);

        return redirect()->to(base_url('mantenimiento/color'));
    }
}
