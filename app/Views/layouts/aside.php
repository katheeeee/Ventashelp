<!-- MANTENIMIENTO -->
<li class="nav-item has-treeview <?= ($active=='mantenimiento')?'menu-open':'' ?>">
  <a href="#" class="nav-link <?= ($active=='mantenimiento')?'active':'' ?>">
    <i class="nav-icon fas fa-tools"></i>
    <p>
      Mantenimiento
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>

  <ul class="nav nav-treeview">

    <li class="nav-item">
      <a href="<?= base_url('mantenimiento/categoria') ?>"
         class="nav-link <?= ($subactive=='categoria')?'active':'' ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>Categorías</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="<?= base_url('mantenimiento/color') ?>"
         class="nav-link <?= ($subactive=='color')?'active':'' ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>Color</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="<?= base_url('mantenimiento/marca') ?>"
         class="nav-link <?= ($subactive=='marca')?'active':'' ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>Marca</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="<?= base_url('mantenimiento/tipo_material') ?>"
         class="nav-link <?= ($subactive=='tipo_material')?'active':'' ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>Tipo Material</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="<?= base_url('mantenimiento/unmedida') ?>"
         class="nav-link <?= ($subactive=='unmedida')?'active':'' ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>Unidad Medida</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="<?= base_url('mantenimiento/tipo_cliente') ?>"
         class="nav-link <?= ($subactive=='tipo_cliente')?'active':'' ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>Tipo Cliente</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="<?= base_url('mantenimiento/tipo_documento') ?>"
         class="nav-link <?= ($subactive=='tipo_documento')?'active':'' ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>Tipo Documento</p>
      </a>
    </li>

    <!-- ✅ NUEVO: CLIENTES -->
    <li class="nav-item">
      <a href="<?= base_url('mantenimiento/cliente') ?>"
         class="nav-link <?= ($subactive=='cliente')?'active':'' ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>Clientes</p>
      </a>
    </li>

  </ul>
</li>
