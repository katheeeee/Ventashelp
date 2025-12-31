<?php

namespace App\Models;

use CodeIgniter\Model;

class mcliente extends Model
{
    protected $table      = 'cliente';
    protected $primaryKey = 'idcliente';

    protected $allowedFields = [
        'codigo',
        'nombre',
        'direccion',
        'telefono',
        'estado',
        'idtipo_documento',
        'idtipo_cliente',
        'hobby',
    ];

    // 🔹 LISTADO CON NOMBRES
    public function listarConTipos()
    {
        return $this->db->table('cliente c')
            ->select('c.*, td.nombre AS tipo_doc, tc.nombre AS tipo_cliente')
            ->join('tipo_documento td', 'td.idtipo_documento = c.idtipo_documento', 'left')
            ->join('tipo_cliente tc', 'tc.idtipo_cliente = c.idtipo_cliente', 'left')
            ->orderBy('c.idcliente', 'DESC')
            ->get()
            ->getResultArray();
    }
}
