<?php 
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';
require '../tcpdfv02/tcpdf.php';
require '../manager/ApplicationManager.php';
require '../application/config/connection.php';



$user = fetchtUserDetails($conn, $_GET['control_no']);
$entry = fetchEntry($conn, $_GET['control_no']);
$validations = getUserChecklistsValidations($conn, $_GET['control_no']);

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// $header = getHeader($status);

// set document information
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

$html = generateHeader();
$pdf->writeHTML($html, true, false, true, false, '');

$html = generateTitle();
$pdf->writeHTML($html, true, false, true, false, '');

$html = generateDetails($user);
$pdf->writeHTML($html, true, false, true, false, '');

$html = generateEntry($entry);
$pdf->writeHTML($html, true, false, true, false, '');

$html = generateSignatory($user);
$pdf->writeHTML($html, true, false, true, false, '');

if (in_array($user['status'], ['Approved', 'Disapproved', 'Expired', 'Renewed'])) {
	$html = generateValidations($validations);
	$pdf->writeHTML($html, true, false, true, false, '');

	$html = generateApprover($user);
	$pdf->writeHTML($html, true, false, true, false, '');

	$html = generateInspectionTems($conn);
	$pdf->writeHTML($html, true, false, true, false, '');
}



$pdf->lastPage();
$pdf->Output('personnel_report.pdf', 'I');

function fetchtUserDetails($conn, $control_no)
    {
        $sql = "SELECT 
            ai.id as id,
            ac.id as acid,
            DATE_FORMAT(ac.date_created, '%M %d, %Y') as date_created,
            DATE_FORMAT(ac.date_proceed, '%m-%d-%Y') as date_proceed,
            ui.ADDRESS as address,
            ui.GOV_AGENCY_NAME as agency,
            ui.GOV_ESTB_NAME as establishment, 
            ui.GOV_NATURE_NAME as nature,
            ai.CMLGOO_NAME as fname,
            p.code as pcode,
            m.code as mcode,
            ui.MOBILE_NO as contact_details,
            ac.status as status,
            ac.control_no as control_no,
            ac.establishment as establishment,
            ac.nature as nature,
            ac.address as address,
            ac.safety_seal_no as ssno,
            aip.CMLGOO_NAME as approver,
            DATE_FORMAT(ac.date_approved, '%M %d, %Y') as date_approved
            FROM tbl_app_checklist ac
            LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
            LEFT JOIN tbl_admin_info aip on aip.id = ac.approver_id
            LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
            LEFT JOIN tbl_province p on p.id = ai.PROVINCE
            LEFT JOIN tbl_citymun m on m.id = ai.LGU
            WHERE ac.control_no = '".$control_no."'";
        
        $query = mysqli_query($conn, $sql);
        // $result = mysqli_fetch_array($query);
        $data = [];
        $today = new DateTime();
        $today = $today->format('F d, Y');

        while ($row = mysqli_fetch_assoc($query)) {
            $date_created = $row['date_created'];
            if (empty($date_created)) {
                $date_created = $today;
            }
            $data = [
                'id' => $row['id'],
                'ss_no' => $row['ssno'],
                'acid' => $row['acid'],
                'date_created' => $date_created,
                'address' => $row['address'],
                'agency' => $row['agency'],
                'establishment' => $row['establishment'],
                'nature' => $row['nature'],
                'fname' => $row['fname'],
                'contact_details' => $row['contact_details'],
                'status' => !empty($row['status']) ? $row['status'] : 'Draft',
                'pcode' => $row['pcode'],
                'mcode' => $row['mcode'],
                'code' => !empty($row['control_no']) ? $row['control_no'] : '2021-'.'_____',
                'date_proceed' => $row['date_proceed'],
                'approver' => $row['approver'],
                'date_approved' => $row['date_approved'],
                'today' => $today
            ];      
        }

        return $data;
    }

function fetchEntry($conn, $control_no) {
	$sql = "SELECT c.id as clist_id, c.requirement as requirement, c.description as description, e.id as ulist_id, e.answer as answer, e.reason as reason, a.status as status FROM tbl_app_checklist_entry e LEFT JOIN tbl_app_checklist a on a.id = e.parent_id LEFT JOIN tbl_app_certchecklist c on c.id = e.chklist_id LEFT JOIN tbl_admin_info ai on ai.id = a.user_id WHERE a.control_no = '".$control_no."'";

	$query = mysqli_query($conn, $sql);
	$result = [];
	while ($row = mysqli_fetch_assoc($query)) {
	    $result[$row['ulist_id']] = [
	        'clist_id' => $row['clist_id'],
	        'requirement' => $row['requirement'],
	        'description' => explode('~ ', $row['description']),
	        'ulist_id' => $row['ulist_id'],
	        'answer' => $row['answer'],
	        'reason' => $row['reason']
	    ];    
	}

	return $result;
}

function generateHeader()
{
	$html = '<table class="table table-bordered" style="font-size:9pt;">';
	$html.= '<tr>';
	$html.= '<td style="text-align:center;">';
	$html.= '<img src="../logo_dilg.jpg" style="width:80px; height:80px;">';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td style="text-align:center;">';
	$html.= 'Republic of the Philippines<br>';
	$html.= 'DEPARTMENT OF THE INTERIOR AND LOCAL GOVERNMENT<br>';
	$html.= 'DILG-NAPOLCOM Center, EDSA corner Quezon Avenue, West Triangle, Quezon City<br>';
	$html.= 'http://www.dilg.gov.ph';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '</table>';

	return $html;
}

function generateTitle()
{
	$html = '<table class="table table-bordered">';
	$html.= '<tr>';
	$html.= '<td style="text-align:center; font-size:15pt;">';
	$html.= '<b>SAFETY SEAL CERTIFICATION CHECKLIST</b><br>';
	$html.= '<i style="font-size:9pt;">(DILG as Issuing Authority)</i>';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '</table>';

	return $html;
}


function generateEntry($dd) {
	$html = '<table>';
	$html.= '<tr><td>Instruction: (✓) Check the appropriate box (Yes/No), if the following requirement is provided:</td></tr>';
	$html.= '</table>';

	$html .= '<table class="table-striped" border="1" cellspacing="1" cellpadding="5" style="font-size:9pt; text-align: justify;">';
	
	$html .= '<tr style="text-align:center;">';
	$html .= '<th width="28%;"><b>Requirement</b></th>';
	$html .= '<th width="30%;"><b>MOVs to be Produced/ Uploaded</b></th>';
	$html .= '<th width="8%;"><b>Yes</b></th>';
	$html .= '<th width="8%;"><b>No</b></th>';
	$html .= '<th width="8%;"><b>N/A</b></th>';
	$html .= '<th width="18%;"><b>Reason why N/A</b></th>';
	$html .= '</tr>';
	foreach ($dd as $key => $data) {
		$html .= '<tr nobr="true">';
		$html .= '<td>';
		if ($key == 49559) {
			$html .= 'Availability of designated Safety Officer with the following functions:';
			$html .= '<ol type="a">';
			$html .= '<li>coordinate with the appropriate bodies for support and referral to community-based
isolation facilities for confirmed cases with mild symptoms, and to health facilities for severe and critical care,';
			$html .= '</li>';
			$html .= '<li>undertake contact tracing or coordinate the conduct thereof; and';
			$html .= '</li>';
			$html .= '<li>monitor status of employees quarantined or isolated; and';
			$html .= '</li>';
			$html .= '<li>implement return to work policies.';
			$html .= '</li>';
			$html .= '</ol>';
		} else {
			$html .= $data['requirement'];
		}

		$html .= '</td>';
		$html .= '<td>';
		$html .= '<ul>';
			foreach ($data['description'] as $key => $value) {
				$html .= '<li>';
				$html .= $value;
				$html .= '</li>';
			}
		$html .= '</ul>';
		$html .= '</td>';
		$html .= '<td style="text-align:center;">';
			if ($data['answer'] == 'yes') {
				$html .= '<img src="../check_mark.jpg" style="width:20px; height:20px;">';
			}
		$html .= '</td>';
		$html .= '<td style="text-align:center;">';
			if ($data['answer'] == 'no') {
				$html .= '<img src="../check_mark.jpg" style="width:20px; height:20px;">';
			}
		$html .= '</td>';
		$html .= '<td style="text-align:center;">';
			if ($data['answer'] == 'n/a') {
				$html .= '<img src="../check_mark.jpg" style="width:20px; height:20px;">';
			}
		$html .= '</td>';
		$html .= '<td>';
		$html .= $data['reason'];
		$html .= '</td>';
		$html .= '</tr>';
	}
	$html .= '</table>';

	return $html;
}

function generateValidations($dd)
{
	$html = '<table class="table table-bordered" style="font-size:9pt;">';
	$html.= '<tr>';
	$html.= '<td>';
	$html.= '<b>ONSITE VALIDATION / INSPECTION</b>:';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td>';
	$html.= '</td>';
	$html.= '</tr>';

	$html.= '</table>';

	$html.= '<table class="table table-bordered" style="font-size:9pt;">';
	$html.= '<tr>';
	$html.= '<td>';
	$html.= '<b>Defects / Deficiences noted durind inspection:</b>';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td>';
	$html.= isset($dd['defects']) ? $dd['defects'] : '';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td>';
	$html.= '';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td>';
	$html.= '';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '</table>';

	$html.= '<table class="table table-bordered" style="font-size:9pt;">';
	$html.= '<tr>';
	$html.= '<td>';
	$html.= '<b>Recommendations:</b>';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td>';
	$html.= isset($dd['recommendations']) ? $dd['recommendations'] : '';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '</table>';

	return $html;
}

function generateDetails($dd) 
{
	$html = '<table class="" cellspacing="1" cellpadding="1" style="font-size:10.5pt;">';
	$html.= '<tr>';
	$html.= '<td>Control No:</td>';

	if (!empty($dd['ss_no'])) {
		$html.= '<td>Safetyseal No:</td>';
	} else {
		$html.= '<td></td>';
	}

	$html.= '<td>Date Created:</td>';
	$html.= '</tr>';

	$html.= '<tr style="line-height:180%;">';
	$html.= '<td style="background-color:#e9ecef; border:2px solid #ced4da;">  '.$dd['code'];
	$html.= '</td>';

	if (in_array($dd['status'], ['Expired', 'Revoked'])) {
		$html.= '<td style="background-color:red; border:2px solid white; color:white;">  <b>'.$dd['ss_no'];
		$html.= ' ('.strtoupper($dd['status']).')</b></td>';
	} elseif (!empty($dd['ss_no'])) {
		$html.= '<td style="background-color:green; border:2px solid white; color:white;">  <b>'.$dd['ss_no'];
		$html.= '</b></td>';
	} else {
		$html.= '<td></td>';
	}
	
	$html.= '<td style="background-color:#e9ecef; border:2px solid #ced4da;">  '.$dd['date_created'];
	$html.= '</td>';
	$html.= '</tr>';

	$html.= '<tr>';
	$html.= '<td colspan="5">Name of Government Agency/ Office:</td>';
	$html.= '</tr>';

	$html.= '<tr style="line-height:180%;">';
	$html.= '<td colspan="5" style="background-color:#e9ecef; border:2px solid #ced4da;">  '.$dd['agency'];
	$html.= '</td>';
	$html.= '</tr>';

	$html.= '<tr>';
	$html.= '<td colspan="5">Name of Government Establishment/Department/Office/Unit:</td>';
	$html.= '</tr>';

	$html.= '<tr style="line-height:180%;">';
	$html.= '<td colspan="5" style="background-color:#e9ecef; border:2px solid #ced4da;">  '.$dd['establishment'];
	$html.= '</td>';
	$html.= '</tr>';

	$html.= '<tr>';
	$html.= '<td colspan="5">Nature of Government Establishment/Department/Office/Unit:</td>';
	$html.= '</tr>';

	$html.= '<tr style="line-height:180%;">';
	$html.= '<td colspan="5" style="background-color:#e9ecef; border:2px solid #ced4da;">  '.$dd['nature'];
	$html.= '</td>';
	$html.= '</tr>';

	$html.= '<tr>';
	$html.= '<td colspan="5">Address:</td>';
	$html.= '</tr>';

	$html.= '<tr style="line-height:180%; text-align: justify;">';
	$html.= '<td colspan="5" style="background-color:#e9ecef; border:2px solid #ced4da;">  '.$dd['address'];
	$html.= '</td>';
	$html.= '</tr>';

	$html.= '<tr>';
	$html.= '<td>Name of Person in Charge:</td>';
	$html.= '<td>';
	$html.= '</td>';
	$html.= '<td>Contact Details:</td>';
	$html.= '</tr>';

	$html.= '<tr style="line-height:180%;">';
	$html.= '<td style="background-color:#e9ecef; border:2px solid #ced4da;">  '.$dd['fname'];
	$html.= '</td>';
	$html.= '<td>';
	$html.= '</td>';
	$html.= '<td style="background-color:#e9ecef; border:2px solid #ced4da;">  '.$dd['contact_details'];
	$html.= '</td>';
	$html.= '</tr>';

	$html .= '</table>';

	return $html;
}

function generateSignatory($dd)
{
	$html = '<table class="table table-bordered">';
	$html.= '<tr>';
	$html.= '<td style="font-size:9pt;">';
	$html.= '<i>I hereby certify that the facts stated herein are true and correct of my own personal knowledge and any misrepresentation subjects me to criminal or administrative liability.</i>';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td colspan="2">';
	$html.= '<br><br><br><br><br>';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '</table>';

	$html.= '<table class="table table-bordered">';
	$html.= '<tr>';
	$html.= '<td style="width:30%;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="width:30%;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt; width: 40%;">';
	$html.= '<b>'.$dd['fname'].' / '.$dd['date_created'].'</b>';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td style="width:30%;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="width:30%;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:right; font-size:9pt; border-top: 1px solid black; width:40%;">';
	$html.= '<b>Name and Signature of Person in Charge / Date</b>';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '</table>';

	return $html;
}

function generateApprover($dd)
{
	$html = '<table class="table table-bordered">';
	$html.= '<tr>';
	$html.= '<td style="font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td colspan="2">';
	$html.= '<br><br><br>';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '</table>';

	$html.= '<table class="table table-bordered">';
	$html.= '<tr>';
	$html.= '<td style="width:30%;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="width:30%;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:right; font-size:9pt;">';
	$html.= '<b>'.$dd['approver'].' / '.$dd['today'].'</b>';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td style="width:28%;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="width:28%;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:right; font-size:9pt; border-top: 1px solid black; width:44%;">';
	$html.= '<b>Name and Signature of Safety Seal Inspector / Date</b>';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '</table>';

	return $html;
}

function generateInspectionTems($conn)
{
	$html = '<table class="table table-bordered">';
	$html.= '<tr>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td style="font-size:10pt;">';
	$html.= '<b>Inspection and Certification Teams:</b>';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '</table>';

	$sql = ' SELECT `user_id` FROM `tbl_app_checklist` WHERE `control_no` = "'.$_GET['control_no'].'" ';
	$query = $conn->query($sql);
	$res = $query->fetch_assoc();

	$selectUserInfo = ' SELECT `ID`, `REGION`, `PROVINCE`, `LGU`, `OFFICE`, `CMLGOO_NAME`, `UNAME`, `PASSWORD`, `VERIFICATION_CODE`, `IS_APPROVED`, `IS_VERIFIED`, `ROLES`, `EMAIL` FROM `tbl_admin_info` WHERE `ID` = '.$res['user_id'].' ';
	$execUserInfo = $conn->query($selectUserInfo);
	$userInfo = $execUserInfo->fetch_assoc();
	$province = $userInfo['PROVINCE'];
	$lgu = $userInfo['LGU'];

	$selectInspectionTeam = ' SELECT `ID`, `PROVINCE`, `PROVINCE_ID`, `LGU`, `LGU_ID`, `NAME`, `EMAIL_ADDRESS`, `CONTACT_NO`, `PNP`, `BFP`, `ICT_HOTLINE`, `EMAIL_ADDRESS_COMPLAINTS` FROM `tbl_inspection_team` WHERE `PROVINCE_ID` = "'.$province.'" AND `LGU_ID` = "'.$lgu.'" ';
	$execInspectionTeam = $conn->query($selectInspectionTeam);
	$inspector = $execInspectionTeam->fetch_assoc();

	$html.= '<table class="table table-bordered">';
	$html.= '<tr>';
	$html.= '<td style="text-align:center; font-size:9pt; width:33.3%;">';
	// $html.= '<u><b>Jennifer S. Quirante</b></u>';
	$html.= '<u><b>'.$inspector['NAME'].'</b></u>';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt; width:33.3%;">';
	// $html.= '<u><b>PLTCOL Jonathan B. Villamor</b></u>';
	$html.= '<u><b>'.$inspector['PNP'].'</b></u>';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt; width:33.3%;">';
	// $html.= '<u><b>FCINSP Alexander Dale Q. Baena</b></u>';
	$html.= '<u><b>'.$inspector['BFP'].'</b></u>';
	$html.= '</td>';
	$html.= '</tr>';
	$html.= '<tr>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '<b>DILG OFFICER</b>';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '<b>PNP OFFICER</b>';
	$html.= '</td>';
	$html.= '<td style="text-align:center; font-size:9pt;">';
	$html.= '<b>BFP OFFICER</b>';
	$html.= '</td>';
	$html.= '</tr>';

	$html.= '</table>';

	

	return $html;
}

function getUserChecklistsValidations($conn, $id)
{
    $sql = "SELECT 
        v.defects as defects,
        v.recommendations as recommendations
        FROM tbl_app_checklist_onsitevalidations v
        LEFT JOIN tbl_app_checklist a on a.id = v.chklist_id
        WHERE a.control_no = '".$id."'";

    $query = mysqli_query($conn, $sql);
    $data = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $data = [
            'defects' => utf8_decode($row['defects']),
            'recommendations' => utf8_decode($row['recommendations'])
        ];    
    }

    return $data;
}