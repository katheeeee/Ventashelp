<?php

namespace App\Models;

use CodeIgniter\Model;

class mtipo_cliente extends Model
{
    protected $table      = 'tipo_cliente';
    protected $primaryKey = 'idtipo_cliente';

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'estado'
    ];
}
