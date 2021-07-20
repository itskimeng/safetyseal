<?php
session_start();
date_default_timezone_set('Asia/Manila');
require '../application/config/connection.php';

$has_sent_client = $_POST['has_sent_client'];
$control_no_client = $_POST['cn_client'];

$has_sent_admin = $_POST['has_sent_admin'];
$control_no_admin = $_POST['cn_admin'];

if($_POST['client'] == 'client')
{
        $sql = "UPDATE `tbl_app_checklist` SET `sms_sending_status` = '$has_sent_client' where control_no ='$control_no_client'";
    $query = mysqli_query($conn, $sql);
}else if($_POST['admin'] == 'admin')
{
     $sql = "UPDATE `tbl_app_checklist` SET `email_sending_status` = '$has_sent_admin', `pnp_sending_status` = '$has_sent_admin', `bfp_sending_status` = '$has_sent_admin' where control_no ='$control_no_admin'";
    $query = mysqli_query($conn, $sql);
}

   
    
  

  

   ?>