<?php
if (isset($_GET['vkey'])) {
    //Process Verification
    $vkey = $_GET['vkey'];
    include '../config/connection.php';

    $resultSet = $conn->query("SELECT IS_VERIFIED, VERIFICATION_CODE from tbl_userinfo where IS_VERIFIED=0 and VERIFICATION_CODE='$vkey' LIMIT 1");
    if ($resultSet->num_rows == 1) {
        //validate email
        $update = $conn->query("UPDATE tbl_userinfo SET IS_VERIFIED = 1 where VERIFICATION_CODE='$vkey' LIMIT 1");
        if ($update) {

            echo 'Your account has been verified. You may now login.';
        } else {
            echo $conn->error;
        }
    } else {
        echo 'This account invalid or already verified';
    }
} else {
    die('Something went wrong');
}
