<?php
session_start();
// test

require_once 'frontend/bower_components/phpti-master/src/ti.php'; 
?>

<?php include 'base_template.php'; ?>

<?php startblock('title'); ?>
  User Accounts - Edit
<?php endblock('title'); ?>

<?php startblock('content'); ?>
  <?php include('views/users/edit.php'); ?>
<?php endblock(); ?>
