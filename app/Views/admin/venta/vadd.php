<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4>Ventas <small class="text-muted">/ Nuevo</small></h4>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <?php foreach ((array)session()->getFlashdata('error') as $e): ?>
          <div><?= esc($e) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('ventas/store') ?>" method="post" id="formVenta">
      <?= csrf_field() ?>

      <div class="row">
        <div class="col-md-3">
          <label>Comprobante</label>
          <select name="idtipo_documento" class="form-control" required>
            <option value="">Seleccione...</option>
            <?php foreach ($tipos_documento as $t): ?>
              <option value="<?= esc($t['idtipo_documento']) ?>">
                <?= esc($t['nombre']) ?>
              </option>
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
          <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="col-md-12">
          <label>Cliente</label>
          <div class="input-group">
            <input type="hidden" name="idcliente" id="idcliente" required>
            <input type="text" class="form-control" id="clienteTexto" placeholder="Seleccione..." readonly required>
            <div class="input-group-append">
              <button type="button" class="btn btn-info" id="btnBuscarCliente">
                <i class="fa fa-search"></i> Buscar
              </button>
            </div>
          </div>
          <small class="text-muted">Se abrirá una lista para elegir cliente.</small>
        </div>
      </div>

      <hr>

      <div class="row align-items-end">
        <div class="col-md-9">
          <label>Producto</label>
          <input type="text" class="form-control" id="productoTexto" placeholder="Seleccione..." readonly>
        </div>
        <div class="col-md-3 text-right">
          <button type="button" class="btn btn-primary" id="btnBuscarProducto">
            <i class="fa fa-search"></i> Buscar
          </button>
        </div>
      </div>

      <div class="mt-3">
        <table class="table table-bordered" id="tablaDetalle">
          <thead class="bg-success">
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Imagen</th>
              <th>UM</th>
              <th>Precio Venta</th>
              <th>Stock</th>
              <th style="width:140px;">Cantidad</th>
              <th>Importe</th>
              <th style="width:60px;">X</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

      <div class="row mt-3">
        <div class="col-md-4">
          <label>Subtotal</label>
          <input type="text" name="subtotal" id="subtotal" class="form-control" value="0.00" readonly>
        </div>
        <div class="col-md-4">
          <label>IGV</label>
          <input type="text" name="igv" id="igv" class="form-control" value="0.00" readonly>
        </div>
        <div class="col-md-4">
          <label>Total</label>
          <input type="text" name="total" id="total" class="form-control" value="0.00" readonly>
        </div>
      </div>

      <input type="hidden" name="items" id="items">

      <div class="mt-3">
        <button type="submit" class="btn btn-success">
          Guardar
        </button>
        <a href="<?= base_url('ventas') ?>" class="btn btn-secondary">Volver</a>
      </div>

    </form>

  </div>
</div>

</div>
</section>

<!-- =========================
     MODAL PRODUCTOS
========================= -->
<div class="modal fade" id="modalProductos" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lista de Productos</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <table class="table table-bordered table-striped" id="tablaProductos">
          <thead>
            <tr>
              <th>Add</th>
              <th>Código</th>
              <th>Nombre</th>
              <th>Imagen</th>
              <th>Precio</th>
              <th>Stock</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- =========================
     MODAL CLIENTES
========================= -->
<div class="modal fade" id="modalClientes" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lista de Clientes</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <table class="table table-bordered table-striped" id="tablaClientes">
          <thead>
            <tr>
              <th>Elegir</th>
              <th>Código</th>
              <th>Nombre</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
let detalle = []; // items de la venta

function money(n){
  n = parseFloat(n || 0);
  return n.toFixed(2);
}

function recalcularTotales(){
  let subtotal = 0;
  detalle.forEach(it => subtotal += parseFloat(it.importe || 0));
  let igv = subtotal * 0.18;
  let total = subtotal + igv;

  $('#subtotal').val(money(subtotal));
  $('#igv').val(money(igv));
  $('#total').val(money(total));
  $('#items').val(JSON.stringify(detalle));
}

function renderDetalle(){
  const $tb = $('#tablaDetalle tbody');
  $tb.html('');

  detalle.forEach((it, idx) => {
    const row = `
      <tr>
        <td>${it.codigo}</td>
        <td>${it.nombre}</td>
        <td class="text-center">
          <a href="${it.img_url}" data-toggle="lightbox" data-title="${it.nombre}">
            <img src="${it.img_url}" class="img-thumbnail" style="max-width:60px;max-height:60px;">
          </a>
        </td>
        <td>${it.unmedida}</td>
        <td>${money(it.precio)}</td>
        <td>${it.stock}</td>
        <td>
          <input type="number" min="1" class="form-control form-control-sm cant"
                 data-idx="${idx}" value="${it.cantidad}">
        </td>
        <td>${money(it.importe)}</td>
        <td class="text-center">
          <button type="button" class="btn btn-danger btn-sm quitar" data-idx="${idx}">X</button>
        </td>
      </tr>
    `;
    $tb.append(row);
  });

  recalcularTotales();
}

function existeProducto(idproducto){
  return detalle.findIndex(x => parseInt(x.idproducto) === parseInt(idproducto));
}

$(function(){

  // abrir modal productos
  $('#btnBuscarProducto').on('click', function(){
    $('#modalProductos').modal('show');
    cargarProductos();
  });

  // abrir modal clientes
  $('#btnBuscarCliente').on('click', function(){
    $('#modalClientes').modal('show');
    cargarClientes();
  });

  // cambiar cantidad
  $(document).on('input', '.cant', function(){
    const idx = $(this).data('idx');
    let cant = parseFloat($(this).val() || 1);
    if (cant < 1) cant = 1;

    detalle[idx].cantidad = cant;
    detalle[idx].importe = cant * parseFloat(detalle[idx].precio);
    renderDetalle();
  });

  // quitar fila
  $(document).on('click', '.quitar', function(){
    const idx = $(this).data('idx');
    detalle.splice(idx, 1);
    renderDetalle();
  });

  // antes de enviar
  $('#formVenta').on('submit', function(e){
    if (detalle.length === 0){
      e.preventDefault();
      alert('Agrega al menos 1 producto.');
      return false;
    }
    $('#items').val(JSON.stringify(detalle));
  });

});

function cargarProductos(){
  $.getJSON("<?= base_url('ventas/ajax-productos') ?>", function(data){
    const $tbody = $('#tablaProductos tbody');
    $tbody.html('');

    data.forEach(p => {
      const btn = `<button type="button" class="btn btn-success btn-sm selProd"
                    data-id="${p.idproducto}"
                    data-codigo="${p.codigo}"
                    data-nombre="${p.nombre}"
                    data-img="${p.imagen}"
                    data-imgurl="${p.img_url}"
                    data-precio="${p.precio}"
                    data-stock="${p.stock}"
                    data-um="${p.unmedida}">
                    <i class="fa fa-check"></i>
                  </button>`;

      $tbody.append(`
        <tr>
          <td class="text-center">${btn}</td>
          <td>${p.codigo}</td>
          <td>${p.nombre}</td>
          <td class="text-center">
            <img src="${p.img_url}" class="img-thumbnail" style="max-width:60px;max-height:60px;">
          </td>
          <td>${money(p.precio)}</td>
          <td>${p.stock}</td>
        </tr>
      `);
    });

    // datatable (re-iniciar)
    if ($.fn.DataTable.isDataTable('#tablaProductos')) {
      $('#tablaProductos').DataTable().destroy();
    }
    $('#tablaProductos').DataTable({
      language: { url: "//cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json" }
    });
  });
}

$(document).on('click', '.selProd', function(){
  const idproducto = $(this).data('id');

  const idx = existeProducto(idproducto);
  if (idx >= 0){
    // si ya existe, sumamos 1
    detalle[idx].cantidad = parseFloat(detalle[idx].cantidad) + 1;
    detalle[idx].importe = detalle[idx].cantidad * parseFloat(detalle[idx].precio);
  } else {
    detalle.push({
      idproducto: idproducto,
      codigo: $(this).data('codigo'),
      nombre: $(this).data('nombre'),
      imagen: $(this).data('img'),
      img_url: $(this).data('imgurl'),
      unmedida: $(this).data('um'),
      precio: parseFloat($(this).data('precio')),
      stock: parseInt($(this).data('stock')),
      cantidad: 1,
      importe: parseFloat($(this).data('precio'))
    });
  }

  $('#productoTexto').val($(this).data('nombre'));
  $('#modalProductos').modal('hide');
  renderDetalle();
});

function cargarClientes(){
  $.getJSON("<?= base_url('ventas/ajax-clientes') ?>", function(data){
    const $tbody = $('#tablaClientes tbody');
    $tbody.html('');

    data.forEach(c => {
      const btn = `<button type="button" class="btn btn-success btn-sm selCli"
                    data-id="${c.idcliente}"
                    data-texto="${c.codigo} - ${c.nombre}">
                    <i class="fa fa-check"></i>
                  </button>`;

      $tbody.append(`
        <tr>
          <td class="text-center">${btn}</td>
          <td>${c.codigo}</td>
          <td>${c.nombre}</td>
        </tr>
      `);
    });

    if ($.fn.DataTable.isDataTable('#tablaClientes')) {
      $('#tablaClientes').DataTable().destroy();
    }
    $('#tablaClientes').DataTable({
      language: { url: "//cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json" }
    });
  });
}

$(document).on('click', '.selCli', function(){
  $('#idcliente').val($(this).data('id'));
  $('#clienteTexto').val($(this).data('texto'));
  $('#modalClientes').modal('hide');
});
</script>

<?= $this->include('layouts/footer') ?>

<?= $this->section('scripts') ?>
<script>
  // AQUÍ va el JS de ventas:
  // - abrir modal buscar producto
  // - abrir modal buscar cliente
  // - agregar al detalle
  // - calcular subtotal/igv/total
</script>
<?= $this->endSection() ?>
