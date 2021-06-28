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
$email = $_POST['email'];
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
notifyUser($email);

$_SESSION['toastr'] = $app->addFlash('success', 'The application has been set to '.$status.'.', 'Success');


function notifyUser($emailAddress)
{

	$to = $emailAddress;
	$subject = "Safety Seal Portal";
	$message = '<html><body>';
	$message .= '
			<div class="container>
				<div class="card shadow" style="width:30rem">
					<div class="card-header" style="background-color: #009688; color:#fff;">
						<center><img src="http://safetyseal.calabarzon.dilg.gov.ph/frontend/images/email_header.png" style="width:65%;height:auto;"/></center>
					</div>
					<div class="card-body" style="background-color:ECEFF1"><br>
						<br><b>Congratulations!</b><br>
						You passed the Safety Seal Certification as of _______ <br>
						Kindly note that the Safety Seal is only valid for six(6) months unless <br>
						otherwise revoked earlier due to valid complaint. You may process <br>
						renewal one (1) month prior to the expiration of its validity.<br>

						To keep updated please visit safetyseal.calabarzon.dilg.gov.ph or coordinate with your DILG Field officer
						<br>
						Thank you!.
					
					</div>
				</div>
			</div>';
	$message .= '</html></body>';
	$headers = "From: safetyseal@calabarzon.dilg.gov.ph \r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-800" . "\r\n";
	mail($to, $subject, $message, $headers);
}





