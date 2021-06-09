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
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>150</h3>

                                <p>New Orders</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>53<sup style="font-size: 20px">%</sup></h3>

                                <p>Bounce Rate</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>44</h3>

                                <p>User Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>65</h3>

                                <p>Unique Visitors</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-3">
                        <div class="col-lg-4">
                            <!-- COLOR PALETTE -->
                            <div class="box box-success color-palette-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa fa-tag"></i>Safety Seal</h3>
                                </div>
                                <div class="box-body" style="padding:35%;">

                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarousel" data-slide-to="1"></li>
                                    <li data-target="#myCarousel" data-slide-to="2"></li>
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <img src="frontend/images/safety_banner.svg" alt="Los Angeles" style="width:100%;">
                                    </div>

                                    <div class="item">
                                        <img src="frontend/images/safety_banner.svg" alt="Chicago" style="width:100%;">
                                    </div>

                                    <div class="item">
                                        <img src="frontend/images/safety_banner.svg" alt="New york" style="width:100%;">
                                    </div>
                                </div>

                                <!-- Left and right controls -->
                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Default box -->
                <div class="box box-success color-palette-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa fa-tag"></i>Applicants</h3>
                                </div>
                                <div class="box-body" >
                                <table class="table table-bordered">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Agency Name</th>
                                <th>Location</th>
                                <th>Date Registered</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>Mark Kim Sacluti</td>
                                <td>DILG IV-A</td>
                                <td>Pagsanjan, Laguna</td>
                                <td>June 08, 2021</td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                    </div>
                                </td>
                                <td style = "width:14px;">
                                    <button class="btn btn-primary btn-md">Approve</button>
                                </td>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>Mark Kim Sacluti</td>
                                <td>DILG IV-A</td>
                                <td>Pagsanjan, Laguna</td>
                                <td>June 08, 2021</td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                    </div>
                                </td>
                                <td style = "width:14px;">
                                    <button class="btn btn-primary btn-md">Approve</button>
                                </td>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>Mark Kim Sacluti</td>
                                <td>DILG IV-A</td>
                                <td>Pagsanjan, Laguna</td>
                                <td>June 08, 2021</td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                    </div>
                                </td>
                                <td style = "width:14px;">
                                    <button class="btn btn-primary btn-md">Approve</button>
                                </td>
                            </tr>
                           
                        </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
        
                <!-- /.box -->

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