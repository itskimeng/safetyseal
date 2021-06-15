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
                    <div class="row">
                        <span class="label label-lg label-light-success label-inline font-weight-bold mt-3 py-3">
                            <!-- <i class="la la-clipboard-check mr-2"></i> -->
                            <a href="../wbstapplication.php?create_new" class="btn btn-primary btn-md">
                                <i class="fa fa-edit"></i> Add New
                            </a>
                        </span>
                    </div>
                </div>
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            Home / My Establishments
                        </div>
                        <div class="card-body" style="background-color: #f9f8f8;">
                            <table class="table table-hover mb-0 border-bottom" id="establishmentsTable" style="font-size: 10pt;">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="10%">Control No.</th>
                                        <th class="text-center" width="18%">NAME</th>
                                        <th class="text-center" width="18%">AGENCY</th>
                                        <th class="text-center" width="18%">ESTABLISHMENT</th>
                                        <th class="text-center" width="20%">LOCATION</th>
                                        <th class="text-center" width="15%">SAFETY SEAL NO</th>
                                        <th class="text-center" width="10%">ISSUED </th>
                                        <th class="text-center" width="10%">VALID UNTIL</th>
                                        <th class="text-center" width="10%">ACTION</th>
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