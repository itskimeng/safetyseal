<?php
echo '
<tr>

    <td class="align-middle">
        <a href="establishment-profile.php" target="_blank" class="">
            <div class="font-weight-bold">
               '.$row['GOV_AGENCY_NAME'].'
            </div>
        </a>
    </td>
    <td class="align-middle">
       '.$row['GOV_ESTB_NAME'].'
    </td>
    <td class="align-middle">
       '.$row['ADDRESS'].'
    </td>
    <td class="align-middle" nowrap="">
       '.$row['control_no'].'
    </td>
    <td class="align-middle" nowrap="">

   '.date('F d,Y',strtotime($row['date_created'])).' 
    </td>
    <td class="align-middle" nowrap="">

        December 1, 2021
    </td>
    <td class="align-middle" nowrap="">
        <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
            <i class="fa fa-check-circle"></i>
            Passed
        </span>
    </td>
</tr>';
?>