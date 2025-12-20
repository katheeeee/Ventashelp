<?= $this->extend('admin/dashboard') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Color</h4>
  <a href="<?= base_url('color/add') ?>" class="btn btn-primary btn-sm">
    + Agregar
  </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

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
  <div class="card-body table-responsive">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Código</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Estado</th>
          <th style="width: 140px;">Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($colores)): ?>
          <?php foreach ($colores as $r): ?>
            <tr>
              <td><?= esc($r['idcolor']) ?></td>
              <td><?= esc($r['codigo']) ?></td>
              <td><?= esc($r['nombre']) ?></td>
              <td><?= esc($r['descripcion']) ?></td>
              <td>
                <?php if ((int)$r['estado'] === 1): ?>
                  <span class="badge bg-success">Activo</span>
                <?php else: ?>
                  <span class="badge bg-danger">Inactivo</span>
                <?php endif; ?>
              </td>
              <td>
                <a href="<?= base_url('color/view/'.$r['idcolor']) ?>" class="btn btn-info btn-sm">Ver</a>
                <a href="<?= base_url('color/edit/'.$r['idcolor']) ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="<?= base_url('color/delete/'.$r['idcolor']) ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('¿Seguro que deseas eliminar este color?')">
                  Eliminar
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center">No hay registros</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
