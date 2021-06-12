<?php

require '../application/config/connection.php';
require '../manager/DashboardManager.php';

$app = new DashboardManager();
$username = mysqli_real_escape_string($conn, $_POST["username"]);
$password = mysqli_real_escape_string($conn, md5($_POST["password"]));

$user_cred = $app->count();  


?>
