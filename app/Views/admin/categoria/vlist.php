<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
<div class="card-header"><h3>Nuevo tipo documento</h3></div>

<div class="card-body">

<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger">
<?php foreach (session('error') as $e): ?>
  <?= $e ?><br>
<?php endforeach; ?>
</div>
<?php endif; ?>

<form method="post" action="<?= base_url('tipo_documento/store') ?>">
<?= csrf_field() ?>

<div class="form-group">
<label>Código</label>
<input type="text" name="codigo" class="form-control" required>
</div>

<div class="form-group">
<label>Nombre</label>
<input type="text" name="nombre" class="form-control" required>
</div>

<div class="form-group">
<label>Descripción</label>
<input type="text" name="descripcion" class="form-control" required>
</div>

<button class="btn btn-primary">Guardar</button>
<a href="<?= base_url('tipo_documento') ?>" class="btn btn-secondary">Volver</a>

</form>
</div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
