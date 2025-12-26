<?php

namespace App\Models;

use CodeIgniter\Model;

class musuario extends Model
{
    protected $table      = 'usuario';
    protected $primaryKey = 'idtipo_usuario';

    protected $returnType = 'array';
    protected $allowedFields = [
        'idtipo_usuario','codigo','nombre','apellido','estado','telefono','user','pass','idrol'
    ];

    public function mlogeo(string $user, string $pass)
    {
        return $this->where('user', $user)
                    ->where('pass', $pass)
                    ->where('estado', 1)
                    ->first();
    }
    public function listar()
{
    return $this->where('estado', 1)->orderBy('nombre', 'ASC')->findAll();
}

public function listar_todos()
{
    return $this->orderBy('nombre', 'ASC')->findAll();
}

public function buscar_por_user(string $user, $except_id = null)
{
    $q = $this->where('user', $user);
    if ($except_id) $q->where('idtipo_usuario !=', $except_id);
    return $q->first();
}

}
