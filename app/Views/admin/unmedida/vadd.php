<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Nueva categoría</h3>
      </div>

      <div class="card-body">

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('error') as $err): ?>
              <div><?= esc($err) ?></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('categoria/store') ?>">
          <?= csrf_field() ?>

          <div class="form-group">
            <label>Código</label>
            <input type="text" name="codigo" class="form-control"
                   value="<?= old('codigo') ?>" required>
          </div>

          <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control"
                   value="<?= old('nombre') ?>" required>
          </div>

          <div class="form-group">
            <label>Descripción</label>
            <input type="text" name="descripcion" class="form-control"
                   value="<?= old('descripcion') ?>" required>
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Guardar
          </button>

          <a class="btn btn-secondary" href="<?= base_url('categoria') ?>">
            Volver
          </a>
        </form>
      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
