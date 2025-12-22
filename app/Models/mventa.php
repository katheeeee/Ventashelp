<?php

namespace App\Models;

use CodeIgniter\Model;

class mventa extends Model
{
    protected $table      = 'venta';
    protected $primaryKey = 'idventa';
    protected $returnType = 'array';

    protected $allowedFields = [
        'fecha',
        'subtotal',
        'estado',
        'serie',
        'igv',
        'descuento',
        'total',
        'idtipo_comprobante',
        'idusuario',
        'idcliente',
        'fecharegistro',
        'usuarioregistro',
        'idtipo_documento',
    ];

    public $useTimestamps = false;
}
