<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4>Detalle Venta #<?= esc($cab['idventa']) ?></h4>

    <table class="table table-bordered">
      <tr><th>Fecha</th><td><?= esc($cab['fecha']) ?></td></tr>
      <tr><th>Comprobante</th><td><?= esc($cab['comprobante']) ?></td></tr>
      <tr><th>Serie</th><td><?= esc($cab['serie']) ?></td></tr>
      <tr><th>Cliente</th><td><?= esc($cab['cliente']) ?></td></tr>
      <tr><th>Subtotal</th><td><?= esc($cab['subtotal']) ?></td></tr>
      <tr><th>IGV</th><td><?= esc($cab['igv']) ?></td></tr>
      <tr><th>Descuento</th><td><?= esc($cab['descuento']) ?></td></tr>
      <tr><th>Total</th><td><?= esc($cab['total']) ?></td></tr>
    </table>

    <h5>Productos</h5>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Código</th>
          <th>Producto</th>
          <th>Imagen</th>
          <th>UM</th>
          <th>Precio</th>
          <th>Cantidad</th>
          <th>Importe</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($det as $d): ?>
        <?php $img = $d['imagen'] ?: 'no.jpg'; ?>
        <tr>
          <td><?= esc($d['codigo']) ?></td>
          <td><?= esc($d['nombre']) ?></td>
          <td class="text-center">
            <a href="<?= base_url('uploads/productos/'.$img) ?>" data-toggle="lightbox" data-title="<?= esc($d['nombre']) ?>">
              <img src="<?= base_url('uploads/productos/'.$img) ?>" class="img-thumbnail" style="max-width:60px;max-height:60px;">
            </a>
          </td>
          <td><?= esc($d['unmedida']) ?></td>
          <td><?= esc($d['precio']) ?></td>
          <td><?= esc($d['cantidad']) ?></td>
          <td><?= esc($d['importe']) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

    <a href="<?= base_url('ventas') ?>" class="btn btn-secondary">Volver</a>

  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
