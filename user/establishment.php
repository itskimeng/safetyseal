<?php session_start() ?>
<?php require '../session_checker.v2.php'; ?>

<!DOCTYPE html>
<html lang="en">
<?php include 'user_header.php'; ?>
<?php include '../controller/UserController.php'; ?>
<?php include '../macro/macro.php'; ?>

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
                                <li class="breadcrumb-item active" aria-current="page">Establishment</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <!-- Tabs nav -->
                        <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link mb-2 p-3 shadow active" id="v-pills-home-tab" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                <i class="fa fa-building" aria-hidden="true"></i>
                                <span class="font-weight-bold small"> Agency</span>
                            </a>

                            <a href="../user/account.php" class="nav-link mb-2 p-3 shadow" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                <i class="fa fa-cog" aria-hidden="true"></i>
                                <span class="font-weight-bold small"> Account</span>
                            </a>

                            <a href="../user/application_list.php" class="nav-link mb-2 p-3 shadow" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                <i class="fas fa-clipboard-list"></i> 
                                <span class="font-weight-bold small">Application</span>
                            </a>

                            <a href="../user/users_guide.php" class="nav-link mb-2 p-3 shadow" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                                <i class="fas fa-file-alt"></i>
                                <span class="font-weight-bold small">User's Guide</span>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert" style="background-color: #243866 !important; border-color: #1e1e2d;">
                                  <strong><i class="fas fa-exclamation-triangle"></i></strong> These data will reflect in the checklist. Please check carefully before applying for certification.
                                </div>
                            </div>
                        </div>

                        <form action="../entity/post_establishment.php" enctype="multipart/form-data" method="POST">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="box tab-pane fade shadow rounded bg-white show active p-2" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <div class="box-header">
                                        <h3 class="box-title"><i class="fas fa-info-circle"></i> <b>Details</b></h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row mb-3">
                                            <?= group_input_custom('Name of Government Agency/Office', 'gov_agency', 'gov_agency', $user_info['agency']); ?>
                                        </div>
                                        <div class="row mb-3">
                                            <?= group_input_custom('Name of Sub-office/Unit', 'sub_office', 'sub_office', $user_info['sub_office']); ?>
                                        </div>
                                        <div class="row mb-3">
                                            <?= group_select_custom('Nature of Government Establishments', 'gov_nature', 'gov_nature', $user_info['nature'], $government_nature); ?>
                                        </div>
                                        <div class="row mb-3">
                                            <?= group_textarea_custom('Address', 'address', 'address', $user_info['address']); ?>
                                        </div>
                                        <div class="row mb-3">
                                            <?= group_select_custom('Province', 'province', 'province', $user_info['province_id'], $province_opts, ['custom-po'=>true]); ?>
                                        </div>
                                        <div class="row mb-3">
                                            <?= group_select_custom('City/Municipality', 'lgu', 'lgu', $user_info['lgu_code'], $lgu_opts, ['custom-cm'=>true]); ?>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="box-tools text-right">
                                            <div class="btn-group">
                                                <button class="btn btn-primary btn-md"><i class="fa fa-save"></i> Save</button>
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
        background-color:  #243866 !important;
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

    .float-sm-right {
        float: right !important;
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

    $(document).on('change', '.province', function(){
      $('#cform-lgu').val('');
      $('#cform-lgu').empty();
      let id = $(this).val();

      let path = '../entity/getLGUs.php?id='+id;
      getLGUOpts(path);
    })

    function getLGUOpts(opts) {
      $.get(opts, function(data, status){
          let dd = JSON.parse(data);
          $('#cform-lgu').append($('<option selected disabled>').val('').text('-- Please select City/Municipality --'));
          $.each(dd, function(key, item){
            $('#cform-lgu').append($('<option>').val(item.code).text(item.name));

          });
        }
      );
      
      return 0;
    }

</script>
