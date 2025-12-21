<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
<div class="card-header">
  <h5>Detalle Proveedor</h5>
</div>

<div class="card-body">

<table class="table table-bordered">
  <tr>
    <th>Código</th>
    <td><?= esc($p['codigo']) ?></td>
  </tr>
  <tr>
    <th>Nombre</th>
    <td><?= esc($p['nombre']) ?></td>
  </tr>
  <tr>
    <th>Dirección</th>
    <td><?= esc($p['direccion']) ?></td>
  </tr>
  <tr>
    <th>Teléfono</th>
    <td><?= esc($p['telefono']) ?></td>
  </tr>
  <tr>
    <th>Estado</th>
    <td><?= $p['estado']==1?'Activo':'Inactivo' ?></td>
  </tr>
</table>

<a href="<?= base_url('mantenimiento/proveedor') ?>" class="btn btn-secondary">
  Volver
</a>

</div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
