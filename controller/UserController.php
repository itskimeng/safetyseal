<?php

require '../application/config/connection.php';
require '../manager/UserManager.php';

$app = new UserManager();
$id = $_SESSION['userid'];

$user_est = $app->fetchEstablishments($id);
$gcode = isset($_SESSION['gcode']) ? $_SESSION['gcode'] : '';
$gscope = isset($_SESSION['gscope']) ? $_SESSION['gscope'] : '';

?>
