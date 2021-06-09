<div class="registration-image">
  <div class="container">
    <div class="pt-5">
      <div class="row align-items-center heading">

        <div class="col-lg-7 mb-4 text-white">
          <!-- <header class="py-5 mt-5"> -->
          <header>
            <h1 class="display-6 headingText">Safety Seal Registration</h1>
            <p class="lead mb-0" style=" font-size:17px; color:#e8e7e7;">
            Register Now! for Safety Seal Certification
             </p>
            
          </header>
        </div>


        <div class="col-md-5">
          <div class="py-5">
            <div class="form-box shadow p-3 mb-5 bg-body rounded">
              <form method = "POST" action = "views/login.php" class="bg-white  rounded-5 shadow-5-strong p-5">
                <!-- Email input -->
                <div class="form-outline mb-4">
                  <input type="text" name="username" id="form1Example1" class="form-control" autocomplete="off"/>
                  <label class="form-label" for="form1Example1">Username</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                  <input type="password" name="password" id="form1Example2" class="form-control" autocomplete="off" />
                  <label class="form-label" for="form1Example2">Password</label>
                </div>

                <!-- 2 column grid layout for inline styling -->
                <div class="row mb-4">
                  <div class="col d-flex justify-content-center">
                    <!-- Checkbox -->
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                      <label class="form-check-label" for="form1Example3">
                        Remember me
                      </label>
                    </div>
                  </div>

                  <div class="col text-center">
                    <!-- Simple link -->
                    <a href="#!" data-bs-toggle="modal" data-bs-target="#exampleModal">Create an account</a>
                  </div>
                </div>

                <!-- Submit button -->
                <button type = "submit" class="btn btn-primary btn-block" name="login">Sign in</button>
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
<script src="/frontend/js/ajax.js"></script>