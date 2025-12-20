<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="card">
      <div class="card-body">

        <h4>Editar Categoría</h4>

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('error') as $e): ?>
              <div><?= esc($e) ?></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form action="<?= base_url('mantenimiento/categoria/update/'.$cat['idcategoria']) ?>" method="post">
          <?= csrf_field() ?>

          <div class="form-group">
            <label>Código</label>
            <input type="text" name="codigo" class="form-control"
                   value="<?= old('codigo', $cat['codigo']) ?>" required>
          </div>

          <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control"
                   value="<?= old('nombre', $cat['nombre']) ?>" required>
          </div>

          <div class="form-group">
            <label>Descripción</label>
            <input type="text" name="descripcion" class="form-control"
                   value="<?= old('descripcion', $cat['descripcion']) ?>" required>
          </div>

          <div class="form-group">
            <label>Estado</label>
            <select name="estado" class="form-control">
              <option value="1" <?= ((int)$cat['estado'] === 1) ? 'selected' : '' ?>>Activo</option>
              <option value="0" <?= ((int)$cat['estado'] === 0) ? 'selected' : '' ?>>Inactivo</option>
            </select>
          </div>

          <button type="submit" class="btn btn-warning">
            <i class="fa fa-edit"></i> Actualizar
          </button>

          <a href="<?= base_url('mantenimiento/categoria') ?>" class="btn btn-secondary">
            Volver
          </a>
        </form>

      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
