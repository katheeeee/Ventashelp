<?= $this->include('layouts/header') ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Detalle Proveedor</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('mantenimiento/proveedor') ?>">Proveedores</a></li>
          <li class="breadcrumb-item active">Ver</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-body">

        <table class="table table-bordered">
          <tr><th>ID</th><td><?= esc($row['idproveedor']) ?></td></tr>
          <tr><th>Código</th><td><?= esc($row['codigo']) ?></td></tr>
          <tr><th>Nombre</th><td><?= esc($row['nombre']) ?></td></tr>
          <tr><th>Dirección</th><td><?= esc($row['direccion']) ?></td></tr>
          <tr><th>Teléfono</th><td><?= esc($row['telefono']) ?></td></tr>
          <tr><th>Tipo Documento (ID)</th><td><?= esc($row['idtipo_documeto']) ?></td></tr>
          <tr><th>Tipo Cliente (ID)</th><td><?= esc($row['idtipo_cliente']) ?></td></tr>
          <tr><th>Estado</th><td><?= ((int)$row['estado'] === 1) ? 'Activo' : 'Inactivo' ?></td></tr>
        </table>

        <a href="<?= base_url('mantenimiento/proveedor') ?>" class="btn btn-secondary">
          Volver
        </a>

      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
