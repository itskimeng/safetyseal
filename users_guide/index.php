<?php
require_once 'controller/UsersGuideController.php'; ?>

<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5 class="m-0"> User's Guide <small><b><?php echo $hlbl; ?></b></small>
                </h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
                    <li class="breadcrumb-item active">User's Guide</li>
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
            <div class="col-md-12">
                 <iframe src="fpdf/guide/safetyseal_users_guide_admin_2022.pdf" width="100%" height="500px"></iframe>
            </div>
        </div>
    </div>
</div>