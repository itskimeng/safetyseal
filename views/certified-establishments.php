<?php require_once 'controller/CertifiedEstablishmentsController.php'; ?>

<img src="frontend/images/banner_calabarzon.png" height="10%" width="100%" alt="">
<hr>
<div class="row">
    <div class="col-lg-12 ">       
      <img src="frontend/images/carousel/3.png" style="width: 100%;" alt=""> 
    </div>
</div>
<div class="row mt-5 mb-5">
      
    <div class="col-md-12">
    

      <div class="card">
        <div class="card-header p-1">
          Home / Certified Establishments
        </div>
        <div class="card-body p-1" style="background-color: #f9f8f8;">
            <table class="table table-hover mb-0 border-bottom" id="establishmentsTable">
                <thead>
                    <tr>
                        <th hidden style="text-align: center;">ID</th>
                        <th class="text-center" width="25%">ESTABLISHMENT</th>
                        <th class="text-center" width="30%">ADDRESS</th>
                        <th class="text-center" width="15%">SAFETY SEAL NO</th>
                        <th class="text-center">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($establishments as $key => $establishment): ?>
                        <tr class="clickable-row" data-href="establishment-profile.php?id=<?= $establishment['ac_id']; ?>">
                            <td hidden>
                                <?= $establishment['province_id']; ?>        
                            </td>
                            <td class="align-middle">
                                <a href="establishment-profile.php?id=<?= $establishment['ac_id']; ?>" class="" style="text-decoration:none; color:black;" target="_blank">
                                    <span style="font-size:10pt;"><?= $establishment['agency']; ?></span>
                                    <div class="font-weight-bold">
                                       <?= $establishment['gov_estb_name']; ?>
                                    </div>
                                    <span class="text-muted" style="font-size:10pt;"><?= $establishment['nature']; ?></span>
                                </a>
                            </td>
                            <td class="align-middle">
                                 <?= $establishment['address']; ?>
                            </td>
                            <td class="text-center align-middle" nowrap="">
                                <?= $establishment['safety_seal_no']; ?>
                            </td>
                            <td class="text-center align-middle" nowrap="">
                                <?= $establishment['history']; ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>

            </table>

        </div>
    </div>
</div>

<script>
    $('#establishmentsTable').DataTable({
        "bLengthChange": false,
    });
</script>