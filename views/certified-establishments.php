<?php require_once 'application/config/connection.php'; ?>



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
              <?php 
              $selectApplication = ' SELECT `id`, `control_no`, `user_id`, `status`, `has_consent`, `date_created`, `date_proceed`, `receiver_id`, `date_received`, `approver_id`, `date_approved`, `safety_seal_no`, `date_modified` FROM `tbl_app_checklist` WHERE status = "Approved" ';
              $execSelectApplication = $conn->query($selectApplication);
              while ($resultApplication = $execSelectApplication->fetch_assoc()) 
              {
                $selectApplicantDetails = ' SELECT `ID`, `REGION`, `PROVINCE`, `LGU`, `OFFICE`, `CMLGOO_NAME`, `UNAME`, `PASSWORD`, `VERIFICATION_CODE`, `IS_APPROVED`, `IS_VERIFIED`, `ROLES`, `EMAIL` FROM `tbl_admin_info` WHERE `ID` = "'.$resultApplication['user_id'].'" ';
                $execApplicantDetails = $conn->query($selectApplicantDetails);
                $resultApplicantDetails = $execApplicantDetails->fetch_assoc();



                $selectAddress = ' SELECT `ID`, `USER_ID`, `ADDRESS`, `POSITION`, `MOBILE_NO`, `EMAIL_ADDRESS`, `GOV_AGENCY_NAME`, `GOV_ESTB_NAME`, `DATE_REGISTERED`, `PROVINCE`, `CITY_MUNICIPALITY`, `GOV_NATURE_NAME` FROM `tbl_userinfo` WHERE `USER_ID` = "'.$resultApplication['user_id'].'" ';
                $execAddress = $conn->query($selectAddress);
                $resultAddress = $execAddress->fetch_assoc();
               ?>
                <tr class="clickable-row" data-href="establishment-profile.php?unique_id=<?php echo $resultApplication['user_id']; ?>">
                        <td class="align-middle">
                            <a href="establishment-profile.php?unique_id=<?php echo $resultApplication['user_id']; ?>" target="_blank" class="">
                                <div class="font-weight-bold">
                                   <?php echo $resultAddress['GOV_AGENCY_NAME']; ?>
                                </div>
                            </a>
                        </td>
                        <td class="align-middle">
                            <a href="establishment-profile.php?unique_id=<?php echo $resultApplication['user_id']; ?>" class="">
                                <div class="font-weight-bold">
                                   <?php echo $resultAddress['GOV_ESTB_NAME']; ?>
                                </div>
                            </a>
                        </td>
                        <td class="align-middle">
                             <?php echo $resultAddress['ADDRESS']; ?>
                        </td>
                        <td class="align-middle" nowrap="">
                             <?php echo $resultApplication['control_no']; ?>
                        </td>
                        <td class="align-middle" nowrap="">
                            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                                <i class="la la-clipboard-check mr-2"></i>
                             <?php echo date('F d, Y',strtotime($resultApplication['date_approved'])); ?>
                            </span>
                        </td>
                        <td class="align-middle" nowrap="">
                            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                                <i class="la la-clipboard-check mr-2"></i>
                             <?php echo date('F d, Y', strtotime("+6 months", strtotime($resultApplication['date_approved']))); ?>
                            </span>
                        </td>
                        <td class="align-middle" nowrap="">
                            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                                <i class="la la-clipboard-check mr-2"></i>
                             <?php echo $resultApplication['status']; ?>
                            </span>
                        </td>
                    </tr>


              <?php } ?>


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