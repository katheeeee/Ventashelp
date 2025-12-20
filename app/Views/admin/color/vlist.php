<?= $this->extend('admin/dashboard') ?>
<?= $this->section('content') ?>

<h4>Color</h4>

<a href="<?= base_url('ccolor/add') ?>" class="btn btn-primary mb-2">+ Agregar</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($registros as $r): ?>
        <tr>
            <td><?= $r['idcolor'] ?></td>
            <td><?= $r['nombre'] ?></td>
            <td><?= $r['descripcion'] ?></td>
            <td>
                <span class="badge bg-<?= $r['estado']=='Activo'?'success':'danger' ?>">
                    <?= $r['estado'] ?>
                </span>
            </td>
            <td>
                <a href="<?= base_url('ccolor/view/'.$r['idcolor']) ?>" class="btn btn-info btn-sm">👁</a>
                <a href="<?= base_url('ccolor/edit/'.$r['idcolor']) ?>" class="btn btn-warning btn-sm">✏</a>
                <a href="<?= base_url('ccolor/delete/'.$r['idcolor']) ?>" class="btn btn-danger btn-sm">✖</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>
