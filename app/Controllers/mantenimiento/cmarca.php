<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;
use App\Models\mmarca;

class cmarca extends BaseController
{
    public function index()
    {
        $model = new mmarca();

        return view('admin/marca/vlist', [
            'active'    => 'mantenimiento',
            'subactive' => 'marca',
            'registros' => $model->findAll()
        ]);
    }

    public function add()
    {
        return view('admin/marca/vadd', [
            'active'    => 'mantenimiento',
            'subactive' => 'marca',
        ]);
    }

    public function store()
    {
        $rules = [
            'codigo'      => 'required|is_unique[marca.codigo]',
            'nombre'      => 'required',
            'descripcion' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $model = new mmarca();
        $model->insert([
            'codigo'      => $this->request->getPost('codigo'),
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => 1
        ]);

        return redirect()->to(base_url('mantenimiento/marca'))
            ->with('success', 'Marca guardada con éxito');
    }

    public function edit($id)
    {
        $model = new mmarca();

        return view('admin/marca/vedit', [
            'active'    => 'mantenimiento',
            'subactive' => 'marca',
            'row'       => $model->find($id)
        ]);
    }

    public function update($id)
    {
        $model = new mmarca();
        $row = $model->find($id);

        $rules = [
            'codigo'      => 'required',
            'nombre'      => 'required',
            'descripcion' => 'required',
        ];

        // UNIQUE solo si cambió el código
        if ($this->request->getPost('codigo') !== ($row['codigo'] ?? '')) {
            $rules['codigo'] .= '|is_unique[marca.codigo]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $model->update($id, [
            'codigo'      => $this->request->getPost('codigo'),
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => $this->request->getPost('estado'),
        ]);

        return redirect()->to(base_url('mantenimiento/marca'))
            ->with('success', 'Marca actualizada con éxito');
    }

    public function view($id)
    {
        $model = new mmarca();

        return view('admin/marca/vview', [
            'active'    => 'mantenimiento',
            'subactive' => 'marca',
            'row'       => $model->find($id)
        ]);
    }

    public function delete($id)
    {
        $model = new mmarca();
        $model->delete($id);

        return redirect()->to(base_url('mantenimiento/marca'))
            ->with('success', 'Marca eliminada con éxito');
    }
}
