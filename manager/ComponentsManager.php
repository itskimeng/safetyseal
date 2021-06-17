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

    public function getGovtNature(){

        $data = ['DILG Regional Office', 'DILG Provincial Office', 'DILG C/M Field Office', 'PNP Regional Office', 'PNP Provincial Office', 'PNP City/Municipal Office/Station/Camp', 'BJMP Regional Office', 'Provincial Jail', 'District Jail', 'City/Municipal Jail', 'BFP Regional Office', 'BFP Provincial Office', 'BFP City/Municipal Station', 'Provincial LGU', 'City/Municipal LGU', 'Barangay LGU'];
        sort($data);
        return $data;
    }
}

