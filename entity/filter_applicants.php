<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$province = $_SESSION['province'];
$is_clusterhead = $_SESSION['is_clusterhead'];
$clusterhead_id = $_SESSION['clusterhead_id'];

if (!$is_clusterhead) {
	$lgu = $_SESSION['city_mun'];
} else {
	$lgu = $_GET['citymun'];
}

$name = $_GET['name'];
$agency = $_GET['agency'];
$location = $_GET['location'];
$status = $_GET['status'];
$app_type = $_GET['app_type'];
$daterange = explode('-', $_GET['daterange']);

$date_from = new DateTime($daterange[0]);
$date_to = new DateTime($daterange[1]);

$data = [
	'name' => $name,
	'agency' => $agency,
	'status' => $status,
	'app_type' => $app_type,
	'location' => $location,
	'date_from' => $date_from->format('Y-m-d 00:00:00'),
	'date_to' => $date_to->format('Y-m-d 23:59:59')
];

$lists = filterApplicants($conn, $province, $lgu, $data);

echo $lists;

function filterApplicants($conn, $province, $lgu, $options) {
	$date_from = $options['date_from'];
	$date_to = $options['date_to'];
	$data = [];

	$sql = "SELECT
	  	ac.id as id,
        ai.CMLGOO_NAME as fname,
        ui.GOV_AGENCY_NAME as agency,
        ui.ADDRESS as address,
        DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
        DATE_FORMAT(ac.date_approved, '%Y-%m-%d') as date_approved,
        ui.id as userid,
        ac.control_no as control_no,
        ac.status as status,
        ac.application_type as app_type,
        ac.safety_seal_no as ss_no,
        ac.agency as r_agency,
        ac.establishment as r_establishment,
        ac.nature as r_nature,
        ac.address as r_address,
        ac.person as r_person,
        ac.contact_details as r_contact_details,
        ac.token as token
		FROM tbl_app_checklist ac
		LEFT JOIN tbl_userinfo ui on ui.id = ac.user_id
  		LEFT JOIN tbl_admin_info ai on ui.user_id = ai.id
		WHERE ai.PROVINCE = '".$province."' AND ai.LGU = '".$lgu."' AND ac.date_created >= '$date_from' AND ac.date_created <= '$date_to' AND ac.status <> 'Draft'";

	if (!empty($options['name'])) {
		$sql.= " AND ai.CMLGOO_NAME = '".$options['name']."'"; 
	}	

	if (!empty($options['agency'])) {
		$sql.= " AND ui.GOV_AGENCY_NAME = '".$options['agency']."'"; 
	}

	if (!empty($options['location'])) {
		$sql.= " AND ui.ADDRESS = '".$options['location']."'"; 
	}	

	if (!empty($options['status'])) {
		$sql.= " AND ac.status = '".$options['status']."'"; 
	}

	if (!empty($options['app_type'])) {
		$sql.= " AND ac.application_type = '".$options['app_type']."'"; 
	}	

	$query = mysqli_query($conn, $sql);

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
            'fname' => $row['app_type'] == 'Applied' ? $row['fname'] : $row['r_person'],
            'agency' => $row['app_type'] == 'Applied' ? $row['agency'] : $row['r_agency'],
            'address' => $row['app_type'] == 'Applied' ? $row['address'] : $row['r_address'],
            'date_created' => $row['date_created'],
            'control_no' => $row['control_no'],
            'status' => $row['status'],
            'app_type' => $row['app_type'],
            'token' => $row['token'],
            'color' => $color,
            'ss_no' => !empty($row['ss_no']) ? $row['ss_no'] : '',
            'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
        ];    
    }


    $sql = "SELECT
	  	ac.id as id,
        ai.CMLGOO_NAME as fname,
        ui.GOV_AGENCY_NAME as agency,
        ui.ADDRESS as address,
        DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
        DATE_FORMAT(ac.date_approved, '%Y-%m-%d') as date_approved,
        ui.id as userid,
        ac.control_no as control_no,
        ac.status as status,
        ac.application_type as app_type,
        ac.safety_seal_no as ss_no,
        ac.agency as r_agency,
        ac.establishment as r_establishment,
        ac.nature as r_nature,
        ac.address as r_address,
        ac.person as r_person,
        ac.contact_details as r_contact_details,
        ac.token as token
		FROM tbl_app_checklist ac
		LEFT JOIN tbl_userinfo ui on ui.id = ac.user_id
  		LEFT JOIN tbl_admin_info ai on ui.user_id = ai.id
		WHERE ai.PROVINCE = '".$province."' AND ai.LGU = '".$lgu."' AND ac.date_created >= '$date_from' AND ac.date_created <= '$date_to' AND ac.application_type = 'Encoded'";

	if (!empty($options['name'])) {
		$sql.= " AND ai.CMLGOO_NAME = '".$options['name']."'"; 
	}	

	if (!empty($options['agency'])) {
		$sql.= " AND ui.GOV_AGENCY_NAME = '".$options['agency']."'"; 
	}

	if (!empty($options['location'])) {
		$sql.= " AND ui.ADDRESS = '".$options['location']."'"; 
	}	

	if (!empty($options['status'])) {
		$sql.= " AND ac.status = '".$options['status']."'"; 
	}

	if (!empty($options['app_type'])) {
		$sql.= " AND ac.application_type = '".$options['app_type']."'"; 
	}	

	$query = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($query)) {
        
        if ($row['status'] == 'For Receiving') {
            $color = 'primary';
        } elseif ($row['status'] == 'Received') {
            $color = 'yellow';
        } elseif ($row['status'] == 'Disapproved') {
            $color = 'red';
        } elseif ($row['status'] == 'Approved') {
            $color = 'green';
        }else{ 
            $color = 'secondary';
        }
        if($row['status'] == 'Approved')
        {
            $validity_date = date('F d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
        }else{
            $validity_date = '';
        }

        $data[$row['id']] = [
            'id' => $row['id'],
            'userid' => $row['userid'],
            'fname' => $row['app_type'] == 'Applied' ? $row['fname'] : $row['r_person'],
            'agency' => $row['app_type'] == 'Applied' ? $row['agency'] : $row['r_agency'],
            'address' => $row['app_type'] == 'Applied' ? $row['address'] : $row['r_address'],
            'date_created' => $row['date_created'],
            'control_no' => $row['control_no'],
            'status' => $row['status'],
            'app_type' => $row['app_type'],
            'token' => $row['token'],
            'color' => $color,
            'ss_no' => !empty($row['ss_no']) ? $row['ss_no'] : '',
            'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
        ];    
    }

    $sql = "SELECT
        ac.id as id,
        ai.CMLGOO_NAME as fname,
        ui.GOV_AGENCY_NAME as agency,
        ui.ADDRESS as address,
        DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
        DATE_FORMAT(ac.date_approved, '%Y-%m-%d') as date_approved,
        ui.id as userid,
        ac.control_no as control_no,
        ac.status as status,
        ac.application_type as app_type,
        ac.safety_seal_no as ss_no,
        ac.agency as r_agency,
        ac.establishment as r_establishment,
        ac.nature as r_nature,
        ac.address as r_address,
        ac.person as r_person,
        ac.contact_details as r_contact_details,
        ac.token as token
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_userinfo ui on ui.id = ac.user_id
        LEFT JOIN tbl_admin_info ai on ui.user_id = ai.id
        WHERE ai.PROVINCE = '".$province."' AND ac.lgu = '".$lgu."' AND ac.date_created >= '$date_from' AND ac.date_created <= '$date_to' AND ac.application_type = 'Encoded'";

    if (!empty($options['name'])) {
        $sql.= " AND ai.CMLGOO_NAME = '".$options['name']."'"; 
    }   

    if (!empty($options['agency'])) {
        $sql.= " AND ui.GOV_AGENCY_NAME = '".$options['agency']."'"; 
    }

    if (!empty($options['location'])) {
        $sql.= " AND ui.ADDRESS = '".$options['location']."'"; 
    }   

    if (!empty($options['status'])) {
        $sql.= " AND ac.status = '".$options['status']."'"; 
    }

    if (!empty($options['app_type'])) {
        $sql.= " AND ac.application_type = '".$options['app_type']."'"; 
    }   

    $query = mysqli_query($conn, $sql);

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
            'fname' => $row['app_type'] == 'Applied' ? $row['fname'] : $row['r_person'],
            'agency' => $row['app_type'] == 'Applied' ? $row['agency'] : $row['r_agency'],
            'address' => $row['app_type'] == 'Applied' ? $row['address'] : $row['r_address'],
            'date_created' => date('F d, Y',strtotime($row['date_created'])),
            'validity_date' => $validity_date,
            'control_no' => $row['control_no'],
            'status' => $row['status'],
            'app_type' => $row['app_type'],
            'color' => $color,
            'token' => $row['token'],
            'ss_no' => !empty($row['ss_no']) ? $row['ss_no'] : '',
            'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
        ];    
    }
   
    return json_encode($data);
}

function getApplicationLists($province, $lgu, $status)
    {
        $sql = "SELECT 
        ac.id as id,
        ai.CMLGOO_NAME as fname,
        ui.GOV_AGENCY_NAME as agency,
        ui.ADDRESS as address,
        DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
        DATE_FORMAT(ac.date_approved, '%Y-%m-%d H:i:s') as date_approved,
        ui.id as userid,
        ac.control_no as control_no,
        ac.safety_seal_no as ss_no,
        ac.status as status,
        ac.address as ac_address,
        ac.application_type as app_type,
        ac.token as token
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        WHERE ai.PROVINCE = ".$province." AND ai.LGU = ".$lgu." AND ac.application_type = 'Applied' AND ac.status <> '".$status."'";
     
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        
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
                'agency' => $row['agency'],
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

        $sql2 = "SELECT 
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
        ac.token as token
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        WHERE ai.PROVINCE = ".$province." AND ai.LGU = ".$lgu." AND ac.application_type = 'Encoded'";
     
        $query = mysqli_query($this->conn, $sql2);
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
                'fname' => $row['fname'],
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

        return $data;

    }