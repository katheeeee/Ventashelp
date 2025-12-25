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

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">ventas por día</h3>
    </div>
    <div class="card-body" style="min-height:320px;">
      <canvas id="grafica_ventas"></canvas>
    </div>
  </div>

</div>
</section>

<script>
  window.reportes_cfg = {
    base_url: "<?= base_url() ?>",
    url_data: "<?= base_url('reportes/ventas_diarias_data') ?>"
  };
</script>

<!-- chartjs puede ir aquí sin problema -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- tu js también puede ir aquí, pero DEBE esperar a jQuery -->
<script src="<?= base_url('assets/js/reportes/ventas_diarias.js') ?>"></script>

<?= $this->include('layouts/footer') ?>
