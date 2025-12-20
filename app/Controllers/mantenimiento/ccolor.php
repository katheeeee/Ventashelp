<?php

namespace App\Controllers\mantenimiento;

use App\Controllers\BaseController;   // ✅ IMPORTANTE
use App\Models\mcolor;

class ccolor extends BaseController
{
    protected $color;

    public function __construct()
    {
        $this->color = new mcolor();
    }

    public function index()
    {
        $data['registros'] = $this->color->findAll();
        return view('admin/color/vlist', $data);
    }
}
