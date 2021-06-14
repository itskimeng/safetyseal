<?php 
// include 'function php/conn.php';
// include 'fpdf/fpdf.php';
require 'fpdf/roundedRect1.php';


$pdf = new PDF();
$pdf->AddPage();
// $pdf->SetFillColor(192);
$pdf->RoundedRect(25, 250, 161, 42, 7, '1234', 'D');
$pdf->Image('fpdf/disiplina.png',85,1,50);
// $pdf->Image('fpdf/safetyseallogo2.png',24,22,165);
$pdf->Image('fpdf/safetyseallogo2.png',8,-26,193.5);



// $pdf->Rect(25, 250, 161, 42, 'D');

$pdf->Image('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2Festablishment-profile?id=establishmentId%2F&choe=UTF-8',30,255,30,0,'png');
$pdf->Image('fpdf/dilg.png',62,255,30);

$pdf->SetFont('Arial','',12);
$pdf->SetXY(95,254);
$pdf->Cell(10,10,'Safety Seal No : ');

$pdf->SetFont('Arial','U',14);
$pdf->SetXY(126,254);
$pdf->Cell(10,10,'R4A-BA-01-0001');

$pdf->SetFont('Arial','',12);
$pdf->SetXY(95,262);
$pdf->Cell(10,10,'Date Issued : ');

$pdf->SetFont('Arial','U',14);
$pdf->SetXY(126,262);
$pdf->Cell(10,10,'June 11, 2021');

$pdf->SetFont('Arial','',12);
$pdf->SetXY(95,275);
$pdf->Cell(1,1,'Valid Until : ');

$pdf->SetFont('Arial','U',14);
$pdf->SetXY(126,275);
$pdf->Cell(1,1,'December 11, 2021');

// $pdf->SetFont('Arial','',12);
// $pdf->SetXY(95,275.5);
// $pdf->Cell(1,1.4,'Signature : ');

// $pdf->SetFont('Arial','U',14);
// $pdf->SetXY(126,275.5);
// $pdf->Cell(1,1.4,'Sample  Signature');


$pdf->Output();

 ?>
