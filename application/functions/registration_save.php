<?php
session_start();
date_default_timezone_set('Asia/Manila');
require_once '../config/connection.php';
$error = NULL;
$agency_name =  mysqli_real_escape_string($conn, $_POST['government_agency']);
$establishment_name   =    mysqli_real_escape_string($conn, $_POST['government_esta']);
$gov_nature   =    mysqli_real_escape_string($conn, $_POST['government_nature']);
$firstname             =    mysqli_real_escape_string($conn, $_POST['fname']);
$middlename             =    mysqli_real_escape_string($conn, $_POST['mname']);
$lastname             =    mysqli_real_escape_string($conn, $_POST['lname']);
$address   =    mysqli_real_escape_string($conn, $_POST['validateAddress']);
$position   =    mysqli_real_escape_string($conn, $_POST['position']);
$province   =    mysqli_real_escape_string($conn, $_POST['province']);
$municipalities   =    mysqli_real_escape_string($conn, $_POST['municipality']);
$mobile_no          =    mysqli_real_escape_string($conn, $_POST['phone_no']);
$emailAddress      =    mysqli_real_escape_string($conn, $_POST['emailAddress']);
$username          =    mysqli_real_escape_string($conn, $_POST['username']);
$password          =    mysqli_real_escape_string($conn, md5($_POST['password']));
$password2          =    mysqli_real_escape_string($conn, md5($_POST['cpassword']));
$vkey = md5(time() . $username);
$_SESSION['username'] = $username;
$_SESSION['password'] = $password;

$date = date('Y-m-d', time());
if (strlen($username) < 5) {
    $error = "Your username muust be at least 10 characters";
} else if ($password != $password2) {
    $error = "Your passwords do not match.";
} else {
    // Form is valid


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
        
    if (mysqli_query($conn, $sql)) {
        //    send email


        $to = $emailAddress;
        $subject = "Email Verification";
        $message = "<a style='font-size:24px;font-family:centuryGothic;' href='http://safetyseal.calabarzon.dilg.gov.ph/application/functions/verify.php?vkey=" . $vkey . "'>Verify Account</a>";
        $headers = "From: safetyseal@calabarzon.dilg.gov.ph \r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-800" . "\r\n";
        mail($to, $subject, $message, $headers);
    } else {
        echo $mysqli->error;
    }
    header('Location:../../registration.php?flag=1&email=' . $emailAddress . '');
}

// resend email
if (isset($_POST['resend'])) {
    $to = $_POST['emailTo'];
    $subject = "Safety Seal Email Verification";
    $message = "<a style='font-size:24px;font-family:centuryGothic;' href='http://safetyseal.calabarzon.dilg.gov.ph/application/functions/verify.php?vkey=" . $vkey . "'>Verify Account</a>";
    $headers = "From: safetyseal@calabarzon.dilg.gov.ph \r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-800" . "\r\n";
    mail($to, $subject, $message, $headers);
}



mysqli_close($conn);
