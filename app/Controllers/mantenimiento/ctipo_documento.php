<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;
use App\Models\mtipo_documento;

class ctipo_documento extends BaseController
{
    public function index()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mtipo_documento();

        $data = [
            'active'    => 'mantenimiento',
            'subactive' => 'tipo_documento',
            'registros' => $model->findAll()
        ];

        return view('admin/tipo_documento/vlist', $data);
    }

    public function add()
    {
        return view('admin/tipo_documento/vadd', [
            'active'    => 'mantenimiento',
            'subactive' => 'tipo_documento'
        ]);
    }

    public function store()
    {
        $rules = [
            'codigo'      => 'required|is_unique[tipo_documento.codigo]',
            'nombre'      => 'required',
            'descripcion' => 'required'
        ];

        $messages = [
            'codigo' => [
                'required'  => 'El código es obligatorio',
                'is_unique' => 'El código ya existe'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getErrors());
        }

        $model = new mtipo_documento();
        $model->insert([
            'codigo'      => $this->request->getPost('codigo'),
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => 1
        ]);

        return redirect()->to(base_url('tipo_documento'))
            ->with('success', 'Tipo de documento registrado');
    }

    public function edit($id)
    {
        $model = new mtipo_documento();

        return view('admin/tipo_documento/vedit', [
            'active'    => 'mantenimiento',
            'subactive' => 'tipo_documento',
            'row'       => $model->find($id)
        ]);
    }

    public function update($id)
    {
        $rules = [
            'codigo'      => "required|is_unique[tipo_documento.codigo,idtipo_documento,$id]",
            'nombre'      => 'required',
            'descripcion' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getErrors());
        }

        $model = new mtipo_documento();
        $model->update($id, [
            'codigo'      => $this->request->getPost('codigo'),
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => $this->request->getPost('estado')
        ]);

        return redirect()->to(base_url('tipo_documento'))
            ->with('success', 'Actualizado correctamente');
    }

    public function view($id)
    {
        $model = new mtipo_documento();

        return view('admin/tipo_documento/vview', [
            'active'    => 'mantenimiento',
            'subactive' => 'tipo_documento',
            'row'       => $model->find($id)
        ]);
    }

    public function delete($id)
    {
        $model = new mtipo_documento();
        $model->delete($id);

        return redirect()->to(base_url('tipo_documento'))
            ->with('success', 'Eliminado correctamente');
    }
}
