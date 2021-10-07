<?php

class SafetysealHistoryManager
{
    public $conn = '';

    const MENU_PUBLIC_APPLICATION   = 1;
    const MENU_PUBLIC_USER          = 2;
    const MENU_ADMIN_APPLICATION    = 3;
    const MENU_ADMIN_USER           = 4;

    const ACTION_POST               = 'create';
    const ACTION_UPDATE             = 'update';
    const ACTION_DELETE             = 'delete';
    const ACTION_UPLOAD             = 'upload';
    const ACTION_RETURN             = 'return';
    const ACTION_RECEIVE            = 'receive';

    function __construct() 
    {
        $this->conn = mysqli_connect("localhost","calabarzondilggo_safetysealuser","'xPR<W5dm$#-[RQf","calabarzondilggo_safetyseal");
    }

    public function insert($data) 
    {
        $sql = 'INSERT INTO tbl_history (fid, mid, uid, action, message, action_date) VALUES ('.$data['fid'].', '.$data['mid'].', '.$data['uid'].', "'.$data['action'].'", "'.$data['message'].'", "'.$data['action_date'].'")';

        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function toData() 
    {

    }
    

}