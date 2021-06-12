<?php

class DashboardManager
{
    public $conn = '';

  
    function __construct() 
    {
        $this->conn = mysqli_connect("localhost","calabarzondilggo_safetysealuser","'xPR<W5dm$#-[RQf","calabarzondilggo_safetyseal");
    }
    
    public function count()
    {
        $val = ['For Receiving', 'Received', 'Approved', 'Disapproved'];
        $data = array();
        foreach ($val as $key => $stat) {
            $sql = "SELECT count(*) as 'status' FROM `tbl_app_checklist` WHERE status = '$stat' ";
            $query = mysqli_query($this->conn, $sql);
            $result= $row = mysqli_fetch_assoc($query);
            $data[$stat] = $row['status'];
        }
        
        return $data;
    }

  
}