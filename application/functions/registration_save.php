<?php
date_default_timezone_set('Asia/Manila');

require_once '../config/connection.php';
    $agency_name =  mysqli_real_escape_string($conn, $_POST['government_agency']);
    $establishment_name   =    mysqli_real_escape_string($conn, $_POST['government_esta']);
    $firstname             =    mysqli_real_escape_string($conn, $_POST['fname']);
    $middlename             =    mysqli_real_escape_string($conn, $_POST['mname']);
    $lastname             =    mysqli_real_escape_string($conn, $_POST['lname']);
    $address   =    mysqli_real_escape_string($conn, $_POST['validateAddress']);
    $mobile_no          =    mysqli_real_escape_string($conn, $_POST['phone_no']);
    $emailAddress      =    mysqli_real_escape_string($conn, $_POST['emailAddress']);
    $username          =    mysqli_real_escape_string($conn, $_POST['username']);
    $password          =    mysqli_real_escape_string($conn, $_POST['password']);
    $date = date('Y-m-d', time());


    $sql = "INSERT INTO `tbl_userinfo`(`ID`, `FIRST_NAME`, `MIDDLE_NAME`, `LAST_NAME`, `ADDRESS`, `MOBILE_NO`, `EMAIL_ADDRESS`, `GOV_AGENCY_NAME`, `GOV_ESTB_NAME`, `UNAME`, `PASSWORD`, `DATE_REGISTERED`, `IS_APPROVE`)
    VALUES (NULL,'$firstname','$middlename','$lastname','$address','$mobile_no','$emailAddress','$agency_name','$establishment_name','$username','$password','$date', '0')";
       if (mysqli_query($conn, $sql)) {
       
    } else {
    }
header('Location:../../index.html.php');
    ?>
