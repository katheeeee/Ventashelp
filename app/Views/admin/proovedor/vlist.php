<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
<div class="card-header">
  <a href="<?= base_url('mantenimiento/proveedor/add') ?>" class="btn btn-primary btn-sm">
    <i class="fa fa-plus"></i> Nuevo
  </a>
</div>

<div class="card-body">
<table class="table table-bordered table-striped">
<thead>
<tr>
  <th>ID</th>
  <th>Código</th>
  <th>Nombre</th>
  <th>Estado</th>
  <th width="120">Acciones</th>
</tr>
</thead>

<tbody>
<?php foreach ($registros as $r): ?>
<tr>
  <td><?= $r['idproveedor'] ?></td>
  <td><?= esc($r['codigo']) ?></td>
  <td><?= esc($r['nombre']) ?></td>
  <td><?= $r['estado']==1 ? 'Activo':'Inactivo' ?></td>
  <td>
    <a class="btn btn-info btn-sm"
       href="<?= base_url('mantenimiento/proveedor/view/'.$r['idproveedor']) ?>">
       <i class="fa fa-eye"></i>
    </a>
    <a class="btn btn-warning btn-sm"
       href="<?= base_url('mantenimiento/proveedor/edit/'.$r['idproveedor']) ?>">
       <i class="fa fa-edit"></i>
    </a>
  </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
