<?php
$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST']);
session_start();
date_default_timezone_set('Asia/Manila');
require_once '../config/connection.php';
require '../../library/PHPMailer/src/PHPMailer.php';
require '../../library/PHPMailer/src/SMTP.php';
require '../../library/PHPMailer/src/Exception.php';
require '../../manager/SafetysealHistoryManager.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$shm = new SafetysealHistoryManager();
$today = new DateTime();

$error = NULL;
$id = isset($_POST['id']) ? $_POST['id'] : '';
$agency_name            = isset($_POST['government_agency']) ? mysqli_real_escape_string($conn, $_POST['government_agency']) : '';
$establishment_name     = isset($_POST['government_esta']) ? mysqli_real_escape_string($conn, $_POST['government_esta']) : '';
$gov_nature             = isset($_POST['government_nature']) ? mysqli_real_escape_string($conn, $_POST['government_nature']) : '';
$firstname              = isset($_POST['fname']) ? mysqli_real_escape_string($conn, $_POST['fname']) : '';
$middlename             = isset($_POST['mname']) ? mysqli_real_escape_string($conn, $_POST['mname']) : '';
$lastname               = isset($_POST['validateAddress']) ? mysqli_real_escape_string($conn, $_POST['lname']) : '';
$address                = isset($_POST['validateAddress']) ? mysqli_real_escape_string($conn, $_POST['validateAddress']) : '';
$position               = isset($_POST['position']) ? mysqli_real_escape_string($conn, $_POST['position']) : '';
$province               = isset($_POST['province']) ? mysqli_real_escape_string($conn, $_POST['province']) : '';
$municipalities         = isset($_POST['municipality']) ? mysqli_real_escape_string($conn, $_POST['municipality']) : '';
$mobile_no              = isset($_POST['phone_no']) ? mysqli_real_escape_string($conn, $_POST['phone_no']) : '';
$emailAddress           = isset($_POST['emailAddress']) ? mysqli_real_escape_string($conn, $_POST['emailAddress']) : '';
$username               = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : '';
$password               = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';
$password2              = isset($_POST['cpassword']) ? mysqli_real_escape_string($conn,$_POST['cpassword']) : '';
$vkey                   = md5(time() . $username);
// $_SESSION['username']   = $username;
// $_SESSION['password']   = $password;

$date = date('Y-m-d', time());

if (isset($_POST['resend'])) {
    $query = "SELECT * FROM tbl_admin_info WHERE id = $id";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Host = "calabarzon.dilg.gov.ph";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Port = "587";
    $mail->Username = "safetyseal@calabarzon.dilg.gov.ph";
    $mail->Password = "wvSHrgX)K#VF";
    $mail->Subject = "Safetyseal Email Verification";
    $mail->setFrom('safetyseal@calabarzon.dilg.gov.ph', 'no-reply');
    $mail->isHTML(true);
    $message = file_get_contents('../../views/users/message.php');
    $message = str_replace('%burl%', $url_array[0], $message);
    $message = str_replace('%link%', $row['VERIFICATION_CODE'], $message);
    
    $mail->msgHTML($message);
    $mail->addAddress($emailAddress);

    $mail->smtpClose();

    if ($mail->send()) {
        echo 'success';
    } else {
        echo 'failed';
    }

} elseif (strlen($username) < 5) {
    $error = "Your username muust be at least 10 characters";
} elseif ($password != $password2) {
    $error = "Your passwords do not match.";
} else {
    //insert to db
    $insert = "INSERT INTO `tbl_admin_info`(`ID`, `REGION`, `PROVINCE`, `LGU`, `OFFICE`, `CMLGOO_NAME`, `UNAME`, `PASSWORD`, `VERIFICATION_CODE`, `IS_APPROVED`, `IS_VERIFIED`, `ROLES`, `EMAIL`)
    VALUES (null,'REGION IV-A - CALABARZON','$province','$municipalities','$agency_name','$firstname".' '."$middlename".' '."$lastname', '$username', '$password','$vkey', '0', '0','user','$emailAddress')";

    if (mysqli_query($conn, $insert)) {
    }
    //get user id
    $resultSet = $conn->query("SELECT * from tbl_admin_info where UNAME = '$username' AND PASSWORD = '$password' ORDER BY ID desc limit 1");
    $row = $resultSet->fetch_assoc();
    $user_id=$row['ID'];

    

    $sql = "INSERT INTO `tbl_userinfo` (`ID`, `USER_ID`, `ADDRESS`, `POSITION`, `MOBILE_NO`, `EMAIL_ADDRESS`, `GOV_AGENCY_NAME`, `GOV_ESTB_NAME`,`DATE_REGISTERED`,`GOV_NATURE_NAME`)
        VALUES (NULL,'$user_id','$address','$position','$mobile_no','$emailAddress','$agency_name','$establishment_name','$date','$gov_nature')";

    $shm->insert(['fid'=>$user_id, 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_USER, 'uid'=>$user_id, 'action'=> SafetysealHistoryManager::ACTION_REGISTER, 'message'=> 'registered new account', 'action_date'=> $today->format('Y-m-d H:i:s')]);
        
    if (mysqli_query($conn, $sql)) {
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = "calabarzon.dilg.gov.ph";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Port = "587";
        $mail->Username = "safetyseal@calabarzon.dilg.gov.ph";
        $mail->Password = "wvSHrgX)K#VF";
        $mail->Subject = "Safetyseal Email Verification";
        $mail->setFrom('safetyseal@calabarzon.dilg.gov.ph', 'no-reply');
        $mail->isHTML(true);
        $message = file_get_contents('../../views/users/message.php');
        $message = str_replace('%burl%', $url_array[0], $message);
        $message = str_replace('%link%', $vkey, $message);
        
        $mail->msgHTML($message);
        $mail->addAddress($emailAddress);

        $mail->smtpClose();

        if ($mail->send()) {
            header('Location:../../registration.php?flag=1&emailAddress=' . $emailAddress . '&id='.$user_id);
        }
    }

}

mysqli_close($conn);
