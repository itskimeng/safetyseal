<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';
require '../manager/ApplicationManager.php';
require '../manager/SafetysealHistoryManager.php';
require '../manager/ApplicationHistoryManager.php';
require '../application/config/connection.php';

$app = new ApplicationManager();
$shm = new SafetysealHistoryManager();
$ahm = new ApplicationHistoryManager();
$today = new DateTime();


$userid = $_SESSION['userid'];
$province = $_SESSION['province'];
$is_clusterhead = $_SESSION['is_clusterhead'];
$is_pfp = $_SESSION['is_pfp'];
$token = $_POST['id'];

if ($is_clusterhead OR $is_pfp) {
    $citymun = $_POST['citymun'];
} else {
    $citymun = $_SESSION['city_mun'];
}

$checklist_id = findID($conn, $token);

if (!$checklist_id['for_renewal']) {
    $status = ApplicationManager::STATUS_APPROVED;
    $ss_no = generateCode($conn, $province, $citymun);
    
    $app->evaluateChecklist($checklist_id['id'], $status, $ss_no, $today->format('Y-m-d H:i:s'), $userid);
} else {
    $status = 'Renewed';
    $ss_no = $checklist_id['ssn'];
    
    $app->evaluateChecklist2($checklist_id['id'], $status, $ss_no, $today->format('Y-m-d H:i:s'), $userid);
}

$_SESSION['toastr'] = $app->addFlash('success', 'The application has been set to '.$status.'.', 'Success');


$msg = 'application ' .$checklist_id['control_no'] .' has been approved';
$shm->insert(['fid'=>$checklist_id['id'], 'mid'=>SafetysealHistoryManager::MENU_ADMIN_APPLICATION, 'uid'=>$userid, 'action'=>$status, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);

$issued_date = new DateTime($today->format('Y-m-d H:i:s'));
$validity_date = date('Y-m-d', strtotime("+6 months", strtotime($issued_date->format('Y-m-d'))));
$validity_date = new DateTime($validity_date);

$ahm->insert(['app_id'=>$checklist_id['id'], 'issued_date'=>$today->format('Y-m-d'), 'expiration_date'=>$validity_date->format('Y-m-d'), 'status'=>$status, 'date_created'=>$today->format('Y-m-d H:i:s')]);


function findID($conn, $id) {
	$sql = 'SELECT id, control_no, for_renewal, safety_seal_no as ssn FROM tbl_app_checklist where token = "'.$id.'"';
    $query = mysqli_query($conn, $sql);
	$result = mysqli_fetch_array($query);
        
    return $result; 
}

function generateCode($conn, $province, $citymun) 
    {
        $sql = "SELECT code as pcode FROM tbl_province WHERE id = $province";
        $query = mysqli_query($conn, $sql);
        $result1 = mysqli_fetch_array($query);

        $sql = "SELECT code as mcode FROM tbl_citymun WHERE province = $province AND code = '".$citymun."'";
        $query = mysqli_query($conn, $sql);
        $result12 = mysqli_fetch_array($query);

        $ccode = 'R4A-'.$result1['pcode'].'-'.$result12['mcode'];
        // $ccode = '2021';


        $sql = "SELECT counter, id FROM tbl_config WHERE code = '".$ccode."'";
        $query = mysqli_query($conn, $sql);
        $result2 = mysqli_fetch_array($query);

        $cc = $result2['counter'] + 1;

        if ($cc > 9999) {
            $new_counter = $cc;
        } elseif ($cc > 999) {
            $new_counter = '0'.$cc;
        } elseif ($cc < 10) {
            $new_counter = '0000'.$cc;
        } elseif ($cc < 99) {
            $new_counter = '000'.$cc;
        } elseif ($cc > 99 AND $cc <= 999) {
            $new_counter = '00'.$cc;
        }

        $sql = "UPDATE tbl_config SET counter = '".$new_counter."' WHERE id = ".$result2['id']."";
        $result = mysqli_query($conn, $sql);

        $control_no = $ccode.'-'.$new_counter;
       
        return $control_no;
    }


