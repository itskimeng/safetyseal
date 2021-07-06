<?php
include '../application/config/connection.php';

    $sqlQuery = "SELECT cl.date_approved, mc.IP_ADDRESS, cl.status,cl.sms_sending_status, cl.control_no,cl.safety_seal_no,  cl.user_id, cl.contact_details FROM `tbl_app_checklist` cl
    LEFT JOIN tbl_admin_info ai on cl.user_id = ai.id
       LEFT JOIN tbl_userinfo ui on ai.id = ui.USER_ID
       LEFT JOIN tbl_ipadd_details mc on cl.sms_sending_status = mc.ID
       WHERE `status` LIKE '%Approved%' ORDER BY `date_approved` DESC LIMIT 1    ";
    
    $result = mysqli_query($conn, $sqlQuery);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        if ($row['status'] == 'Approved') {
            echo json_encode(array(
                "ip_address" => $row['IP_ADDRESS'],
                "for_sending" => $row['sms_sending_status'],
                "user" => $row['user_id'],
                "control_no" => $row['control_no'],
                "ss_no" => $row['safety_seal_no'],
                "contact_details" => $row['contact_details'],
                "content" => "Notification from DILG IV-A Safety Seal Portal: \n Good day! Your application for Safety Seal Certification with Ctrl No: " . $row['control_no'] . " and Safety Seal No: " . $row['safety_seal_no'] . " has been approved. Kindly login to the portal to print the certificate"
            ));
        } else if ($row['status'] == 'Disapproved') {
            echo json_encode(array(
                "ip_address" => $row['IP_ADDRESS'],
                "for_sending" => $row['sms_sending_status'],
                "user" => $row['user_id'],
                "control_no" => $row['control_no'],
                "ss_no" => $row['safety_seal_no'],
                "contact_details" => $row['contact_details'],
                "content" => "Notification from DILG IV-A Safety Seal Portal:Good day! Your application for Safety Seal Certification with Ctrl No: ".$row['control_no']." has been returned. Kindly login to the portal to complete your application."
            ));
        }
    }
}
exit();
?>