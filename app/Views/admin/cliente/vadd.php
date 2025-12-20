<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4>Nuevo Cliente</h4>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <?php foreach (session()->getFlashdata('error') as $e): ?>
          <div><?= esc($e) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('mantenimiento/cliente/store') ?>" method="post">
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
        <input type="text" name="direccion" class="form-control" value="<?= old('direccion') ?>">
      </div>

      <div class="form-group">
        <label>Teléfono</label>
        <input type="text" name="telefono" class="form-control" value="<?= old('telefono') ?>">
      </div>

      <div class="form-group">
        <label>Tipo Documento</label>
        <select name="idtipo_documento" class="form-control" required>
          <option value="">-- Seleccione --</option>
          <?php foreach ($tipos_documento as $d): ?>
            <option value="<?= esc($d['idtipo_documento']) ?>"
              <?= old('idtipo_documento') == $d['idtipo_documento'] ? 'selected' : '' ?>>
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
              <?= old('idtipo_cliente') == $t['idtipo_cliente'] ? 'selected' : '' ?>>
              <?= esc($t['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-success">
        <i class="fa fa-save"></i> Guardar
      </button>

      <a href="<?= base_url('mantenimiento/cliente') ?>" class="btn btn-secondary">
        Volver
      </a>

    </form>

  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
