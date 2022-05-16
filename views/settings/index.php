<?php
require_once 'controller/SettingsController.php'; ?>

<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5 class="m-0"> Settings</small>
                </h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </div>
        </div>
        <hr>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="container">
        <?php include 'province_table.php'; ?>
    </div>
</div> 

<?php include 'modal_settings.php'; ?>  

<style type="text/css">

    .cavite-border {
        border-left: 4px solid #ffc107 !important;
    }

    .laguna-border {
        border-left: 4px solid #c20e41 !important;
    }

    .batangas-border {
        border-left: 4px solid #1345a0 !important;
    }

    .rizal-border {
        border-left: 4px solid #ebf820 !important;
    }

    .quezon-border {
        border-left: 4px solid #108712 !important;
    }

    .lucena-border {
        border-left: 4px solid #108712 !important;
    }

    .dropbox {
        box-shadow: 0 0.5px 1.5px rgb(0 0 0 / 50%);
    }

    .accordion {
        margin-bottom: 8px !important;
    }
    .menu .accordion-heading {  position: relative; }
    .menu .accordion-heading .edit {
        position: absolute;
        top: 8px;
        right: 30px; 
    }
    .menu .area { border-left: 4px solid #f38787; }
    .menu .equipamento { border-left: 4px solid #65c465; }
    .menu .ponto { border-left: 4px solid #98b3fa; }
    .menu .collapse.in { overflow: visible; }


    .accordion{margin-bottom:20px;}
    .accordion-group{margin-bottom:2px;border:1px solid #e5e5e5;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
    .accordion-heading{border-bottom:0;}
    .accordion-heading .accordion-toggle{display:block;padding:8px 15px;}
    .accordion-toggle{cursor:pointer;}
    .accordion-inner{padding:9px 15px;border-top:1px solid #e5e5e5;}
    .transform-text {
        text-transform: uppercase;
    }
</style>    

<script>
    $(document).ready(function(){
        <?php
            if (isset($_SESSION['toastr'])) {
              echo 'tata.' . $_SESSION['toastr']['type'] . '("' . $_SESSION['toastr']['title'] . '", "' . $_SESSION['toastr']['message'] . '", {
                  duration: 5000
                })';
              unset($_SESSION['toastr']);
            }
        ?>

        $(document).on('click', '.modal-settings', function(){
            let type = $(this).data('type');
            let modal = $('#modal-default');
            let modal_title = modal.find('.modal-title');
            let modal_type = modal.find('#m-type');
            let modal_idd = modal.find('#m-idd');
            let title = $(this).data('title');

            let dd = '';
            if (type == 'province') {
                dd = $(this).data('province');
            } else if (type == 'cluster') {
                dd = $(this).data('cluster');
            } else if (type == 'lgu') {
                dd = $(this).data('lgu');
            }

            modal_type.val(type);
            modal_idd.val(dd);
            
            modal_title.text('');
            modal_title.text('Configure Settings - '+title);
        });
    })
</script>
</html>