<div class="registration-image">
      <div class="container">
          <div class="pt-5">            <div class="row align-items-center heading">

              <div class="col-lg-7 mb-4 text-white">
                <!-- <header class="py-5 mt-5"> -->
                <header>
                    <h1 class="display-6 headingText">Local Governance Regional Resource Center (LGRRC) CALABARZON</h1>
                    <p class="lead mb-0" style=" font-size:17px; color:#e8e7e7;">Building learning communities in the whole CALABARZON Region that pursue local governance excellence through knowledge sharing</p>
                    <!-- <a href="#facilitiesId" class="btn btn-primary btn-lg mt-3 scrollTo">Who Are We</a> -->
                    <a href="#facilitiesId" class="btn btn-primary btn-lg mt-3 scrollTo" style="background-color: #c30718; border-color:#ad0735;">Who Are We</a>
                </header>
              </div>
              <div class="col-md-5">
                <div class="py-5">
                   <div class="form-box">
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
                    <a href="#!">Forgot password?</a>
                  </div>
                </div>

                <!-- Submit button -->
                <button type="submit"  onclick="modalRegister();" class="btn btn-primary btn-block">Sign in</button>
              </form>
                    
                    </div>
                </div>
              </div>


            <!-------------------------------- MODAL RESET PASSWORD ----------------------------->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <center>
                      Username:
                      <input type="text" class="form-control" id="passwordUsername" style="width: 70%;">
                      <br>
                      Enter Email:
                      <input type="email" class="form-control" id="passwordEmail" style="width: 70%;">
                    </center>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="btnUpdatePassword">Update <i class="fa fa-paper-plane"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-------------------------------- MODAL RESET PASSWORD ----------------------------->

            <div id="modalRegister" data-izimodal-group="group1"></div>

            </div>
            <!-- <div class="row"> -->
          </div>
      </div>

    </div>
    <!-- bgImage -->
 