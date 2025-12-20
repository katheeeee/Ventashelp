<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;
use App\Models\mcolor;

class ccolor extends BaseController
{
    protected $color;

    public function __construct()
    {
        $this->color = new mcolor();
    }

    // =========================
    // LISTADO
    // =========================
    public function index()
    {
        $data = [
            'pageTitle' => 'Color',
            'pageSub'   => 'Listado',
            'registros' => $this->color->findAll()
        ];

        return view('admin/color/vlist', $data);
    }

    // =========================
    // FORMULARIO NUEVO
    // =========================
    public function add()
    {
        $data = [
            'pageTitle' => 'Color',
            'pageSub'   => 'Nuevo'
        ];

        return view('admin/color/vadd', $data);
    }

    // =========================
    // GUARDAR
    // =========================
    public function store()
    {
        $this->color->insert([
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => 'Activo'
        ]);

        return redirect()->to(base_url('ccolor'));
    }

    // =========================
    // FORMULARIO EDITAR
    // =========================
    public function edit($id)
    {
        $data = [
            'pageTitle' => 'Color',
            'pageSub'   => 'Editar',
            'registro'  => $this->color->find($id)
        ];

        return view('admin/color/vedit', $data);
    }

    // =========================
    // ACTUALIZAR
    // =========================
    public function update($id)
    {
        $this->color->update($id, [
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion')
        ]);

        return redirect()->to(base_url('ccolor'));
    }

    // =========================
    // ELIMINAR (CAMBIAR ESTADO)
    // =========================
    public function delete($id)
    {
        $this->color->update($id, [
            'estado' => 'Inactivo'
        ]);

        return redirect()->to(base_url('ccolor'));
    }

    // =========================
    // VER DETALLE
    // =========================
    public function view($id)
    {
        $data = [
            'pageTitle' => 'Color',
            'pageSub'   => 'Detalle',
            'registro'  => $this->color->find($id)
        ];

        return view('admin/color/vview', $data);
    }
}
