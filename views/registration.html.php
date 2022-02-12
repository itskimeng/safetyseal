<div class="container" style="padding-top: 5%; padding-bottom: 1%;">
  <img src="frontend/images/banner_calabarzon.png" height="10%" width="100%" alt="">
</div>

<div class="registration-image">
  <div class="container">
    
    <div class="pt-5">
   
      <div class="row align-items-center heading">
        
        <div class="col-lg-7 mb-4 text-white">
          <!-- <header class="py-5 mt-5"> -->
          <header>
            <h1 class="display-6 headingText" style="color: white;">Safety Seal Registration</h1>
            <p class="lead mb-0" style=" font-size:17px; color:#e8e7e7;">
              Register Now! for Safety Seal Certification
            </p>

          </header>
        </div>


        <div class="col-md-5">
          <div class="py-4">
            <div class="form-box shadow p-3 mb-5 bg-body rounded">


              <div class="text-center">
                <div class="h3 font-weight-bold">
                  Sign In to SafetySeal
                </div>
                <p class="text-muted">
                  New Here?
                  <a href="#!" data-bs-toggle="modal" data-bs-target="#exampleModal">Create an account</a>
                </p>
              </div>
              <div class="alert-messages text-center">
                
              </div>
              <form method="POST" action="views/login.php">

                <input type="hidden" name="_token" value="9bAiLIQmMfgBUrC2hmmc1TbPIYW7n9IJDJJeCXqx">
                <!-- Email Address -->
                <div class="form-group mt-9">
                  <label class="form-label font-weight-bolder" for="email">
                    Username
                  </label>

                  <input class="form-control form-control-lg form-control-solid" name="username" required="required" autofocus="autofocus">
                </div>

                <!-- Password -->
                <div class="form-group mt-6">
                  <div class="d-flex justify-content-between">
                    <label class="form-label font-weight-bolder" for="password">
                      Password
                    </label>
                    <!-- <a href="https://safetyseal.ncr.dilg.gov.ph/forgot-password" class="text-primary text-hover-primary" id="kt_login_forgot">Forgot your password?</a> -->
                  </div>

                  <input class="form-control form-control-lg form-control-solid" id="password" type="password" name="password" required="required" autocomplete="current-password">
                </div>

                <!-- Remember Me -->
                <!-- <div class="checkbox-list"> -->
                  <!-- <label class="checkbox"> -->
                    <!-- <input id="remember_me" type="checkbox" name="remember" /> -->
                    <!-- <span></span> -->
                    <!-- Remember me -->
                  <!-- </label> -->
                <!-- </div> -->

                <div class="form-group mt-3">
                  <button type="submit" name="login" class="btn btn-light-primary">
                    Login
                  </button>
                </div>
              </form>

            </div>
          </div>
        </div>




      </div>
      <!-- <div class="row"> -->
    </div>
  </div>
</div>
<?php include 'registration_modal.php' ?>
<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
      .forEach(function(form) {
        form.addEventListener('submit', function(event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }

          form.classList.add('was-validated')
        }, false)
      })
  })()
</script>
<script>
  let login = '<?php if (isset($_GET['login'])) { echo $_GET['login']; } else { } ?>';
  if (login) {
    showAndDismissAlert('danger', 'Login Failed!');
  }

  function showAndDismissAlert(type, message) {
    var htmlAlert = '<div class="alert alert-' + type + '"><i class="fa fa-exclamation-triangle"></i>' + message + '</div>';

    // Prepend so that alert is on top, could also append if we want new alerts to show below instead of on top.
    $(".alert-messages").prepend(htmlAlert);

    // Since we are prepending, take the first alert and tell it to fade in and then fade out.
    // Note: if we were appending, then should use last() instead of first()
    $(".alert-messages .alert").first().hide().fadeIn(200).delay(2000).fadeOut(1000, function() {
      $(this).remove();
    });
  }
</script>
<style>
</style>