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
      <h3 class="card-title">top 10 productos</h3>
    </div>
    <div class="card-body" style="height:420px;">
      <canvas id="grafica_top"></canvas>
    </div>
  </div>

</div>
</section>

<script>
  window.reportes_cfg = {
    url_data: "<?= base_url('reportes/top_productos_data') ?>"
  };
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url('assets/js/reportes/top_productos.js') ?>?v=<?= time() ?>"></script>

<?= $this->include('layouts/footer') ?>
