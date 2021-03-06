<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-12">
                <div class=" card box box-success">
                    <div class="card-header" style="background-color: #009688; color:#fff;">
                        <i class="fa fa-map"></i> CALABARZON OVERVIEW
                    </div>
                    <div class="box-header with-border">

                        <!-- BAR CHART -->
                        <div class="box box-success">

                            <div class="box-body bg-ligth" style="background-color: #e2e3e345;">
                                <div class="row">
                                        <div class="col-md-8">

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
                                                
                                                <a href="dashboard.v2.php?username=<?php echo $_GET['username']; ?>&province=cavite" class="info-box mb-1 bg-warning cavite-province zoom" >
                                                  <span class="info-box-icon"><i class="fas fa-map-marker-alt"></i></i></span>

                                                  <div class="info-box-content">
                                                    <span class="info-box-text"><b>CAVITE</b> - Total Applicants w/ SSC</span>
                                                    <span class="info-box-number" style="margin-top: -0.75rem; font-size: 20pt;"><?php echo $reports['cavite']; ?></span>
                                                  </div>
                                                </a>

                                                <a href="dashboard.v2.php?username=<?php echo $_GET['username']; ?>&province=laguna" type="button" class="info-box mb-1 bg-red2 laguna-province zoom" style="color:white;">
                                                  <span class="info-box-icon"><i class="fas fa-map-marker-alt"></i></i></span>

                                                  <div class="info-box-content" style="color:white;">
                                                    <span class="info-box-text"><b>LAGUNA</b> - Total Applicants w/ SSC</span>
                                                    <span class="info-box-number" style="margin-top: -0.75rem; font-size: 20pt;"><?php echo $reports['laguna']; ?></span>
                                                  </div>
                                                </a>

                                                <a href="dashboard.v2.php?username=<?php echo $_GET['username']; ?>&province=batangas" class="info-box mb-1 bg-blue2 batangas-province zoom" style="color:white;">
                                                  <span class="info-box-icon"><i class="fas fa-map-marker-alt"></i></i></span>

                                                  <div class="info-box-content" style="color:white;">
                                                    <span class="info-box-text"><b>BATANGAS</b> - Total Applicants w/ SSC</span>
                                                    <span class="info-box-number" style="margin-top: -0.75rem; font-size: 20pt;"><?php echo $reports['batangas']; ?></span>
                                                  </div>
                                                  <!-- /.info-box-content -->
                                                </a>

                                                <a href="dashboard.v2.php?username=<?php echo $_GET['username']; ?>&province=rizal" class="info-box mb-1 bg-yellow2 rizal-province zoom" style="color:black;">
                                                  <span class="info-box-icon"><i class="fas fa-map-marker-alt"></i></i></span>

                                                  <div class="info-box-content" style="color:black;">
                                                    <span class="info-box-text"><b>RIZAL</b> - Total Applicants w/ SSC</span>
                                                    <span class="info-box-number" style="margin-top: -0.75rem; font-size: 20pt;"><?php echo $reports['rizal']; ?></span>
                                                  </div>
                                                  <!-- /.info-box-content -->
                                                </a>  

                                                <a href="dashboard.v2.php?username=<?php echo $_GET['username']; ?>&province=quezon" class="info-box mb-1 bg-green2 zoom" style="color:white;">
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
                <div class="card" style="height: 562px;">
                    <div class="card-header" style="background-color: #009688; color:#fff;">
                        <h3 class="card-title" style="font-size: 9pt;"><img src="frontend/images/logo.png" style="width: 30px;" alt=""> ESTABLISHMENTS WITH SAFETY SEAL CERTIFICATE</h3>

                        <a href="entity/ssc_establishment_print.php?province=all" class="btn btn-sm btn-info" style="float: right;"><i class="fa fa-print"></i> Print</a>
                    </div>

                    <div class="card-body" style="overflow:auto;">
                        <div class="col-sm-12">
                            <?php if(!empty($est_safety_seal)): ?>
                                
                                <?php foreach ($est_safety_seal as $key => $establishments) : ?>
                                    <div class="row" style="border-radius: 5px; border: solid 1px #ced109; margin-bottom: 3px;">
                                        <div class="col-sm-7">
                                            <b style="font-size:10pt;"><?php echo $establishments['est']; ?></b>
                                        </div>
                                        <div class="col-sm-5">
                                            <span style="float: right; position:relative; top:5px;" class="badge badge-primary pull-right"><?php echo $establishments['ss_no']; ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else:?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <b>There are no establishments with safety seal certificate</b>  
                                    </div>
                                </div>
                            <?php endif;?>
                        </div>
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
                            <div style="padding-left:10px; padding-top:15px;">
                                LEGEND: 
                                <span class="pull-right badge bg-yellow">PENDING APPLICATION</span>
                                <span class="pull-right badge bg-green">APPROVED</span>
                            </div>
                            <div class="box-body bg-ligth" style="height: 466px;">
                                <div class="chart" style="padding-top: 20px;">
                                    <canvas id="barChart" style="height:230px; padding:10px;"></canvas>
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