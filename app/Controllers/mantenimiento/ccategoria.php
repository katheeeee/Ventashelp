<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;
use App\Models\mcategoria;

class ccategoria extends BaseController
{
    public function index()
    {
        $model = new mcategoria();

        return view('admin/categoria/vlist', [
            'active'     => 'mantenimiento',
            'subactive'  => 'categoria',
            'categorias' => $model->findAll(),
        ]);
    }

    public function add()
    {
        return view('admin/categoria/vadd', [
            'active'    => 'mantenimiento',
            'subactive' => 'categoria',
        ]);
    }

    public function store()
    {
        $rules = [
            'codigo'      => 'required|is_unique[categoria.codigo]',
            'nombre'      => 'required',
            'descripcion' => 'required',
        ];

        $messages = [
            'codigo' => [
                'required'  => 'El código es obligatorio',
                'is_unique' => 'El código ya existe, intente con otro',
            ],
            'nombre' => [
                'required' => 'El nombre es obligatorio',
            ],
            'descripcion' => [
                'required' => 'La descripción es obligatoria',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getErrors());
        }

        $model = new mcategoria();
        $model->insert([
            'codigo'      => $this->request->getPost('codigo'),
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => 1
        ]);

        return redirect()->to(base_url('mantenimiento/categoria'))
            ->with('success', 'Categoría guardada con éxito');
    }

    public function edit($id)
    {
        $model = new mcategoria();

        return view('admin/categoria/vedit', [
            'active'    => 'mantenimiento',
            'subactive' => 'categoria',
            'cat'       => $model->find($id),
        ]);
    }

    public function view($id)
    {
        $model = new mcategoria();

        return view('admin/categoria/vview', [
            'active'    => 'mantenimiento',
            'subactive' => 'categoria',
            'cat'       => $model->find($id),
        ]);
    }

    public function update($id)
    {
        $rules = [
            'codigo'      => "required|is_unique[categoria.codigo,idcategoria,$id]",
            'nombre'      => 'required',
            'descripcion' => 'required',
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

        $model = new mcategoria();
        $model->update($id, [
            'codigo'      => $this->request->getPost('codigo'),
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => $this->request->getPost('estado'),
        ]);

        return redirect()->to(base_url('mantenimiento/categoria'))
            ->with('success', 'Categoría actualizada con éxito');
    }

    public function delete($id)
    {
        $model = new mcategoria();
        $model->delete($id);

        return redirect()->to(base_url('mantenimiento/categoria'))
            ->with('success', 'Categoría eliminada');
    }
}
