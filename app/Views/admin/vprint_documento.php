<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?= esc($tipo) ?> <?= esc($idventa) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body{ font-family: Arial, sans-serif; margin:20px; }
    .box{ max-width: 800px; margin:auto; }
    table{ width:100%; border-collapse: collapse; margin-top:10px; }
    th,td{ border:1px solid #333; padding:6px; font-size:14px; }
    th{ text-align:left; }
    .right{ text-align:right; }
    .actions{ margin:12px 0; display:flex; gap:10px; }
    @media print { .actions{ display:none; } }
  </style>
</head>
<body>
<div class="box">

  <div class="actions">
    <button onclick="window.print()">Imprimir</button>

    <?php if ($tipo === 'BOLETA'): ?>
      <a href="<?= base_url('movimientos/boleta_pdf/'.$idventa) ?>" target="_blank">PDF</a>
    <?php else: ?>
      <a href="<?= base_url('movimientos/factura_pdf/'.$idventa) ?>" target="_blank">PDF</a>
    <?php endif; ?>
  </div>

  <h2><?= esc($tipo) ?> - N° <?= esc($idventa) ?></h2>
  <div><b>Fecha:</b> <?= esc($fecha) ?></div>
  <hr>

  <div>
    <b>Cliente:</b> <?= esc($cliente['nombre']) ?><br>
    <b>Documento:</b> <?= esc($cliente['doc']) ?><br>
    <b>Dirección:</b> <?= esc($cliente['direccion']) ?><br>
  </div>

  <table>
    <thead>
      <tr>
        <th>Descripción</th>
        <th class="right">Cant</th>
        <th class="right">P.Unit</th>
        <th class="right">Importe</th>
      </tr>
    </thead>
    <tbody>
      <?php $total=0; foreach($items as $it): $imp=$it['cant']*$it['precio']; $total+=$imp; ?>
      <tr>
        <td><?= esc($it['descripcion']) ?></td>
        <td class="right"><?= esc($it['cant']) ?></td>
        <td class="right"><?= number_format($it['precio'],2) ?></td>
        <td class="right"><?= number_format($imp,2) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3" class="right">TOTAL</th>
        <th class="right"><?= number_format($total,2) ?></th>
      </tr>
    </tfoot>
  </table>

</div>
</body>
</html>
