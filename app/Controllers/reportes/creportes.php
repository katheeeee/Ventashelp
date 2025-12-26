<?php

namespace App\Controllers\reportes;

use App\Controllers\BaseController;

class creportes extends BaseController
{
    public function resumen()
    {
        return view('admin/reportes/resumen');
    }

    public function ventas_diarias()
    {
        return view('admin/reportes/ventas_diarias');
    }

    public function top_productos()
    {
        return view('admin/reportes/top_productos');
    }

    public function top_clientes()
    {
        return view('admin/reportes/top_clientes');
    }
}
