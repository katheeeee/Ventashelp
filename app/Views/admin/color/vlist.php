<?= $this->include('layouts/header') ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Colores</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="<?= base_url('dashboard') ?>">Home</a>
          </li>
          <li class="breadcrumb-item active">Colores</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">

      <div class="card-header">
        <a href="<?= base_url('mantenimiento/color/add') ?>" class="btn btn-primary btn-sm">
          <i class="fa fa-plus"></i> Nuevo
        </a>
      </div>

      <div class="card-body">

        <!-- MENSAJES -->
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('error') as $err): ?>
              <div><?= esc($err) ?></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <table id="tablaColor" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Código</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Estado</th>
              <th style="width:120px;">Acciones</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($colores as $c): ?>
              <tr>
                <td><?= esc($c['idcolor']) ?></td>
                <td><?= esc($c['codigo']) ?></td>
                <td><?= esc($c['nombre']) ?></td>
                <td><?= esc($c['descripcion']) ?></td>

                <td>
                  <?php if ($c['estado'] == 1): ?>
                    <span class="badge badge-success">Activo</span>
                  <?php else: ?>
                    <span class="badge badge-danger">Inactivo</span>
                  <?php endif; ?>
                </td>

                <td>
                  <a class="btn btn-sm btn-info"
                     href="<?= base_url('mantenimiento/color/view/'.$c['idcolor']) ?>"
                     title="Ver">
                    <i class="fa fa-eye"></i>
                  </a>

                  <a class="btn btn-sm btn-warning"
                     href="<?= base_url('mantenimiento/color/edit/'.$c['idcolor']) ?>"
                     title="Editar">
                    <i class="fa fa-pencil-alt"></i>
                  </a>

                  <a class="btn btn-sm btn-danger"
                     href="<?= base_url('color/delete/'.$c['idcolor']) ?>"
                     onclick="return confirm('¿Eliminar color?')"
                     title="Eliminar">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
