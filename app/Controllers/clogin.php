<?php

namespace App\Controllers;

use App\Models\musuario;

class Clogin extends BaseController
{
    // muestra el login
    public function index()
    {
        return view('admin/vlogin');
    }

    // procesa el login (ESTE ES CLOGEO)
    public function clogeo()
    {
        $txtnombre = trim($this->request->getPost('txtnombre'));
        $txtpass   = trim($this->request->getPost('txtpass'));

        $model = new musuario();
        $res   = $model->mlogeo($txtnombre, $txtpass);

        if (!$res) {
            return redirect()->back()
                ->with('error', 'Usuario y/o contraseña incorrectos');
        }

        session()->set([
            'idusuario'      => $res['idtipo_usuario'], // ✅ necesario para cambiar contraseña
            'idtipo_usuario' => $res['idtipo_usuario'],
            'user'           => $res['user'],
            'login'          => true
        ]);

        return redirect()->to(base_url('dashboard'));
    }

    // CIERRA SESIÓN (ESTE ES CLOGOUT)
    public function clogout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
