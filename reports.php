<?php
session_start();
require 'phpexcel/Classes/PHPExcel.php';
require 'application/config/connection.php';


$phpExcel = new PHPExcel;

//Setting description, creator and title
$phpExcel ->getProperties()->setTitle("Certified Establishment Report");
$phpExcel ->getProperties()->setCreator("Safety Seal Administrator");
$phpExcel ->getProperties()->setDescription("List of certified establishment");
// Creating PHPExcel spreadsheet writer object
// We will create xlsx file (Excel 2007 and above)
$writer = PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");
// When creating the writer object, the first sheet is also created
// We will get the already created sheet
$sheet = $phpExcel ->getActiveSheet();
// Setting title of the sheet
$sheet->setTitle('Establishment List');

// Creating spreadsheet header
$sheet ->getStyle('A1:R1')->getFont('Arial Black')->setBold(true)->setSize(16);
$sheet ->getCell('A1')->setValue('No.');
$sheet ->getCell('B1')->setValue('Control No.');
$sheet ->getCell('C1')->setValue('Name of Establishment/ Office/Department/Unit');
$sheet ->getCell('D1')->setValue('Nature of Establishment/ Office/Department/Unit');
$sheet ->getCell('E1')->setValue('Address');
$sheet ->getCell('F1')->setValue('Name of Person-in-Charge');
$sheet ->getCell('G1')->setValue('Contact Details');
$sheet ->getCell('H1')->setValue('Issuance of Safety Seal Certification (Input "1" if Yes, Input "0" if No)');
$sheet ->getCell('I1')->setValue('Date of Issuance of Safety Seal Certificate');
$sheet ->getCell('J1')->setValue('Reason for Non-Issuance of Safety Seal [If answer in (g) is "0" or No]');
$sheet ->getCell('K1')->setValue('Mode of Acquisition (Input 1 if "by application", Input 2 if "by regular visit)');
$sheet ->getCell('L1')->setValue('Posted in Official Website? (Input "1" if Yes, Input "0" if No)');
$sheet ->getCell('M1')->setValue('Complaints Received, if any');
$sheet ->getCell('N1')->setValue('NO OF ESTABLISHMENT FOR INSPECTION');
$sheet ->getCell('O1')->setValue('NO. OF ESTABLISHMENTS FOR EVALUATION');
$sheet ->getCell('P1')->setValue('NO. OF ESTABLISHMENTS DENIED/REFERRRED TO OTHER AGENCIES');
$sheet ->getCell('Q1')->setValue('Action Taken');
$sheet ->getCell('R1')->setValue('Remarks');


$sheet->getStyle('A1:M1')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'd2fabd')
        )
    )
);


$sheet->getStyle('N1:P1')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '45e859')
        )
    )
);

$sheet->getStyle('Q1:R1')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'd2fabd')
        )
    )
);

$sheet->getStyle("A1:R1")->applyFromArray(
    array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'DDDDDD')
            )
        )
    )
);


//setting width and height
$sheet->getRowDimension(1)->setRowHeight(100);
$sheet->getColumnDimension('A')->setWidth(15);
$sheet->getColumnDimension('B')->setWidth(20);
$sheet->getColumnDimension('C')->setWidth(35);
$sheet->getColumnDimension('D')->setWidth(35);
$sheet->getColumnDimension('E')->setWidth(20);
$sheet->getColumnDimension('F')->setWidth(35);
$sheet->getColumnDimension('G')->setWidth(20);
$sheet->getColumnDimension('H')->setWidth(35);
$sheet->getColumnDimension('I')->setWidth(35);
$sheet->getColumnDimension('J')->setWidth(35);
$sheet->getColumnDimension('K')->setWidth(35);
$sheet->getColumnDimension('L')->setWidth(35);
$sheet->getColumnDimension('M')->setWidth(35);
$sheet->getColumnDimension('N')->setWidth(35);
$sheet->getColumnDimension('O')->setWidth(35);
$sheet->getColumnDimension('P')->setWidth(35);
$sheet->getColumnDimension('Q')->setWidth(35);
$sheet->getColumnDimension('R')->setWidth(35);
$sheet->getStyle('A1:R1')->getAlignment()->setWrapText(true); 


//populate data

$selectArea = ' SELECT `ID`, `REGION`, `PROVINCE`, `LGU`, `OFFICE`, `CMLGOO_NAME`, `UNAME`, `PASSWORD`, `VERIFICATION_CODE`, `IS_APPROVED`, `IS_VERIFIED`, `ROLES`, `EMAIL` FROM `tbl_admin_info` WHERE `ID` = "'.$_SESSION['userid'].'" ';
$execArea = $conn->query($selectArea);
$area = $execArea->fetch_assoc();

$province = $area['PROVINCE'];
$lgu = $area['LGU'];

$selectUser = ' SELECT `ID`, `REGION`, `PROVINCE`, `LGU`, `OFFICE`, `CMLGOO_NAME`, `UNAME`, `PASSWORD`, `VERIFICATION_CODE`, `IS_APPROVED`, `IS_VERIFIED`, `ROLES`, `EMAIL` FROM `tbl_admin_info` WHERE `PROVINCE` = "'.$province.'" AND `LGU` = "'.$lgu.'" ';
$execUser = $conn->query($selectUser);

$i = 2;
$x = 1;
while ($resultUser = $execUser->fetch_assoc()) 
{
	$sql = ' SELECT `id`, `control_no`, `user_id`, `agency`, `establishment`, `nature`, `address`, `person`, `contact_details`, `status`, `has_consent`, `date_created`, `date_proceed`, `receiver_id`, `date_received`, `approver_id`, `date_approved`, `safety_seal_no`, `reassessed_by`, `date_reassessed`, `date_modified`, `token`, `application_type` FROM `tbl_app_checklist` WHERE `user_id` = "'.$resultUser['ID'].'" ';
	$query = $conn->query($sql);

	if ($query->num_rows > 0) 
	{
		$row = $query->fetch_assoc();

		$sheet ->getStyle('A'.$i.':R'.$i)->getFont()->setBold(false)->setSize(14);
		$sheet ->getCell('A'.$i)->setValue($x);
		$sheet ->getCell('B'.$i)->setValue($row['control_no']);
		$sheet ->getCell('C'.$i)->setValue($row['establishment']);
		$sheet ->getCell('D'.$i)->setValue($row['nature']);
		$sheet ->getCell('E'.$i)->setValue($row['address']);
		$sheet ->getCell('F'.$i)->setValue($row['person']);
		$sheet ->getCell('G'.$i)->setValue($row['contact_details']);

		$sheet ->getCell('H'.$i)->setValue($row['status']);

		$sheet ->getCell('I'.$i)->setValue($row['date_approved']);
		$sheet ->getCell('J'.$i)->setValue('remarks if not approve');
		$sheet ->getCell('K'.$i)->setValue('1 application, 2 visit');
		$sheet ->getCell('L'.$i)->setValue('Posted in official website');
		$sheet ->getCell('M'.$i)->setValue('Complaints if any');
		$sheet ->getCell('N'.$i)->setValue('0');
		$sheet ->getCell('O'.$i)->setValue('0');
		$sheet ->getCell('P'.$i)->setValue('0');
		$sheet ->getCell('Q'.$i)->setValue('N/A');
		$sheet ->getCell('R'.$i)->setValue('N/A');
		$i++;
		$x++;

	}

}


//select LGU name for file naming
$selectLgu = ' SELECT `id`, `province`, `code`, `name`, `date_created` FROM `tbl_citymun` WHERE `province` = "'.$province.'" AND `code` = "'.$lgu.'" ';
$execLgu = $conn->query($selectLgu);
$resultLgu = $execLgu->fetch_assoc();

//name
$filename = $resultLgu['name'].'_'.date("F j, Y");


// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');

// It will be called file.xls
header('Content-Disposition: attachment; filename="'.$filename.'.xls"');

// Write file to the browser
$writer->save('php://output');