<?php

class DashboardManager
{
    public $conn = '';


    function __construct()
    {
        $this->conn = mysqli_connect("localhost", "calabarzondilggo_safetysealuser", "'xPR<W5dm$#-[RQf", "calabarzondilggo_safetyseal");
    }

    public function setLGU($province)
    {   
        
            $sql = "SELECT pro.id as id, pro.name, lgu.name as LGU FROM `tbl_province` pro LEFT JOIN tbl_citymun lgu on pro.id = lgu.province where pro.id = $province";
            $query = mysqli_query($this->conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
            $data[] = [
                "LGU" => $row['LGU']
            ];
        }
        

        return $data;
    }

    public function getdataForReceived($province)
    {
       $months =  [0,1,2,3,4,5,6,7,8,9,10,11,12];
        for($i=1; $i < count($months); $i++){
            $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
            LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
            LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
            WHERE ai.PROVINCE= '$province' and MONTH(checklist.date_created) = $i and checklist.status='For Receiving'";
            $query = mysqli_query($this->conn, $sql);
            $result = $row = mysqli_fetch_assoc($query);
            $data[$months[$i]]= $row['count'];
        }

        return $data;
    }
    public function getdataApproved($province)
    {

        $months =  [0,1,2,3,4,5,6,7,8,9,10,11,12];
        for($i=1; $i < count($months); $i++){
            $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
            LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
            LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
            WHERE ai.PROVINCE= '$province' and MONTH(checklist.date_created) = $i and checklist.status='Approved'";
            $query = mysqli_query($this->conn, $sql);
            $result = $row = mysqli_fetch_assoc($query);
            $data[$months[$i]]= $row['count'];
        }
        return $data;
    }

    public function countStatus($province, $lgu)
    {
        $val = ['For Receiving', 'Received', 'Approved', 'Disapproved'];
        $data = array();
        foreach ($val as $key => $stat) {
            // $sql = "SELECT count(*) as 'status' FROM `tbl_app_checklist` WHERE status = '$stat' ";
            $sql = "SELECT 
                    count(*) as count
                    FROM tbl_app_checklist ac
                    LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
                    LEFT JOIN tbl_province p on p.id = ai.PROVINCE
                    LEFT JOIN tbl_citymun cm on cm.id = ai.LGU
                    WHERE p.id = '$province' AND cm.id = '$lgu' AND status = '".$stat."' ";

            $query = mysqli_query($this->conn, $sql);
            $result = $row = mysqli_fetch_assoc($query);
            $data[$stat] = $row['count'];
        }

        return $data;
    }
}
