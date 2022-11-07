<?php
session_start();
date_default_timezone_set('Asia/Manila');
require '../library/PHPExcel-1.8/Classes/PHPExcel.php';
require '../Model/Connection.php';
require '../manager/ApplicationManager.php';

$am = new ApplicationManager();

$current_month = $_GET['asof_date'];
$asof_date = new DateTime($current_month);
$timestamp = $asof_date->format('Y-m-d H:i:s');
$asof_datetxt = $asof_date->format('F d, Y h:i A');
$asof_txtonly = $asof_date->format('Ymd-hiA');
$filename = 'SSC_REPORT_'.$asof_txtonly;

$phpExcel = new PHPExcel;

$phpExcel->getProperties()->setTitle("DILG Inspection and Certification Team Accomplishment Report");
$phpExcel->getProperties()->setCreator("Regional Officer SafetySeal Office");
$phpExcel->getProperties()->setDescription("Summary of DILG Inspection and Certification Team Accomplishment Report");
$writer = PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");
$sheet = $phpExcel->getActiveSheet();

$sheet->setTitle('Summary');

// Creating spreadsheet header
$sheet->getStyle('A1:I1')->getFont('Arial Black')->setBold(true);
$sheet->getStyle('A2:I2')->getFont('Arial Black')->setBold(true);
$sheet->getStyle('A3:I3')->getFont('Arial Black')->setBold(true);
$sheet->getStyle('A5:I5')->getFont('Arial Black')->setBold(true);
$sheet->getStyle('A6:I6')->getFont('Arial Black')->setBold(true);
$sheet->getStyle('A7:I7')->getFont('Arial Black')->setBold(true);
$sheet->getStyle('A8:I8')->getFont('Arial Black')->setBold(true);
$sheet->getStyle('A9:I9')->getFont('Arial Black')->setBold(true);
$sheet->getStyle('A10:I10')->getFont('Arial Black')->setBold(true);
$sheet->getStyle('B4:I4')->getFont('Arial Black')->setItalic(true);

$sheet->getCell('A1')->setValue('Summary of DILG Inspection and Certification Team Accomplishment Report as of '.$asof_datetxt);
$sheet->getCell('A2')->setValue('Name of Province');
$sheet->getCell('B2')->setValue('Total No. of Applications Received (Control No.)');
$sheet->getCell('C2')->setValue('Total No. of Establishments Issued with Safety Seal Certification ');
$sheet->getCell('D2')->setValue('Total No. of Disapproved Establishments ');
$sheet->getCell('E2')->setValue('MODE OF ACQUISITION');
$sheet->getCell('F2')->setValue('');
$sheet->getCell('G2')->setValue('Total No. of SSC Posted in Official Website');
$sheet->getCell('H2')->setValue('Total No. of Complaints Received');
$sheet->getCell('I2')->setValue('Remarks');

$sheet->getCell('E3')->setValue("TOTAL NO. OF ESTABLISHMENTS CERTIFIED BY APPLICATION \n(The Establishment applied thru the website or secured the Checklist from the Office of the Issuing Authority)");
$sheet->getCell('F3')->setValue("TOTAL NO. OF ESTABLISHMENTS CERTIFIED BY VISIT FROM REGULAR MONITORING \n( During the conduct of a regular monitoring, the Inspection Team has determined that the establishment is eligible for a Safety Seal)");

$sheet->getCell('B4')->setValue('a');
$sheet->getCell('C4')->setValue('g');
$sheet->getCell('D4')->setValue('i');
$sheet->getCell('E4')->setValue('j');
$sheet->getCell('F4')->setValue('');
$sheet->getCell('G4')->setValue('k');
$sheet->getCell('H4')->setValue('l');
$sheet->getCell('I4')->setValue('n');

$sheet->getCell('A5')->setValue('TOTAL');
$sheet->getCell('A6')->setValue('BATANGAS');
$sheet->getCell('A7')->setValue('CAVITE');
$sheet->getCell('A8')->setValue('LAGUNA');
$sheet->getCell('A9')->setValue('RIZAL');
$sheet->getCell('A10')->setValue('QUEZON (including Lucena HUC)');

$sheet->mergeCells('A1:I1');
$sheet->mergeCells('E2:F2');
$sheet->mergeCells('A2:A3');
$sheet->mergeCells('B2:B3');
$sheet->mergeCells('C2:C3');
$sheet->mergeCells('D2:D3');
$sheet->mergeCells('G2:G3');
$sheet->mergeCells('H2:H3');
$sheet->mergeCells('I2:I3');
$sheet->mergeCells('E4:F4');

$sheet->getStyle('A1')->getFont()->setSize(15);
$sheet->getStyle('B5:I5')->getFont()->setSize(15);
$sheet->getStyle('B6:I6')->getFont()->setSize(15);
$sheet->getStyle('B7:I7')->getFont()->setSize(15);
$sheet->getStyle('B8:I8')->getFont()->setSize(15);
$sheet->getStyle('B9:I9')->getFont()->setSize(15);
$sheet->getStyle('B10:I10')->getFont()->setSize(15);

$sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A2')->getAlignment()->setVertical('center');

$sheet->getStyle('B2')->getAlignment()->setHorizontal('center');
$sheet->getStyle('B2')->getAlignment()->setVertical('center');

$sheet->getStyle('B4')->getAlignment()->setHorizontal('center');
$sheet->getStyle('B4')->getAlignment()->setVertical('center');

$sheet->getStyle('C2')->getAlignment()->setHorizontal('center');
$sheet->getStyle('C2')->getAlignment()->setVertical('center');

$sheet->getStyle('C4')->getAlignment()->setHorizontal('center');
$sheet->getStyle('C4')->getAlignment()->setVertical('center');

$sheet->getStyle('D2')->getAlignment()->setHorizontal('center');
$sheet->getStyle('D2')->getAlignment()->setVertical('center');

$sheet->getStyle('D4')->getAlignment()->setHorizontal('center');
$sheet->getStyle('D4')->getAlignment()->setVertical('center');

$sheet->getStyle('E2')->getAlignment()->setHorizontal('center');
$sheet->getStyle('E2')->getAlignment()->setVertical('center');

$sheet->getStyle('E4')->getAlignment()->setHorizontal('center');
$sheet->getStyle('E4')->getAlignment()->setVertical('center');

$sheet->getStyle('F2')->getAlignment()->setHorizontal('center');
$sheet->getStyle('F2')->getAlignment()->setVertical('center');

$sheet->getStyle('F4')->getAlignment()->setHorizontal('center');
$sheet->getStyle('F4')->getAlignment()->setVertical('center');

$sheet->getStyle('G2')->getAlignment()->setHorizontal('center');
$sheet->getStyle('G2')->getAlignment()->setVertical('center');

$sheet->getStyle('G4')->getAlignment()->setHorizontal('center');
$sheet->getStyle('G4')->getAlignment()->setVertical('center');

$sheet->getStyle('H2')->getAlignment()->setHorizontal('center');
$sheet->getStyle('H2')->getAlignment()->setVertical('center');

$sheet->getStyle('H4')->getAlignment()->setHorizontal('center');
$sheet->getStyle('H4')->getAlignment()->setVertical('center');

$sheet->getStyle('I2')->getAlignment()->setHorizontal('center');
$sheet->getStyle('I2')->getAlignment()->setVertical('center');

$sheet->getStyle('I4')->getAlignment()->setHorizontal('center');
$sheet->getStyle('I4')->getAlignment()->setVertical('center');

$sheet->getStyle('E3')->getAlignment()->setHorizontal('center');
$sheet->getStyle('E3')->getAlignment()->setVertical('center');

$sheet->getStyle('F3')->getAlignment()->setHorizontal('center');
$sheet->getStyle('F3')->getAlignment()->setVertical('center');

$sheet->getStyle('A5')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A5')->getAlignment()->setVertical('center');

$sheet->getStyle('A6')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A6')->getAlignment()->setVertical('center');

$sheet->getStyle('A7')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A7')->getAlignment()->setVertical('center');

$sheet->getStyle('A8')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A8')->getAlignment()->setVertical('center');

$sheet->getStyle('A9')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A9')->getAlignment()->setVertical('center');

$sheet->getStyle('A10')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A10')->getAlignment()->setVertical('center');

$sheet->getStyle('A10')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A10')->getAlignment()->setVertical('center');


$sheet->getStyle('A1:I1')->applyFromArray(
	array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'd2fabd')
		)
	)
);

$sheet->getStyle('A2:B2')->applyFromArray(
	array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'ffc0cb')
		)
	)
);

$sheet->getStyle('A4:B4')->applyFromArray(
	array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'ffc0cb')
		)
	)
);

$sheet->getStyle('H2:I2')->applyFromArray(
	array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'ffc0cb')
		)
	)
);

$sheet->getStyle('H4:I4')->applyFromArray(
	array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'ffc0cb')
		)
	)
);

$sheet->getStyle('C2:G2')->applyFromArray(
	array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'f2d28b')
		)
	)
);

$sheet->getStyle('C4:G4')->applyFromArray(
	array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'f2d28b')
		)
	)
);

$sheet->getStyle('E3:F3')->applyFromArray(
	array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'f2d28b')
		)
	)
);

$sheet->getStyle('E4:F4')->applyFromArray(
	array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'f2d28b')
		)
	)
);

$sheet->getStyle("A1:I1")->applyFromArray(
	array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb' => 'DDDDDD')
			)
		)
	)
);

$sheet->getStyle('A5:I5')->applyFromArray(
	array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'd2fabd')
		)
	)
);

$border = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('rgb' => '6a6d6d'))));


//setting width and height
$sheet->getRowDimension(1)->setRowHeight(30);
$sheet->getColumnDimension('A')->setWidth(35);
$sheet->getColumnDimension('B')->setWidth(35);
$sheet->getColumnDimension('C')->setWidth(35);
$sheet->getColumnDimension('D')->setWidth(35);
$sheet->getColumnDimension('E')->setWidth(35);
$sheet->getColumnDimension('F')->setWidth(35);
$sheet->getColumnDimension('G')->setWidth(35);
$sheet->getColumnDimension('H')->setWidth(35);
$sheet->getColumnDimension('I')->setWidth(35);


$sheet->getRowDimension('5')->setRowHeight(50);
$sheet->getRowDimension('6')->setRowHeight(50);
$sheet->getRowDimension('7')->setRowHeight(50);
$sheet->getRowDimension('8')->setRowHeight(50);
$sheet->getRowDimension('9')->setRowHeight(50);
$sheet->getRowDimension('10')->setRowHeight(50);

$sheet->getStyle('A5:I5')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A5:I5')->getAlignment()->setVertical('center');

$sheet->getStyle('A6:I6')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A6:I6')->getAlignment()->setVertical('center');

$sheet->getStyle('A7:I7')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A7:I7')->getAlignment()->setVertical('center');

$sheet->getStyle('A8:I8')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A8:I8')->getAlignment()->setVertical('center');

$sheet->getStyle('A9:I9')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A9:I9')->getAlignment()->setVertical('center');

$sheet->getStyle('A10:I10')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A10:I10')->getAlignment()->setVertical('center');



$sheet->getStyle('A1:I1')->getAlignment()->setWrapText(true);
$sheet->getStyle('A2:A3')->getAlignment()->setWrapText(true);
$sheet->getStyle('B2:B3')->getAlignment()->setWrapText(true);
$sheet->getStyle('C2:C3')->getAlignment()->setWrapText(true);
$sheet->getStyle('D2:D3')->getAlignment()->setWrapText(true);
$sheet->getStyle('G2:G3')->getAlignment()->setWrapText(true);
$sheet->getStyle('H2:H3')->getAlignment()->setWrapText(true);
$sheet->getStyle('I2:I3')->getAlignment()->setWrapText(true);

$sheet->getStyle('E3')->getAlignment()->setWrapText(true);
$sheet->getStyle('F3')->getAlignment()->setWrapText(true);


$sheet->getStyle('A1:I1')->applyFromArray($border);

$reports['total_application'] = $am->showAllApplications('',$timestamp);
$reports['total_received'] = $am->showAllApplications('',$timestamp,ApplicationManager::STATUS_RECEIVED);
$reports['total_approved'] = $am->showAllApplications('',$timestamp,ApplicationManager::STATUS_APPROVED);
$reports['total_disapproved'] = $am->showAllApplications('',$timestamp,ApplicationManager::STATUS_DISAPPROVED);

$sheet->getCell('B5')->setValue($reports['total_application']);
$sheet->getCell('C5')->setValue($reports['total_approved']);
$sheet->getCell('D5')->setValue($reports['total_disapproved']);
$sheet->getCell('E5')->setValue($reports['total_approved']);
$sheet->getCell('F5')->setValue('0');
$sheet->getCell('G5')->setValue($reports['total_approved']);
$sheet->getCell('H5')->setValue('0');
$sheet->getCell('I5')->setValue('');

$reports['batangas_application'] = $am->showAllApplications(3,$timestamp);
$reports['batangas_received'] = $am->showAllApplications(3,$timestamp,ApplicationManager::STATUS_RECEIVED);
$reports['batangas_approved'] = $am->showAllApplications(3,$timestamp,ApplicationManager::STATUS_APPROVED);
$reports['batangas_disapproved'] = $am->showAllApplications(3,$timestamp,ApplicationManager::STATUS_DISAPPROVED);

$sheet->getCell('B6')->setValue($reports['batangas_application']);
$sheet->getCell('C6')->setValue($reports['batangas_approved']);
$sheet->getCell('D6')->setValue($reports['batangas_disapproved']);
$sheet->getCell('E6')->setValue($reports['batangas_approved']);
$sheet->getCell('F6')->setValue('0');
$sheet->getCell('G6')->setValue($reports['batangas_approved']);
$sheet->getCell('H6')->setValue('0');
$sheet->getCell('I6')->setValue('');

$reports['cavite_application'] = $am->showAllApplications(1,$timestamp);
$reports['cavite_received'] = $am->showAllApplications(1,$timestamp,ApplicationManager::STATUS_RECEIVED);
$reports['cavite_approved'] = $am->showAllApplications(1,$timestamp,ApplicationManager::STATUS_APPROVED);
$reports['cavite_disapproved'] = $am->showAllApplications(1,$timestamp,ApplicationManager::STATUS_DISAPPROVED);

$sheet->getCell('B7')->setValue($reports['cavite_application']);
$sheet->getCell('C7')->setValue($reports['cavite_approved']);
$sheet->getCell('D7')->setValue($reports['cavite_disapproved']);
$sheet->getCell('E7')->setValue($reports['cavite_approved']);
$sheet->getCell('F7')->setValue('0');
$sheet->getCell('G7')->setValue($reports['cavite_approved']);
$sheet->getCell('H7')->setValue('0');
$sheet->getCell('I7')->setValue('');

$reports['laguna_application'] = $am->showAllApplications(2,$timestamp);
$reports['laguna_received'] = $am->showAllApplications(2,$timestamp,ApplicationManager::STATUS_RECEIVED);
$reports['laguna_approved'] = $am->showAllApplications(2,$timestamp,ApplicationManager::STATUS_APPROVED);
$reports['laguna_disapproved'] = $am->showAllApplications(2,$timestamp,ApplicationManager::STATUS_DISAPPROVED);

$sheet->getCell('B8')->setValue($reports['laguna_application']);
$sheet->getCell('C8')->setValue($reports['laguna_approved']);
$sheet->getCell('D8')->setValue($reports['laguna_disapproved']);
$sheet->getCell('E8')->setValue($reports['laguna_approved']);
$sheet->getCell('F8')->setValue('0');
$sheet->getCell('G8')->setValue($reports['laguna_approved']);
$sheet->getCell('H8')->setValue('0');
$sheet->getCell('I8')->setValue('');

$reports['rizal_application'] = $am->showAllApplications(4,$timestamp);
$reports['rizal_received'] = $am->showAllApplications(4,$timestamp,ApplicationManager::STATUS_RECEIVED);
$reports['rizal_approved'] = $am->showAllApplications(4,$timestamp,ApplicationManager::STATUS_APPROVED);
$reports['rizal_disapproved'] = $am->showAllApplications(4,$timestamp,ApplicationManager::STATUS_DISAPPROVED);

$sheet->getCell('B9')->setValue($reports['rizal_application']);
$sheet->getCell('C9')->setValue($reports['rizal_approved']);
$sheet->getCell('D9')->setValue($reports['rizal_disapproved']);
$sheet->getCell('E9')->setValue($reports['rizal_approved']);
$sheet->getCell('F9')->setValue('0');
$sheet->getCell('G9')->setValue($reports['rizal_approved']);
$sheet->getCell('H9')->setValue('0');
$sheet->getCell('I9')->setValue('');

$reports['huc_application'] = $am->showAllApplications('huc',$timestamp);
$reports['huc_received'] = $am->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_RECEIVED);
$reports['huc_approved'] = $am->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_APPROVED);
$reports['huc_disapproved'] = $am->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_DISAPPROVED);

$sheet->getCell('B10')->setValue($reports['huc_application']);
$sheet->getCell('C10')->setValue($reports['huc_approved']);
$sheet->getCell('D10')->setValue($reports['huc_disapproved']);
$sheet->getCell('E10')->setValue($reports['huc_approved']);
$sheet->getCell('F10')->setValue('0');
$sheet->getCell('G10')->setValue($reports['huc_approved']);
$sheet->getCell('H10')->setValue('0');
$sheet->getCell('I10')->setValue('');

// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');

// It will be called file.xls
header('Content-Disposition: attachment; filename="'.$filename.'.xls"');

// Write file to the browser
$writer->save('php://output');
