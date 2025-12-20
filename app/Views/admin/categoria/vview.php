<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Detalle de categoría</h3>
      </div>

      <div class="card-body">

        <div class="form-group">
          <label>Código</label>
          <input type="text" class="form-control"
                 value="<?= esc($cat['codigo'] ?? '') ?>" disabled>
        </div>

        <div class="form-group">
          <label>Nombre</label>
          <input type="text" class="form-control"
                 value="<?= esc($cat['nombre'] ?? '') ?>" disabled>
        </div>

        <div class="form-group">
          <label>Descripción</label>
          <input type="text" class="form-control"
                 value="<?= esc($cat['descripcion'] ?? '') ?>" disabled>
        </div>

        <div class="form-group">
          <label>Estado</label>
          <input type="text" class="form-control"
                 value="<?= (($cat['estado'] ?? 1) == 1) ? 'Activo' : 'Inactivo' ?>" disabled>
        </div>

        <div class="mt-3">
          <a href="<?= base_url('mantenimiento/categoria') ?>" class="btn btn-secondary">
            Volver
          </a>

          <!-- OPCIONAL: botón editar -->
          <?php if (!empty($cat['idcategoria'])): ?>
            <a href="<?= base_url('mantenimiento/categoria/edit/'.$cat['idcategoria']) ?>" class="btn btn-warning">
              <i class="fa fa-pencil-alt"></i> Editar
            </a>
          <?php endif; ?>
        </div>

      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
