<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-12">
                <div class=" card box box-success">
                    <div class="card-header" style="background-color: #009688; color:#fff;">
                        CALABARZON
                    </div>
                    <div class="box-header with-border">

                        <!-- BAR CHART -->
                        <div class="box box-success">

                            <div class="box-body bg-ligth" style="background-color: #e2e3e345;">
                                <div class="row">
                                    <!-- <div class="col-md-12"> -->
                                        <div class="col-md-8">
                                            <!-- <div style="margin: auto; width:54%; padding: 5px;">
                                                <img src="_images/calabarzon.png" style="max-width: 100%;">
                                            </div> -->

                                            <div class="calabarzon-map" style="margin: auto; margin-left: 267px; width: 445px;">
                                                <img src="_images/quezon.png" style="max-width: 100%;">
                                            </div>

                                            <div style="margin-top: -423px; margin-left: 199px; width: 445px;">
                                                <img class="calabarzon-map" src="_images/batangas.png" style="max-width: 100%;">
                                            </div>

                                            <div style="margin-top: -422px; margin-left: 199px; width: 445px;">
                                                <img class="calabarzon-map" src="_images/laguna.png" style="max-width: 100%;">
                                            </div>

                                            <div style="margin-top: -423px; margin-left: 200px; width: 445px;">
                                                <img class="calabarzon-map" src="_images/cavite.png" style="max-width: 100%;">
                                            </div>

                                            <div style="margin-top: -423px; margin-left: 200px; width: 445px;">
                                                <img class="calabarzon-map" src="_images/rizal.png" style="max-width: 100%;">
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="col-md-4">
                                            <div style="background-color: #e8e8e8; padding: 15px;">
                                                
                                                <a href="dashboard.v2.php?username=<?php echo $_GET['username']; ?>&province=cavite" class="info-box mb-1 bg-warning cavite-province">
                                                  <span class="info-box-icon"><i class="fas fa-map-marker-alt"></i></i></span>

                                                  <div class="info-box-content">
                                                    <span class="info-box-text"><b>CAVITE</b> - Total Applicants w/ SSC</span>
                                                    <span class="info-box-number" style="margin-top: -0.75rem; font-size: 20pt;"><?php echo $reports['cavite']; ?></span>
                                                  </div>
                                                </a>

                                                <a href="dashboard.v2.php?username=<?php echo $_GET['username']; ?>&province=laguna" type="button" class="info-box mb-1 bg-red2 laguna-province" style="color:white;">
                                                  <span class="info-box-icon"><i class="fas fa-map-marker-alt"></i></i></span>

                                                  <div class="info-box-content" style="color:white;">
                                                    <span class="info-box-text"><b>LAGUNA</b> - Total Applicants w/ SSC</span>
                                                    <span class="info-box-number" style="margin-top: -0.75rem; font-size: 20pt;"><?php echo $reports['laguna']; ?></span>
                                                  </div>
                                                </a>

                                                <a href="dashboard.v2.php?username=<?php echo $_GET['username']; ?>&province=batangas" class="info-box mb-1 bg-blue2 batangas-province" style="color:white;">
                                                  <span class="info-box-icon"><i class="fas fa-map-marker-alt"></i></i></span>

                                                  <div class="info-box-content" style="color:white;">
                                                    <span class="info-box-text"><b>BATANGAS</b> - Total Applicants w/ SSC</span>
                                                    <span class="info-box-number" style="margin-top: -0.75rem; font-size: 20pt;"><?php echo $reports['batangas']; ?></span>
                                                  </div>
                                                  <!-- /.info-box-content -->
                                                </a>

                                                <a href="dashboard.v2.php?username=<?php echo $_GET['username']; ?>&province=rizal" class="info-box mb-1 bg-yellow2 rizal-province" style="color:black;">
                                                  <span class="info-box-icon"><i class="fas fa-map-marker-alt"></i></i></span>

                                                  <div class="info-box-content" style="color:black;">
                                                    <span class="info-box-text"><b>RIZAL</b> - Total Applicants w/ SSC</span>
                                                    <span class="info-box-number" style="margin-top: -0.75rem; font-size: 20pt;"><?php echo $reports['rizal']; ?></span>
                                                  </div>
                                                  <!-- /.info-box-content -->
                                                </a>  

                                                <a href="dashboard.v2.php?username=<?php echo $_GET['username']; ?>&province=quezon" class="info-box mb-1 bg-green2" style="color:white;">
                                                  <span class="info-box-icon"><i class="fas fa-map-marker-alt"></i></i></span>

                                                  <div class="info-box-content quezon-province" style="color:white;">
                                                    <span class="info-box-text"><b>QUEZON</b> - Total Applicants w/ SSC</span>
                                                    <span class="info-box-number" style="margin-top: -0.75rem; font-size: 20pt;"><?php echo $reports['quezon']; ?></span>
                                                  </div>
                                                </a>  
                                            </div>

                                        </div>
                                        
                                    <!-- </div> -->
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

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-4">
                <div class="card" style="height: 269px;">
                    <div class="card-header" style="background-color: #009688; color:#fff;">
                        <h3 class="card-title"><img src="frontend/images/logo.png" style="width: 30px;" alt=""> LGUs </h3>
                    </div>

                    <div class="card-body" style="overflow:auto;">
                        <div style="text-align:center;"><b>Not yet Available</b></div>
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
                        <h3 class="card-title" style="font-size:12pt;"><img src="frontend/images/logo.png" style="width: 30px;" alt=""> ESTABLISHMENTS WITH SAFETY SEAL CERTIFICATE</h3>
                    </div>

                    <div class="card-body" style="overflow:auto;">
                        <ul class="list-group list-group-flush">
                        <?php if(!empty($est_safety_seal)): ?>
                            <?php foreach ($est_safety_seal as $key => $establishments) : ?>
                                <?php echo '<li class="list-group-item"><b style="font-size:10pt;">' . $establishments['est'] . '</b> <span style="float: right; position:relative; top:5px;" class="badge badge-primary pull-right">'.$establishments['ss_no'].'</span> </li>'; ?>
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
                        <h5>CALABARZON - MONTHLY UPDATES</h5> 
                    </div>
                    <div class="box-header with-border">

                        <!-- BAR CHART -->
                        <div class="box box-success">
                            <div style="padding-left:5px; padding-top:15px;">
                                LEGEND: <span class="pull-right badge bg-green">APPROVED</span>
                                <span class="pull-right badge bg-blue">FOR RECEIVING </span>
                            </div>
                            <div class="box-body bg-ligth" style="height: 466px;">
                                <div class="chart" style="padding-top: 20px;">
                                    <canvas id="barChart" style="height:230px; padding:5px;"></canvas>
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