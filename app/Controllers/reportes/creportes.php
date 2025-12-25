<?php

namespace App\Controllers\reportes;

use App\Controllers\BaseController;

class creportes extends BaseController
{
    public function index()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        return view('admin/reportes/index', [
            'title'  => 'reportes',
            'active' => 'reportes',
        ]);
    }
}
