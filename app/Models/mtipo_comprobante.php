<?php

namespace App\Models;

use CodeIgniter\Model;

class mtipo_comprobante extends Model
{
    protected $table      = 'tipo_comprobante';
    protected $primaryKey = 'idtipo_comprobante';
    protected $returnType = 'array';

    protected $allowedFields = [
        'nombre',
        'serie',
        'igv',
        'cantidad',
        'estado',
    ];

    public $useTimestamps = false;
}
