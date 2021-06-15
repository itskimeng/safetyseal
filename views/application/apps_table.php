<div class="row">
  <div class="col-lg-12 col-md-6 col-sm-3">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-file"></i> Application List</h3>
      </div>

      <div class="card-body">
        <table id="list_table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th style="text-align: center;">Control No.</th>
              <th style="text-align: center;">Name</th>
              <th style="text-align: center; width:15%">Agency Name</th>
              <th style="text-align: center; width:15%">Location</th>
              <th style="text-align: center; width:10%">Date Registered</th>
              <th style="text-align: center;">Safety Seal No.</th>
              <th style="text-align: center; width:15%">Action</th>
            </tr>
          </thead>
          <tbody id="list_body">
            <?php foreach ($applicants as $key => $applicant): ?>
              <tr>
                <td>
                  <span class="label label-lg bg-<?php echo $applicant['color']; ?> label-inline font-weight-bold py-3">
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
                    <?php if (in_array($applicant['status'], ['For Receiving', 'For Reassessment'])): ?>

                      <a href="entity/post_received.php?appid=<?php echo $applicant['id']; ?>&ussir=<?php echo $applicant['userid']; ?>&status=<?php echo $applicant['status']; ?>" class="btn btn-primary btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-box"></i> Receive
                      </a>

                      <!-- <a href="admin_application_view.php?appid=<?php //echo $applicant['id']; ?>&ussir=<?php //echo $applicant['userid']; ?>&status=<?php //echo $applicant['status']; ?>" class="btn btn-primary btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-box"></i> Receive
                      </a> -->
                    <?php else: ?>
                      <a href="admin_application_view.php?appid=<?php echo $applicant['id']; ?>&ussir=<?php echo $applicant['userid']; ?>" class="btn btn-info btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-clipboard-list"></i> View Applicant
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