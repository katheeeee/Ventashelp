<?php

namespace App\Models;

use CodeIgniter\Model;

class mtipo_documento extends Model
{
    protected $table      = 'tipo_documento';
    protected $primaryKey = 'idtipo_documento';

    protected $returnType = 'array';

    protected $allowedFields = [
        'codigo',
        'nombre',
        'descripcion',
        'estado'
    ];
}
