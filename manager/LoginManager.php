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
        $sql = "SELECT ai.ID AS ID,
        ai.UNAME AS UNAME,
        ai.IS_VERIFIED AS IS_VERIFIED,
        ai.ROLES AS ROLES,
        ai.PROVINCE AS PROVINCE,
        ai.LGU AS CITY_MUNICIPALITY ,
        ai.CMLGOO_NAME as name,
        ai.is_clusterhead as is_clusterhead,
        ai.clusterhead_id as clusterhead_id,
        ai.EMAIL as email
        FROM `tbl_admin_info` ai 
        LEFT JOIN tbl_userinfo ui on ai.ID = ui.USER_ID 
        WHERE ai.UNAME = '$username' AND ai.PASSWORD = '$password'";
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = [
                'ID' => $row['ID'],
                'UNAME' => $row['UNAME'],
                'IS_VERIFIED' => $row['IS_VERIFIED'],
                'ROLES' => $row['ROLES'],
                'PROVINCE' => $row['PROVINCE'],
                'CITY_MUNICIPALITY' => $row['CITY_MUNICIPALITY'],
                'name' => $row['name'],
                'email' => $row['email'],
                'is_clusterhead' => $row['is_clusterhead'],
                'clusterhead_id' => $row['clusterhead_id']
            ];    
        }


        return $data;
    }

  
}