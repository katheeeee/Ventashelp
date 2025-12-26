<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\musuario;

class cusuarios extends BaseController
{
    public function index()
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        $model = new musuario();

        $data = [
            'title'     => 'usuarios',
            'active'    => 'admin',
            'subactive' => 'usuarios',
            'rows'      => $model->listar_todos()
        ];

        return view('admin/admin/usuarios', $data);
    }

    public function add()
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        $data = [
            'title'     => 'nuevo usuario',
            'active'    => 'admin',
            'subactive' => 'usuarios_add',
        ];
        return view('admin/admin/usuarios_add', $data);
    }

    public function store()
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        $model = new musuario();

        $user     = trim($this->request->getPost('user'));
        $pass     = trim($this->request->getPost('pass'));
        $nombre   = trim($this->request->getPost('nombre'));
        $apellido = trim($this->request->getPost('apellido'));
        $telefono = trim($this->request->getPost('telefono'));
        $codigo   = trim($this->request->getPost('codigo'));
        $idrol    = (int)($this->request->getPost('idrol') ?? 1);

        if ($user === '' || $pass === '' || $nombre === '') {
            return redirect()->back()->with('msg_error', 'completa los campos obligatorios');
        }

        if ($model->buscar_por_user($user)) {
            return redirect()->back()->with('msg_error', 'el usuario ya existe');
        }

        $model->insert([
            'codigo'   => $codigo,
            'nombre'   => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'user'     => $user,
            'pass'     => $pass,
            'estado'   => 1,
            'idrol'    => $idrol
        ]);

        return redirect()->to(base_url('admin/usuarios'))->with('msg_ok', 'usuario creado');
    }

    public function edit($id)
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        $model = new musuario();
        $row = $model->find($id);

        if (!$row) return redirect()->to(base_url('admin/usuarios'))->with('msg_error', 'usuario no encontrado');

        $data = [
            'title'     => 'editar usuario',
            'active'    => 'admin',
            'subactive' => 'usuarios',
            'row'       => $row
        ];

        return view('admin/admin/usuarios_edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        $model = new musuario();
        $row = $model->find($id);
        if (!$row) return redirect()->to(base_url('admin/usuarios'))->with('msg_error', 'usuario no encontrado');

        $user     = trim($this->request->getPost('user'));
        $nombre   = trim($this->request->getPost('nombre'));
        $apellido = trim($this->request->getPost('apellido'));
        $telefono = trim($this->request->getPost('telefono'));
        $codigo   = trim($this->request->getPost('codigo'));
        $idrol    = (int)($this->request->getPost('idrol') ?? 1);

        if ($user === '' || $nombre === '') {
            return redirect()->back()->with('msg_error', 'completa los campos obligatorios');
        }

        if ($model->buscar_por_user($user, $id)) {
            return redirect()->back()->with('msg_error', 'ese user ya está en uso');
        }

        $model->update($id, [
            'codigo'   => $codigo,
            'nombre'   => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'user'     => $user,
            'idrol'    => $idrol
        ]);

        return redirect()->to(base_url('admin/usuarios'))->with('msg_ok', 'usuario actualizado');
    }

    public function toggle($id)
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        $model = new musuario();
        $row = $model->find($id);
        if (!$row) return redirect()->to(base_url('admin/usuarios'))->with('msg_error', 'usuario no encontrado');

        $nuevo = ((int)$row['estado'] === 1) ? 0 : 1;

        $model->update($id, ['estado' => $nuevo]);

        return redirect()->to(base_url('admin/usuarios'))->with('msg_ok', 'estado actualizado');
    }
}
