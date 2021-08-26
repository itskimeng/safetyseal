<?php session_start() ?>
<?php require '../session_checker.v2.php'; ?>

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
            <hr>
                <div class="row mt-2">
                    <form action="../entity/post_user_acct2.php?id=<?php echo $user_info['id']; ?>" enctype="multipart/form-data" method="post">
                    <div class="col-md-12">
                        <div class="card mb-3" style="min-height: 96%;">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        Name
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="fullname" class="form-control" id="exampleInputEmail1" placeholder="Enter Fullname" value="<?php echo $user_info['name']; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        Position
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="position" class="form-control" id="exampleInputEmail1" placeholder="Enter Position" value="<?php echo $user_info['position']; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        Contact Number
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="mobile_no" class="form-control" id="exampleInputEmail1" placeholder="Enter Contact Number" value="<?php echo $user_info['phone_no']; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        Email Address
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Email Address" value="<?php echo $user_info['emailladdress']; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        Name of Government Agency/Office
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="gov_agency" class="form-control" id="exampleInputEmail1" placeholder="Enter Name of Government Agency/Office" value="<?php echo $user_info['agency']; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        Name of Sub-office/Unit
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="sub_office" class="form-control" id="exampleInputEmail1" placeholder="Enter Name of Sub-office/Unit" value="<?php echo $user_info['sub_office']; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        Nature of Government Establishments
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control select2bs4 select2-hidden-accessible" name="gov_nature" id="nature" tabindex="-1" aria-hidden="true" required>
                                                <option value ="" selected></option>
                                                <?php foreach ($government_nature as $key => $nature):?>
                                                    <?php if ($nature == $user_info['nature']): ?>
                                                        <option value="<?php echo $nature;?>" selected><?php echo $nature;?></option>
                                                    <?php else: ?>
                                                        <option value="<?php echo $nature;?>"><?php echo $nature;?></option>
                                                    <?php endif ?>
                                                <?php endforeach;?>
                                            </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        Address
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="address" class="form-control" id="exampleInputEmail1" placeholder="Enter Address" value="<?php echo $user_info['address']; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        Province
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <select class="form-control select2bs4 select2-hidden-accessible" name="province" id="province" tabindex="-1" aria-hidden="true" required>
                                                <option value ="" selected></option>
                                                <?php foreach ($province_opts as $key => $province):?>
                                                    <?php if ($key == $user_info['province_id']): ?>
                                                        <option value="<?php echo $key;?>" selected><?php echo $province['name'];?></option>
                                                    <?php else: ?>
                                                        <option value="<?php echo $key;?>"><?php echo $province['name'];?></option>
                                                    <?php endif ?>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        City/Municipality
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <select class="form-control select2bs4 select2-hidden-accessible" name="lgu" id="lgu" tabindex="-1" aria-hidden="true" required>
                                                <option value ="" selected></option>
                                                <?php foreach ($lgu_opts as $key => $lgu):?>
                                                    <?php if ($lgu['code'] == $user_info['lgu_code']): ?>
                                                        <option value="<?php echo $lgu['code'];?>" selected><?php echo $lgu['name'];?></option>
                                                    <?php else: ?>
                                                        <option value="<?php echo $lgu['code'];?>"><?php echo $lgu['name'];?></option>
                                                    <?php endif ?>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-footer">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        Username
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Enter Username" value="<?php echo $user_info['username']; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        Password
                                    </div>
                                    <div class="col-md-8">
                                        <input type="password" name="password" class="form-control" id="exampleInputEmail1" placeholder="Enter Password" value="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        Confirm Password
                                    </div>
                                    <div class="col-md-8">
                                        <input type="password" name="confirm_pw" class="form-control" id="exampleInputEmail1" placeholder="Confirm Password" value="">
                                    </div>
                                </div>
                                <!-- <div class="row mb-3"> -->
                                    <!-- <div> -->
                                        <button class="btn btn-sm btn-primary" style="float:right;"><i class="fa fa-edit"></i> Update</button>
                                    <!-- </div> -->
                                <!-- </div> -->
                            </div>
                        </div>  
                      
                
                    </div>
                </form>
            </div>        
                
            
    </main>
</body>
<?php include '../layout/footer.html.v2.php'; ?>
</html>
<script>
    <?php
      if (isset($_SESSION['toastr'])) {
        echo 'tata.'.$_SESSION['toastr']['type'].'("'.$_SESSION['toastr']['title'].'", "'.$_SESSION['toastr']['message'].'", {
          duration: 5000
        })';
        unset($_SESSION['toastr']);
      }
    ?> 

    $('#establishmentsTable').DataTable({
        responsive: {
            details: true
        }
    });

    $(document).on('change', '#province', function(){
      $('#lgu').val('');
      $('#lgu').empty();
      let id = $(this).val();

      let path = '../entity/getLGUs.php?id='+id;

      let dd = getLGUs(path);
    })

    function getLGUs(path) {
      $.get(path, function(data, status){
          let dd = JSON.parse(data);
          $('#lgu').append($('<option>').val('').text(''));
          $.each(dd, function(key, item){
            $('#lgu').append($('<option>').val(item.code).text(item.name));

          });
        }
      );
      
      return 0;
    }
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