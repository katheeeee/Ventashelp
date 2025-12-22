<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<form id="formVenta" action="<?= base_url('ventas/store') ?>" method="post">
<?= csrf_field() ?>

<div class="card">
<div class="card-body">

<div class="row">
  <div class="col-md-3">
    <label>Comprobante</label>
    <select name="idtipo_documento" class="form-control" required>
      <option value="">Seleccione...</option>
      <?php foreach ($tipos_documento as $t): ?>
        <option value="<?= $t['idtipo_documento'] ?>"><?= $t['nombre'] ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-3">
    <label>Serie</label>
    <input type="text" name="serie" class="form-control" required>
  </div>

  <div class="col-md-3">
    <label>Número</label>
    <input type="text" name="num_documento" class="form-control" required>
  </div>

  <div class="col-md-3">
    <label>Fecha</label>
    <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>">
  </div>
</div>

<hr>

<button type="button" id="btnBuscarProducto" class="btn btn-primary">
  <i class="fa fa-search"></i> Buscar Producto
</button>

<table class="table table-bordered mt-3" id="tablaDetalle">
<thead class="bg-success text-white">
<tr>
  <th>Código</th>
  <th>Nombre</th>
  <th>Precio</th>
  <th>Cantidad</th>
  <th>Importe</th>
</tr>
</thead>
<tbody></tbody>
</table>

<input type="hidden" name="items" id="items">

<button class="btn btn-success mt-2">
  <i class="fa fa-save"></i> Guardar
</button>

</div>
</div>
</form>

</div>
</section>

<!-- ================= MODAL PRODUCTOS ================= -->
<div class="modal fade" id="modalProductos">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Productos</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="dtProductos">
          <thead>
            <tr>
              <th>+</th>
              <th>Código</th>
              <th>Nombre</th>
              <th>Precio</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){

  let dt = null;

  $('#btnBuscarProducto').click(function(){
    $('#modalProductos').modal('show');

    if (!dt){
      dt = $('#dtProductos').DataTable({
        ajax: '<?= base_url('ventas/ajaxProductos') ?>',
        columns: [
          { data:null, render:()=>'<button class="btn btn-success btn-sm add">+</button>' },
          { data:'codigo' },
          { data:'nombre' },
          { data:'precio' }
        ],
        language:{ url:'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json' }
      });

      $('#dtProductos tbody').on('click','.add',function(){
        let d = dt.row($(this).parents('tr')).data();
        $('#tablaDetalle tbody').append(
          `<tr>
            <td>${d.codigo}</td>
            <td>${d.nombre}</td>
            <td>${d.precio}</td>
            <td>1</td>
            <td>${d.precio}</td>
          </tr>`
        );
        $('#modalProductos').modal('hide');
      });
    }

    dt.ajax.reload();
  });

});
</script>

<?= $this->include('layouts/footer') ?>
