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
                'clist_id' => $row['id'],
                'requirement' => $row['requirement'],
                'description' => explode('~ ', $row['description']),
                'ulist_id' => '',
                'answer' => '',
                'reason' => ''
            ];    
        }
        
        return $data;
    }

    public function insertUserChecklist($data)
    {
        $sql = 'INSERT INTO tbl_app_userchecklist (chklist_id, user_id, answer, reason, date_created) VALUES ('.$data["chklist_id"].', '.$data["user_id"].', "'.$data["answer"].'", "'.$data["reason"].'", "'.$data["date_created"].'")';

        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function updateUserChecklist($data)
    {
        $sql = "UPDATE tbl_app_userchecklist 
                SET answer = '".$data['answer']."', reason = '".$data['reason']."' WHERE id = ".$data['chklist_id']." AND user_id = ".$data['user_id']."";

        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function getUserChecklists($user)
    {
        $sql = "SELECT 
            clist.id as clist_id,  
            clist.requirement as requirement,
            clist.description as description,  
            ulist.id as ulist_id,
            ulist.user_id as ulist_userid,
            ulist.answer as answer,
            ulist.reason as reason,
            DATE_FORMAT(ulist.date_created, '%Y-%m-%d') as date_created
            FROM tbl_app_userchecklist ulist
            LEFT JOIN tbl_app_certchecklist clist on clist.id = ulist.chklist_id
            WHERE ulist.user_id = $user";

        $query = mysqli_query($this->conn, $sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = [
                'clist_id' => $row['clist_id'],
                'requirement' => $row['requirement'],
                'description' => explode('~ ', $row['description']),
                'ulist_id' => $row['ulist_id'],
                'answer' => $row['answer'],
                'reason' => $row['reason'],
                'date_created' => $row['date_created']
            ];    
        }

        return $data;
    }

    public function getUsers($user)
    {
        $sql = "SELECT id, CONCAT(FIRST_NAME, LAST_NAME) as FULLNAME, ADDRESS, GOV_AGENCY_NAME, GOV_ESTB_NAME, MOBILE_NO, DATE_FORMAT(DATE_APPLICATION_CREATED, '%M %d, %Y') as DATE_APPLICATION_CREATED, GOV_NATURE_NAME FROM tbl_userinfo WHERE id = $user";

        $query = mysqli_query($this->conn, $sql);
        $result = mysqli_fetch_array($query);

        return $result;
    }

    public function setUserApplicationDate($user, $date)
    {
        $sql = "UPDATE tbl_userinfo SET DATE_APPLICATION_CREATED = '".$date."' WHERE id = ".$user."";
        $result = mysqli_query($this->conn, $sql);

        return $result;
    }
}