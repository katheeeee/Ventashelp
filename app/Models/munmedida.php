<?php

namespace App\Models;

use CodeIgniter\Model;

class munmedida extends Model
{
    protected $table      = 'unmedida';      // ⚠️ si tu tabla se llama distinto, cambia aquí
    protected $primaryKey = 'idunmedida';    // ⚠️ si tu PK se llama distinto, cambia aquí

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'estado'
    ];
}
