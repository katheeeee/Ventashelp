<?php

namespace App\Controllers\ventas;

use App\Controllers\BaseController;
use App\Models\mventa;
use App\Models\mdetalle_venta;
use App\Models\mproducto;
use App\Models\mcliente;
use App\Models\mtipo_comprobante;

class cventa extends BaseController
{
    protected $venta;
    protected $detalle;
    protected $producto;
    protected $cliente;

    public function __construct()
    {
        $this->venta     = new mventa();
        $this->detalle   = new mdetalle_venta();
        $this->producto  = new mproducto();
        $this->cliente   = new mcliente();
    }

    public function index()
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        $registros = $this->venta
            ->select('venta.*, cliente.nombre as cliente, tipo_comprobante.nombre as comprobante')
            ->join('cliente', 'cliente.idcliente = venta.idcliente')
            ->join('tipo_comprobante', 'tipo_comprobante.idtipo_comprobante = venta.idtipo_comprobante', 'left')
            ->orderBy('venta.idventa', 'DESC')
            ->findAll();

        return view('admin/venta/vlist', [
            'active'    => 'ventas',
            'subactive' => 'venta_list',
            'registros' => $registros,
        ]);
    }

    public function add()
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        $tipos_comprobante = (new mtipo_comprobante())
            ->where('estado', 1)
            ->orderBy('nombre', 'ASC')
            ->findAll();

        return view('admin/venta/vadd', [
            'active'            => 'ventas',
            'subactive'         => 'venta_add',
            'tipos_comprobante' => $tipos_comprobante,
        ]);
    }

    public function ajaxClientes()
    {
        if (!session()->get('login')) return $this->response->setStatusCode(403);

        $q = trim($this->request->getGet('q') ?? '');

        $builder = $this->cliente->select('idcliente, codigo, nombre');

        if ($q !== '') {
            $builder->groupStart()
                ->like('nombre', $q)
                ->orLike('codigo', $q)
                ->groupEnd();
        }

        if ($this->cliente->db->fieldExists('estado', 'cliente')) {
            $builder->where('estado', 1);
        }

        $data = $builder->orderBy('nombre', 'ASC')->findAll(50);
        return $this->response->setJSON($data);
    }

    public function ajaxProductos()
    {
        if (!session()->get('login')) return $this->response->setStatusCode(403);

        $q = trim($this->request->getGet('q') ?? '');

        $builder = $this->producto
            ->select('producto.idproducto, producto.codigo, producto.nombre, producto.imagen, producto.precio, producto.stock,
                      unmedida.nombre as unmedida')
            ->join('unmedida', 'unmedida.idunmedida = producto.idunmedida', 'left');

        if ($q !== '') {
            $builder->groupStart()
                ->like('producto.nombre', $q)
                ->orLike('producto.codigo', $q)
                ->groupEnd();
        }

        if ($this->producto->db->fieldExists('estado', 'producto')) {
            $builder->where('producto.estado', 1);
        }

        $data = $builder->orderBy('producto.nombre', 'ASC')->findAll(300);

        foreach ($data as &$r) {
            $r['imagen']  = $r['imagen'] ?: 'no.jpg';
            $r['img_url'] = base_url('uploads/productos/' . $r['imagen']);
        }

        return $this->response->setJSON($data);
    }

    // ✅ AJAX para rellenar serie y número
    public function ajaxComprobanteData($id)
    {
        if (!session()->get('login')) return $this->response->setStatusCode(403);

        $tc = (new mtipo_comprobante())->find($id);

        if (!$tc) {
            return $this->response->setJSON(['serie' => '', 'numero' => '']);
        }

        $numero = str_pad(((int)$tc['cantidad']) + 1, 6, '0', STR_PAD_LEFT);

        return $this->response->setJSON([
            'serie'  => $tc['serie'],
            'numero' => $numero,
        ]);
    }

    public function store()
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        $idUsuario = session('idusuario') ?? session('idtipo_usuario') ?? 1;

        $rules = [
            'idtipo_comprobante' => 'required|integer',
            'serie'              => 'required',
            'num_documento'      => 'required',
            'fecha'              => 'required',
            'idcliente'          => 'required|integer',
            'subtotal'           => 'required',
            'igv'                => 'required',
            'total'              => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $items = json_decode($this->request->getPost('items'), true);

        if (!is_array($items) || count($items) === 0) {
            return redirect()->back()->withInput()->with('error', ['Debes agregar al menos 1 producto.']);
        }

        // ✅ Validar stock antes
        foreach ($items as $it) {
            $idproducto = (int)($it['idproducto'] ?? 0);
            $cantidad   = (float)($it['cantidad'] ?? 0);

            if ($idproducto <= 0 || $cantidad <= 0) {
                return redirect()->back()->withInput()->with('error', ['Hay items inválidos en el detalle.']);
            }

            $p = $this->producto->find($idproducto);
            if (!$p) {
                return redirect()->back()->withInput()->with('error', ['Producto no encontrado.']);
            }

            if ((float)$p['stock'] < (float)$cantidad) {
                return redirect()->back()->withInput()->with('error', [
                    "Stock insuficiente para {$p['nombre']}. Disponible: {$p['stock']}"
                ]);
            }
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // ✅ fecha DATETIME
        $fecha = $this->request->getPost('fecha');
        if (strlen($fecha) === 10) $fecha .= ' 00:00:00';

        $idtipo_comprobante = (int)$this->request->getPost('idtipo_comprobante');

        // ✅ Insert cabecera
        $idventa = $this->venta->insert([
            'fecha'              => $fecha,
            'subtotal'           => $this->request->getPost('subtotal'),
            'igv'                => $this->request->getPost('igv'),
            'descuento'          => $this->request->getPost('descuento') ?? 0,
            'total'              => $this->request->getPost('total'),
            'serie'              => $this->request->getPost('serie'),
            'num_documento'      => $this->request->getPost('num_documento'),
            'idtipo_comprobante' => $idtipo_comprobante,
            'idcliente'          => $this->request->getPost('idcliente'),
            'idusuario'          => $idUsuario,
            'estado'             => 1,
            'fecharegistro'      => date('Y-m-d H:i:s'),
            'usuarioregistro'    => $idUsuario,
        ], true);

        // ✅ Detalle + bajar stock
        foreach ($items as $it) {
            $idproducto = (int)($it['idproducto'] ?? 0);
            $precio     = (float)($it['precio'] ?? 0);
            $cantidad   = (float)($it['cantidad'] ?? 0);
            $importe    = (float)($it['importe'] ?? 0);

            $this->detalle->insert([
                'estado'        => 1,
                'precio'        => $precio,
                'cantidad'      => $cantidad,
                'importe'       => $importe,
                'idproducto'    => $idproducto,
                'idventa'       => $idventa,
                'fecharegistro' => date('Y-m-d H:i:s'),
            ]);

            $db->table('producto')
                ->set('stock', 'stock - ' . $db->escape($cantidad), false)
                ->where('idproducto', $idproducto)
                ->where('stock >=', $cantidad)
                ->update();

            if ($db->affectedRows() === 0) {
                $db->transRollback();
                return redirect()->back()->withInput()->with('error', [
                    'Stock insuficiente (se actualizó mientras vendías). Intenta nuevamente.'
                ]);
            }
        }

        // ✅ AUMENTAR correlativo del comprobante (cantidad + 1) ANTES del return
        $db->table('tipo_comprobante')
            ->set('cantidad', 'cantidad + 1', false)
            ->where('idtipo_comprobante', $idtipo_comprobante)
            ->update();

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', ['Error al registrar la venta.']);
        }

        return redirect()->to(base_url('ventas'))->with('success', 'Venta registrada correctamente');
    }

    public function view($id)
    {
        if (!session()->get('login')) return redirect()->to(base_url('login'));

        $cab = $this->venta
            ->select('venta.*, cliente.nombre as cliente, tipo_comprobante.nombre as comprobante')
            ->join('cliente', 'cliente.idcliente = venta.idcliente')
            ->join('tipo_comprobante', 'tipo_comprobante.idtipo_comprobante = venta.idtipo_comprobante', 'left')
            ->find($id);

        $det = $this->detalle
            ->select('detalle_venta.*, producto.codigo, producto.nombre, producto.imagen')
            ->join('producto', 'producto.idproducto = detalle_venta.idproducto')
            ->where('detalle_venta.idventa', $id)
            ->findAll();

        return view('admin/venta/vview', [
            'active'    => 'ventas',
            'subactive' => 'venta_list',
            'cab'       => $cab,
            'det'       => $det,
        ]);
    }
    public function pdf($idventa)
{
    if (!session()->get('login')) return redirect()->to(base_url('login'));

    // Cabecera
    $cab = $this->venta
        ->select('venta.*,
                  cliente.nombre as cliente,
                  cliente.direccion as direccion,
                  cliente.telefono as telefono,
                  tipo_comprobante.nombre as comprobante,
                  tipo_comprobante.serie as serie_conf')
        ->join('cliente', 'cliente.idcliente = venta.idcliente', 'left')
        ->join('tipo_comprobante', 'tipo_comprobante.idtipo_comprobante = venta.idtipo_comprobante', 'left')
        ->where('venta.idventa', (int)$idventa)
        ->first();

    if (!$cab) {
        return redirect()->to(base_url('ventas'))->with('error', 'Venta no encontrada');
    }

    // Detalle
    $det = $this->detalle
        ->select('detalle_venta.*,
                  producto.codigo as cod_producto,
                  producto.nombre as nom_producto')
        ->join('producto', 'producto.idproducto = detalle_venta.idproducto', 'left')
        ->where('detalle_venta.idventa', (int)$idventa)
        ->findAll();

    // Crear PDF
    require_once ROOTPATH . 'vendor/setasign/fpdf/fpdf.php';

$pdf = new \FPDF('P', 'mm', 'A4');

    $pdf->SetTitle("Comprobante {$cab['serie']}-{$cab['num_documento']}");
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(true, 15);

    // ====== ENCABEZADO EMPRESA ======
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 8, 'HELPNET', 0, 1, 'L');

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, 'Direccion: (pon tu direccion aqui)', 0, 1, 'L');
    $pdf->Cell(0, 5, 'Telefono: (pon tu telefono aqui)', 0, 1, 'L');
    $pdf->Ln(3);

    // ====== TITULO COMPROBANTE ======
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(0, 8, strtoupper($cab['comprobante'] ?? 'COMPROBANTE'), 0, 1, 'C');

    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 6, "Serie-Nro: {$cab['serie']}-{$cab['num_documento']}", 0, 1, 'C');
    $pdf->Ln(2);

    // ====== DATOS CLIENTE ======
    $fecha = $cab['fecha'] ? date('d/m/Y H:i', strtotime($cab['fecha'])) : '';
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 6, 'Fecha:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, $fecha, 0, 1, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 6, 'Cliente:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, $cab['cliente'] ?? '-', 0, 1, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 6, 'Direccion:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, $cab['direccion'] ?? '-', 0, 1, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 6, 'Telefono:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, $cab['telefono'] ?? '-', 0, 1, 'L');

    $pdf->Ln(4);

    // ====== TABLA DETALLE ======
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(25, 7, 'COD', 1, 0, 'C');
    $pdf->Cell(85, 7, 'PRODUCTO', 1, 0, 'C');
    $pdf->Cell(20, 7, 'CANT', 1, 0, 'C');
    $pdf->Cell(25, 7, 'PRECIO', 1, 0, 'C');
    $pdf->Cell(30, 7, 'IMPORTE', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 10);

    foreach ($det as $r) {
        $pdf->Cell(25, 7, $r['cod_producto'] ?? '', 1, 0, 'L');
        $pdf->Cell(85, 7, mb_strimwidth($r['nom_producto'] ?? '', 0, 45, '...'), 1, 0, 'L');
        $pdf->Cell(20, 7, number_format((float)$r['cantidad'], 0), 1, 0, 'C');
        $pdf->Cell(25, 7, number_format((float)$r['precio'], 2), 1, 0, 'R');
        $pdf->Cell(30, 7, number_format((float)$r['importe'], 2), 1, 1, 'R');
    }

    $pdf->Ln(4);

    // ====== TOTALES ======
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(130, 7, '', 0, 0);
    $pdf->Cell(30, 7, 'Subtotal:', 0, 0, 'R');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(30, 7, number_format((float)$cab['subtotal'], 2), 0, 1, 'R');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(130, 7, '', 0, 0);
    $pdf->Cell(30, 7, 'IGV:', 0, 0, 'R');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(30, 7, number_format((float)$cab['igv'], 2), 0, 1, 'R');

    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(130, 8, '', 0, 0);
    $pdf->Cell(30, 8, 'TOTAL:', 0, 0, 'R');
    $pdf->Cell(30, 8, number_format((float)$cab['total'], 2), 0, 1, 'R');

    // Salida al navegador
    $this->response->setHeader('Content-Type', 'application/pdf');
    // I = inline (se abre en navegador); D = descarga
    $pdf->Output('I', "comprobante_{$cab['serie']}_{$cab['num_documento']}.pdf");
    exit;
}

}
