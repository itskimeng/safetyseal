<?php require_once 'application/config/connection.php'; ?>



<img src="frontend/images/banner_calabarzon.png" height="10%" width="100%" alt="">
 <hr>
 <div class="row">
        <div class="col-lg-12 ">       
          <img src="frontend/images/carousel/3.png" style="width: 100%;" alt=""> 
        </div>
      </div>
  <div class="row mt-5 mb-5">
      
    <div class="col-md-12">
    

      <div class="card">
        <div class="card-header">
          Home / Certified Establishments
        </div>
        <div class="card-body" style="background-color: #f9f8f8;">

        <table class="table table-hover mb-0 border-bottom" id="establishmentsTable">
            <thead>
                <tr>
                    <th hidden style="text-align: center;">ID</th>
                    <th width="25%">AGENCY</th>
                    <th width="25%">ESTABLISHMENT</th>
                    <th width="40%">ADDRESS</th>
                    <th width="15%">SAFETY SEAL NO</th>
                    <th width="10%">ISSUED ON</th>
                    <th width="10%">VALID UNTIL</th>
                    <!-- <th width="10%">STATUS</th> -->
                </tr>
            </thead>
            <tbody>
              <?php 
              
        $sql = "SELECT ac.id, p.id as province_id, p.name as province, cm.code as lgu, ac.user_id, ac.agency as GOV_AGENCY_NAME, ac.establishment as GOV_ESTB_NAME, ac.address as ADDRESS, ac.safety_seal_no, ac.date_approved, ac.status FROM `tbl_app_checklist` ac 
            LEFT JOIN tbl_admin_info ai on ai.ID = ac.user_id
LEFT JOIN tbl_province p on p.id = ai.PROVINCE
LEFT JOIN tbl_citymun cm on cm.province = ai.PROVINCE AND cm.code = ai.LGU 
WHERE ac.status IN ('Approved', 'Renewed') ORDER BY p.id, cm.id, ai.id";




        $result1 = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result1)) {


              if ($row['GOV_AGENCY_NAME'] == '') 
              {
                $selectApplicantDetails = ' SELECT `OFFICE` FROM `tbl_admin_info` WHERE `ID` = "'.$row['user_id'].'" ';
                $execApplicantDetails = $conn->query($selectApplicantDetails);
                $resultApplicantDetails = $execApplicantDetails->fetch_assoc();
                $agency = $resultApplicantDetails['OFFICE'];
              }
              else
              {
                $agency = $row['GOV_AGENCY_NAME'];
              }
               ?>
                <tr class="clickable-row" data-href="establishment-profile.php?unique_id=<?php echo $row['id']; ?>">
                        <td hidden><?php echo $row['province_id']; ?></td>
                        <td class="align-middle">
                            <a href="establishment-profile.php?unique_id=<?php echo $row['id']; ?>" target="_blank" class="">
                                <div class="font-weight-bold">
                                   <?php echo $agency; ?>
                                </div>
                            </a>
                        </td>
                        <td class="align-middle">
                            <a href="establishment-profile.php?unique_id=<?php echo $row['id']; ?>" class="">
                                <div class="font-weight-bold">
                                   <?php echo $row['GOV_ESTB_NAME']; ?>
                                </div>
                            </a>
                        </td>
                        <td class="align-middle">
                             <?php echo $row['ADDRESS']; ?>
                        </td>
                        <td class="align-middle" nowrap="">
                             <?php echo $row['safety_seal_no']; ?>
                        </td>
                        <td class="align-middle" nowrap="">
                            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                                <i class="la la-clipboard-check mr-2"></i>
                             <?php echo date('F d, Y',strtotime($row['date_approved'])); ?>
                            </span>
                        </td>
                        <td class="align-middle" nowrap="">
                            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                                <i class="la la-clipboard-check mr-2"></i>
                             <?php echo date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))); ?>
                            </span>
                        </td>
                        <!-- <td class="align-middle" nowrap="">
                            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                                <i class="la la-clipboard-check mr-2"></i>
                             <?php //if ($row['status'] == 'Approved') { echo '<span class="text-success">CERTIFIED<span>';} else {echo '<span class="text-danger">'.$row['status'].'<span>'; } ?>
                            </span>
                        </td> -->
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
        //"responsive": true,
        //"autoWidth": false,
        //"lengthMenu": [[20, 50, -1], [20, 50, "All"]],
        //"columnDefs": [
        //    {
        //        "targets": [ 0 ],
        //        "visible": false
        //    }
        //]
      } );
  </script>