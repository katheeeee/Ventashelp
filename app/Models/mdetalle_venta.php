<?php

namespace App\Models;

use CodeIgniter\Model;

class mdetalle_venta extends Model
{
    protected $table      = 'detalle_venta';
    protected $primaryKey = 'iddetalle_venta';
    protected $returnType = 'array';

    protected $allowedFields = [
        'estado',
        'precio',
        'cantidad',
        'importe',
        'idproducto',
        'idventa',
        'fecharegistro',
    ];

    public $useTimestamps = false;
}
