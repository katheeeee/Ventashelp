<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Editar categoría</h3>
      </div>

      <div class="card-body">

        <!-- MENSAJE ERROR -->
        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show">
            <?php
              $errors = session()->getFlashdata('error');
              if (is_array($errors)):
                foreach ($errors as $err):
            ?>
                  <div><?= esc($err) ?></div>
            <?php
                endforeach;
              else:
                echo esc($errors);
              endif;
            ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
        <?php endif; ?>

        <!-- FORM -->
        <form method="post" action="<?= base_url('mantenimiento/categoria/update/'.$cat['idcategoria']) ?>">
          <?= csrf_field() ?>

          <div class="form-group">
            <label>Código</label>
            <input type="text"
                   name="codigo"
                   class="form-control"
                   value="<?= old('codigo', $cat['codigo'] ?? '') ?>"
                   required>
          </div>

          <div class="form-group">
            <label>Nombre</label>
            <input type="text"
                   name="nombre"
                   class="form-control"
                   value="<?= old('nombre', $cat['nombre'] ?? '') ?>"
                   required>
          </div>

          <div class="form-group">
            <label>Descripción</label>
            <input type="text"
                   name="descripcion"
                   class="form-control"
                   value="<?= old('descripcion', $cat['descripcion'] ?? '') ?>"
                   required>
          </div>

          <div class="form-group">
            <label>Estado</label>
            <select name="estado" class="form-control">
              <option value="1" <?= old('estado', $cat['estado'] ?? 1) == 1 ? 'selected' : '' ?>>Activo</option>
              <option value="0" <?= old('estado', $cat['estado'] ?? 1) == 0 ? 'selected' : '' ?>>Inactivo</option>
            </select>
          </div>

          <div class="mt-3">
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-save"></i> Actualizar
            </button>

            <a class="btn btn-secondary" href="<?= base_url('mantenimiento/categoria') ?>">
              Volver
            </a>
          </div>

        </form>

      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
