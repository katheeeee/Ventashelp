<?php

namespace App\Models;

use CodeIgniter\Model;

class mcliente extends Model
{
    protected $table      = 'cliente';
    protected $primaryKey = 'idcliente';

    protected $allowedFields = [
        'codigo',
        'nombre',
        'direccion',
        'telefono',
        'estado',
        'idtipo_documento',
        'idtipo_cliente'
    ];
}
