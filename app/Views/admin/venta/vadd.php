<?= $this->include('layouts/header') ?>

<section class="content pt-3">
  <div class="container-fluid">

    <form id="formVenta" action="<?= base_url('ventas/store') ?>" method="post">
      <?= csrf_field() ?>

      <div class="card">
        <div class="card-body">

          <!-- ===================== CABECERA ===================== -->
          <div class="row">
            <div class="col-md-3 form-group">
              <label>Comprobante</label>
              <select name="idtipo_comprobante" id="idtipo_comprobante" class="form-control" required>
                <option value="">Seleccione...</option>
                <?php foreach (($tipos_comprobante ?? []) as $t): ?>
                  <option value="<?= esc($t['idtipo_comprobante']) ?>">
                    <?= esc($t['nombre']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-3 form-group">
              <label>Serie</label>
              <input type="text" name="serie" id="serie" class="form-control" readonly required>
              <small class="text-muted">Se llena al elegir el comprobante</small>
            </div>

            <div class="col-md-3 form-group">
              <label>Número</label>
              <input type="text" name="num_documento" id="num_documento" class="form-control" readonly required>
              <small class="text-muted">Se llena al elegir el comprobante</small>
            </div>

            <div class="col-md-3 form-group">
              <label>Fecha</label>
              <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
          </div>

          <hr>

          <!-- ===================== CLIENTE ===================== -->
          <div class="row align-items-end">
            <div class="col-md-8 form-group">
              <label>Cliente</label>
              <input type="hidden" name="idcliente" id="idcliente" value="<?= old('idcliente') ?>">
              <input type="text" id="cliente_nombre" class="form-control"
                     placeholder="Seleccione o busque..." value="<?= old('cliente_nombre') ?>">
            </div>

            <div class="col-md-2 form-group">
              <button type="button" id="btnBuscarCliente" class="btn btn-info btn-block">
                <i class="fa fa-search"></i> Buscar
              </button>
            </div>

            <div class="col-md-2 form-group">
              <!-- Ajusta esta ruta si tu mantenimineto está dentro del grupo mantenimiento -->
              <a href="<?= base_url('mantenimiento/cliente/add') ?>" class="btn btn-success btn-block">
                <i class="fa fa-plus"></i> Nuevo
              </a>
            </div>
          </div>

          <!-- ===================== PRODUCTO ===================== -->
          <div class="row align-items-end">
            <div class="col-md-8 form-group">
              <label>Producto</label>
              <input type="text" id="producto_buscar" class="form-control" placeholder="Buscar producto...">
            </div>

            <div class="col-md-2 form-group">
              <button type="button" id="btnBuscarProducto" class="btn btn-primary btn-block">
                <i class="fa fa-search"></i> Buscar
              </button>
            </div>

            <div class="col-md-2 form-group">
              <a href="<?= base_url('mantenimiento/producto/add') ?>" class="btn btn-success btn-block">
                <i class="fa fa-plus"></i> Nuevo
              </a>
            </div>
          </div>

          <!-- ===================== DETALLE ===================== -->
          <div class="table-responsive">
            <table class="table table-bordered" id="tablaDetalle">
              <thead>
                <tr class="bg-success text-white">
                  <th>Código</th>
                  <th>Nombre</th>
                  <th>Imagen</th>
                  <th>UM</th>
                  <th class="text-right">Precio</th>
                  <th class="text-right">Stock</th>
                  <th style="width:140px;">Cantidad</th>
                  <th style="width:140px;" class="text-right">Importe</th>
                  <th style="width:60px;" class="text-center">X</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

          <!-- ===================== TOTALES ===================== -->
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

          <a href="<?= base_url('ventas') ?>" class="btn btn-secondary">
            Volver
          </a>

        </div>
      </div>
    </form>

  </div>
</section>

<!-- ===================== MODAL CLIENTES ===================== -->
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

<!-- ===================== MODAL PRODUCTOS (DATATABLE) ===================== -->
<div class="modal fade" id="modalProductos" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Lista de Productos</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <table class="table table-bordered" id="dtProductos" style="width:100%;">
          <thead>
            <tr>
              <th style="width:80px;">Add</th>
              <th>Código</th>
              <th>Nombre</th>
              <th>Imagen</th>
              <th class="text-right">Precio</th>
              <th class="text-right">Stock</th>
              <th>UM</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<!-- ===================== CONFIG JS (IMPORTANTE) ===================== -->
<script>
window.VENTA_CFG = {
  URL_CLIENTES: "<?= base_url('ventas/ajaxClientes') ?>",
  URL_PRODUCTOS: "<?= base_url('ventas/ajaxProductos') ?>",
  URL_COMP: "<?= base_url('ventas/ajaxComprobanteData') ?>",
  IMG_DEFAULT: "<?= base_url('uploads/productos/no.jpg') ?>",
  IGV_RATE: 0.18
};
</script>

<!-- ===================== DEPENDENCIAS (si tu footer ya lo incluye, puedes quitarlo) ===================== -->
<!-- jQuery, Bootstrap y DataTables normalmente van en el footer/layout -->
<!-- SOLO carga tu JS -->
<script src="<?= base_url('assets/js/vadd.js') ?>"></script>

<?= $this->include('layouts/footer') ?>
