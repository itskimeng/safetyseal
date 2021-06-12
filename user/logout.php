<?php
session_start();
session_destroy();
session_unset();
header('../index.php');
?>