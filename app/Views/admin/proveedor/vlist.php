<?= $this->include('layouts/header') ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Proveedores</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
          <li class="breadcrumb-item active">Proveedores</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">

      <div class="card-header">
        <a href="<?= base_url('mantenimiento/proveedor/add') ?>" class="btn btn-primary btn-sm">
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

        <table id="tablaProveedor" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Código</th>
              <th>Nombre</th>
              <th>Dirección</th>
              <th>Teléfono</th>
              <th>Estado</th>
              <th style="width:120px;">Acciones</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($registros as $r): ?>
              <tr>
                <td><?= esc($r['idproveedor']) ?></td>
                <td><?= esc($r['codigo']) ?></td>
                <td><?= esc($r['nombre']) ?></td>
                <td><?= esc($r['direccion']) ?></td>
                <td><?= esc($r['telefono']) ?></td>

                <td>
                  <?php if ((int)$r['estado'] === 1): ?>
                    <span class="badge badge-success">Activo</span>
                  <?php else: ?>
                    <span class="badge badge-danger">Inactivo</span>
                  <?php endif; ?>
                </td>

                <td>
                  <a class="btn btn-sm btn-info"
                     href="<?= base_url('mantenimiento/proveedor/view/'.$r['idproveedor']) ?>"
                     title="Ver">
                    <i class="fa fa-eye"></i>
                  </a>

                  <a class="btn btn-sm btn-warning"
                     href="<?= base_url('mantenimiento/proveedor/edit/'.$r['idproveedor']) ?>"
                     title="Editar">
                    <i class="fa fa-pencil-alt"></i>
                  </a>

                  <a class="btn btn-sm btn-danger"
                     href="<?= base_url('mantenimiento/proveedor/delete/'.$r['idproveedor']) ?>"
                     onclick="return confirm('¿Eliminar proveedor?')"
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
