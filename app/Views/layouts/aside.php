<?php
  $active    = $active    ?? '';
  $subactive = $subactive ?? '';
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <a href="<?= base_url('dashboard') ?>" class="brand-link">
    <span class="brand-text font-weight-bold">Katventas</span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false">

        <!-- DASHBOARD -->
        <li class="nav-item">
          <a href="<?= base_url('dashboard') ?>"
             class="nav-link <?= ($active=='dashboard')?'active':'' ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

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
                <i class="fas fa-tags nav-icon"></i>
                <p>Categorías</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('mantenimiento/color') ?>"
                 class="nav-link <?= ($subactive=='color')?'active':'' ?>">
                <i class="fas fa-palette nav-icon"></i>
                <p>Color</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('mantenimiento/marca') ?>"
                 class="nav-link <?= ($subactive=='marca')?'active':'' ?>">
                <i class="fas fa-industry nav-icon"></i>
                <p>Marca</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('mantenimiento/tipo_material') ?>"
                 class="nav-link <?= ($subactive=='tipo_material')?'active':'' ?>">
                <i class="fas fa-cubes nav-icon"></i>
                <p>Tipo de Material</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('mantenimiento/unmedida') ?>"
                 class="nav-link <?= ($subactive=='unmedida')?'active':'' ?>">
                <i class="fas fa-ruler nav-icon"></i>
                <p>Unidad Medida</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('mantenimiento/tipo_documento') ?>"
                 class="nav-link <?= ($subactive=='tipo_documento')?'active':'' ?>">
                <i class="fas fa-id-card nav-icon"></i>
                <p>Tipo Documento</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('mantenimiento/tipo_cliente') ?>"
                 class="nav-link <?= ($subactive=='tipo_cliente')?'active':'' ?>">
                <i class="fas fa-users nav-icon"></i>
                <p>Tipo de Cliente</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('mantenimiento/cliente') ?>"
                 class="nav-link <?= ($subactive=='cliente')?'active':'' ?>">
                <i class="fas fa-user nav-icon"></i>
                <p>Clientes</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('mantenimiento/proveedor') ?>"
                 class="nav-link <?= ($subactive=='proveedor')?'active':'' ?>">
                <i class="fas fa-truck nav-icon"></i>
                <p>Proveedores</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('mantenimiento/producto') ?>"
                 class="nav-link <?= ($subactive=='producto')?'active':'' ?>">
                <i class="fas fa-box nav-icon"></i>
                <p>Productos</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- VENTAS -->
        <li class="nav-item has-treeview <?= ($active=='ventas')?'menu-open':'' ?>">
          <a href="#" class="nav-link <?= ($active=='ventas')?'active':'' ?>">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>
              Ventas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('ventas/add') ?>"
                 class="nav-link <?= ($subactive=='venta_add')?'active':'' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Agregar</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('ventas') ?>"
                 class="nav-link <?= ($subactive=='venta_list')?'active':'' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Listar</p>
              </a>
            </li>
          </ul>
        </li>

<!-- reportes -->
<li class="nav-item has-treeview <?= ($active=='reportes')?'menu-open':'' ?>">
  <a href="#" class="nav-link <?= ($active=='reportes')?'active':'' ?>">
    <i class="nav-icon fas fa-chart-bar"></i>
    <p>
      reportes
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>

  <ul class="nav nav-treeview">

    <li class="nav-item">
      <a href="<?= base_url('reportes') ?>"
         class="nav-link <?= ($subactive=='resumen')?'active':'' ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>resumen</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="<?= base_url('reportes/top_productos') ?>"
         class="nav-link <?= ($subactive=='top_productos')?'active':'' ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>top productos</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="<?= base_url('reportes/top_clientes') ?>"
         class="nav-link <?= ($subactive=='top_clientes')?'active':'' ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>top clientes</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="<?= base_url('reportes/ventas_diarias') ?>"
         class="nav-link <?= ($subactive=='ventas_diarias')?'active':'' ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>ventas diarias</p>
      </a>
    </li>

  </ul>
</li>


       <!-- ===================== -->
<!-- ADMINISTRADOR -->
<!-- ===================== -->
<li class="nav-item has-treeview <?= ($active=='admin')?'menu-open':'' ?>">
  <a href="#" class="nav-link <?= ($active=='admin')?'active':'' ?>">
    <i class="nav-icon fas fa-user-shield"></i>
    <p>
      administrador
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>

  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="<?= base_url('admin/cambiar_password') ?>"
         class="nav-link <?= ($subactive=='cambiar_password')?'active':'' ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>cambiar contraseña</p>
      </a>
    </li>
  </ul>
  <li class="nav-item">
    <a href="<?= base_url('admin/usuarios') ?>"
       class="nav-link <?= ($subactive=='usuarios')?'active':'' ?>">
      <i class="far fa-circle nav-icon"></i>
      <p>usuarios</p>
    </a>
  </li>
 </ul>
 </li>



      </ul>
    </nav>
  </div>
</aside>
