<?php require_once 'controller/AdminApplicationController.php'; ?>

<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0"> Application List <small><b><?php echo $hlbl; ?></b></small>
        </h5>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
          <li class="breadcrumb-item active">Application List</li>
        </ol>
      </div>
    </div>
    <hr>
  </div>
</div>

<!-- Main content -->
<div class="content">
  <div class="container">
    <?php include 'filter.php'; ?>
    <?php
    if (isset($_GET['status'])) {
      include 'appinfo_table.php';
    } else {
      include 'apps_table.php';
    }
    ?>
  </div>
  <!-- modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 80%!important;">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-file"></i>Application List: (<strong>Draft</strong>)</h5><br>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table id="draftlist_table" class="table table-bordered table-striped" style="font-size:10pt;">
            <thead>
              <tr>
                <th>TYPE</th>
                <th style="text-align: center; width:14%">CONTROL NO.</th>
                <th style="text-align: center; width:18%">AGENCY NAME &amp;<br> Person in-Charge</th>
                <th style="text-align: center; width:20%">LOCATION</th>
                <th style="text-align: center; width:13%">DATE CREATED</th>
                <th style="text-align: center;">SAFETYSEAL NO.</th>
                <th style="text-align: center; width:12%">ACTION</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($application_draftlist as $key => $applicant) : ?>
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
                    <?php if ($applicant['for_renewal']) : ?>
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
                    <?php elseif (!empty($applicant['ss_no'])) : ?>
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


                    <?php else : ?>
                      ---
                    <?php endif ?>
                  </td>
                  <td class="text-center">
                    <div class="col-md-12">

                      <div class="btn-group">
                        <?php if ($applicant['app_type'] == 'Encoded') : ?>
                          <a href="admin_view_application.php?form=<?= $applicant['checklist_form']; ?>&person=<?= $applicant['fname']; ?>&type=Encoded&_view" class="btn btn-info btn-sm" title="View Checklist"><i class="fa fa-folder-open"></i></a>
                        <?php elseif (in_array($applicant['status'], ['For Receiving', 'For Reassessment'])) : ?>
                          <a href="admin_view_application.php?form=<?= $applicant['checklist_form']; ?>&userid=<?= $applicant['userid']; ?>&type=Applied&_view" class="btn btn-info btn-sm" title="View Checklist"><i class="fa fa-folder-open"></i></a>
                        <?php else : ?>
                          <a href="admin_view_application.php?form=<?= $applicant['checklist_form']; ?>&userid=<?= $applicant['userid']; ?>&type=Applied&_view" class="btn btn-info btn-sm" title="View Checklist"><i class="fa fa-folder-open"></i></a>
                        <?php endif ?>
                      </div>

                      <?php if (in_array($applicant['status'], ['Approved', 'Renewed', 'Expired'])) : ?>
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    $('#reservation').daterangepicker()

    $("#list_table").DataTable({}).buttons().container().appendTo('#list_table_wrapper .col-md-6:eq(0)');
    $("#draftlist_table").DataTable({pageLength: 5}).buttons().container().appendTo('#list_table_wrapper .col-md-6:eq(0)');
    
    <?php
    if (isset($_SESSION['toastr'])) {
      echo 'tata.' . $_SESSION['toastr']['type'] . '("' . $_SESSION['toastr']['title'] . '", "' . $_SESSION['toastr']['message'] . '", {
          duration: 5000
        })';
      unset($_SESSION['toastr']);
    }
    ?>

    $(document).on('click', '#btn-reset', function() {
      location.reload();
    });
    $(document).on('change','#province',function(){
      $('#sel_province').val($(this).val());
    })
    $(document).on('change','#cform-citymun',function(){
      $('#sel_municipality').val($(this).val());
    })
    $(document).on('click', '#btn-filter', function() {
      let path = 'entity/filter_applicants.php';
      let pro = '';
      let def_pro = $('#province').val();
      let sel_pro = $('#sel_province').val();
      if(def_pro == '')
      {
        pro = sel_pro;
      }else{
        pro = def_pro;
      }


      let data = {
        citymun: $('#sel_municipality').val(),
        name: $('#cform-name').val(),
        agency: $('#cform-agency').val(),
        location: $('#cform-location').val(),
        status: $('#cform-status').val(),
        daterange: $('#reservation').val(),
        app_type: $('#cform-app_type').val(),
        province: pro,
      };

      $.get(path, data, function(data, status) {
        $('#list_body').empty();
        let lists = JSON.parse(data);
        $('#list_table').dataTable().fnClearTable();
        $('#list_table').dataTable().fnDestroy();
        generateMainTable(lists);
        $("#list_table").DataTable({
          // "responsive": true, "lengthChange": false, "autoWidth": false,
          // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#list_table_wrapper .col-md-6:eq(0)');
      });
    });

    function generateMainTable($data) {
      $.each($data, function(key, item) {

        let tr = '<tr>';
        tr += '<td style = "font-weight:bold;">' + item['app_type'] + '</td>';
        tr += '<td>';
        tr += '<span class="label label-sm bg-' + item['color'] + ' label-inline font-weight-bold py-3">';
        tr += '<i class="fa fa-check-circle"></i>' + item['status'];
        tr += '</span>';
        tr += '<br>';
        tr += item['control_no'];
        tr += '</td>';
        tr += '<td>' + item['fname'] + '</td>';
        tr += '<td>' + item['address'] + '</td>';
        tr += '<td>' + item['date_created'] + '</td>';
        tr += '<td>';
        tr += '<span class="label label-sm bg-' + item['color'] + ' label-inline font-weight-bold py-3"><i class="fa fa-certificate"></i>&nbsp;' + item['ss_no'] + '</span>';
        tr += '<table class="table table-bordered dataTable dtr-inline">';
        tr += '<tbody>';
        tr += '<tr>';
        tr += '<td><strong>Issued</strong></td>';
        tr += '<td>' + item['date_created'] + '</td>';
        tr += '</tr>';
        tr += '<tr>';
        tr += '<td><strong>Valid Until</strong></td>';
        tr += '<td>' + item['validity_date'] + '</td>';
        tr += '</tr>';
        tr += '</tbody>';
        tr += '</table>';


        tr += '</td>';
        tr += '<td>';

        if (item['app_type'] == 'Encoded') {
          tr += '<a href="admin_application_edit.php?appid=' + item['token'] + '&code=&scope=" class="btn btn-info btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-clipboard-list"></i> View</a>';

          if (item['status'] == 'Draft') {
            tr += '<a href="entity/delete_admin_application.php?appid=' + item['token'] + '" class="btn btn-danger btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-trash"></i> Remove</a>';
          }

        } else if (item['status'] == 'For Receiving') {
          tr += '<a href="entity/post_received.php?appid=' + item['id'] + '&ussir=' + item['userid'] + '&status=' + item['status'] + '" class="btn btn-primary btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-box"></i> Receive</a>';

          tr += '<a href="admin_application_open.php?appid=' + item['id'] + '&ussir=' + item['userid'] + '" class="btn btn-primary btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-box"></i> Receive</a>';
        } else {
          tr += '<a href="admin_application_view.php?form=' + item['form'] + '&appid=' + item['id'] + '&ussir=' + item['userid'] + '" class="btn btn-info btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-clipboard-list"></i> View</a>';
        }

        if (item['status'] == 'Approved') {
          tr += '<a href="certificate.php?token=' + item['token'] + '" class="btn btn-warning btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-print"></i> Generate Certificate</a>';
        }
        tr += '</td>';
        tr += '</tr>';
        $('#list_body').append(tr);
      });

      return $data;
    }

  });
</script>