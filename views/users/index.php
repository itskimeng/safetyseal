<?php
require_once 'controller/UserAccountsController.php'; ?>

<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5 class="m-0"> SafetySeal User Accounts <small><b><?php echo $hlbl; ?></b></small>
                </h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
                    <li class="breadcrumb-item active">User Accounts</li>
                </ol>
            </div>
        </div>
        <hr>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="container">
        
        <?php include 'user_table.php'; ?>
        <?php include 'views/dashboard/custom_style.css'; ?>
    </div>
</div>       

<?php include 'modal_impersonate.php'; ?>

<script>
    $(function() {
        $('#list_table').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
          "columnDefs": [
                {
                    "targets": [ 0 ],
                    "visible": false
                }
            ]
        });

        $(document).on('click', '.btn-impersonate', function(){
            let user_id = $(this).data('user_id');
            let modal = $('#modal-impersonate');

            modal.find('#user-id').val(user_id);
        });


        $('#cavite-province').on('hover', function(){
            $('.quezon-zoom').addClass('zoom2');
        });

    })
</script>
</html>