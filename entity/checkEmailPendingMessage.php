<?php
include '../application/config/connection.php';

    $sqlQuery = "SELECT mc.IP_ADDRESS, ai.CMLGOO_NAME as name, ui.GOV_ESTB_NAME as est, cl.status,cl.email_sending_status, cl.control_no,cl.safety_seal_no, cl.user_id, cl.contact_details from tbl_app_checklist cl 
    LEFT JOIN tbl_admin_info ai on cl.user_id = ai.id 
    LEFT JOIN tbl_userinfo ui on ai.id = ui.USER_ID 
    LEFT JOIN tbl_ipadd_details mc 
    on cl.email_sending_status = mc.ID 
    where email_sending_status = 1 ";
    echo $sqlQuery;
    $result = mysqli_query($conn, $sqlQuery);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
            echo json_encode(array(
                "ip_address" => $row['IP_ADDRESS'],
                "for_sending" => $row['email_sending_status'],
                "user" => $row['user_id'],
                "control_no" => $row['control_no'],
                "ss_no" => $row['safety_seal_no'],
                "name" => $row['name'],
                "est" => $row['est'],
                "contact_details" => $row['contact_details'],
                "content" => "Hi  ".$row['name']."!, ".strtoupper($row['est'])."applied for Safety Seal Certification with CTRL No: ".$row['control_no'].". Kindly login to the portal to proceed with the assessment and issuance of certificate."
            ));
        }
    
}
