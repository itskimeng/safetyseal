<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$entry_id = $_GET['id'];

$lists = getUserChecklistsAttachments($conn, $entry_id);

echo $lists;

function getUserChecklistsAttachments($conn, $id)
{
    $sql = "SELECT 
        e.id as eid,
        ca.id as caid,
        ca.file_id as file_id,
        ca.file_name as file_name,
        ca.location as location,
        ca.file_type as file_type
        FROM tbl_app_checklist_attachments ca 
        LEFT JOIN tbl_app_checklist_entry e on e.id = ca.entry_id
        LEFT JOIN tbl_app_checklist a on a.id = e.parent_id
        WHERE e.id = ".$id."";

    $query = mysqli_query($conn, $sql);
    $data = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $cover_page = null;
        if (strpos($row['file_type'], 'pdf')) {
            $cover_page = 'files/certified/pdf_icon.png';
        } elseif (strpos($row['file_type'], 'spreadsheetml.sheet')) {
            $cover_page = 'files/certified/excel_icon.png';
        } elseif (strpos($row['file_type'], 'msword')) {
            $cover_page = 'files/certified/word_icon.png';
        }

        $data[$row['caid']] = [
            'caid' => $row['caid'],
            'file_id' => $row['file_id'],
            'file_name' => $row['file_name'],
            'location' => $row['location'],
            'cover_page' => $cover_page
        ];    
    }

    return json_encode($data);
}