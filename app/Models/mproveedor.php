<?php

namespace App\Models;

use CodeIgniter\Model;

class mproveedor extends Model
{
    protected $table      = 'proveedor';
    protected $primaryKey = 'idproveedor';

    protected $allowedFields = [
        'codigo',
        'nombre',
        'direccion',
        'telefono',
        'estado',
        'idtipo_documeto',
        'idtipo_cliente'
    ];

    // 🔹 LISTADO CON NOMBRES
    public function listarConTipos()
    {
        return $this->db->table('proveedor p')
            ->select('p.*, td.nombre AS tipo_doc, tc.nombre AS tipo_cliente')
            ->join('tipo_documento td', 'td.idtipo_documento = p.idtipo_documeto', 'left')
            ->join('tipo_cliente tc', 'tc.idtipo_cliente = p.idtipo_cliente', 'left')
            ->orderBy('p.idproveedor', 'DESC')
            ->get()
            ->getResultArray();
    }
}
