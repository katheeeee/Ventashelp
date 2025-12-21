<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4>Detalle Producto</h4>

    <table class="table table-bordered">
      <tr><th>ID</th><td><?= esc($p['idproducto']) ?></td></tr>
      <tr><th>Código</th><td><?= esc($p['codigo']) ?></td></tr>
      <tr><th>Nombre</th><td><?= esc($p['nombre']) ?></td></tr>
      <tr><th>Descripción</th><td><?= esc($p['descripcion']) ?></td></tr>
      <tr><th>Observación</th><td><?= esc($p['observacion']) ?></td></tr>
      <tr><th>Categoría</th><td><?= esc($p['categoria']) ?></td></tr>
      <tr><th>Marca</th><td><?= esc($p['marca']) ?></td></tr>
      <tr><th>Color</th><td><?= esc($p['color']) ?></td></tr>
      <tr><th>Tipo Material</th><td><?= esc($p['tipo_material']) ?></td></tr>
      <tr><th>Unidad Medida</th><td><?= esc($p['unmedida']) ?></td></tr>
      <tr><th>Precio</th><td><?= esc($p['precio']) ?></td></tr>
      <tr><th>Stock</th><td><?= esc($p['stock']) ?></td></tr>
      <tr><th>Estado</th><td><?= ((int)$p['estado'] === 1) ? 'Activo' : 'Inactivo' ?></td></tr>
    </table>

    <a href="<?= base_url('mantenimiento/producto') ?>" class="btn btn-secondary">
      Volver
    </a>

  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
