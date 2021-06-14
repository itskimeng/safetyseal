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

                    <div class="card">
                        <div class="card-header">
                            Home / My Establishments
                        </div>
                        <div class="card-body" style="background-color: #f9f8f8;">
                            <table class="table table-hover mb-0 border-bottom" id="establishmentsTable">
                                <thead>
                                    <tr>
                                        <th width="25%">NAME</th>
                                        <th width="25%">AGENCY</th>
                                        <th width="25%">ESTABLISHMENT</th>
                                        <th width="40%">LOCATION</th>
                                        <th width="15%">SAFETY SEAL NO</th>
                                        <th width="10%">ISSUED </th>
                                        <th width="10%">VALID UNTIL</th>
                                        <th width="10%">ACTION</th>
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