<?php

class UserManager
{
    public $conn = '';

  
    function __construct() 
    {
        $this->conn = mysqli_connect("localhost","calabarzondilggo_safetysealuser","'xPR<W5dm$#-[RQf","calabarzondilggo_safetyseal");
    }
    
    public function fetchEstablishments($userid)
    {
        $sql = "SELECT 
        ai.CMLGOO_NAME as name,
        u.GOV_AGENCY_NAME as agency,
        u.GOV_ESTB_NAME as establishment,
        u.ADDRESS as location, 
        ac.control_no as control_no,
        ac.safety_seal_no as ss_no,
        ac.token as token,
        ac.establishment as ac_establishment,
        ac.nature as ac_nature,
        ac.address as ac_address,
        ac.status as ac_status,
        DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created 
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo u on ai.ID = u.USER_ID
        WHERE ai.ID = '$userid'";

        $query = mysqli_query($this->conn, $sql);
        $data = [];
        $rowCount= mysqli_num_rows($query); 
        
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = [
                'name' => $row['name'],
                'agency' => $row['agency'],
                'establishment' => $row['establishment'],
                'location' => $row['location'],
                'control_no' => $row['control_no'],
                'ss_no' => $row['ss_no'],
                'token' => $row['token'],
                'date_created' => $row['date_created'],
                'ac_establishment' => $row['ac_establishment'],
                'ac_nature' => $row['ac_nature'],
                'ac_address' => $row['ac_address'],
                'ac_status' => $row['ac_status'],
                'est' => $rowCount
            ];    
        }


        return $data;
    }

    public function getUserInfo($userid)
    {
        $sql = "SELECT ai.id as id, ai.CMLGOO_NAME as name, user.GOV_AGENCY_NAME as agency, user.POSITION as position, user.ADDRESS as address, user.MOBILE_NO as phone_no, user.EMAIL_ADDRESS  as emailaddress FROM `tbl_admin_info` ai
        LEFT JOIN tbl_userinfo user on ai.id = user.USER_ID  WHERE ai.ID = '$userid'";

        $query = mysqli_query($this->conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $data = [
                'name' => $row['name'],
                'position' => $row['position'],
                'address' => $row['address'],
                'phone_no' => $row['phone_no'],
                'emailladdress' => $row['emailaddress'],
                'agency' => $row['agency']
                
            ];    
        }
        return $data;
        
    }

  
}