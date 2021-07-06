<?php
session_start();
date_default_timezone_set('Asia/Manila');
require '../application/config/connection.php';

$has_sent = $_POST['has_sent'];
$control_no = $_POST['cn'];


    $sql = "UPDATE `tbl_app_checklist` SET `sms_sending_status` = '$has_sent' where control_no ='$control_no'";
    $query = mysqli_query($conn, $sql);



    // $sql = "UPDATE `tbl_app_checklist` SET `email_sending_status` = '$has_sent', `pnp_sending_status` = '$has_sent', `bfp_sending_status` = '$has_sent' where control_no ='$control_no'";
    // $query = mysqli_query($conn, $sql);

  

   ?>