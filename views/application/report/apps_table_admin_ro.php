<div class="row">
  <div class="col-lg-12 col-md-6 col-sm-3">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-file"></i> Summary of DILG Inspection and Certification Team Accomplishment Report</h3>
      </div>

      <div class="card-body">
        <table class="table table-bordered" style="font-size:10pt;">
          <thead>
            <tr>
              <th rowspan="2" width="15%" class="header_pink" style="vertical-align: middle;">Name of Province</th>
              <th rowspan="2" class="header_pink" style="vertical-align: middle;">Total No. of Applications Received</th>
              <th rowspan="2" class="header_yellow" style="vertical-align: middle;">Total No. of Establishments Issued with Safety Seal Certification </th>
              <th rowspan="2" class="header_yellow" style="vertical-align: middle;">Total No. of Establishments with Renewed Safety Seal</th>
              <th colspan="2" class="header_yellow" style="vertical-align: middle;">Pending Applications</th>
            </tr>
            <tr>
              <th width="13%" class="header_yellow" style="vertical-align: middle;">For Assessment</th>
              <th width="13%" class="header_yellow" style="vertical-align: middle;">Returned</th>
            </tr>

          </thead>
          <tbody id="list_body">
              <tr style="background-color: #8ae38a;">
                <td style="text-align: center; vertical-align: middle;"><b>TOTAL</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['total_application']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['total_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['total_renewed']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['total_received']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['total_disapproved']; ?></b></td>
              </tr>
              <tr>
                <td style="text-align: center; vertical-align: middle;"><b>BATANGAS</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['batangas_application']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['batangas_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['batangas_renewed']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['batangas_received']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['batangas_disapproved']; ?></b></td>
              </tr>
              <tr>
                <td style="text-align: center; vertical-align: middle;"><b>CAVITE</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['cavite_application']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['cavite_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['cavite_renewed']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['cavite_received']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['cavite_disapproved']; ?></b></td>
                <!-- <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td> -->
                <!-- <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['cavite_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td> -->
              </tr>
              <tr>
                <td style="text-align: center; vertical-align: middle;"><b>LAGUNA</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['laguna_application']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['laguna_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['laguna_renewed']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['laguna_received']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['laguna_disapproved']; ?></b></td>
                <!-- <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td> -->
                <!-- <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['laguna_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td> -->
              </tr>
              <tr>
                <td style="text-align: center; vertical-align: middle;"><b>RIZAL</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['rizal_application']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['rizal_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['rizal_renewed']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['rizal_received']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['rizal_disapproved']; ?></b></td>
                <!-- <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td> -->
                <!-- <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['rizal_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td> -->
              </tr>
              <tr>
                <td style="text-align: center; vertical-align: middle;"><b>QUEZON (including Lucena HUC)</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['huc_application']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['huc_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['huc_renewed']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['huc_received']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?= $reports['huc_disapproved']; ?></b></td>
                <!-- <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td> -->
                <!-- <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['huc_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td> -->
              </tr>
            
          </tbody>   
        </table>
      </div>
    </div>
  </div>
</div>  

<style type="text/css">
  .header_pink {
    background-color: pink;
    text-align: center;
  }

  .header_yellow {
    background-color: #f2d28b;
    text-align: center; 
  }
</style>