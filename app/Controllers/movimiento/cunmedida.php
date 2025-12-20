<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;
use App\Models\munmedida;

class cunmedida extends BaseController
{
    public function index()
    {
        $model = new munmedida();

        return view('admin/unmedida/vlist', [
            'active'    => 'mantenimiento',
            'subactive' => 'unmedida',
            'registros' => $model->findAll()
        ]);
    }

    public function add()
    {
        return view('admin/unmedida/vadd', [
            'active'    => 'mantenimiento',
            'subactive' => 'unmedida'
        ]);
    }

    public function store()
    {
        $rules = [
            'codigo'      => 'required|is_unique[unmedida.codigo]',
            'nombre'      => 'required',
            'descripcion' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getErrors());
        }

        $model = new munmedida();
        $model->insert([
            'codigo'      => $this->request->getPost('codigo'),
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => 1
        ]);

        return redirect()->to(base_url('mantenimiento/unmedida'))
            ->with('success', 'Unidad de medida guardada con éxito');
    }

    public function edit($id)
    {
        $model = new munmedida();

        return view('admin/unmedida/vedit', [
            'active'    => 'mantenimiento',
            'subactive' => 'unmedida',
            'row'       => $model->find($id)
        ]);
    }

    public function update($id)
    {
        $model = new munmedida();
        $row = $model->find($id);

        $rules = [
            'codigo'      => 'required',
            'nombre'      => 'required',
            'descripcion' => 'required'
        ];

        if ($this->request->getPost('codigo') !== ($row['codigo'] ?? '')) {
            $rules['codigo'] .= '|is_unique[unmedida.codigo]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getErrors());
        }

        $model->update($id, [
            'codigo'      => $this->request->getPost('codigo'),
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => $this->request->getPost('estado')
        ]);

        return redirect()->to(base_url('mantenimiento/unmedida'))
            ->with('success', 'Unidad de medida actualizada con éxito');
    }

    public function view($id)
    {
        $model = new munmedida();

        return view('admin/unmedida/vview', [
            'active'    => 'mantenimiento',
            'subactive' => 'unmedida',
            'row'       => $model->find($id)
        ]);
    }

    public function delete($id)
    {
        $model = new munmedida();
        $model->delete($id);

        return redirect()->to(base_url('mantenimiento/unmedida'))
            ->with('success', 'Unidad de medida eliminada');
    }
}
