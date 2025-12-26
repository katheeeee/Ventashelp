<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="row mb-3">
      <div class="col-md-3">
        <label>desde</label>
        <input type="date" id="desde" class="form-control" value="<?= date('Y-m-01') ?>">
      </div>
      <div class="col-md-3">
        <label>hasta</label>
        <input type="date" id="hasta" class="form-control" value="<?= date('Y-m-d') ?>">
      </div>
      <div class="col-md-2">
        <label>top</label>
        <input type="number" id="limit" class="form-control" value="10" min="1" max="50">
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button id="btn_filtrar" class="btn btn-primary btn-block">filtrar</button>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <a id="btn_exportar" href="#" class="btn btn-success btn-block">exportar excel</a>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">top clientes</h3>
      </div>
      <div class="card-body" style="380px;">
        <canvas id="grafica"></canvas>
      </div>
    </div>

  </div>
</section>

<script>
  window.reportes_cfg = {
    url_data: "<?= base_url('reportes/top_clientes_data') ?>",
    url_export: "<?= base_url('reportes/export/top_clientes') ?>"
  };
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url('assets/js/reportes/top_clientes.js') ?>?v=<?= time() ?>"></script>

<?= $this->include('layouts/footer') ?>
