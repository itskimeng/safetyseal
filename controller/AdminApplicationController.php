<?php
date_default_timezone_set('Asia/Manila');

require 'Model/Connection.php';
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
       // FOR PROVINCIAL FOCAL PERSONS
	   $applicants = getPFPApplicationLists($conn, $province, ApplicationManager::STATUS_DRAFT);
	} elseif (!$is_clusterhead) {
       // FOR MLGOO ACCOUNTS
        $applicants = $app->getUserApplications($province, $citymun, ApplicationManager::STATUS_DRAFT); 
	   // $applicants = $app->getApplicationLists($province, $citymun, ApplicationManager::STATUS_DRAFT);
	} else {
		$applicants = getApplicationLists($conn, $province, $citymun_opts, ApplicationManager::STATUS_DRAFT, $is_clusterhead);
	}
	// $client_details = $app->getNotifDetailsClients(ApplicationManager::STATUS_APPROVED);
} else {
	$applicants = $app->getAllApplicationLists();
	$reports['total_application'] = $app->showAllApplications('',$timestamp);
	$reports['total_received'] = $app->showAllApplications('',$timestamp,ApplicationManager::STATUS_RECEIVED);
    $reports['total_approved'] = $app->showAllApplications('',$timestamp,ApplicationManager::STATUS_APPROVED);
    $reports['total_renewed'] = $app->showAllApplications('',$timestamp,ApplicationManager::STATUS_RENEWED);
	$reports['total_disapproved'] = $app->showAllApplications('',$timestamp,ApplicationManager::STATUS_DISAPPROVED);

	$reports['cavite_application'] = $app->showAllApplications(1,$timestamp);
	$reports['cavite_received'] = $app->showAllApplications(1,$timestamp,ApplicationManager::STATUS_RECEIVED);
    $reports['cavite_approved'] = $app->showAllApplications(1,$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['cavite_renewed'] = $app->showAllApplications(1,$timestamp,ApplicationManager::STATUS_RENEWED);
	$reports['cavite_disapproved'] = $app->showAllApplications(1,$timestamp,ApplicationManager::STATUS_DISAPPROVED);
	
	$reports['laguna_application'] = $app->showAllApplications(2,$timestamp);
    $reports['laguna_received'] = $app->showAllApplications(2,$timestamp,ApplicationManager::STATUS_RECEIVED);
    $reports['laguna_approved'] = $app->showAllApplications(2,$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['laguna_renewed'] = $app->showAllApplications(2,$timestamp,ApplicationManager::STATUS_RENEWED);
	$reports['laguna_disapproved'] = $app->showAllApplications(2,$timestamp,ApplicationManager::STATUS_DISAPPROVED);

	$reports['batangas_application'] = $app->showAllApplications(3,$timestamp);
	$reports['batangas_received'] = $app->showAllApplications(3,$timestamp,ApplicationManager::STATUS_RECEIVED);
	$reports['batangas_approved'] = $app->showAllApplications(3,$timestamp,ApplicationManager::STATUS_APPROVED);
    $reports['batangas_renewed'] = $app->showAllApplications(3,$timestamp,ApplicationManager::STATUS_RENEWED);
	$reports['batangas_disapproved'] = $app->showAllApplications(3,$timestamp,ApplicationManager::STATUS_DISAPPROVED);
	
	$reports['rizal_application'] = $app->showAllApplications(4,$timestamp);
	$reports['rizal_received'] = $app->showAllApplications(4,$timestamp,ApplicationManager::STATUS_RECEIVED);
    $reports['rizal_approved'] = $app->showAllApplications(4,$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['rizal_renewed'] = $app->showAllApplications(4,$timestamp,ApplicationManager::STATUS_RENEWED);
	$reports['rizal_disapproved'] = $app->showAllApplications(4,$timestamp,ApplicationManager::STATUS_DISAPPROVED);
	
	$reports['huc_application'] = $app->showAllApplications('huc',$timestamp);
	$reports['huc_received'] = $app->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_RECEIVED);
	$reports['huc_approved'] = $app->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_APPROVED);
    $reports['huc_renewed'] = $app->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_RENEWED);
	$reports['huc_disapproved'] = $app->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_DISAPPROVED);
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
	$colors = [
    	'Draft'			    => 'secondary',
    	'For Receiving'     => 'primary',
        'For Reassessment'  => 'primary',
    	'Received'          => 'yellow',
    	'Disapproved'       => 'red',
    	'Returned' 		    => 'red',
    	'Approved' 		    => 'green'
    ];

    $date_today = new DateTime();
    $date_today = date('Y-m-d', strtotime($date_today->format('Y-m-d')));

	foreach ($lgus as $key => $lgu) {
		$codes[] = $lgu['code']; 
	}

	$codes = implode(',', $codes);

	// $bsql = "SELECT 
 //                ac.id as id,
 //                ai.CMLGOO_NAME as fname,
 //                ui.GOV_AGENCY_NAME as pagency, 
 //                ac.agency as cagency, 
 //                ui.ADDRESS as address,
 //                DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
 //                DATE_FORMAT(ac.date_approved, '%Y-%m-%d H:i:s') as date_approved,
 //                ui.id as userid,
 //                ac.control_no as control_no,
 //                ac.safety_seal_no as ss_no,
 //                ac.status as status,
 //                ac.address as ac_address,
 //                ac.application_type as app_type,
 //                ac.token as token, 
 //                ac.for_renewal
 //    	    FROM tbl_app_checklist ac
 //    	    LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
 //    	    LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id";

    $bsql = "SELECT 
                ac.id AS id,
                ai.CMLGOO_NAME AS fname,
                ui.GOV_AGENCY_NAME AS pagency,
                ui.ADDRESS AS address,
                DATE_FORMAT(ac.date_created, '%Y-%m-%d') AS date_created,
                ac.date_created AS date_createds,
                DATE_FORMAT(ac.date_approved, '%Y-%m-%d') AS date_approved,
                ui.id AS userid,
                ai.id AS aid,
                ac.control_no AS control_no,
                ac.safety_seal_no AS ss_no,
                ac.status AS stats,
                ac.address AS ac_address,
                ac.application_type AS app_type,
                ac.token AS token,
                ac.for_renewal AS for_renewal,
                ac.status
            FROM tbl_app_checklist ac
            LEFT JOIN tbl_admin_info ai ON ai.id = ac.user_id
            LEFT JOIN tbl_userinfo ui ON ui.user_id = ai.id";
            // WHERE ai.PROVINCE = '".$province."' AND ai.LGU = '".$lgu."' AND ac.application_type = 'Applied' AND ac.status <> 'Draft' AND ac.status <> 'Returned' AND ac.status <> 'Reassess' 
            // ORDER BY ai.id, ac.id DESC 
            // LIMIT 18446744073709551615";


	$sql1 = " WHERE ai.PROVINCE = ".$province." AND ai.LGU IN (".$codes.") AND ac.application_type = 'Applied' AND ac.status <> '".$status."' AND ac.status <> 'Returned'";
    $sql1 .= " ORDER BY ai.id, ac.id DESC LIMIT 18446744073709551615";

    // $sub_qry = "SELECT * FROM (".$bsql.$sql1.") AS subqry GROUP BY aid" ;

    // print_r($sub_qry);
    // die();

	$query = mysqli_query($conn, $bsql.$sql1);
	    
    while ($row = mysqli_fetch_assoc($query)) {
        if (($row['status'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
            $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
            $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
        } else {
            $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
            $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
        }

        $date1 = date_create($date_today);
        $date2 = date_create($date_validity);
        $interval = $date1->diff($date2);
        
        $status = $row['status'];
        if (!empty($row['date_approved'])) {
            if ($row['status'] == 'For Renewal') {
                $status = $row['status'];
            } elseif ($date_today >= $date_validity) {
                $status = 'Expired';
            }
        }

        $data[$row['id']] = [
            'id' 			=> $row['id'],
            'userid' 		=> $row['userid'],
            'fname' 		=> $row['fname'],
            'agency' 		=> $row['pagency'],
            'address' 		=> $row['address'],
            'date_created' 	=> date('F d, Y', strtotime($row['date_created'])),
            'control_no' 	=> $row['control_no'],
            'ss_no' 		=> $row['ss_no'],
            'status' 		=> $status,
            'for_renewal'   => $row['for_renewal'],
            'color' 		=> $colors[$row['status']],
            'ac_address' 	=> $row['ac_address'],
            'app_type' 		=> $row['app_type'],
            'token' 		=> $row['token'],
            'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : '',
            'issued_date'   => date('M d, Y', strtotime($row['date_approved']))
        ];    
    }

    $sql2 = " WHERE ai.PROVINCE = ".$province." AND ac.application_type = 'Encoded' AND ac.lgu IN (".$codes.")";	
    
    $query = mysqli_query($conn, $bsql.$sql2);
    
    while ($row = mysqli_fetch_assoc($query)) {
        if (($row['status'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
            $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
            $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
        } else {
            $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
            $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
        }

        $date1 = date_create($date_today);
        $date2 = date_create($date_validity);
        $interval = $date1->diff($date2);
        
        $status = $row['status'];
        if (!empty($row['date_approved'])) {
            if ($row['status'] == 'For Renewal') {
                $status = $row['status'];
            } elseif ($date_today >= $date_validity) {
                $status = 'Expired';
            }
        }

        $data[$row['id']] = [
            'id' 			=> $row['id'],
            'userid' 		=> $row['userid'],
            'fname' 		=> $row['fname'],
            'agency' 		=> !empty($row['cagency']) ? $row['cagency'] : $row['pagency'],
            'address' 		=> $row['address'],
            'date_created' 	=> date('F d, Y', strtotime($row['date_created'])),
            'control_no' 	=> $row['control_no'],
            'ss_no' 		=> $row['ss_no'],
            'status' 		=> $status,
            'color' 		=> $colors[$row['status']],
            'ac_address' 	=> $row['ac_address'],
            'app_type' 		=> $row['app_type'],
            'token' 		=> $row['token'],
            'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : '',
            'issued_date'   => date('M d, Y', strtotime($row['date_approved']))
        ];    
    }

    $sql3 = " WHERE ai.PROVINCE = ".$province." AND ac.application_type = 'Encoded' AND ai.LGU IN (".$codes.")";
    
    $query = mysqli_query($conn, $bsql.$sql3);
    
    while ($row = mysqli_fetch_assoc($query)) {
        if (($row['status'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
            $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
            $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
        } else {
            $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
            $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
        }

        $date1 = date_create($date_today);
        $date2 = date_create($date_validity);
        $interval = $date1->diff($date2);
        
        $status = $row['status'];
        if (!empty($row['date_approved'])) {
            if ($row['status'] == 'For Renewal') {
                $status = $row['status'];
            } elseif ($date_today >= $date_validity) {
                $status = 'Expired';
            }
        }

        $data[$row['id']] = [
            'id' 			=> $row['id'],
            'userid' 		=> $row['userid'],
            'fname' 		=> $row['fname'],
            'agency'	 	=> !empty($row['cagency']) ? $row['cagency'] : $row['pagency'],
            'address' 		=> $row['address'],
            'date_created' 	=> date('F d, Y', strtotime($row['date_created'])),
            'control_no' 	=> $row['control_no'],
            'ss_no' 		=> $row['ss_no'],
            'status' 		=> $status,
            'color' 		=> $colors[$row['status']],
            'ac_address' 	=> $row['ac_address'],
            'app_type' 		=> $row['app_type'],
            'token' 		=> $row['token'],
            'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : '',
            'issued_date'   => date('M d, Y', strtotime($row['date_approved']))
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
    $date_today = new DateTime();
    $date_today = date('Y-m-d', strtotime($date_today->format('Y-m-d')));
    
    $data = [];
    $colors = [
        'Draft'         => 'secondary',
        'For Receiving' => 'primary',
        'Reassess'      => 'primary',
        'Received'      => 'yellow',
        'Disapproved'   => 'red',
        'Returned'      => 'red',
        'Approved'      => 'green'
    ];

    // $sql = "SELECT ac.id as id, ai.CMLGOO_NAME as fname, ui.GOV_AGENCY_NAME as pagency, ac.agency as cagency,
       //  ui.ADDRESS as address, DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created, DATE_FORMAT(ac.date_approved, '%Y-%m-%d') as date_approved, ui.id as userid, ac.control_no as control_no, ac.safety_seal_no as ss_no,
       //  ac.status as status, ac.address as ac_address, ac.application_type as app_type, ac.person as person,
       //  ac.token as token FROM tbl_app_checklist ac LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
       //  LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id";

    $bsql = "SELECT 
                ac.id AS id,
                ai.CMLGOO_NAME AS fname,
                ui.GOV_AGENCY_NAME AS agency,
                ui.ADDRESS AS address,
                DATE_FORMAT(ac.date_created, '%Y-%m-%d') AS date_created,
                ac.date_created AS date_createds,
                DATE_FORMAT(ac.date_approved, '%Y-%m-%d') AS date_approved,
                ui.id AS userid,
                ai.id AS aid,
                ac.control_no AS control_no,
                ac.safety_seal_no AS ss_no,
                ac.status AS stats,
                ac.address AS ac_address,
                ac.application_type AS app_type,
                ac.token AS token,
                ac.for_renewal AS for_renewal
            FROM tbl_app_checklist ac
            LEFT JOIN tbl_admin_info ai ON ai.id = ac.user_id
            LEFT JOIN tbl_userinfo ui ON ui.user_id = ai.id";

    $sql1 = " WHERE ai.PROVINCE = $province AND ac.application_type = 'Applied' AND ac.status NOT IN ('Draft', 'Returned')";
    $sql1 .= " ORDER BY ai.id, ac.id DESC LIMIT 18446744073709551615";

    $sub_qry = "SELECT * FROM (".$bsql.$sql1.") AS subqry GROUP BY aid" ;
     
    $query = mysqli_query($conn, $sub_qry);

    while ($row = mysqli_fetch_assoc($query)) {
        $color = 'green';
        if (($row['stats'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
            $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
            $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
        } else {
            $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
            $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
        }

        $date1 = date_create($date_today);
        $date2 = date_create($date_validity);
        $interval = $date1->diff($date2);
        
        $status = $row['stats'];
        if (!empty($row['date_approved'])) {
            if ($row['stats'] == 'For Renewal') {
                $status = $row['stats'];
            } elseif ($date_today >= $date_validity) {
                $status = 'Expired';
            }
        }

        if ($status == 'For Receiving') {
            $color = 'primary';
        } elseif ($status == 'Received') {
            $color = 'yellow';
        } elseif (in_array($status, ['Disapproved', 'Expired'])) {
            $color = 'red';
        }

        $data[$row['id']] = [
            'id'            => $row['id'],
            'userid'        => $row['userid'],
            'fname'         => $row['fname'],
            'agency'        => $row['agency'],
            'address'       => $row['address'],
            'date_created'  => date('M d, Y', strtotime($row['date_created'])),
            'control_no'    => $row['control_no'],
            'ss_no'         => $row['ss_no'],
            'status'        => $status,
            'color'         => $color,
            'ac_address'    => $row['ac_address'],
            'app_type'      => $row['app_type'],
            'token'         => $row['token'],
            'for_renewal'   => $row['for_renewal'],
            'issued_date'   => date('M d, Y', strtotime($row['date_approved'])),
            'validity_date' => $date_validity_f
        ];   
    }

    $sql2 = " WHERE ai.PROVINCE = $province AND ac.application_type = 'Encoded'";
    $sql2 .= " ORDER BY ai.id, ac.id DESC LIMIT 18446744073709551615";

    $sub_qry = "SELECT * FROM (".$bsql.$sql2.") AS subqry GROUP BY aid" ;
 
    $query = mysqli_query($conn, $sub_qry);
    
    while ($row = mysqli_fetch_assoc($query)) {
        $color = 'green';
        if (($row['stats'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
            $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
            $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
        } else {
            $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
            $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
        }

        $date1 = date_create($date_today);
        $date2 = date_create($date_validity);
        $interval = $date1->diff($date2);
        
        $status = $row['stats'];
        if (!empty($row['date_approved'])) {
            if ($row['stats'] == 'For Renewal') {
                $status = $row['stats'];
            } elseif ($date_today >= $date_validity) {
                $status = 'Expired';
            }
        }

        if ($status == 'For Receiving') {
            $color = 'primary';
        } elseif ($status == 'Received') {
            $color = 'yellow';
        } elseif (in_array($status, ['Disapproved', 'Expired'])) {
            $color = 'red';
        }

        $data[$row['id']] = [
            'id'            => $row['id'],
            'userid'        => $row['userid'],
            'fname'         => $row['fname'],
            'agency'        => $row['agency'],
            'address'       => $row['address'],
            'date_created'  => date('M d, Y', strtotime($row['date_created'])),
            'control_no'    => $row['control_no'],
            'ss_no'         => $row['ss_no'],
            'status'        => $status,
            'color'         => $color,
            'ac_address'    => $row['ac_address'],
            'app_type'      => $row['app_type'],
            'token'         => $row['token'],
            'for_renewal'   => $row['for_renewal'],
            'issued_date'   => date('M d, Y', strtotime($row['date_approved'])),
            'validity_date' => $date_validity_f
        ];      
    }

    return $data;

}

function getPFPApplicationLists2($conn, $province, $status)
{
	$data = [];
	$colors = [
    	'Draft'			=> 'secondary',
    	'For Receiving' => 'primary',
        'Reassess'      => 'primary',
    	'Received' 		=> 'yellow',
    	'Disapproved' 	=> 'red',
    	'Returned' 		=> 'red',
    	'Approved' 		=> 'green'
    ];

    // $sql = "SELECT ac.id as id, ai.CMLGOO_NAME as fname, ui.GOV_AGENCY_NAME as pagency, ac.agency as cagency,
	   //  ui.ADDRESS as address, DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created, DATE_FORMAT(ac.date_approved, '%Y-%m-%d') as date_approved, ui.id as userid, ac.control_no as control_no, ac.safety_seal_no as ss_no,
	   //  ac.status as status, ac.address as ac_address, ac.application_type as app_type, ac.person as person,
	   //  ac.token as token FROM tbl_app_checklist ac LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
	   //  LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id";

    $bsql = "SELECT 
                ac.id AS id,
                ai.CMLGOO_NAME AS fname,
                ui.GOV_AGENCY_NAME AS agency,
                ui.ADDRESS AS address,
                DATE_FORMAT(ac.date_created, '%Y-%m-%d') AS date_created,
                ac.date_created AS date_createds,
                DATE_FORMAT(ac.date_approved, '%Y-%m-%d') AS date_approved,
                ui.id AS userid,
                ai.id AS aid,
                ac.control_no AS control_no,
                ac.safety_seal_no AS ss_no,
                ac.status AS stats,
                ac.address AS ac_address,
                ac.application_type AS app_type,
                ac.token AS token,
                ac.for_renewal AS for_renewal
            FROM tbl_app_checklist ac
            LEFT JOIN tbl_admin_info ai ON ai.id = ac.user_id
            LEFT JOIN tbl_userinfo ui ON ui.user_id = ai.id";



	// $sql1 = " WHERE ai.PROVINCE = ".$province." AND ac.application_type = 'Applied' AND ac.status <> '$status' AND ac.status <> 'Returned'";

    $sql1 = " WHERE ai.PROVINCE = $province AND ac.application_type = 'Applied' AND ac.status <> '".$status."' AND ac.status <> 'Returned'";
    $sql1 .= " ORDER BY ai.id, ac.id DESC LIMIT 18446744073709551615";

    $sub_qry = "SELECT * FROM (".$bsql.$sql1.") AS subqry GROUP BY aid" ;
	 
    $query = mysqli_query($conn, $sql.$sql1);

    while ($row = mysqli_fetch_assoc($query)) {
        $data[$row['id']] = [
            'id' 			=> $row['id'],
            'userid' 		=> $row['userid'],
            'fname' 		=> !empty($row['person']) ? $row['person'] : $row['fname'],
            'agency' 		=> $row['pagency'],
            'address' 		=> $row['address'],
            'date_created' 	=> date('M d, Y', strtotime($row['date_created'])),
            'control_no' 	=> $row['control_no'],
            'ss_no' 		=> $row['ss_no'],
            'status' 		=> $row['status'],
            'color' 		=> $colors[$row['status']],
            'ac_address' 	=> $row['ac_address'],
            'app_type' 		=> $row['app_type'],
            'token' 		=> $row['token'],
            'issued_date'   => '',
            'validity_date' => !empty($row['date_approved']) ? date('M d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
        ];    
    }

    // $sql2 = " WHERE ai.PROVINCE = ".$province." AND ac.application_type = 'Encoded'";
 
    // $query = mysqli_query($conn, $sql.$sql2);
    
    // while ($row = mysqli_fetch_assoc($query)) {
    //     $data[$row['id']] = [
    //         'id' 			=> $row['id'],
    //         'userid' 		=> $row['userid'],
    //         'fname' 		=> !empty($row['person']) ? $row['person'] : $row['fname'],
    //         'agency' 		=> !empty($row['cagency']) ? $row['cagency'] : $row['pagency'],
    //         'address' 		=> $row['address'],
    //         'date_created' 	=> $row['date_created'],
    //         'control_no' 	=> $row['control_no'],
    //         'ss_no' 		=> $row['ss_no'],
    //         'status' 		=> $row['status'],
    //         'color' 		=> $colors[$row['status']],
    //         'ac_address' 	=> $row['ac_address'],
    //         'app_type' 		=> $row['app_type'],
    //         'token' 		=> $row['token'],
    //         'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
    //     ];    
    // }

    return $data;

}
