<?php
date_default_timezone_set('Asia/Manila');

class ApplicationHistoryManager extends Connection
{
    public $conn = '';
    const STATUS_CREATED            = 'Created';
    const STATUS_APPROVED           = 'Approved';
    const STATUS_DISAPPROVED        = 'Disapproved';
    const STATUS_RENEWED            = 'Renewed';
    const STATUS_EXPIRED            = 'Expired';
    const STATUS_REVOKED            = 'Revoked';

     function __construct() {
        if (!isset($this->db)) {
            $conn = new mysqli($this->hostname, $this->dbUser, $this->dbPassword, $this->dbName);
            if ($conn->connect_error) {
                die("Database is not connected: " . $conn->connect_error);
            } else {
                $this->db = $conn;
            }
        }
    }

    public function insert($data) 
    {
        $sql = "INSERT INTO tbl_application_history 
                SET app_id = ".$data["app_id"].", 
                issued_date = '".$data['issued_date']."', 
                expiration_date = '".$data['expiration_date']."', 
                status = '".$data['status']."', 
                date_created = '".$data['date_created']."'";

        $result = $this->db->query($sql);

        return $result;
    }
    
}