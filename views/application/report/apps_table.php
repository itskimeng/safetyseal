<div class="row">
  <div class="col-lg-12 col-md-6 col-sm-3">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-file"></i> Application List</h3>
      
        <div class="card-tools">
        <!-- <span class="btn btn-success btn-md pull-right" id="report" ><i class="fa fa-file-excel"></i> Generate </span> -->
        <!-- Example single danger button -->


          <!-- <a href="admin_application_add.php?appid=new" class="btn btn-block btn-info btn-sm"><i class="fa fa-plus-square"></i> Add New</a> -->
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
              <th style="text-align: center;">SAFETY SEAL NO.</th>
            </tr>
          </thead>
          <tbody id="list_body">
            <?php foreach ($applicants as $key => $applicant): ?>
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
                <!-- <td>
                  <div class="col-md-12">
                    <?php if ($applicant['app_type'] == 'Encoded'): ?>
                      <a href="admin_application_edit.php?appid=<?php echo $applicant['token']; ?>&code=&scope=" class="btn btn-info btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-clipboard-list"></i> View
                      </a>
                    <?php elseif (in_array($applicant['status'], ['For Receiving', 'For Reassessment'])): ?>
                      <a href="entity/post_received.php?appid=<?php echo $applicant['id']; ?>&ussir=<?php echo $applicant['userid']; ?>&status=<?php echo $applicant['status']; ?>" class="btn btn-primary btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-box"></i> Receive
                      </a>
                    <?php else: ?>
                      <a href="admin_application_view.php?appid=<?php echo $applicant['id']; ?>&ussir=<?php echo $applicant['userid']; ?>" class="btn btn-success btn-block btn-sm" style="margin-bottom: -5%;">
                        <i class="fa fa-eye"></i> View
                      </a>
                    <?php endif ?>
                  </div>
                </td> -->
              </tr>
              
            <?php endforeach ?>
            
          </tbody>   
        </table>

      </div>
    </div>
  </div>
</div>  