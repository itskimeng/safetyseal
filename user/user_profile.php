<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'user_header.php'; ?>
<?php include '../controller/UserController.php'; ?>


<body>
    <main>
        <div class="container" style="margin-top: 5%;">
            <header>
                <?php include 'user_navbar.php'; ?>
            </header>
            <img src="../frontend/images/banner_calabarzon.png" height="10%" width="100%" alt="">

            <div class="container">
                <div class="col-md-12">
                    <div class="">


                        <!-- Main content -->
                        <section class="content">

                            <div class="row">

                                <div class="col-md-3">

                                    <!-- Profile Image -->
                                    <div class="card shadow ">
                                        <div class="card-header" style="background-color: #009688; color:#fff;">
                                        </div>
                                        <div class="card-body">
                                            <center><img style="width:100px;" src="../frontend/images/user.png" alt="User profile picture"></center>

                                            <h3 class="profile-username text-center"><?php echo $_SESSION['username']; ?></h3>


                                            <ul class="list-group list-group-unbordered">
                                                <li class="list-group-item">
                                                    <a href="users_establishments.php" style="color:#000;">
                                                    <b><i class="fa fa-home"></i> My Establishments</b>
                                                    <span class="badge bg-primary" style="margin-left:20%;">


                                                        <?php
                                                    
                                                            echo $user_info['est'];
                                                     ?>
                                                    </span>
                                                    </a>
                                                </li>

                                            </ul>


                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->

                                    <!-- About Me Box -->
                                    <br>
                                    <div class="card shadow">
                                        <div class="card-header" style="background-color: #009688; color:#fff;">
                                        </div>
                                        <div class="box-header with-border">
                                            <h3 class="box-title">About Me</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                        <strong><i class="fa fa-building margin-r-5"></i> Government Agency</strong>
                                            <p class="text-muted">
                                                <?php echo $user_info['agency']; ?>
                                            </p>
                                            <hr>
                                            <strong><i class="fa fa-book margin-r-5"></i> Position</strong>
                                            <p class="text-muted">
                                                <?php echo $user_info['position']; ?>
                                            </p>
                                            <hr>
                                            <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>

                                            <p class="text-muted"><?php echo $user_info['address']; ?></p>


                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-9">
                                    <div class="card shadow ">
                                        <div class="card-header" style="background-color: #009688; color:#fff;">
                                        </div>
                                        <div class="card-body">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Home</button>
                                                </li>
                                                <!-- <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                                                </li> -->
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <!-- AREA CHART -->
                                                            <div class="box box-primary">
                                                                <div class="box-header with-border">
                                                                    <h3 class="box-title">No. of Approved Establishments per Month</h3>

                                                                    
                                                                </div>
                                                                <div class="box-body">
                                                                    <div class="chart">
                                                                        <canvas id="areaChart" style="height:250px"></canvas>
                                                                    </div>
                                                                </div>
                                                                <!-- /.box-body -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> -->
                                            </div>

                                            <!-- /.box -->
                                        </div>
                                        <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Home</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
                                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                                    </div> -->
                                    </div>
                                    <!-- /.nav-tabs-custom -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                        </section>
                        <!-- /.content -->
                    </div>
                </div>
                <div class="col-md-12">


                </div>
            </div>
    </main>
</body>
<?php include '../layout/footer.html.php'; ?>

</html>
<script>
    $('#establishmentsTable').DataTable({
        responsive: {
            details: true
        }
    });
</script>


<!DOCTYPE html>
<html>


<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../frontend/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../frontend/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../frontend/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../frontend/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../frontend/dist/js/demo.js"></script>
</body>

</html>

<script>
    $(function() {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //--------------
        //- AREA CHART -
        //--------------

        // Get context with jQuery - using jQuery's .get() method.
        var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
        // This will get the first returned node in the jQuery collection.
        var areaChart = new Chart(areaChartCanvas)

        var areaChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                    label: 'Electronics',
                    fillColor: 'rgba(210, 214, 222, 1)',
                    strokeColor: 'rgba(210, 214, 222, 1)',
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: [65, 59, 80, 81, 56, 55, 40]
                },
                {
                    label: 'Digital Goods',
                    fillColor: 'rgba(60,141,188,0.9)',
                    strokeColor: 'rgba(60,141,188,0.8)',
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [28, 48, 40, 19, 86, 27, 90]
                }
            ]
        }

        var areaChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            //String - Colour of the grid lines
            scaleGridLineColor: 'rgba(0,0,0,.05)',
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: false,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
        }

        //Create the line chart
        areaChart.Line(areaChartData, areaChartOptions)

        //-------------

    })
</script>
</body>

</html>