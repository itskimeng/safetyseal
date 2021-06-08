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
          $query = "SELECT * FROM tbl_userinfo WHERE UNAME = '$username' AND PASSWORD = '$password' and IS_APPROVE = '1'";  
          echo $query;
          $result = mysqli_query($conn, $query);  
          if(mysqli_num_rows($result) > 0)  
          {  
               $_SESSION['username'] = $username;  
               header("location:../dashboard.php");  
          }  
          else  
          {  
               echo '<script>alert("Login Failed.!")</script>';  
          }  
     }  
} 
mysqli_close($conn);
?>