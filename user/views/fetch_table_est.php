<?php
foreach ($user_est as $key => $data) {
    # code...
?>
    <tr>
        <td class="align-middle" style="width:20%;">

            <?php echo $data['name']; ?>

        </td>
        <td class="align-middle">
            <a href="establishment-profile.php" target="_blank" class="">
                <div class="font-weight-bold">
                    <?php echo $data['agency']; ?>

                </div>
            </a>
        </td>
        <td class="align-middle">
            <a href="establishment-profile.php" class="">
                <div class="font-weight-bold">
                    <?php echo $data['establishment']; ?>

                </div>
            </a>
        </td>
        <td class="align-middle">
            <?php echo $data['location']; ?>

        <td class="align-middle" nowrap="">
            <?php echo $data['control_no']; ?>

        </td>
        <td class="align-middle" nowrap="">
            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                <i class="la la-clipboard-check mr-2"></i>
                <?php echo date('F d, Y',strtotime($data['date_created'])); ?>

            </span>
        </td>
        <td class="align-middle" nowrap="">
            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                <i class="la la-clipboard-check mr-2"></i>
                <?php echo date('F d, Y', strtotime("+6 months", strtotime($data['date_created']))); ?>
            </span>
        </td>
        <td class="align-middle" nowrap="">
            <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
                <i class="la la-clipboard-check mr-2"></i>
                <button class="btn btn-primary btn-md"><i class="fa fa-edit"></i> Edit</button>
                <button class="btn btn-success btn-md"><i class="fa fa-eye"></i> View</button>
            </span>
        </td>
    </tr>
<?php
}
?>