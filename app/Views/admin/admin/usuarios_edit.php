<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <?php if (session()->getFlashdata('msg_error')): ?>
      <div class="alert alert-danger"><?= esc(session()->getFlashdata('msg_error')) ?></div>
    <?php endif; ?>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">editar usuario</h3>
      </div>

      <form method="post" action="<?= base_url('admin/usuarios/update/'.$row['idtipo_usuario']) ?>">
        <?= csrf_field() ?>
        <div class="card-body">

          <div class="form-group">
            <label>codigo</label>
            <input type="text" name="codigo" class="form-control" value="<?= esc($row['codigo']) ?>">
          </div>

          <div class="form-group">
            <label>nombre *</label>
            <input type="text" name="nombre" class="form-control" required value="<?= esc($row['nombre']) ?>">
          </div>

          <div class="form-group">
            <label>apellido</label>
            <input type="text" name="apellido" class="form-control" value="<?= esc($row['apellido']) ?>">
          </div>

          <div class="form-group">
            <label>telefono</label>
            <input type="text" name="telefono" class="form-control" value="<?= esc($row['telefono']) ?>">
          </div>

          <div class="form-group">
            <label>user *</label>
            <input type="text" name="user" class="form-control" required value="<?= esc($row['user']) ?>">
          </div>

          <div class="form-group">
            <label>rol</label>
            <select name="idrol" class="form-control">
              <option value="1" <?= ((int)$row['idrol']===1)?'selected':'' ?>>1</option>
              <option value="2" <?= ((int)$row['idrol']===2)?'selected':'' ?>>2</option>
            </select>
          </div>

        </div>

        <div class="card-footer">
          <button class="btn btn-primary" type="submit">guardar</button>
          <a class="btn btn-secondary" href="<?= base_url('admin/usuarios') ?>">volver</a>
        </div>
      </form>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
