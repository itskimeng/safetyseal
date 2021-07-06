<?php require_once 'controller/AdminApplicationController.php'; ?>

<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0"> Application <small><b><?php echo $is_clusterhead ? '(CLUSTER HEAD)': ''; ?></b></small></h5>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
          <li class="breadcrumb-item active">Application</li>
        </ol>
      </div>
    </div>
    <hr>
  </div>
</div>

<!-- <div class="container">
<form method="post" enctype="multipart/form-data" action="entity/upload_table.php">
  <div class="form-group">
      <div class="custom-file">
        <input type="file" name="files" multiple class="custom-file-input form-control" id="customFile" required>
      </div>
    </div>
  </div>
  <button type="submit">Submit</button>
</form>
</div> -->
    
<!-- Main content -->
<div class="content">
  <div class="container">
    <?php include 'filter.php'; ?> 
    <?php include 'apps_table.php'; ?>     
  </div>
</div>

<script>
  $(function () {
    // $('select').select2();
  $('#reservation').daterangepicker()

    $("#list_table").DataTable({
      // "responsive": true, "lengthChange": false, "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#list_table_wrapper .col-md-6:eq(0)');
    // $('#list_table').DataTable({
    //   "paging": true,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false,
    //   "responsive": true,
    // });

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

      function generateMainTable($data) {
        $.each($data, function(key, item){
          let tr = '<tr>';
          tr+= '<td>'+item['app_type']+'</td>';
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
            tr+= '<a href="admin_application_edit.php?appid='+item['token']+'&code=&scope=" class="btn btn-primary btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-clipboard-list"></i> View</a>';
          } else if (item['status'] == 'For Receiving') {
            tr+= '<a href="admin_application_view.php?appid='+item['id']+'&ussir='+item['userid']+'&status='+item['status']+'" class="btn btn-primary btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-box"></i> Received</a>';
          } else {
            tr+= '<a href="admin_application_view.php?appid='+item['id']+'&ussir='+item['userid']+'" class="btn btn-primary btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-clipboard-list"></i> View</a>';
          }

          if (item['status'] == 'Approved') {
            tr+= '<a href="certificate.php?token='+item['token']+'" class="btn btn-warning btn-block btn-sm" style="margin-bottom: -2%;"><i class="fa fa-eye"></i> Generate Certificate</a>';
          }
          tr+= '</td>';
          tr+= '</tr>';
          $('#list_body').append(tr);
        });

        return $data;
      }
  });


  });
</script>