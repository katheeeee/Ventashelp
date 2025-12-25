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

  $db = \Config\Database::connect();

  // filtros
  $where = " where v.estado = 1 ";
  $params = [];

  if ($desde && $hasta) {
    $where .= " and date(v.fecha) between ? and ? ";
    $params[] = $desde;
    $params[] = $hasta;
  }

  // kpis
  $k1 = $db->query("select count(*) as ventas, ifnull(sum(v.total),0) as total, count(distinct v.idcliente) as clientes
                    from venta v $where", $params)->getRowArray();

  $k2 = $db->query("select ifnull(sum(dv.cantidad),0) as productos
                    from detalle_venta dv
                    join venta v on v.idventa = dv.idventa
                    $where", $params)->getRowArray();

  // por comprobante (usa tu tabla tipo_comprobante si existe)
  $pc = $db->query("
    select tc.nombre as nombre, ifnull(sum(v.total),0) as total
    from venta v
    join tipo_comprobante tc on tc.idtipo_comprobante = v.idtipo_comprobante
    $where
    group by tc.idtipo_comprobante, tc.nombre
    order by total desc
  ", $params)->getResultArray();

  return $this->response->setJSON([
    'kpis' => [
      'ventas' => (int)($k1['ventas'] ?? 0),
      'total' => (float)($k1['total'] ?? 0),
      'clientes' => (int)($k1['clientes'] ?? 0),
      'productos' => (int)($k2['productos'] ?? 0),
    ],
    'por_comprobante' => $pc
  ]);
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

    return $this->response->setJSON($db->query($sql, $params)->getResultArray());
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

    return $this->response->setJSON($db->query($sql, $params)->getResultArray());
}

}
