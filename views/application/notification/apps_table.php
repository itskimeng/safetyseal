<div class="row">
  <div class="col-lg-12 col-md-6 col-sm-3">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-file"></i> Application List</h3>
      
     
      </div>

      <div class="card-body">
        <table id="list_table" class="table table-bordered table-striped" style="font-size:10pt;">
          <thead>
            <tr>
              <th style="text-align: center; width:10%;">TYPE</th>
              <th style="text-align: center;">CONTROL NO.</th>
              <th style="text-align: center;">NAME</th>
              <th style="text-align: center; width:15%">AGENCY NAME</th>
              <th style="text-align: center; width:15%">LOCATION</th>
              <th style="text-align: center; width:10%">DATE REGISTERED</th>
              <th style="text-align: center;">SAFETY SEAL NO.</th>
              <th style="text-align: center; width:15%">ACTION</th>
            </tr>
          </thead>
          <tbody id="list_body">
            <?php foreach ($client_details as $key => $applicant): ?>
              <tr>
                <td>
                  <?php echo $applicant['app_type']; ?>
                </td>
                <td>
                  <span class="label label-sm bg-<?php echo $applicant['color']; ?> label-inline font-weight-bold py-3">
                    <i class="fa fa-check-circle"></i><?php echo $applicant['status']; ?>
                  </span>
                  <br>
                  <?php echo $applicant['control_no']; ?>    
                </td>
                <td><?php echo $applicant['fname']; ?></td>
                <td><?php echo $applicant['agency']; ?></td>
                <td><?php echo $applicant['ac_address']; ?></td>
                <td><?php echo $applicant['date_created']; ?></td>
                <td><?php echo $applicant['ss_no']; ?></td>
                <td>
                  <div class="col-md-12">
                  <input type = "hidden" id="client" data-value =<?php echo $applicant['sms_sending_status'];?> />
                  <input type = "hidden" id="cmlgoo" value =<?php echo $applicant['email_sending_status'];?> />
                  <input type = "hidden" id="pnp" value =<?php echo $applicant['pnp_sending_status'];?> />
                  <input type = "hidden" id="bfp" value =<?php echo $applicant['bfp_sending_status'];?> />
                  
                      <button id="send" class="btn btn-primary btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-envelope-square"></i> Send
                      </button>
                  </div>
                </td>
              </tr>
            <?php endforeach ?>
            
          </tbody>   
        </table>
      </div>
    </div>
  </div>
</div>  