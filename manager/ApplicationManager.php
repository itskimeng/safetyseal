<?php

class ApplicationManager
{
    public $conn = '';

    const STATUS_DRAFT = "Draft";
    const STATUS_APPROVED = "Approved";
    const STATUS_FOR_APPROVAL = "For Approval";

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

    public function findChecklist($userid)
    {
        $sql = "SELECT id FROM tbl_app_checklist WHERE user_id = $userid";
        $query = mysqli_query($this->conn, $sql);
    
        $result = mysqli_fetch_assoc($query);
        
        return $result['id'];
    }

    public function insertChecklist($control_no, $userid, $date_created)
    {
        $sql = 'INSERT INTO tbl_app_checklist (control_no, user_id, date_created) VALUES ("'.$control_no.'", '.$userid.', "'.$date_created.'")';
        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function updateChecklist($userid, $date_modified)
    {
        $sql = "UPDATE tbl_app_checklist SET date_modified = '".$date_modified."' WHERE user_id = ".$userid."";
        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function insertChecklistEntry($data)
    {
        $sql = 'INSERT INTO tbl_app_checklist_entry (parent_id, chklist_id, answer, reason, date_created) VALUES ('.$data["parent_id"].', '.$data["chklist_id"].', "'.$data["answer"].'", "'.$data["reason"].'", "'.$data["date_created"].'")';

        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function updateChecklistEntry($data)
    {
        $sql = "UPDATE tbl_app_checklist_entry 
                SET answer = '".$data['answer']."', reason = '".$data['reason']."' WHERE id = ".$data['chklist_id']."";

        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function getUserChecklistsEntry($user)
    {
        $sql = "SELECT 
            c.id as clist_id,  
            c.requirement as requirement,
            c.description as description,
            e.id as ulist_id,
            e.answer as answer,
            e.reason as reason
            FROM tbl_app_checklist_entry e
            LEFT JOIN tbl_app_checklist a on a.id = e.parent_id
            LEFT JOIN tbl_app_certchecklist c on c.id = e.chklist_id
            LEFT JOIN tbl_userinfo u on u.id = a.user_id
            WHERE u.id = $user";

        $query = mysqli_query($this->conn, $sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = [
                'clist_id' => $row['clist_id'],
                'requirement' => $row['requirement'],
                'description' => explode('~ ', $row['description']),
                'ulist_id' => $row['ulist_id'],
                'answer' => $row['answer'],
                'reason' => $row['reason']
            ];    
        }

        return $data;
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
        $sql = "SELECT 
            a.id as id, 
            DATE_FORMAT(a.date_created, '%M %d, %Y') as date_created,
            u.ADDRESS as address, 
            u.GOV_AGENCY_NAME as agency, 
            u.GOV_ESTB_NAME as establishment, 
            u.GOV_NATURE_NAME as nature,
            p.code as pcode,
            m.code as mcode,
            CONCAT(u.FIRST_NAME, ' ', u.LAST_NAME) as fname, 
            u.MOBILE_NO as contact_details,
            a.status as status,
            a.control_no as control_no
            FROM tbl_userinfo u 
            LEFT JOIN tbl_app_checklist a on u.id = a.user_id
            LEFT JOIN tbl_province p on p.id = u.PROVINCE
            LEFT JOIN tbl_citymun m on m.id = u.CITY_MUNICIPALITY
            WHERE u.id = $user";
        
        $query = mysqli_query($this->conn, $sql);
        // $result = mysqli_fetch_array($query);
        $data = [];
        $today = new DateTime();
        $today = $today->format('F d, Y');

        while ($row = mysqli_fetch_assoc($query)) {
            $date_created = $row['date_created'];
            if (empty($date_created)) {
                $date_created = $today;
            }
            $data = [
                'id' => $row['id'],
                'date_created' => $date_created,
                'address' => $row['address'],
                'agency' => $row['agency'],
                'establishment' => $row['establishment'],
                'nature' => $row['nature'],
                'fname' => $row['fname'],
                'contact_details' => $row['contact_details'],
                'status' => !empty($row['status']) ? $row['status'] : 'Draft',
                'pcode' => $row['pcode'],
                'mcode' => $row['mcode'],
                'code' => !empty($row['control_no']) ? $row['control_no'] : 'R4A-'.$row['pcode'].'-'.$row['mcode'].'-____'
            ];      
        }

        return $data;
    }

    public function setUserApplicationDate($user, $date)
    {
        $sql = "UPDATE tbl_userinfo SET DATE_APPLICATION_CREATED = '".$date."' WHERE id = ".$user."";
        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function proceedChecklist($checklist_id, $has_consent, $status, $date_modified)
    {
        $sql = "UPDATE tbl_app_checklist SET date_modified = '".$date_modified."', has_consent = '".$has_consent."', status = '".$status."' WHERE id = ".$checklist_id."";
        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function addFlash($type, $message, $title) 
    {
        $data = [
            'type'      => $type, // or 'success' or 'info' or 'warning'
            'title'     => $title,
            'message'   => $message
        ];

        return $data;
    }

    public function getProvinces()
    {
        $sql = "SELECT id, code, name FROM tbl_province";
        
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = [
                'id' => $row['id'],
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
            $data[] = [
                'id' => $row['id'],
                'province' => $row['province'],
                'code' => $row['code'],
                'name' => $row['name']
            ];    
        }

        return $data;
    }

    public function getApplicationLists($status)
    {
        $sql = "SELECT 
        ac.id as id,
        CONCAT(ui.FIRST_NAME, ' ', ui.LAST_NAME) as fname,
        ui.GOV_AGENCY_NAME as agency,
        ui.ADDRESS as address,
        DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
        ui.id as userid,
        ac.control_no as control_no
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_userinfo ui on ui.id = ac.user_id
        WHERE ac.status = '".$status."'";
        
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = [
                'id' => $row['id'],
                'userid' => $row['userid'],
                'fname' => $row['fname'],
                'agency' => $row['agency'],
                'address' => $row['address'],
                'date_created' => $row['date_created'],
                'control_no' => $row['control_no']
            ];    
        }

        return $data;
    }

}