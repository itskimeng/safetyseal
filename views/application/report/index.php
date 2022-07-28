<?php require_once 'controller/AdminApplicationController.php'; ?>

<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5 class="m-0"> Generate Report <small><b><?php echo $hlbl; ?></b></small></h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
                    <li class="breadcrumb-item active">Generate Report</li>
                </ol>
            </div>
        </div>
        <hr>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="container">
        <?php if (!$is_adminro): ?>
            <?php include 'filter.php'; ?>
            <?php include 'apps_table.php'; ?>
        <?php else: ?>
            <?php include 'filter_admin_ro.php'; ?>
            <?php include 'apps_table_admin_ro.php'; ?>
        <?php endif ?>
    </div>
</div>

<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" crossorigin="anonymous" />

<script>
    $(function() {
        // $('#report').hide();
        // $('select').select2();
        // $('#reservation').daterangepicker();


        //Date and time picker
        $('#cform-as_of').datetimepicker({ icons: { time: 'far fa-clock' } });

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
        $('#report').show();

            let path = 'entity/filter_applicants_report.php';
            let data = {
                name: $('#cform-name').val(),
                agency: $('#cform-agency').val(),
                location: $('#cform-location').val(),
                province: $('#province').val(),
                lgu: $('#city_mun').val(),
                status: $('#cform-status').val(),
                daterange: $('#reservation').val(),
                app_type: $('#cform-app_type').val()
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
                tr += '<td>' + item['app_type'] + '</td>';
                tr += '<td>';
                tr += '<span class="label label-sm bg-' + item['color'] + ' label-inline font-weight-bold py-3">';
                tr += '<i class="fa fa-check-circle"></i>' + item['status'];
                tr += '</span>';
                tr += '<br>';
                tr += item['control_no'];
                tr += '</td>';
                tr += '<td>' + item['fname'] + '</td>';
                tr += '<td>' + item['agency'] + '</td>';
                tr += '<td>' + item['address'] + '</td>';
                tr += '<td>' + item['date_created'] + '</td>';
                tr += '<td>' + item['ss_no'] + '</td>';
                tr += '</tr>';
                $('#list_body').append(tr);
            });

            return $data;
        }

        $(document).on('click', '#report', function() {
            let province = $('#province').val();
            let lgu = $('#city_mun').val();
            let daterange = $('#reservation').val();
            let app_type = $('#cform-app_type').val();

            let path = 'entity/filter_applicants_report.php';
            let data = {
                name: $('#cform-name').val(),
                agency: $('#cform-agency').val(),
                location: $('#cform-location').val(),
                province: province,
                lgu: lgu,
                status: $('#cform-status').val(),
                daterange: daterange,
                app_type: app_type
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

            window.location = 'reports.php?province='+province+'&lgu='+lgu+'&date_range='+daterange+'&app_type='+app_type;
        })

        $(document).on('click', '#btn-generate_adminro', function() {
            let path = 'entity/filter_applicants_report_admin.php';
            let path2 = 'entity/admin_ro_report.php';

            let data = {
                // province: $('.province').val(),
                asof_date: $('.datetimepicker-input').val()
            };

            $.get(path, data, function(data, status) {
                let $data = JSON.parse(data);
                $('#list_body').empty();

                let total = generateTotalReport($data);
                $('#list_body').append(total);

                let batangas = generateBatangasReport($data);
                $('#list_body').append(batangas);

                let cavite = generateCaviteReport($data);
                $('#list_body').append(cavite);

                let laguna = generateLagunaReport($data);
                $('#list_body').append(laguna);

                let rizal = generateRizalReport($data);
                $('#list_body').append(rizal);

                let huc = generateHUCReport($data);
                $('#list_body').append(huc);
            });

            $.post(path2, data, function(data, status) {
                window.location = 'entity/admin_ro_report.php?asof_date='+$('.datetimepicker-input').val();    
            });

        })


        $(document).on('click', '#btn-filter_adminro', function() {
            let path = 'entity/filter_applicants_report_admin.php';
            let data = {
                // province: $('.province').val(),
                asof_date: $('.datetimepicker-input').val()
            };  

            $.get(path, data, function(data, status) {
                let $data = JSON.parse(data);
                $('#list_body').empty();

                let total = generateTotalReport($data);
                $('#list_body').append(total);

                let batangas = generateBatangasReport($data);
                $('#list_body').append(batangas);

                let cavite = generateCaviteReport($data);
                $('#list_body').append(cavite);

                let laguna = generateLagunaReport($data);
                $('#list_body').append(laguna);

                let rizal = generateRizalReport($data);
                $('#list_body').append(rizal);

                let huc = generateHUCReport($data);
                $('#list_body').append(huc);

            });  
        })

        function generateTotalReport($data) {
            let row = '';
                row+= '<tr style="background-color: #8ae38a;">';
                row+= '<td style="text-align: center; vertical-align: middle;"><b>TOTAL</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['total_application']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['total_approved']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['total_renewed']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['total_received']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['total_disapproved']+'</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['total_approved']+'</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>';
                row+= '</tr>';

            return row;
        }

        function generateBatangasReport($data) {
            let row = '';
                row+= '<tr>';
                row+= '<td style="text-align: center; vertical-align: middle;"><b>BATANGAS</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['batangas_application']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['batangas_approved']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['batangas_renewed']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['batangas_received']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['batangas_disapproved']+'</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['batangas_approved']+'</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>';
                row+= '</tr>';

            return row;
        }

        function generateCaviteReport($data) {
            let row = '';
                row+= '<tr>';
                row+= '<td style="text-align: center; vertical-align: middle;"><b>CAVITE</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['cavite_application']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['cavite_approved']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['cavite_renewed']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['cavite_received']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['cavite_disapproved']+'</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['cavite_approved']+'</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>';
                row+= '</tr>';

            return row;
        }

        function generateLagunaReport($data) {
            let row = '';
                row+= '<tr>';
                row+= '<td style="text-align: center; vertical-align: middle;"><b>LAGUNA</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['laguna_application']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['laguna_approved']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['laguna_renewed']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['laguna_received']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['laguna_disapproved']+'</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['laguna_approved']+'</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>';
                row+= '</tr>';

            return row;
        }

        function generateRizalReport($data) {
            let row = '';
                row+= '<tr>';
                row+= '<td style="text-align: center; vertical-align: middle;"><b>RIZAL</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['rizal_application']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['rizal_approved']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['rizal_renewed']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['rizal_received']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['rizal_disapproved']+'</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['rizal_approved']+'</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>';
                row+= '</tr>';

            return row;
        }

        function generateHUCReport($data) {
            let row = '';
                row+= '<tr>';
                row+= '<td style="text-align: center; vertical-align: middle;"><b>QUEZON (including Lucena HUC)</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['huc_application']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['huc_approved']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['huc_renewed']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['huc_received']+'</b></td>';
                row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['huc_disapproved']+'</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>'+$data['huc_approved']+'</b></td>';
                // row+= '<td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>';
                row+= '</tr>';

            return row;
        }

    });
</script>