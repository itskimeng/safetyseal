<?php
foreach ($user_est as $key => $data) {
    # code...
?>
    <tr>
        <td>
            <a href="#" class="btn btn-success btn-block btn-sm active"><?php echo $data['ac_status']; ?></a>
            
            <br>
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
            <a href="establishment-profile.php" class="">
                <div class="font-weight-bold">
                    <?php echo $data['ac_establishment']; ?>

                </div>
            </a>
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
            <?php if ($data['ac_status'] == 'Disapproved'): ?>
                <div class="col-md-12">
                  <a href="../entity/post_reassess.php?ssid=<?php echo $data['token']; ?>&stt=Reassess" type="button" class="btn btn-warning btn-block" style="width: 100%;">Reassess
                  </a>
                </div>
            <?php else: ?>
                <div class="col-md-12" style="margin-bottom:3%;">
                    <a href="../wbstapplication.php?ssid=<?php echo $data['token']; ?>" class="btn btn-primary btn-block btn-sm"><i class="fa fa-eye"></i> Edit</a>
                </div>
            <?php endif ?>
        </td>
    </tr>
<?php
}
?>