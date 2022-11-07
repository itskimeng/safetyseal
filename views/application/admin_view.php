<?php require_once 'controller/AdminViewApplicationListController.php'; ?>

<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0"> Application View</small>
        </h5>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
          <li class="breadcrumb-item"><a href="admin_application.php">Application List</a></li>
          <li class="breadcrumb-item active">Application View</a></li>
        </ol>
      </div>
    </div>
    <hr>
  </div>
</div>
    
<!-- Main content -->
<div class="content">
  <div class="container">

    <div class="row">
      <div class="col-md-12 mb-2">
        <a href="admin_application.php" class="btn btn-secondary btn-sm">
          <i class="fa fa-arrow-circle-left"></i> Back
        </a>
      </div>
    </div>

    <div class="row">
        
        <div class="col-md-4">
          <div class="card">
            <div class="card-header bg-violet">
              <h5 class="card-title"><i class="fas fa-info-circle"></i> <b>Applicant</b></h5>
              
            </div>
            <div class="card-body p-0">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-responsive" style="font-size:14px;">
                    <tbody>
                      <tr>
                        <td width="25%">Agency/Office</td>
                        <td width="45%"><?= $user['agency']; ?></td>
                      </tr>
                      <tr>
                        <td width="25%">Person In-Charge</td>
                        <td width="45%"><?= $user['name']; ?></td>
                      </tr>
                      <tr>
                        <td width="25%">Location</td>
                        <td width="45%"><?= $user['address']; ?></td>
                      </tr>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header bg-violet">
                  <h5 class="card-title"><i class="fas fa-info-circle"></i> <b>Application List</b></h5>
                </div>

                <div class="card-body p-0">
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-responsive" style="width: 100%; font-size: 14px;">
                        <tbody>
                          <tr>
                            <td style="color: #c0c0c0; text-align: center; width: 20%;"><b>CONTROL NO</b></td>
                            <td style="color: #c0c0c0; text-align: center; width: 30%;"><b>SUB-OFFICE/UNIT</b></td>
                            <td style="color: #c0c0c0; text-align: center; width: 20%;"><b>EXPIRATION DATE</b></td>
                            <td style="color: #c0c0c0; text-align: center; width: 20%;"><b>STATUS</b></td>
                            <td></td>
                          </tr>
                          <?php if (!empty($data)): ?>
                             <?php foreach ($data as $key => $dd): ?>
                              <tr>
                                  <td style="vertical-align: bottom;">
                                    <span class="label label-sm bg-gray label-inline font-weight-bold py-3"></i><?= $dd['control_no']; ?></span><br>
                                    <?= $dd['date_created'] ?>
                                      
                                  </td>
                                  <td style="vertical-align: bottom;">
                                      <?= $dd['establishment']; ?>
                                  </td>
                                  <td style="vertical-align: bottom; text-align: center;">
                                    <?php if (!empty($dd['expiration_date'])): ?>
                                      <span class="label label-sm bg-<?= $dd['color']; ?> label-inline font-weight-bold py-3"><?= $dd['expiration_date']; ?></span>
                                    <?php else: ?>
                                      ---
                                    <?php endif ?>
                                  </td>
                                  <td style="vertical-align: bottom; text-align: center;">
                                    <?= $dd['status']; ?>
                                  </td>
                                  <td style="vertical-align: bottom; text-align: center;">
                                    <div class="col-md-12">
                                      <a href="admin_application_summary.php?form=<?= $_GET['form'];?>&appid=<?= $dd['id']; ?>&ussir=<?= $userid; ?>" class="btn btn-info btn-sm" title="View Checklist"><i class="fa fa-eye"></i></a>

                                      <?php if (in_array($dd['status'], ['Draft'])): ?>
                                        <a href="entity/delete_admin_application.php?token=<?= $dd['token']; ?>" class="btn btn-danger btn-sm" style="margin-bottom: -2%;" title="Remove Application">
                                         
                                        <i class="fa fa-trash"></i></a>
                                      <?php endif ?>

                                    </div>
                                  </td>
                              </tr>
                            <?php endforeach ?>
                          <?php else: ?>
                            <tr>
                              <td colspan="5" style="text-align:center;">No data available</td>
                            </tr>
                          <?php endif ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>

    </div> 
  </div>
</div>

<script>
  $(function () {
  $('#reservation').daterangepicker()

    $("#list_table").DataTable({
    }).buttons().container().appendTo('#list_table_wrapper .col-md-6:eq(0)');

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

    $(document).on('click', '#btn-filter', function() {
      let path = 'entity/filter_applicants.php';
      let data = {
          citymun: $('#cform-citymun').val(),
          name: $('#cform-name').val(),
          agency: $('#cform-agency').val(),
          location: $('#cform-location').val(),
          status: $('#cform-status').val(),
          daterange: $('#reservation').val(),
          app_type: $('#cform-app_type').val()
        };

      $.get(path, data, function(data, status){
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
    $.each($data, function(key, item){
    
      let tr = '<tr>';
      tr+= '<td style = "font-weight:bold;">'+item['app_type']+'</td>';
      tr+= '<td>';
      tr+= '<span class="label label-sm bg-'+item['color']+' label-inline font-weight-bold py-3">';
      tr+= '<i class="fa fa-check-circle"></i>'+item['status'];
      tr+= '</span>';
      tr+= '<br>';
      tr+= item['control_no'];
      tr+= '</td>';
      tr+= '<td>'+item['fname']+'</td>';
      tr+= '<td>'+item['agency']+'</td>';
      tr+= '<td>'+item['address']+'</td>';
      tr+= '<td>'+item['date_created']+'</td>';
      tr+= '<td>'+item['validity_date']+'</td>';
      tr+= '<td>'+item['ss_no']+'</td>';
      tr+= '<td>';

      if (item['app_type'] == 'Encoded') {
        tr+= '<a href="admin_application_edit.php?appid='+item['token']+'&code=&scope=" class="btn btn-info btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-clipboard-list"></i> View</a>';

        if (item['status'] == 'Draft') {
          tr+= '<a href="entity/delete_admin_application.php?appid='+item['token']+'" class="btn btn-danger btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-trash"></i> Remove</a>';
        }

      } else if (item['status'] == 'For Receiving') {
        tr+= '<a href="entity/post_received.php?appid='+item['id']+'&ussir='+item['userid']+'&status='+item['status']+'" class="btn btn-primary btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-box"></i> Receive</a>';

        tr+= '<a href="admin_application_open.php?appid='+item['id']+'&ussir='+item['userid']+'" class="btn btn-primary btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-box"></i> Receive</a>';
      } else {
        tr+= '<a href="admin_application_view.php?appid='+item['id']+'&ussir='+item['userid']+'" class="btn btn-info btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-clipboard-list"></i> View</a>';
      }

      if (item['status'] == 'Approved') {
        tr+= '<a href="certificate.php?token='+item['token']+'" class="btn btn-warning btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-print"></i> Generate Certificate</a>';
      }
      tr+= '</td>';
      tr+= '</tr>';
      $('#list_body').append(tr);
    });

    return $data;
  }

});
</script>