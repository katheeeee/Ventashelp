  </div><!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Helpnet</strong> &copy; <?= date('Y') ?>.
  </footer>

</div><!-- /.wrapper -->

<!-- JS AdminLTE (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<!-- DataTables (JS) -->
<script src="https://cdn.jsdelivr.net/npm/datatables.net@1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.13.8/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(function () {
    $('.datatable').each(function () {
      $(this).DataTable({
        language: {
          url: "//cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json"
        }
      });
    });
  });
</script>

<!-- Ekko Lightbox -->
<script src="<?= base_url('assets/template/plugins/ekko-lightbox/ekko-lightbox.min.js') ?>"></script>
<script>
  $(document).on('click', '[data-toggle="lightbox"]', function (event) {
    event.preventDefault();
    $(this).ekkoLightbox();
  });
</script>

<?= $this->renderSection('scripts') ?>

</body>
</html>
