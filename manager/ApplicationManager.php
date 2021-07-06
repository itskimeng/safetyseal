<?php

class ApplicationManager
{
    public $conn = '';

    const STATUS_DRAFT              = "Draft";
    const STATUS_APPROVED           = "Approved";
    const STATUS_DISAPPROVED        = "Disapproved";
    const STATUS_FOR_APPROVAL       = "For Approval";
    const STATUS_FOR_RECEIVING      = "For Receiving";
    const STATUS_RECEIVED           = "Received";
    const STATUS_FOR_REASSESSMENT   = "For Reassessment";
    const STATUS_REASSESS           = "Reassess";
    const TYPE_APPLIED           = "Applied";
    const TYPE_ENCODED           = "Encoded";
    

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
                'reason' => '',
                'other_tool' => ''
            ];    
        }
        
        return $data;
    }

    public function findChecklist($token)
    {
        $sql = "SELECT id FROM tbl_app_checklist WHERE token = '".$token."'";
        $query = mysqli_query($this->conn, $sql);
        $result = mysqli_fetch_assoc($query);
        
        return $result['id'];
    }

    public function insertChecklist($control_no, $establishment, $nature, $address, $userid, $date_created, $token)
    {
        $sql = 'INSERT INTO tbl_app_checklist (control_no, establishment, nature, address, user_id, date_created, token) VALUES ("'.$control_no.'", "'.$establishment.'", "'.$nature.'", "'.$address.'", '.$userid.', "'.$date_created.'", "'.$token.'")';

        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function updateChecklist($token, $establishment, $nature, $address, $date_modified)
    {
        $sql = "UPDATE tbl_app_checklist SET date_modified = '".$date_modified."', establishment = '".$establishment."', nature = '".$nature."', address = '".$address."' WHERE token = '".$token."'";
        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function insertChecklistEntry($data)
    {
        $sql = 'INSERT INTO tbl_app_checklist_entry (parent_id, chklist_id, answer, reason, date_created) VALUES ('.$data["parent_id"].', '.$data["chklist_id"].', "'.$data["answer"].'", "'.$data["reason"].'", "'.$data["date_created"].'")';
        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function notifyApprover($province, $lgu){
        $sql = "SELECT `PROVINCE`, `LGU`, `EMAIL`, ui.MOBILE_NO, ai.ROLES AS roles FROM `tbl_admin_info` ai
        left join tbl_userinfo ui on ai.ID = ui.USER_ID
        WHERE PROVINCE = '".$province."' and LGU = '".$lgu."' and roles = 'admin'";
       
        $data = [];
        $query = mysqli_query($this->conn, $sql);

        while ($row = mysqli_fetch_assoc($query)) {        
            $data[] = [
                'email' => $row['EMAIL'],
                'mobile' => $row['MOBILE_NO']
            ];
        }
            return $data;

    }

    public function updateChecklistEntry($data)
    {
        $sql = "UPDATE tbl_app_checklist_entry 
                SET tracing_tool = '".$data['tracing_tool']."', other_tool = '".$data['other_tool']."', answer = '".$data['answer']."', reason = '".$data['reason']."' WHERE id = ".$data['chklist_id']."";

        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function getUserChecklistsEntry($token)
    {
        $sql = "SELECT 
            c.id as clist_id,  
            c.requirement as requirement,
            c.description as description,
            e.id as ulist_id,
            e.answer as answer,
            e.reason as reason,
            a.status as status,
            e.assessment as assessment,
            e.other_tool as other_tool,
            a.status as status,
            e.tracing_tool as tracing_tool
            FROM tbl_app_checklist_entry e
            LEFT JOIN tbl_app_checklist a on a.id = e.parent_id
            LEFT JOIN tbl_app_certchecklist c on c.id = e.chklist_id
            LEFT JOIN tbl_admin_info ai on ai.id = a.user_id
            WHERE a.token = '".$token."'";

            

        $query = mysqli_query($this->conn, $sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $is_disabled = true;
            if (in_array($row['status'], array('Draft', 'Disapproved', 'Reassess'))) {
                $is_disabled = false;
            }

            $data[] = [
                'clist_id' => $row['clist_id'],
                'requirement' => $row['requirement'],
                'description' => explode('~ ', $row['description']),
                'ulist_id' => $row['ulist_id'],
                'answer' => $row['answer'],
                'reason' => $row['reason'],
                'assessment' => $row['assessment'],
                'other_tool' => $row['other_tool'],
                'is_disabled' => $is_disabled,
                'otherTool_disabled' => empty($row['answer']) ? false : true,
                'tracing_tool' => $row['tracing_tool']
            ];    
        }

        return $data;
    }

    public function getUserChecklistsAttachments($token)
    {
        $sql = "SELECT 
            e.id as eid,
            ca.id as caid,
            ca.file_id as file_id,
            ca.file_name as file_name,
            ca.location as location
            FROM tbl_app_checklist_attachments ca 
            LEFT JOIN tbl_app_checklist_entry e on e.id = ca.entry_id
            LEFT JOIN tbl_app_checklist a on a.id = e.parent_id
            WHERE a.token = '".$token."'";

        $query = mysqli_query($this->conn, $sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $data[$row['eid']][] = [
                'eid' => $row['eid'],
                'caid' => $row['caid'],
                'file_id' => $row['file_id'],
                'file_name' => $row['file_name'],
                'location' => $row['location']
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
            ulist.safety_seal_no as ss_no
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
                'ss_no' => $row['ss_no'],
                'date_created' => $row['date_created']
            ];    
        }

        return $data;
    }

    public function getUsers($user, $token)
    {
        $sql = "SELECT 
            ai.id as id,
            ac.id as acid,
            DATE_FORMAT(ac.date_created, '%M %d, %Y') as date_created,
            DATE_FORMAT(ac.date_proceed, '%m-%d-%Y') as date_proceed,
            ui.ADDRESS as address,
            ui.GOV_AGENCY_NAME as agency,
            ui.GOV_ESTB_NAME as establishment, 
            ui.GOV_NATURE_NAME as nature,
            ai.CMLGOO_NAME as fname,
            p.code as pcode,
            m.code as mcode,
            ui.MOBILE_NO as contact_details,
            ac.status as status,
            ac.control_no as control_no,
            ac.establishment as establishment2,
            ac.nature as nature,
            ac.address as address
            FROM tbl_app_checklist ac
            LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
            LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
            LEFT JOIN tbl_province p on p.id = ai.PROVINCE
            LEFT JOIN tbl_citymun m on m.id = ai.LGU
            WHERE ac.token = '".$token."'";
        
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
                'acid' => $row['acid'],
                'date_created' => $date_created,
                'address' => $row['address'],
                'agency' => $row['agency'],
                'establishment' => $row['establishment2'],
                'nature' => $row['nature'],
                'fname' => $row['fname'],
                'contact_details' => $row['contact_details'],
                'status' => !empty($row['status']) ? $row['status'] : 'Draft',
                'pcode' => $row['pcode'],
                'mcode' => $row['mcode'],
                'code' => !empty($row['control_no']) ? $row['control_no'] : '2021-'.'_____',
                'date_proceed' => $row['date_proceed']
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

    public function proceedChecklist($checklist_id, $contact_details, $has_consent, $status, $date_modified)
    {
        $sql = "UPDATE tbl_app_checklist SET contact_details = '".$contact_details."', date_proceed = '".$date_modified."', date_modified = '".$date_modified."', has_consent = '".$has_consent."', sms_sending_status = '1',email_sending_status = '1',pnp_sending_status = '1',bfp_sending_status = '1', status = '".$status."' WHERE id = ".$checklist_id."";
        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function reassessChecklist($user, $token, $status, $date_modified)
    {
        $sql = "UPDATE tbl_app_checklist SET reassessed_by = ".$user.", date_reassessed = '".$date_modified."', date_modified = '".$date_modified."', status = '".$status."' WHERE token = '".$token."'";
        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function receiveChecklist($checklist_id, $status, $date_modified, $receiver)
    {
        $sql = "UPDATE tbl_app_checklist SET date_received = '".$date_modified."', date_modified = '".$date_modified."', receiver_id = ".$receiver.", status = '".$status."' WHERE id = ".$checklist_id."";
        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function insertValidationChecklist($appid, $defects, $receommendations, $date_created)
    {
        $sql = 'INSERT INTO tbl_app_checklist_onsitevalidations (chklist_id, defects, recommendations) VALUES ("'.$appid.'", "'.$defects.'", "'.$receommendations.'")';
        $result = mysqli_query($this->conn, $sql);

        return $result;
    }


    public function updateValidationChecklist($checklist_id, $defects, $recommendations, $date_modified)
    {
        $sql = 'UPDATE tbl_app_checklist_onsitevalidations SET defects = "'.utf8_encode($defects).'", recommendations = "'.utf8_encode($recommendations).'", date_modified = "'.$date_modified.'" WHERE chklist_id = '.$checklist_id.'';
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
            $data[$row['id']] = [
                'code' => $row['code'],
                'name' => $row['name']
            ];    
        }

        return $data;
    }

    public function getCityMuns($province)
    {
        $sql = "SELECT id, province, code, name FROM tbl_citymun where province  = $province";
        
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($query)) {
            $data[$row['id']] = [
                'province' => $row['province'],
                'code' => $row['code'],
                'name' => $row['name']
            ];    
           
        }

        return $data;
    }

    public function getApplicationLists($province, $lgu, $status)
    {
        $sql = "SELECT 
        ac.id as id,
        ai.CMLGOO_NAME as fname,
        ui.GOV_AGENCY_NAME as agency,
        ui.ADDRESS as address,
        DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
        DATE_FORMAT(ac.date_approved, '%Y-%m-%d') as date_approved,
        ui.id as userid,
        ac.control_no as control_no,
        ac.safety_seal_no as ss_no,
        ac.status as status,
        ac.address as ac_address,
        ac.application_type as app_type,
        ac.token as token
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        WHERE ai.PROVINCE = ".$province." AND ai.LGU = ".$lgu." AND ac.application_type = 'Applied' AND ac.status <> '".$status."'";
     
     
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($query)) {
            $color = 'green';
            if ($row['status'] == 'For Receiving') {
                $color = 'primary';
            } elseif ($row['status'] == 'Received') {
                $color = 'yellow';
            } elseif ($row['status'] == 'Disapproved') {
                $color = 'red';
            }
            if($row['status'] =='Approved'){
                $validity = date('F d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
            }else{
                $validity = '';
            }

            $data[$row['id']] = [
                'id' => $row['id'],
                'userid' => $row['userid'],
                'fname' => $row['fname'],
                'agency' => $row['agency'],
                'address' => $row['address'],
                'date_created' => date('F d, Y',strtotime($row['date_created'])),
                'control_no' => $row['control_no'],
                'ss_no' => $row['ss_no'],
                'status' => $row['status'],
                'color' => $color,
                'ac_address' => $row['ac_address'],
                'app_type' => $row['app_type'],
                'token' => $row['token'],
                'validity_date' => $validity,
                // 'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
            ];    
        }

        $sql2 = "SELECT 
        ac.id as id,
        ai.CMLGOO_NAME as fname,
        ui.GOV_AGENCY_NAME as pagency,
        ac.agency as cagency,
        ui.ADDRESS as address,
        DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
        DATE_FORMAT(ac.date_approved, '%Y-%m-%d') as date_approved,
        ui.id as userid,
        ac.control_no as control_no,
        ac.safety_seal_no as ss_no,
        ac.status as status,
        ac.address as ac_address,
        ac.application_type as app_type,
        ac.token as token
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        WHERE ai.PROVINCE = ".$province." AND ai.LGU = ".$lgu." AND ac.application_type = 'Encoded'";
     
        $query = mysqli_query($this->conn, $sql2);
        // $data = [];
        
        while ($row = mysqli_fetch_assoc($query)) {
            $color = 'green';
            if ($row['status'] == 'For Receiving') {
                $color = 'primary';
            } elseif ($row['status'] == 'Received') {
                $color = 'yellow';
            } elseif ($row['status'] == 'Disapproved') {
                $color = 'red';
            }

            $data[$row['id']] = [
                'id' => $row['id'],
                'userid' => $row['userid'],
                'fname' => $row['fname'],
                'agency' => !empty($row['cagency']) ? $row['cagency'] : $row['pagency'],
                'address' => $row['address'],
                'date_created' => $row['date_created'],
                'control_no' => $row['control_no'],
                'ss_no' => $row['ss_no'],
                'status' => $row['status'],
                'color' => $color,
                'ac_address' => $row['ac_address'],
                'app_type' => $row['app_type'],
                'token' => $row['token'],
                'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
            ];    
        }

        return $data;

    }
    
    public function getNotifDetailsClients($status)
    {
        $sql = "SELECT 
        ac.id as id,
        ai.CMLGOO_NAME as fname,
        ui.GOV_AGENCY_NAME as agency,
        ui.ADDRESS as address,
        DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
        ui.id as userid,
        ac.control_no as control_no,
        ac.safety_seal_no as ss_no,
        ac.status as status,
        ac.address as ac_address,
        ac.application_type as app_type,
        ac.token as token,
        ac.sms_sending_status as sms_sending_status,
        ac.email_sending_status as email_sending_status,
        ac.pnp_sending_status as pnp_sending_status,
        ac.bfp_sending_status as bfp_sending_status
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        WHERE  ac.status = '".$status."'";

     
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($query)) {
            $color = 'green';
            if ($row['status'] == 'For Receiving') {
                $color = 'primary';
            } elseif ($row['status'] == 'Received') {
                $color = 'yellow';
            } elseif ($row['status'] == 'Disapproved') {
                $color = 'red';
            }

            $data[$row['id']] = [
                'id' => $row['id'],
                'userid' => $row['userid'],
                'fname' => $row['fname'],
                'agency' => $row['agency'],
                'address' => $row['address'],
                'date_created' => $row['date_created'],
                'control_no' => $row['control_no'],
                'ss_no' => $row['ss_no'],
                'status' => $row['status'],
                'color' => $color,
                'ac_address' => $row['ac_address'],
                'app_type' => $row['app_type'],
                'token' => $row['token'],
                'sms_sending_status' => $row['sms_sending_status'],
                'email_sending_status' => $row['email_sending_status'],
                'pnp_sending_status' => $row['pnp_sending_status'],
                'bfp_sending_status' => $row['bfp_sending_status']
            ];    
        }
        return $data;
    }
    // reupload
    public function getAllApplicationLists()
    {
        $sql = "SELECT ac.id as id, ai.CMLGOO_NAME as fname, ui.GOV_AGENCY_NAME as agency, ui.ADDRESS as address, DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created, DATE_FORMAT(ac.date_approved, '%Y-%m-%d') as date_approved, ui.id as userid, ac.control_no as control_no, ac.safety_seal_no as ss_no, ac.status as status, ac.address as ac_address, ac.application_type as app_type, ac.token as token, tp.name as province
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        LEFT JOIN tbl_province tp on tp.id = ai.PROVINCE
        ORDER BY ai.PROVINCE";


        $query = mysqli_query($this->conn, $sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($query)) {
            $color = 'green';
            if ($row['status'] == 'For Receiving') {
                $color = 'primary';
            } elseif ($row['status'] == 'Received') {
                $color = 'yellow';
            } elseif ($row['status'] == 'Disapproved') {
                $color = 'red';
            } elseif ($row['status'] == 'Draft') {
                $color = 'secondary';
            }

            $data[$row['id']] = [
                'id' => $row['id'],
                'userid' => $row['userid'],
                'fname' => $row['fname'],
                'agency' => $row['agency'],
                'address' => $row['address'],
                'date_created' => $row['date_created'],
                'date_approved' => !empty($row['date_approved']) ? $row['date_approved'] : '',
                'control_no' => $row['control_no'],
                'ss_no' => $row['ss_no'],
                'status' => $row['status'],
                'color' => $color,
                'ac_address' => $row['ac_address'],
                'app_type' => $row['app_type'],
                'token' => $row['token'],
                'validity_date' => '',
                'province' => $row['province']
            ];    
        }

        return $data;
    }

    public function showAllApplications($province='',$timestamp, $status='')
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_app_checklist ac 
                LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
                LEFT JOIN tbl_province tp on tp.id = ai.PROVINCE 
                WHERE ac.date_created <= '".$timestamp."' AND ai.id IS NOT NULL";

        if (!empty($status)) {
            $sql.= " AND ac.status = '".$status."'";
        }

        if ($province == 'huc') {
            $sql.= " AND tp.id = 5 OR tp.id = 8";
        } elseif (!empty($province)) {
            $sql.= " AND tp.id = ".$province."";
        }

        $query = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_array($query);

        return $row['total'];
    }

    public function getValidationLists($appid) {
        $sql = "SELECT * FROM tbl_app_checklist_onsitevalidations where chklist_id = $appid";
        $query = mysqli_query($this->conn, $sql);
           
        $result = mysqli_fetch_array($query);
        
        return $result; 
    }

   

    public function insertAssessment($id, $assessment) {
        $sql = "UPDATE tbl_app_checklist_entry SET assessment = '".$assessment."' WHERE id = ".$id."";
        $query = mysqli_query($this->conn, $sql);
         
        return $query; 
    }

    public function evaluateChecklist($checklist_id, $status, $safety_seal_no, $date_modified, $approver)
    {
        $sql = "UPDATE tbl_app_checklist SET safety_seal_no = '".$safety_seal_no."', date_approved = '".$date_modified."', date_modified = '".$date_modified."', approver_id = ".$approver.", status = '".$status."' WHERE id = ".$checklist_id."";
        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function generateCode($user) 
    {
        $sql = "SELECT p.code as pcode, m.code as mcode
        FROM tbl_admin_info u
        LEFT JOIN tbl_province p on p.id = u.PROVINCE
        LEFT JOIN tbl_citymun m on m.id = u.LGU
        WHERE u.ID = ".$user."";

        $query = mysqli_query($this->conn, $sql);
        $result1 = mysqli_fetch_array($query);

        $ccode = 'R4A-'.$result1['pcode'].'-'.$result1['mcode'];
        // $ccode = '2021';


        $sql = "SELECT counter, id FROM tbl_config WHERE code = '".$ccode."'";
        $query = mysqli_query($this->conn, $sql);
        $result2 = mysqli_fetch_array($query);

        $cc = $result2['counter'] + 1;

        if ($cc > 9999) {
            $new_counter = $cc;
        } elseif ($cc > 999) {
            $new_counter = '0'.$cc;
        } elseif ($cc < 10) {
            $new_counter = '0000'.$cc;
        } elseif ($cc < 99) {
            $new_counter = '000'.$cc;
        } elseif ($cc > 99 AND $cc <= 999) {
            $new_counter = '00'.$cc;
        }

        $sql = "UPDATE tbl_config SET counter = '".$new_counter."' WHERE id = ".$result2['id']."";
        $result = mysqli_query($this->conn, $sql);

        $control_no = $ccode.'-'.$new_counter;
       
        return $control_no;
    }

    public function generateControlNumber($user)
    {
        $ccode = '2021';
        $sql = "SELECT counter, id FROM tbl_config WHERE code = '" . $ccode . "'";
        $query = mysqli_query($this->conn, $sql);
        $result = mysqli_fetch_array($query);

        $cc = $result['counter'];
        
        if ($cc > 9999) {
            $new_counter = $cc;
        } elseif ($cc > 999) {
            $new_counter = '0' . $cc;
        } elseif ($cc < 10) {
            $new_counter = '0000' . $cc;
        } elseif ($cc < 99) {
            $new_counter = '000' . $cc;
        } elseif ($cc > 99 and $cc <= 999) {
            $new_counter = '00' . $cc;
        }

        $cc = $cc + 1;

        $sql = "UPDATE tbl_config SET counter = '" . $cc . "' WHERE id = " . $result['id'] . "";
        $result = mysqli_query($this->conn, $sql);

        $control_no = $ccode . '-' . $new_counter;

        return $control_no;
    }

    public function getChecklistOrder($pointer) 
    {
        $id = '';
        switch ($pointer) {
            case 'CL1':
                $id = '1ZzfOg9Lhem47BDEr8VdfL07hlfmEok9F';
                break;
            case 'CL2':
                $id = '1grbCqIy51mWyURe8E4BISnXVQ3ReSveA';
                break;
            case 'CL3':
                $id = '1vjnseA-lxfzM2aE_xQnWJv87jvapYwUz';
                break;
            case 'CL4':
                $id = '1-UmqGMmyzaQAOjJ0yRmZzf-3M5uOV7JQ';
                break;
            case 'CL5':
                $id = '1xdHYJhoPXIRe7MnoHj3HPSGkFfugjpcG';
                break;
            case 'CL6':
                $id = '1JmGwP6U6Sqk1zV8QauBy9GRAMI61_ujC';
                break;
            case 'CL7':
                $id = '1VGENErXJ7VO2zS94NqFQE781WTlqwnql';
                break;
            case 'CL8':
                $id = '1SfQ44AZn3SIBfSa_QNUudePTB15etqWM';
                break;
            case 'CL9':
                $id = '1e3-ZvGOWeiOtV2oSbk93_OcTQK3ncu_e';
                break;
            case 'CL10':
                $id = '1J0EUlJnzrD_esbbxrYkGComWBE2PKfS_';
                break;
            case 'CL11':
                $id = '1vuQvP64MDKsN5NTC1gOm78l09_enmfuq';
                break;
            case 'CL12':
                $id = '1ubdhb0vil9J-n5USbyUUqOV0uGoTtpCc';
                break;
            case 'CL13':
                $id = '1rEub2gfLXJmkfzhnSzo-OhEt2DIUFqjK';
                break;
            case 'CL14':
                $id = '1qDFdbB4Ju9CQ7yE673dNdb5GL46IT4Yh';
                break;
            default:
                // code...
                break;
        }

        return $id;
    }

    public function getCertChecklists() 
    {
        $sql = "SELECT id FROM tbl_app_certchecklist";
        $query = mysqli_query($this->conn, $sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $data[$row['id']] = $row['id'];    
        }
        
        return $data;    
    }
    function getStatus($conn, $id,$cn) {
        $sql = "SELECT status,safety_seal_no FROM tbl_app_checklist where user_id = $id and control_no = '$cn'";
        $query = mysqli_query($conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = [
                'status' =>$row['status'],
                'safety_seal_no' => $row['safety_seal_no']
            ];
        return $data;
    }
    }
    function getMessageInfoStatus($id) {
        $sql = "SELECT 
        ai.id as id,
        ui.GOV_ESTB_NAME as establishment, 
        ai.CMLGOO_NAME as fname,
        ui.MOBILE_NO as contact_details,
        cl.status as status,
        cl.safety_seal_no as ss_no,
        cl.control_no as control_no,
        cl.sms_sending_status as for_sending
        FROM tbl_admin_info ai
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        LEFT JOIN tbl_province p on p.id = ai.PROVINCE
        LEFT JOIN tbl_citymun m on m.id = ai.LGU
        LEFT JOIN tbl_app_checklist cl on ai.id = cl.user_id
        where cl.user_id = $id and cl.sms_sending_status = 1";

        $query = mysqli_query($this->conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = [
                'status' =>$row['status'],
                'control_no' => $row['control_no'],
                'safety_seal_no' => $row['ss_no'],
                'for_sending' => $row['sms_sending_status'],
                'contact_details' => $row['contact_details']
            ];
        return $data;
    }
    }
    public function getApplicantDetails($user)
    {
        $sql = "SELECT 
            ai.id as id,
            ui.ADDRESS as address,
            ui.GOV_AGENCY_NAME as agency,
            ui.GOV_ESTB_NAME as establishment, 
            ui.GOV_NATURE_NAME as nature,
            ui.EMAIL_ADDRESS as email,
            ai.CMLGOO_NAME as fname,
            p.code as pcode,
            m.code as mcode,
            ui.MOBILE_NO as contact_details,
            cl.id as acid,
            cl.status as status,
            cl.safety_seal_no as ss_no
            FROM tbl_admin_info ai
            LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
            LEFT JOIN tbl_province p on p.id = ai.PROVINCE
            LEFT JOIN tbl_citymun m on m.id = ai.LGU
            LEFT JOIN tbl_app_checklist cl on ai.id = cl.user_id
            WHERE ai.id = $user";

        $query = mysqli_query($this->conn, $sql);
        // $result = mysqli_fetch_array($query);
        $data = [];
        $today = new DateTime();
        $today = $today->format('F d, Y');

        while ($row = mysqli_fetch_assoc($query)) {
            $data = [
                'id' => $row['id'],
                'acid' => $row['acid'],
                'date_created' => $today,
                'address' => $row['address'],
                'agency' => $row['agency'],
                'establishment' => $row['establishment'],
                'nature' => $row['nature'],
                'fname' => $row['fname'],
                'contact_details' => $row['contact_details'],
                'status' => 'Draft',
                'pcode' => $row['pcode'],
                'mcode' => $row['mcode'],
                'code' => '2021-'.'_____',
                'date_proceed' => '',
                'status' => !empty($row['status']) ? $row['status'] : 'Draft',
                'safetyseal_no' => $row['ss_no']
            ];      
        }

        return $data;
    }

    public function getApproverDetails($province,$lgu)
    {
        $sql = "SELECT 
        ui.EMAIL_ADDRESS as email,
        ai.CMLGOO_NAME as fname,
        ui.MOBILE_NO as contact_details
        FROM tbl_admin_info ai
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        WHERE ai.PROVINCE = '$province' AND ai.LGU = '$lgu' and ai.ROLES = 'admin'";
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($query)) {
            $data = [
                'email' => $row['email'],
                'fname' => $row['fname'],
                'mobile_no' => $row['contact_details']
            ];   
        }
            return $data;
    }

}