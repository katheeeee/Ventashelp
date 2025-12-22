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

    <!-- CLIENTE -->
    <div class="row align-items-end">
      <div class="col-md-10 form-group">
        <label>Cliente</label>
        <input type="hidden" name="idcliente" id="idcliente" value="<?= old('idcliente') ?>">
        <input type="text" id="cliente_nombre" class="form-control" placeholder="Seleccione o busque..." value="<?= old('cliente_nombre') ?>" readonly>
      </div>
      <div class="col-md-2 form-group">
        <button type="button" id="btnBuscarCliente" class="btn btn-info btn-block">
          <i class="fa fa-search"></i> Buscar
        </button>
      </div>
    </div>

    <!-- PRODUCTO -->
    <div class="row align-items-end">
      <div class="col-md-10 form-group">
        <label>Producto</label>
        <input type="text" id="producto_buscar" class="form-control" placeholder="Buscar producto (Enter)">
      </div>
      <div class="col-md-2 form-group">
        <button type="button" id="btnBuscarProducto" class="btn btn-primary btn-block">
          <i class="fa fa-search"></i> Buscar
        </button>
      </div>
    </div>

    <!-- DETALLE -->
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

    <!-- TOTALES -->
    <div class="row">
      <div class="col-md-4 form-group">
        <label>Subtotal</label>
        <input type="text" name="subtotal" id="subtotal" class="form-control" value="0.00" readonly>
      </div>
      <div class="col-md-4 form-group">
        <label>IGV (18%)</label>
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

<!-- MODAL CLIENTES -->
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

<!-- MODAL PRODUCTOS (DATATABLE) -->
<div class="modal fade" id="modalProductos" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lista de Productos</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

        <table class="table table-bordered table-hover" id="dtProductos" style="width:100%;">
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

<!-- Variables para JS -->
<script>
  window.VENTA_CFG = {
    IGV_RATE: 0.18,
    URL_CLIENTES: "<?= base_url('ventas/ajaxClientes') ?>",
    URL_PRODUCTOS: "<?= base_url('ventas/ajaxProductos') ?>",
    IMG_DEFAULT: "<?= base_url('uploads/productos/no.jpg') ?>"
  };
</script>

<?= $this->include('layouts/footer') ?>
