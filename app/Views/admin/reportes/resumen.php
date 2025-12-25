<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

  <div class="row mb-3">
    <div class="col-md-3">
      <label>desde</label>
      <input type="date" id="desde" class="form-control">
    </div>
    <div class="col-md-3">
      <label>hasta</label>
      <input type="date" id="hasta" class="form-control">
    </div>
    <div class="col-md-2 d-flex align-items-end">
      <button id="btn_filtrar" class="btn btn-primary btn-block">filtrar</button>
    </div>
  </div>

  <!-- tarjetas -->
  <div class="row">
    <div class="col-md-3">
      <div class="small-box bg-info">
        <div class="inner">
          <h3 id="k_ventas">0</h3>
          <p>ventas</p>
        </div>
        <div class="icon"><i class="fas fa-receipt"></i></div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h3 id="k_total">S/ 0.00</h3>
          <p>total vendido</p>
        </div>
        <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3 id="k_clientes">0</h3>
          <p>clientes únicos</p>
        </div>
        <div class="icon"><i class="fas fa-users"></i></div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3 id="k_productos">0</h3>
          <p>productos vendidos</p>
        </div>
        <div class="icon"><i class="fas fa-box"></i></div>
      </div>
    </div>
  </div>

  <!-- gráfico -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">ventas por comprobante</h3>
    </div>
    <div class="card-body" style="height:360px;">
      <canvas id="donut_comprobante"></canvas>
    </div>
  </div>

</div>
</section>

<script>
  window.reportes_cfg = {
    url_data: "<?= base_url('reportes/resumen_data') ?>"
  };
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url('assets/js/reportes/resumen.js') ?>?v=<?= time() ?>"></script>

<?= $this->include('layouts/footer') ?>
