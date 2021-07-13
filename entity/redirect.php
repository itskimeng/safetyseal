<?php
session_start();
// $url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST']);
$url = $url_array[0];


header("location: ../admin_verification_page.php");    
// header('location:../admin_verification_page.php');exit;