<?php

namespace App\Models;

use CodeIgniter\Model;

class mproducto extends Model
{
    protected $table      = 'producto';
    protected $primaryKey = 'idproducto';

    protected $allowedFields = [
        'codigo','nombre','descripcion','estado','imagen',
        'precio','stock','observacion',
        'idcolor','idcategoria','idtipo_material','idmarca','idunmedida'
    ];

    protected $useTimestamps = false;
}
