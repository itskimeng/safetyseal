<div class="row">
  <div class="col-lg-12 col-md-6 col-sm-3">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-file"></i> Application List</h3>
      
        <div class="card-tools">
          <?php if (!in_array($_SESSION['position'], ['BFP', 'PNP'])): ?>
            <a href="admin_application_add.php?appid=new" class="btn btn-block btn-info btn-sm"><i class="fa fa-plus-square"></i> Add New</a>
          <?php endif ?>
        </div>
      </div>

      <div class="card-body">
        <table id="list_table" class="table table-bordered table-striped" style="font-size:10pt;">
          <thead>
            <tr>
              <th>TYPE</th>
              <th style="text-align: center; width:14%">CONTROL NO.</th>
              <th style="text-align: center; width:18%">AGENCY NAME &<br> Person in-Charge</th>
              <th style="text-align: center; width:20%">LOCATION</th>
              <th style="text-align: center; width:13%">DATE CREATED</th>
              <th style="text-align: center;">SAFETYSEAL NO.</th>
              <th style="text-align: center; width:12%">ACTION</th>
            </tr>
          </thead>
          <tbody id="list_body">
   
            <?php foreach ($application_info as $key => $applicant): ?>
              <tr>
                <td>
                  <?= $applicant['app_type']; ?>
                </td>
                <td>
                  <input type="hidden" name="ac_id" id="cform-ac_id" value="<?= $applicant['id']; ?>">
                  <span class="label label-sm bg-<?= $applicant['color']; ?> label-inline font-weight-bold py-3"><i class="fa fa-check-circle"></i>&nbsp;<?= $applicant['status']; ?>
                  </span>
                  <br>
                  <?= $applicant['control_no']; ?>    
                </td>
                <td>
                  <b class="mb-4"><?= $applicant['agency']; ?></b><br><br>
                  <i>--<?= $applicant['fname']; ?>--</i>
                </td>
                <td><?= $applicant['ac_address']; ?></td>
                <td class="text-center">
                  <?= $applicant['date_created']; ?>
                </td>
                <td class="text-center">
                  <?php if ($applicant['for_renewal']): ?>
                    <table class="table table-bordered dataTable dtr-inline">
                      <tbody>
                        <tr>
                          <td><strong>Issued</strong></td>
                          <td>---</td>
                        </tr>
                        <tr>
                          <td><strong>Valid Until</strong></td>
                          <td>---</td>
                        </tr>
                      </tbody>
                    </table>
                  <?php elseif (!empty($applicant['ss_no'])): ?>
                    <span class="label label-sm bg-<?= $applicant['color']; ?> label-inline font-weight-bold py-3"><i class="fa fa-certificate"></i>&nbsp;<?= $applicant['ss_no']; ?></span>

                    <table class="table table-bordered dataTable dtr-inline">
                      <tbody>
                        <tr>
                          <td><strong>Issued</strong></td>
                          <td><?= $applicant['issued_date']; ?></td>
                        </tr>
                        <tr>
                          <td><strong>Valid Until</strong></td>
                          <td><?= $applicant['validity_date']; ?></td>
                        </tr>
                      </tbody>
                    </table>


                  <?php else: ?>
                    ---
                  <?php endif ?>
                </td>
                <td class="text-center">
                  <div class="col-md-12">

                    <div class="btn-group">
                      <?php if ($applicant['app_type'] == 'Encoded'): ?>
                          <a href="admin_view_application.php?form=<?= $applicant['checklist_form'];?>&person=<?= $applicant['fname']; ?>&type=Encoded&_view" class="btn btn-info btn-sm" title="View Checklist"><i class="fa fa-folder-open"></i></a>
                      <?php elseif (in_array($applicant['status'], ['For Receiving', 'For Reassessment'])): ?>
                        <a href="admin_view_application.php?form=<?= $applicant['checklist_form'];?>&userid=<?= $applicant['userid']; ?>&type=Applied&_view" class="btn btn-info btn-sm" title="View Checklist"><i class="fa fa-folder-open"></i></a>
                      <?php else: ?>
                          <a href="admin_view_application.php?form=<?= $applicant['checklist_form'];?>&userid=<?= $applicant['userid']; ?>&type=Applied&_view" class="btn btn-info btn-sm" title="View Checklist"><i class="fa fa-folder-open"></i></a>
                      <?php endif ?>
                    </div>

                    <?php if (in_array($applicant['status'], ['Approved', 'Renewed', 'Expired'])): ?>
                      <div class="btn-group">
                        <a href="certificate.php?token=<?= $applicant['token']; ?>&status=<?= $applicant['status']; ?>&_view" class="btn btn-warning btn-sm" style="margin-bottom: -2%;" target="_blank" title="Generate Certificate"><i class="fa fa-print"></i></a>
                      </div>
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