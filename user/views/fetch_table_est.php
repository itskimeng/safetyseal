<?php
foreach ($user_est as $key => $data) {
    # code...
?>
    <tr>
        <td>
            <a href="#" class="btn btn-success btn-block btn-sm active"><?php echo $data['ac_status']; ?></a>
        </td>
        <td>
            <?php echo $data['control_no']; ?>
        </td>
        <td style="width:20%;"><?php echo $data['name']; ?></td>
        <td>
            <a href="establishment-profile.php" target="_blank" class="">
                <div class="font-weight-bold">
                    <?php echo $data['agency']; ?>
                </div>
            </a>
        </td>
        <td>
            <div class="font-weight-bold">
                <?php echo $data['ac_establishment']; ?>

            </div>
        </td>
        <td><?php echo $data['ac_address']; ?>
        <td nowrap=""><?php echo $data['ss_no']; ?></td>
        <td nowrap="">
            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                <i class="la la-clipboard-check mr-2"></i>
                <?php echo date('F d, Y',strtotime($data['date_created'])); ?>

            </span>
        </td>
        <td nowrap="">
            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                <i class="la la-clipboard-check mr-2"></i>
                <?php echo date('F d, Y', strtotime("+6 months", strtotime($data['date_created']))); ?>
            </span>
        </td>
        <td nowrap="">
            <?php if ($data['ac_status'] == 'Disapproved' OR $data['ac_status'] == 'Returned'){ ?>
                <div class="col-md-12 mb-1">
                  <a href="../entity/post_reassess.php?ssid=<?php echo $data['token']; ?>&stt=Reassess" type="button" class="btn btn-danger btn-block btn-sm" style="width: 100%;"><i class="fa fa-redo" aria-hidden="true"></i> Reassess
                  </a>
                </div>

                <div class="col-md-12 mb-1">
                  <a href="../entity/delete_application.php?ssid=<?php echo $data['token']; ?>" type="button" class="btn btn-danger btn-block btn-sm" style="width: 100%;"><i class="fas fa-trash"></i> Remove
                  </a>
                </div>

            <?php } else if ($data['ac_status'] == 'Approved') { ?>
                <div class="col-md-12 mb-1">
                  <a href="../certificate.php?token=<?php echo $data['token']; ?>" target="_blank" type="button" class="btn btn-warning btn-block btn-sm" style="width: 100%;"><i class="fa fa-certificate"></i> View Certificate
                  </a>
                </div>

            <?php } else { ?>
                <div class="col-md-12 mb-1" style="margin-bottom:3%;">
                    <a href="../wbstapplication.php?ssid=<?php echo $data['token']; ?>&code=<?php echo $gcode; ?>&scope=<?php echo $gscope; ?>" type="button" class="btn btn-primary btn-block btn-sm" style="width: 100%;"><i class="fa fa-eye"></i> Edit</a>
                </div>

                <div class="col-md-12 mb-1">
                  <a href="../entity/delete_application.php?ssid=<?php echo $data['token']; ?>" type="button" class="btn btn-danger btn-block btn-sm" style="width: 100%;"><i class="fas fa-trash"></i> Remove
                  </a>
                </div>
            <?php } ?>

            <?php if ($data['ac_status'] != 'Draft'): ?>
                <div class="col-md-12 mb-1">
                  <a href="../entity/print_preview.php?control_no=<?php echo $data['control_no']; ?>" type="button" class="btn btn-warning btn-block btn-sm" style="width: 100%;"><i class="fa fa-print"></i> Print
                  </a>
                </div>
            <?php endif ?>
        </td>
    </tr>
<?php
}
?>