<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<form method="post" action="<?= base_url('mantenimiento/proveedor/store') ?>">

<div class="card">
  <div class="card-header"><h5>Nuevo Proveedor</h5></div>

  <div class="card-body">

    <div class="form-group">
      <label>Código</label>
      <input type="text" name="codigo" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Nombre</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Dirección</label>
      <input type="text" name="direccion" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Teléfono</label>
      <input type="text" name="telefono" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Tipo Documento</label>
      <select name="idtipo_documeto" class="form-control" required>
        <?php foreach($tipo_documento as $t): ?>
          <option value="<?= $t['idtipo_documento'] ?>">
            <?= esc($t['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label>Tipo Cliente</label>
      <select name="idtipo_cliente" class="form-control" required>
        <?php foreach($tipo_cliente as $t): ?>
          <option value="<?= $t['idtipo_cliente'] ?>">
            <?= esc($t['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

  </div>

  <div class="card-footer">
    <button class="btn btn-primary">Guardar</button>
    <a href="<?= base_url('mantenimiento/proveedor') ?>" class="btn btn-secondary">Cancelar</a>
  </div>
</div>

</form>

</div>
</section>

<?= $this->include('layouts/footer') ?>
