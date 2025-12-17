<?php

namespace App\Models;

use CodeIgniter\Model;

class Musuario extends Model
{
    protected $table      = 'usuario';
    protected $primaryKey = 'idtipo_usuario';
    protected $returnType = 'array';

    protected $allowedFields = [
        'codigo',
        'nombre',
        'apellido',
        'estado',
        'telefono',
        'user',
        'pass',
        'idrol'
    ];

    // login como en el video, pero bien hecho
    public function mlogeo($user, $pass)
    {
        $user = trim($user);
        $pass = trim($pass);

        return $this->where('estado', 1)
                    ->where('UPPER(user)', strtoupper($user), false)
                    ->where('pass', $pass)
                    ->first();
    }
}
