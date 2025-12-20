<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
<div class="card-body">

<table class="table table-bordered">
<tr><th>ID</th><td><?= esc($col['idcolor']) ?></td></tr>
<tr><th>Nombre</th><td><?= esc($col['nombre']) ?></td></tr>
<tr><th>Descripción</th><td><?= esc($col['descripcion']) ?></td></tr>
<tr><th>Estado</th>
<td><?= $col['estado']==1?'Activo':'Inactivo' ?></td></tr>
</table>

<a href="<?= base_url('mantenimiento/color') ?>" class="btn btn-secondary">Volver</a>
<a href="<?= base_url('mantenimiento/color/edit/'.$col['idcolor']) ?>" class="btn btn-warning">Editar</a>

</div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
