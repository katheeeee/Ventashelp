<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4>Detalle Cliente</h4>

    <table class="table table-bordered">
      <tr><th>ID</th><td><?= esc($cli['idcliente']) ?></td></tr>
      <tr><th>Código</th><td><?= esc($cli['codigo']) ?></td></tr>
      <tr><th>Nombre</th><td><?= esc($cli['nombre']) ?></td></tr>
      <tr><th>Dirección</th><td><?= esc($cli['direccion']) ?></td></tr>
      <tr><th>Teléfono</th><td><?= esc($cli['telefono']) ?></td></tr>
      <tr><th>Tipo Doc</th><td><?= esc($cli['idtipo_documento']) ?></td></tr>
      <tr><th>Tipo Cliente</th><td><?= esc($cli['idtipo_cliente']) ?></td></tr>
      <tr><th>Estado</th><td><?= $cli['estado']==1?'Activo':'Inactivo' ?></td></tr>
      <tr><th>Hobby</th><td><?= esc($cli['hobby']) ?></td></tr>
    </table>

    <a href="<?= base_url('mantenimiento/cliente') ?>" class="btn btn-secondary">
      Volver
    </a>

  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
