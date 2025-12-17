<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <a href="<?= base_url('admin') ?>" class="brand-link">
    <span class="brand-text font-weight-bold">HELPNET</span>
  </a>

  <div class="sidebar">

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

        <li class="nav-item">
          <a href="<?= base_url('admin') ?>" class="nav-link <?= ($active=='dashboard')?'active':'' ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

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
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Productos</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview <?= ($active=='movimientos')?'menu-open':'' ?>">
          <a href="#" class="nav-link <?= ($active=='movimientos')?'active':'' ?>">
            <i class="nav-icon fas fa-exchange-alt"></i>
            <p>
              Movimientos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview <?= ($active=='reportes')?'menu-open':'' ?>">
          <a href="#" class="nav-link <?= ($active=='reportes')?'active':'' ?>">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>
              Reportes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        </li>

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
