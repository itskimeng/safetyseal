<?php
date_default_timezone_set('Asia/Manila');

require 'application/config/connection.php';
require 'manager/ApplicationManager.php';

$app = new ApplicationManager();

$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];
$is_clusterhead = $_SESSION['is_clusterhead'];
$clusterhead_id = $_SESSION['clusterhead_id'];
$is_pfp = $_SESSION['is_pfp'];
$is_rofp = (($province == 0) && ($citymun == 00));
$hlbl = ""; 

if ($is_rofp) {
    $hlbl = '(REGIONAL OFFICE FOCAL PERSON)';
}

if ($is_clusterhead) {
	$hlbl = '(CLUSTERHEAD)';
} 

if ($is_pfp) {
	$hlbl = '(PROVINCIAL FOCAL PERSON)';
} 

$is_adminro = false;
$today = new DateTime();

if ($province == 0 AND $citymun == 00) {
	$is_adminro = true;
}

$_SESSION['gcode'] = isset($_GET['code']) ? $_GET['code'] : '';
$_SESSION['gscope'] = isset($_GET['scope']) ? $_GET['scope'] : '';

$status_opts = $app->getStatusOptions();
$apptype_opts = $app->getAppTypeOptions();
$province_opts = $app->getProvinces();

if (!$is_clusterhead) {
	$citymun_opts = $app->getCityMuns($province);
} else {
	$citymun_opts = getget($conn, $clusterhead_id);
}
$today1 = $today->format('m');
$current_time = $today->format('m/d/Y h:i:s a');
$month_options = month_options($today1);

$timestamp = date('Y-m-d H:i:s', time());

if (!$is_adminro) {
	if ($is_pfp) {
		$applicants = getPFPApplicationLists($conn, $province, ApplicationManager::STATUS_DRAFT);
	} elseif (!$is_clusterhead) {
		$applicants = $app->getApplicationLists($province, $citymun, ApplicationManager::STATUS_DRAFT);
	} else {
		$applicants = getApplicationLists($conn, $province, $citymun_opts, ApplicationManager::STATUS_DRAFT, $is_clusterhead);
	}
	$client_details = $app->getNotifDetailsClients(ApplicationManager::STATUS_APPROVED);
} else {
	$applicants = $app->getAllApplicationLists();
	$reports['total_application'] = $app->showAllApplications('',$timestamp);
	$reports['total_received'] = $app->showAllApplications('',$timestamp,ApplicationManager::STATUS_RECEIVED);
	$reports['total_approved'] = $app->showAllApplications('',$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['total_disapproved'] = $app->showAllApplications('',$timestamp,ApplicationManager::STATUS_DISAPPROVED);
	// $reports['total_returned'] = $app->showAllApplications('',$timestamp,ApplicationManager::STATUS_RETURNED);
	// $reports['total_reassess'] = $app->showAllApplications('',$timestamp,ApplicationManager::STATUS_REASSESS);

	// $reports['total_disapproved'] = $reports['total_disapproved'] + $reports['total_returned'] + $reports['total_reassess'];

	$reports['batangas_application'] = $app->showAllApplications(3,$timestamp);
	$reports['batangas_received'] = $app->showAllApplications(3,$timestamp,ApplicationManager::STATUS_RECEIVED);
	$reports['batangas_approved'] = $app->showAllApplications(3,$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['batangas_disapproved'] = $app->showAllApplications(3,$timestamp,ApplicationManager::STATUS_DISAPPROVED);
	// $reports['batangas_returned'] = $app->showAllApplications(3,$timestamp,ApplicationManager::STATUS_RETURNED);
	// $reports['batangas_reassess'] = $app->showAllApplications(3,$timestamp,ApplicationManager::STATUS_REASSESS);

	// $reports['batangas_disapproved'] = $reports['batangas_disapproved'] + $reports['batangas_returned'];

	$reports['cavite_application'] = $app->showAllApplications(1,$timestamp);
	$reports['cavite_received'] = $app->showAllApplications(1,$timestamp,ApplicationManager::STATUS_RECEIVED);
	$reports['cavite_approved'] = $app->showAllApplications(1,$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['cavite_disapproved'] = $app->showAllApplications(1,$timestamp,ApplicationManager::STATUS_DISAPPROVED);
	// $reports['cavite_returned'] = $app->showAllApplications(1,$timestamp,ApplicationManager::STATUS_RETURNED);
	// $reports['cavite_reassess'] = $app->showAllApplications(1,$timestamp,ApplicationManager::STATUS_REASSESS);

	// $reports['cavite_disapproved'] = $reports['cavite_disapproved'] + $reports['cavite_returned'];

	$reports['laguna_application'] = $app->showAllApplications(2,$timestamp);
	$reports['laguna_received'] = $app->showAllApplications(2,$timestamp,ApplicationManager::STATUS_RECEIVED);
	$reports['laguna_approved'] = $app->showAllApplications(2,$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['laguna_disapproved'] = $app->showAllApplications(2,$timestamp,ApplicationManager::STATUS_DISAPPROVED);
	// $reports['laguna_returned'] = $app->showAllApplications(2,$timestamp,ApplicationManager::STATUS_RETURNED);
	// $reports['laguna_reassess'] = $app->showAllApplications(2,$timestamp,ApplicationManager::STATUS_REASSESS);

	// $reports['laguna_disapproved'] = $reports['laguna_disapproved'] + $reports['laguna_returned'];

	$reports['rizal_application'] = $app->showAllApplications(4,$timestamp);
	$reports['rizal_received'] = $app->showAllApplications(4,$timestamp,ApplicationManager::STATUS_RECEIVED);
	$reports['rizal_approved'] = $app->showAllApplications(4,$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['rizal_disapproved'] = $app->showAllApplications(4,$timestamp,ApplicationManager::STATUS_DISAPPROVED);
	// $reports['rizal_returned'] = $app->showAllApplications(4,$timestamp,ApplicationManager::STATUS_RETURNED);
	// $reports['rizal_reassess'] = $app->showAllApplications(4,$timestamp,ApplicationManager::STATUS_REASSESS);

	// $reports['rizal_disapproved'] = $reports['rizal_disapproved'] + $reports['rizal_returned'];

	$reports['huc_application'] = $app->showAllApplications('huc',$timestamp);
	$reports['huc_received'] = $app->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_RECEIVED);
	$reports['huc_approved'] = $app->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['huc_disapproved'] = $app->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_DISAPPROVED);
	// $reports['huc_returned'] = $app->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_RETURNED);
	// $reports['huc_reassess'] = $app->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_REASSESS);

	// $reports['huc_disapproved'] = $reports['huc_disapproved'] + $reports['huc_returned'];

}

if ($is_pfp) {
	$citymun = '';	
}

function getget($conn, $id)
{
	$sql = "SELECT * FROM tbl_cluster_head where id = $id";	
	$query = mysqli_query($conn, $sql);
	$result = mysqli_fetch_array($query);

	$rr = json_decode($result['citymun']);
	$rr = implode(',', $rr);

	$sql2 = "SELECT * FROM tbl_citymun where id IN ($rr)";
	$result2 = mysqli_query($conn, $sql2);

	$data = [];
        
    while ($row = mysqli_fetch_assoc($result2)) {
        $data[$row['id']] = [
            'province' => $row['province'],
            'code' => $row['code'],
            'name' => $row['name']
        ];    
       
    }

	return $data;
}

function month_options($today) {
	$options = [
		'01' => 'January',
		'02' => 'February',
		'03' => 'March',
		'04' => 'April',
		'05' => 'May',
		'06' => 'June',
		'07' => 'July',
		'08' => 'August',
		'09' => 'September',
		'10' => 'October',
		'11' => 'November',
		'12' => 'December'
	];

	$dd = [];

	foreach ($options as $key => $opt) {
		if ($key <= $today) {
			$dd[$key] = $opt;
		}
	}

	return $dd;
}

function getApplicationLists($conn, $province, $lgus, $status, $is_clusterhead)
{
	$data = [];

	foreach ($lgus as $key => $lgu) {
		$codes[] = $lgu['code']; 
	}

	$codes = implode(',', $codes);

	$bsql = "SELECT ac.id as id,ai.CMLGOO_NAME as fname,ui.GOV_AGENCY_NAME as pagency, ac.agency as cagency, ui.ADDRESS as address,DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,DATE_FORMAT(ac.date_approved, '%Y-%m-%d H:i:s') as date_approved,ui.id as userid,ac.control_no as control_no,ac.safety_seal_no as ss_no,ac.status as status,ac.address as ac_address,ac.application_type as app_type,ac.token as token
	    FROM tbl_app_checklist ac
	    LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
	    LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id";

	$sql1 = " WHERE ai.PROVINCE = ".$province." AND ai.LGU IN (".$codes.") AND ac.application_type = 'Applied' AND ac.status <> '".$status."'";

	$query = mysqli_query($conn, $bsql.$sql1);
	    
    while ($row = mysqli_fetch_assoc($query)) {
        $color = 'green';
        if ($row['status'] == 'For Receiving') {
            $color = 'primary';
        } elseif ($row['status'] == 'Received') {
            $color = 'yellow';
        } elseif ($row['status'] == 'Disapproved') {
            $color = 'red';
        }

        $data[$row['id']] = [
            'id' => $row['id'],
            'userid' => $row['userid'],
            'fname' => $row['fname'],
            'agency' => $row['pagency'],
            'address' => $row['address'],
            'date_created' => date('F d, Y', strtotime($row['date_created'])),
            'control_no' => $row['control_no'],
            'ss_no' => $row['ss_no'],
            'status' => $row['status'],
            'color' => $color,
            'ac_address' => $row['ac_address'],
            'app_type' => $row['app_type'],
            'token' => $row['token'],
            'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
        ];    
    }

    $sql2 = " WHERE ai.PROVINCE = ".$province." AND ac.application_type = 'Encoded' AND ac.lgu IN (".$codes.")";	
    
    $query = mysqli_query($conn, $bsql.$sql2);
    
    while ($row = mysqli_fetch_assoc($query)) {
        $color = 'green';
        if ($row['status'] == 'For Receiving') {
            $color = 'primary';
        } elseif ($row['status'] == 'Received') {
            $color = 'yellow';
        } elseif ($row['status'] == 'Disapproved') {
            $color = 'red';
        }

        $data[$row['id']] = [
            'id' => $row['id'],
            'userid' => $row['userid'],
            'fname' => $row['fname'],
            'agency' => !empty($row['cagency']) ? $row['cagency'] : $row['pagency'],
            'address' => $row['address'],
            'date_created' => date('F d, Y', strtotime($row['date_created'])),
            'control_no' => $row['control_no'],
            'ss_no' => $row['ss_no'],
            'status' => $row['status'],
            'color' => $color,
            'ac_address' => $row['ac_address'],
            'app_type' => $row['app_type'],
            'token' => $row['token'],
            'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
        ];    
    }

    $sql3 = " WHERE ai.PROVINCE = ".$province." AND ac.application_type = 'Encoded' AND ai.LGU IN (".$codes.")";
    
    $query = mysqli_query($conn, $bsql.$sql3);
    
    while ($row = mysqli_fetch_assoc($query)) {
        $color = 'green';
        if ($row['status'] == 'For Receiving') {
            $color = 'primary';
        } elseif ($row['status'] == 'Received') {
            $color = 'yellow';
        } elseif ($row['status'] == 'Disapproved') {
            $color = 'red';
        }

        $data[$row['id']] = [
            'id' => $row['id'],
            'userid' => $row['userid'],
            'fname' => $row['fname'],
            'agency' => !empty($row['cagency']) ? $row['cagency'] : $row['pagency'],
            'address' => $row['address'],
            'date_created' => date('F d, Y', strtotime($row['date_created'])),
            'control_no' => $row['control_no'],
            'ss_no' => $row['ss_no'],
            'status' => $row['status'],
            'color' => $color,
            'ac_address' => $row['ac_address'],
            'app_type' => $row['app_type'],
            'token' => $row['token'],
            'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
        ];    
    }

    return $data;

}

function generateData($result)
{

	$data = [];
	while ($row = mysqli_fetch_assoc($result)) {
        $color = 'green';
        if ($row['status'] == 'For Receiving') {
            $color = 'primary';
        } elseif ($row['status'] == 'Received') {
            $color = 'yellow';
        } elseif ($row['status'] == 'Disapproved') {
            $color = 'red';
        }

        $data[$row['id']] = [
            'id' 				=> $row['id'],
            'userid'	 		=> $row['userid'],
            'fname' 			=> $row['fname'],
            'agency' 			=> !empty($row['cagency']) ? $row['cagency'] : $row['pagency'],
            'address' 			=> $row['address'],
            'date_created' 		=> $row['date_created'],
            'control_no' 		=> $row['control_no'],
            'ss_no' 			=> $row['ss_no'],
            'status' 			=> $row['status'],
            'color' 			=> $color,
            'ac_address' 		=> $row['ac_address'],
            'app_type' 			=> $row['app_type'],
            'token' 			=> $row['token'],
            'validity_date' 	=> !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
        ];    
    }

    return $data;
}

function getPFPApplicationLists($conn, $province, $status)
{
	$data = [];

    $sql = "SELECT 
	    ac.id as id,
	    ai.CMLGOO_NAME as fname,
	    ui.GOV_AGENCY_NAME as pagency,
	    ac.agency as cagency,
	    ui.ADDRESS as address,
	    DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
	    DATE_FORMAT(ac.date_approved, '%Y-%m-%d') as date_approved,
	    ui.id as userid,
	    ac.control_no as control_no,
	    ac.safety_seal_no as ss_no,
	    ac.status as status,
	    ac.address as ac_address,
	    ac.application_type as app_type,
	    ac.person as person,
	    ac.token as token
	    FROM tbl_app_checklist ac
	    LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
	    LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id";

	$sql1 = " WHERE ai.PROVINCE = ".$province." AND ac.application_type = 'Applied' AND ac.status <> '$status'";
	 
	    $query = mysqli_query($conn, $sql.$sql1);

	    
	    while ($row = mysqli_fetch_assoc($query)) {
	        $color = 'green';
	        if ($row['status'] == 'For Receiving') {
	            $color = 'primary';
	        } elseif ($row['status'] == 'Received') {
	            $color = 'yellow';
	        } elseif ($row['status'] == 'Disapproved') {
	            $color = 'red';
	        }

	        $data[$row['id']] = [
	            'id' => $row['id'],
	            'userid' => $row['userid'],
	            'fname' => !empty($row['person']) ? $row['person'] : $row['fname'],
	            'agency' => $row['pagency'],
	            'address' => $row['address'],
	            'date_created' => date('F d, Y', strtotime($row['date_created'])),
	            'control_no' => $row['control_no'],
	            'ss_no' => $row['ss_no'],
	            'status' => $row['status'],
	            'color' => $color,
	            'ac_address' => $row['ac_address'],
	            'app_type' => $row['app_type'],
	            'token' => $row['token'],
	            'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
	        ];    
	    }

	    // $sql2 = "SELECT 
	    // ac.id as id,
	    // ai.CMLGOO_NAME as fname,
	    // ui.GOV_AGENCY_NAME as pagency,
	    // ac.agency as cagency,
	    // ui.ADDRESS as address,
	    // DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
	    // DATE_FORMAT(ac.date_approved, '%Y-%m-%d') as date_approved,
	    // ui.id as userid,
	    // ac.control_no as control_no,
	    // ac.safety_seal_no as ss_no,
	    // ac.status as status,
	    // ac.address as ac_address,
	    // ac.application_type as app_type,
	    // ac.person as person,
	    // ac.token as token
	    // FROM tbl_app_checklist ac
	    // LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
	    // LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
	    // WHERE ai.PROVINCE = ".$province." AND ac.application_type = 'Encoded' AND ac.status = 'Approved'";

	    $sql2 = " WHERE ai.PROVINCE = ".$province." AND ac.application_type = 'Encoded'";
	 
	    $query = mysqli_query($conn, $sql.$sql2);
	    // $data = [];
	    
	    while ($row = mysqli_fetch_assoc($query)) {
	        $color = 'green';
	        if ($row['status'] == 'For Receiving') {
	            $color = 'primary';
	        } elseif ($row['status'] == 'Received') {
	            $color = 'yellow';
	        } elseif ($row['status'] == 'Disapproved') {
	            $color = 'red';
	        }

	        $data[$row['id']] = [
	            'id' => $row['id'],
	            'userid' => $row['userid'],
	            'fname' => !empty($row['person']) ? $row['person'] : $row['fname'],
	            'agency' => !empty($row['cagency']) ? $row['cagency'] : $row['pagency'],
	            'address' => $row['address'],
	            'date_created' => $row['date_created'],
	            'control_no' => $row['control_no'],
	            'ss_no' => $row['ss_no'],
	            'status' => $row['status'],
	            'color' => $color,
	            'ac_address' => $row['ac_address'],
	            'app_type' => $row['app_type'],
	            'token' => $row['token'],
	            'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
	        ];    
	    }
	// }


    return $data;

}
