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

  <div class="row">
    <div class="col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h3 id="r_total_vendido">0.00</h3>
          <p>total vendido</p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-info">
        <div class="inner">
          <h3 id="r_total_ventas">0</h3>
          <p>cantidad de ventas</p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3 id="r_total_igv">0.00</h3>
          <p>igv total</p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3 id="r_ticket_promedio">0.00</h3>
          <p>ticket promedio</p>
        </div>
      </div>
    </div>
  </div>

</div>
</section>

<script>
  window.reportes_cfg = { base_url: "<?= base_url() ?>" };
</script>

<script src="<?= base_url('assets/template/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/js/reportes/reportes.js') ?>"></script>

<?= $this->include('layouts/footer') ?>
