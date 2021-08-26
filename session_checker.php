<?php 


if (!isset($_SESSION['username'])) {
	$_SESSION['toastr'] = $data = [
            'type'      => 'warn',
            'title'     => 'Session Expired',
            'message'   => 'Please Login again.'
        ];

	header('location:registration.php');
}