<?php
require_once '../config/connection.php';
    $government_agency =  mysqli_real_escape_string($conn, $_POST['government_agency']);
    $governmenr_esta   =    mysqli_real_escape_string($conn, $_POST['governmenr_esta']);
    $firstname             =    mysqli_real_escape_string($conn, $_POST['fname']);
    $mname             =    mysqli_real_escape_string($conn, $_POST['mname']);
    $validatelname     =    mysqli_real_escape_string($conn, $_POST['validatename']);
    $validateAddress   =    mysqli_real_escape_string($conn, $_POST['validateAddress']);
    $phone_no          =    mysqli_real_escape_string($conn, $_POST['phone_no']);
    $emailAddress      =    mysqli_real_escape_string($conn, $_POST['emailAddress']);
    $username          =    mysqli_real_escape_string($conn, $_POST['username']);
    $password          =    mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword          =   mysqli_real_escape_string($conn, $_POST['cpassword']);

    $sql = "INSERT INTO `tbl_userinfo`
    (`ID`, `FIRST_NAME`, `MIDDLE_NAME`, `LAST_NAME`, `ADDRESS`, `MOBILE_NO`, `EMAIL_ADDRESS`, `GOV_AGENCY_NAME`, `GOV_ESTB_NAME`, `DATE_REGISTERED`, `IS_APPROVE`) 
    VALUES (null,'','$firstname','$middlename','$lastname','$address','$mobile_no','$emailAddress','$agency_name','$establishment_name',now(),'0')";
       if (mysqli_query($conn, $sql)) {
       
    } else {
    }
echo 'save';
    ?>
