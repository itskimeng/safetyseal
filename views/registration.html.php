<div class="registration-image">
  <div class="container">
    <div class="pt-5">
      <div class="row align-items-center heading">

        <div class="col-lg-7 mb-4 text-white">
          <!-- <header class="py-5 mt-5"> -->
          <header>
            <h1 class="display-6 headingText">Safety Seal Registration</h1>
            <p class="lead mb-0" style=" font-size:17px; color:#e8e7e7;">
              The Safety Seal Certification is a voluntary certification scheme that a firms
              that an establishment is compliant with the maximum public health standards set
              by the goverment and uses or integrates its contact tracing with StaySafe.ph.
              governance excellence through knowledge sharing</p>
            <a href="#facilitiesId" class="btn btn-primary btn-lg mt-3 scrollTo" style="background-color: #c30718; border-color:#ad0735;">Who Are We</a>
          </header>
        </div>


        <div class="col-md-5">
          <div class="py-5">
            <div class="form-box shadow p-3 mb-5 bg-body rounded">
              <form class="bg-white  rounded-5 shadow-5-strong p-5">
                <!-- Email input -->
                <div class="form-outline mb-4">
                  <input type="text" id="form1Example1" class="form-control" />
                  <label class="form-label" for="form1Example1">Username</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                  <input type="password" id="form1Example2" class="form-control" />
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
                    <a href="#!" data-bs-toggle="modal" data-bs-target="#exampleModal">Sign-up here!</a>
                  </div>
                </div>

                <!-- Submit button -->
                <button class="btn btn-primary btn-block">Sign in</button>
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