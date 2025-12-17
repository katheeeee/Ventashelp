<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="m-0">Categorías</h3>
      <a href="<?= base_url('categoria/add') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nueva
      </a>
    </div>

    <div class="card">
      <div class="card-body">
        <table id="tablaCategorias" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Estado</th>
              <th width="140">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categorias as $c): ?>
              <tr>
                <td><?= esc($c['id']) ?></td>
                <td><?= esc($c['nombre']) ?></td>
                <td><?= ($c['estado'] ?? 1) ? 'Activo' : 'Inactivo' ?></td>
                <td>
                  <a class="btn btn-sm btn-warning" href="<?= base_url('categoria/edit/'.$c['id']) ?>">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a class="btn btn-sm btn-danger"
                     href="<?= base_url('categoria/delete/'.$c['id']) ?>"
                     onclick="return confirm('¿Eliminar categoría?')">
                    <i class="fas fa-trash"></i>
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
