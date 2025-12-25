<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\musuario;

class cadmin extends BaseController
{
    public function cambiar_password()
    {
        $data = [
            'title'     => 'cambiar contraseña',
            'active'    => 'admin',
            'subactive' => 'cambiar_password'
        ];

        return view('admin/admin/cambiar_password', $data);
    }

    public function guardar_password()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $actual = trim($this->request->getPost('password_actual'));
        $nueva  = trim($this->request->getPost('password_nueva'));
        $rep    = trim($this->request->getPost('password_repetir'));

        if ($nueva === '' || strlen($nueva) < 4) {
            return redirect()->back()->with('msg_error', 'la nueva contraseña es muy corta');
        }

        if ($nueva !== $rep) {
            return redirect()->back()->with('msg_error', 'las contraseñas no coinciden');
        }

        $idusuario = session()->get('idusuario');

        $model = new musuario();
        $user  = $model->find($idusuario);

        if (!$user) {
            return redirect()->back()->with('msg_error', 'usuario no encontrado');
        }

        // validar contraseña actual (TEXTO PLANO)
        if ($user['pass'] !== $actual) {
            return redirect()->back()->with('msg_error', 'la contraseña actual es incorrecta');
        }

        // actualizar contraseña
        $model->update($idusuario, [
            'pass' => $nueva
        ]);

        return redirect()->to(base_url('admin/cambiar_password'))
            ->with('msg_ok', 'contraseña actualizada correctamente');
    }
}
