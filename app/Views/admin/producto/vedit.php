<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4>Editar Producto</h4>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <?php foreach (session()->getFlashdata('error') as $e): ?>
          <div><?= esc($e) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('mantenimiento/producto/update/'.$p['idproducto']) ?>" method="post">
      <?= csrf_field() ?>

      <div class="form-group">
        <label>Código</label>
        <input type="text" name="codigo" class="form-control"
               value="<?= old('codigo', $p['codigo']) ?>" required>
      </div>

      <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control"
               value="<?= old('nombre', $p['nombre']) ?>" required>
      </div>

      <div class="form-group">
        <label>Descripción</label>
        <input type="text" name="descripcion" class="form-control"
               value="<?= old('descripcion', $p['descripcion']) ?>" required>
      </div>

      <div class="form-group">
        <label>Observación</label>
        <input type="text" name="observacion" class="form-control"
               value="<?= old('observacion', $p['observacion']) ?>">
      </div>

      <div class="form-group">
        <label>Imagen (nombre archivo o ruta)</label>
        <input type="text" name="imagen" class="form-control"
               value="<?= old('imagen', $p['imagen']) ?>">
      </div>

      <div class="row">
        <div class="col-md-6 form-group">
          <label>Precio</label>
          <input type="text" name="precio" class="form-control"
                 value="<?= old('precio', $p['precio']) ?>" required>
        </div>
        <div class="col-md-6 form-group">
          <label>Stock</label>
          <input type="number" name="stock" class="form-control"
                 value="<?= old('stock', $p['stock']) ?>" required>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 form-group">
          <label>Categoría</label>
          <select name="idcategoria" class="form-control" required>
            <?php foreach ($categorias as $c): ?>
              <option value="<?= $c['idcategoria'] ?>"
                <?= old('idcategoria', $p['idcategoria']) == $c['idcategoria'] ? 'selected' : '' ?>>
                <?= esc($c['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-4 form-group">
          <label>Marca</label>
          <select name="idmarca" class="form-control" required>
            <?php foreach ($marcas as $m): ?>
              <option value="<?= $m['idmarca'] ?>"
                <?= old('idmarca', $p['idmarca']) == $m['idmarca'] ? 'selected' : '' ?>>
                <?= esc($m['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-4 form-group">
          <label>Color</label>
          <select name="idcolor" class="form-control" required>
            <?php foreach ($colores as $co): ?>
              <option value="<?= $co['idcolor'] ?>"
                <?= old('idcolor', $p['idcolor']) == $co['idcolor'] ? 'selected' : '' ?>>
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
            <?php foreach ($tipos_material as $tm): ?>
              <option value="<?= $tm['idtipo_material'] ?>"
                <?= old('idtipo_material', $p['idtipo_material']) == $tm['idtipo_material'] ? 'selected' : '' ?>>
                <?= esc($tm['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6 form-group">
          <label>Unidad Medida</label>
          <select name="idunmedida" class="form-control" required>
            <?php foreach ($unmedidas as $u): ?>
              <option value="<?= $u['idunmedida'] ?>"
                <?= old('idunmedida', $p['idunmedida']) == $u['idunmedida'] ? 'selected' : '' ?>>
                <?= esc($u['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label>Estado</label>
        <select name="estado" class="form-control" required>
          <option value="1" <?= old('estado', $p['estado']) == 1 ? 'selected' : '' ?>>Activo</option>
          <option value="0" <?= old('estado', $p['estado']) == 0 ? 'selected' : '' ?>>Inactivo</option>
        </select>
      </div>

      <button type="submit" class="btn btn-warning">
        <i class="fa fa-edit"></i> Actualizar
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
