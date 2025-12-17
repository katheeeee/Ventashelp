<?php

namespace App\Models;

use CodeIgniter\Model;

class musuario extends Model
{
    protected $table      = 'usuario';
    protected $primaryKey = 'idtipo_usuario'; // si tu PK real es otro, cámbialo

    protected $returnType = 'array';
    protected $allowedFields = [
        'idtipo_usuario','codigo','nombre','apellido','estado','telefono','user','pass','idrol'
    ];

    public function mlogeo(string $user, string $pass)
    {
        return $this->where('user', $user)
                    ->where('pass', $pass)
                    ->where('estado', 1)   // opcional (solo si manejas estado)
                    ->first();
    }
}
