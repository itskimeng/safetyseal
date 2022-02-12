<?php

class UserManager extends Connection
{
    public $conn = '';

  
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
    
    public function fetchEstablishments($userid, $token=null)
    {
        $sql = "SELECT 
        ai.CMLGOO_NAME as name,
        u.GOV_AGENCY_NAME as agency,
        u.GOV_ESTB_NAME as establishment,
        u.ADDRESS as location, 
        ac.control_no as control_no,
        ac.safety_seal_no as ss_no,
        ac.token as token,
        ac.establishment as ac_establishment,
        ac.nature as ac_nature,
        ac.address as ac_address,
        ac.status as ac_status,
        DATE_FORMAT(ac.date_renewed, '%Y-%m-%d') as date_renewed,
        DATE_FORMAT(ac.date_created, '%b %d, %Y %h:%i %p') as date_created,
        DATE_FORMAT(ac.date_approved, '%Y-%m-%d %h:%i %p') as date_approved,
        DATE_FORMAT(ac.date_approved, '%b %d, %Y') as date_issued,
        ai.UNAME as username,
        ac.for_renewal as for_renewal,
        ac.id as acid
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo u on ai.ID = u.USER_ID
        WHERE ai.ID = '$userid'";

        if (!empty($token)) {
            $sql .= " AND ac.token = '".$token."'";
        }

        $sql .= " ORDER BY ac.id DESC";

        $getQry = $this->db->query($sql);
        $data = [];
        
        $date_today = new DateTime();
        $date_today = date('Y-m-d', strtotime($date_today->format('Y-m-d')));

        while ($row = mysqli_fetch_assoc($getQry)) {
            // $date_created = date('M. d, Y h:i:s A', strtotime($row['date_created']));
            $date_created = $row['date_created'];
            $date_renewed = date('F d, Y',strtotime($row['date_renewed']));
            

            if (($row['ac_status'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_renewed'])));
            } else {
                $date_validity = date('Y-m-d', strtotime("+6 months", strtotime($row['date_approved'])));
            }

            if (($row['ac_status'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
            } else {
                $date_validity_f = date('M d, Y', strtotime("+6 months", strtotime($row['date_approved'])));
            }

            $date1 = date_create($date_today);
            $date2 = date_create($date_validity);
            $interval = $date1->diff($date2);

            // if ($row['ac_status'] == 'For Renewal') {
            //     $status = $row['ac_status'];
            // } elseif ($date_today >= $date_validity) {
            //     $status = 'Expired';
            // }

            $status = $row['ac_status'];

            if (!empty($row['date_approved'])) {
                if ($row['ac_status'] == 'For Renewal') {
                    $status = $row['ac_status'];
                } elseif ($date_today >= $date_validity) {
                    $status = 'Expired';
                }   
            }


            $data[] = [
                'acid'              => $row['acid'],
                'name'              => $row['name'],
                'agency'            => $row['agency'],
                'establishment'     => $row['establishment'],
                'location'          => $row['location'],
                'control_no'        => $row['control_no'],
                'ss_no'             => $row['ss_no'],
                'token'             => $row['token'],
                'date_created'      => $date_created,
                'date_issued'       => $row['date_issued'],
                'date_validity'     => !empty($row['date_approved']) ? $date_validity_f : '---',
                'interval'          => $date_today >= $date_validity,
                'ac_establishment'  => $row['ac_establishment'],
                'ac_nature'         => $row['ac_nature'],
                'ac_address'        => $row['ac_address'],
                'ac_status'         => $status,
                'username'          => $row['username'],
                'for_renewal'       => $row['for_renewal'],
                'date_renewed'      => $date_renewed
            ];    
        }

        return $data;
    }

    public function getUserInfo($userid)
    {
        $sql = "SELECT 
            ai.id as id, 
            ai.CMLGOO_NAME as name, 
            user.GOV_AGENCY_NAME as agency, 
            user.POSITION as position, 
            user.ADDRESS as address, 
            user.MOBILE_NO as phone_no, 
            user.EMAIL_ADDRESS  as emailaddress,
            ai.UNAME as username,
            user.GOV_NATURE_NAME as nature,
            ai.OFFICE as sub_office,
            p.name as province,
            p.id as province_id,
            cm.name as lgu,
            ai.UNAME as username,
            cm.code as lgu_code
            FROM `tbl_admin_info` ai
            LEFT JOIN tbl_userinfo user on ai.id = user.USER_ID  
            LEFT JOIN tbl_app_checklist chkl on ai.id = chkl.user_id 
            LEFT JOIN tbl_province p on p.id = ai.PROVINCE
            LEFT JOIN tbl_citymun cm on cm.code = ai.LGU AND cm.PROVINCE = ai.PROVINCE 
            WHERE ai.ID = '$userid'";

        $getQry = $this->db->query($sql);
        $data = [];
        $rowCount= mysqli_num_rows($getQry); 

        while ($row = mysqli_fetch_assoc($getQry)) {
            $data = [
                'id' => $row['id'],
                'name' => $row['name'],
                'position' => $row['position'],
                'address' => !empty($row['address']) ? $row['address'] : 'Not Available',
                'phone_no' => $row['phone_no'],
                'emailladdress' => $row['emailaddress'],
                'agency' => $row['agency'],
                'est'=>$rowCount,
                'username' => $row['username'],
                'nature' => $row['nature'],
                'sub_office' => $row['sub_office'],
                'province' => $row['province'],
                'province_id' => $row['province_id'],
                'lgu' => $row['lgu'],
                'lgu_code' => $row['lgu_code'],
                'username' => $row['username']
            ];    
        }
        return $data;
        
    }

    public function getRenewalEntry($ss_no) {
        $sql = "SELECT count(*) as count FROM tbl_app_checklist WHERE safety_seal_no = '".$ss_no."' AND for_renewal = true";
        $getQry = $this->db->query($sql);
        $result = mysqli_fetch_assoc($getQry);

        return $result['count'];
    }

  
}