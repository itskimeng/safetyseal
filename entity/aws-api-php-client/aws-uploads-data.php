<?php

class BucketUploads extends AWS_CLIENT
{

    function __construct() {
        if (!isset($this->db)) {
            // Connect to the database
            $conn = new mysqli($this->hostname, $this->db_user, $this->db_password, $this->db_name);
            if ($conn->connect_error) {
                die("Database is not connected: " . $conn->connect_error);
            } else {
                $this->db = $conn;
            }
        }
    }
}
