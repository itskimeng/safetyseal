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
          <a href="#" class="nav-link">Home</a>
        </li>
        <li class="nav-item">
          <a href="dashboard.v2.php" class="nav-link">Dashboard</a>
        </li>
        <li class="nav-item">
          <a href="admin_application.php" class="nav-link">Application</a>
        </li>

        <li class="nav-item">
          <a href="views/logout.php" class="nav-link">Logout(<?php echo $_SESSION['username'];?>)</a>
        </li>

      </ul>

    </div>

  </div>
</nav>