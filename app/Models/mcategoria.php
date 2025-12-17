<?php

namespace App\Models;

use CodeIgniter\Model;

class mcategoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'id'; // cambia si tu pk es otro
    protected $allowedFields = ['nombre', 'estado'];
    protected $returnType = 'array';
}
