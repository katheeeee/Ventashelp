<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4>Nueva Unidad de Medida</h4>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <?php foreach (session()->getFlashdata('error') as $e): ?>
          <div><?= esc($e) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('mantenimiento/unmedida/store') ?>" method="post">
      <?= csrf_field() ?>

      <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" value="<?= old('nombre') ?>" required>
      </div>

      <div class="form-group">
        <label>Descripción</label>
        <input type="text" name="descripcion" class="form-control" value="<?= old('descripcion') ?>" required>
      </div>

      <button type="submit" class="btn btn-success">
        <i class="fa fa-save"></i> Guardar
      </button>

      <a href="<?= base_url('mantenimiento/unmedida') ?>" class="btn btn-secondary">
        Volver
      </a>
    </form>

  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
