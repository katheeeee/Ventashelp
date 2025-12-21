<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<form method="post"
      action="<?= base_url('mantenimiento/proveedor/update/'.$proveedor['idproveedor']) ?>">

<div class="card">
  <div class="card-header"><h5>Editar Proveedor</h5></div>

  <div class="card-body">

    <div class="form-group">
      <label>Código</label>
      <input type="text" name="codigo"
             value="<?= esc($proveedor['codigo']) ?>" class="form-control">
    </div>

    <div class="form-group">
      <label>Nombre</label>
      <input type="text" name="nombre"
             value="<?= esc($proveedor['nombre']) ?>" class="form-control">
    </div>

    <div class="form-group">
      <label>Dirección</label>
      <input type="text" name="direccion"
             value="<?= esc($proveedor['direccion']) ?>" class="form-control">
    </div>

    <div class="form-group">
      <label>Teléfono</label>
      <input type="text" name="telefono"
             value="<?= esc($proveedor['telefono']) ?>" class="form-control">
    </div>

    <div class="form-group">
      <label>Estado</label>
      <select name="estado" class="form-control">
        <option value="1" <?= $proveedor['estado']==1?'selected':'' ?>>Activo</option>
        <option value="0" <?= $proveedor['estado']==0?'selected':'' ?>>Inactivo</option>
      </select>
    </div>

  </div>

  <div class="card-footer">
    <button class="btn btn-primary">Actualizar</button>
    <a href="<?= base_url('mantenimiento/proveedor') ?>" class="btn btn-secondary">Volver</a>
  </div>

</div>

</form>

</div>
</section>

<?= $this->include('layouts/footer') ?>
