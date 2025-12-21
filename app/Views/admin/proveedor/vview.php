<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-header"><h5>Detalle Proveedor</h5></div>

  <div class="card-body">

    <p><b>Código:</b> <?= esc($proveedor['codigo']) ?></p>
    <p><b>Nombre:</b> <?= esc($proveedor['nombre']) ?></p>
    <p><b>Dirección:</b> <?= esc($proveedor['direccion']) ?></p>
    <p><b>Teléfono:</b> <?= esc($proveedor['telefono']) ?></p>
    <p><b>Estado:</b>
      <?= $proveedor['estado']==1 ? 'Activo' : 'Inactivo' ?>
    </p>

  </div>

  <div class="card-footer">
    <a href="<?= base_url('mantenimiento/proveedor') ?>" class="btn btn-secondary">Volver</a>
  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
