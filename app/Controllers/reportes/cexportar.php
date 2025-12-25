<?php

namespace App\Controllers\reportes;

use App\Controllers\BaseController;

class cexportar extends BaseController
{
    public function excel()
    {
        return $this->response->setJSON(['ok' => true, 'msg' => 'excel pendiente']);
    }

    public function pdf()
    {
        return $this->response->setJSON(['ok' => true, 'msg' => 'pdf pendiente']);
    }
}
