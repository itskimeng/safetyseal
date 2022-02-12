<?php
session_start();
// require_once '../application/config/connection.php';
require_once '../controller/LoginController.php';

// if ($_POST['username'] != 'jcbajite') {
//      header('Location: ../registration.php?login=failed');
// } else
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
     if (!empty($user_cred)) {
          foreach ($user_cred as $key => $user_data){

               if($user_data['IS_VERIFIED'] ==1)
               {
                    if ($user_data['ROLES'] == 'admin') {
                      $_SESSION['username']  = $user_data['UNAME'];
                      $_SESSION['province']  = $user_data['PROVINCE'];
                      $_SESSION['city_mun']  = $user_data['CITY_MUNICIPALITY'];
                      $_SESSION['userid']  = $user_data['ID'];
                      $_SESSION['nature'] = $user_data['nature'];
                      $_SESSION['is_clusterhead']  = $user_data['is_clusterhead'];
                      $_SESSION['clusterhead_id'] = $user_data['clusterhead_id'];
                      $_SESSION['is_pfp'] = $user_data['is_pfp'];
                      $_SESSION['position'] = $user_data['position'];

                      header("location: ../dashboard.v2.php?username=" . md5($username) . "");
                    } else if ($user_data['ROLES'] == 'user') {
                         $_SESSION['username']  = $user_data['UNAME'];
                         $_SESSION['userid']  = $user_data['ID'];
                         $_SESSION['province']  = $user_data['PROVINCE'];
                         $_SESSION['city_mun']  = $user_data['CITY_MUNICIPALITY'];
                         $_SESSION['name'] = $user_data['name'];
                         $_SESSION['email'] = $user_data['email'];
                         
                     
                         header("location:../dashboard_user.php?username=" . md5($username) . "");
                    }
               }
               else {
                    $error = "This account has not yet been verified.";
                    echo $error;
               }
          }
     }
} else {
     header('Location: ../registration.php?login=failed');
}


mysqli_close($conn);

?>