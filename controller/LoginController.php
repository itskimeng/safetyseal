<?php

require '../application/config/connection.php';
require '../manager/LoginManager.php';

$app = new LoginManager();
$username = mysqli_real_escape_string($conn, $_POST["username"]);
$password = mysqli_real_escape_string($conn, md5($_POST["password"]));

$user_cred = $app->getUsersRole($username,$password);  


?>
