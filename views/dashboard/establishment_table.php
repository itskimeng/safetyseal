<?php
echo '
<tr>
<td class="align-middle">
'.$row['fname'].'
</td>
    <td class="align-middle">
        <a href="establishment-profile.php" target="_blank" class="">
            <div class="font-weight-bold">
               '.$row['agency'].'
            </div>
        </a>
    </td>

    <td class="align-middle">
       '.$row['address'].'
    </td>
    <td class="align-middle" nowrap="">
       '.$row['control_no'].'
    </td>
    <td class="align-middle" nowrap="">

   '.date('F d,Y',strtotime($row['date_created'])).' 
    </td>
    <td class="align-middle" nowrap="">
        '.date('F d, Y', strtotime("+6 months", strtotime($row['date_created']))).'
    </td>
    <td class="align-middle" nowrap="">
        <span class="label label-lg label-light-success label-inline font-weight-bold py-4">
            <i class="fa fa-check-circle"></i>
            '.$row['status'].'
        </span>
    </td>
</tr>';
?>