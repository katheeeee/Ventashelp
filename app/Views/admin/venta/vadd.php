<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<form id="formVenta" action="<?= base_url('ventas/store') ?>" method="post">
<?= csrf_field() ?>

<div class="card">
<div class="card-body">

<!-- ================= CABECERA ================= -->
<div class="row">
  <div class="col-md-3 form-group">
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

  <div class="col-md-3 form-group">
    <label>Serie</label>
    <input type="text" name="serie" class="form-control" required>
  </div>

  <div class="col-md-3 form-group">
    <label>Número</label>
    <input type="text" name="num_documento" class="form-control" required>
  </div>

  <div class="col-md-3 form-group">
    <label>Fecha</label>
    <input type="date" name="fecha" class="form-control"
           value="<?= date('Y-m-d') ?>" required>
  </div>
</div>

<!-- ================= CLIENTE ================= -->
<div class="row align-items-end">
  <div class="col-md-10 form-group">
    <label>Cliente</label>
    <input type="hidden" name="idcliente" id="idcliente">
    <input type="text" id="cliente_nombre" class="form-control"
           placeholder="Seleccione o busque..." readonly>
  </div>
  <div class="col-md-2 form-group">
    <button type="button" id="btnBuscarCliente"
            class="btn btn-info btn-block">
      <i class="fa fa-search"></i> Buscar
    </button>
  </div>
</div>

<!-- ================= PRODUCTO ================= -->
<div class="row align-items-end">
  <div class="col-md-10 form-group">
    <label>Producto</label>
    <input type="text" id="producto_buscar" class="form-control"
           placeholder="Buscar producto (Enter)">
  </div>
  <div class="col-md-2 form-group">
    <button type="button" id="btnBuscarProducto"
            class="btn btn-primary btn-block">
      <i class="fa fa-search"></i> Buscar
    </button>
  </div>
</div>

<!-- ================= DETALLE ================= -->
<table class="table table-bordered" id="tablaDetalle">
<thead class="bg-success text-white">
<tr>
  <th>Código</th>
  <th>Nombre</th>
  <th>Imagen</th>
  <th>UM</th>
  <th>Precio</th>
  <th>Stock</th>
  <th style="width:120px;">Cantidad</th>
  <th style="width:120px;">Importe</th>
  <th style="width:60px;">X</th>
</tr>
</thead>
<tbody></tbody>
</table>

<!-- ================= TOTALES ================= -->
<div class="row">
  <div class="col-md-4 form-group">
    <label>Subtotal</label>
    <input type="text" name="subtotal" id="subtotal"
           class="form-control" value="0.00" readonly>
  </div>

  <div class="col-md-4 form-group">
    <label>IGV (18%)</label>
    <input type="text" name="igv" id="igv"
           class="form-control" value="0.00" readonly>
  </div>

  <div class="col-md-4 form-group">
    <label>Total</label>
    <input type="text" name="total" id="total"
           class="form-control" value="0.00" readonly>
  </div>
</div>

<input type="hidden" name="items" id="items">

<button type="submit" class="btn btn-success">
  <i class="fa fa-save"></i> Guardar
</button>

<a href="<?= base_url('ventas') ?>" class="btn btn-secondary">
  Volver
</a>

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
        <h5 class="modal-title">Lista de Productos</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover"
               id="dtProductos" style="width:100%;">
          <thead>
            <tr>
              <th style="width:80px;">Add</th>
              <th>Código</th>
              <th>Nombre</th>
              <th>Imagen</th>
              <th>Precio</th>
              <th>Stock</th>
              <th>UM</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
(function(){

const IGV = 0.18;
function n(v){ return isNaN(parseFloat(v)) ? 0 : parseFloat(v); }
function f(v){ return n(v).toFixed(2); }

function calc(){
  let total = 0;
  $('#tablaDetalle tbody tr').each(function(){
    const precio = n($(this).data('precio'));
    const cant   = n($(this).find('.cantidad').val());
    const imp    = precio * cant;
    $(this).find('.importe').text(f(imp));
    total += imp;
  });
  const subtotal = total / (1 + IGV);
  const igv = total - subtotal;
  $('#subtotal').val(f(subtotal));
  $('#igv').val(f(igv));
  $('#total').val(f(total));
  buildItems();
}

function buildItems(){
  let items = [];
  $('#tablaDetalle tbody tr').each(function(){
    items.push({
      idproducto: $(this).data('id'),
      precio: $(this).data('precio'),
      cantidad: $(this).find('.cantidad').val(),
      importe: $(this).find('.importe').text()
    });
  });
  $('#items').val(JSON.stringify(items));
}

function addProducto(p){
  if ($('#tablaDetalle tr[data-id="'+p.idproducto+'"]').length){
    let c = $('#tablaDetalle tr[data-id="'+p.idproducto+'"] .cantidad');
    c.val(parseInt(c.val()) + 1);
    calc();
    return;
  }

  let tr = `
  <tr data-id="${p.idproducto}" data-precio="${p.precio}">
    <td>${p.codigo}</td>
    <td>${p.nombre}</td>
    <td class="text-center">
      <img src="${p.img_url}" class="img-thumbnail" style="max-width:60px;">
    </td>
    <td>${p.unmedida ?? ''}</td>
    <td class="text-right">${f(p.precio)}</td>
    <td class="text-right">${p.stock}</td>
    <td>
      <input type="number" min="1" value="1"
             class="form-control cantidad">
    </td>
    <td class="importe text-right">0.00</td>
    <td class="text-center">
      <button type="button"
              class="btn btn-danger btn-sm btnDel">
        <i class="fa fa-times"></i>
      </button>
    </td>
  </tr>`;
  $('#tablaDetalle tbody').append(tr);
  calc();
}

let dtProd = null;
function initDt(){
  if (dtProd) return;
  dtProd = $('#dtProductos').DataTable({
    ajax: {
      url: '<?= base_url('ventas/ajaxProductos') ?>',
      dataSrc: ''
    },
    columns: [
      { data:null, render:()=>'<button class="btn btn-success btn-sm sel">✔</button>' },
      { data:'codigo' },
      { data:'nombre' },
      { data:'img_url', render:i=>`<img src="${i}" style="max-width:60px;">` },
      { data:'precio', className:'text-right', render:f },
      { data:'stock', className:'text-right' },
      { data:'unmedida' }
    ],
    language:{ url:'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json' }
  });

  $('#dtProductos tbody').on('click','.sel',function(){
    let d = dtProd.row($(this).parents('tr')).data();
    addProducto(d);
    $('#modalProductos').modal('hide');
  });
}

$('#btnBuscarProducto').click(function(){
  $('#modalProductos').modal('show');
  setTimeout(()=>{ initDt(); dtProd.ajax.reload(); },200);
});

$(document).on('input','.cantidad',calc);
$(document).on('click','.btnDel',function(){ $(this).closest('tr').remove(); calc(); });

})();
</script>

<?= $this->include('layouts/footer') ?>
