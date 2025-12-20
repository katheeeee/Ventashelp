<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <a href="<?= base_url('mantenimiento/marca/add') ?>" class="btn btn-primary btn-sm">
          <i class="fa fa-plus"></i> Nuevo
        </a>
      </div>

      <div class="card-body">

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

        <table id="tablaCategorias" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Código</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Estado</th>
              <th width="140">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach (($registros ?? []) as $r): ?>
              <tr>
                <td><?= esc($r['idmarca']) ?></td>
                <td><?= esc($r['codigo']) ?></td>
                <td><?= esc($r['nombre']) ?></td>
                <td><?= esc($r['descripcion']) ?></td>
                <td>
                  <?= ($r['estado']==1)
                    ? '<span class="badge badge-success">Activo</span>'
                    : '<span class="badge badge-danger">Inactivo</span>' ?>
                </td>
                <td>
                  <a class="btn btn-info btn-sm" href="<?= base_url('mantenimiento/marca/view/'.$r['idmarca']) ?>">
                    <i class="fa fa-eye"></i>
                  </a>
                  <a class="btn btn-warning btn-sm" href="<?= base_url('mantenimiento/marca/edit/'.$r['idmarca']) ?>">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a class="btn btn-danger btn-sm"
                     href="<?= base_url('mantenimiento/marca/delete/'.$r['idmarca']) ?>"
                     onclick="return confirm('¿Eliminar?')">
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
