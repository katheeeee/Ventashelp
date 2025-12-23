<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <!-- MENSAJES -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <?= is_array(session()->getFlashdata('error'))
          ? implode('<br>', session()->getFlashdata('error'))
          : session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <div class="card">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title">
          <i class="fas fa-shopping-cart"></i> Lista de Ventas
        </h3>

        <div class="card-tools">
          <a href="<?= base_url('ventas/add') ?>" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> Nueva Venta
          </a>
        </div>
      </div>

      <div class="card-body">
        <table id="tablaVentas" class="table table-bordered table-striped table-hover">
          <thead class="bg-light">
            <tr>
              <th>#</th>
              <th>Fecha</th>
              <th>Cliente</th>
              <th>Comprobante</th>
              <th>Serie</th>
              <th>Número</th>
              <th>Total (S/)</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>

          <tbody>
            <?php if (!empty($registros)): ?>
              <?php foreach ($registros as $r): ?>
                <tr>
                  <td><?= esc($r['idventa']) ?></td>

                  <td>
                    <?= date('d/m/Y', strtotime($r['fecha'])) ?>
                  </td>

                  <td>
                    <?= esc($r['cliente'] ?? '-') ?>
                  </td>

                  <td>
                    <span class="badge badge-info">
                      <?= esc($r['comprobante'] ?? '-') ?>
                    </span>
                  </td>

                  <td><?= esc($r['serie']) ?></td>
                  <td><?= esc($r['num_documento']) ?></td>

                  <td class="text-right font-weight-bold">
                    <?= number_format($r['total'], 2) ?>
                  </td>

                  <td class="text-center">
                    <!-- VER -->
                    <a href="<?= base_url('ventas/view/' . $r['idventa']) ?>"
                       class="btn btn-info btn-sm"
                       title="Ver venta">
                      <i class="fas fa-eye"></i>
                    </a>

                    <!-- PDF / IMPRIMIR -->
                    <a href="<?= base_url('ventas/pdf/' . $r['idventa']) ?>"
                       class="btn btn-danger btn-sm"
                       target="_blank"
                       title="Comprobante PDF">
                      <i class="fas fa-file-pdf"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center text-muted">
                  No hay ventas registradas
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>

<!-- DATATABLE -->
<script>
  $(function () {
    $('#tablaVentas').DataTable({
      responsive: true,
      autoWidth: false,
      order: [[0, 'desc']],
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
      }
    });
  });
</script>
