<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?= esc($title ?? 'Helpnet') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

  <style>
    .main-header.navbar { background:#2f80c0; }
    .navbar-dark .navbar-nav .nav-link,
    .navbar-dark .navbar-brand { color:#fff; }
    .main-sidebar { background:#1f2a33; }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<nav class="main-header navbar navbar-expand navbar-dark">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#">
        <i class="fas fa-bars"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="navbar-brand font-weight-bold" href="<?= base_url('admin') ?>">
        HELPNET
      </a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fas fa-user-circle"></i>
      </a>
    </li>
  </ul>
</nav>

<?= $this->include('layouts/aside') ?>

<div class="content-wrapper">
