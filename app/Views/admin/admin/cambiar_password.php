<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <?php if (session()->getFlashdata('msg_ok')): ?>
      <div class="alert alert-success">
        <?= esc(session()->getFlashdata('msg_ok')) ?>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('msg_error')): ?>
      <div class="alert alert-danger">
        <?= esc(session()->getFlashdata('msg_error')) ?>
      </div>
    <?php endif; ?>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">cambiar contraseña</h3>
      </div>

      <form method="post" action="<?= base_url('admin/cambiar_password') ?>">
        <?= csrf_field() ?>

        <div class="card-body">

          <div class="form-group">
            <label>contraseña actual</label>
            <input type="password" name="password_actual" class="form-control" required>
          </div>

          <div class="form-group">
            <label>nueva contraseña</label>
            <input type="password" name="password_nueva" class="form-control" required minlength="4">
          </div>

          <div class="form-group">
            <label>repetir nueva contraseña</label>
            <input type="password" name="password_repetir" class="form-control" required minlength="4">
          </div>

        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            guardar
          </button>
        </div>

      </form>
    </div>

  </div>
</section>

<?= $this->include('layouts/footer') ?>
