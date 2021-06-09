<!DOCTYPE html>
<html>
<?php include 'layout/dashboard_header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <?php include 'layout/dashboard_navbar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Blank page
                    <small>it all starts here</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Examples</a></li>
                    <li class="active">Blank page</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="box box-success color-palette-box">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-tag"></i> Checklist</h3>
                            </div>

                            <div class="box-body" >
                                <?php include 'admin/checklist1.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>


            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.13
            </div>
            <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
            reserved.
        </footer>


    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="frontend/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="frontend/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="frontend/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="frontend/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="frontend/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->     
    <script src="frontend/dist/js/demo.js"></script>
    <script>
        $(document).ready(function() {
            $('.sidebar-menu').tree()
        })
    </script>
</body>

</html>