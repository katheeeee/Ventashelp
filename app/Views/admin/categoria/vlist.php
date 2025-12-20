<?= $this->include('layouts/header') ?>

<?php $categorias = $categorias ?? []; ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Categorías</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
          <li class="breadcrumb-item active">Categorías</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">

      <div class="card-header">
        <!-- ✅ AQUI ESTÁ EL CAMBIO -->
        <a href="<?= base_url('mantenimiento/categoria/add') ?>" class="btn btn-primary btn-sm">
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
            <?php foreach ((array) session()->getFlashdata('error') as $err): ?>
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
              <th style="width:140px;">Acciones</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($categorias as $c): ?>
              <tr>
                <td><?= esc($c['idcategoria']) ?></td>
                <td><?= esc($c['codigo']) ?></td>
                <td><?= esc($c['nombre']) ?></td>
                <td><?= esc($c['descripcion']) ?></td>

                <td>
                  <?= ($c['estado'] == 1)
                    ? '<span class="badge badge-success">Activo</span>'
                    : '<span class="badge badge-danger">Inactivo</span>' ?>
                </td>

                <td>
                  <!-- ✅ CAMBIOS EN TODOS LOS BOTONES -->
                  <a class="btn btn-sm btn-info"
                     href="<?= base_url('mantenimiento/categoria/view/'.$c['idcategoria']) ?>"
                     title="Ver">
                    <i class="fa fa-eye"></i>
                  </a>

                  <a class="btn btn-sm btn-warning"
                     href="<?= base_url('mantenimiento/categoria/edit/'.$c['idcategoria']) ?>"
                     title="Editar">
                    <i class="fa fa-pencil-alt"></i>
                  </a>

                  <a class="btn btn-sm btn-danger"
                     href="<?= base_url('mantenimiento/categoria/delete/'.$c['idcategoria']) ?>"
                     onclick="return confirm('¿Eliminar categoría?')"
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
