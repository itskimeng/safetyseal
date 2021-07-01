<?php
include '../application/config/connection.php';

    $sqlQuery = "SELECT ai.CMLGOO_NAME,cl.establishment as est, ai.PROVINCE, ai.LGU, cl.email_sending_status, mc.IP_ADDRESS, cl.control_no from tbl_app_checklist cl 
    LEFT JOIN tbl_admin_info ai on cl.user_id = ai.id 
    LEFT JOIN tbl_userinfo ui on ai.id = ui.USER_ID 
    LEFT JOIN tbl_ipadd_details mc 
    on cl.email_sending_status = mc.ID 
    where email_sending_status = 1 ";
    $result = mysqli_query($conn, $sqlQuery);

    if ($row1 = mysqli_fetch_array($result)) {
        $sql = "SELECT ai.CMLGOO_NAME as name, ui.MOBILE_NO as contact_details FROM `tbl_admin_info` ai
        LEFT JOIN tbl_userinfo ui on ai.id=ui.USER_ID
        WHERE ai.PROVINCE = ".$row1['PROVINCE']." AND ai.LGU=".$row1['LGU']." and ai.ROLES='admin'  ";
        $result1 = mysqli_query($conn, $sql);
        // if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result1)) {
                echo json_encode(array(
                    "ip_address" => $row1['IP_ADDRESS'],
                    "for_sending" => $row1['email_sending_status'],
                    "control_no" => $row1['control_no'],
                    "est" => $row1['est'],
                    "contact_details" => $row['contact_details'],
                    "content" => "Hi  ".$row['name']."!, ".strtoupper($row1['est'])." applied for Safety Seal Certification with CTRL No: ".$row1['control_no'].". Kindly login to the portal to proceed with the assessment and issuance of certificate."
                ));
            }
        // }

    }





  
    

