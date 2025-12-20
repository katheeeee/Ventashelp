<?= $this->extend('admin/dashboard') ?>
<?= $this->section('content') ?>

<h4>Nuevo Color</h4>

<form action="<?= base_url('ccolor/store') ?>" method="post">
    <div class="mb-2">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Descripción</label>
        <input type="text" name="descripcion" class="form-control">
    </div>

    <button class="btn btn-success">Guardar</button>
    <a href="<?= base_url('color') ?>" class="btn btn-secondary">Volver</a>
</form>

<?= $this->endSection() ?>
