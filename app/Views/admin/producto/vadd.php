<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4>Nuevo Producto</h4>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <?php foreach (session()->getFlashdata('error') as $e): ?>
          <div><?= esc($e) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('mantenimiento/producto/store') ?>" method="post" enctype="multipart/form-data">
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
        <label>Descripción</label>
        <input type="text" name="descripcion" class="form-control" value="<?= old('descripcion') ?>" required>
      </div>

      <div class="form-group">
        <label>Observación</label>
        <input type="text" name="observacion" class="form-control" value="<?= old('observacion') ?>">
      </div>

      <!-- ✅ IMAGEN REAL (Seleccionar archivo) -->
      <div class="form-group">
        <label>Imagen</label>
        <input type="file" name="imagen" class="form-control" accept="image/*">
        <small class="text-muted">Formatos recomendados: JPG/PNG</small>
      </div>

      <div class="row">
        <div class="col-md-6 form-group">
          <label>Precio</label>
          <input type="text" name="precio" class="form-control" value="<?= old('precio') ?>" required>
        </div>
        <div class="col-md-6 form-group">
          <label>Stock</label>
          <input type="number" name="stock" class="form-control" value="<?= old('stock') ?>" required>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 form-group">
          <label>Categoría</label>
          <select name="idcategoria" class="form-control" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($categorias as $c): ?>
              <option value="<?= $c['idcategoria'] ?>" <?= old('idcategoria') == $c['idcategoria'] ? 'selected' : '' ?>>
                <?= esc($c['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-4 form-group">
          <label>Marca</label>
          <select name="idmarca" class="form-control" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($marcas as $m): ?>
              <option value="<?= $m['idmarca'] ?>" <?= old('idmarca') == $m['idmarca'] ? 'selected' : '' ?>>
                <?= esc($m['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-4 form-group">
          <label>Color</label>
          <select name="idcolor" class="form-control" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($colores as $co): ?>
              <option value="<?= $co['idcolor'] ?>" <?= old('idcolor') == $co['idcolor'] ? 'selected' : '' ?>>
                <?= esc($co['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 form-group">
          <label>Tipo Material</label>
          <select name="idtipo_material" class="form-control" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($tipos_material as $tm): ?>
              <option value="<?= $tm['idtipo_material'] ?>" <?= old('idtipo_material') == $tm['idtipo_material'] ? 'selected' : '' ?>>
                <?= esc($tm['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6 form-group">
          <label>Unidad Medida</label>
          <select name="idunmedida" class="form-control" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($unmedidas as $u): ?>
              <option value="<?= $u['idunmedida'] ?>" <?= old('idunmedida') == $u['idunmedida'] ? 'selected' : '' ?>>
                <?= esc($u['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <button type="submit" class="btn btn-success">
        <i class="fa fa-save"></i> Guardar
      </button>

      <a href="<?= base_url('mantenimiento/producto') ?>" class="btn btn-secondary">
        Volver
      </a>

    </form>

  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
