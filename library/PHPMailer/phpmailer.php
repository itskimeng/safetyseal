<?php

require '../../PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/src/SMTP.php';
require '../../PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();

$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";
$mail->Port = "587";
$mail->Username = "dilg4awebmail64@gmail.com";
$mail->Password = "]LJkA9qaH)tR^3eZ";
$mail->Subject = "Test email using PHPMailer";
$mail->setFrom('dilg4awebmail64@gmail.com');
$mail->isHTML(true);
$mail->addAttachment('../../images/profile/Sacluti Mark Kim A.jpg');
$mail->Body = "<h1>This is HTML h1 Heading</h1></br><p>This is html paragraph</p>";
$mail->addAddress('sodsodjomarie@gmail.com');

if ($mail->send()) {
	echo "Email Sent..!";
} else {
	echo "Message could not be sent. Mailer Error: " .$mail->ErrorInfo;
}

// $mail->smtpClose();
