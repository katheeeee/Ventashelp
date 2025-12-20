<?php

namespace App\Controllers\movimientos;

use App\Controllers\BaseController;

class cdocumento extends BaseController
{
    private function venta_demo($idventa)
    {
        return [
            'idventa' => $idventa,
            'fecha' => date('Y-m-d H:i'),
            'cliente' => [
                'nombre' => 'JUAN PEREZ',
                'doc' => '12345678',
                'direccion' => 'PUNO - PERU'
            ],
            'items' => [
                ['descripcion' => 'Producto A', 'cant' => 2, 'precio' => 10.50],
                ['descripcion' => 'Producto B', 'cant' => 1, 'precio' => 25.00],
            ]
        ];
    }

    public function boleta($idventa)
    {
        $data = $this->venta_demo($idventa);
        $data['tipo'] = 'BOLETA';
        return view('admin/vprint_documento', $data);
    }

    public function factura($idventa)
    {
        $data = $this->venta_demo($idventa);
        $data['tipo'] = 'FACTURA';
        return view('admin/vprint_documento', $data);
    }

    public function boleta_pdf($idventa)
    {
        $data = $this->venta_demo($idventa);
        $data['tipo'] = 'BOLETA';
        return $this->pdf_fpdf($data);
    }

    public function factura_pdf($idventa)
    {
        $data = $this->venta_demo($idventa);
        $data['tipo'] = 'FACTURA';
        return $this->pdf_fpdf($data);
    }

    private function pdf_fpdf($data)
    {
        require_once APPPATH . 'ThirdParty/fpdf/fpdf.php';

        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);

        $pdf->Cell(0, 10, utf8_decode($data['tipo'].' - N° '.$data['idventa']), 0, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, utf8_decode('Fecha: '.$data['fecha']), 0, 1);
        $pdf->Cell(0, 6, utf8_decode('Cliente: '.$data['cliente']['nombre']), 0, 1);
        $pdf->Cell(0, 6, utf8_decode('Documento: '.$data['cliente']['doc']), 0, 1);
        $pdf->Cell(0, 6, utf8_decode('Direccion: '.$data['cliente']['direccion']), 0, 1);
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(100, 7, 'Descripcion', 1);
        $pdf->Cell(20, 7, 'Cant', 1, 0, 'C');
        $pdf->Cell(30, 7, 'P.Unit', 1, 0, 'R');
        $pdf->Cell(30, 7, 'Importe', 1, 1, 'R');

        $pdf->SetFont('Arial', '', 10);

        $total = 0;
        foreach ($data['items'] as $it) {
            $imp = $it['cant'] * $it['precio'];
            $total += $imp;

            $pdf->Cell(100, 7, utf8_decode($it['descripcion']), 1);
            $pdf->Cell(20, 7, $it['cant'], 1, 0, 'C');
            $pdf->Cell(30, 7, number_format($it['precio'], 2), 1, 0, 'R');
            $pdf->Cell(30, 7, number_format($imp, 2), 1, 1, 'R');
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(150, 8, 'TOTAL', 1, 0, 'R');
        $pdf->Cell(30, 8, number_format($total, 2), 1, 1, 'R');

        return $this->response->setHeader('Content-Type', 'application/pdf')
                              ->setBody($pdf->Output('S'));
    }
}
