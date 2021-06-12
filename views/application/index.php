<?php require_once 'controller/AdminApplicationController.php'; ?>

<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0"> Application</h5>
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
          name: $('#cform-name').val(),
          agency: $('#cform-agency').val(),
          location: $('#cform-location').val(),
          status: $('#cform-status').val(),
          daterange: $('#reservation').val()
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
          tr+= '<td>'+item['fname']+'</td>';
          tr+= '<td>'+item['agency']+'</td>';
          tr+= '<td>'+item['address']+'</td>';
          tr+= '<td>'+item['date_created']+'</td>';
          tr+= '<td>'+item['status']+'</td>';
          tr+= '<td>';
          if (item['status'] == 'For Receiving') {
            tr+= '<a href="admin_application_view.php?appid='+item['id']+'&ussir='+item['userid']+'&status='+item['status']+'" class="btn btn-primary btn-block btn-sm" style="margin-bottom: -5%;"><i class="fa fa-box"></i> Received</a>';
          } else {
            tr+= '<a href="admin_application_view.php?appid='+item['id']+'&ussir='+item['userid']+'" class="btn btn-danger btn-block btn-sm" style="margin-bottom: -5%;"><i class="fa fa-clipboard-list"></i> View Applicant</a>';
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