<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Nueva categoría</h3>
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

        <!-- MENSAJE ÉXITO -->
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('mantenimiento/categoria/store') ?>">
          <?= csrf_field() ?>

          <div class="form-group">
            <label>Código</label>
            <input type="text"
                   name="codigo"
                   class="form-control"
                   value="<?= old('codigo') ?>"
                   required>
          </div>

          <div class="form-group">
            <label>Nombre</label>
            <input type="text"
                   name="nombre"
                   class="form-control"
                   value="<?= old('nombre') ?>"
                   required>
          </div>

          <div class="form-group">
            <label>Descripción</label>
            <input type="text"
                   name="descripcion"
                   class="form-control"
                   value="<?= old('descripcion') ?>"
                   required>
          </div>

          <div class="mt-3">
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-save"></i> Guardar
            </button>

            <a href="<?= base_url('mantenimiento/categoria') ?>"
               class="btn btn-secondary">
              Volver
            </a>
          </div>
        </form>

      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
