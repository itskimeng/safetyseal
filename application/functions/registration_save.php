<?php
date_default_timezone_set('Asia/Manila');
require_once '../config/connection.php';
$error = NULL;
    $agency_name =  mysqli_real_escape_string($conn, $_POST['government_agency']);
    $establishment_name   =    mysqli_real_escape_string($conn, $_POST['government_esta']);
    $firstname             =    mysqli_real_escape_string($conn, $_POST['fname']);
    $middlename             =    mysqli_real_escape_string($conn, $_POST['mname']);
    $lastname             =    mysqli_real_escape_string($conn, $_POST['lname']);
    $address   =    mysqli_real_escape_string($conn, $_POST['validateAddress']);
    $mobile_no          =    mysqli_real_escape_string($conn, $_POST['phone_no']);
    $emailAddress      =    mysqli_real_escape_string($conn, $_POST['emailAddress']);
    $username          =    mysqli_real_escape_string($conn, $_POST['username']);
    $password          =    mysqli_real_escape_string($conn, md5($_POST['password']));
    $password2          =    mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   
    $date = date('Y-m-d', time());


    if(strlen($username) < 5)
    {
        $error = "Your username muust be at least 10 characters";
    }else if($password != $password2)
    {
        $error = "Your passwords do not match.";
    }else{
        // Form is valid

        // Generate Key
        $vkey = md5(time(). $username);

        //insert to db
        
    $sql = "INSERT INTO `tbl_userinfo`(`ID`, `FIRST_NAME`, `MIDDLE_NAME`, `LAST_NAME`, `ADDRESS`, `MOBILE_NO`, `EMAIL_ADDRESS`, `GOV_AGENCY_NAME`, `GOV_ESTB_NAME`, `UNAME`, `PASSWORD`, `VERIFICATION_CODE`, `DATE_REGISTERED`, `IS_APPROVE`, `IS_VERIFIED`, `ROLE`, `PROVINCE`, `CITY_MUNICIPALITY`)
    VALUES (NULL,'$firstname','$middlename','$lastname','$address','$mobile_no','$emailAddress','$agency_name','$establishment_name','$username','$password','$vkey','$date', '0','0', 'user','Province', 'Municipality')";
       if (mysqli_query($conn, $sql)) {
        //    send email


        $to = 'markkimsacluti10101996@gmail.com';
        $subject = "Email Verification";
        $message = "<a href='http://localhost/application/functions/verify.php?vkey=".$vkey."'>Register Account</a>";
        $headers = "From: safetyseal@calabarzon.dilg.gov.ph \r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-800". "\r\n";
        mail($to,$subject,$message,$headers);
        echo 'success';
    } else {
        echo $mysqli->error;
    }
    }
    


//     mysqli_close($conn);

// header('Location:../../index.php');
    ?>
