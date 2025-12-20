<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="card">
      <div class="card-body">

        <h4>Detalle Marca</h4>

        <table class="table table-bordered">
          <tr>
            <th style="width:180px;">ID</th>
            <td><?= esc($mar['idmarca']) ?></td>
          </tr>
          <tr>
            <th>Nombre</th>
            <td><?= esc($mar['nombre']) ?></td>
          </tr>
          <tr>
            <th>Descripción</th>
            <td><?= esc($mar['descripcion']) ?></td>
          </tr>
          <tr>
            <th>Estado</th>
            <td>
              <?php if ((int)$mar['estado'] === 1): ?>
                <span class="badge badge-success">Activo</span>
              <?php else: ?>
                <span class="badge badge-danger">Inactivo</span>
              <?php endif; ?>
            </td>
          </tr>
        </table>

        <a href="<?= base_url('mantenimiento/marca') ?>" class="btn btn-secondary">Volver</a>
        <a href="<?= base_url('mantenimiento/marca/edit/'.$mar['idmarca']) ?>" class="btn btn-warning">Editar</a>

      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>