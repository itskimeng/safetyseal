<?php
foreach ($user_est as $key => $data) {
    # code...
?>
    <tr>
        <td style="text-align: center;">
            <?php echo $data['control_no']; ?>
        </td>
        <td style="text-align: center;">
            <?php if (in_array($data['ac_status'], ['Returned', 'Revoked'])): ?>
                <span class="label label-danger"><?php echo $data['ac_status']; ?></span>
            <?php elseif ($data['ac_status'] == 'Approved'): ?>
                <span class="label label-success"><?php echo $data['ac_status']; ?></span>
            <?php elseif (in_array($data['ac_status'], ['For Receiving', 'For Reassessment'])): ?>
                <span class="label label-primary"><?php echo $data['ac_status']; ?></span>
            <?php elseif (in_array($data['ac_status'], ['Reassess', 'Draft'])): ?>
                <span class="label label-default">Draft</span>
            <?php else: ?>
                <span class="label label-default"><?php echo $data['ac_status']; ?></span>
            <?php endif ?>
        </td>
        <!-- <td style="width:20%;"><?php //echo $data['name']; ?></td> -->
        <!-- <td>
            <a href="establishment-profile.php" target="_blank" class="">
                <div class="font-weight-bold">
                    <?php //echo $data['agency']; ?>
                </div>
            </a>
        </td> -->
        <td>
            <div class="font-weight-bold">
                <?php echo $data['ac_establishment']; ?>

            </div>
        </td>
        <!-- <td><?php //echo $data['ac_address']; ?> -->
        <td nowrap="" style="text-align:center; color: green;">
            <?php if ($data['ac_status'] == 'Approved' OR $data['for_renewal']): ?>
                <span class="label label-success"><b><?php echo $data['ss_no']; ?></b></span>
            <?php else: ?>
                -
            <?php endif ?>
        </td>
        <td nowrap="" style="text-align:center;">
            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                <i class="la la-clipboard-check mr-2"></i>
                <?php echo $data['date_created']; ?>

            </span>
        </td>
        <td nowrap="" style="text-align:center;">
            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                <i class="la la-clipboard-check mr-2"></i>
                <?php if (!empty($data['date_renewed'])): ?>
                    <?php echo $data['date_renewed']; ?>
                <?php else: ?>
                    -
                <?php endif ?>
            </span>
        </td>
        <td nowrap="" style="text-align:center;">
            <?php if ($data['ac_status'] == 'Approved' AND $data['interval'] == 0): ?>
                <span class="label label-danger btn-renew" style="font-size:13px;">
                    <b><?php echo $data['date_validity']; ?></b>
                </span>
            <?php elseif ($data['ac_status'] == 'Approved' OR $data['for_renewal']): ?>
                <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                    <i class="la la-clipboard-check mr-2"></i>
                    <?php echo $data['date_validity']; ?>
                </span>
            <?php else: ?>
                -
            <?php endif ?>
        </td>
        <td nowrap="" style="text-align:center;">
            <?php if (in_array($data['ac_status'], ['Disapproved', 'Returned', 'Revoked'])) { ?>
                <div class="col-md-12 mb-1" style="margin-bottom:3%;">
                    <a href="../wbstapplication.php?ssid=<?php echo $data['token']; ?>&code=<?php echo $gcode; ?>&scope=<?php echo $gscope; ?>" type="button" class="btn btn-primary btn-block btn-sm rounded-circle" title="Edit Application"><i class="fa fa-eye"></i></a>

                    <a href="../entity/post_reassess.php?ssid=<?php echo $data['token']; ?>&stt=Reassess" type="button" class="btn btn-warning btn-block btn-sm rounded-circle" title="Reassess Application"><i class="fa fa-redo" aria-hidden="true"></i>
                  </a>

                  <a href="../entity/delete_application.php?ssid=<?php echo $data['token']; ?>" type="button" class="btn btn-danger btn-block btn-sm rounded-circle" title="Remove Application"><i class="fas fa-trash"></i>
                  </a>

                </div>

                <!-- <div class="col-md-12 mb-1">
                  <a href="../entity/post_reassess.php?ssid=<?php //echo $data['token']; ?>&stt=Reassess" type="button" class="btn btn-warning btn-block btn-sm" style="width: 100%;"><i class="fa fa-redo" aria-hidden="true"></i>
                  </a>
                </div>

                <div class="col-md-12 mb-1">
                  <a href="../entity/delete_application.php?ssid=<?php //echo $data['token']; ?>" type="button" class="btn btn-danger btn-block btn-sm" style="width: 100%;"><i class="fas fa-trash"></i>
                  </a>
                </div> -->

            <?php } else if ($data['ac_status'] == 'Approved') { ?>
                <div class="col-md-12 mb-1">
                  <!-- <a href="../certificate.php?token=<?php //echo $data['token']; ?>" target="_blank" type="button" class="btn btn-warning btn-block btn-sm" style="width: 100%;"><i class="fa fa-certificate"></i> -->
                  <!-- </a> -->

                    <a href="../certificate.php?token=<?php echo $data['token']; ?>" target="_blank" type="button" class="btn btn-success btn-block btn-sm rounded-circle" title="View Certificate"><i class="fas fa-certificate"></i>
                    </a>

                    <a href="../entity/print_preview.php?control_no=<?php echo $data['control_no']; ?>" target="_blank" type="button" class="btn btn-warning btn-block btn-sm rounded-circle" title="Print Checklist"><i class="fa fa-print"></i>
                    </a>

                    <?php if ($data['interval'] == 0): ?>
                        <a href="../entity/renew_application.php?ssid=<?php echo $data['token']; ?>&code=<?php echo $gcode; ?>&scope=<?php echo $gscope; ?>" type="button" class="btn btn-secondary btn-block btn-sm rounded-circle btn-renew" title="Apply for Renewal"><i class="fa fa-print"></i>
                        </a>
                    <?php endif ?>
                </div>

            <?php } else { ?>
                <div class="col-md-12 mb-1" style="margin-bottom:3%;">
                    <a href="../wbstapplication.php?ssid=<?php echo $data['token']; ?>&code=<?php echo $gcode; ?>&scope=<?php echo $gscope; ?>" type="button" class="btn btn-primary btn-block btn-sm rounded-circle" title="Edit Application"><i class="fa fa-edit"></i></a>

                    <a href="../entity/delete_application.php?ssid=<?php echo $data['token']; ?>" type="button" class="btn btn-danger btn-block btn-sm rounded-circle" title="Remove Application"><i class="fas fa-trash"></i>
                      </a>

                    <?php if ($data['ac_status'] != 'Draft'): ?>
                        <!-- <div class="col-md-12 mb-1"> -->
                          <a href="../entity/print_preview.php?control_no=<?php echo $data['control_no']; ?>" type="button" class="btn btn-warning btn-block btn-sm rounded-circle" title="Print Checklist"><i class="fa fa-print"></i>
                          </a>
                        <!-- </div> -->
                    <?php endif ?>
                </div>


                <?php if (in_array($data['ac_status'], ['Reassess', 'Draft'])){ ?>
                    <!-- <div class="col-md-12 mb-1">
                      <a href="../entity/delete_application.php?ssid=<?php //echo $data['token']; ?>" type="button" class="btn btn-danger btn-block btn-sm"><i class="fas fa-trash"></i>
                      </a>
                    </div> -->
                <?php } ?>

            <?php } ?>

            <?php if ($data['ac_status'] != 'Draft'): ?>
                <!-- <div class="col-md-12 mb-1"> -->
                  <!-- <a href="../entity/print_preview.php?control_no=<?php //echo $data['control_no']; ?>" type="button" class="btn btn-warning btn-block btn-sm rounded-circle"><i class="fa fa-print"></i> -->
                  <!-- </a> -->
                <!-- </div> -->
            <?php endif ?>
        </td>
    </tr>
<?php
}
?>