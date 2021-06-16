<?php

class ComponentsManager
{
    public $conn = '';

  
    function __construct() 
    {
        $this->conn = mysqli_connect("localhost","calabarzondilggo_safetysealuser","'xPR<W5dm$#-[RQf","calabarzondilggo_safetyseal");
    }
    
    public function getProvinces()
    {
        $sql = "SELECT id, code, name FROM tbl_province";
        
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($query)) {
            $data[$row['id']] = [
                'code' => $row['code'],
                'name' => $row['name']
            ];    
        }

        return $data;
    }

    public function getCityMuns()
    {
        $sql = "SELECT id, province, code, name FROM tbl_citymun";
        
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($query)) {
            $data[$row['province']][] = [
                'id' => $row['id'],
                'code' => $row['code'],
                'name' => $row['name']
            ];    
        }

        return $data;
    }
}

