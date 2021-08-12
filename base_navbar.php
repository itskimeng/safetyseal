<nav class="main-header navbar navbar-expand-md navbar-light navbar-dark">
  <div class="container">
    <a href="dashboard.v2.php" class="navbar-brand">
      <img src="frontend/images/logo.png" alt="SafetySeal Logo" class="brand-image img-circle elevation-3" style="opacity: .8; height: 40px;">
      <span class="brand-text font-weight-light">SafetySeal</span>
    </a>

    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto" id="navbarCollapse">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
     
        <li class="nav-item">
          <?php if (isset($_GET['username'])): ?>
            <a href="dashboard.v2.php?username=<?php echo $_GET['username']; ?>" class="nav-link">Dashboard</a>
          <?php else: ?>
            <a href="dashboard.v2.php?username=<?php echo $_SESSION['username']; ?>" class="nav-link">Dashboard</a>
          <?php endif ?>
        </li>
        <?php if ($_SESSION['province'] != 0 AND $_SESSION['city_mun'] != 00): ?>
        <li class="nav-item">
          <a href="admin_application.php" class="nav-link">Application</a>
        </li>
        <?php endif ?>
        <li class="nav-item">
          <a href="admin_report_application.php" class="nav-link">Generate Reports</a>
        </li>

        <?php if ($_SESSION['is_pfp'] > 0 OR $_SESSION['province'] == 0 AND $_SESSION['city_mun'] == 00): ?>
          <li class="nav-item">
            <a href="uac.php" class="nav-link">User Accounts</a>
          </li>
        <?php endif ?>
        
        <?php if($_SESSION['username'] == 'dilg4@rictu'):?>
        <li class="nav-item">
          <a href="admin_send_notif.php" class="nav-link">Notification</a>
        </li>
        <?php endif;?>
       

        <li class="nav-item">
          <a href="views/logout.php" class="nav-link">Logout(<?php echo $_SESSION['username'];?>)</a>
        </li>

      </ul>

    </div>

  </div>
</nav>