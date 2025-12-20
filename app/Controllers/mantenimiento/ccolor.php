<?php

namespace App\Controllers\mantenimiento;
use App\Models\mcolor;

class ccolor extends BaseController
{
    protected $color;

    public function __construct()
    {
        $this->color = new mcolor();
    }

    // LISTADO
    public function index()
    {
        $data['registros'] = $this->color->findAll();
        return view('admin/color/vlist', $data);
    }

    // FORM AGREGAR
    public function add()
    {
        return view('admin/color/vadd');
    }

    // GUARDAR
    public function store()
    {
        $this->color->insert([
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => 'Activo'
        ]);

        return redirect()->to(base_url('ccolor'));
    }

    // FORM EDITAR
    public function edit($id)
    {
        $data['registro'] = $this->color->find($id);
        return view('admin/color/vedit', $data);
    }

    // ACTUALIZAR
    public function update($id)
    {
        $this->color->update($id, [
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion')
        ]);

        return redirect()->to(base_url('ccolor'));
    }

    // CAMBIAR ESTADO
    public function delete($id)
    {
        $this->color->update($id, ['estado' => 'Inactivo']);
        return redirect()->to(base_url('ccolor'));
    }

    // VER
    public function view($id)
    {
        $data['registro'] = $this->color->find($id);
        return view('admin/color/vview', $data);
    }
}
