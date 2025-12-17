<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header"><h3 class="card-title">Nueva categoría</h3></div>
      <div class="card-body">
        <form method="post" action="<?= base_url('categoria/store') ?>">
          <?= csrf_field() ?>

          <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>

          <button class="btn btn-primary">Guardar</button>
          <a class="btn btn-secondary" href="<?= base_url('categoria') ?>">Volver</a>
        </form>
      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
