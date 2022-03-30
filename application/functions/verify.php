<?php
session_start();
if (isset($_GET['vkey'])) {
    $vkey = $_GET['vkey'];
    include '../config/connection.php';

    $resultSet = $conn->query("SELECT UNAME, PASSWORD, IS_VERIFIED, VERIFICATION_CODE from tbl_admin_info where IS_VERIFIED=0 and VERIFICATION_CODE='$vkey' LIMIT 1");
    if ($resultSet->num_rows == 1) {
        $row = $resultSet->fetch_assoc();
      
        $update = $conn->query("UPDATE tbl_admin_info SET IS_VERIFIED = 1 where VERIFICATION_CODE='$vkey' LIMIT 1");
        if ($update) {
            
            $_SESSION['username'] = $row['UNAME'];
            $_SESSION['password'] = $row['PASSWORD'];
            ?>
           <script>window.location='../../registration.php?verified=1';</script>
            <?php
        
        } else {
            echo $conn->error;
        }
    } else {
        ?>
        <script>window.location='../../registration.php?verified=0';</script>
         <?php
       
    }
} else {
    die('Something went wrong');
}
?>