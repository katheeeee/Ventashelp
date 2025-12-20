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

        <table id="tablaMarca" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Estado</th>
              <th style="width:120px;">Acciones</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($marcas as $m): ?>
              <tr>
                <td><?= esc($m['idmarca']) ?></td>
                <td><?= esc($m['nombre']) ?></td>
                <td><?= esc($m['descripcion']) ?></td>

                <td>
                  <?php if ($m['estado'] == 1): ?>
                    <span class="badge badge-success">Activo</span>
                  <?php else: ?>
                    <span class="badge badge-danger">Inactivo</span>
                  <?php endif; ?>
                </td>

                <td>
                  <a class="btn btn-sm btn-info"
                     href="<?= base_url('mantenimiento/marca/view/'.$m['idmarca']) ?>"
                     title="Ver">
                    <i class="fa fa-eye"></i>
                  </a>

                  <a class="btn btn-sm btn-warning"
                     href="<?= base_url('mantenimiento/marca/edit/'.$m['idmarca']) ?>"
                     title="Editar">
                    <i class="fa fa-pencil-alt"></i>
                  </a>

                  <a class="btn btn-sm btn-danger"
                     href="<?= base_url('mantenimiento/marca/delete/'.$m['idmarca']) ?>"
                     onclick="return confirm('¿Eliminar marca?')"
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
