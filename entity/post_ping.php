<?php
include '../application/config/connection.php';

        $sqlQuery = "SELECT cl.date_approved, mc.IP_ADDRESS, cl.status,cl.sms_sending_status, cl.control_no,cl.safety_seal_no, cl.user_id, cl.contact_details FROM `tbl_app_checklist` cl 
    LEFT JOIN tbl_admin_info ai on cl.user_id = ai.id 
    LEFT JOIN tbl_userinfo ui on ai.id = ui.USER_ID 
    LEFT JOIN tbl_ipadd_details mc on cl.sms_sending_status = mc.ID 
    WHERE sms_sending_status = 1 and sms_sending_status != '' and status = 'Approved' ORDER BY `date_approved` DESC LIMIT 1";
    $result = mysqli_query($conn, $sqlQuery);

    while ($row = mysqli_fetch_array($result)) {
  
                echo json_encode(array(
                    "ip_address" => $row['IP_ADDRESS']
                ));
            }






  
    

