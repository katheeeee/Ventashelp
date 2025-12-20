<?= $this->include('layouts/header') ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Detalle Color</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="<?= base_url('dashboard') ?>">Home</a>
          </li>
          <li class="breadcrumb-item">
            <a href="<?= base_url('mantenimiento/color') ?>">Colores</a>
          </li>
          <li class="breadcrumb-item active">Detalle</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-body">

        <table class="table table-bordered">
          <tr>
            <th style="width:180px;">ID</th>
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
              <?php if ($col['estado'] == 1): ?>
                <span class="badge badge-success">Activo</span>
              <?php else: ?>
                <span class="badge badge-danger">Inactivo</span>
              <?php endif; ?>
            </td>
          </tr>
        </table>

        <a href="<?= base_url('mantenimiento/color') ?>" class="btn btn-secondary">
          Volver
        </a>

        <a href="<?= base_url('mantenimiento/color/edit/'.$col['idcolor']) ?>" class="btn btn-warning">
          Editar
        </a>

      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
