<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../tcpdfv02/tcpdf.php';
require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$province = strtoupper($_GET['province']);

$checker_id = checkID($_GET['province']);
$data = getEstablishmentSSCRO($conn, $checker_id);
$date = new DateTime();
$date = $date->format('F d, Y');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setPageOrientation('L');
$pdf->SetCreator('DILG RICTU');
$pdf->SetAuthor('DILG RICTU');
$pdf->SetKeywords('TCPDF, PDF, todo');

// set default header data
$pdf->SetHeaderData('', '0', '', '');

$pdf->SetPrintHeader(false);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->SetFont('', '', 10);

// add a page
$pdf->AddPage();
// $html = file_get_contents(htmlentities('print.html.php'));

$html = generateHeader($province, $date);
$pdf->writeHTML($html, true, false, true, false, '');

$html = generateDetails($data);
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();
$pdf->Output('cavite_report.pdf', 'I');

function checkID($id) {
	$dd = '';
	switch ($id) {
		case 'cavite':
			$dd = 1;
			break;
		case 'laguna':
			$dd = 2;
			break;
		case 'batangas':
			$dd = 3;
			break;
		case 'rizal':
			$dd = 4;
			break;
		case 'quezon':
			$dd = 5;
			break;	
	}

	return $dd;
}

function generateHeader($province, $date)
{
	$html = '<table class="table table-bordered" cellspacing="1" cellpadding="5" style="font-size:12pt;">';
	$html.= '<tr>';
	$html.= '<td style="text-align:center;"><b>ESTABLISHMENTS WITH SAFETYSEAL CERTIFICATES - '.$province.'</b></td>';
	$html.= '</tr>';

	$html.= '<tr>';
	$html.= '<td style="text-align: center;"><b>As of : '.$date.'</b></td>';
	$html.= '</tr>';
	$html.= '</table>';

	return $html;
}

function generateDetails($data) 
{
	$html = '<table class="table table-bordered" border="1" cellspacing="1" cellpadding="5" style="font-size:10.5pt;">';
	
	$html.= '<tr>';
	$html.= '<td style="text-align:center;"><b>LGU</b></td>';
	$html.= '<td style="text-align:center;"><b>ESTABLISHMENT</b></td>';
	$html.= '<td style="text-align:center;"><b>SSC NO.</b></td>';
	$html.= '<td style="text-align:center;"><b>ADDRESS</b></td>';
	$html.= '</tr>';

	foreach ($data as $key => $dd) {
		$html.= '<tr>';
		$html.= '<td>';
		$html.= $dd['lgu'];
		$html.= '</td>';
		$html.= '<td>';
		$html.= $dd['est'];
		$html.= '</td>';
		$html.= '<td style="text-align:center;">';
		$html.= $dd['ss_no'];
		$html.= '</td>';
		$html.= '<td>';
		$html.= $dd['address'];
		$html.= '</td>';
		$html.= '</tr>';
	}
	$html.='</table>';

	return $html;
}

function getEstablishmentSSCRO($conn, $province)
{
    $sql = "SELECT chkl.id as id, cm.name as lgu, chkl.establishment as est, ui.GOV_ESTB_NAME as est2, chkl.address as address, chkl.safety_seal_no as 'ss_no' 
        FROM `tbl_app_checklist` chkl 
        LEFT JOIN tbl_admin_info ai on chkl.user_id = ai.id
        LEFT JOIN tbl_userinfo ui on ui.USER_ID = ai.id
        LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
        LEFT JOIN tbl_citymun cm on cm.PROVINCE = ai.PROVINCE AND cm.code = ai.LGU 
        WHERE ai.PROVINCE = $province AND chkl.status='Approved' ORDER BY pro.id, chkl.safety_seal_no";

    $query = mysqli_query($conn, $sql);
    $data = [];
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data[$row['id']] = [
                'est' => !empty($row['est']) ? $row['est'] : $row['est2'],
                'ss_no' => !empty($row['ss_no']) ? $row['ss_no'] : 'NO SSC',
                'address' => $row['address'],
                'lgu' => $row['lgu']
            ];
        }
    }

    if ($province == 5) {
	    $sql = "SELECT chkl.id as id, cm.name as lgu, chkl.establishment as est, ui.GOV_ESTB_NAME as est2, chkl.address as address, chkl.safety_seal_no as 'ss_no' 
	        FROM `tbl_app_checklist` chkl 
	        LEFT JOIN tbl_admin_info ai on chkl.user_id = ai.id
	        LEFT JOIN tbl_userinfo ui on ui.USER_ID = ai.id
	        LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
	        LEFT JOIN tbl_citymun cm on cm.PROVINCE = ai.PROVINCE AND cm.code = ai.LGU 
	        WHERE ai.PROVINCE = 8 AND chkl.status='Approved' ORDER BY pro.id, chkl.safety_seal_no";    

	    $query = mysqli_query($conn, $sql);
	    // $data = [];
	    if (mysqli_num_rows($query) > 0) {
	        while ($row = mysqli_fetch_assoc($query)) {
	            $data[$row['id']] = [
	                'est' => !empty($row['est']) ? $row['est'] : $row['est2'],
	                'ss_no' => !empty($row['ss_no']) ? $row['ss_no'] : 'NO SSC',
	                'address' => $row['address'],
	                'lgu' => $row['lgu']
	            ];
	        }
	    }
    }   

    return $data;
}