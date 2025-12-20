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
            'codigo'      => 'required|is_unique[color.codigo]',
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

        $model = new mcolor();
        $model->insert([
            'codigo'      => $this->request->getPost('codigo'),
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => 1
        ]);

        return redirect()->to(base_url('color'))
            ->with('success', 'Color guardado con éxito');
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

    public function update($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        // ✅ IMPORTANTE: ajusta "idcolor" si tu PK se llama distinto
        $rules = [
            'codigo'      => "required|is_unique[color.codigo,idcolor,$id]",
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

        $model = new mcolor();
        $model->update($id, [
            'codigo'      => $this->request->getPost('codigo'),
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => $this->request->getPost('estado'),
        ]);

        return redirect()->to(base_url('color'))
            ->with('success', 'Color actualizado con éxito');
    }

    public function delete($id)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mcolor();
        $model->delete($id);

        return redirect()->to(base_url('color'));
    }
}
