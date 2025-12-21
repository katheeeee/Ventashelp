<?= $this->include('layouts/header') ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Nuevo Proveedor</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('mantenimiento/proveedor') ?>">Proveedores</a></li>
          <li class="breadcrumb-item active">Nuevo</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-body">

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
            <!-- OJO: tu campo en proveedor es idtipo_documeto -->
            <select name="idtipo_documeto" class="form-control" required>
              <option value="">-- Seleccione --</option>
              <?php foreach ($documentos as $d): ?>
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
              <?php foreach ($tipos_cliente as $t): ?>
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
