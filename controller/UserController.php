<?php

require '../application/config/connection.php';
require '../manager/UserManager.php';

$app = new UserManager();
$id = $_SESSION['userid'];

$user_est = $app->fetchEstablishments($id);


?>
