<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Login | Ventas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

  <style>
    body { background:#d8dde6; }
    .titulo { margin-bottom:25px; letter-spacing:1px; }
  </style>
</head>

<body class="hold-transition login-page">

<div class="login-box">
  <div class="text-center titulo">
    <h4>SISTEMA DE VENTAS Y<br>COMPRA</h4>
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Logeo</p>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
          <?= esc(session()->getFlashdata('error')) ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('clogeo') ?>" method="post">

        <div class="input-group mb-3">
          <input type="text" name="txtnombre" class="form-control"
                 placeholder="Usuario" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="txtpass" class="form-control"
                 placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">
          Sign In
        </button>

      </form>
    </div>
  </div>
</div>

</body>
</html>
