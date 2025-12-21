<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
<div class="card-body">

<table class="table table-bordered">
<tr><th>ID</th><td><?= esc($tm['idtipo_material']) ?></td></tr>
<tr><th>Nombre</th><td><?= esc($tm['nombre']) ?></td></tr>
<tr><th>Descripción</th><td><?= esc($tm['descripcion']) ?></td></tr>
<tr><th>Estado</th><td><?= $tm['estado']==1?'Activo':'Inactivo' ?></td></tr>
</table>

<a href="<?= base_url('mantenimiento/tipo_material') ?>" class="btn btn-secondary">Volver</a>
<a href="<?= base_url('mantenimiento/tipo_material/edit/'.$tm['idtipo_material']) ?>" class="btn btn-warning">Editar</a>

</div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
