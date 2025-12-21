<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-header">
    <a href="<?= base_url('mantenimiento/producto/add') ?>" class="btn btn-primary btn-sm">
      <i class="fa fa-plus"></i> Nuevo
    </a>
  </div>

  <div class="card-body">

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <?php foreach (session()->getFlashdata('error') as $err): ?>
          <div><?= esc($err) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <table class="table table-bordered table-striped datatable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Código</th>
          <th>Nombre</th>
          <th>Imagen</th>
          <th>Categoría</th>
          <th>Marca</th>
          <th>Precio</th>
          <th>Stock</th>
          <th>Estado</th>
          <th width="120">Acciones</th>
        </tr>
      </thead>

      <tbody>
        <td class="text-center">
  <?php if (!empty($r['imagen'])): ?>
    <a href="<?= base_url('uploads/productos/'.$r['imagen']) ?>"
       data-toggle="lightbox"
       data-title="<?= esc($r['nombre']) ?>">
      <img src="<?= base_url('uploads/productos/'.$r['imagen']) ?>"
           class="img-thumbnail"
           style="max-width:60px; max-height:60px;">
    </a>
  <?php else: ?>
    <span class="text-muted">Sin imagen</span>
  <?php endif; ?>
</td>

      <?php foreach ($registros as $r): ?>
        <tr>
          <td><?= esc($r['idproducto']) ?></td>
          <td><?= esc($r['codigo']) ?></td>
          <td><?= esc($r['nombre']) ?></td>
          <td><?= esc($r['categoria']) ?></td>
          <td><?= esc($r['marca']) ?></td>
          <td><?= esc($r['precio']) ?></td>
          <td><?= esc($r['stock']) ?></td>
          <td>
            <?= ((int)$r['estado'] === 1)
              ? '<span class="badge badge-success">Activo</span>'
              : '<span class="badge badge-danger">Inactivo</span>' ?>
          </td>

          <td>
            <a class="btn btn-info btn-sm"
               href="<?= base_url('mantenimiento/producto/view/'.$r['idproducto']) ?>"
               title="Ver"><i class="fa fa-eye"></i></a>

            <a class="btn btn-warning btn-sm"
               href="<?= base_url('mantenimiento/producto/edit/'.$r['idproducto']) ?>"
               title="Editar"><i class="fa fa-edit"></i></a>

            <a class="btn btn-danger btn-sm"
               href="<?= base_url('mantenimiento/producto/delete/'.$r['idproducto']) ?>"
               onclick="return confirm('¿Eliminar producto?')"
               title="Eliminar"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

  </div>
</div>

</div>
</section>

<?= $this->include('layouts/footer') ?>
