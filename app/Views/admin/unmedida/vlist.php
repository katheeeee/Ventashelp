<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-header">
    <a href="<?= base_url('mantenimiento/unmedida/add') ?>" class="btn btn-primary btn-sm">
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

    <table id="tablaUnmedida" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Estado</th>
          <th width="120">Acciones</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($unidades as $u): ?>
          <tr>
            <td><?= esc($u['idunmedida']) ?></td>
            <td><?= esc($u['nombre']) ?></td>
            <td><?= esc($u['descripcion']) ?></td>

            <td>
              <?= $u['estado']==1
                ? '<span class="badge badge-success">Activo</span>'
                : '<span class="badge badge-danger">Inactivo</span>' ?>
            </td>

            <td>
              <a class="btn btn-info btn-sm"
                 href="<?= base_url('mantenimiento/unmedida/view/'.$u['idunmedida']) ?>"
                 title="Ver">
                 <i class="fa fa-eye"></i>
              </a>

              <a class="btn btn-warning btn-sm"
                 href="<?= base_url('mantenimiento/unmedida/edit/'.$u['idunmedida']) ?>"
                 title="Editar">
                 <i class="fa fa-edit"></i>
              </a>

              <a class="btn btn-danger btn-sm"
                 href="<?= base_url('unmedida/delete/'.$u['idunmedida']) ?>"
                 onclick="return confirm('¿Eliminar unidad de medida?')"
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
