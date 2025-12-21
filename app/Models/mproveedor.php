<?php

namespace App\Models;

use CodeIgniter\Model;

class mproveedor extends Model
{
    protected $table      = 'proveedor';
    protected $primaryKey = 'idproveedor';

    protected $allowedFields = [
        'codigo',
        'nombre',
        'direccion',
        'telefono',
        'estado',
        'idtipo_documeto',
        'idtipo_cliente'
    ];
}
