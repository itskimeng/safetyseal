<?php 


if (!isset($_SESSION['username'])) {
	$_SESSION['toastr'] = [
            'type'      => 'warn',
            'title'     => 'Session Expired',
            'message'   => 'Please Login again.'
        ];

	header('location:registration.php');
	exit();
}