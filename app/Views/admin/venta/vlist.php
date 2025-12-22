<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-header">
    <a href="<?= base_url('ventas/add') ?>" class="btn btn-primary btn-sm">
      <i class="fa fa-plus"></i> Nueva Venta
    </a>
  </div>

  <div class="card-body">

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <?php foreach (session()->getFlashdata('error') as $err): ?>
          <div><?= esc($err) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <table id="tablaVentas" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Fecha</th>
          <th>Comprobante</th>
          <th>Serie</th>
          <th>Cliente</th>
          <th>Total</th>
          <th>Estado</th>
          <th width="120">Acciones</th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ($registros as $r): ?>
        <tr>
          <td><?= esc($r['idventa']) ?></td>
          <td><?= esc($r['fecha']) ?></td>
          <td><?= esc($r['comprobante']) ?></td>
          <td><?= esc($r['serie']) ?></td>
          <td><?= esc($r['cliente']) ?></td>
          <td><?= esc($r['total']) ?></td>
          <td>
            <?= ((int)$r['estado'] === 1)
              ? '<span class="badge badge-success">Activo</span>'
              : '<span class="badge badge-danger">Anulado</span>' ?>
          </td>

          <td>
            <a class="btn btn-info btn-sm"
               href="<?= base_url('ventas/view/'.$r['idventa']) ?>"
               title="Ver">
              <i class="fa fa-eye"></i>
            </a>

            <a class="btn btn-danger btn-sm"
               href="<?= base_url('ventas/delete/'.$r['idventa']) ?>"
               onclick="return confirm('¿Eliminar venta?')"
               title="Eliminar">
              <i class="fa fa-trash"></i>
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

<script>
  $(function () {
    if ($('#tablaVentas').length) {
      $('#tablaVentas').DataTable({
        language: { url: "//cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json" }
      });
    }
  });
</script>

<?= $this->include('layouts/footer') ?>
