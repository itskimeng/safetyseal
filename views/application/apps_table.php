<div class="row">
  <div class="col-lg-12 col-md-6 col-sm-3">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-file"></i> Application List</h3>
      
        <div class="card-tools">
          <a href="admin_application_add.php?appid=new" class="btn btn-block btn-info btn-sm"><i class="fa fa-plus-square"></i> Add New</a>
        </div>
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
              <th style="text-align: center; width:10%">VALIDITY DATE</th>
              <th style="text-align: center;">SAFETY SEAL NO.</th>
              <th style="text-align: center; width:15%">ACTION</th>
            </tr>
          </thead>
          <tbody id="list_body">
            <?php foreach ($applicants as $key => $applicant): ?>
              <tr>
                <td>
                  <input type="hidden" name="ac_id" id="cform-ac_id" value="<?php echo $applicant['id']; ?>">
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
                <td><?php echo $applicant['validity_date']; ?></td>
                <td><?php echo $applicant['ss_no']; ?></td>
                <td>
                  <div class="col-md-12">
                    <?php if ($applicant['app_type'] == 'Encoded'): ?>
                      <a href="admin_application_edit.php?appid=<?php echo $applicant['token']; ?>&code=&scope=" class="btn btn-info btn-block btn-sm" style="margin-bottom: -2%;" title="View Checklist">
                        <i class="fa fa-clipboard-list"></i> View
                      </a>

                      <?php if (in_array($applicant['status'], ['Draft'])): ?>
                        <a href="entity/delete_admin_application.php?token=<?php echo $applicant['token']; ?>" class="btn btn-danger btn-block btn-sm" style="margin-bottom: -2%;" title="Remove Application">
                          <i class="fa fa-trash"></i> Remove
                        </a>
                      <?php endif ?>


                    <?php elseif (in_array($applicant['status'], ['For Receiving', 'For Reassessment'])): ?>
                      <!-- <a href="entity/post_received.php?appid=<?php echo $applicant['id']; ?>&ussir=<?php echo $applicant['userid']; ?>&status=<?php echo $applicant['status']; ?>" class="btn btn-primary btn-block btn-sm" style="margin-bottom: -2%;">
                        <i class="fa fa-box"></i> Receive
                      </a> -->

                      <a href="admin_application_open.php?appid=<?php echo $applicant['id']; ?>&ussir=<?php echo $applicant['userid']; ?>" class="btn btn-info btn-block btn-sm" style="margin-bottom: -2%;" title="View Checklist">
                        <i class="fa fa-folder-open"></i> View
                      </a>

                    <?php else: ?>
                      <a href="admin_application_view.php?appid=<?php echo $applicant['id']; ?>&ussir=<?php echo $applicant['userid']; ?>" class="btn btn-info btn-block btn-sm" style="margin-bottom: -2%;" title="View Checklist">
                        <i class="fa fa-clipboard-list"></i> View
                      </a>
                    <?php endif ?>

                    <?php if (in_array($applicant['status'], ['Approved'])): ?>
                      <a href="certificate.php?token=<?php echo $applicant['token']; ?>" class="btn btn-warning btn-block btn-sm" style="margin-bottom: -2%;" title="Generate Certificate">
                        <i class="fa fa-print"></i> Generate
                      </a>
                    <?php endif ?>
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