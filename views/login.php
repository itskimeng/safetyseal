<?php
session_start();
require_once '../application/config/connection.php';
// if(isset($_POST["login"]))  
// {  
//      if(empty($_POST["username"]) && empty($_POST["password"]))  
//      {  
//           echo '<script>alert("Both Fields are required")</script>';
//      }  
//      else  
//      {  
//           $username = mysqli_real_escape_string($conn, $_POST["username"]);  
//           $password = md5($_POST['password']);  
//           $sql1 = mysqli_query($conn,"SELECT `ROLE`,`UNAME` FROM tbl_userinfo WHERE UNAME = '".$username."' and IS_APPROVE = '1' LIMIT 1");
//           $row = mysqli_fetch_array($sql1);
//           $role_access = $row['ROLE'];
//         if(empty($role_access))
//         {
//             header('Location: ../registration.php?message=failed');
//         }else{

        
//           if($role_access == 'admin'){
//                $query = "SELECT * FROM tbl_userinfo WHERE UNAME = '$username' AND PASSWORD = '$password' and `ROLE`= 'admin' ";  
//                $result = mysqli_query($conn, $query);  
//                if(mysqli_num_rows($result) > 0)  
//                {  
//                     $_SESSION['username'] = $username;  
//                     header("location: ../dashboard.v2.php?username=".md5($username)."");  
//                }  
//                else  
//                {  
//                     echo '<script>alert("Login Failed.!")</script>'; 
//                     header('Location: ../registration.php?message=failed');
//                }  
//           }else if($role_access == 'user'){
//                $query = "SELECT * FROM tbl_userinfo WHERE UNAME = '$username' AND PASSWORD = '$password' and `ROLE`= 'user' ";  
//                $result = mysqli_query($conn, $query);  
//                if(mysqli_num_rows($result) > 0)  
//                {  
//                     $_SESSION['username'] = $username;  
//                     header("location:../dashboard_user.php?username=".$username."");  
//                }  
//                else  
//                {  
//                     echo '<script>alert("Login Failed.!")</script>'; 
//                     header('Location: ../registration.php?message=failed ');
//                }  
//           }
//         }
               
//      }  
// } 

if(isset($_POST['login']))
{
     //get form data
     $username = mysqli_real_escape_string($conn, $_POST["username"]);  
     $password = md5($_POST['password']); 

     // Query the database
     $resultSet = $conn->query("SELECT * from tbl_userinfo where UNAME = '$username' AND PASSWORD = '$password' LIMIT 1");
     if($resultSet->num_rows !==0){
          //Process the login
          $row = $resultSet->fetch_assoc();
          $verified = $row['IS_VERIFIED'];
          $role_access = $row['ROLE'];

          if($verified ==1){
               
          if($role_access == 'admin'){
                    $_SESSION['username'] = $username;  
                    header("location: ../dashboard.v2.php?username=".md5($username)."");               
          }else if($role_access == 'user'){
               $_SESSION['username'] = $username;  

                    header("location:../index.php?username=".md5($username)."");  
          }
          }else{
               $error = "This account has not yet been verified.";
               echo $error;
          }
     }
}else{
     echo 'something wrong';
}
mysqli_close($conn);
?>


 