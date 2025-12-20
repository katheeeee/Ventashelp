<?= $this->extend('admin/dashboard') ?>
<?= $this->section('content') ?>

<h4>Detalle Color</h4>

<ul class="list-group">
    <li class="list-group-item"><b>ID:</b> <?= $registro['idcolor'] ?></li>
    <li class="list-group-item"><b>Nombre:</b> <?= $registro['nombre'] ?></li>
    <li class="list-group-item"><b>Descripción:</b> <?= $registro['descripcion'] ?></li>
    <li class="list-group-item"><b>Estado:</b> <?= $registro['estado'] ?></li>
</ul>

<a href="<?= base_url('color') ?>" class="btn btn-secondary mt-3">Volver</a>

<?= $this->endSection() ?>
