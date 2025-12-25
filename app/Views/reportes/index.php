<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

  <!-- filtros -->
  <div class="row mb-3">
    <div class="col-md-3">
      <input type="date" id="desde" class="form-control">
    </div>
    <div class="col-md-3">
      <input type="date" id="hasta" class="form-control">
    </div>
    <div class="col-md-2">
      <button id="btn_filtrar" class="btn btn-primary btn-block">
        filtrar
      </button>
    </div>
  </div>

  <!-- tarjetas -->
  <div class="row text-center">
    <div class="col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h3 id="total_vendido">0.00</h3>
          <p>total vendido</p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-info">
        <div class="inner">
          <h3 id="total_ventas">0</h3>
          <p>cantidad de ventas</p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3 id="total_igv">0.00</h3>
          <p>igv total</p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3 id="ticket_promedio">0.00</h3>
          <p>ticket promedio</p>
        </div>
      </div>
    </div>
  </div>

  <!-- grafica -->
  <div class="card mt-3">
    <div class="card-header">
      <h3 class="card-title">ventas por dia</h3>
    </div>
    <div class="card-body">
      <canvas id="grafica_ventas"></canvas>
    </div>
  </div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
<script src="<?= base_url('assets/js/reportes.js') ?>"></script>
