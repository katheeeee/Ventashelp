<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <div class="card">
      <div class="card-body">
        <h5>Nuevo Proveedor</h5>

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('error') as $err): ?>
              <div><?= esc($err) ?></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form action="<?= base_url('mantenimiento/proveedor/store') ?>" method="post">
          <?= csrf_field() ?>

          <div class="form-group">
            <label>Código</label>
            <input type="text" name="codigo" class="form-control" value="<?= old('codigo') ?>" required>
          </div>

          <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= old('nombre') ?>" required>
          </div>

          <div class="form-group">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control" value="<?= old('direccion') ?>" required>
          </div>

          <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?= old('telefono') ?>" required>
          </div>

          <div class="form-group">
            <label>Tipo Documento</label>
            <select name="idtipo_documeto" class="form-control" required>
              <option value="">-- Seleccione --</option>
              <?php foreach ($tipo_documento as $d): ?>
                <option value="<?= esc($d['idtipo_documento']) ?>"
                  <?= (old('idtipo_documeto') == $d['idtipo_documento']) ? 'selected' : '' ?>>
                  <?= esc($d['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Tipo Cliente</label>
            <select name="idtipo_cliente" class="form-control" required>
              <option value="">-- Seleccione --</option>
              <?php foreach ($tipo_cliente as $t): ?>
                <option value="<?= esc($t['idtipo_cliente']) ?>"
                  <?= (old('idtipo_cliente') == $t['idtipo_cliente']) ? 'selected' : '' ?>>
                  <?= esc($t['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <button type="submit" class="btn btn-success">
            <i class="fa fa-save"></i> Guardar
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
