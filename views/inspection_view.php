<?php require_once 'application/config/connection.php'; ?>
<img src="frontend/images/banner_calabarzon.png" height="10%" width="100%" alt="">
 <hr>
  <div class="row mt-5 mb-5">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
          Home / Inspection and Certification Teams
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
          </div>
          -->


        <table class="table table-hover mb-0 border-bottom" id="complaintsTable">
            <thead>
                <tr>
                    <th width="10%">PROVINCE</th>
                    <th width="10%">CITY / MUNICIPALITY</th>
                    <th width="10%">NAME OF DILG OFFICER</th>
                    <th width="10%">PHILIPPINE NATIONAL POLICE</th>
                    <th width="10%">BUREAU OF FIRE PROTECTION</th>
                  

                   
                </tr>
            </thead>
            <tbody>

              <?php 
              $sqlSelectData = ' SELECT `ID`, `PROVINCE`, `LGU`, `NAME`, `EMAIL_ADDRESS`, `CONTACT_NO`, `PNP`, `BFP`, `ICT_HOTLINE`, `EMAIL_ADDRESS_COMPLAINTS` FROM `tbl_inspection_team` ORDER BY `PROVINCE` ASC ';
              $executeSelectData = $conn->query($sqlSelectData);
              while ($resultData = $executeSelectData->fetch_assoc()) 
              {
               ?>



                
                <tr>
                    <td class="align-middle">
                      <div class="font-weight-bold">
                        <?php echo $resultData['PROVINCE']; ?>
                      </div>
                    </td>
                    <td class="align-middle">
                        <?php echo $resultData['LGU']; ?>
                    </td>
                    <td class="align-middle" nowrap="">
                        <?php echo $resultData['NAME']; ?>      
                    </td>
                    <td class="align-middle" nowrap="">
                        <?php echo $resultData['PNP']; ?>  
                    </td>
                    <td class="align-middle" nowrap="">
                        <?php echo $resultData['BFP']; ?>  
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
    $('#complaintsTable').DataTable( {
        responsive: {
            details: true
        }
    } );
  </script>