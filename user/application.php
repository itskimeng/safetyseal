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
            <div class="container mb-3 pt-3">
                <div class="row">
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb float-sm-right" style="float:right;">
                            <ol class="breadcrumb" style="font-size: 14px;">
                                <li class="breadcrumb-item"><a href="../user/index.php" style="text-decoration: none; color: #243866;"><i class="fas fa-home"></i> Home</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="../user/application_list.php" style="text-decoration: none; color: #243866;">Application List</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Application</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a href="../user/establishment.php" class="nav-link mb-2 p-3 shadow" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                <i class="fa fa-building" aria-hidden="true"></i>
                                <span class="font-weight-bold small"> Agency</span>
                            </a>

                            <a href="../user/account.php" class="nav-link mb-2 p-3 shadow" id="v-pills-home-tab" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                <i class="fa fa-cog" aria-hidden="true"></i>
                                <span class="font-weight-bold small"> Account</span>
                            </a>

                            <a href="../user/application_list.php" class="nav-link mb-2 p-3 shadow active" id="v-pills-messages-tab" data-toggle="pill" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                <i class="fas fa-clipboard-list"></i> 
                                <span class="font-weight-bold small">Application</span>
                            </a>

                            <a href="../user/users_guide.php" class="nav-link mb-2 p-3 shadow" id="v-pills-settings-tab" data-toggle="pill" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                                <i class="fas fa-file-alt"></i>
                                <span class="font-weight-bold small">User's Guide</span>
                            </a>
                        </div>
                    </div>


                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <a href="application_list.php" class="btn btn-secondary btn-sm">
                                    <i class="fa fa-arrow-circle-left"></i> Back
                                </a>
                            </div>
                        </div>

                        <form action="../entity/post_user_acct2.php?id=<?= $user_info['id']; ?>" enctype="multipart/form-data" method="POST">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="box tab-pane fade shadow rounded bg-white show active p-0" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <div class="box-header">
                                        <h3 class="box-title"><i class="fas fa-info-circle"></i> <b>Application</b></h3>
                                        <div class="box-tools">
                                            <div class="col-md-12" style="margin-bottom:3%;">
                                                <a href="../wbstapplication.php?ssid=<?php echo $_GET['ssid']; ?>&code=<?php echo $gcode; ?>&scope=<?php echo $gscope; ?>" type="button" class="btn btn-primary btn-block btn-sm rounded-circle" title="Edit Application"><i class="fa fa-edit"></i></a>

                                                <?php if (in_array($user_est[0]['ac_status'], ['Expired']) AND !$user_est[0]['for_renewal'] AND $has_renewal_entry == 0): ?>
                                                    <a href="../entity/renew_application.php?ssid=<?= $_GET['ssid']; ?>" type="button" class="btn btn-warning btn-block btn-sm rounded-circle" title="Apply For Renewal"><i class="fas fa-retweet"></i></a>
                                                <?php endif ?>

                                                <?php if (in_array($user_est[0]['ac_status'], ['Disapproved', 'Returned', 'Revoked'])): ?>
                                                    <a href="../entity/post_reassess.php?ssid=<?= $_GET['ssid']; ?>&stt=Reassess" type="button" class="btn btn-warning btn-block btn-sm rounded-circle" title="Reassess Application"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                                <?php endif ?>

                                                <?php if (in_array($user_est[0]['ac_status'], ['Disapproved', 'Returned', 'Draft', 'For Renewal'])): ?>
                                                    <a type="button" class="btn btn-danger btn-sm btn-delete_app rounded-circle" data-bs-toggle="modal" data-target="#modal-delete_app" title="Delete Application"><i class="fas fa-trash"></i></a>

                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="box-body">
                                        <div class="row">

                                            <div class="col-md-12 p-0">
                                                <table class="table table-responsive" style="font-size: 14px;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width:50%;">
                                                                <table style="margin-top: -13px; margin-left: -10px;">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width: 55%;">Control No</td>
                                                                            <td>
                                                                                <label class="control-label"><strong><?= $user_est[0]['control_no']; ?></strong></label>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 55%;">Date Created</td>
                                                                            <td>
                                                                                <label class="control-label"><strong><?= $user_est[0]['date_created']; ?></strong></label>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 55%;">Sub-Office/Unit</td>
                                                                            <td>
                                                                                <label class="control-label"><strong><?= $user_est[0]['ac_establishment']; ?></strong></label>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 55%;">Safetyseal No</td>
                                                                            <td>
                                                                                <?php if (in_array($user_est[0]['ac_status'], ['Approved', 'Renewed'])): ?>
                                                                                    <a href="../certificate.php?token=<?php echo $_GET['ssid']; ?>&status=<?= $user_est[0]['ac_status']; ?>" target="_blank" type="button" class="btn btn-success btn-block btn-sm" title="Print Certificate"> <?= $user_est[0]['ss_no']; ?></a>
                                                                                <?php elseif ($user_est[0]['ac_status'] == 'Expired'): ?>
                                                                                    <label class="control-label"><strong><?= $user_est[0]['ss_no']; ?></strong></label>
                                                                                <?php else: ?>
                                                                                    <strong>---</strong>
                                                                                <?php endif ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 55%;">Issued On</td>
                                                                            <td>
                                                                                <?php if (!empty($user_est[0]['date_issued'])): ?>
                                                                                    <label class="control-label"><strong><?= $user_est[0]['date_issued']; ?></strong></label>
                                                                                <?php else: ?>
                                                                                    ---
                                                                                <?php endif ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 55%;">Valid Until</td>
                                                                            <td>
                                                                                <?php if ($user_est[0]['ac_status'] == 'Expired'): ?>
                                                                                    <span class="label label-danger" style="font-size:13px;">
                                                                                        <b><?= $user_est[0]['date_validity']; ?></b>
                                                                                    </span>
                                                                                <?php elseif (empty($user_est[0]['ss_no'])): ?>
                                                                                    ---
                                                                                <?php else: ?>
                                                                                    <label class="control-label"><strong><?= $user_est[0]['date_validity']; ?></strong></label>
                                                                                <?php endif ?>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td>
                                                                <table style="margin-top: -13px; margin-left: -10px;">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width: 50%; vertical-align: middle;">Contact Tracing Tool</td>
                                                                            <td>
                                                                                <label class="control-label"><strong><?= $other_tool; ?></strong></label>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 50%; vertical-align: middle;">Status</td>
                                                                            <td>
                                                                                <?php if (in_array($user_est[0]['ac_status'], ['Revoked', 'Disapproved', 'Returned'])): ?>
                                                                                    <span class="badge badge-danger mb-1" style="background-color: #d60b0b; font-size: 13.5px;"><?= $user_est[0]['ac_status']; ?></span>
                                                                                <?php elseif (in_array($user_est[0]['ac_status'], ['Approved', 'Renewed'])): ?>
                                                                                    <span class="badge badge-success mb-1" style="background-color: #00a65a; font-size: 13.5px;"><?= $user_est[0]['ac_status']; ?></span>
                                                                                <?php elseif ($user_est[0]['ac_status'] == 'Expired'): ?>
                                                                                    <span class="badge bg-danger" style="font-size:13.5px;"><?= $user_est[0]['ac_status']; ?></span>
                                                                                <?php else: ?>
                                                                                    <span class="badge badge-info mb-1" style="background-color: #243866; font-size: 13.5px;"><?= $user_est[0]['ac_status']; ?></span>
                                                                                <?php endif ?>
                                                                                <br>
                                                                
                                                                                <?php if ($is_complete_attachments AND $upload_count > 0): ?>
                                                                                    <label class="mb-1" style="font-size:14px;"><i class="fas fa-check-circle" style="color:#00a65a;"></i><strong> <?= $upload_count; ?>/<?= $count_answeredyes; ?> Uploaded MOVS</strong></label><br>
                                                                                <?php else: ?>
                                                                                    <label class="mb-1" style="font-size:14px;"><i class="fas fa-times-circle" style="color:#d25555;"></i><strong> <?= $upload_count; ?>/<?= $count_answeredyes; ?> Uploaded MOVS</strong></label><br>
                                                                                <?php endif ?>

                                                                                <?php if ($is_complete_asessment): ?>
                                                                                    <label class="mb-1" style="font-size:14px;"><i class="fas fa-check-circle" style="color:#00a65a;"></i><strong> 100% Self Asessment</strong></label><br>
                                                                                <?php else: ?>
                                                                                    <label class="mb-1" style="font-size:14px;"><i class="fas fa-times-circle" style="color:#d25555;"></i><strong> <?= $complete_percentage; ?>% Self Asessment</strong></label><br>
                                                                                <?php endif ?>


                                                                                <?php if (in_array($user_est[0]['ac_status'], ['Revoked', 'Disapproved', 'Returned'])): ?>
                                                                                    <p class="text-danger" style="font-size:10.5px;">There seems to be a problem in your application.</p> 
                                                                                <?php elseif (!$is_complete_asessment OR !$is_complete_attachments): ?>
                                                                                    <p class="text-danger" style="font-size:10.5px;">Your application is not yet ready to submit.</p>
                                                                                <?php elseif ($user_est[0]['ac_status'] == 'Draft'): ?>
                                                                                    <p class="text-success" style="font-size:10.5px;">Your application is now ready to submit.</p>
                                                                                <?php elseif ($user_est[0]['ac_status'] == 'Received'): ?>
                                                                                    <p class="text-success" style="font-size:10.5px;">Application is now being assessed.</p>
                                                                                <?php elseif (in_array($user_est[0]['ac_status'], ['For Receiving', 'For Reassessment'])): ?>
                                                                                    <p class="text-success" style="font-size:10.5px;">Application is now waiting for CMLGOO's response.</p>
                                                                                <?php elseif ($is_complete_asessment AND $is_complete_attachments AND $user_est[0]['ac_status'] == 'For Renewal'): ?>
                                                                                    <p class="text-danger" style="font-size:10.5px;">Your application is not yet ready to submit.</p>
                                                                                <?php endif ?>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                    </tbody>    
                                                </table>
                                            </div>

                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="box tab-pane fade shadow rounded bg-white show active p-1" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <div class="box-header">
                                        <h3 class="box-title"><i class="fas fa-history"></i> <b>Approval History</b></h3>
                                    </div> 
                                    <div class="box-body custom-box-body" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;">
                                        <div class="row">

                                            <div class="col-md-12 p-0">
                                                <table class="table" style="font-size: 14px;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="color: #c0c0c0; text-align: center; width: 20%;"><b>DATE</b></td>
                                                            <td style="color: #c0c0c0; text-align: center; width: 25%;"><b>USER</b></td>
                                                            <td style="color: #c0c0c0; text-align: center; width: 20%;"><b>ACTION</b></td>
                                                            <td style="color: #c0c0c0; text-align: center;"><b>REMARK</b></td>
                                                        </tr>
                                                        <?php foreach ($approval_history as $key => $history): ?>
                                                            <tr>
                                                                <td style="vertical-align:bottom;">
                                                                    <small><?= $history['interval']; ?></small><br>
                                                                    <?= $history['action_date']; ?>
                                                                </td>
                                                                <td style="vertical-align:bottom;">
                                                                    <?= $history['name']; ?>
                                                                </td>
                                                                <td style="vertical-align:bottom; text-align: center;">
                                                                    <?= ucfirst($history['action']); ?>
                                                                </td>
                                                                <td style="vertical-align:bottom;">
                                                                   <?= ucfirst($history['message']); ?> 
                                                                </td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="box tab-pane fade shadow rounded bg-white show active p-1" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <div class="box-header">
                                        <h3 class="box-title"><i class="fas fa-calendar-check"></i> <b>Application History</b></h3>
                                    </div> 
                                    <div class="box-body">
                                        <div class="row">

                                            <div class="col-md-12 p-0">
                                                <table class="table" style="font-size: 14px;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="color: #c0c0c0;"><b>SAFESEAL NO.</b></td>
                                                            <td style="color: #c0c0c0;"><b>DATE</b></td>
                                                            <td style="color: #c0c0c0;"><b>ISSUED DATE</b></td>
                                                            <td style="color: #c0c0c0;"><b>EXPIRATION DATE</b></td>
                                                            <td style="color: #c0c0c0;"><b>STATUS</b></td>
                                                        </tr>
                                                        <?php if (!empty($application_history)): ?>
                                                            <?php foreach ($application_history as $key => $history): ?>
                                                                <tr>
                                                                    <td style="vertical-align:bottom;">
                                                                        <?= $user_est[0]['ss_no']; ?>
                                                                    </td>
                                                                    <td style="vertical-align:bottom;">
                                                                        <?= $history['date_created']; ?>
                                                                    </td>
                                                                    <td style="vertical-align:bottom;">
                                                                        <?= $history['issued_date']; ?>
                                                                    </td>
                                                                    <td style="vertical-align:bottom; text-align: center;">
                                                                        <?= $history['expiration_date']; ?>
                                                                    </td>
                                                                    <td style="vertical-align:bottom;">
                                                                       <?= $history['status']; ?> 
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="5" style="text-align:center;">No data available</td>
                                                            </tr>   
                                                        <?php endif ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
    </main>
</body>
<?php include '../layout/footer.html.v2.php'; ?>
<?php include '../layout/custom_page-above.php'; ?>
<?php include 'modal_delete_app_edit.php'; ?>    

</html>
<style type="text/css">
    #establishmentsTable {
        /*max-width: 2500px;*/
        /*overflow-x: scroll;*/
        font-family: poppins,sans-serif;
    }

    #establishmentsTable > tbody > tr {
        background-color: white;
    }

    .label {
        padding: 5px;
        border-radius: 4px;
    }

    .btn-renew {
      background-color: #004A7F;
      -webkit-border-radius: 10px;
      border-radius: 10px;
      border: none;
      color: #FFFFFF;
      cursor: pointer;
      display: inline-block;
      font-family: Arial;
      font-size: 20px;
      padding: 5px 10px;
      text-align: center;
      text-decoration: none;
      -webkit-animation: glowing 1500ms infinite;
      -moz-animation: glowing 1500ms infinite;
      -o-animation: glowing 1500ms infinite;
      animation: glowing 1500ms infinite;
    }

    @-webkit-keyframes glowing {
      0% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
      50% { background-color: #FF0000; -webkit-box-shadow: 0 0 5px #FF0000; }
      100% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
    }

    @-moz-keyframes glowing {
      0% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
      50% { background-color: #FF0000; -moz-box-shadow: 0 0 5px #FF0000; }
      100% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
    }

    @-o-keyframes glowing {
      0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
      50% { background-color: #FF0000; box-shadow: 0 0 5px #FF0000; }
      100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
    }

    @keyframes glowing {
      0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
      50% { background-color: #FF0000; box-shadow: 0 0 5px #FF0000; }
      100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
    }

    /*
    *
    * ==========================================
    * CUSTOM UTIL CLASSES
    * ==========================================
    */

    .nav-pills .nav-link.active, .nav-pills .show >.nav-link {
        color: #fff;
        background-color: #243866 !important;
    }

    .nav-pills-custom .nav-link {
        color: #aaa;
        background: #fff;
        position: relative;
    }

    .nav-pills-custom .nav-link.active {
        /*color: #002952;
        background: #fff;*/
        background-color: #002851 !important;
        color: white;
    }

    .nav-pills-custom .nav-link.active:hover {
        /*color: #002952;
        background: #fff;*/
        background-color: #002851;
        color: white;
    }

    .nav-pills-custom .nav-link:hover {
        background-color: #acb2b8;
        color: white;
    }

    /* Add indicator arrow for the active tab */
    @media (min-width: 992px) {
        .nav-pills-custom .nav-link::before {
            content: '';
            display: block;
            border-top: 8px solid transparent;
            border-left: 10px solid #002851;
            border-bottom: 8px solid transparent;
            position: absolute;
            top: 50%;
            right: -10px;
            transform: translateY(-50%);
            opacity: 0;
        }
    }

    .nav-pills-custom .nav-link.active::before {
        opacity: 1;
    }

    .text-right {
        text-align: right;
        padding-top: 7px;
    }

    .custom-form-control {
        border-radius: 5px !important;
        background-color: #f6f6f6 !important;
    }

    div.custom-box-body::-webkit-scrollbar {
        width: 10px;
    }
     
    div.custom-box-body::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 2px rgba(0,0,0,0.3); 
        border-radius: 2px;
    }
     
    div.custom-box-body::-webkit-scrollbar-thumb {
        border-radius: 2px;
        -webkit-box-shadow: inset 0 0 2px rgba(0,0,0,0.5); 
    }


</style>
<script>
    <?php
        if (isset($_SESSION['toastr'])) {
          echo 'tata.' . $_SESSION['toastr']['type'] . '("' . $_SESSION['toastr']['title'] . '", "' . $_SESSION['toastr']['message'] . '", {
              duration: 5000
            })';
          unset($_SESSION['toastr']);
        }
    ?>
    $(document).on('click', '.btn-delete_app', function(e){
        $('#modal-delete_app').modal('show'); 
    });
</script>
