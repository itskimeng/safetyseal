<?php

class UserManager
{
    public $conn = '';

  
    function __construct() 
    {
        $this->conn = mysqli_connect("localhost","calabarzondilggo_safetysealuser","'xPR<W5dm$#-[RQf","calabarzondilggo_safetyseal");
    }
    
    public function fetchEstablishments($userid)
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
        DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
        ai.UNAME as username,
        ac.for_renewal as for_renewal
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo u on ai.ID = u.USER_ID
        WHERE ai.ID = '$userid'";

        $query = mysqli_query($this->conn, $sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($query)) {

            // $date2 = date_create($date2);

            $date_created = date('F d, Y',strtotime($row['date_created']));
            $date_renewed = date('F d, Y',strtotime($row['date_renewed']));
            $date_today = new DateTime();
            $date_today = date('F d, Y', strtotime($date_today->format('Y-m-d')));

            if (($row['ac_status'] == "Approved") AND ($row['for_renewal']) AND (!empty($row['date_renewed']))) {
                $date_validity = date('F d, Y', strtotime("+6 months", strtotime($row['date_renewed'])));
            } else {
                $date_validity = date('F d, Y', strtotime("+6 months", strtotime($row['date_created'])));
            }

            $date1=date_create($date_today);
            $date2=date_create($date_validity);



            $interval = date_diff($date1, $date2);

            $data[] = [
                'name'              => $row['name'],
                'agency'            => $row['agency'],
                'establishment'     => $row['establishment'],
                'location'          => $row['location'],
                'control_no'        => $row['control_no'],
                'ss_no'             => $row['ss_no'],
                'token'             => $row['token'],
                'date_created'      => $date_created,
                'date_validity'     => $date_validity,
                'interval'          => $interval->m,
                'ac_establishment'  => $row['ac_establishment'],
                'ac_nature'         => $row['ac_nature'],
                'ac_address'        => $row['ac_address'],
                'ac_status'         => $row['ac_status'],
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

        $query = mysqli_query($this->conn, $sql);
        $data = [];
        $rowCount= mysqli_num_rows($query); 

        while ($row = mysqli_fetch_assoc($query)) {
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

  
}