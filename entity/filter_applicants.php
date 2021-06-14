<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$name = $_GET['name'];
$agency = $_GET['agency'];
$location = $_GET['location'];
$status = $_GET['status'];
$daterange = explode('-', $_GET['daterange']);

$date_from = new DateTime($daterange[0]);
$date_to = new DateTime($daterange[1]);

$data = [
	'name' => $name,
	'agency' => $agency,
	'status' => $status,
	'location' => $location,
	'date_from' => $date_from->format('Y-m-d 00:00:00'),
	'date_to' => $date_to->format('Y-m-d 23:59:59')
];

$lists = filterApplicants($conn, $data);

echo $lists;

function filterApplicants($conn, $options) {
	$date_from = $options['date_from'];
	$date_to = $options['date_to'];

	$sql = "SELECT
	  	ac.id as id,
        ai.CMLGOO_NAME as fname,
        ui.GOV_AGENCY_NAME as agency,
        ui.ADDRESS as address,
        DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
        ui.id as userid,
        ac.control_no as control_no,
        ac.status as status
		FROM tbl_app_checklist ac
		LEFT JOIN tbl_userinfo ui on ui.id = ac.user_id
  		LEFT JOIN tbl_admin_info ai on ui.user_id = ai.id
		WHERE ac.date_created >= '$date_from' AND ac.date_created <= '$date_to'";

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

	$query = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = [
            'id' => $row['id'],
            'userid' => $row['userid'],
            'fname' => $row['fname'],
            'agency' => $row['agency'],
            'address' => $row['address'],
            'date_created' => $row['date_created'],
            'control_no' => $row['control_no'],
            'status' => $row['status']
        ];    
    }
   
    return json_encode($data);
}