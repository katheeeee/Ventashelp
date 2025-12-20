<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <a href="<?= base_url('dashboard') ?>" class="brand-link">
    <span class="brand-text font-weight-bold">HELPNET</span>
  </a>
<?php
$active = $active ?? '';
$subactive = $subactive ?? '';
?>

  <div class="sidebar">

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- DASHBOARD -->
        <li class="nav-item">
          <a href="<?= base_url('dashboard') ?>" class="nav-link <?= ($active=='dashboard')?'active':'' ?>">
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

            <!-- CATEGORIA (YA FUNCIONA) -->
            <li class="nav-item">
              <a href="<?= base_url('mantenimiento/categoria') ?>" class="nav-link <?= ($subactive=='categoria')?'active':'' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Categorías</p>
              </a>
            </li>

            <!-- CLIENTES (LO CREARÁS DESPUÉS) -->
            <li class="nav-item">
              <a href="<?= base_url('mantenimiento/cliente') ?>" class="nav-link <?= ($subactive=='cliente')?'active':'' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Clientes</p>
              </a>
            </li>

            
            <!-- PRODUCTOS (LO CREARÁS DESPUÉS) -->
            <li class="nav-item">
              <a href="<?= base_url('mantenimiento/producto') ?>" class="nav-link <?= ($subactive=='producto')?'active':'' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Productos</p>
              </a>
            </li>

            <li class="nav-item">
            <a href="<?= base_url('mantenimiento/tipo_documento') ?>"
             class="nav-link <?= ($subactive=='tipo_documento')?'active':'' ?>">
                <i class="far fa-circle nav-icon"></i>
                  <p>Tipo documento</p>
                 </a>
                </li>

          </ul>
        </li>

      

        <!-- MOVIMIENTOS -->
  
<a href="<?= base_url('movimientos/boleta/1') ?>" class="nav-link">
  <i class="far fa-circle nav-icon"></i><p>Generar boleta</p>
</a>

<a href="<?= base_url('movimientos/factura/1') ?>" class="nav-link">
  <i class="far fa-circle nav-icon"></i><p>Generar factura</p>
</a>

            </p>
          </a>
        </li>

        <!-- REPORTES -->
        <li class="nav-item has-treeview <?= ($active=='reportes')?'menu-open':'' ?>">
          <a href="#" class="nav-link <?= ($active=='reportes')?'active':'' ?>">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>
              Reportes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        </li>

        <!-- ADMIN -->
        <li class="nav-item has-treeview <?= ($active=='admin')?'menu-open':'' ?>">
          <a href="#" class="nav-link <?= ($active=='admin')?'active':'' ?>">
            <i class="nav-icon fas fa-user-shield"></i>
            <p>
              Administrador
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        </li>

      </ul>
    </nav>

  </div>
</aside>
