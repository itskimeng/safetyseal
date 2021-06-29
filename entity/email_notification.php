<?php


// sending email notification
foreach ($notify as $key => $data) {
	notifyUser($data['email'], $establishment ,$name, $data['control_no']);
}

function notifyUser($emailAddress, $est,$applicant_name,$control_no)
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
						<br> Hi '.$applicant_name.' of ' . strtoupper($est) . '</br> applied for Safety Seal Certification with CTRL No <b>'.$control_no.'</b><br><br>
                        Kindly login to the portal to proceed with the assessment and issuance of certificate.
                        
					</div>
				</div>
			</div>';
	$message .= '</html></body>';
	$headers = "From: safetyseal@calabarzon.dilg.gov.ph \r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-800" . "\r\n";
	mail($to, $subject, $message, $headers);
}
