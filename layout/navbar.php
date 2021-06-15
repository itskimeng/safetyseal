<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top navscroll" style=" background-color: #1e1e2d; ">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php" id="navhome">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="guidelines.php" id="navguidelines">Guidelines </a>
          </li>
          <?php if (!isset($_SESSION['username'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="registration.php" id="navapplication">Application </a>
            </li>
          <?php endif ?>
        
          <li class="nav-item">
            <a class="nav-link" href="certified-establishments.php" id="navcertified">Certified Establishments </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="inspection-and-certification-team.php" id="navinspection">Inspection and Certification Teams </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="complaints.php" id="navcomplaints">Complaints</a>
          </li>

        </ul>
        <?php
        if (isset($_SESSION['username'])) {
        ?>
          <ul class="navbar-nav ">
            <li class="nav-item">
              <a class="nav-link" href="certificate.php" id="navcomplaints" target="_blank"><span class="certificationTxt">My Certification <i class="fa fa-certificate"></i></span></a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Logout(<?php echo $_SESSION['username']; ?>)
              </a>
              <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                <li><a class="dropdown-item" href="../user/user_profile.php">My Profile</a></li>
                <li><a class="dropdown-item" href="user/users_establishments.php">My Establishments</a></li>
                <li><a class="dropdown-item" href="views/logout.php">Log out</a></li>
              </ul>
            </li>
          </ul>
        <?php
        }else{
          ?>
           <a class="nav-link login-menu" href="registration.php" id="navlogin">
           Login
           </a>
           <span><a class="nav-link contact-us" href="#" tabindex="-1" aria-disabled="true" id="navcontact">Contact Us</a><span>
          <?php
        }
        ?>
       



        

      </div>
    </div>
  </nav>
</header>