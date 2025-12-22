<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<form id="formVenta" action="<?= base_url('ventas/store') ?>" method="post">
<?= csrf_field() ?>

<div class="card">
  <div class="card-body">

    <div class="row">
      <div class="col-md-3 form-group">
        <label>Comprobante</label>
        <select name="idtipo_documento" class="form-control" required>
          <option value="">Seleccione...</option>
          <?php foreach ($tipos_documento as $t): ?>
            <option value="<?= esc($t['idtipo_documento']) ?>"><?= esc($t['nombre']) ?></option>
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
        <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>" required>
      </div>
    </div>

    <div class="row align-items-end">
      <div class="col-md-10 form-group">
        <label>Cliente</label>
        <input type="hidden" name="idcliente" id="idcliente" value="<?= old('idcliente') ?>">
        <input type="text" id="cliente_nombre" class="form-control" placeholder="Seleccione o busque..." value="<?= old('cliente_nombre') ?>">
      </div>
      <div class="col-md-2 form-group">
        <button type="button" id="btnBuscarCliente" class="btn btn-info btn-block">
          <i class="fa fa-search"></i> Buscar
        </button>
      </div>
    </div>

    <div class="row align-items-end">
      <div class="col-md-10 form-group">
        <label>Producto</label>
        <input type="text" id="producto_buscar" class="form-control" placeholder="Busque para agregar...">
      </div>
      <div class="col-md-2 form-group">
        <button type="button" id="btnBuscarProducto" class="btn btn-primary btn-block">
          <i class="fa fa-search"></i> Buscar
        </button>
      </div>
    </div>

    <table class="table table-bordered" id="tablaDetalle">
      <thead>
        <tr class="bg-success text-white">
          <th>Código</th>
          <th>Nombre</th>
          <th>Imagen</th>
          <th>UM</th>
          <th>Precio Venta</th>
          <th>Stock</th>
          <th style="width:120px;">Cantidad</th>
          <th style="width:130px;">Importe</th>
          <th style="width:60px;">X</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

    <div class="row">
      <div class="col-md-4 form-group">
        <label>Subtotal</label>
        <input type="text" name="subtotal" id="subtotal" class="form-control" value="0.00" readonly>
      </div>
      <div class="col-md-4 form-group">
        <label>IGV</label>
        <input type="text" name="igv" id="igv" class="form-control" value="0.00" readonly>
      </div>
      <div class="col-md-4 form-group">
        <label>Total</label>
        <input type="text" name="total" id="total" class="form-control" value="0.00" readonly>
      </div>
    </div>

    <input type="hidden" name="items" id="items">

    <button class="btn btn-success" type="submit">
      <i class="fa fa-save"></i> Guardar
    </button>

    <a href="<?= base_url('ventas') ?>" class="btn btn-secondary">Volver</a>

  </div>
</div>

</form>

</div>
</section>

<div class="modal fade" id="modalClientes" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lista de Clientes</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="text" id="qCliente" class="form-control mb-2" placeholder="Buscar cliente...">
        <table class="table table-bordered" id="tablaClientes">
          <thead>
            <tr>
              <th style="width:80px;">Add</th>
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

<div class="modal fade" id="modalProductos" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lista de Productos</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="text" id="qProducto" class="form-control mb-2" placeholder="Buscar producto...">
        <table class="table table-bordered" id="tablaProductos">
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
  const IGV_RATE = 0.18;

  function n2(v){
    let x = parseFloat(v);
    if (isNaN(x)) x = 0;
    return Math.round(x * 100) / 100;
  }

  function fmt(v){
    return n2(v).toFixed(2);
  }

  function getRowById(id){
    return $('#tablaDetalle tbody tr[data-id="'+id+'"]');
  }

  function calc(){
    let total = 0;

    $('#tablaDetalle tbody tr').each(function(){
      const precio = n2($(this).find('.precio').text());
      const cant = n2($(this).find('.cantidad').val());
      const imp = n2(precio * cant);

      $(this).find('.importe').text(fmt(imp));
      total += imp;
    });

    const subtotal = total / (1 + IGV_RATE);
    const igv = total - subtotal;

    $('#total').val(fmt(total));
    $('#subtotal').val(fmt(subtotal));
    $('#igv').val(fmt(igv));

    buildItems();
  }

  function buildItems(){
    const items = [];
    $('#tablaDetalle tbody tr').each(function(){
      items.push({
        idproducto: parseInt($(this).attr('data-id')),
        precio: n2($(this).find('.precio').text()),
        cantidad: n2($(this).find('.cantidad').val()),
        importe: n2($(this).find('.importe').text())
      });
    });
    $('#items').val(JSON.stringify(items));
  }

  function addProducto(p){
    const id = parseInt(p.idproducto);
    if (!id) return;

    const row = getRowById(id);
    if (row.length){
      let c = n2(row.find('.cantidad').val());
      row.find('.cantidad').val(fmt(c + 1));
      calc();
      return;
    }

    const img = p.img_url ? p.img_url : '<?= base_url('uploads/productos/no.jpg') ?>';
    const precio = fmt(p.precio);
    const stock = p.stock ?? '';

    const tr = $(`
      <tr data-id="${id}">
        <td class="codigo"></td>
        <td class="nombre"></td>
        <td class="text-center">
          <a href="${img}" data-toggle="lightbox" data-title="">
            <img src="${img}" class="img-thumbnail" style="max-width:60px; max-height:60px;">
          </a>
        </td>
        <td class="um"></td>
        <td class="precio text-right"></td>
        <td class="stock text-right"></td>
        <td><input type="number" min="1" step="1" class="form-control cantidad" value="1"></td>
        <td class="importe text-right">0.00</td>
        <td class="text-center">
          <button type="button" class="btn btn-danger btn-sm btnDel"><i class="fa fa-times"></i></button>
        </td>
      </tr>
    `);

    tr.find('.codigo').text(p.codigo ?? '');
    tr.find('.nombre').text(p.nombre ?? '');
    tr.find('a[data-toggle="lightbox"]').attr('data-title', p.nombre ?? '');
    tr.find('.um').text(p.unmedida ?? '');
    tr.find('.precio').text(precio);
    tr.find('.stock').text(stock);

    $('#tablaDetalle tbody').append(tr);
    calc();
  }

  function cargarClientes(q){
    return $.getJSON('<?= base_url('ventas/ajaxClientes') ?>', { q: q || '' });
  }

  function cargarProductos(q){
    return $.getJSON('<?= base_url('ventas/ajaxProductos') ?>', { q: q || '' });
  }

  function renderClientes(rows){
    const tb = $('#tablaClientes tbody');
    tb.empty();
    (rows || []).forEach(r=>{
      const tr = $(`
        <tr>
          <td class="text-center">
            <button type="button" class="btn btn-success btn-sm selCli">Add</button>
          </td>
          <td class="cod"></td>
          <td class="nom"></td>
        </tr>
      `);
      tr.attr('data-id', r.idcliente);
      tr.attr('data-nombre', r.nombre ?? '');
      tr.find('.cod').text(r.codigo ?? '');
      tr.find('.nom').text(r.nombre ?? '');
      tb.append(tr);
    });
  }

  function renderProductos(rows){
    const tb = $('#tablaProductos tbody');
    tb.empty();
    (rows || []).forEach(r=>{
      const img = r.img_url ? r.img_url : '<?= base_url('uploads/productos/no.jpg') ?>';

      const tr = $(`
        <tr>
          <td class="text-center">
            <button type="button" class="btn btn-success btn-sm selProd">Add</button>
          </td>
          <td class="cod"></td>
          <td class="nom"></td>
          <td class="text-center">
            <a href="${img}" data-toggle="lightbox" data-title="">
              <img src="${img}" class="img-thumbnail" style="max-width:60px; max-height:60px;">
            </a>
          </td>
          <td class="pre text-right"></td>
          <td class="stk text-right"></td>
          <td class="um"></td>
        </tr>
      `);

      tr.data('row', r);
      tr.find('.cod').text(r.codigo ?? '');
      tr.find('.nom').text(r.nombre ?? '');
      tr.find('a[data-toggle="lightbox"]').attr('data-title', r.nombre ?? '');
      tr.find('.pre').text(fmt(r.precio));
      tr.find('.stk').text(r.stock ?? '');
      tr.find('.um').text(r.unmedida ?? '');

      tb.append(tr);
    });
  }

  let tCli = null, tProd = null;

  $('#btnBuscarCliente').on('click', function(){
    $('#modalClientes').modal('show');
    $('#qCliente').val('');
    cargarClientes('').done(renderClientes);
    setTimeout(()=>$('#qCliente').focus(), 200);
  });

  $('#btnBuscarProducto').on('click', function(){
    $('#modalProductos').modal('show');
    $('#qProducto').val('');
    cargarProductos('').done(renderProductos);
    setTimeout(()=>$('#qProducto').focus(), 200);
  });

  $('#qCliente').on('keyup', function(){
    clearTimeout(tCli);
    const q = $(this).val().trim();
    tCli = setTimeout(()=>{ cargarClientes(q).done(renderClientes); }, 200);
  });

  $('#qProducto').on('keyup', function(){
    clearTimeout(tProd);
    const q = $(this).val().trim();
    tProd = setTimeout(()=>{ cargarProductos(q).done(renderProductos); }, 200);
  });

  $('#cliente_nombre').on('keyup', function(e){
    if (e.key === 'Enter'){
      $('#btnBuscarCliente').click();
    }
  });

  $('#producto_buscar').on('keyup', function(e){
    if (e.key === 'Enter'){
      $('#btnBuscarProducto').click();
    }
  });

  $(document).on('click', '.selCli', function(){
    const tr = $(this).closest('tr');
    $('#idcliente').val(tr.attr('data-id'));
    $('#cliente_nombre').val(tr.attr('data-nombre'));
    $('#modalClientes').modal('hide');
  });

  $(document).on('click', '.selProd', function(){
    const tr = $(this).closest('tr');
    const r = tr.data('row');
    addProducto(r);
    $('#modalProductos').modal('hide');
    $('#producto_buscar').val('');
  });

  $(document).on('input', '#tablaDetalle .cantidad', function(){
    let v = parseFloat($(this).val());
    if (isNaN(v) || v <= 0) $(this).val(1);
    calc();
  });

  $(document).on('click', '#tablaDetalle .btnDel', function(){
    $(this).closest('tr').remove();
    calc();
  });

  $('#formVenta').on('submit', function(e){
    if (!$('#idcliente').val()){
      e.preventDefault();
      alert('Seleccione un cliente.');
      return;
    }
    if ($('#tablaDetalle tbody tr').length === 0){
      e.preventDefault();
      alert('Agregue al menos 1 producto.');
      return;
    }
    buildItems();
  });

  calc();
})();
</script>

<?= $this->include('layouts/footer') ?>
