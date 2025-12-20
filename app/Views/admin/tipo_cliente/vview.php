<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4>Detalle Tipo de Cliente</h4>

    <table class="table table-bordered">
      <tr><th>ID</th><td><?= esc($tc['idtipo_cliente']) ?></td></tr>
      <tr><th>Nombre</th><td><?= esc($tc['nombre']) ?></td></tr>
      <tr><th>Descripción</th><td><?= esc($tc['descripcion']) ?></td></tr>
      <tr><th>Estado</th><td><?= $tc['estado']==1?'Activo':'Inactivo' ?></td></tr>
    </table>

    <a href="<?= base_url('mantenimiento/tipo_cliente') ?>" class="btn btn-secondary">
      Volver
    </a>

  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
