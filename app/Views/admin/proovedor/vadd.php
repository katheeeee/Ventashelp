<form method="post" action="<?= base_url('mantenimiento/proveedor/store') ?>">
  <input name="codigo" class="form-control" required>
  <input name="nombre" class="form-control" required>
  <input name="direccion" class="form-control">
  <input name="telefono" class="form-control">

  <select name="idtipo_documeto" class="form-control">
    <?php foreach($tipos_doc as $t): ?>
      <option value="<?= $t['idtipo_documento'] ?>">
        <?= $t['nombre'] ?>
      </option>
    <?php endforeach; ?>
  </select>

  <select name="idtipo_cliente" class="form-control">
    <?php foreach($tipos_cli as $t): ?>
      <option value="<?= $t['idtipo_cliente'] ?>">
        <?= $t['nombre'] ?>
      </option>
    <?php endforeach; ?>
  </select>

  <button class="btn btn-primary mt-2">Guardar</button>
</form>
