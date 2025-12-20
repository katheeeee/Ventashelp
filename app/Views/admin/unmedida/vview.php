<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4>Detalle Unidad de Medida</h4>

    <table class="table table-bordered">
      <tr><th style="width:180px;">ID</th><td><?= esc($um['idunmedida']) ?></td></tr>
      <tr><th>Nombre</th><td><?= esc($um['nombre']) ?></td></tr>
      <tr><th>Descripción</th><td><?= esc($um['descripcion']) ?></td></tr>
      <tr><th>Estado</th><td><?= $um['estado']==1?'Activo':'Inactivo' ?></td></tr>
    </table>

    <a href="<?= base_url('mantenimiento/unmedida') ?>" class="btn btn-secondary">Volver</a>

  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
