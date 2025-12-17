<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;
use App\Models\mcategoria;

class ccategoria extends BaseController
{
    public function index()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $model = new mcategoria();
        $data['categorias'] = $model->findAll();

        return view('admin/categoria/vlist', $data);
    }

    public function add()
    {
        return view('admin/categoria/vadd');
    }

    public function store()
    {
        $model = new mcategoria();
        $model->insert([
            'nombre' => $this->request->getPost('nombre'),
            'estado' => 1
        ]);

        return redirect()->to(base_url('categoria'));
    }

    public function edit($id)
    {
        $model = new mcategoria();
        $data['cat'] = $model->find($id);

        return view('admin/categoria/vedit', $data);
    }

    public function update($id)
    {
        $model = new mcategoria();
        $model->update($id, [
            'nombre' => $this->request->getPost('nombre'),
            'estado' => $this->request->getPost('estado')
        ]);

        return redirect()->to(base_url('categoria'));
    }

    public function delete($id)
    {
        $model = new mcategoria();
        $model->delete($id);

        return redirect()->to(base_url('categoria'));
    }
}
