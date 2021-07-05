  <?php require_once 'application/config/connection.php'; ?>
  <img src="frontend/images/banner_calabarzon.png" height="10%" width="100%" alt="">
 

  <div class = "container bg-light">
    <div class="row">
        <div class="col-lg-12 banner">        
        </div>
      </div>
  </div>
    <div class="container">
      <!-- Stack the columns on mobile by making one full-width and the other half-width -->
      <div class="row">
        <div class="col-md-6 bg-light">
          <div class="row" style="padding:5px;">
            <div class="col-lg-12 bg-light" style="padding:5px;">
              <div class="container shadow p-3 mb-3 bg-body rounded banner-guidelines" style="background-color:#B0BEC5;height: 250px;">
                <a href="guidelines.php" class="btn btn-light-primary py-2 me-5 mr-2  btn-guide">Read More</a>
              </div>
            </div>
            <div class="col-6 bg-light" style="padding: 5px;">
              <div class="container shadow p-3 mb-5 bg-body rounded rounded application" style="background-color:#B0BEC5; height:500px;">
                <a href="wbstapplication.php" class="btn btn-light-primary py-2 me-5 mr-2 btn-application">Apply Now!</a>
              </div>
            </div>
            <div class="col-6 bg-light" style="padding: 5px;">
              <div class="container shadow p-3 mb-5 bg-body request_forms-banner " style="background-color:#B0BEC5; height:500px;">
                <a href="wbstapplication.php"  class="btn btn-light-primary py-2 me-5 mr-2 btn-request">Request</a>
              </div>
            </div>
          </div>
        </div>
        <!-- ddd -->
        <div class="col-md-6 bg-light">
          <div class="row" style="padding:5px;">
            <div class="col-6 bg-light" style="padding: 5px;">
              <div class="container shadow p-3 mb-3 bg-body rounded list_establishment-banner" style="background-color:#B0BEC5; height:500px;">
              <a href="certified-establishments.php" class="btn btn-light-primary py-2 me-5 mr-2 btn-establishment">View All</a>

              </div>
            </div>
            <div class="col-6 bg-light" style="padding: 5px;">
              <div class="container shadow p-3 mb-3 bg-body rounded contact-banner " style="background-color:#B0BEC5; height:500px;">
              <a href="inspection-and-certification-team.php" class="btn btn-light-primary py-2 me-5 mr-2 btn-contact">View</a>

              </div>
            </div>
            <div class="col-lg-12 bg-light" style="padding: 5px;">
              <div class="container shadow p-3 mb-5 bg-body rounded inquiries_complaints" style="background-color:#B0BEC5;height: 250px;">
              <a href="complaints.php" class="btn btn-light-primary py-2 me-5 mr-2 btn-inquiries">Send</a>

              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <center>
            <h3>Newly Certified Establishments</h3>
          </center>
        </div>
      </div>

      <div class="row my-5">
        <!-- Set up your HTML -->
        <div class="owl-carousel">

            <div>
              <div class="card">
                <div class="card-header" style="background-color: #480272; color:white; height: 65px;">
                  <center>BJMP City of Cabuyao <i class="fa fa-check"></i></center>
                </div>
                <div class="card-body cardRecentEstablishment">
                  <a href="establishment-profile.php?unique_id=172"><img src="files/certified/cabuyao.png" alt="" height="250"></a>
                </div>
                <div class="card-footer text-muted">
                  Certified: <b>July 01, 2021</b>
                </div>
              </div>
            </div>

            <div>
              <div class="card">
                <div class="card-header" style="background-color: #480272; color:white;">
                  <center>BUREAU OF FIRE PROTECTION CATANAUAN STATION <i class="fa fa-check"></i></center>
                </div>
                <div class="card-body cardRecentEstablishment">
                  <a href="establishment-profile.php?unique_id=149"><img src="files/certified/catanuan2.jpg" alt="" height="250"></a>
                </div>
                <div class="card-footer text-muted">
                  Certified: <b>June 30, 2021</b>
                </div>
              </div>
            </div>

            <div>
              <div class="card">
                <div class="card-header" style="background-color: #480272; color:white;">
                  <center>BUREAU OF FIRE PROTECTION - LUCBAN FIRE STATION <i class="fa fa-check"></i></center>
                </div>
                <div class="card-body cardRecentEstablishment">
                  <a href="establishment-profile.php?unique_id=110"><img src="files/certified/lucban.png" alt="" height="250"></a>
                </div>
                <div class="card-footer text-muted">
                  Certified: <b>June 28, 2021</b>
                </div>
              </div>
            </div>

        </div>
      </div>

  