<?php

namespace App\Models;

use CodeIgniter\Model;

class mmarca extends Model
{
    protected $table      = 'marca';
    protected $primaryKey = 'idmarca';

    protected $allowedFields = ['codigo', 'nombre', 'descripcion', 'estado'];

    protected $returnType = 'array';
}
