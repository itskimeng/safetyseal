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
                                <li class="breadcrumb-item active" aria-current="page">Application List</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <!-- Tabs nav -->
                        <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a href="../user/establishment.php" class="nav-link mb-2 p-3 shadow" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                <i class="fa fa-building" aria-hidden="true"></i>
                                <span class="font-weight-bold small"> Agency</span>
                            </a>

                            <a href="../user/account.php" class="nav-link mb-2 p-3 shadow" id="v-pills-home-tab" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                <i class="fa fa-cog" aria-hidden="true"></i>
                                <span class="font-weight-bold small"> Account</span>
                            </a>

                            <a class="nav-link mb-2 p-3 shadow active" id="v-pills-messages-tab" data-toggle="pill" role="tab" aria-controls="v-pills-messages" aria-selected="false">
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
                            <div class="col-md-12">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert" style="background-color: #243866 !important; border-color: #1e1e2d;">
                                  <strong><i class="fas fa-exclamation-triangle"></i></strong> System will not accept new transaction if applicant has existing application.
                                </div>
                            </div>
                        </div>

                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="box tab-pane fade shadow rounded bg-white show active p-1" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <div class="box-header">
                                    <h3 class="box-title"><i class="fas fa-clipboard-list"></i> <b>Application List</b></h3>
                                    <div class="box-tools">
                                        <?php if (!$has_applied): ?>
                                            <a href="../wbstapplication.php?create_new" class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus-square"></i> Apply
                                            </a>
                                        <?php endif ?>
                                    </div>
                                </div> 
                                <div class="box-body">
                                    <div class="row">

                                        <div class="col-md-12 p-0">
                                            <table class="table" style="font-size: 14px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="color: #c0c0c0; width: 15%; text-align:center;"><b>CONTROL NO.</b></td>
                                                        <td style="color: #c0c0c0; text-align:center;"><b>Sub-Office/Unit</b></td>
                                                        <td style="color: #c0c0c0; text-align:center;"><b>STATUS</b></td>
                                                        <td style="color: #c0c0c0; text-align:center;"><b>EXPIRATION</b></td>
                                                        <td></td>
                                                    </tr>
                                                    <?php if (!empty($user_est)): ?>
                                                    <?php foreach ($user_est as $key => $est): ?>
                                                            <tr>
                                                                <td style="vertical-align:bottom; text-align: center;">
                                                                    <?= $est['control_no']; ?>
                                                                </td>
                                                                <td style="vertical-align:bottom; text-align: center;">
                                                                    <?= $est['ac_establishment']; ?>
                                                                </td>
                                                                <td style="vertical-align:bottom;  text-align: center;">
                                                                    <?= $est['ac_status']; ?>
                                                                </td>
                                                                <td style="vertical-align:bottom; text-align: center;">
                                                                    <?php if (in_array($est['ac_status'], ['Approved', 'Renewed']) AND !$est['interval']): ?>
                                                                        <span class="label label-success" style="font-size:13px;">
                                                                            <b><?= $est['date_validity']; ?></b>
                                                                        </span>
                                                                    <?php elseif (in_array($est['ac_status'], ['Approved', 'Renewed']) AND $est['interval']): ?>
                                                                        <span class="label label-danger" style="font-size:13px;">
                                                                            <b><?= $est['date_validity']; ?></b>
                                                                        </span>
                                                                    <?php elseif ($est['ac_status'] == 'Approved' OR $est['for_renewal']): ?>
                                                                        <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                                                                            <i class="la la-clipboard-check mr-2"></i>
                                                                            <?= $est['date_validity']; ?>
                                                                        </span>
                                                                    <?php elseif ($est['ac_status'] == 'Expired' AND $est['interval']): ?>
                                                                        <span class="label label-danger" style="font-size:13px;">
                                                                            <b><?= $est['date_validity']; ?></b>
                                                                        </span>
                                                                    <?php else: ?>
                                                                        ---
                                                                    <?php endif ?>
                                                                </td>
                                                                <td style="vertical-align:bottom; text-align: center;">
                                                                    <?php if (in_array($est['ac_status'], ['Disapproved', 'Returned', 'Revoked', 'For Renewal'])) { ?>
                                                                        <div class="col-md-12">
                                                                            <a href="application.php?ssid=<?= $est['token']; ?>&code=<?= $gcode; ?>&scope=<?= $gscope; ?>" type="button" class="btn btn-primary btn-block btn-sm rounded-circle" title="View Application"><i class="fa fa-eye"></i></a>

                                                                            <?php if (in_array($est['ac_status'], ['Disapproved', 'Returned', 'Revoked'])): ?>
                                                                                <a href="../entity/post_reassess.php?ssid=<?= $est['token']; ?>&stt=Reassess" type="button" class="btn btn-warning btn-block btn-sm rounded-circle" title="Reassess Application"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                                                                
                                                                            <?php endif ?>

                                                                          <a type="button" class="btn btn-danger btn-sm btn-delete_app rounded-circle" data-bs-toggle="modal" data-target="#modal-delete_app"><i class="fas fa-trash"></i></a>
                                                                        </div>

                                                                    <?php } else if (in_array($est['ac_status'], ['Approved', 'Renewed'])) { ?>
                                                                        <div class="col-md-12">
                                                                            <a href="application.php?ssid=<?= $est['token']; ?>&code=<?= $gcode; ?>&scope=<?= $gscope; ?>" type="button" class="btn btn-primary btn-sm rounded-circle" data-toggle="tooltip" data-placement="top" title="View Application"><i class="fa fa-eye"></i></a>

                                                                            <a href="../certificate.php?token=<?= $est['token']; ?>&status=<?= $est['ac_status']; ?>" target="_blank" type="button" class="btn btn-success btn-block btn-sm rounded-circle" data-toggle="tooltip" data-placement="top" title="View Certificate"><i class="fas fa-certificate"></i>
                                                                            </a>

                                                                            <a href="../entity/checklist_form.php?control_no=<?= $est['control_no']; ?>" target="_blank" type="button" class="btn btn-warning btn-block btn-sm rounded-circle" title="Print Checklist"><i class="fa fa-print"></i>
                                                                            </a>

                                                                            <?php if ($est['interval'] == 0): ?>
                                                                                <!-- <a href="../entity/renew_application.php?ssid=<?php //echo $est['token']; ?>&code=<?php //echo $gcode; ?>&scope=<?php //echo $gscope; ?>" type="button" class="btn btn-secondary btn-block btn-sm rounded-circle btn-renew" title="Apply for Renewal"><i class="fa fa-print"></i>
                                                                                </a> -->
                                                                            <?php endif ?>
                                                                        </div>

                                                                    <?php } else { ?>
                                                                        <div class="col-md-12">
                                                                            <a href="application.php?ssid=<?= $est['token']; ?>&code=<?= $gcode; ?>&scope=<?= $gscope; ?>" type="button" class="btn btn-primary btn-block btn-sm rounded-circle" title="View Application"><i class="fas fa-eye"></i></a>

                                                                            <?php if (in_array($user_est[0]['ac_status'], ['Draft','Disapproved', 'Returned', 'Revoked'])): ?>
                                                                                <a type="button" class="btn btn-danger btn-sm btn-delete_app rounded-circle" data-bs-toggle="modal" data-target="#modal-delete_app"><i class="fas fa-trash"></i></a>
                                                                            <?php endif ?>

                                                                            <a href="../certificate.php?token=<?= $est['token']; ?>&status=<?= $est['ac_status']; ?>" target="_blank" type="button" class="btn btn-success btn-block btn-sm rounded-circle" data-toggle="tooltip" data-placement="top" title="View Certificate"><i class="fas fa-certificate"></i>
                                                                            </a>

                                                                            <?php if ($est['ac_status'] != 'Draft'): ?>
                                                                                <a href="../entity/checklist_form.php?control_no=<?= $est['control_no']; ?>" type="button" target="_blank" class="btn btn-warning btn-block btn-sm rounded-circle" title="Print Checklist"><i class="fa fa-print"></i></a>
                                                                            <?php endif ?>
                                                                        </div>

                                                                    <?php } ?>   
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

                    </div>
                </div>
            </div>
    </main>
</body>
<?php include '../layout/footer.html.v2.php'; ?>
<?php include '../layout/custom_page-above.php'; ?>
<?php include 'modal_delete_app.php'; ?>

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
        let row = $(this).closest('tr');
        let connum = row.find('td:eq(0)').html();
        let modal = $('#modal-delete_app');
        let control_label = modal.find('.con_num');

        control_label.html($.trim(connum));

        $('#modal-delete_app').modal('show'); 
    });
</script>
