<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <div class="d-flex align-items-center mb-3">
      <h4 class="mb-0 mr-2">Ventas</h4>
      <span class="text-muted">Nuevo</span>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <?php foreach (session()->getFlashdata('error') as $e): ?>
          <div><?= esc($e) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('ventas/store') ?>" method="post" id="formVenta">
      <?= csrf_field() ?>

      <!-- FILA 1: Comprobante - Serie - Número - Fecha -->
      <div class="row">
        <div class="col-md-4 form-group">
          <label>Comprobante</label>
          <select name="idtipo_comprobante" id="idtipo_comprobante" class="form-control" required>
            <option value="">Seleccione...</option>
            <?php foreach ($comprobantes as $c): ?>
              <option value="<?= esc($c['idtipo_comprobante']) ?>">
                <?= esc($c['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-3 form-group">
          <label>Serie:</label>
          <input type="text" name="serie" id="serie" class="form-control" value="<?= old('serie') ?>">
        </div>

        <div class="col-md-3 form-group">
          <label>Número:</label>
          <input type="text" name="numero" id="numero" class="form-control" value="<?= old('numero') ?>">
        </div>

        <div class="col-md-2 form-group">
          <label>Fecha:</label>
          <input type="text" name="fecha" id="fecha" class="form-control" value="<?= old('fecha', date('d/m/Y')) ?>" required>
        </div>
      </div>

      <!-- FILA 2: Cliente (full) -->
      <div class="form-group">
        <label>Cliente:</label>
        <select name="idcliente" id="idcliente" class="form-control" required>
          <option value="">Seleccione...</option>
          <?php foreach ($clientes as $cl): ?>
            <option value="<?= esc($cl['idcliente']) ?>">
              <?= esc($cl['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <hr>

      <!-- FILA 3: Producto + Botones -->
      <div class="row">
        <div class="col-md-8 form-group">
          <label>Producto:</label>
          <select id="selProducto" class="form-control">
            <option value="">Seleccione...</option>
            <?php foreach ($productos as $p): ?>
              <?php
                $img = $p['imagen'] ?: 'no.jpg';
                $um  = $p['unmedida'] ?? '';
              ?>
              <option value="<?= esc($p['idproducto']) ?>"
                data-codigo="<?= esc($p['codigo']) ?>"
                data-nombre="<?= esc($p['nombre']) ?>"
                data-precio="<?= esc($p['precio']) ?>"
                data-stock="<?= esc($p['stock']) ?>"
                data-imagen="<?= esc($img) ?>"
                data-um="<?= esc($um) ?>">
                <?= esc($p['nombre']) ?> (Stock: <?= esc($p['stock']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-4 form-group d-flex align-items-end justify-content-end">
          <button type="button" id="btnAgregar" class="btn btn-info mr-2" style="min-width:140px;">
            <i class="fa fa-plus"></i> Agregar
          </button>

          <button type="button" id="btnBuscar" class="btn btn-primary" style="min-width:140px;">
            <i class="fa fa-search"></i> Buscar
          </button>
        </div>
      </div>

      <!-- TABLA DETALLE (verde como captura) -->
      <div class="table-responsive">
        <table class="table table-bordered" id="tablaDetalle" style="min-width: 900px;">
          <thead style="background:#0b8f62;color:#fff;">
            <tr>
              <th style="width:110px;">Código</th>
              <th>Nombre</th>
              <th style="width:110px;">Imagen</th>
              <th style="width:80px;">UM</th>
              <th style="width:120px;">Precio Venta</th>
              <th style="width:90px;">Stock</th>
              <th style="width:120px;">Cantidad</th>
              <th style="width:120px;">Importe</th>
              <th style="width:60px;">X</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

      <!-- TOTALES (igual a captura) -->
      <div class="row mt-2">
        <div class="col-md-4 form-group">
          <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">Subtotal:</span></div>
            <input type="text" name="subtotal" id="subtotal" class="form-control" readonly value="0.00">
          </div>
        </div>

        <div class="col-md-4 form-group">
          <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">IGV:</span></div>
            <input type="text" name="igv" id="igv" class="form-control" readonly value="0.00">
          </div>
        </div>

        <div class="col-md-4 form-group">
          <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">Total:</span></div>
            <input type="text" name="total" id="total" class="form-control" readonly value="0.00">
          </div>
        </div>
      </div>

      <!-- BOTÓN GUARDAR (verde como captura) -->
      <button type="submit" class="btn btn-success" style="background:#0b8f62;border-color:#0b8f62;">
        Guardar
      </button>

      <a href="<?= base_url('ventas') ?>" class="btn btn-secondary ml-2">
        Volver
      </a>

    </form>

  </div>
</div>

</div>
</section>

<!-- MODAL BUSCAR (simple, para que sea igual al botón Buscar) -->
<div class="modal fade" id="modalBuscarProducto" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buscar Producto</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="text" id="filtroProducto" class="form-control mb-2" placeholder="Escribe para filtrar...">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="tablaBuscar">
            <thead>
              <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($productos as $p): ?>
                <?php $img = $p['imagen'] ?: 'no.jpg'; ?>
                <tr
                  data-id="<?= esc($p['idproducto']) ?>"
                  data-codigo="<?= esc($p['codigo']) ?>"
                  data-nombre="<?= esc($p['nombre']) ?>"
                  data-precio="<?= esc($p['precio']) ?>"
                  data-stock="<?= esc($p['stock']) ?>"
                  data-imagen="<?= esc($img) ?>"
                  data-um="<?= esc($p['unmedida'] ?? '') ?>"
                >
                  <td><?= esc($p['idproducto']) ?></td>
                  <td><?= esc($p['codigo']) ?></td>
                  <td><?= esc($p['nombre']) ?></td>
                  <td><?= esc($p['precio']) ?></td>
                  <td><?= esc($p['stock']) ?></td>
                  <td>
                    <button type="button" class="btn btn-info btn-sm btnPick">Elegir</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function f2(n){ return (parseFloat(n||0)).toFixed(2); }

function recalcularTotales(){
  let subtotal = 0;
  $('#tablaDetalle tbody tr').each(function(){
    subtotal += parseFloat($(this).find('.txtImporte').val() || 0);
  });
  let igv = subtotal * 0.18;
  let total = subtotal + igv;

  $('#subtotal').val(f2(subtotal));
  $('#igv').val(f2(igv));
  $('#total').val(f2(total));
}

function existeProducto(id){
  return $('#tablaDetalle tbody input[name="idproducto[]"][value="'+id+'"]').length > 0;
}

function agregarFilaProducto(data){
  if(!data.id) return;

  if(existeProducto(data.id)){
    alert('Ese producto ya fue agregado.');
    return;
  }

  let cant = 1;
  let imp = parseFloat(data.precio||0) * cant;

  let row = `
  <tr>
    <td>
      ${data.codigo}
      <input type="hidden" name="idproducto[]" value="${data.id}">
    </td>

    <td>${data.nombre}</td>

    <td class="text-center">
      <a href="<?= base_url('uploads/productos/') ?>/${data.imagen}"
         data-toggle="lightbox" data-title="${data.nombre}">
        <img src="<?= base_url('uploads/productos/') ?>/${data.imagen}"
             class="img-thumbnail" style="max-width:70px;max-height:70px;">
      </a>
    </td>

    <td>${data.um}</td>

    <td>
      ${f2(data.precio)}
      <input type="hidden" name="precio[]" value="${f2(data.precio)}">
    </td>

    <td>${data.stock}</td>

    <td>
      <input type="number" min="1" step="1"
        class="form-control txtCantidad" name="cantidad[]" value="${cant}">
    </td>

    <td>
      <input type="text" class="form-control txtImporte" name="importe[]" readonly value="${f2(imp)}">
    </td>

    <td class="text-center">
      <button type="button" class="btn btn-danger btn-sm btnQuitar">
        <i class="fa fa-times"></i>
      </button>
    </td>
  </tr>
  `;

  $('#tablaDetalle tbody').append(row);
  recalcularTotales();
}

$('#btnAgregar').on('click', function(){
  let opt = $('#selProducto option:selected');
  let id = opt.val();
  if(!id) return;

  agregarFilaProducto({
    id: id,
    codigo: opt.data('codigo'),
    nombre: opt.data('nombre'),
    precio: opt.data('precio'),
    stock: opt.data('stock'),
    imagen: opt.data('imagen') || 'no.jpg',
    um: opt.data('um') || ''
  });
});

$(document).on('input', '.txtCantidad', function(){
  let tr = $(this).closest('tr');
  let precio = parseFloat(tr.find('input[name="precio[]"]').val() || 0);
  let cant = parseFloat($(this).val() || 1);
  if(cant < 1) cant = 1;
  $(this).val(cant);

  let imp = precio * cant;
  tr.find('.txtImporte').val(f2(imp));
  recalcularTotales();
});

$(document).on('click', '.btnQuitar', function(){
  $(this).closest('tr').remove();
  recalcularTotales();
});

// Botón Buscar => abre modal
$('#btnBuscar').on('click', function(){
  $('#modalBuscarProducto').modal('show');
});

// Filtro del modal buscar
$('#filtroProducto').on('keyup', function(){
  let v = $(this).val().toLowerCase();
  $('#tablaBuscar tbody tr').each(function(){
    let text = $(this).text().toLowerCase();
    $(this).toggle(text.indexOf(v) !== -1);
  });
});

// Elegir desde modal
$(document).on('click', '.btnPick', function(){
  let tr = $(this).closest('tr');
  agregarFilaProducto({
    id: tr.data('id'),
    codigo: tr.data('codigo'),
    nombre: tr.data('nombre'),
    precio: tr.data('precio'),
    stock: tr.data('stock'),
    imagen: tr.data('imagen') || 'no.jpg',
    um: tr.data('um') || ''
  });
  $('#modalBuscarProducto').modal('hide');
});
</script>

<?= $this->include('layouts/footer') ?>
