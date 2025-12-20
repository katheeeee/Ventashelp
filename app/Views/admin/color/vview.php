<?= $this->extend('admin/dashboard') ?>
<?= $this->section('content') ?>

<h4 class="mb-3">Detalle Color</h4>

<div class="card">
  <div class="card-body">
    <table class="table table-bordered">
      <tr>
        <th style="width: 180px;">ID</th>
        <td><?= esc($col['idcolor']) ?></td>
      </tr>
      <tr>
        <th>Código</th>
        <td><?= esc($col['codigo']) ?></td>
      </tr>
      <tr>
        <th>Nombre</th>
        <td><?= esc($col['nombre']) ?></td>
      </tr>
      <tr>
        <th>Descripción</th>
        <td><?= esc($col['descripcion']) ?></td>
      </tr>
      <tr>
        <th>Estado</th>
        <td>
          <?php if ((int)$col['estado'] === 1): ?>
            <span class="badge bg-success">Activo</span>
          <?php else: ?>
            <span class="badge bg-danger">Inactivo</span>
          <?php endif; ?>
        </td>
      </tr>
    </table>

    <a href="<?= base_url('color') ?>" class="btn btn-secondary">Volver</a>
    <a href="<?= base_url('color/edit/'.$col['idcolor']) ?>" class="btn btn-warning">Editar</a>
  </div>
</div>

<?= $this->endSection() ?>
