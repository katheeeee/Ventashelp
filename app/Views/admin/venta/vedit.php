<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
<div class="card-body">

<form action="<?= base_url('mantenimiento/color/update/'.$col['idcolor']) ?>" method="post">
<?= csrf_field() ?>

<div class="form-group">
  <label>Nombre</label>
  <input type="text" name="nombre" class="form-control"
         value="<?= old('nombre', $col['nombre']) ?>" required>
</div>

<div class="form-group">
  <label>Descripción</label>
  <input type="text" name="descripcion" class="form-control"
         value="<?= old('descripcion', $col['descripcion']) ?>" required>
</div>

<div class="form-group">
  <label>Estado</label>
  <select name="estado" class="form-control">
    <option value="1" <?= $col['estado']==1?'selected':'' ?>>Activo</option>
    <option value="0" <?= $col['estado']==0?'selected':'' ?>>Inactivo</option>
  </select>
</div>

<button class="btn btn-warning">Actualizar</button>
<a href="<?= base_url('mantenimiento/color') ?>" class="btn btn-secondary">Volver</a>

</form>

</div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
