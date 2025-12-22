<?= $this->include('layouts/header') ?>

<section class="content pt-3">
<div class="container-fluid">

<div class="card">
<div class="card-body">

<h4>Ventas <small class="text-muted">Nuevo</small></h4>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<form action="<?= base_url('ventas/store') ?>" method="post">
<?= csrf_field() ?>

<!-- FILA 1 -->
<div class="row">
  <div class="col-md-3">
    <label>Tipo Documento</label>
    <select name="idtipo_documento" class="form-control" required>
      <option value="">Seleccione</option>
      <?php foreach ($tipos_documento as $t): ?>
        <option value="<?= $t['idtipo_documento'] ?>"><?= esc($t['nombre']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-3">
    <label>Serie</label>
    <input type="text" name="serie" class="form-control">
  </div>

  <div class="col-md-3">
    <label>Número</label>
    <input type="text" name="num_documento" class="form-control">
  </div>

  <div class="col-md-3">
    <label>Fecha</label>
    <input type="text" name="fecha" class="form-control" value="<?= date('d/m/Y') ?>">
  </div>
</div>

<!-- CLIENTE -->
<div class="form-group mt-2">
  <label>Cliente</label>
  <select name="idcliente" class="form-control" required>
    <option value="">Seleccione</option>
    <?php foreach ($clientes as $c): ?>
      <option value="<?= $c['idcliente'] ?>"><?= esc($c['nombre']) ?></option>
    <?php endforeach; ?>
  </select>
</div>

<hr>

<!-- PRODUCTO -->
<div class="row align-items-end">
  <div class="col-md-8">
    <label>Producto</label>
    <select id="producto" class="form-control">
      <option value="">Seleccione</option>
      <?php foreach ($productos as $p): ?>
        <option value="<?= $p['idproducto'] ?>"
          data-codigo="<?= $p['codigo'] ?>"
          data-nombre="<?= $p['nombre'] ?>"
          data-precio="<?= $p['precio'] ?>"
          data-stock="<?= $p['stock'] ?>">
          <?= $p['codigo'].' - '.$p['nombre'] ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-2">
    <button type="button" id="btnAgregar" class="btn btn-primary btn-block">
      Agregar
    </button>
  </div>
</div>

<!-- TABLA -->
<table class="table table-bordered mt-3" id="tablaDetalle">
<thead class="bg-success">
<tr>
  <th>Código</th>
  <th>Nombre</th>
  <th>Precio</th>
  <th>Stock</th>
  <th>Cantidad</th>
  <th>Importe</th>
  <th>X</th>
</tr>
</thead>
<tbody></tbody>
</table>

<div class="row">
  <div class="col-md-4 ml-auto">
    <label>Total</label>
    <input type="text" id="total" class="form-control" readonly>
  </div>
</div>

<button class="btn btn-success mt-3">Guardar</button>

</form>
</div>
</div>

</div>
</section>

<script>
let total = 0;

document.getElementById('btnAgregar').onclick = function(){
  let sel = document.getElementById('producto');
  let opt = sel.options[sel.selectedIndex];
  if(!opt.value) return;

  let precio = parseFloat(opt.dataset.precio);
  let cant = 1;
  let imp = precio * cant;

  let tr = `
  <tr>
    <td>${opt.dataset.codigo}</td>
    <td>${opt.dataset.nombre}</td>
    <td>${precio}</td>
    <td>${opt.dataset.stock}</td>
    <td><input type="number" name="cantidad[]" value="1" class="form-control"></td>
    <td class="imp">${imp}</td>
    <td><button type="button" class="btn btn-danger btn-sm">X</button></td>

    <input type="hidden" name="idproducto[]" value="${opt.value}">
    <input type="hidden" name="precio[]" value="${precio}">
  </tr>`;

  document.querySelector('#tablaDetalle tbody').insertAdjacentHTML('beforeend', tr);
  total += imp;
  document.getElementById('total').value = total.toFixed(2);
};
</script>

<?= $this->include('layouts/footer') ?>
