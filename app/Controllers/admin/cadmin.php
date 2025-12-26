<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\musuario;
if (!session()->get('login')) return redirect()->to(base_url('login'));
if ((int)session()->get('idrol') !== 1) return redirect()->to(base_url('dashboard'));

class cadmin extends BaseController
{
    
    public function cambiar_password()
    {
        if($r = $this->solo_admin()) return $r;
        $data = [
            'title'     => 'cambiar contraseña',
            'active'    => 'admin',
            'subactive' => 'cambiar_password'
        ];

        return view('admin/admin/cambiar_password', $data);
    }

    public function guardar_password()
    {
                if($r = $this->solo_admin()) return $r;

        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $actual = trim($this->request->getPost('password_actual') ?? '');
        $nueva  = trim($this->request->getPost('password_nueva') ?? '');
        $rep    = trim($this->request->getPost('password_repetir') ?? '');

        if ($nueva === '' || strlen($nueva) < 4) {
            return redirect()->back()->with('msg_error', 'la nueva contraseña debe tener al menos 4 caracteres');
        }

        if ($nueva !== $rep) {
            return redirect()->back()->with('msg_error', 'las contraseñas no coinciden');
        }

        if ($actual === $nueva) {
            return redirect()->back()->with('msg_error', 'la nueva contraseña no puede ser igual a la actual');
        }

        $idusuario = session()->get('idusuario');
        if (!$idusuario) {
            return redirect()->back()->with('msg_error', 'no se encontró idusuario en sesión');
        }

        $model = new musuario();

        // ✅ forzamos traer pass sí o sí
        $user = $model->select('idtipo_usuario, pass')->find($idusuario);

        if (!$user) {
            return redirect()->back()->with('msg_error', 'usuario no encontrado');
        }

        if (!isset($user['pass'])) {
            return redirect()->back()->with('msg_error', 'no se pudo leer la contraseña del usuario');
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
    private function solo_admin()
{
    if (!session()->get('login')) {
        return redirect()->to(base_url('login'));
    }

    // 1 = admin (como dijiste)
    if ((int)session()->get('idrol') !== 1) {
        return redirect()->to(base_url('dashboard'));
        // o si prefieres:
        // return $this->response->setStatusCode(403, 'acceso denegado');
    }

    return null; // ok
}

}
