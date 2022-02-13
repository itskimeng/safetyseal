<?php
date_default_timezone_set('Asia/Manila');

class ApplicationManager extends Connection
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
    const STATUS_FOR_RENEWAL        = "For Renewal";
    const STATUS_RENEWED            = "Renewed";
    const STATUS_RETURNED           = "Returned";
    const STATUS_REVOKED            = "Revoked";
    const TYPE_APPLIED              = "Applied";
    const TYPE_ENCODED              = "Encoded";
    

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

    public function getChecklists()
    {
        $sql = "SELECT id, requirement, description FROM tbl_app_certchecklist";
        $getQry = $this->db->query($sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($getQry)) {
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
        $sql = "SELECT 
                id, 
                control_no, 
                for_renewal, 
                DATE_FORMAT('%Y-%m-%d', date_approved) as date_approved, 
                renew_count,
                agency,
                establishment,
                nature,
                address,
                contact_details,
                safety_seal_no,
                lgu,
                person 
                FROM tbl_app_checklist WHERE token = '".$token."'";

        $getQry = $this->db->query($sql);
        $result = mysqli_fetch_assoc($getQry);

        return $result;
    }

    public function insertChecklist($control_no, $establishment, $nature, $address, $userid, $date_created, $token)
    {
        $sql = 'INSERT INTO tbl_app_checklist (control_no, establishment, nature, address, user_id, date_created, token) VALUES ("'.$control_no.'", "'.$establishment.'", "'.$nature.'", "'.$address.'", '.$userid.', "'.$date_created.'", "'.$token.'")';

        $result = $this->db->query($sql);
        $last_id = mysqli_insert_id($this->db);

        return $last_id;
    }


    public function insertChecklist2($control_no, $establishment, $nature, $address, $userid, $date_created, $token, $ss_no)
    {
        $sql = 'INSERT INTO tbl_app_checklist (control_no, establishment, nature, address, user_id, date_created, token, for_renewal, status, safety_seal_no) VALUES ("'.$control_no.'", "'.$establishment.'", "'.$nature.'", "'.$address.'", '.$userid.', "'.$date_created.'", "'.$token.'", true, "For Renewal", "'.$ss_no.'")';

        $result = $this->db->query($sql);
        $last_id = mysqli_insert_id($this->db);

        return $last_id;
    }

    public function updateChecklist($token, $establishment, $nature, $address, $date_modified)
    {
        $sql = "UPDATE tbl_app_checklist SET date_modified = '".$date_modified."', establishment = '".$establishment."', nature = '".$nature."', address = '".$address."' WHERE token = '".$token."'";
        $result = $this->db->query($sql);

        return $result;
    }

    public function insertChecklistEntry($data)
    {
        $sql = 'INSERT INTO tbl_app_checklist_entry (parent_id, chklist_id, answer, reason, date_created) VALUES ('.$data["parent_id"].', '.$data["chklist_id"].', "'.$data["answer"].'", "'.$data["reason"].'", "'.$data["date_created"].'")';
        $result = $this->db->query($sql);

        return $result;
    }

    public function notifyApprover($province, $lgu){
        $sql = "SELECT `PROVINCE`, `LGU`, `EMAIL`, ui.MOBILE_NO, ai.ROLES AS roles FROM `tbl_admin_info` ai
        left join tbl_userinfo ui on ai.ID = ui.USER_ID
        WHERE PROVINCE = '".$province."' and LGU = '".$lgu."' and roles = 'admin'";
       
        $data = [];
        $getQry = $this->db->query($sql);

        while ($row = mysqli_fetch_assoc($getQry)) {        
            $data[] = [
                'email' => $row['EMAIL'],
                'mobile' => $row['MOBILE_NO']
            ];
        }
            return $data;

    }

    public function updateChecklistEntry($data, $table)
    {
        $sql = "UPDATE $table SET tracing_tool = '".$data['tracing_tool']."', other_tool = '".$data['other_tool']."', answer = '".$data['answer']."', reason = '".$data['reason']."' WHERE id = ".$data['chklist_id']."";
        $result = $this->db->query($sql);

        return $result;
    }

    public function getUserChecklistsEntry($token, $table)
    {
        $sql = "SELECT 
            c.id as clist_id,  
            c.requirement as requirement,
            c.description as description,
            e.id as ulist_id,
            e.answer as answer,
            e.reason as reason,
            e.assessment as assessment,
            e.other_tool as other_tool,
            a.status as status,
            e.tracing_tool as tracing_tool,
            e.chklist_id as chklist_id
            FROM $table e
            LEFT JOIN tbl_app_checklist a on a.id = e.parent_id
            LEFT JOIN tbl_app_certchecklist c on c.id = e.chklist_id
            LEFT JOIN tbl_admin_info ai on ai.id = a.user_id
            WHERE a.token = '".$token."'";

        $getQry = $this->db->query($sql);
        $data = [];

        $is_disabled = true;
        
        while ($row = mysqli_fetch_assoc($getQry)) {
            if (in_array($row['status'], array('Draft', 'Disapproved', 'Reassess', 'For Renewal'))) {
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
                'otherTool_disabled' => empty($row['answer']) OR $row['answer'] == 'other' ? false : true,
                'tracing_tool' => $row['tracing_tool']
            ];    
        }

        return $data;
    }

    public function getUserChecklistsAttachments($token, $for_renewal)
    {
        $sql = "SELECT 
            e.id as eid,
            ca.id as caid,
            ca.file_name as file_name
            FROM tbl_app_checklist_attachments ca ";

        // if ($for_renewal) {
        //     $sql .= " LEFT JOIN tbl_app_checklist_renewal_entry e on e.id = ca.renewal_id";
        // } else {
            $sql .= " LEFT JOIN tbl_app_checklist_entry e on e.id = ca.entry_id";
        // }    
        
        $sql .= " LEFT JOIN tbl_app_checklist a on a.id = e.parent_id WHERE a.token = '".$token."'";

        $getQry = $this->db->query($sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($getQry)) {
            $data[$row['eid']][] = [
                'eid' => $row['eid'],
                'caid' => $row['caid'],
                'file_name' => $row['file_name']
            ];    
        }

        return $data;
    }

    public function getUserChecklistsAttachmentsYES($token, $for_renewal=false)
    {
        $sql = "SELECT 
            e.id as eid,
            ca.id as caid,
            ca.file_name as file_name
            FROM tbl_app_checklist_attachments ca ";

        if ($for_renewal) {
            $sql .= " LEFT JOIN tbl_app_checklist_renewal_entry e on e.id = ca.renewal_id";
        } else {
            $sql .= " LEFT JOIN tbl_app_checklist_entry e on e.id = ca.entry_id";
        }    
        
        $sql .= " LEFT JOIN tbl_app_checklist a on a.id = e.parent_id WHERE e.answer = 'yes' AND a.id = '".$token."'";

        $getQry = $this->db->query($sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($getQry)) {
            $data[$row['eid']][] = [
                'eid' => $row['eid'],
                'caid' => $row['caid'],
                'file_name' => $row['file_name']
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

        $getQry = $this->db->query($sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($getQry)) {
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
            DATE_FORMAT(ac.date_approved, '%Y-%m-%d %h:%i %p') as date_approved,
            DATE_FORMAT(ac.date_renewed, '%Y-%m-%d %h:%i %p') as date_renewed,
            DATE_FORMAT(ac.date_approved, '%b %d, %Y') as date_issued,
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
            ac.address as address,
            aco.defects as defects,
            aco.recommendations as recommendations,
            ac.remarks as remarks,
            ac.token as token,
            ac.for_renewal as for_renewal,
            ac.safety_seal_no as ssc_no,
            ac.renew_count
            FROM tbl_app_checklist ac
            LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
            LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
            LEFT JOIN tbl_province p on p.id = ai.PROVINCE
            LEFT JOIN tbl_citymun m on m.id = ai.LGU
            LEFT JOIN tbl_app_checklist_onsitevalidations aco on aco.chklist_id = ac.id
            WHERE ac.token = '".$token."'";
        
        $getQry = $this->db->query($sql);
        $data = [];
        // $today = new DateTime();
        // $today = $today->format('F d, Y');

        $date_today = new DateTime();
        $date_today = date('Y-m-d', strtotime($date_today->format('Y-m-d')));

        while ($row = mysqli_fetch_assoc($getQry)) {
            $date_created = $row['date_created'];
            if (empty($date_created)) {
                $date_created = $today;
            }

            if (($row['status'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
            } else {
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
            }

            if (($row['status'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
            } else {
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
            }

            $date1 = date_create($date_today);
            $date2 = date_create($date_validity);
            $interval = $date1->diff($date2);
            
            $status = $row['status'];
            if (!empty($row['date_approved'])) {
                if ($row['status'] == 'For Renewal') {
                    $status = $row['status'];
                } elseif ($date_today >= $date_validity) {
                    $status = 'Expired';
                }
            }

            $data = [
                'id'                => $row['id'],
                'acid'              => $row['acid'],
                'date_created'      => $date_created,
                'address'           => $row['address'],
                'agency'            => $row['agency'],
                'establishment'     => $row['establishment2'],
                'nature'            => $row['nature'],
                'fname'             => $row['fname'],
                'contact_details'   => $row['contact_details'],
                // 'status'            => !empty($row['status']) ? $row['status'] : 'Draft',
                // 'status'            => $date_today >= $date_validity ? 'Expired' : $row['ac_status'],
                'status'            => $status,
                'pcode'             => $row['pcode'],
                'mcode'             => $row['mcode'],
                'defects'           => $row['defects'],
                'recommendations'   => $row['recommendations'],
                'code'              => !empty($row['control_no']) ? $row['control_no'] : '2021-'.'_____',
                'date_proceed'      => $row['date_proceed'],
                'remarks'           => $row['remarks'],
                'token'             => $row['token'],
                'for_renewal'       => $row['for_renewal'],
                'ssc_no'            => $row['ssc_no'],
                'renew_count'       => $row['renew_count']
            ];      
        }

        return $data;
    }


    public function setUserApplicationDate($user, $date)
    {
        $sql = "UPDATE tbl_userinfo SET DATE_APPLICATION_CREATED = '".$date."' WHERE id = ".$user."";
        $result = $this->db->query($sql);

        return $result; 
    }

    public function proceedChecklist($checklist_id, $contact_details, $has_consent, $status, $date_modified)
    {
        $sql = "UPDATE tbl_app_checklist SET contact_details = '".$contact_details."', date_proceed = '".$date_modified."', date_modified = '".$date_modified."', has_consent = '".$has_consent."', sms_sending_status = '1',email_sending_status = '1',pnp_sending_status = '1',bfp_sending_status = '1', status = '".$status."' WHERE id = ".$checklist_id."";
        $result = $this->db->query($sql);

        return $result;
    }

    public function reassessChecklist($user, $token, $status, $date_modified)
    {
        $sql = "UPDATE tbl_app_checklist SET reassessed_by = ".$user.", date_reassessed = '".$date_modified."', date_modified = '".$date_modified."', status = '".$status."' WHERE token = '".$token."'";
        $result = $this->db->query($sql);

        return $result;
    }

    public function receiveChecklist($checklist_id, $status, $date_modified, $receiver, $remarks='')
    {
        $sql = "UPDATE tbl_app_checklist SET date_received = '".$date_modified."', date_modified = '".$date_modified."', receiver_id = ".$receiver.", status = '".$status."' WHERE id = ".$checklist_id."";
        $result = $this->db->query($sql);

        return $result;
    }

    public function returnChecklist($checklist_id, $status, $date_modified, $receiver, $remarks='')
    {
        $sql = "UPDATE tbl_app_checklist SET date_returned = '".$date_modified."', date_modified = '".$date_modified."', status = '".$status."', undoer = '".$receiver."', remarks = '".$remarks."' WHERE id = ".$checklist_id."";
        $result = $this->db->query($sql);

        return $result;
    }

    public function insertValidationChecklist($appid, $defects, $receommendations, $date_created)
    {
        $sql = 'INSERT INTO tbl_app_checklist_onsitevalidations (chklist_id, defects, recommendations) VALUES ("'.$appid.'", "'.$defects.'", "'.$receommendations.'")';
        $result = $this->db->query($sql);

        return $result;
    }


    public function updateValidationChecklist($checklist_id, $defects, $recommendations, $date_modified)
    {
        $sql = 'UPDATE tbl_app_checklist_onsitevalidations SET defects = "'.utf8_encode($defects).'", recommendations = "'.utf8_encode($recommendations).'", date_modified = "'.$date_modified.'" WHERE chklist_id = '.$checklist_id.'';
        $result = $this->db->query($sql);

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
        
        $getQry = $this->db->query($sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($getQry)) {
            $data[$row['id']] = [
                'code' => $row['code'],
                'name' => $row['name']
            ];    
        }

        return $data;
    }

    public function getCityMuns($province)
    {
        mysqli_set_charset($this->db, "utf8");
        $sql = "SELECT id, province, code, name FROM tbl_citymun where province  = $province";
        
        $getQry = $this->db->query($sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($getQry)) {
            $data[$row['id']] = [
                'province' => $row['province'],
                'code' => $row['code'],
                'name' => $row['name']
            ];    
           
        }

        return $data;
    }

    public function getCityMuns2()
    {
        $sql = "SELECT id, province, code, name FROM tbl_citymun";
        
        $getQry = $this->db->query($sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($getQry)) {
            $data[$row['province']][$row['id']] = [
                'province' => $row['province'],
                'id' => $row['id'],
                'code' => $row['code'],
                'name' => $row['name']
            ];    
           
        }

        return $data;
    }

    public function getUserApplications($province, $lgu, $status)
    {
        $date_today = new DateTime();
        $date_today = date('Y-m-d', strtotime($date_today->format('Y-m-d')));
        $data = [];
        
        $sql = "SELECT * FROM (
                    SELECT 
                    ac.id AS id,
                    ai.CMLGOO_NAME AS fname,
                    ui.GOV_AGENCY_NAME AS agency,
                    ui.ADDRESS AS address,
                    DATE_FORMAT(ac.date_created, '%Y-%m-%d') AS date_created,
                    ac.date_created AS date_createds,
                    DATE_FORMAT(ac.date_approved, '%Y-%m-%d') AS date_approved,
                    ui.id AS userid,
                    ai.id AS aid,
                    ac.control_no AS control_no,
                    ac.safety_seal_no AS ss_no,
                    ac.status AS stats,
                    ac.address AS ac_address,
                    ac.application_type AS app_type,
                    ac.token AS token,
                    ac.for_renewal AS for_renewal
                    FROM tbl_app_checklist ac
                    LEFT JOIN tbl_admin_info ai ON ai.id = ac.user_id
                    LEFT JOIN tbl_userinfo ui ON ui.user_id = ai.id
                    WHERE ai.PROVINCE = 2 AND ai.LGU = 03 AND ac.application_type = 'Applied' AND ac.status <> 'Draft' AND ac.status <> 'Returned' AND ac.status <> 'Reassess' 
                    ORDER BY ai.id, ac.id DESC 
                    LIMIT 18446744073709551615
                ) AS subqry
                GROUP BY aid";

        $getQry = $this->db->query($sql);
        
        while ($row = mysqli_fetch_assoc($getQry)) {
            $color = 'green';
            if (($row['stats'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
            } else {
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
            }

            $date1 = date_create($date_today);
            $date2 = date_create($date_validity);
            $interval = $date1->diff($date2);
            
            $status = $row['stats'];
            if (!empty($row['date_approved'])) {
                if ($row['stats'] == 'For Renewal') {
                    $status = $row['stats'];
                } elseif ($date_today >= $date_validity) {
                    $status = 'Expired';
                }
            }

            if ($status == 'For Receiving') {
                $color = 'primary';
            } elseif ($status == 'Received') {
                $color = 'yellow';
            } elseif (in_array($status, ['Disapproved', 'Expired'])) {
                $color = 'red';
            }

            $data[$row['id']] = [
                'id'            => $row['id'],
                'userid'        => $row['userid'],
                'fname'         => $row['fname'],
                'agency'        => $row['agency'],
                'address'       => $row['address'],
                'date_created'  => date('M d, Y', strtotime($row['date_created'])),
                'control_no'    => $row['control_no'],
                'ss_no'         => $row['ss_no'],
                'status'        => $status,
                'color'         => $color,
                'ac_address'    => $row['ac_address'],
                'app_type'      => $row['app_type'],
                'token'         => $row['token'],
                'for_renewal'   => $row['for_renewal'],
                'issued_date'   => date('M d, Y', strtotime($row['date_approved'])),
                'validity_date' => $date_validity_f
            ];    
        }

        $sql2 = "SELECT * FROM (
                    SELECT 
                    ac.id as id,
                    ai.CMLGOO_NAME as fname,
                    ui.GOV_AGENCY_NAME as pagency,
                    ac.agency as cagency,
                    ui.ADDRESS as address,
                    DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
                    DATE_FORMAT(ac.date_approved, '%Y-%m-%d') as date_approved,
                    ui.id as userid,
                    ai.id AS aid,
                    ac.control_no as control_no,
                    ac.safety_seal_no as ss_no,
                    ac.status as stats,
                    ac.address as ac_address,
                    ac.application_type as app_type,
                    ac.token as token,
                    ac.person as person,
                    ac.for_renewal as for_renewal
                    FROM tbl_app_checklist ac
                    LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
                    LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
                    WHERE ai.PROVINCE = ".$province." AND ai.LGU = ".$lgu." AND ac.application_type = 'Encoded'
                    ORDER BY ac.person, ac.id DESC 
                    LIMIT 18446744073709551615
                ) AS subqry
                GROUP BY person";

        $getQry = $this->db->query($sql2);

        while ($row = mysqli_fetch_assoc($getQry)) {
            $color = 'green';

            if (($row['stats'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
            } else {
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
            }

            $date1 = date_create($date_today);
            $date2 = date_create($date_validity);
            $interval = $date1->diff($date2);
            
            $status = $row['stats'];
            if (!empty($row['date_approved'])) {
                if ($row['stats'] == 'For Renewal') {
                    $status = $row['stats'];
                } elseif ($date_today >= $date_validity) {
                    $status = 'Expired';
                }
            }

            if ($status == 'For Receiving') {
                $color = 'primary';
            } elseif ($status == 'Received') {
                $color = 'yellow';
            } elseif (in_array($status, ['Disapproved', 'Expired'])) {
                $color = 'red';
            }

            $data[$row['id']] = [
                'id'            => $row['id'],
                'userid'        => $row['userid'],
                'fname'         => !empty($row['person']) ? $row['person'] : $row['fname'],
                'agency'        => !empty($row['cagency']) ? $row['cagency'] : $row['pagency'],
                'address'       => $row['address'],
                'date_created'  => date('M d, Y', strtotime($row['date_created'])),
                'control_no'    => $row['control_no'],
                'ss_no'         => $row['ss_no'],
                'status'        => $status,
                'color'         => $color,
                'ac_address'    => $row['ac_address'],
                'app_type'      => $row['app_type'],
                'token'         => $row['token'],
                'issued_date'   => date('M d, Y', strtotime($row['date_approved'])),
                'validity_date' => $date_validity_f,
                'for_renewal'   => $row['for_renewal']
            ];    
        }

        $sql3 = "SELECT * FROM (
                    SELECT 
                    ac.id as id,
                    ai.CMLGOO_NAME as fname,
                    ui.GOV_AGENCY_NAME as pagency,
                    ac.agency as cagency,
                    ui.ADDRESS as address,
                    DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
                    DATE_FORMAT(ac.date_approved, '%Y-%m-%d') as date_approved,
                    ui.id as userid,
                    ai.id AS aid,
                    ac.control_no as control_no,
                    ac.safety_seal_no as ss_no,
                    ac.status as stats,
                    ac.address as ac_address,
                    ac.application_type as app_type,
                    ac.token as token,
                    ac.person as person,
                    ac.for_renewal as for_renewal
                    FROM tbl_app_checklist ac
                    LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
                    LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
                    WHERE ai.PROVINCE = ".$province." AND ac.lgu = ".$lgu." AND ac.application_type = 'Encoded'
                    ORDER BY ac.person, ac.id DESC 
                    LIMIT 18446744073709551615
                ) AS subqry
                GROUP BY person";
        $getQry = $this->db->query($sql3);

        while ($row = mysqli_fetch_assoc($getQry)) {
            $color = 'green';

            if (($row['stats'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
            } else {
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
            }

            $date1 = date_create($date_today);
            $date2 = date_create($date_validity);
            $interval = $date1->diff($date2);
            
            $status = $row['stats'];
            if (!empty($row['date_approved'])) {
                if ($row['stats'] == 'For Renewal') {
                    $status = $row['stats'];
                } elseif ($date_today >= $date_validity) {
                    $status = 'Expired';
                }
            }


            if ($status == 'For Receiving') {
                $color = 'primary';
            } elseif ($status == 'Received') {
                $color = 'yellow';
            } elseif (in_array($status, ['Disapproved', 'Expired'])) {
                $color = 'red';
            }

            $data[$row['id']] = [
                'id'            => $row['id'],
                'userid'        => $row['userid'],
                'fname'         => !empty($row['person']) ? $row['person'] : $row['fname'],
                'agency'        => !empty($row['cagency']) ? $row['cagency'] : $row['pagency'],
                'address'       => $row['address'],
                'date_created'  => date('M d, Y', strtotime($row['date_created'])),
                'control_no'    => $row['control_no'],
                'ss_no'         => $row['ss_no'],
                'status'        => $status,
                'color'         => $color,
                'ac_address'    => $row['ac_address'],
                'app_type'      => $row['app_type'],
                'token'         => $row['token'],
                'issued_date'   => date('M d, Y', strtotime($row['date_approved'])),
                'validity_date' => $date_validity_f,
                'for_renewal'   => $row['for_renewal']
            ];    
        }

        return $data;

    }

    public function getApplicationLists($province, $lgu, $status)
    {

        $date_today = new DateTime();
        $date_today = date('Y-m-d', strtotime($date_today->format('Y-m-d')));

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
        ac.token as token,
        ac.for_renewal as for_renewal
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        WHERE ai.PROVINCE = ".$province." AND ai.LGU = ".$lgu." AND ac.application_type = 'Applied' AND ac.status <> '".$status."' AND ac.status <> 'Returned' AND ac.status <> 'Reassess'";
     
        $getQry = $this->db->query($sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($getQry)) {
            $color = 'green';
            // if ($row['status'] == 'For Receiving' OR $row['status'] == 'For Reassessment') {
            //     $color = 'primary';
            // } elseif ($row['status'] == 'Received') {
            //     $color = 'yellow';
            // } elseif (in_array($row['status'], ['Disapproved', 'Revoked', 'Expired'])) {
            //     $color = 'red';
            // }
            
            // $validity = '';

            // if (!empty($row['date_approved'])) {
            //     if ($row['status'] =='Approved' OR $row['status'] == 'Renewed' OR $row['status'] == 'Expired') {
            //         $validity = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
            //     }
            // 

            if (($row['status'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
            } else {
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
            }

            $date1 = date_create($date_today);
            $date2 = date_create($date_validity);
            $interval = $date1->diff($date2);
            
            $status = $row['status'];
            if (!empty($row['date_approved'])) {
                if ($row['status'] == 'For Renewal') {
                    $status = $row['status'];
                } elseif ($date_today >= $date_validity) {
                    $status = 'Expired';
                }
            }

            if ($status == 'For Receiving') {
                $color = 'primary';
            } elseif ($status == 'Received') {
                $color = 'yellow';
            } elseif (in_array($status, ['Disapproved', 'Expired'])) {
                $color = 'red';
            }

            $data[$row['id']] = [
                'id'            => $row['id'],
                'userid'        => $row['userid'],
                'fname'         => $row['fname'],
                'agency'        => $row['agency'],
                'address'       => $row['address'],
                'date_created'  => date('M d, Y', strtotime($row['date_created'])),
                'control_no'    => $row['control_no'],
                'ss_no'         => $row['ss_no'],
                'status'        => $status,
                'color'         => $color,
                'ac_address'    => $row['ac_address'],
                'app_type'      => $row['app_type'],
                'token'         => $row['token'],
                'for_renewal'   => $row['for_renewal'],
                'issued_date'   => date('M d, Y', strtotime($row['date_approved'])),
                'validity_date' => $date_validity_f,
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
        ac.token as token,
        ac.person as person,
        ac.for_renewal as for_renewal
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        WHERE ai.PROVINCE = ".$province." AND ai.LGU = ".$lgu." AND ac.application_type = 'Encoded'";
     
        $getQry = $this->db->query($sql2);

        // $data = [];
        
        while ($row = mysqli_fetch_assoc($getQry)) {
            $color = 'green';
            // if ($row['status'] == 'For Receiving') {
            //     $color = 'primary';
            // } elseif ($row['status'] == 'Received') {
            //     $color = 'yellow';
            // } elseif ($row['status'] == 'Disapproved') {
            //     $color = 'red';
            // }

            // $validity = '';

            // if (!empty($row['date_approved'])) {
            //     if($row['status'] =='Approved' OR $row['for_renewal']){
            //         $validity = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
            //     }
            // }

            if (($row['status'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
            } else {
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
            }

            $date1 = date_create($date_today);
            $date2 = date_create($date_validity);
            $interval = $date1->diff($date2);
            
            $status = $row['status'];
            if (!empty($row['date_approved'])) {
                if ($row['status'] == 'For Renewal') {
                    $status = $row['status'];
                } elseif ($date_today >= $date_validity) {
                    $status = 'Expired';
                }
            }

            if ($status == 'For Receiving') {
                $color = 'primary';
            } elseif ($status == 'Received') {
                $color = 'yellow';
            } elseif (in_array($status, ['Disapproved', 'Expired'])) {
                $color = 'red';
            }

            $data[$row['id']] = [
                'id'            => $row['id'],
                'userid'        => $row['userid'],
                'fname'         => !empty($row['person']) ? $row['person'] : $row['fname'],
                'agency'        => !empty($row['cagency']) ? $row['cagency'] : $row['pagency'],
                'address'       => $row['address'],
                'date_created'  => date('M d, Y', strtotime($row['date_created'])),
                'control_no'    => $row['control_no'],
                'ss_no'         => $row['ss_no'],
                'status'        => $status,
                'color'         => $color,
                'ac_address'    => $row['ac_address'],
                'app_type'      => $row['app_type'],
                'token'         => $row['token'],
                'issued_date'   => date('M d, Y', strtotime($row['date_approved'])),
                'validity_date' => $date_validity_f,
                'for_renewal'   => $row['for_renewal']
            ];    
        }

        $sql3 = "SELECT 
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
        ac.token as token,
        ac.person as person,
        ac.for_renewal as for_renewal
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        WHERE ai.PROVINCE = ".$province." AND ac.lgu = ".$lgu." AND ac.application_type = 'Encoded'";
     
        $getQry = $this->db->query($sql3);
        // $data = [];
        
        while ($row = mysqli_fetch_assoc($getQry)) {
            $color = 'green';
        
            // $validity = '';

            // if (!empty($row['date_approved'])) {
            //     if($row['status'] =='Approved' OR $row['for_renewal']){
            //         $validity = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
            //     }
            // }

            if (($row['status'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
            } else {
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
            }

            $date1 = date_create($date_today);
            $date2 = date_create($date_validity);
            $interval = $date1->diff($date2);
            
            $status = $row['status'];
            if (!empty($row['date_approved'])) {
                if ($row['status'] == 'For Renewal') {
                    $status = $row['status'];
                } elseif ($date_today >= $date_validity) {
                    $status = 'Expired';
                }
            }


            if ($status == 'For Receiving') {
                $color = 'primary';
            } elseif ($status == 'Received') {
                $color = 'yellow';
            } elseif (in_array($status, ['Disapproved', 'Expired'])) {
                $color = 'red';
            }

            $data[$row['id']] = [
                'id'            => $row['id'],
                'userid'        => $row['userid'],
                'fname'         => !empty($row['person']) ? $row['person'] : $row['fname'],
                'agency'        => !empty($row['cagency']) ? $row['cagency'] : $row['pagency'],
                'address'       => $row['address'],
                'date_created'  => date('M d, Y', strtotime($row['date_created'])),
                'control_no'    => $row['control_no'],
                'ss_no'         => $row['ss_no'],
                'status'        => $status,
                'color'         => $color,
                'ac_address'    => $row['ac_address'],
                'app_type'      => $row['app_type'],
                'token'         => $row['token'],
                'issued_date'   => date('M d, Y', strtotime($row['date_approved'])),
                'validity_date' => $date_validity_f,
                'for_renewal'   => $row['for_renewal']
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

     
        $getQry = $this->db->query($sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($getQry)) {
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
        $today = new DateTime();
        $date_today = $today->format('Y-m-d');

        $sql = "SELECT ac.id as id, ai.CMLGOO_NAME as fname, ui.GOV_AGENCY_NAME as agency, ui.ADDRESS as address, DATE_FORMAT(ac.date_created, '%b %d, %Y') as date_created, DATE_FORMAT(ac.date_approved, '%Y-%m-%d') as date_approved, ui.id as userid, ac.control_no as control_no, ac.safety_seal_no as ss_no, ac.status as stats, ac.address as ac_address, ac.application_type as app_type, ac.token as token, tp.name as province, ac.for_renewal, ac.person
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        LEFT JOIN tbl_province tp on tp.id = ai.PROVINCE
        ORDER BY ai.PROVINCE";

        $getQry = $this->db->query($sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($getQry)) {
            $color = 'green';
            // if ($row['status'] == 'For Receiving') {
            //     $color = 'primary';
            // } elseif ($row['status'] == 'Received') {
            //     $color = 'yellow';
            // } elseif ($row['status'] == 'Disapproved') {
            //     $color = 'red';
            // } elseif ($row['status'] == 'Draft') {
            //     $color = 'secondary';
            // }

            if (($row['stats'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
            } else {
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
            }

            $date1 = date_create($date_today);
            $date2 = date_create($date_validity);
            $interval = $date1->diff($date2);
            
            $status = $row['stats'];
            if (!empty($row['date_approved'])) {
                if ($row['stats'] == 'For Renewal') {
                    $status = $row['stats'];
                } elseif ($date_today >= $date_validity) {
                    $status = 'Expired';
                }
            }

            if ($status == 'For Receiving') {
                $color = 'primary';
            } elseif ($status == 'Received') {
                $color = 'yellow';
            } elseif (in_array($status, ['Disapproved', 'Expired', 'Returned'])) {
                $color = 'red';
            }

            $data[$row['id']] = [
                'id'                => $row['id'],
                'userid'            => $row['userid'],
                'fname'             => $row['app_type'] == 'Applied' ? $row['fname'] : $row['person'],
                'agency'            => $row['agency'],
                'address'           => $row['address'],
                'date_created'      => $row['date_created'],
                'date_approved'     => !empty($row['date_approved']) ? $row['date_approved'] : '',
                'control_no'        => $row['control_no'],
                'ss_no'             => $row['ss_no'],
                'status'            => $status,
                'color'             => $color,
                'ac_address'        => $row['ac_address'],
                'app_type'          => $row['app_type'],
                'token'             => $row['token'],
                'issued_date'       => date('M d, Y', strtotime($row['date_approved'])),
                'validity_date'     => $date_validity_f,
                'province'          => $row['province'],
                'for_renewal'       => $row['for_renewal']
            ];    
        }

        return $data;
    }

    public function showAllApplications($province='',$timestamp, $status='')
    {
        $sql = "SELECT count(*) as total FROM tbl_app_checklist ac 
                JOIN tbl_admin_info ai on ai.id = ac.user_id
                JOIN tbl_province tp on tp.id = ai.PROVINCE 
                JOIN tbl_citymun cm on cm.province = ai.PROVINCE AND cm.code = ai.LGU
                WHERE ac.date_created <= '".$timestamp."' AND ai.id IS NOT NULL AND tp.id IS NOT NULL";

        if (!empty($status)) {
            if ($status == 'Disapproved') {
                $sql.= " AND ac.status IN ('Reassess', 'Disapproved', 'Returned', 'For Reassessment')";
            } elseif ($status == 'Approved') {
                $sql.= " AND ac.status IN ('Approved')";
            } elseif ($status == 'Received') {
                $sql.= " AND ac.status IN ('Received', 'For Renewal')";
            } else {
                $sql.= " AND ac.status = '".$status."'";
            }
        } else {
            $sql.= " AND ac.status IN ('Received', 'Approved', 'Returned', 'For Reassessment', 'Reassess', 'Disapproved', 'Renewed', 'For Renewal')";
        }

        if ($province == 'huc') {
            $sql.= " AND tp.id IN (5, 8)";
        } elseif (!empty($province)) {
            $sql.= " AND tp.id = $province";
        }

        $getQry = $this->db->query($sql);
        $row = mysqli_fetch_array($getQry);

        return number_format($row['total']);
    }

    public function getValidationLists($appid) {
        $sql = "SELECT * FROM tbl_app_checklist_onsitevalidations where chklist_id = $appid";
        $getQry = $this->db->query($sql);   
        $result = mysqli_fetch_array($getQry);
        
        return $result; 
    }

    public function insertAssessment($id, $assessment, $for_renewal) 
    {
        $sql = "UPDATE tbl_app_checklist_entry SET assessment = '".$assessment."' WHERE id = ".$id."";
        $getQry = $this->db->query($sql);
         
        return $getQry; 
    }

    public function evaluateChecklist($checklist_id, $status, $safety_seal_no, $date_modified, $approver, $for_renewal=false, $is_new=true)
    {
        if ($for_renewal) {
            $sql = "UPDATE tbl_app_checklist SET date_modified = '".$date_modified."', approver_id = ".$approver.", status = '".$status."' WHERE id = ".$checklist_id."";
        } else {

            if ($is_new) {
                if ($status == 'Disapproved') {
                    $sql = "UPDATE tbl_app_checklist SET safety_seal_no = '".$safety_seal_no."', date_modified = '".$date_modified."', approver_id = ".$approver.", status = '".$status."' WHERE id = ".$checklist_id."";
                } else {
                    $sql = "UPDATE tbl_app_checklist SET safety_seal_no = '".$safety_seal_no."', date_approved = '".$date_modified."', date_modified = '".$date_modified."', approver_id = ".$approver.", status = '".$status."' WHERE id = ".$checklist_id."";
                }

            } else {
                $sql = "UPDATE tbl_app_checklist SET date_modified = '".$date_modified."', approver_id = ".$approver.", status = '".$status."' WHERE id = ".$checklist_id."";
            }
        }
        
        $result = $this->db->query($sql);

        return $result;
    }

    public function evaluateChecklist2($checklist_id, $status, $safety_seal_no, $date_modified, $approver, $for_renewal=false, $is_new=true)
    {
        
        $sql = "UPDATE tbl_app_checklist 
                SET date_modified = '".$date_modified."', 
                for_renewal = false, 
                date_renewed = '".$date_modified."',
                date_approved = '".$date_modified."',
                approver_id = ".$approver.", 
                status = 'Renewed' 
                WHERE id = ".$checklist_id."";
        $result = $this->db->query($sql);

        return $result;
    }

    public function generateCode($user) 
    {
        $sql = "SELECT p.code as pcode, m.code as mcode
        FROM tbl_admin_info u
        LEFT JOIN tbl_province p on p.id = u.PROVINCE
        LEFT JOIN tbl_citymun m on m.id = u.LGU
        WHERE u.ID = ".$user."";

        $getQry = $this->db->query($sql);
        $result1 = mysqli_fetch_array($getQry);

        $ccode = 'R4A-'.$result1['pcode'].'-'.$result1['mcode'];
        // $ccode = '2021';


        $sql = "SELECT counter, id FROM tbl_config WHERE code = '".$ccode."'";
        $getQry = $this->db->query($sql);
        $result2 = mysqli_fetch_array($getQry);

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
        $result = $this->db->query($sql);

        $control_no = $ccode.'-'.$new_counter;
       
        return $control_no;
    }

    public function generateControlNumber($user)
    {
        $ccode = date('Y');
        $sql = "SELECT counter, id FROM tbl_config WHERE code = '" . $ccode . "'";
        $getQry = $this->db->query($sql);
        $result = mysqli_fetch_array($getQry);

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
        $result = $this->db->query($sql);

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
        $getQry = $this->db->query($sql);

        $data = [];

        while ($row = mysqli_fetch_assoc($getQry)) {
            $data[$row['id']] = $row['id'];    
        }
        
        return $data;    
    }
    function getStatus($conn, $id,$cn) {
        $sql = "SELECT status,safety_seal_no FROM tbl_app_checklist where user_id = $id and control_no = '$cn'";
        $getQry = $this->db->query($sql);

        $data = [];
        while ($row = mysqli_fetch_assoc($getQry)) {
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

        $getQry = $this->db->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($getQry)) {
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
            ai.OFFICE as sub_office,  
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

        $getQry = $this->db->query($sql);

        // $result = mysqli_fetch_array($query);
        $data = [];
        $today = new DateTime();
        $today = $today->format('F d, Y');
        $yy = date('Y');

        while ($row = mysqli_fetch_assoc($getQry)) {
            $data = [
                'id'                => $row['id'],
                'acid'              => $row['acid'],
                'date_created'      => $today,
                'address'           => $row['address'],
                'agency'            => $row['agency'],
                'establishment'     => $row['sub_office'],
                'nature'            => $row['nature'],
                'fname'             => $row['fname'],
                'contact_details'   => $row['contact_details'],
                'status'            => 'Draft',
                'pcode'             => $row['pcode'],
                'mcode'             => $row['mcode'],
                'code'              => $yy.'-'.'_____',
                'date_proceed'      => '',
                'status'            => !empty($row['status']) ? $row['status'] : 'Draft',
                'safetyseal_no'     => $row['ss_no']
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
        $getQry = $this->db->query($sql);

        $data = [];
        
        while ($row = mysqli_fetch_assoc($getQry)) {
            $data = [
                'email' => $row['email'],
                'fname' => $row['fname'],
                'mobile_no' => $row['contact_details']
            ];   
        }
            return $data;
    }

    public function getStatusOptions()
    {
        $options  = [
            self::STATUS_FOR_RECEIVING => self::STATUS_FOR_RECEIVING,
            self::STATUS_RECEIVED => self::STATUS_RECEIVED,
            self::STATUS_APPROVED => self::STATUS_APPROVED,
            self::STATUS_DISAPPROVED => self::STATUS_DISAPPROVED
        ];

        return $options;
    }

    public function getAppTypeOptions()
    {
        $options = [
            self::TYPE_APPLIED => self::TYPE_APPLIED,
            self::TYPE_ENCODED => self::TYPE_ENCODED
        ];

        return $options;
    }

    public function getAllUsers($province='', $lgu='', $roles='')
    {
        mysqli_set_charset($this->conn, "utf8");

        $sql = "SELECT ai.id as userid, ai.CMLGOO_NAME as name, pr.name as province, pr.id as province_id, cm.name as lgu, ai.EMAIL as email, ai.roles as role, ai.IS_VERIFIED as is_verified, ai.IS_APPROVED as is_approved, ai.UNAME as username, ai.profile
        FROM tbl_admin_info ai
        JOIN tbl_userinfo ui on ui.user_id = ai.id
        JOIN tbl_province pr on pr.id = ai.PROVINCE
        JOIN tbl_citymun cm on cm.province = ai.PROVINCE AND cm.code = ai.LGU
        WHERE ai.id IS NOT NULL";

        if (!empty($province)) {
            $sql .= " AND ai.PROVINCE = '$province'";
        }

        $sql .= " ORDER BY pr.id, cm.id, ai.id";

        // $query = mysqli_query($this->conn, $sql);
        $getQry = $this->db->query($sql);

        $data = [];
        
        while ($row = mysqli_fetch_assoc($getQry)) {
            $data[$row['userid']] = [
                'name' => $row['name'],
                'username' => $row['username'],
                'email' => $row['email'],
                'province_id' => $row['province_id'],
                'province' => $row['province'],
                'lgu' => $row['lgu'],
                'status' => $row['is_verified'] ? 'Active' : 'Inactive',
                'profile' => !empty($row['profile']) ? '_images/profile/'.$row['profile'] : '_images/logo.png'
            ];   
        }
        
        return $data;
    }

    public function getUserData($id)
    {
        $sql = "SELECT 
            ai.id as userid, 
            ai.CMLGOO_NAME as name, 
            pr.id as province, 
            pr.id as province_id, 
            cm.name as lgu,
            cm.id as lgu_id,  
            ai.EMAIL as email, 
            ai.roles as role, 
            ai.IS_VERIFIED as is_verified, 
            ai.IS_APPROVED as is_approved, 
            ui.POSITION as position, 
            ui.ADDRESS as address, 
            ui.MOBILE_NO as mobile_no, 
            ui.GOV_AGENCY_NAME as gov_agency, 
            ai.OFFICE as sub_office, 
            ui.GOV_ESTB_NAME as establishment, 
            ui.GOV_NATURE_NAME as gov_nature, 
            ai.UNAME as username,
            ai.ROLES as role,
            ai.profile as profile  
            FROM tbl_admin_info ai
        JOIN tbl_userinfo ui on ui.user_id = ai.id
        JOIN tbl_province pr on pr.id = ai.PROVINCE
        JOIN tbl_citymun cm on cm.province = ai.PROVINCE AND cm.code = ai.LGU
        WHERE ai.id = $id";

        $getQry = $this->db->query($sql);
        $data = [];

        $result = mysqli_fetch_assoc($getQry);
        
        return $result;
    }

    public function postUserAccount($data) 
    {
        $sql = "UPDATE tbl_admin_info SET CMLGOO_NAME = '".$data['fullname']."', EMAIL = '".$data['email']."', OFFICE = '".$data['sub_office']."', IS_VERIFIED = '".$data['status']."', PROVINCE = '".$data['province']."', LGU = '".$data['lgu']."', ROLES = '".$data['role']."' WHERE id = '".$data['id']."'";

        $getQry = $this->db->query($sql);

        $sql = "UPDATE tbl_userinfo SET ADDRESS = '".$data['address']."', POSITION = '".$data['position']."', MOBILE_NO = '".$data['mobile_no']."', EMAIL_ADDRESS = '".$data['email']."', GOV_AGENCY_NAME = '".$data['gov_agency']."', GOV_NATURE_NAME = '".$data['gov_nature']."' WHERE id = '".$data['id']."'";

        $getQry = $this->db->query($sql);


        if (!empty($data['pw1'])) {
            // $hashed_pw = password_hash($data['pw1'], PASSWORD_DEFAULT);
            $sql = "UPDATE tbl_admin_info SET PASSWORD = '".$data['pw1']."' WHERE id = '".$data['id']."'";

            $getQry = $this->db->query($sql);
        }

        return $data;
    }

    public function postUserEstablishment($data) 
    {
        $sql = "UPDATE tbl_admin_info 
                SET OFFICE = '".$data['sub_office']."', 
                PROVINCE = '".$data['gov_province']."', 
                LGU = '".$data['gov_lgu']."' 
                WHERE id = ".$data['userid']."";

        $getQry = $this->db->query($sql);

        $sql = "UPDATE tbl_userinfo 
                SET ADDRESS = '".$data['gov_address']."', 
                GOV_AGENCY_NAME = '".$data['gov_agency']."',
                GOV_NATURE_NAME = '".$data['gov_nature']."' 
                WHERE id = ".$data['userid']."";

        $getQry = $this->db->query($sql);   

        return $data; 
    }

    public function postUserAccountV2($data) 
    {
        $sql = "UPDATE tbl_admin_info 
                SET CMLGOO_NAME = '".$data['fullname']."', 
                EMAIL = '".$data['email']."', 
                OFFICE = '".$data['sub_office']."',
                UNAME = '".$data['username']."' 
                WHERE id = '".$data['userid']."'";

        $getQry = $this->db->query($sql);

        $sql = "UPDATE tbl_userinfo 
                SET POSITION = '".$data['position']."', 
                MOBILE_NO = '".$data['mobile_no']."', 
                EMAIL_ADDRESS = '".$data['email']."' 
                WHERE id = '".$data['userid']."'";

        $getQry = $this->db->query($sql);   


        if (!empty($data['password'])) {
            $sql = "UPDATE tbl_admin_info SET PASSWORD = '".$data['password']."' WHERE id = '".$data['userid']."'";

            $getQry = $this->db->query($sql);
        }

        return $data; 
    }

    public function postUserProfile($filepath, $id) 
    {
        $sql = "UPDATE tbl_admin_info SET profile = '".$filepath."' WHERE id = '".$id."'";
        $getQry = $this->db->query($sql);

        return 0;
    }

    public function insertAttachments($entry_id, $file) {
        $sql = 'INSERT INTO tbl_app_checklist_attachments SET entry_id = "'.$entry_id.'", file_name = "'.$file.'", date_created = NOW()';
        $getQry = $this->db->query($sql);

        return $data;
    }

    public function getUserMOVS($id, $for_renewal='')
    {
        $sql = "SELECT * FROM tbl_app_checklist_attachments WHERE entry_id = $id";
        $getQry = $this->db->query($sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($getQry)) {
            $data[] = $row['file_name'];    
        }

        return $data;
    }

    public function fileSizeChecker($size) 
    {
        $is_large = false;
        if ($size > 50000000) {
            $is_large = true;
        }

        return $is_large;
    }

    public function getParentID($id)
    {
        $sql = "SELECT parent_id FROM tbl_app_checklist_entry WHERE id = ".$id."";
        $getQry = $this->db->query($sql);
        $result = mysqli_fetch_assoc($getQry);
            
        return $result['parent_id'];
    }

    public function insertEntry($client_id, $client_secret, $entry, $file, $file_type, $for_renewal) 
    {
        $today = new DateTime();

        $sql = "INSERT INTO tbl_app_checklist_attachments 
                SET file_id = '".$file['id']."',
                file_name = '".$file['originalFilename']."',
                location = '".$file['alternateLink']."',
                date_created = '".$today->format('Y-m-d H:i:s')."',
                client_id = '".$client_id."',
                client_secret = '".$client_secret."',
                file_type = '".$file_type."',
                entry_id = '".$entry."'";

        $result = $this->db->query($sql);

        return $result;
    }

    public function getUploadedMOVS($id, $for_renewal)
    {
        $sql = "SELECT e.id as eid, ca.id as caid, ca.file_id as file_id, ca.file_name as file_name, ca.location as location, ca.file_type as file_type FROM tbl_app_checklist_attachments ca ";

        // if ($for_renewal) {
            // $sql .= " LEFT JOIN tbl_app_checklist_renewal_entry e on e.id = ca.renewal_id";
        // } else {
            $sql .= " LEFT JOIN tbl_app_checklist_entry e on e.id = ca.entry_id";
        // }
        
        $sql .= " LEFT JOIN tbl_app_checklist a on a.id = e.parent_id WHERE e.id = ".$id."";

        $getQry = $this->db->query($sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($getQry)) {
            $cover_page = null;
            if (strpos($row['file_type'], 'pdf')) {
                $cover_page = 'files/certified/pdf_icon.png';
            } elseif (strpos($row['file_type'], 'spreadsheetml.sheet')) {
                $cover_page = 'files/certified/excel_icon.png';
            } elseif (strpos($row['file_type'], 'msword') OR strpos($row['file_type'], 'wordprocessing')) {
                $cover_page = 'files/certified/word_icon.png';
            }

            $data[$row['caid']] = [
                'caid' => $row['caid'],
                'file_id' => $row['file_id'],
                'file_name' => $row['file_name'],
                'url' => $row['location'],
                'cover_page' => $cover_page
            ];    
        }

        return json_encode($data);
    }

    public function getEntryClientID($id) 
    {
        $sql = "SELECT client_id, client_secret FROM tbl_app_checklist_attachments WHERE id = $id";
        $getQry = $this->db->query($sql);
        $row = mysqli_fetch_assoc($getQry);

        return $row;
    }

    public function removeAttachment($id) 
    {
        $sql = 'DELETE FROM tbl_app_checklist_attachments WHERE id = '.$id.'';
        $result = $this->db->query($sql);

        return $result;   
    }

    public function getAnsweredChecklist($id)
    {
        $sql = "SELECT answer FROM tbl_app_checklist_entry WHERE parent_id = ".$id." AND answer != ''";
        $getQry = $this->db->query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($getQry)) {
            $data[] = $result['answer'];
        }
            
        return $data;
    }

     public function getEncodedAttachmentChecklist($id)
    {
        $sql = "SELECT count(*) as answer FROM tbl_app_checklist_encoded_attachments WHERE parent_id = '".$id."'";
        $getQry = $this->db->query($sql);
        $result = mysqli_fetch_assoc($getQry);
            
        return $result['answer'];
    }

    public function getAnsweredChecklistYes($id)
    {
        $sql = "SELECT count(*) as count FROM tbl_app_checklist_entry WHERE parent_id = ".$id." AND answer = 'yes'";
        $getQry = $this->db->query($sql);
    
        $result = mysqli_fetch_assoc($getQry);
        
        return $result['count'];
    }

    public function passwordMatchChecker($pw1, $pw2) 
    {
        if ($pw1 != $pw2) {
            throw new Exception('Password does not match!');
        }

        if (strlen($pw1) < 6) {
            throw new Exception('Password must be at least 6 characters.');
        }

        return true;
    }

    public function getApprovalHistory($id) 
    {
        $sql = "SELECT 
                h.action as action,
                ai.CMLGOO_NAME as name,
                h.message as message,
                DATE_FORMAT(h.action_date, '%Y-%m-%d %H:%i:%s') as action_date,
                DATE_FORMAT(h.action_date, '%b %d, %Y %h:%i %p') as date_created
                FROM tbl_history h 
                LEFT JOIN tbl_admin_info ai ON ai.id = h.uid
                WHERE h.fid = $id
                ORDER BY h.id DESC";

        $getQry = $this->db->query($sql);
        
        $date_today = new DateTime();
        $date_today = date('Y-m-d H:i:s', strtotime($date_today->format('Y-m-d H:i:s')));

        
        $data = [];

        while ($result = mysqli_fetch_assoc($getQry)) {
            $date1=date_create($date_today);
            $date2=date_create($result['action_date']);
            $interval = date_diff($date1, $date2);

            if ($interval->y > 0) {
                $interval = $interval->y .' year(s) ago';
            } elseif ($interval->m > 0) {
                $interval = $interval->m .' month(s) ago';
            } elseif ($interval->d > 0) {
                $interval = $interval->d .' day(s) ago';
            } elseif ($interval->h > 0) {
                $interval = $interval->h .' hour(s) ago';
            } elseif ($interval->i > 0) {
                $interval = $interval->s .' min(s) ago';
            } else {
                $interval = $interval->s .' sec(s) ago';
            }

            $data[] = [
                'name'          => $result['name'],
                'action'        => $result['action'],
                'interval'      => $interval,
                'action_date'   => $result['date_created'],
                'message'       => $result['message']
            ];
        }

        return $data;
    }

    public function getApplicationHistory($id) 
    {
        $sql = "SELECT 
                DATE_FORMAT(issued_date, '%b %d, %Y') as issued_date,
                DATE_FORMAT(expiration_date, '%b %d, %Y') as expiration_date,
                DATE_FORMAT(date_created, '%b %d, %Y') as date_created,  
                status 
                FROM tbl_application_history 
                WHERE app_id = $id
                ORDER BY id DESC";

        $getQry = $this->db->query($sql);
        $data = [];

        while ($result = mysqli_fetch_assoc($getQry)) {
            $data[] = [
                'issued_date'       => $result['issued_date'],
                'expiration_date'   => $result['expiration_date'],
                'date_created'      => $result['date_created'],
                'status'            => $result['status']
            ];
        }

        return $data;
    }

    public function getContactTracingTool($id) 
    {
        $sql = "SELECT 
                CASE WHEN e.tracing_tool = 'staysafe' then 'StaySafe.ph' else e.other_tool end AS app_tool 
                FROM tbl_app_checklist_entry e
                LEFT JOIN tbl_app_checklist a ON a.id = e.parent_id  
                WHERE e.parent_id = $id
                AND a.application_type = 'Applied'
                ORDER BY e.id ASC limit 1";

        $getQry = $this->db->query($sql);
        $result = mysqli_fetch_assoc($getQry);
        
        $tool = isset($result['app_tool']) ? $result['app_tool'] : ''; 

        return $tool;
    }

    public function getAllChecklist($userid=null, $person=null) 
    {
        $date_today = new DateTime();
        $date_today = date('Y-m-d', strtotime($date_today->format('Y-m-d')));

        $sql = "SELECT 
                id,
                control_no,
                safety_seal_no,
                token,
                status,
                establishment,
                for_renewal,
                person as name,
                address,
                agency,
                contact_details,
                DATE_FORMAT(date_created, '%b %d, %Y %h:%i %p') as date_created, 
                DATE_FORMAT(date_approved, '%b %d, %Y') as date_approved 
                FROM tbl_app_checklist";
        
        if (!empty($userid)) {
            $sql .= " WHERE user_id = $userid ORDER BY id DESC";
        } else {
            $sql .= " WHERE person = '".$person."' ORDER BY id DESC";
        } 
        

        $getQry = $this->db->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($getQry)) {
            $color = "green";
            $date_validity_f = '';
            $status = $row['status'];

            if (!empty($row['date_approved'])) {
                if (($row['status'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
                    $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
                    $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
                } else {
                    $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
                    $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
                }

                $date1 = date_create($date_today);
                $date2 = date_create($date_validity);
                $interval = $date1->diff($date2);
                
                if (!empty($row['date_approved'])) {
                    if ($row['status'] == 'For Renewal') {
                        $status = $row['status'];
                    } elseif ($date_today >= $date_validity) {
                        $status = 'Expired';
                    }
                }
            }


            if ($status == 'For Receiving') {
                $color = 'primary';
            } elseif ($status == 'Received') {
                $color = 'yellow';
            } elseif (in_array($status, ['Disapproved', 'Expired'])) {
                $color = 'red';
            }
            
            $data[] = [
                'token'             => $row['token'],
                'id'                => $row['id'],
                'control_no'        => $row['control_no'],
                'ssn'               => in_array($status, ['Draft', 'For Renewal']) ? '' : $row['safety_seal_no'],
                'agency'            => $row['agency'],
                'name'              => $row['name'],
                'address'           => $row['address'],
                'establishment'     => $row['establishment'],
                'date_created'      => $row['date_created'],
                'expiration_date'   => in_array($status, ['Draft', 'For Renewal']) ? '' : $date_validity_f,
                'status'            => $status,
                'color'             => $color
            ];
        }

        return $data;
    }

}