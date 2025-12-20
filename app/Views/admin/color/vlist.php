<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <!-- ✅ CORREGIDO: era tipo_documento -->
        <a href="<?= base_url('mantenimiento/color/add') ?>" class="btn btn-primary btn-sm">
          <i class="fa fa-plus"></i> Nuevo
        </a>
      </div>

      <div class="card-body">

        <table id="tablaColor" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Código</th>
              <th>Nombre</th>
              <th>Estado</th>
              <th width="120">Acciones</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($colores as $r): ?>
              <tr>
                <td><?= esc($r['idcolor']) ?></td>
                <td><?= esc($r['codigo']) ?></td>
                <td><?= esc($r['nombre']) ?></td>
                <td>
                  <?php if ($r['estado'] == 1): ?>
                    <span class="badge badge-success">Activo</span>
                  <?php else: ?>
                    <span class="badge badge-danger">Inactivo</span>
                  <?php endif; ?>
                </td>
                <td>
                  <a class="btn btn-info btn-sm"
                     href="<?= base_url('mantenimiento/color/view/'.$r['idcolor']) ?>"
                     title="Ver">
                    <i class="fa fa-eye"></i>
                  </a>

                  <a class="btn btn-warning btn-sm"
                     href="<?= base_url('mantenimiento/color/edit/'.$r['idcolor']) ?>"
                     title="Editar">
                    <i class="fa fa-edit"></i>
                  </a>

                  <!-- ⚠️ delete según tu patrón -->
                  <a class="btn btn-danger btn-sm"
                     href="<?= base_url('color/delete/'.$r['idcolor']) ?>"
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
