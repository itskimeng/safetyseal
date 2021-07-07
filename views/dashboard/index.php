<?php
require_once 'controller/DashboardController.php'; ?>

<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5 class="m-0"> SafetySeal Dashboard <small><b>(<?php echo $hlbl; ?>)</b></small>
                </h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
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

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?php echo $total_count['For Receiving']; ?></h3>
                        <p>FOR RECEIVING</p>
                    </div>
                    <div class="icon">
                        <img src="frontend/images/dash_received.png" style="width:100px;margin-top:-100px;margin-right:10px;" align="right" alt="">

                    </div>
                    <a href="#" class="small-box-footer">
                        &nbsp;
                    </a>
                </div>
            </div>

            <!-- small box -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo $total_count['Received']; ?></h3>

                        <p>RECEIVED</p>
                    </div>
                    <div class="icon">
                        <img src="frontend/images/dash_receiving.png" style="width:100px;margin-top:-100px;margin-right:10px;" align="right" alt="">

                    </div>
                    <a href="#" class="small-box-footer">
                        &nbsp;

                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $total_count['Approved']; ?></h3>


                        <p>APPROVED</p>
                    </div>
                    <div class="icon">
                        <img src="frontend/images/dash_approved.png" style="width:100px;margin-top:-100px;margin-right:10px;" align="right" alt="">

                    </div>
                    <a href="#" class="small-box-footer">
                        &nbsp;

                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box" style="background-color: #b71c1c;color:gainsboro">
                    <div class="inner">
                        <h3><?php echo $total_count['Disapproved']; ?></h3>


                        <p>DISAPPROVED</p>
                    </div>
                    <div class="icon">
                        <img src="frontend/images/dash_disapproved.png" style="width:100px;margin-top:-100px;margin-right:10px;" align="right" alt="">

                    </div>
                    <a href="#" class="small-box-footer">
                        &nbsp;

                    </a>
                </div>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-lg-12">
                <a href="reports.php" class="btn btn-primary float-right my-2">Generate Reports <i class="fa fa-print"></i></a>
            </div>
        </div> -->

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card" style="height: 269px;">
                            <div class="card-header" style="background-color: #009688; color:#fff;">
                                <h3 class="card-title"><img src="frontend/images/logo.png" style="width: 30px;" alt=""> LGU's </h3>
                            </div>

                            <div class="card-body" style="overflow:auto;">
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($lgu as $key => $municipalities) : ?>
                                        <?php echo '<li class="list-group-item">' . $municipalities['name'] . ' </li>'; ?>
                                        <!-- <span style="float: right; position:relative; top:5px;" class="badge badge-primary pull-right">Primary</span> -->
                                    <?php endforeach; ?>

                                </ul>
                            </div>
                        </div>
                        <div class="card" style="height: 269px;">
                            <div class="card-header" style="background-color: #009688; color:#fff;">
                                <h3 class="card-title"><img src="frontend/images/logo.png" style="width: 30px;" alt=""> ESTABLISHMENTS WITH SAFETY SEAL CERTIFICATE</h3>
                            </div>

                            <div class="card-body" style="overflow:auto;">
                                <ul class="list-group list-group-flush">
                                <?php if(!empty($est_safety_seal)): ?>
                                <?php foreach ($est_safety_seal as $key => $establishments) : ?>
                                        <?php echo '<li class="list-group-item">' . $establishments['est'] . ' <span style="float: right; position:relative; top:5px;" class="badge badge-primary pull-right">'.$establishments['ss_no'].'</span> </li>'; ?>
                                <?php endforeach; ?>
                                <?php else:?>
                                <?php echo '<li class="list-group-item">There are no establishments with safety seal certificate</li>'; ?>
                                <?php endif;?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8" style="border-radius:5px">
                        <div class=" card box box-success">
                            <div class="card-header" style="background-color: #009688; color:#fff;">
                                LEGEND: <span class="pull-right badge bg-green">APPROVED</span>
                                <span class="pull-right badge bg-blue">FOR RECEIVING </span>

                            </div>
                            <div class="box-header with-border">

                                <!-- BAR CHART -->
                                <div class="box box-success">

                                    <div class="box-body bg-ligth">
                                        <div class="chart">
                                            <canvas id="barChart" style="height:230px"></canvas>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>

                                <!-- /.box -->

                            </div>
                            <!-- /.col (RIGHT) -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- <div class="row">
            <div class="col-lg-4">
                <div class="card" style="height: 269px;">
                    <div class="card-header" style="background-color: #009688; color:#fff;">
                        <h3 class="card-title"><img src="frontend/images/logo.png" style="width: 30px;" alt=""> LGU's </h3>
                    </div>

                    <div class="card-body">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" style="height: 269px;">
                    <div class="card-header" style="background-color: #009688; color:#fff;">
                        <h3 class="card-title"><img src="frontend/images/logo.png" style="width: 30px;" alt=""> LGU's </h3>
                    </div>

                    <div class="card-body">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" style="height: 269px;">
                    <div class="card-header" style="background-color: #009688; color:#fff;">
                        <h3 class="card-title"><img src="frontend/images/logo.png" style="width: 30px;" alt=""> LGU's </h3>
                    </div>

                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div> -->


        <script>
            $(function() {
                $('#table1').DataTable();


                var areaChartData = {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],

                    datasets: [{
                            labels: 'Applicants',
                            fillColor: '#1976D2',
                            strokeColor: 'rgba(210, 214, 222, 1)',
                            pointColor: 'rgba(210, 214, 222, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(220,220,220,1)',
                            data: [<?php echo $receiving['1'] . ',' . $receiving['2'] . ',' . $receiving['3'] . ',' . $receiving['4'] . ',' . $receiving['5'] . ',' . $receiving['6'] . ',' . $receiving['7'] . ',' . $receiving['8'] . ',' . $receiving['9'] . ',' . $receiving['10'] . ',' . $receiving['11'] . ',' . $receiving['12']; ?>],
                        },
                        {
                            label: 'Approved Applicants',
                            fillColor: '#43A047',
                            strokeColor: 'rgba(60,141,188,0.8)',
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: [<?php echo $approved['1'] . ',' . $approved['2'] . ',' . $approved['3'] . ',' . $approved['4'] . ',' . $approved['5'] . ',' . $approved['6'] . ',' . $approved['7'] . ',' . $approved['8'] . ',' . $approved['9'] . ',' . $approved['10'] . ',' . $approved['11'] . ',' . $approved['12']; ?>],


                        }
                    ],

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


                var barChartCanvas = $('#barChart').get(0).getContext('2d')
                var barChart = new Chart(barChartCanvas)
                var barChartData = areaChartData
                barChartData.datasets[1].fillColor = '#00a65a'
                barChartData.datasets[1].strokeColor = '#00a65a'
                barChartData.datasets[1].pointColor = '#00a65a'
                var barChartOptions = {
                    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                    scaleBeginAtZero: true,
                    //Boolean - Whether grid lines are shown across the chart
                    scaleShowGridLines: true,
                    //String - Colour of the grid lines
                    scaleGridLineColor: 'rgba(0,0,0,.05)',
                    //Number - Width of the grid lines
                    scaleGridLineWidth: 1,
                    //Boolean - Whether to show horizontal lines (except X axis)
                    scaleShowHorizontalLines: true,
                    //Boolean - Whether to show vertical lines (except Y axis)
                    scaleShowVerticalLines: true,
                    //Boolean - If there is a stroke on each bar
                    barShowStroke: true,
                    //Number - Pixel width of the bar stroke
                    barStrokeWidth: 2,
                    //Number - Spacing between each of the X value sets
                    barValueSpacing: 5,
                    //Number - Spacing between data sets within X values
                    barDatasetSpacing: 1,
                    //String - A legend template
                    legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                    //Boolean - whether to make the chart responsive
                    responsive: true,
                    maintainAspectRatio: true
                }

                barChartOptions.datasetFill = false
                barChart.Bar(barChartData, barChartOptions)

            })
        </script>
        </body>

        </html>