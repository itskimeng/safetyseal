<?php 
session_start();
require_once 'application/config/connection.php'; 

if ($_GET['token']) {
	$selectApplication = ' SELECT `id`, `control_no`, `user_id`, `status`, `has_consent`, `date_created`, `date_proceed`, `receiver_id`, `date_received`, `approver_id`, `date_approved`, `safety_seal_no`, `date_modified` FROM `tbl_app_checklist` WHERE status = "Approved" AND `token` = "'.$_GET['token'].'" ';
}
else
{
	$selectApplication = ' SELECT `id`, `control_no`, `user_id`, `status`, `has_consent`, `date_created`, `date_proceed`, `receiver_id`, `date_received`, `approver_id`, `date_approved`, `safety_seal_no`, `date_modified` FROM `tbl_app_checklist` WHERE status = "Approved" AND `user_id` = "'.$_SESSION['userid'].'" ';
}


$execSelectApplication = $conn->query($selectApplication);
$resultApplication = $execSelectApplication->fetch_assoc();


$selectApplicantDetails = ' SELECT `ID`, `REGION`, `PROVINCE`, `LGU`, `OFFICE`, `CMLGOO_NAME`, `UNAME`, `PASSWORD`, `VERIFICATION_CODE`, `IS_APPROVED`, `IS_VERIFIED`, `ROLES`, `EMAIL` FROM `tbl_admin_info` WHERE `ID` = "'.$resultApplication['user_id'].'" ';
$execApplicantDetails = $conn->query($selectApplicantDetails);
$resultApplicantDetails = $execApplicantDetails->fetch_assoc();


$selectAddress = ' SELECT `ID`, `USER_ID`, `ADDRESS`, `POSITION`, `MOBILE_NO`, `EMAIL_ADDRESS`, `GOV_AGENCY_NAME`, `GOV_ESTB_NAME`, `DATE_REGISTERED`, `GOV_NATURE_NAME` FROM `tbl_userinfo` WHERE `USER_ID` = "'.$resultApplication['user_id'].'" ';
$execAddress = $conn->query($selectAddress);
$resultAddress = $execAddress->fetch_assoc();

ini_set('memory_limit', '-1');

require 'fpdf/roundedRect1.php';

$pdf = new PDF();
$pdf->AddPage();
$pdf->RoundedRect(25, 250, 161, 42, 7, '1234', 'D');
$pdf->Image('fpdf/disiplina.png',85,1,50);
$pdf->Image('fpdf/safetyseallogo2.png',8,-26,193.5);


$pdf->Image('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2Fsafetyseal.calabarzon.dilg.gov.ph/establishment-profile.php?unique_id='.$resultApplication['user_id'].'%2F&choe=UTF-8',30,255,30,0,'png');
$pdf->Image('fpdf/dilg.png',62,255,30);

$pdf->SetFont('Arial','',12);
$pdf->SetXY(95,254);
$pdf->Cell(10,10,'Safety Seal No : ');

$pdf->SetFont('Arial','U',14);
$pdf->SetXY(126,254);
$pdf->Cell(10,10,$resultApplication['safety_seal_no']);

$pdf->SetFont('Arial','',12);
$pdf->SetXY(95,262);
$pdf->Cell(10,10,'Date Issued : ');

$pdf->SetFont('Arial','U',14);
$pdf->SetXY(126,262);
$pdf->Cell(10,10,date('F d, Y',strtotime($resultApplication['date_approved'])));

$pdf->SetFont('Arial','',12);
$pdf->SetXY(95,275);
$pdf->Cell(1,1,'Valid Until : ');

$pdf->SetFont('Arial','U',14);
$pdf->SetXY(126,275);
$pdf->Cell(1,1,date('F d, Y', strtotime("+6 months", strtotime($resultApplication['date_approved']))));


$pdf->Output();

 ?>
