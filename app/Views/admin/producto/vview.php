<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4 class="mb-3">detalle producto</h4>

    <table class="table table-bordered">
      <tr>
        <th style="width:220px;">id</th>
        <td><?= esc($p['idproducto']) ?></td>
      </tr>
      <tr>
        <th>código</th>
        <td><?= esc($p['codigo']) ?></td>
      </tr>
      <tr>
        <th>nombre</th>
        <td><?= esc($p['nombre']) ?></td>
      </tr>

      <tr>
        <th>imagen</th>
        <td>
          <?php
            $img = $p['imagen'] ?? 'no.jpg';
            $src = base_url('uploads/productos/' . $img);
          ?>

          <a href="<?= $src ?>" data-toggle="lightbox" data-title="<?= esc($p['nombre']) ?>">
            <img
              src="<?= $src ?>"
              class="img-thumbnail"
              style="max-height:260px;"
              onerror="this.onerror=null;this.src='<?= base_url('uploads/productos/no.jpg') ?>';"
            >
          </a>
        </td>
      </tr>

      <tr>
        <th>descripción</th>
        <td><?= esc($p['descripcion']) ?></td>
      </tr>
      <tr>
        <th>observación</th>
        <td><?= esc($p['observacion']) ?></td>
      </tr>
      <tr>
        <th>categoría</th>
        <td><?= esc($p['categoria']) ?></td>
      </tr>
      <tr>
        <th>marca</th>
        <td><?= esc($p['marca']) ?></td>
      </tr>
      <tr>
        <th>color</th>
        <td><?= esc($p['color']) ?></td>
      </tr>
      <tr>
        <th>tipo material</th>
        <td><?= esc($p['tipo_material']) ?></td>
      </tr>
      <tr>
        <th>unidad medida</th>
        <td><?= esc($p['unmedida']) ?></td>
      </tr>
      <tr>
        <th>precio</th>
        <td><?= esc($p['precio']) ?></td>
      </tr>
      <tr>
        <th>stock</th>
        <td><?= esc($p['stock']) ?></td>
      </tr>
      <tr>
        <th>estado</th>
        <td>
          <?= ((int)$p['estado'] === 1)
            ? '<span class="badge badge-success">activo</span>'
            : '<span class="badge badge-danger">inactivo</span>' ?>
        </td>
      </tr>
    </table>

    <a href="<?= base_url('mantenimiento/producto') ?>" class="btn btn-secondary">
      volver
    </a>

  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
