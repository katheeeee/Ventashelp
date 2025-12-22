<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4>Nueva Venta</h4>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <?php foreach (session()->getFlashdata('error') as $e): ?>
          <div><?= esc($e) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('ventas/store') ?>" method="post">
      <?= csrf_field() ?>

      <div class="row">
        <div class="col-md-4 form-group">
          <label>Comprobante</label>
          <select name="idtipo_comprobante" id="idtipo_comprobante" class="form-control" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($comprobantes as $c): ?>
              <option value="<?= esc($c['idtipo_comprobante']) ?>">
                <?= esc($c['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-4 form-group">
          <label>Serie</label>
          <input type="text" name="serie" class="form-control" value="<?= old('serie') ?>" required>
        </div>

        <div class="col-md-4 form-group">
          <label>Fecha</label>
          <input type="text" name="fecha" class="form-control" value="<?= old('fecha', date('Y-m-d')) ?>" required>
        </div>
      </div>

      <div class="form-group">
        <label>Cliente</label>
        <select name="idcliente" id="idcliente" class="form-control" required>
          <option value="">-- Seleccione --</option>
          <?php foreach ($clientes as $cl): ?>
            <option value="<?= esc($cl['idcliente']) ?>">
              <?= esc($cl['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <hr>

      <div class="row">
        <div class="col-md-8 form-group">
          <label>Producto</label>
          <select id="selProducto" class="form-control">
            <option value="">-- Seleccione --</option>
            <?php foreach ($productos as $p): ?>
              <option value="<?= esc($p['idproducto']) ?>"
                data-codigo="<?= esc($p['codigo']) ?>"
                data-nombre="<?= esc($p['nombre']) ?>"
                data-precio="<?= esc($p['precio']) ?>"
                data-stock="<?= esc($p['stock']) ?>"
                data-imagen="<?= esc($p['imagen'] ?: 'no.jpg') ?>"
                data-um="<?= esc($p['unmedida']) ?>">
                <?= esc($p['nombre']) ?> (Stock: <?= esc($p['stock']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-2 form-group">
          <label>Cantidad</label>
          <input type="number" id="txtCantidad" class="form-control" value="1" min="1">
        </div>

        <div class="col-md-2 form-group d-flex align-items-end">
          <button type="button" id="btnAgregar" class="btn btn-primary btn-block">
            <i class="fa fa-plus"></i> Agregar
          </button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered" id="tablaDetalle">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Imagen</th>
              <th>UM</th>
              <th>Precio</th>
              <th>Stock</th>
              <th>Cant.</th>
              <th>Importe</th>
              <th>X</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

      <div class="row">
        <div class="col-md-4 form-group">
          <label>Subtotal</label>
          <input type="text" name="subtotal" id="subtotal" class="form-control" readonly value="0.00">
        </div>

        <div class="col-md-4 form-group">
          <label>IGV (18%)</label>
          <input type="text" name="igv" id="igv" class="form-control" readonly value="0.00">
        </div>

        <div class="col-md-4 form-group">
          <label>Total</label>
          <input type="text" name="total" id="total" class="form-control" readonly value="0.00">
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 form-group">
          <label>Descuento</label>
          <input type="number" step="0.01" name="descuento" id="descuento" class="form-control" value="0">
        </div>
      </div>

      <button type="submit" class="btn btn-success">
        <i class="fa fa-save"></i> Guardar Venta
      </button>

      <a href="<?= base_url('ventas') ?>" class="btn btn-secondary">
        Volver
      </a>

    </form>

  </div>
</div>

</div>
</section>

<script>
function recalcularTotales(){
  let subtotal = 0;

  $('#tablaDetalle tbody tr').each(function(){
    subtotal += parseFloat($(this).find('.txtImporte').val() || 0);
  });

  let igv = subtotal * 0.18;
  let descuento = parseFloat($('#descuento').val() || 0);
  let total = (subtotal + igv) - descuento;

  $('#subtotal').val(subtotal.toFixed(2));
  $('#igv').val(igv.toFixed(2));
  $('#total').val(total.toFixed(2));
}

function yaExisteProducto(id){
  return $('#tablaDetalle tbody input[name="idproducto[]"][value="'+id+'"]').length > 0;
}

$('#btnAgregar').on('click', function(){
  let opt = $('#selProducto option:selected');
  let id = opt.val();
  if(!id) return;

  if(yaExisteProducto(id)){
    alert('Ese producto ya fue agregado.');
    return;
  }

  let codigo = opt.data('codigo');
  let nombre = opt.data('nombre');
  let precio = parseFloat(opt.data('precio') || 0);
  let stock  = parseFloat(opt.data('stock') || 0);
  let imagen = opt.data('imagen') || 'no.jpg';
  let um     = opt.data('um') || '';

  let cantidad = parseFloat($('#txtCantidad').val() || 1);
  if(cantidad <= 0) cantidad = 1;

  let importe = precio * cantidad;

  let row = `
  <tr>
    <td>${codigo}<input type="hidden" name="idproducto[]" value="${id}"></td>
    <td>${nombre}</td>
    <td class="text-center">
      <a href="<?= base_url('uploads/productos/') ?>/${imagen}" data-toggle="lightbox" data-title="${nombre}">
        <img src="<?= base_url('uploads/productos/') ?>/${imagen}" class="img-thumbnail" style="max-width:60px;max-height:60px;">
      </a>
    </td>
    <td>${um}</td>
    <td>
      ${precio.toFixed(2)}
      <input type="hidden" name="precio[]" value="${precio.toFixed(2)}">
    </td>
    <td>${stock}</td>
    <td>
      <input type="number" step="0.01" class="form-control txtCantidad" name="cantidad[]" value="${cantidad}">
    </td>
    <td>
      <input type="text" class="form-control txtImporte" name="importe[]" readonly value="${importe.toFixed(2)}">
    </td>
    <td class="text-center">
      <button type="button" class="btn btn-danger btn-sm btnQuitar"><i class="fa fa-times"></i></button>
    </td>
  </tr>`;

  $('#tablaDetalle tbody').append(row);
  recalcularTotales();
});

$(document).on('click', '.btnQuitar', function(){
  $(this).closest('tr').remove();
  recalcularTotales();
});

$(document).on('input', '.txtCantidad', function(){
  let tr = $(this).closest('tr');
  let precio = parseFloat(tr.find('input[name="precio[]"]').val() || 0);
  let cant = parseFloat($(this).val() || 0);
  if(cant < 0) cant = 0;

  let imp = precio * cant;
  tr.find('.txtImporte').val(imp.toFixed(2));
  recalcularTotales();
});

$('#descuento').on('input', function(){
  recalcularTotales();
});
</script>

<?= $this->include('layouts/footer') ?>
