<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
<div class="card-header">
  <a href="<?= base_url('mantenimiento/color/add') ?>" class="btn btn-primary btn-sm">
    <i class="fa fa-plus"></i> Nuevo
  </a>
</div>

<div class="card-body">

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<table class="table table-bordered table-striped">
<thead>
<tr>
  <th>ID</th>
  <th>Nombre</th>
  <th>Descripción</th>
  <th>Estado</th>
  <th width="120">Acciones</th>
</tr>
</thead>

<tbody>
<?php foreach ($colores as $c): ?>
<tr>
  <td><?= esc($c['idcolor']) ?></td>
  <td><?= esc($c['nombre']) ?></td>
  <td><?= esc($c['descripcion']) ?></td>
  <td>
    <?= $c['estado'] == 1
      ? '<span class="badge badge-success">Activo</span>'
      : '<span class="badge badge-danger">Inactivo</span>' ?>
  </td>
  <td>
    <a class="btn btn-info btn-sm"
       href="<?= base_url('mantenimiento/color/view/'.$c['idcolor']) ?>">
       <i class="fa fa-eye"></i>
    </a>

    <a class="btn btn-warning btn-sm"
       href="<?= base_url('mantenimiento/color/edit/'.$c['idcolor']) ?>">
       <i class="fa fa-edit"></i>
    </a>

    <a class="btn btn-danger btn-sm"
       href="<?= base_url('color/delete/'.$c['idcolor']) ?>"
       onclick="return confirm('¿Eliminar color?')">
       <i class="fa fa-trash"></i>
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
