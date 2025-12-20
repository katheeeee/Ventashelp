<?= $this->include('layouts/header') ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Editar Color</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="<?= base_url('dashboard') ?>">Home</a>
          </li>
          <li class="breadcrumb-item">
            <a href="<?= base_url('mantenimiento/color') ?>">Colores</a>
          </li>
          <li class="breadcrumb-item active">Editar</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-body">

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('error') as $err): ?>
              <div><?= esc($err) ?></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form action="<?= base_url('mantenimiento/color/update/'.$col['idcolor']) ?>" method="post">
          <?= csrf_field() ?>

          <div class="form-group">
            <label>Código</label>
            <input type="text" name="codigo" class="form-control"
                   value="<?= old('codigo', $col['codigo']) ?>" required>
          </div>

          <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control"
                   value="<?= old('nombre', $col['nombre']) ?>" required>
          </div>

          <div class="form-group">
            <label>Descripción</label>
            <input type="text" name="descripcion" class="form-control"
                   value="<?= old('descripcion', $col['descripcion']) ?>" required>
          </div>

          <div class="form-group">
            <label>Estado</label>
            <select name="estado" class="form-control">
              <option value="1" <?= ((int)$col['estado'] === 1) ? 'selected' : '' ?>>Activo</option>
              <option value="0" <?= ((int)$col['estado'] === 0) ? 'selected' : '' ?>>Inactivo</option>
            </select>
          </div>

          <button type="submit" class="btn btn-warning">
            <i class="fa fa-edit"></i> Actualizar
          </button>

          <a href="<?= base_url('mantenimiento/color') ?>" class="btn btn-secondary">
            Volver
          </a>
        </form>

      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
