<?php

class UserManager
{
    public $conn = '';

  
    function __construct() 
    {
        $this->conn = mysqli_connect("localhost","calabarzondilggo_safetysealuser","'xPR<W5dm$#-[RQf","calabarzondilggo_safetyseal");
    }
    
    public function fetch($userid)
    {
        $sql = "SELECT 
        ai.CMLGOO_NAME as name,
        user.GOV_AGENCY_NAME as agency,
        user.GOV_ESTB_NAME as establishment,
        user.ADDRESS as location, 
        checklist.control_no as control_no,
        DATE_FORMAT(checklist.date_created, '%Y-%m-%d') as date_created 
        FROM `tbl_admin_info` ai
        LEFT JOIN tbl_userinfo user on ai.ID = user.USER_ID
        LEFT JOIN tbl_app_checklist checklist on ai.id = user.USER_ID
        WHERE ai.ID = '$userid'";
        
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = [
                'name' => $row['name'],
                'agency' => $row['agency'],
                'establishment' => $row['establishment'],
                'location' => $row['location'],
                'control_no' => $row['control_no'],
                'date_created' => $row['date_created']
            ];    
        }


        return $data;
    }

  
}