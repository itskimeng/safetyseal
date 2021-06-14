<img src="frontend/images/banner_calabarzon.png" height="10%" width="100%" alt="">
 <hr>
  <div class="row mt-5 mb-5">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
          Home / Certified Establishments
        </div>
        <div class="card-body" style="background-color: #f9f8f8;">

<!--           <div class="d-flex align-items-center row">
              <div class="position-relative col-md-4 my-2">
                  <input class="form-control form-control-lg form-control-solid" name="name" value="" placeholder="Search establishment name">
              </div>
              <div class="d-flex align-items-left col-md-8 my-2">
                  <button type="submit" class="btn btn-light-primary py-2 me-5 mr-2">
                      <i class="fa fa-search"></i> Search
                  </button>
                  <a href="certified-establishments.php" class="btn btn-secondary py-2 me-5 mr-2">
                      <i class="fa fa-sync-alt"></i> Reset
                  </a>
              </div>
          </div> -->
         


        <table class="table table-hover mb-0 border-bottom" id="establishmentsTable">
            <thead>
                <tr>
                    <th width="25%">AGENCY</th>
                    <th width="25%">ESTABLISHMENT</th>
                    <th width="40%">ADDRESS</th>
                    <th width="15%">SAFETY SEAL NO</th>
                    <th width="10%">ISSUED ON</th>
                    <th width="10%">VALID UNTIL</th>
                    <th width="10%">STATUS</th>
                </tr>
            </thead>
            <tbody>
                <tr class="clickable-row" data-href="establishment-profile.php">
                        <td class="align-middle">
                            <a href="establishment-profile.php" target="_blank" class="">
                                <div class="font-weight-bold">
                                    Bureau of Permits
                                </div>
                            </a>
                        </td>
                        <td class="align-middle">
                            <a href="establishment-profile.php" class="">
                                <div class="font-weight-bold">
                                    Bureau of Permits
                                </div>
                            </a>
                        </td>
                        <td class="align-middle">
                            Room 110, Manila City Hall, Padre Burgos St., Ermita, Barangay 659-A, CITY OF MANILA, NCR, FIRST DISTRICT, NATIONAL CAPITAL REGION
                        </td>
                        <td class="align-middle" nowrap="">
                                NCR-2021-0000065
                        </td>
                        <td class="align-middle" nowrap="">
                            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                                <i class="la la-clipboard-check mr-2"></i>
                                June 1, 2021
                            </span>
                        </td>
                        <td class="align-middle" nowrap="">
                            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                                <i class="la la-clipboard-check mr-2"></i>
                                December 1, 2021
                            </span>
                        </td>
                        <td class="align-middle" nowrap="">
                            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                                <i class="la la-clipboard-check mr-2"></i>
                                Passed
                            </span>
                        </td>
                    </tr>
            </tbody>
        </table>



        </div>
      </div>






    </div><!-- <div class="col-md-12"> -->
  </div>

  <script>
    $('#establishmentsTable').DataTable( {
        responsive: {
            details: true
        }
    } );
  </script>