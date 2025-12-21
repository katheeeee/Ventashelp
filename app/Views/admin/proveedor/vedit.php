<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="card">
      <div class="card-body">
        <h5>Editar Proveedor</h5>

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('error') as $err): ?>
              <div><?= esc($err) ?></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form action="<?= base_url('mantenimiento/proveedor/update/'.$row['idproveedor']) ?>" method="post">
          <?= csrf_field() ?>

          <div class="form-group">
            <label>Código</label>
            <input type="text" name="codigo" class="form-control"
                   value="<?= old('codigo', $row['codigo']) ?>" required>
          </div>

          <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control"
                   value="<?= old('nombre', $row['nombre']) ?>" required>
          </div>

          <div class="form-group">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control"
                   value="<?= old('direccion', $row['direccion']) ?>" required>
          </div>

          <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control"
                   value="<?= old('telefono', $row['telefono']) ?>" required>
          </div>

          <div class="form-group">
            <label>Tipo Documento</label>
            <select name="idtipo_documeto" class="form-control" required>
              <?php foreach ($tipo_documento as $d): ?>
                <option value="<?= esc($d['idtipo_documento']) ?>"
                  <?= (old('idtipo_documeto', $row['idtipo_documeto']) == $d['idtipo_documento']) ? 'selected' : '' ?>>
                  <?= esc($d['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Tipo Cliente</label>
            <select name="idtipo_cliente" class="form-control" required>
              <?php foreach ($tipo_cliente as $t): ?>
                <option value="<?= esc($t['idtipo_cliente']) ?>"
                  <?= (old('idtipo_cliente', $row['idtipo_cliente']) == $t['idtipo_cliente']) ? 'selected' : '' ?>>
                  <?= esc($t['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Estado</label>
            <select name="estado" class="form-control">
              <option value="1" <?= ((int)$row['estado'] === 1) ? 'selected' : '' ?>>Activo</option>
              <option value="0" <?= ((int)$row['estado'] === 0) ? 'selected' : '' ?>>Inactivo</option>
            </select>
          </div>

          <button type="submit" class="btn btn-warning">
            <i class="fa fa-edit"></i> Actualizar
          </button>

          <a href="<?= base_url('mantenimiento/proveedor') ?>" class="btn btn-secondary">
            Volver
          </a>

        </form>

      </div>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
