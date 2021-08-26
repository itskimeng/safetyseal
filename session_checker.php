<?php 


if (!isset($_SESSION['username'])) {
	require 'manager/ApplicationManager.php';
	
	$am = new ApplicationManager();

	$_SESSION['toastr'] = $am->addFlash('warn', 'Please Login again.', 'Session Expired');

	header('location:registration.php');
}