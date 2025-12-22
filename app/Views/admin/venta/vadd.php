<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<form id="formVenta" action="<?= base_url('ventas/store') ?>" method="post">
<?= csrf_field() ?>

<div class="card">
  <div class="card-body">

    <!-- CABECERA -->
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

    <!-- CLIENTE -->
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

    <!-- PRODUCTO -->
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

    <!-- DETALLE -->
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

    <!-- TOTALES -->
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

<!-- MODAL CLIENTES -->
<div class="modal fade" id="modalClientes">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Clientes</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="text" id="qCliente" class="form-control mb-2"
               placeholder="Buscar cliente...">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th></th>
              <th>Código</th>
              <th>Nombre</th>
            </tr>
          </thead>
          <tbody id="tablaClientes"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PRODUCTOS -->
<div class="modal fade" id="modalProductos">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Productos</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="text" id="qProducto" class="form-control mb-2"
               placeholder="Buscar producto...">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th></th>
              <th>Código</th>
              <th>Nombre</th>
              <th>Precio</th>
              <th>Stock</th>
              <th>UM</th>
            </tr>
          </thead>
          <tbody id="tablaProductos"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
const IGV = 0.18;

function calc(){
  let total = 0;
  document.querySelectorAll('#tablaDetalle tbody tr').forEach(tr=>{
    const precio = parseFloat(tr.dataset.precio);
    const cant = parseFloat(tr.querySelector('.cantidad').value);
    const imp = precio * cant;
    tr.querySelector('.importe').innerText = imp.toFixed(2);
    total += imp;
  });

  const subtotal = total / (1 + IGV);
  const igv = total - subtotal;

  subtotalInput.value = subtotal.toFixed(2);
  igvInput.value = igv.toFixed(2);
  totalInput.value = total.toFixed(2);

  buildItems();
}

function buildItems(){
  let items = [];
  document.querySelectorAll('#tablaDetalle tbody tr').forEach(tr=>{
    items.push({
      idproducto: tr.dataset.id,
      precio: tr.dataset.precio,
      cantidad: tr.querySelector('.cantidad').value,
      importe: tr.querySelector('.importe').innerText
    });
  });
  document.getElementById('items').value = JSON.stringify(items);
}
</script>

<?= $this->include('layouts/footer') ?>
