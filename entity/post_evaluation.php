<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$app = new ApplicationManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];
$checklist_id = $_POST['appid'];

// ==================
$email = $_POST['email'];
$userid = $_POST['id'];
$control_no = $_POST['control_no'];
$defects = isset($_POST['defects']) ? $_POST['defects'] : '';
$recommendations = isset($_POST['recommendations']) ? $_POST['recommendations'] : '';

$assessments = isset($_POST['assessments']) ? $_POST['assessments'] : '';
$status = ApplicationManager::STATUS_APPROVED;

if (!empty($assessments)) {
	foreach ($assessments as $key => $assess) {
		if ($assess == 'failed') {
			$status = ApplicationManager::STATUS_DISAPPROVED;
			
		}
		$entry = $app->insertAssessment($key, $assess, $email);
	}
}

$notes = $app->getValidationLists($checklist_id );
if (empty($notes)) {
	$app->insertValidationChecklist($checklist_id, $defects, $recommendations, $today->format('Y-m-d H:i:s'));	
} else {
	$app->updateValidationChecklist($checklist_id, $defects, $recommendations, $today->format('Y-m-d H:i:s'));	
}

$ss_no = $app->generateCode($userid);
$app->evaluateChecklist($checklist_id, $status, $ss_no, $today->format('Y-m-d H:i:s'), $userid);
$_SESSION['toastr'] = $app->addFlash('success', 'The application has been set to '.$status.'.', 'Success');



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



