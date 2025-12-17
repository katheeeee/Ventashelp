<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header"><h3 class="card-title">Editar categoría</h3></div>
      <div class="card-body">
        <form method="post" action="<?= base_url('categoria/update/'.$cat['id']) ?>">
          <?= csrf_field() ?>

          <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control"
                   value="<?= esc($cat['nombre']) ?>" required>
          </div>

          <div class="form-group">
            <label>Estado</label>
            <select name="estado" class="form-control">
              <option value="1" <?= ($cat['estado'] ?? 1) == 1 ? 'selected' : '' ?>>Activo</option>
              <option value="0" <?= ($cat['estado'] ?? 1) == 0 ? 'selected' : '' ?>>Inactivo</option>
            </select>
          </div>

          <button class="btn btn-primary">Actualizar</button>
          <a class="btn btn-secondary" href="<?= base_url('categoria') ?>">Volver</a>
        </form>
      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
