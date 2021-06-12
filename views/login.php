<?php
session_start();
// require_once '../application/config/connection.php';
require_once '../controller/LoginController.php';

if (isset($_POST['login'])) {
     //get form data
     $username = mysqli_real_escape_string($conn, $_POST["username"]);

     if (isset($_POST['password'])) {
          $password = ($_POST['password']);
     } else if (isset($_POST['password_reg'])) {
          $password = ($_POST['password_reg']);
     }
     // Query the database
     // APPLICANT

     foreach ($user_cred as $key => $user_data){

          if($user_data['IS_VERIFIED'] ==1)
          {

               
               if ($user_data['ROLES'] == 'admin') {
                 $_SESSION['username']  = $user_data['UNAME'];
                 $_SESSION['province']  = $user_data['PROVINCE'];
                 $_SESSION['city_mun']  = $user_data['CITY_MUNICIPALITY'];
                
                 $_SESSION['userid']  = $user_data['ID'];

                    header("location: ../dashboard.v2.php?username=" . md5($username) . "");
               } else if ($user_data['ROLE'] == 'user') {
                    $_SESSION['username']  = $user_data['UNAME'];
                    $_SESSION['userid']  = $user_data['ID'];
                    header("location:../dashboard_user.php?username=" . md5($username) . "");
               }
          }
          else {
               $error = "This account has not yet been verified.";
               echo $error;
          }
     }
}






//      $resultSet = $conn->query("SELECT * from tbl_userinfo where UNAME = '$username' AND PASSWORD = '$password' LIMIT 1");
//      if ($resultSet->num_rows !== 0) {
//           //Process the login
//           $row = $resultSet->fetch_assoc();
//           $verified = $row['IS_VERIFIED'];
//           $role_access = $row['ROLE'];
//           $userid = $row['ID'];
//           $province = $row['PROVINCE'];
//           $city_mun = $row['CITY_MUNICIPALITIES'];
          

//           if ($verified == 1) {

//                $_SESSION['userid']  = $userid;
//                if ($role_access == 'admin') {
//                  $_SESSION['username']  = $username;
//                  $_SESSION['province']  = $province;
//                  $_SESSION['city_mun']  = $city_mun;
//                     header("location: ../dashboard.v2.php?username=" . md5($username) . "");
//                } else if ($role_access == 'user') {
//                     $_SESSION['username'] =$username;
//                     header("location:../dashboard_user.php?username=" . md5($username) . "");
//                }

//           } else {
//                $error = "This account has not yet been verified.";
//                echo $error;
//           }
//      }else{
//          header('Location: ../registration.php?login=failed');
//      }
// } else {
//      echo 'something wrong';
// }
mysqli_close($conn);

?>