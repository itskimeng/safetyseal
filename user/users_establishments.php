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
            <div class="container mb-3">
                <div class="row">
                  <div style="border-radius: 5px;border: 1px solid #b0adad; margin-bottom: -15px;">
                    <div class="row">
                        <div class="pt-2 pb-2" style="background-color: #fff317; padding: 12px; color: #3a2a2a;">
                            <i class="fa fa-directions"></i> <b>Steps in Online Application and Processing</b>
                        </div>
                        <table class="table table-striped table-bordered">
                            <tr>
                                <td style="width:15%;">Step 1:</td>
                                <td>Register an account in the Safety Seal Portal</td>
                            </tr>
                            <tr>
                                <td style="width:15%;">Step 2:</td>
                                <td>Fill-up the Online Safety Seal Self-Assessment Checklist and upload the documents for the Means of Verification (MOV).</td>
                            </tr>
                            <tr>
                                <td style="width:15%;">Step 3:</td>
                                <td>Wait for the Inspection and Assessment Team to conduct their assessment.</td>
                            </tr>
                            <tr>
                                <td style="width:15%;">Step 4:</td>
                                <td>If approved, print the Safety Seal Certification on an A4 size paper. If not approved, ask for reassessment.</td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="2"><b><i>~ system will not accept new transaction if applicant has existing application. ~</i></b></td>
                            </tr>
                        </table>
                    </div>
                  </div>
                </div>

                <div class="col-md-12 mt-3 py-3">
                    <div class="row">
                        <div class="col-md-2">
                            <?php if (!$has_applied): ?>
                                <!-- <span class="label label-lg label-light-success label-inline font-weight-bold"> -->
                                    <!-- <i class="la la-clipboard-check mr-2"></i> -->
                                    <a href="../wbstapplication.php?create_new" class="btn btn-primary btn-md">
                                        <i class="fa fa-plus-square"></i> Apply New
                                    </a>
                                <!-- </span> -->
                            <?php endif ?>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="card">
                            <div class="row">
                                <div class="card-header">
                                    My Establishments
                                </div>
                                <div class="card-body" style="background-color: #f9f8f8;">
                                    <table class="table table-hover border-bottom" id="establishmentsTable" style="font-size: 11pt;">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="10%">Control No.</th>
                                                <th class="text-center" width="10%">Status</th>
                                                <!-- <th class="text-center" width="20%">NAME</th> -->
                                                <!-- <th class="text-center" width="12%">AGENCY</th> -->
                                                <th class="text-center" width="16%">ESTABLISHMENT</th>
                                                <!-- <th class="text-center" width="20%">LOCATION</th> -->
                                                <th class="text-center" width="10%">SAFETY SEAL NO</th>
                                                <th class="text-center" width="10%">ISSUED </th>
                                                <th class="text-center" width="10%">RENEWED </th>
                                                <th class="text-center" width="10%">VALID UNTIL</th>
                                                <th class="text-center" width="8%">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php include 'views/fetch_table_est.php';?>
                                        </tbody>
                                    </table>
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

</style>
<script>
    // $('#establishmentsTable').DataTable({
    //     responsive: {
    //         details: true
    //     }
    // });

    <?php
    // toastr output & session reset
    // session_start();
    if (isset($_SESSION['toastr'])) {
      echo 'tata.' . $_SESSION['toastr']['type'] . '("' . $_SESSION['toastr']['title'] . '", "' . $_SESSION['toastr']['message'] . '", {
          duration: 5000
        })';
      unset($_SESSION['toastr']);
    }
    ?>
</script>