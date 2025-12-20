<?= $this->extend('admin/dashboard') ?>
<?= $this->section('content') ?>

<h4 class="mb-3">Editar Color</h4>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger">
    <?php 
      $errors = session()->getFlashdata('error');
      if (is_array($errors)) {
        echo '<ul class="mb-0">';
        foreach ($errors as $e) echo "<li>{$e}</li>";
        echo '</ul>';
      } else {
        echo $errors;
      }
    ?>
  </div>
<?php endif; ?>

<div class="card">
  <div class="card-body">
    <form action="<?= base_url('color/update/'.$col['idcolor']) ?>" method="post">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label class="form-label">Código</label>
        <input type="text" name="codigo" class="form-control"
               value="<?= old('codigo', $col['codigo']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control"
               value="<?= old('nombre', $col['nombre']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Descripción</label>
        <input type="text" name="descripcion" class="form-control"
               value="<?= old('descripcion', $col['descripcion']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-control">
          <option value="1" <?= ((int)$col['estado'] === 1) ? 'selected' : '' ?>>Activo</option>
          <option value="0" <?= ((int)$col['estado'] === 0) ? 'selected' : '' ?>>Inactivo</option>
        </select>
      </div>

      <button class="btn btn-warning">Actualizar</button>
      <a href="<?= base_url('color') ?>" class="btn btn-secondary">Volver</a>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
