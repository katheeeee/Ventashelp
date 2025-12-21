<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4>Detalle Proveedor</h4>

    <div class="row">

      <div class="col-md-6">
        <div class="form-group">
          <label>Código</label>
          <input type="text" class="form-control"
                 value="<?= esc($proveedor['codigo']) ?>" disabled>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label>Nombre</label>
          <input type="text" class="form-control"
                 value="<?= esc($proveedor['nombre']) ?>" disabled>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label>Dirección</label>
          <input type="text" class="form-control"
                 value="<?= esc($proveedor['direccion']) ?>" disabled>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label>Teléfono</label>
          <input type="text" class="form-control"
                 value="<?= esc($proveedor['telefono']) ?>" disabled>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label>Tipo Documento</label>
          <input type="text" class="form-control"
                 value="<?= esc($proveedor['tipo_documento']) ?>" disabled>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label>Tipo Cliente</label>
          <input type="text" class="form-control"
                 value="<?= esc($proveedor['tipo_cliente']) ?>" disabled>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label>Estado</label><br>
          <?php if ($proveedor['estado'] == 1): ?>
            <span class="badge badge-success">Activo</span>
          <?php else: ?>
            <span class="badge badge-danger">Inactivo</span>
          <?php endif; ?>
        </div>
      </div>

    </div>

    <a href="<?= base_url('mantenimiento/proveedor') ?>" class="btn btn-secondary">
      <i class="fa fa-arrow-left"></i> Volver
    </a>

  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
