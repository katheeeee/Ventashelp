<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

  <div class="card">
    <div class="card-body">
      <h4>Ventas 🛒 <small class="text-muted">Nuevo</small></h4>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
          <?= session()->getFlashdata('success') ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
          <?php foreach (session()->getFlashdata('error') as $e): ?>
            <div><?= esc($e) ?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('ventas/store') ?>" method="post" id="formVenta">
        <?= csrf_field() ?>

        <!-- FILA 1 -->
        <div class="row">
          <div class="col-md-3 form-group">
            <label>Tipo Documento</label>
            <select name="idtipo_documento" id="idtipo_documento" class="form-control" required>
              <option value="">Seleccione...</option>
              <?php foreach ($tipos_documento as $d): ?>
                <option value="<?= esc($d['idtipo_documento']) ?>">
                  <?= esc($d['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-3 form-group">
            <label>Serie</label>
            <input type="text" name="serie" id="serie" class="form-control" value="<?= old('serie') ?>">
          </div>

          <div class="col-md-3 form-group">
            <label>Número</label>
            <input type="text" name="num_documento" id="num_documento" class="form-control" value="<?= old('num_documento') ?>">
          </div>

          <div class="col-md-3 form-group">
            <label>Fecha</label>
            <input type="text" name="fecha" id="fecha" class="form-control"
                   value="<?= old('fecha', date('d/m/Y')) ?>" required>
          </div>
        </div>

        <!-- FILA 2 -->
        <div class="row">
          <div class="col-md-12 form-group">
            <label>Cliente</label>
            <select name="idcliente" id="idcliente" class="form-control" required>
              <option value="">Seleccione...</option>
              <?php foreach ($clientes as $c): ?>
                <option value="<?= esc($c['idcliente']) ?>">
                  <?= esc($c['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <!-- FILA 3 -->
        <div class="row align-items-end">
          <div class="col-md-8 form-group">
            <label>Producto</label>
            <select id="selProducto" class="form-control">
              <option value="">Seleccione...</option>
              <?php foreach ($productos as $p): ?>
                <?php
                  $img = !empty($p['imagen']) ? $p['imagen'] : 'no.jpg';
                ?>
                <option
                  value="<?= esc($p['idproducto']) ?>"
                  data-codigo="<?= esc($p['codigo']) ?>"
                  data-nombre="<?= esc($p['nombre']) ?>"
                  data-precio="<?= esc($p['precio']) ?>"
                  data-stock="<?= esc($p['stock']) ?>"
                  data-um="<?= esc($p['unmedida']) ?>"
                  data-img="<?= esc($img) ?>"
                >
                  <?= esc($p['codigo']) ?> - <?= esc($p['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-2 form-group">
            <button type="button" class="btn btn-primary btn-block" id="btnAgregar">
              <i class="fa fa-plus"></i> Agregar
            </button>
          </div>

          <div class="col-md-2 form-group">
            <button type="button" class="btn btn-info btn-block" id="btnBuscar" disabled>
              <i class="fa fa-search"></i> Buscar
            </button>
          </div>
        </div>

        <!-- TABLA DETALLE -->
        <div class="table-responsive">
          <table class="table table-bordered" id="tablaDetalle">
            <thead class="bg-success">
              <tr>
                <th style="min-width:90px;">Código</th>
                <th style="min-width:180px;">Nombre</th>
                <th style="min-width:90px;">Imagen</th>
                <th style="min-width:70px;">UM</th>
                <th style="min-width:120px;">Precio Venta</th>
                <th style="min-width:90px;">Stock</th>
                <th style="min-width:120px;">Cantidad</th>
                <th style="min-width:120px;">Importe</th>
                <th style="width:50px;">X</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>

        <!-- TOTALES -->
        <div class="row mt-3">
          <div class="col-md-4">
            <div class="form-group d-flex align-items-center">
              <label class="mb-0 mr-2" style="min-width:80px;">Subtotal:</label>
              <input type="text" class="form-control" id="subtotal" name="subtotal" value="0.00" readonly>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group d-flex align-items-center">
              <label class="mb-0 mr-2" style="min-width:60px;">IGV:</label>
              <input type="text" class="form-control" id="igv" name="igv" value="0.00" readonly>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group d-flex align-items-center">
              <label class="mb-0 mr-2" style="min-width:60px;">Total:</label>
              <input type="text" class="form-control" id="total" name="total" value="0.00" readonly>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group d-flex align-items-center">
              <label class="mb-0 mr-2" style="min-width:90px;">Descuento:</label>
              <input type="number" step="0.01" class="form-control" id="descuento" name="descuento" value="0.00">
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-success" id="btnGuardar">
          Guardar
        </button>

      </form>

    </div>
  </div>

</div>
</section>

<script>
(function(){
  const IGV_RATE = <?= isset($igv_rate) ? (float)$igv_rate : 0.18 ?>;

  const selProducto = document.getElementById('selProducto');
  const btnAgregar  = document.getElementById('btnAgregar');
  const tbody       = document.querySelector('#tablaDetalle tbody');

  const subtotalEl  = document.getElementById('subtotal');
  const igvEl       = document.getElementById('igv');
  const totalEl     = document.getElementById('total');
  const descEl      = document.getElementById('descuento');

  function money(n){
    n = isNaN(n) ? 0 : n;
    return n.toFixed(2);
  }

  function recalcular(){
    let subtotal = 0;

    tbody.querySelectorAll('tr').forEach(tr => {
      const importe = parseFloat(tr.querySelector('.importe').textContent) || 0;
      subtotal += importe;
    });

    const igv = subtotal * IGV_RATE;
    let descuento = parseFloat(descEl.value) || 0;
    if (descuento < 0) descuento = 0;

    const total = (subtotal + igv) - descuento;

    subtotalEl.value = money(subtotal);
    igvEl.value      = money(igv);
    totalEl.value    = money(total);
  }

  function existeProducto(id){
    return !!tbody.querySelector('tr[data-id="'+id+'"]');
  }

  function crearHidden(name, value){
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
  }

  function actualizarFila(tr){
    const precio = parseFloat(tr.dataset.precio) || 0;
    const stock  = parseFloat(tr.dataset.stock) || 0;

    const qtyInput = tr.querySelector('.qty');
    let qty = parseFloat(qtyInput.value) || 0;

    if (qty < 0) qty = 0;
    if (qty > stock) qty = stock; // no pasar stock
    qtyInput.value = qty;

    const importe = qty * precio;
    tr.querySelector('.importe').textContent = money(importe);

    // actualiza hidden inputs
    tr.querySelector('input[name="cantidad[]"]').value = qty;
    tr.querySelector('input[name="precio[]"]').value   = precio;
    tr.querySelector('input[name="idproducto[]"]').value = tr.dataset.id;

    recalcular();
  }

  btnAgregar.addEventListener('click', () => {
    const opt = selProducto.options[selProducto.selectedIndex];
    const id  = opt.value;
    if (!id) return;

    if (existeProducto(id)) {
      alert('Ese producto ya está agregado.');
      return;
    }

    const codigo = opt.dataset.codigo || '';
    const nombre = opt.dataset.nombre || '';
    const precio = parseFloat(opt.dataset.precio || '0');
    const stock  = parseFloat(opt.dataset.stock || '0');
    const um     = opt.dataset.um || '';
    const img    = opt.dataset.img || 'no.jpg';

    const tr = document.createElement('tr');
    tr.dataset.id = id;
    tr.dataset.precio = precio;
    tr.dataset.stock  = stock;

    tr.innerHTML = `
      <td>${codigo}</td>
      <td>${nombre}</td>
      <td class="text-center">
        <a href="<?= base_url('uploads/productos') ?>/${img}" data-toggle="lightbox" data-title="${nombre}">
          <img src="<?= base_url('uploads/productos') ?>/${img}" class="img-thumbnail" style="max-width:50px;max-height:50px;">
        </a>
      </td>
      <td>${um}</td>
      <td>${money(precio)}</td>
      <td>${stock}</td>
      <td>
        <input type="number" step="0.01" min="0" class="form-control qty" value="1">
      </td>
      <td class="importe">${money(precio * 1)}</td>
      <td class="text-center">
        <button type="button" class="btn btn-danger btn-sm btnDel">
          <i class="fa fa-times"></i>
        </button>
      </td>
    `;

    // hidden inputs
    tr.appendChild(crearHidden('idproducto[]', id));
    tr.appendChild(crearHidden('cantidad[]', 1));
    tr.appendChild(crearHidden('precio[]', precio));

    tbody.appendChild(tr);

    // eventos
    tr.querySelector('.qty').addEventListener('input', () => actualizarFila(tr));
    tr.querySelector('.btnDel').addEventListener('click', () => {
      tr.remove();
      recalcular();
    });

    recalcular();
  });

  descEl.addEventListener('input', recalcular);

})();
</script>

<?= $this->include('layouts/footer') ?>
