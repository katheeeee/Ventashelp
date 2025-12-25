<?php

namespace App\Controllers\reportes;

use App\Controllers\BaseController;

class creportes extends BaseController
{
    private function render($vista, $subactive)
    {
        if (!session()->get('login')) {
            return redirect()->to(base_url('login'));
        }

        return view('admin/reportes/' . $vista, [
            'title'     => 'reportes',
            'active'    => 'reportes',
            'subactive' => $subactive
        ]);
    }
public function resumen()
{
  $data = [
    'title' => 'resumen',
    'active' => 'reportes',
    'subactive' => 'resumen'
  ];
  return view('admin/reportes/resumen', $data);
}


    public function top_productos()
    {
        return $this->render('top_productos', 'top_productos');
    }

    public function top_clientes()
    {
        return $this->render('top_clientes', 'top_clientes');
    }

    public function ventas_diarias()
    {
        return $this->render('ventas_diarias', 'ventas_diarias');
    }
}
