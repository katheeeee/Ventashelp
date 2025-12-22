<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Listado de Ventas</h5>
    <a href="<?= base_url('ventas/add') ?>" class="btn btn-success">
      <i class="fa fa-plus"></i> Nueva Venta
    </a>
  </div>

  <div class="card-body">
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>

    <table class="table table-bordered table-hover">
      <thead class="bg-dark text-white">
        <tr>
          <th>ID</th>
          <th>Fecha</th>
          <th>Cliente</th>
          <th>Total</th>
          <th>Estado</th>
          <th style="width:120px;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($registros as $r): ?>
          <tr>
            <td><?= esc($r['idventa']) ?></td>
            <td><?= esc($r['fecha']) ?></td>
            <td><?= esc($r['cliente'] ?? '-') ?></td>
            <td class="text-right">S/ <?= number_format($r['total'], 2) ?></td>
            <td>
              <?php if ($r['estado'] == 1): ?>
                <span class="badge badge-success">Activo</span>
              <?php else: ?>
                <span class="badge badge-danger">Anulado</span>
              <?php endif; ?>
            </td>
            <td class="text-center">
              <a href="<?= base_url('ventas/view/'.$r['idventa']) ?>" 
                 class="btn btn-info btn-sm">
                <i class="fa fa-eye"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
