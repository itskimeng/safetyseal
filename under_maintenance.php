<!DOCTYPE html>
<html lang="en">
<?php include 'layout/header.html.php'; ?>
<body>
    <main>
        <div class="container mt-4">
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
			          <li class="nav-item">
			            <?php if (!isset($_SESSION['username'])): ?>
			                <a class="nav-link" href="registration.php" id="navapplication">Application </a>
			            <?php else: ?>
			                <a class="nav-link" href="user/application_list.php" id="navapplication">Application </a>
			            <?php endif ?>
			          </li>
			        
			          <li class="nav-item">
			            <a class="nav-link" href="certified-establishments.php" id="navcertified">Certified Establishments </a>
			          </li>
			          <li class="nav-item">
			            <a class="nav-link" href="inspection-and-certification-team.php" id="navinspection">Inspection and Certification Teams </a>
			          </li>
			          <li class="nav-item">
			            <a class="nav-link" href="complaints.php" id="navcomplaints">Complaints</a>
			          </li>
			           <!--  <li class="nav-item">
			              <a class="nav-link" href="certificate.php" id="navcomplaints" target="_blank"><span class="certificationTxt">My Certification <i class="fa fa-certificate"></i></span></a>
			            </li> -->

			        </ul>
			           <a class="nav-link login-menu" href="registration.php" id="navlogin">
			           Login
			           </a>
			           <span><a class="nav-link contact-us" href="#" tabindex="-1" aria-disabled="true" id="navcontact">Contact Us</a><span>

			      </div>
			    </div>
			  </nav>
			</header>



        	<img class="mt-5" src="frontend/images/banner_calabarzon.png" height="10%" width="100%" alt="">
  			<hr>

			<article>

				<div class="text-center">
					<script>
						TargetDate = "2022-02-14T12:00:00";
						BackColor = "none";
						ForeColor = "navy";
						CountActive = true;
						CountStepper = -1;
						LeadingZero = true;
						DisplayFormat = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
						FinishMessage = "It is finally here!";
					</script>
					<script language="JavaScript" src="https://rhashemian.github.io/js/countdown.js"></script>
				</div>
				<br>
			    <h1>We&rsquo;ll be back soon!</h1>
			    <div>
			        <p>Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment. If you need to you can always contact us, otherwise we&rsquo;ll be back online shortly!</p>
			        <p>&mdash; DILG IV-A</p>
			    </div>
			</article>

        </div>
    </main>
</body>


</html>

<style type="text/css">
	#cntdwn {
		font-size: 50px;
	}
</style>
	
<script src="frontend/js/banner.js"></script>

