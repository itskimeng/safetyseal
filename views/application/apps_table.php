<div class="row">
  <div class="col-lg-12 col-md-6 col-sm-3">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-file"></i> Application List</h3>
      </div>

      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th style="text-align: center;">Name</th>
              <th style="text-align: center; width:20%">Agency Name</th>
              <th style="text-align: center; width:20%">Location</th>
              <th style="text-align: center; width:20%">Date Registered</th>
              <th style="text-align: center; width:15%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($applicants as $key => $applicant): ?>
              <tr>
                <td><?php echo $applicant['fname']; ?></td>
                <td><?php echo $applicant['agency']; ?></td>
                <td><?php echo $applicant['address']; ?></td>
                <td><?php echo $applicant['date_created']; ?></td>
                <td>
                  <div class="col-md-12">
                    <?php if ($applicant['status'] == 'For Receiving'): ?>

                      <a href="admin_application_view.php?appid=<?php echo $applicant['id']; ?>&ussir=<?php echo $applicant['userid']; ?>&status=<?php echo $applicant['status']; ?>" class="btn btn-primary btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-box"></i> Received
                      </a>


                     <!--  <button type="button" class="btn btn-info btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-box"></i> Received
                      </button> -->
                    <?php else: ?>
                      <a href="admin_application_view.php?appid=<?php echo $applicant['id']; ?>&ussir=<?php echo $applicant['userid']; ?>" class="btn btn-danger btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-clipboard-list"></i> View Applicant
                      </a>
                      <!-- <a href="admin_application_view.php?appid=<?php //echo $applicant['id']; ?>&ussir=<?php //echo $applicant['userid']; ?>" class="btn btn-danger btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-th-list"></i> View Applicant
                      </a> -->
                      <!-- <button type="button" class="btn btn-success btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-bell"></i> Rate
                      </button>
                      <button type="button" class="btn btn-warning btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-bell"></i> Ratings
                      </button>
                      <button type="button" class="btn btn-secondary btn-block btn-sm">
                        <i class="fa fa-bell"></i> History
                      </button> -->
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