<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?= esc($title ?? 'Helpnet') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- ================= ADMINLTE 3 / BOOTSTRAP 4 ================= -->
  <link rel="stylesheet" href="<?= base_url('assets/template/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/template/dist/css/adminlte.min.css') ?>">

  <!-- DataTables CSS (LOCAL que sí tienes) -->
<link rel="stylesheet" href="<?= base_url('assets/template/plugins/datatables/dataTables.bootstrap4.min.css') ?>">



  <!-- ================= EKKO LIGHTBOX ================= -->
  <link rel="stylesheet" href="<?= base_url('assets/template/plugins/ekko-lightbox/ekko-lightbox.css') ?>">

  <!-- ================= ESTILOS PROPIOS ================= -->
  <style>
    .main-header.navbar { background:#2f80c0; }
    .navbar-dark .navbar-nav .nav-link,
    .navbar-dark .navbar-brand { color:#fff; }
    .main-sidebar { background:#1f2a33; }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<!-- ================= NAVBAR ================= -->
<nav class="main-header navbar navbar-expand navbar-dark">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="navbar-brand font-weight-bold ml-2" href="<?= base_url('dashboard') ?>">
        HELPNET
      </a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-user-circle"></i>
        <span class="ml-1"><?= esc(session('user') ?? 'Usuario') ?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
          <i class="fas fa-sign-out-alt mr-2"></i> Salir
        </a>
      </div>
    </li>
  </ul>
</nav>

<!-- ================= ASIDE ================= -->
<?= $this->include('layouts/aside') ?>

<!-- ================= CONTENIDO ================= -->
<div class="content-wrapper">
