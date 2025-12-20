<?= $this->extend('admin/dashboard') ?>
<?= $this->section('content') ?>

<h4>Editar Color</h4>

<form action="<?= base_url('ccolor/update/'.$registro['idcolor']) ?>" method="post">
    <div class="mb-2">
        <label>Nombre</label>
        <input type="text" name="nombre" value="<?= $registro['nombre'] ?>" class="form-control">
    </div>

    <div class="mb-2">
        <label>Descripción</label>
        <input type="text" name="descripcion" value="<?= $registro['descripcion'] ?>" class="form-control">
    </div>

    <button class="btn btn-warning">Actualizar</button>
    <a href="<?= base_url('color') ?>" class="btn btn-secondary">Volver</a>
</form>

<?= $this->endSection() ?>
