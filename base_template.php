<!DOCTYPE html>
<html>
  <head>
    <link rel="shortcut icon" type="image/png" href="dilg.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SafetySeal | <?php emptyblock('title'); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- all assets will be loaded here -->
    <?php startblock('assets'); ?>
      <?php include 'base_menu.css.php'; ?>    
      <?php include 'base_menu.js.php'; ?>
    <?php endblock() ?>
    <!-- end all -->

  </head>
  <body class="hold-transition layout-top-nav">
    <div class="wrapper">

      <!-- navigation panel -->
      <?php startblock('navbar') ?>
        <?php include 'base_navbar.php'; ?>
      <?php endblock(); ?>
      <!-- end navigation panel -->

      <div class="content-wrapper">
        <!-- all contents will be included here -->
        <?php emptyblock('content') ?>
        <!-- end all contents -->
      </div>
    
    </div>  
  </body>
  <!-- Main Footer -->
  <footer class="main-footer d-flex">
    
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</html>

