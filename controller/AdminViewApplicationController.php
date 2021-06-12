<?php
session_start();
date_default_timezone_set('Asia/Manila');

require 'application/config/connection.php';
require 'manager/ApplicationManager.php';

$appid = $_GET['appid'];

$app = new ApplicationManager();

$province_opts = $app->getProvinces();
$citymun_opts = $app->getCityMuns();
$applicants = $app->getApplicationLists(ApplicationManager::STATUS_FOR_APPROVAL);

$applicant = getUserChecklists($conn, $appid); 
$applicants_data = getUserChecklistsEntry($conn, $appid); 

function getUserChecklists($conn, $id)
{
    $sql = "SELECT 
       	u.GOV_AGENCY_NAME as agency,
       	u.GOV_ESTB_NAME as establishment,
       	u.GOV_NATURE_NAME as nature,
       	u.ADDRESS as address,
        CONCAT(u.FIRST_NAME, ' ', u.LAST_NAME) as fname,
       	u.ADDRESS as address,
       	u.MOBILE_NO as contact_details,
        a.control_no as control_no,
       	DATE_FORMAT(a.date_created, '%M %d, %Y') as date_created
        FROM tbl_app_checklist a 
        LEFT JOIN tbl_userinfo u on u.id = a.user_id
        WHERE a.id = $id";

    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);

    return $data;
}

function getUserChecklistsEntry($conn, $id)
{
    $sql = "SELECT 
        c.id as clist_id,  
        c.requirement as requirement,
        c.description as description,
        e.id as ulist_id,
        e.answer as answer,
        e.reason as reason
        FROM tbl_app_checklist_entry e
        LEFT JOIN tbl_app_checklist a on a.id = e.parent_id
        LEFT JOIN tbl_app_certchecklist c on c.id = e.chklist_id
        LEFT JOIN tbl_userinfo u on u.id = a.user_id
        WHERE a.id = $id";

    $query = mysqli_query($conn, $sql);
    $data = [];

    while ($row = mysqli_fetch_assoc($query)) {
    	$badge = 'secondary';
    	if ($row['answer'] == 'yes') {
    		$badge = 'success';
    	} 

    	if ($row['answer'] == 'no') {
    		$badge = 'danger';
    	}

        $data[] = [
            'clist_id' => $row['clist_id'],
            'requirement' => $row['requirement'],
            'description' => explode('~ ', $row['description']),
            'ulist_id' => $row['ulist_id'],
            'badge' => $badge,
            'answer' => strtoupper($row['answer']),
            'reason' => $row['reason']
        ];    
    }

    return $data;
}
