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
$uname = $_SESSION['username'];
$checklist_id = $_POST['appid'];

$email = $_POST['email'];
$control_no = $_POST['control_no'];
$defects = isset($_POST['defects']) ? $_POST['defects'] : '';
$recommendations = isset($_POST['recommendations']) ? $_POST['recommendations'] : '';
$assessments = isset($_POST['assessments']) ? $_POST['assessments'] : '';
$status = ApplicationManager::STATUS_APPROVED;
$ssc_no = '';
$application = findID($conn, $checklist_id);

if (!empty($assessments)) {
	foreach ($assessments as $key => $assess) {
		if (in_array($assess, ['failed', 'fail'])) {
			$status = ApplicationManager::STATUS_DISAPPROVED;
		}
		$entry = $app->insertAssessment($key, $assess, $email, $application['for_renewal']);
	}
}

$notes = $app->getValidationLists($checklist_id );
if (empty($notes)) {
	$app->insertValidationChecklist($checklist_id, $defects, $recommendations, $today->format('Y-m-d H:i:s'));	
} else {
	$app->updateValidationChecklist($checklist_id, $defects, $recommendations, $today->format('Y-m-d H:i:s'));	
}


if ($status == 'Approved' AND !$application['for_renewal']) {
	$ssc_no = $app->generateCode($userid);
}

if ($status == 'Approved' AND $application['for_renewal']) {
	$app->evaluateChecklist2($checklist_id, $status, $ssc_no, $today->format('Y-m-d H:i:s'), $userid, false);
} elseif (empty($application['date_approved'])) {
	$app->evaluateChecklist($checklist_id, $status, $ssc_no, $today->format('Y-m-d H:i:s'), $userid, false);
} else {
	$app->evaluateChecklist($checklist_id, $status, $ssc_no, $today->format('Y-m-d H:i:s'), $userid, false, true);
}

$_SESSION['toastr'] = $app->addFlash('success', 'The application has been set to '.$status.'.', 'Success');
$msg = 'application ' .$application['control_no']. ' has been ' .$status.'.';

if ($defects != null) {
	$msg = $msg .'<br><br> <b>Defects:</b> '.$defects;
}

if ($recommendations != null) {
	$msg = $msg .'<br> <b>Recommendations:</b> '.$recommendations;
}

$shm->insert(['fid'=>$checklist_id, 'mid'=>SafetysealHistoryManager::MENU_ADMIN_APPLICATION, 'uid'=>$userid, 'action'=> SafetysealHistoryManager::ACTION_UPDATE, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);

if (in_array($status, ['Approved', 'Revoked'])) {
	$issued_date = new DateTime($application['date_approved']);
	$validity_date = date('Y-m-d', strtotime("+6 months", strtotime($issued_date->format('Y-m-d'))));
	$validity_date = new DateTime($validity_date);

	$ahm->insert(['app_id'=>$checklist_id, 'issued_date'=>$issued_date->format('Y-m-d'), 'expiration_date'=>$validity_date->format('Y-m-d'), 'status'=>$status, 'date_created'=>$today->format('Y-m-d H:i:s')]);
}	



$degree = $app->getStatus($conn,$userid,$control_no);


foreach ($degree as $key => $data) {
	if($data['status'] == 'Approved')
	{
		ApprovedApplicant($email,$data['safety_seal_no'],$control_no);
	}else{
		DisapprovedApplicant($email,$control_no);
	}
}




function ApprovedApplicant($emailAddress,$ss_no,$control_no)
{

	$to = $emailAddress;
	$subject = "Notification from DILG IV-A Safety Seal Portal:";
	$message = '<html><body>';
	$message .= '
			<div class="container>
				<div class="card shadow" style="width:30rem">
					<div class="card-header" style="background-color: #009688; color:#fff;">
						<center><img src="http://safetyseal.calabarzon.dilg.gov.ph/frontend/images/email_header.png" style="width:65%;height:auto;"/></center>
					</div>
					<div class="card-body" style="background-color:ECEFF1"><br>
						<br>Good day! Your application for Safety Seal Certification with Ctrl No:<b> '.$control_no.'</b>  and Safety Seal No: <b>'.$ss_no.'</b>  has been approved.<br><br>
                        Kindly login to the portal to print the certificate. 
                        
					</div>
				</div>
			</div>';
	$message .= '</html></body>';
	$headers = "From: safetyseal@calabarzon.dilg.gov.ph \r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-800" . "\r\n";
	mail($to, $subject, $message, $headers);
}


function DisapprovedApplicant($emailAddress,$control_no)
{
	$to = $emailAddress;
	$subject = "Notification from DILG IV-A Safety Seal Portal:";
	$message = '<html><body>';
	$message .= '
			<div class="container>
				<div class="card shadow" style="width:30rem">
					<div class="card-header" style="background-color: #009688; color:#fff;">
						<center><img src="http://safetyseal.calabarzon.dilg.gov.ph/frontend/images/email_header.png" style="width:65%;height:auto;"/></center>
					</div>
					<div class="card-body" style="background-color:ECEFF1"><br>
						<br>Good day! Your application for Safety Seal Certification with Ctrl No:<b> '.$control_no.'</b>  has been returned.<br><br>
                        Kindly login to the portal to complete your application.
                        
					</div>
				</div>
			</div>';
	$message .= '</html></body>';
	$headers = "From: safetyseal@calabarzon.dilg.gov.ph \r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-800" . "\r\n";
	mail($to, $subject, $message, $headers);
}

function findID($conn, $id) 
{
	$sql = "SELECT id, control_no, status, for_renewal, date_approved FROM tbl_app_checklist WHERE id = '".$id."'";
	$query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    return $result;
}



