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
        'num_documento',
        'idusuario',
        'idcliente',
        'fecharegistro',
        'usuarioregistro',
        'idtipo_documento',
        'idtipo_comprobante',
    ];

    protected $useTimestamps = false;
}
