<?php

require '../application/config/connection.php';
require '../manager/UserManager.php';
require '../manager/ApplicationManager.php';
require '../manager/ComponentsManager.php';

$app = new UserManager();
$am = new ApplicationManager();
$cm = new ComponentsManager();

$id = $_SESSION['userid'];

$user_est = $app->fetchEstablishments($id);
$gcode = isset($_SESSION['gcode']) ? $_SESSION['gcode'] : '';
$gscope = isset($_SESSION['gscope']) ? $_SESSION['gscope'] : '';
$user_info = $app->getUserInfo($id);
$province_opts = $am->getProvinces();
$lgu_opts = $am->getCityMuns($user_info['province_id']);
$government_nature = $cm->getGovtNature();
$has_applied = false;
if (count($user_est) > 0) {
	$has_applied = true;
}
?>
