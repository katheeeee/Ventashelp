<?php

namespace App\Models;

use CodeIgniter\Model;

class munmedida extends Model
{
    protected $table      = 'unmedida';
    protected $primaryKey = 'idunmedida';

    protected $allowedFields = [
        'codigo',
        'nombre',
        'descripcion',
        'estado'
    ];

    protected $returnType = 'array';
}
