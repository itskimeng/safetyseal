<?php
session_start();
date_default_timezone_set('Asia/Manila');
require '../application/config/connection.php';

$has_sent = $_POST['has_sent'];
$control_no = $_POST['cn'];

updateSendingStatus($conn, $has_sent, $control_no);
updateEmailSendingStatus($conn, $has_sent, $control_no);



function updateSendingStatus($conn, $val, $cn)
{
    $sql = "UPDATE `tbl_app_checklist` SET `sms_sending_status` = '$val' where control_no ='$cn'";
    echo $sql;
    $query = mysqli_query($conn, $sql);
    return $query;
}
function updateEmailSendingStatus($conn, $val, $cn)
{
    $sql = "UPDATE `tbl_app_checklist` SET `email_sending_status` = '$val' where control_no ='$cn'";
    echo $sql;
    $query = mysqli_query($conn, $sql);
    return $query;
}
