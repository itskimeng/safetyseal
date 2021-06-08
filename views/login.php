<?php
session_start();
require_once '../application/config/connection.php';
if(isset($_POST["login"]))  
{  
     if(empty($_POST["username"]) && empty($_POST["password"]))  
     {  
          echo '<script>alert("Both Fields are required")</script>';
     }  
     else  
     {  
          $username = mysqli_real_escape_string($conn, $_POST["username"]);  
          $password = md5($_POST['password']);  
          $sql1 = mysqli_query($conn,"SELECT `ROLE`,`UNAME` FROM tbl_userinfo WHERE UNAME = '".$username."' and IS_APPROVE = '1' LIMIT 1");
          $row = mysqli_fetch_array($sql1);
          $role_access = $row['ROLE'];
        if(empty($role_access))
        {
            header('Location: ../registration.php?message=failed');
        }
        if($role_access == 'admin'){
          $query = "SELECT * FROM tbl_userinfo WHERE UNAME = '$username' AND PASSWORD = '$password' and `ROLE`= 'admin' ";  
          $result = mysqli_query($conn, $query);  
          if(mysqli_num_rows($result) > 0)  
          {  
               $_SESSION['username'] = $username;  
               header("location: ../dashboard.php?username=".$username."");  
          }  
          else  
          {  
               echo '<script>alert("Login Failed.!")</script>'; 
               header('Location: ../registration.php?message=failed');
          }  
        }else if($role_access == 'user'){
            $query = "SELECT * FROM tbl_userinfo WHERE UNAME = '$username' AND PASSWORD = '$password' and `ROLE`= 'user' ";  
          $result = mysqli_query($conn, $query);  
          if(mysqli_num_rows($result) > 0)  
          {  
               $_SESSION['username'] = $username;  
               header("location:../dashboard.php?username=".$username."");  
          }  
          else  
          {  
               echo '<script>alert("Login Failed.!")</script>'; 
               header('Location: ../registration.php?message=failed ');
          }  
        }
          
     }  
} 
mysqli_close($conn);
?>


 