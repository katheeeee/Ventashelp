<?php

namespace App\Controllers\reportes;

use App\Controllers\BaseController;

class cestadisticas extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function resumen()
    {
        if (!session()->get('login')) return $this->response->setStatusCode(403);

        $desde = $this->request->getGet('desde');
        $hasta = $this->request->getGet('hasta');

        $builder = $this->db->table('venta')
            ->select('
                count(idventa) as total_ventas,
                sum(total) as total_vendido,
                sum(igv) as total_igv,
                avg(total) as ticket_promedio
            ')
            ->where('estado', 1);

        if ($desde && $hasta) {
            $builder->where('date(fecha) >=', $desde)
                    ->where('date(fecha) <=', $hasta);
        }

        return $this->response->setJSON($builder->get()->getRowArray());
    }

    public function ventas_diarias()
    {
        if (!session()->get('login')) return $this->response->setStatusCode(403);

        $desde = $this->request->getGet('desde');
        $hasta = $this->request->getGet('hasta');

        $builder = $this->db->table('venta')
            ->select('date(fecha) as fecha, sum(total) as total')
            ->where('estado', 1)
            ->groupBy('date(fecha)')
            ->orderBy('fecha', 'asc');

        if ($desde && $hasta) {
            $builder->where('date(fecha) >=', $desde)
                    ->where('date(fecha) <=', $hasta);
        }

        return $this->response->setJSON($builder->get()->getResultArray());
    }

public function top_productos()
{
  if (!session()->get('login')) return $this->response->setStatusCode(403);

  $desde = $this->request->getGet('desde');
  $hasta = $this->request->getGet('hasta');

  $db = \Config\Database::connect();

  $sql = "
    select
      p.nombre as nombre,
      sum(dv.cantidad) as cantidad,
      sum(dv.importe) as total
    from detalle_venta dv
    join venta v on v.idventa = dv.idventa
    join producto p on p.idproducto = dv.idproducto
    where v.estado = 1
  ";

  $params = [];

  if ($desde && $hasta) {
    $sql .= " and date(v.fecha) between ? and ? ";
    $params[] = $desde;
    $params[] = $hasta;
  }

  $sql .= "
    group by p.idproducto, p.nombre
    order by total desc
    limit 10
  ";

  $rows = $db->query($sql, $params)->getResultArray();
  return $this->response->setJSON($rows);
}

public function top_clientes()
{
  if (!session()->get('login')) return $this->response->setStatusCode(403);

  $desde = $this->request->getGet('desde');
  $hasta = $this->request->getGet('hasta');

  $db = \Config\Database::connect();

  $sql = "
    select
      c.nombre as nombre,
      count(distinct v.idventa) as ventas,
      sum(v.total) as total
    from venta v
    join cliente c on c.idcliente = v.idcliente
    where v.estado = 1
  ";

  $params = [];

  if ($desde && $hasta) {
    $sql .= " and date(v.fecha) between ? and ? ";
    $params[] = $desde;
    $params[] = $hasta;
  }

  $sql .= "
    group by c.idcliente, c.nombre
    order by total desc
    limit 10
  ";

  $rows = $db->query($sql, $params)->getResultArray();
  return $this->response->setJSON($rows);
}

}
