<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4 class="mb-3">Detalle del Producto</h4>

    <table class="table table-bordered">

      <tr>
        <th style="width:200px;">ID</th>
        <td><?= esc($p['idproducto']) ?></td>
      </tr>

      <tr>
        <th>Código</th>
        <td><?= esc($p['codigo']) ?></td>
      </tr>

      <tr>
        <th>Nombre</th>
        <td><?= esc($p['nombre']) ?></td>
      </tr>

      <!-- ✅ IMAGEN -->
      <tr>
        <th>Imagen</th>
        <td class="text-center">

          <?php
            $img = !empty($p['imagen']) ? $p['imagen'] : 'no.jpg';
            $img_url = base_url('uploads/productos/' . rawurlencode($img));
            $fallback = base_url('uploads/productos/no.jpg');
          ?>

          <a href="<?= $img_url ?>"
             data-toggle="lightbox"
             data-title="<?= esc($p['nombre']) ?>">

            <img src="<?= $img_url ?>"
                 class="img-thumbnail"
                 style="max-height:300px;"
                 onerror="this.onerror=null;this.src='<?= $fallback ?>';">

          </a>

        </td>
      </tr>

      <tr>
        <th>Descripción</th>
        <td><?= esc($p['descripcion']) ?></td>
      </tr>

      <tr>
        <th>Observación</th>
        <td><?= esc($p['observacion']) ?></td>
      </tr>

      <tr>
        <th>Categoría</th>
        <td><?= esc($p['categoria']) ?></td>
      </tr>

      <tr>
        <th>Marca</th>
        <td><?= esc($p['marca']) ?></td>
      </tr>

      <tr>
        <th>Color</th>
        <td><?= esc($p['color']) ?></td>
      </tr>

      <tr>
        <th>Tipo material</th>
        <td><?= esc($p['tipo_material']) ?></td>
      </tr>

      <tr>
        <th>Unidad de medida</th>
        <td><?= esc($p['unmedida']) ?></td>
      </tr>

      <tr>
        <th>Precio</th>
        <td>S/ <?= number_format($p['precio'], 2) ?></td>
      </tr>

      <tr>
        <th>Stock</th>
        <td><?= esc($p['stock']) ?></td>
      </tr>

      <tr>
        <th>Estado</th>
        <td>
          <?= ((int)$p['estado'] === 1)
              ? '<span class="badge badge-success">Activo</span>'
              : '<span class="badge badge-danger">Inactivo</span>' ?>
        </td>
      </tr>

    </table>

    <a href="<?= base_url('mantenimiento/producto') ?>" class="btn btn-secondary mt-3">
      <i class="fa fa-arrow-left"></i> Volver
    </a>

  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
