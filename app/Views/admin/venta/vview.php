<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-header">
    <h5>Detalle de Venta #<?= esc($cab['idventa']) ?></h5>
  </div>

  <div class="card-body">

    <div class="row mb-3">
      <div class="col-md-4"><strong>Cliente:</strong> <?= esc($cab['cliente']) ?></div>
      <div class="col-md-4"><strong>Comprobante:</strong> <?= esc($cab['tipo_documento']) ?></div>
      <div class="col-md-4"><strong>Fecha:</strong> <?= esc($cab['fecha']) ?></div>
    </div>

    <table class="table table-bordered">
      <thead class="bg-success text-white">
        <tr>
          <th>Código</th>
          <th>Producto</th>
          <th>Precio</th>
          <th>Cantidad</th>
          <th>Importe</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($det as $d): ?>
          <tr>
            <td><?= esc($d['codigo']) ?></td>
            <td><?= esc($d['nombre']) ?></td>
            <td class="text-right"><?= number_format($d['precio'], 2) ?></td>
            <td class="text-center"><?= esc($d['cantidad']) ?></td>
            <td class="text-right"><?= number_format($d['importe'], 2) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="row mt-3">
      <div class="col-md-4 offset-md-8">
        <table class="table table-bordered">
          <tr>
            <th>Subtotal</th>
            <td class="text-right"><?= number_format($cab['subtotal'], 2) ?></td>
          </tr>
          <tr>
            <th>IGV</th>
            <td class="text-right"><?= number_format($cab['igv'], 2) ?></td>
          </tr>
          <tr class="bg-dark text-white">
            <th>Total</th>
            <td class="text-right"><?= number_format($cab['total'], 2) ?></td>
          </tr>
        </table>
      </div>
    </div>

    <a href="<?= base_url('ventas') ?>" class="btn btn-secondary">
      <i class="fa fa-arrow-left"></i> Volver
    </a>

  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
