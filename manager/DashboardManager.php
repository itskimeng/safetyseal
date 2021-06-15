<?php

class DashboardManager
{
    public $conn = '';


    function __construct()
    {
        $this->conn = mysqli_connect("localhost", "calabarzondilggo_safetysealuser", "'xPR<W5dm$#-[RQf", "calabarzondilggo_safetyseal");
    }

    public function setBarChartLabel()
    {
        $provinces = ['CAVITE', 'LAGUNA', 'BATANGAS', 'RIZAL', 'QUEZON', 'Lucena City'];
        for ($i = 0; $i < 6; $i++) {
            $sql = "SELECT pro.name, checklist.status, count(*) as 'count' FROM `tbl_app_checklist` checklist
                LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
                LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
                WHERE  pro.name= '$provinces[$i]' and checklist.status='Approved'";
            $query = mysqli_query($this->conn, $sql);
            $result = $row = mysqli_fetch_assoc($query);
            $data[$provinces[$i]]= $row['count'];
        }

        return $data;
    }

    
    public function getdataForReceived()
    {
       $months =  [0,1,2,3,4,5,6,7,8,9,10,11,12];
        for($i=1; $i < count($months); $i++){
            $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
            LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
            LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
            WHERE MONTH(checklist.date_created) = $i and checklist.status='For Receiving'";
            //  ai.PROVINCE= '$province' and 
            $query = mysqli_query($this->conn, $sql);
            $result = $row = mysqli_fetch_assoc($query);
            $data[$months[$i]]= $row['count'];
        }

        return $data;
    }
    public function getdataApproved()
    {

        $months =  [0,1,2,3,4,5,6,7,8,9,10,11,12];
        for($i=1; $i < count($months); $i++){
            $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
            LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
            LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
            WHERE MONTH(checklist.date_created) = $i and checklist.status='Approved'";
            // ai.PROVINCE= '$province' and 
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
