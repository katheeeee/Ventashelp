<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <?php if (session()->getFlashdata('msg_ok')): ?>
      <div class="alert alert-success"><?= esc(session()->getFlashdata('msg_ok')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('msg_error')): ?>
      <div class="alert alert-danger"><?= esc(session()->getFlashdata('msg_error')) ?></div>
    <?php endif; ?>

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">usuarios</h3>
        <a href="<?= base_url('admin/usuarios/add') ?>" class="btn btn-primary btn-sm">nuevo</a>
      </div>

      <div class="card-body">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th>id</th>
              <th>codigo</th>
              <th>nombre</th>
              <th>user</th>
              <th>rol</th>
              <th>estado</th>
              <th style="width:160px;">acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r): ?>
              <tr>
                <td><?= esc($r['idtipo_usuario']) ?></td>
                <td><?= esc($r['codigo']) ?></td>
                <td><?= esc($r['nombre'].' '.$r['apellido']) ?></td>
                <td><?= esc($r['user']) ?></td>
                <td><?= esc($r['idrol']) ?></td>
                <td>
                  <?php if ((int)$r['estado'] === 1): ?>
                    <span class="badge badge-success">activo</span>
                  <?php else: ?>
                    <span class="badge badge-danger">inactivo</span>
                  <?php endif; ?>
                </td>
                <td>
                  <a class="btn btn-warning btn-sm" href="<?= base_url('admin/usuarios/edit/'.$r['idtipo_usuario']) ?>">editar</a>
                  <a class="btn btn-secondary btn-sm" href="<?= base_url('admin/usuarios/toggle/'.$r['idtipo_usuario']) ?>">activar/desactivar</a>
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
