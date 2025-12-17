<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('admin/dashboard', [
            'title'       => 'Helpnet',
            'active'      => 'dashboard',

            'pageTitle'   => 'Dashboard',
            'pageSub'     => 'Panel principal',

            'contentText' => 'Contenido'
        ]);
    }
}
