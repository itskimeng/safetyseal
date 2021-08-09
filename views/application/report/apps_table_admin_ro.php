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
              <th width="15%" class="header_pink" style="vertical-align: middle;">Name of Province</th>
              <th class="header_pink" style="vertical-align: middle;">Total No. of Applications Received</th>
              <th class="header_yellow" style="vertical-align: middle;">Total No. of Establishments Issued with Safety Seal Certification </th>
              <th class="header_yellow" style="vertical-align: middle;">Total No. of Returned Establishments</th>
              <!-- <th class="header_yellow" colspan="2" style="vertical-align: middle;">MODE OF ACQUISITION</th> -->
              <!-- <th class="header_yellow" rowspan="2" style="vertical-align: middle;">Total No. of SSC Posted in Official Website</th> -->
              <!-- <th class="header_pink" rowspan="2" style="vertical-align: middle;">Total No. of Complaints Received</th> -->
            </tr>
            <!-- <tr>
              <th width="13%" class="header_yellow" style="vertical-align: middle;">TOTAL NO. OF ESTABLISHMENTS CERTIFIED BY APPLICATION <br><small><i>(The Establishment applied thru the website or secured the Checklist from the Office of the Issuing Authority)</i></small></th>
              <th width="13%" class="header_yellow" style="vertical-align: middle;">TOTAL NO. OF ESTABLISHMENTS CERTIFIED BY VISIT FROM REGULAR MONITORING <br><small><i>( During the conduct of a regular monitoring, the Inspection Team has determined that the establishment is eligible for a Safety Seal)</i></small></th>
            </tr> -->
            <!-- <tr> -->
              <!-- <td class="header_pink"></td>
              <td class="header_pink"><b><i>a</i></b></td>
              <td class="header_yellow"><b><i>g</i></b></td>
              <td class="header_yellow"><b><i>i</i></b></td> -->
              <!-- <td class="header_yellow" colspan="2"><b><i>j</i></b></td>
              <td class="header_yellow"><b><i>k</i></b></td>
              <td class="header_pink"><b><i>l</i></b></td> -->
            <!-- </tr> -->

          </thead>
          <tbody id="list_body">
              <tr style="background-color: #8ae38a;">
                <td style="text-align: center; vertical-align: middle;"><b>TOTAL</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['total_application']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['total_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['total_disapproved']; ?></b></td>
                <!-- <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['total_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['total_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td> -->
              </tr>
              <tr>
                <td style="text-align: center; vertical-align: middle;"><b>BATANGAS</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['batangas_application']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['batangas_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['batangas_disapproved']; ?></b></td>
                <!-- <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['batangas_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['batangas_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td> -->
              </tr>
              <tr>
                <td style="text-align: center; vertical-align: middle;"><b>CAVITE</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['cavite_application']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['cavite_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['cavite_disapproved']; ?></b></td>
                <!-- <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['cavite_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['cavite_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td> -->
              </tr>
              <tr>
                <td style="text-align: center; vertical-align: middle;"><b>LAGUNA</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['laguna_application']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['laguna_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['laguna_disapproved']; ?></b></td>
                <!-- <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['laguna_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['laguna_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td> -->
              </tr>
              <tr>
                <td style="text-align: center; vertical-align: middle;"><b>RIZAL</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['rizal_application']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['rizal_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['rizal_disapproved']; ?></b></td>
                <!-- <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['rizal_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['rizal_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td> -->
              </tr>
              <tr>
                <td style="text-align: center; vertical-align: middle;"><b>QUEZON (including Lucena HUC)</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['huc_application']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['huc_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php echo $reports['huc_disapproved']; ?></b></td>
                <!-- <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['huc_approved']; ?></b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>
                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><?php //echo $reports['huc_approved']; ?></b></td>
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