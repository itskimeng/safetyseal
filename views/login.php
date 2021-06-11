<?php
session_start();
require_once '../application/config/connection.php';
if (isset($_POST['login'])) {
     //get form data
     $username = mysqli_real_escape_string($conn, $_POST["username"]);
     if (isset($_POST['password'])) {
          $password = md5($_POST['password']);
     } else if (isset($_POST['password_reg'])) {
          $password = ($_POST['password_reg']);
     }

     // Query the database
     $resultSet = $conn->query("SELECT * from tbl_userinfo where UNAME = '$username' AND PASSWORD = '$password' LIMIT 1");
     if ($resultSet->num_rows !== 0) {
          //Process the login
          $row = $resultSet->fetch_assoc();
          $verified = $row['IS_VERIFIED'];
          $role_access = $row['ROLE'];

          if ($verified == 1) {

               if ($role_access == 'admin') {
                 $_SESSION['username']  = $username;
                    header("location: ../dashboard.v2.php?username=" . md5($username) . "");
               } else if ($role_access == 'user') {
                    $_SESSION['username'] =$username;
                    header("location:../index.php?username=" . md5($username) . "");
               }
          } else {
               $error = "This account has not yet been verified.";
               echo $error;
          }
     }else{
         header('Location: ../registration.php?login=failed');
     }
} else {
     echo 'something wrong';
}
mysqli_close($conn);
?>
