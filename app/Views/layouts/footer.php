  </div><!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Helpnet</strong> &copy; <?= date('Y') ?>.
  </footer>

</div><!-- /.wrapper -->

<!-- JS AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- jQuery (ya lo usa AdminLTE) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.13.8/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.jsdelivr.net/npm/datatables.net@1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.13.8/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function () {
    $('#tablaCategorias').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json"
      }
    });
  });
</script>

</body>
</html>
