<?php

namespace App\Models;
use CodeIgniter\Model;

class mcolor extends Model
{
    protected $table      = 'color';
    protected $primaryKey = 'idcolor';

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'estado'
    ];
}
