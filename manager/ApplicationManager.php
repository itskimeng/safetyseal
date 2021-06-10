<?php

class ApplicationManager
{
    public $conn = '';

    function __construct() 
    {
        $this->conn = mysqli_connect("localhost","calabarzondilggo_safetysealuser","'xPR<W5dm$#-[RQf","calabarzondilggo_safetyseal");
    }

    public function getChecklists()
    {
        $sql = "SELECT id, requirement, description FROM tbl_app_certchecklist";
        $query = mysqli_query($this->conn, $sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = [
                'id' => $row['id'],
                'requirement' => $row['requirement'],
                'description' => explode('~ ', $row['description'])
            ];    
        }
        
        return $data;
    }
}