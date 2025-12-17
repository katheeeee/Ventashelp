<?php

namespace App\Controllers;

class home extends BaseController
{
    public function index()
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'active'      => 'dashboard',
            'subactive'   => '',
            'pageTitle'   => 'Dashboard',
            'pageSub'     => 'Panel principal',
            'contentText' => 'Contenido'
        ];

        return view('admin/vdashboard', $data);
    }
}
