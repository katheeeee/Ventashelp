<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
  <div class="card-body">

    <h4>Ventas <small class="text-muted">| Nuevo</small></h4>

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
        <div class="col-md-4">
          <label>Comprobante</label>
          <select name="idtipo_documento" id="idtipo_documento" class="form-control" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($tipos_documento as $t): ?>
              <option value="<?= esc($t['idtipo_documento']) ?>">
                <?= esc($t['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-3">
          <label>Serie</label>
          <input type="text" name="serie" id="serie" class="form-control" required>
        </div>

        <div class="col-md-3">
          <label>Número</label>
          <input type="text" name="num_documento" id="num_documento" class="form-control" required>
        </div>

        <div class="col-md-2">
          <label>Fecha</label>
          <input type="date" name="fecha" id="fecha" class="form-control"
                 value="<?= date('Y-m-d') ?>" required>
        </div>
      </div>

      <hr>

      <!-- CLIENTE -->
      <div class="row align-items-end">
        <div class="col-md-10">
          <label>Cliente</label>
          <input type="hidden" name="idcliente" id="idcliente" required>
          <input type="text" id="cliente_nombre" class="form-control" placeholder="Seleccione..." readonly>
          <small class="text-muted">Se abrirá una lista para elegir cliente.</small>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-info btn-block" id="btnBuscarCliente">
            <i class="fa fa-search"></i> Buscar
          </button>
        </div>
      </div>

      <hr>

      <!-- PRODUCTO -->
      <div class="row align-items-end">
        <div class="col-md-10">
          <label>Producto</label>
          <input type="text" id="producto_nombre" class="form-control" placeholder="Seleccione..." readonly>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-primary btn-block" id="btnBuscarProducto">
            <i class="fa fa-search"></i> Buscar
          </button>
        </div>
      </div>

      <br>

      <!-- TABLA DETALLE -->
      <div class="table-responsive">
        <table class="table table-bordered" id="tablaDetalle">
          <thead class="bg-success text-white">
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Imagen</th>
              <th>UM</th>
              <th>Precio Venta</th>
              <th>Stock</th>
              <th width="120">Cantidad</th>
              <th>Importe</th>
              <th width="60">X</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

      <!-- TOTALES -->
      <div class="row">
        <div class="col-md-4">
          <label>Subtotal</label>
          <input type="text" class="form-control" id="subtotal" name="subtotal" value="0.00" readonly>
        </div>
        <div class="col-md-4">
          <label>IGV</label>
          <input type="text" class="form-control" id="igv" name="igv" value="0.00" readonly>
        </div>
        <div class="col-md-4">
          <label>Total</label>
          <input type="text" class="form-control" id="total" name="total" value="0.00" readonly>
        </div>
      </div>

      <input type="hidden" name="items" id="items">

      <br>

      <button type="submit" class="btn btn-success">
        <i class="fa fa-save"></i> Guardar
      </button>

      <a href="<?= base_url('ventas') ?>" class="btn btn-secondary">
        Volver
      </a>

    </form>

  </div>
</div>

</div>
</section>

<!-- =======================
 MODAL CLIENTES
======================= -->
<div class="modal fade" id="modalClientes" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lista de Clientes</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <div class="form-group">
          <input type="text" id="qCliente" class="form-control" placeholder="Buscar por nombre o código...">
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="tablaClientes">
            <thead>
              <tr>
                <th width="60">Add</th>
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
</div>

<!-- =======================
 MODAL PRODUCTOS
======================= -->
<div class="modal fade" id="modalProductos" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lista de Productos</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <div class="form-group">
          <input type="text" id="qProducto" class="form-control" placeholder="Buscar por nombre o código...">
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="tablaProductos">
            <thead>
              <tr>
                <th width="60">Add</th>
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
</div>

<script>
(function(){

  // ==========================
  // Helpers
  // ==========================
  function money(n){
    n = parseFloat(n || 0);
    return n.toFixed(2);
  }

  function recalcularTotales(){
    let subtotal = 0;

    $('#tablaDetalle tbody tr').each(function(){
      const imp = parseFloat($(this).find('.importe').text() || 0);
      subtotal += imp;
    });

    const igv = subtotal * 0.18;     // IGV 18%
    const total = subtotal + igv;

    $('#subtotal').val(money(subtotal));
    $('#igv').val(money(igv));
    $('#total').val(money(total));

    // armar items para POST
    const items = [];
    $('#tablaDetalle tbody tr').each(function(){
      items.push({
        idproducto: $(this).data('idproducto'),
        precio: $(this).data('precio'),
        cantidad: $(this).find('.cantidad').val(),
        importe: $(this).find('.importe').text()
      });
    });
    $('#items').val(JSON.stringify(items));
  }

  function existeProducto(idproducto){
    return $('#tablaDetalle tbody tr[data-idproducto="'+idproducto+'"]').length > 0;
  }

  function agregarProducto(p){
    if (existeProducto(p.idproducto)){
      alert('Este producto ya fue agregado.');
      return;
    }

    const img = p.img_url || '';
    const tr = `
      <tr data-idproducto="${p.idproducto}" data-precio="${p.precio}">
        <td>${p.codigo}</td>
        <td>${p.nombre}</td>
        <td class="text-center">
          <img src="${img}" style="max-width:40px; max-height:40px;" class="img-thumbnail">
        </td>
        <td>${p.unmedida || ''}</td>
        <td class="text-right">${money(p.precio)}</td>
        <td class="text-right">${p.stock}</td>
        <td>
          <input type="number" min="1" class="form-control cantidad" value="1">
        </td>
        <td class="text-right importe">${money(p.precio)}</td>
        <td class="text-center">
          <button type="button" class="btn btn-danger btn-sm btnQuitar">
            <i class="fa fa-times"></i>
          </button>
        </td>
      </tr>
    `;

    $('#tablaDetalle tbody').append(tr);
    recalcularTotales();
  }

  // ==========================
  // DataTables (modales)
  // ==========================
  let dtClientes = null;
  let dtProductos = null;

  function initDTClientes(){
    if (dtClientes) return;
    dtClientes = $('#tablaClientes').DataTable({
      language: { url: "//cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json" },
      pageLength: 10
    });
  }

  function initDTProductos(){
    if (dtProductos) return;
    dtProductos = $('#tablaProductos').DataTable({
      language: { url: "//cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json" },
      pageLength: 10
    });
  }

  function cargarClientes(q=''){
    $.get("<?= base_url('ventas/ajaxClientes') ?>", { q }, function(resp){
      initDTClientes();
      dtClientes.clear();

      resp.forEach(r => {
        dtClientes.row.add([
          `<button type="button" class="btn btn-success btn-sm btnSelCliente"
              data-id="${r.idcliente}" data-nombre="${$('<div>').text(r.nombre).html()}" data-codigo="${$('<div>').text(r.codigo).html()}">
              <i class="fa fa-check"></i>
           </button>`,
          r.codigo ?? '',
          r.nombre ?? ''
        ]);
      });

      dtClientes.draw();
    }, 'json');
  }

  function cargarProductos(q=''){
    $.get("<?= base_url('ventas/ajaxProductos') ?>", { q }, function(resp){
      initDTProductos();
      dtProductos.clear();

      resp.forEach(r => {
        dtProductos.row.add([
          `<button type="button" class="btn btn-success btn-sm btnSelProducto"
              data-json='${JSON.stringify(r).replace(/'/g, "&apos;")}'>
              <i class="fa fa-check"></i>
           </button>`,
          r.codigo ?? '',
          r.nombre ?? '',
          `<img src="${r.img_url}" style="max-width:35px; max-height:35px;" class="img-thumbnail">`,
          money(r.precio),
          r.stock ?? 0,
          r.unmedida ?? ''
        ]);
      });

      dtProductos.draw();
    }, 'json');
  }

  // ==========================
  // Botones Buscar
  // ==========================
  $('#btnBuscarCliente').on('click', function(){
    $('#modalClientes').modal('show');
    cargarClientes('');
    setTimeout(() => $('#qCliente').focus(), 300);
  });

  $('#btnBuscarProducto').on('click', function(){
    $('#modalProductos').modal('show');
    cargarProductos('');
    setTimeout(() => $('#qProducto').focus(), 300);
  });

  // buscar dentro modal (enter o escribir)
  let t1=null, t2=null;
  $('#qCliente').on('keyup', function(){
    clearTimeout(t1);
    const q = $(this).val();
    t1 = setTimeout(() => cargarClientes(q), 250);
  });

  $('#qProducto').on('keyup', function(){
    clearTimeout(t2);
    const q = $(this).val();
    t2 = setTimeout(() => cargarProductos(q), 250);
  });

  // seleccionar cliente
  $(document).on('click', '.btnSelCliente', function(){
    const id = $(this).data('id');
    const nombre = $(this).data('nombre');
    const codigo = $(this).data('codigo');

    $('#idcliente').val(id);
    $('#cliente_nombre').val(codigo + ' - ' + nombre);

    $('#modalClientes').modal('hide');
  });

  // seleccionar producto
  $(document).on('click', '.btnSelProducto', function(){
    const json = $(this).attr('data-json');
    const p = JSON.parse(json);

    $('#producto_nombre').val(p.codigo + ' - ' + p.nombre);
    agregarProducto(p);

    $('#modalProductos').modal('hide');
  });

  // cambiar cantidad => recalcular
  $(document).on('input', '.cantidad', function(){
    const tr = $(this).closest('tr');
    const precio = parseFloat(tr.data('precio') || 0);
    let cant = parseFloat($(this).val() || 1);
    if (cant < 1) cant = 1;

    // (opcional) limitar a stock
    const stock = parseFloat(tr.find('td').eq(5).text() || 0);
    if (cant > stock && stock > 0){
      cant = stock;
      $(this).val(stock);
    }

    tr.find('.importe').text(money(precio * cant));
    recalcularTotales();
  });

  // quitar fila
  $(document).on('click', '.btnQuitar', function(){
    $(this).closest('tr').remove();
    recalcularTotales();
  });

  // validar antes de enviar
  $('#formVenta').on('submit', function(e){
    if (!$('#idcliente').val()){
      e.preventDefault();
      alert('Selecciona un cliente.');
      return;
    }
    if ($('#tablaDetalle tbody tr').length === 0){
      e.preventDefault();
      alert('Agrega al menos 1 producto.');
      return;
    }
    recalcularTotales();
  });

})();
</script>

<?= $this->include('layouts/footer') ?>
