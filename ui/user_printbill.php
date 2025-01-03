<?php 
require('fpdf186/fpdf.php');

include_once 'conndb.php';

$id = $_GET["id"];

$select = $pdo->prepare("select * from tbl_invoice where invoice_id = :id");
$select->bindParam(':id', $id, PDO::PARAM_INT);
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$pdf = new FPDF('P', 'mm', array(57, 150   ));

$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(37, 8, 'CHOWKING', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(37, 5, 'PHONE NUMBER : 988-8888', 0, 1, 'C');
$pdf->Cell(37, 5, 'WEBSITE  : WWW.CHOWKING.PH', 0, 1, 'C');

// Line(x1, y1, x2, y2);
$pdf->Line(0, 28, 57, 28);
$pdf->Ln(2);

$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(3, 4, 'Bill No:', 0, 0, 'L');
$pdf->Cell(37, 4, $row->invoice_id, 0, 1, 'R');

$pdf->Cell(3, 4, 'Date:', 0, 0, 'L');
$pdf->Cell(37, 4, date('d-m-Y', strtotime($row->order_date)), 0, 1, 'R');

$pdf->Cell(3, 4, 'Time:', 0, 0, 'L');
$pdf->Cell(37, 4, date('H:i:s', strtotime($row->time_value)), 0, 1, 'R');

$pdf->Cell(3, 4, 'Table No:', 0, 0, 'L');
$pdf->Cell(37, 4, $row->table_number, 0, 1, 'R');



// $pdf->Cell(24,1,'',0,1,'');

// // $pdf->Line(0, 40, 57, 40);
// $pdf->Ln(1);

// $pdf->SetFont('Arial', 'B', 8);
// $pdf->Cell(17, 4, 'Description', 0, 0, 'L');
// $pdf->Cell(23, 4, 'Qty', 0, 0, 'C');
// $pdf->Cell(4, 4, 'Total', 0, 1, 'R');

// $pdf->Line(0, 45, 57, 45);
// $pdf->Ln(1);


$pdf->Line(0, $pdf->GetY() + 2, 57, $pdf->GetY() + 2);
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 4, 'Description', 0, 0, 'L');
$pdf->Cell(23, 4, 'Qty', 0, 0, 'C');
$pdf->Cell(4, 4, 'Total', 0, 1, 'R');

$select = $pdo->prepare("select * from tbl_invoice_details where invoice_id = :id");
$select->bindParam(':id', $id, PDO::PARAM_INT);
$select->execute();
$items = $select->fetchAll(PDO::FETCH_OBJ);

foreach ($items as $item) {
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(30, 4, $item->product_name, 0, 'L');
    
    // Move to the right of the product name cell
    $pdf->SetXY($pdf->GetX() + 30, $pdf->GetY() - 4);
    
    $pdf->Cell(-2, 4, $item->qty, 0, 0, 'C');
    $pdf->Cell(17, 4, number_format($item->total_per_qty, 2), 0, 1, 'R');
}

$pdf->Line(0, $pdf->GetY() + 2, 57, $pdf->GetY() + 2);
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 4, 'Total Due', 0, 0, 'L');
$pdf->Cell(4, 4, number_format($row->total_due, 2), 0, 1, 'R');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 4, 'Paid', 0, 0, 'L');
$pdf->Cell(4, 4, number_format($row->paid, 2), 0, 1, 'R');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 4, 'Change', 0, 0, 'L');
$pdf->Cell(4, 4, number_format($row->change_amount, 2), 0, 1, 'R');

$pdf->Line(0, $pdf->GetY() + 2, 57, $pdf->GetY() + 2);
$pdf->Ln(3);

$pdf->Cell(30, 4, 'VATable Sales', 0, 0, 'L');
$pdf->Cell(4, 4, number_format($row->vatable_sales, 2), 0, 1, 'R');

$pdf->Cell(30, 4, 'VAT Amount', 0, 0, 'L');
$pdf->Cell(4, 4, number_format($row->vat_amount, 2), 0, 1, 'R');

// $pdf->Cell(30, 4, 'Total', 0, 0, 'L');
// $pdf->Cell(4, 4, number_format($row->total_due + $row->vat_amount, 2), 0, 1, 'R');

$pdf->Line(0, $pdf->GetY() + 2, 57, $pdf->GetY() + 2);
$pdf->Ln(3);

$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(57, 4, 'Thank you for dining with us!', 0, 1, 'C');

$pdf->Output();
?>