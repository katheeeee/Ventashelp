<?php

namespace App\Controllers\reportes;

use App\Controllers\BaseController;

class creportes extends BaseController
{
    private function auth_or_redirect()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }
        return null;
    }

    public function resumen()
    {
        if ($r = $this->auth_or_redirect()) return $r;

        return view('admin/reportes/resumen', [
            'active' => 'reportes',
            'subactive' => 'resumen'
        ]);
    }

    public function ventas_diarias()
    {
        if ($r = $this->auth_or_redirect()) return $r;

        return view('admin/reportes/ventas_diarias', [
            'active' => 'reportes',
            'subactive' => 'ventas_diarias'
        ]);
    }

    public function top_productos()
    {
        if ($r = $this->auth_or_redirect()) return $r;

        return view('admin/reportes/top_productos', [
            'active' => 'reportes',
            'subactive' => 'top_productos'
        ]);
    }

    public function top_clientes()
    {
        if ($r = $this->auth_or_redirect()) return $r;

        return view('admin/reportes/top_clientes', [
            'active' => 'reportes',
            'subactive' => 'top_clientes'
        ]);
    }
}
