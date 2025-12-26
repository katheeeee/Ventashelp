<?= $this->include('layouts/header') ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?= esc($pageTitle) ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
          <li class="breadcrumb-item active"><?= esc($pageSub) ?></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <!-- KPIs -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?= (int)$ventasHoy ?></h3>
            <p>Ventas de hoy</p>
          </div>
          <div class="icon"><i class="fas fa-shopping-cart"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>S/ <?= number_format((float)$ingresosHoy, 2) ?></h3>
            <p>Ingresos hoy</p>
          </div>
          <div class="icon"><i class="fas fa-coins"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3><?= (int)$ventasMes ?></h3>
            <p>Ventas del mes</p>
          </div>
          <div class="icon"><i class="far fa-calendar-alt"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>S/ <?= number_format((float)$ingresosMes, 2) ?></h3>
            <p>Ingresos del mes</p>
          </div>
          <div class="icon"><i class="fas fa-chart-line"></i></div>
        </div>
      </div>
    </div>

    <!-- Gráfica + resumen -->
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Ventas últimos <?= (int)$dias ?> días</h3>
          </div>
          <div class="card-body">
            <canvas id="chartVentas" height="110"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Resumen</h3>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <span>Clientes activos</span>
              <strong><?= (int)$clientesActivos ?></strong>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
              <span>Productos activos</span>
              <strong><?= (int)$productosActivos ?></strong>
            </div>
            <hr>
            <small class="text-muted">Ventas válidas = estado 1</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Top productos + stock bajo -->
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Top 5 productos</h3>
          </div>
          <div class="card-body p-0">
            <table class="table table-striped mb-0">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th class="text-right">Cantidad</th>
                  <th class="text-right">Importe</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($topProductos)): ?>
                  <?php foreach ($topProductos as $p): ?>
                    <tr>
                      <td><?= esc($p['nombre']) ?></td>
                      <td class="text-right"><?= (int)$p['cantidad'] ?></td>
                      <td class="text-right">S/ <?= number_format((float)$p['importe'], 2) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="3" class="text-center text-muted p-3">Sin datos</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title">Stock bajo (≤ <?= (int)$stockMin ?>)</h3>
          </div>
          <div class="card-body p-0">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th class="text-right">Stock</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($stockBajo)): ?>
                  <?php foreach ($stockBajo as $s): ?>
                    <tr>
                      <td><?= esc($s['nombre']) ?></td>
                      <td class="text-right">
                        <span class="badge badge-danger"><?= (int)$s['stock'] ?></span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="2" class="text-center text-muted p-3">Todo OK</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
  const labels = <?= json_encode($chartLabels ?? []) ?>;
  const cant   = <?= json_encode($chartCantidad ?? []) ?>;
  const tot    = <?= json_encode($chartTotal ?? []) ?>;

  const ctx = document.getElementById('chartVentas');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [
        { label: 'Cantidad de ventas', data: cant, tension: 0.3, yAxisID: 'y' },
        { label: 'Total S/', data: tot, tension: 0.3, yAxisID: 'y1' }
      ]
    },
    options: {
      responsive: true,
      interaction: { mode: 'index', intersect: false },
      scales: {
        y: { beginAtZero: true, title: { display: true, text: 'Ventas' } },
        y1:{ beginAtZero: true, position:'right', grid:{ drawOnChartArea:false }, title:{ display:true, text:'S/' } }
      }
    }
  });
</script>

<?= $this->include('layouts/footer') ?>
