<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Detalle de color</h3>
      </div>

      <div class="card-body">

        <div class="form-group">
          <label>Código</label>
          <input type="text" class="form-control"
                 value="<?= esc($row['codigo']) ?>" disabled>
        </div>

        <div class="form-group">
          <label>Nombre</label>
          <input type="text" class="form-control"
                 value="<?= esc($row['nombre']) ?>" disabled>
        </div>

        <div class="form-group">
          <label>Descripción</label>
          <input type="text" class="form-control"
                 value="<?= esc($row['descripcion']) ?>" disabled>
        </div>

        <div class="form-group">
          <label>Estado</label>
          <input type="text" class="form-control"
                 value="<?= ($row['estado'] == 1) ? 'Activo' : 'Inactivo' ?>" disabled>
        </div>

        <a href="<?= base_url('mantenimiento/color') ?>" class="btn btn-secondary">
          Volver
        </a>

      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
