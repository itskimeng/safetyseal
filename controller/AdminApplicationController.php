<?php
date_default_timezone_set('Asia/Manila');

require 'application/config/connection.php';
require 'manager/ApplicationManager.php';

$app = new ApplicationManager();
$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];

$status_opts = [
	ApplicationManager::STATUS_FOR_RECEIVING => ApplicationManager::STATUS_FOR_RECEIVING,
	ApplicationManager::STATUS_RECEIVED => ApplicationManager::STATUS_RECEIVED,
	ApplicationManager::STATUS_APPROVED => ApplicationManager::STATUS_APPROVED,
	ApplicationManager::STATUS_DISAPPROVED => ApplicationManager::STATUS_DISAPPROVED
];

$province_opts = $app->getProvinces();
$citymun_opts = $app->getCityMuns();
$applicants = $app->getApplicationLists(ApplicationManager::STATUS_DRAFT);

// $applicants_data = $app->getUserChecklists($user); 

// function getApplicants($conn, $province, $citymun)
//     {
//         $sql = "SELECT
//         	CONCAT
//             FROM tbl_app_checklist a 
//             FROM tbl_userinfo u on u.id = a.user_id
//             LEFT JOIN tbl_province p on p.id = u.PROVINCE
//             LEFT JOIN tbl_citymun m on m.id = u.CITY_MUNICIPALITY
//             WHERE u.id = $user";
        
//         $query = mysqli_query($this->conn, $sql);
        
//         while ($row = mysqli_fetch_assoc($query)) {
//             $date_created = $row['date_created'];
//             if (empty($date_created)) {
//                 $date_created = $today;
//             }
//             $data = [
//                 'id' => $row['id'],
//                 'date_created' => $date_created,
//                 'address' => $row['address'],
//                 'agency' => $row['agency'],
//                 'establishment' => $row['establishment'],
//                 'nature' => $row['nature'],
//                 'fname' => $row['fname'],
//                 'contact_details' => $row['contact_details'],
//                 'status' => !empty($row['status']) ? $row['status'] : 'Draft',
//                 'pcode' => $row['pcode'],
//                 'mcode' => $row['mcode'],
//                 'code' => !empty($row['control_no']) ? $row['control_no'] : 'R4A-'.$row['pcode'].'-'.$row['mcode'].'-____',
//                 'date_proceed' => $row['date_proceed']
//             ];      
//         }

//         return $data;
//     }
