<?php

class LoginManager
{
    public $conn = '';

  
    function __construct() 
    {
        $this->conn = mysqli_connect("localhost","calabarzondilggo_safetysealuser","'xPR<W5dm$#-[RQf","calabarzondilggo_safetyseal");
    }
    
    public function getUsersRole($username,$password)
    {
        $sql = "SELECT * FROM `tbl_admin_info` ai 
        LEFT JOIN tbl_userinfo ui on ai.ID = ui.USER_ID 
        WHERE ai.UNAME = '$username' AND ai.PASSWORD = '$password' LIMIT 1";
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = [
                'ID' => $row['ID'],
                'UNAME' => $row['UNAME'],
                'IS_VERIFIED' => $row['IS_VERIFIED'],
                'ROLE' => $row['ROLES'],
                'PROVINCE' => $row['PROVINCE'],
                'CITY_MUNICIPALITY' => $row['CITY_MUNICIPALITY']
            ];    
        }

        return $data;
    }

  
}