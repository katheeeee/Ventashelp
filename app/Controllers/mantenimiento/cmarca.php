<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;
use App\Models\mmarca;

class cmarca extends BaseController
{
    public function index()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mmarca();

        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'marca',
            'marcas'    => $model->findAll(),
        ];

        return view('admin/marca/vlist', $data);
    }

    public function add()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'marca',
        ];

        return view('admin/marca/vadd', $data);
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

        $model = new mmarca();
        $model->insert([
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => 1
        ]);

        return redirect()->to(base_url('mantenimiento/marca'))
            ->with('success', 'Marca guardada correctamente');
    }

    public function edit($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mmarca();

        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'marca',
            'mar'       => $model->find($id),
        ];

        return view('admin/marca/vedit', $data);
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

        $model = new mmarca();
        $model->update($id, [
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => $this->request->getPost('estado'),
        ]);

        return redirect()->to(base_url('mantenimiento/marca'))
            ->with('success', 'Marca actualizada correctamente');
    }

    public function view($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mmarca();

        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'marca',
            'mar'       => $model->find($id),
        ];

        return view('admin/marca/vview', $data);
    }

    public function delete($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mmarca();
        $model->delete($id);

        return redirect()->to(base_url('mantenimiento/marca'));
    }
}
