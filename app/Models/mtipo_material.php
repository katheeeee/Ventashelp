<?php

namespace App\Models;

use CodeIgniter\Model;

class mtipo_material extends Model
{
    protected $table      = 'tipo_material';
    protected $primaryKey = 'idtipo_material';

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'estado'
    ];
}
