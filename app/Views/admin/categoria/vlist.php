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
        <a href="<?= base_url('categoria/add') ?>" class="btn btn-primary btn-sm">
          <i class="fa fa-plus"></i> Nuevo
        </a>
      </div>

      <div class="card-body">
<table id="tablaCategorias" class="table table-bordered table-striped">
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
            <?php foreach ($categorias as $c): ?>
              <tr>
                <td><?= esc($c['idcategoria']) ?></td>
                <td><?= esc($c['nombre']) ?></td>
                <td><?= esc($c['descripcion']) ?></td>

                <td>
                  <?php if ($c['estado'] == 1): ?>
                    <span class="badge badge-success">Activo</span>
                  <?php else: ?>
                    <span class="badge badge-danger">Desactivo</span>
                  <?php endif; ?>
                </td>

                <td>
                  <a class="btn btn-sm btn-warning"
                     href="<?= base_url('categoria/edit/'.$c['idcategoria']) ?>">
                    <i class="fa fa-pencil-alt"></i>
                  </a>

                  <a class="btn btn-sm btn-danger"
                     href="<?= base_url('categoria/delete/'.$c['idcategoria']) ?>"
                     onclick="return confirm('¿Eliminar categoría?')">
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
