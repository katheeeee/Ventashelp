<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-header">
    <a href="<?= base_url('mantenimiento/proveedor/add') ?>" class="btn btn-primary btn-sm">
      <i class="fa fa-plus"></i> Nuevo
    </a>
  </div>

  <div class="card-body">

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Código</th>
          <th>Nombre</th>
          <th>Teléfono</th>
          <th>Estado</th>
          <th width="120">Acciones</th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ($proveedores as $p): ?>
        <tr>
          <td><?= $p['idproveedor'] ?></td>
          <td><?= esc($p['codigo']) ?></td>
          <td><?= esc($p['nombre']) ?></td>
          <td><?= esc($p['telefono']) ?></td>
          <td>
            <?= $p['estado']==1
              ? '<span class="badge badge-success">Activo</span>'
              : '<span class="badge badge-danger">Inactivo</span>' ?>
          </td>
          <td>
            <a class="btn btn-info btn-sm"
               href="<?= base_url('mantenimiento/proveedor/view/'.$p['idproveedor']) ?>">
               <i class="fa fa-eye"></i>
            </a>

            <a class="btn btn-warning btn-sm"
               href="<?= base_url('mantenimiento/proveedor/edit/'.$p['idproveedor']) ?>">
               <i class="fa fa-edit"></i>
            </a>

            <a class="btn btn-danger btn-sm"
               href="<?= base_url('mantenimiento/proveedor/delete/'.$p['idproveedor']) ?>"
               onclick="return confirm('¿Eliminar proveedor?')">
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
