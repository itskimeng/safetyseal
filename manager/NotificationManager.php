<?php

class NotificationManager
{
    public $conn = '';

    

    function __construct() 
    {
        $this->conn = mysqli_connect("localhost","calabarzondilggo_safetysealuser","'xPR<W5dm$#-[RQf","calabarzondilggo_safetyseal");
    }

 
    function getMessageInfoStatus($id) {
        $sql = "SELECT 
        ai.id as id,
        ui.GOV_ESTB_NAME as establishment, 
        ai.CMLGOO_NAME as fname,
        ui.MOBILE_NO as contact_details,
        cl.status as status,
        cl.safety_seal_no as ss_no,
        cl.control_no as control_no,
        cl.for_sending as for_sending
        FROM tbl_admin_info ai
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        LEFT JOIN tbl_province p on p.id = ai.PROVINCE
        LEFT JOIN tbl_citymun m on m.id = ai.LGU
        LEFT JOIN tbl_app_checklist cl on ai.id = cl.user_id
        where cl.user_id = $id and cl.for_sending = 1";
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = [
                'status' =>$row['status'],
                'control_no' => $row['control_no'],
                'safety_seal_no' => $row['ss_no'],
                'for_sending' => $row['for_sending'],
                'contact_details' => $row['contact_details']
            ];
        return $data;
        }
    }
   
}