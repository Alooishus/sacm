<?php
include('../inc/db_connect.php');
//search criteria
$action = filter_input(INPUT_POST, 'action');
$e_num =  filter_input(INPUT_POST, 'e_num');
$c_id =  filter_input(INPUT_POST, 'c_id');
$c_fname = filter_input(INPUT_POST, trim('c_fname'));
$c_fname =ucwords(strtolower($c_fname));
$c_lname = filter_input(INPUT_POST, trim('c_lname'));
$c_lname =ucwords(strtolower($c_lname));
$c_dob =  filter_input(INPUT_POST, 'c_dob');
$prog_sec = filter_input(INPUT_POST, 'prog_sec');
$prog_name = filter_input(INPUT_POST, trim('prog_name'));
$prog_time = filter_input(INPUT_POST, trim('prog_time'));
$prog_day = filter_input(INPUT_POST, trim('prog_day'));
$prog_age_range = filter_input(INPUT_POST, trim('prog_age_range'));
$prog_sec_desc = filter_input(INPUT_POST, trim('prog_sec_desc'));
$e_consent_sacm_van = filter_input(INPUT_POST, 'e_consent_sacm_van');
$e_consent_attend = filter_input(INPUT_POST, 'e_consent_attend');
$e_consent_sm_phone = filter_input(INPUT_POST, 'e_consent_sm_phone');
$e_consent_emg_med = filter_input(INPUT_POST, 'e_consent_emg_med');
$e_consent_to_publish = filter_input(INPUT_POST, 'e_consent_to_publish');
$e_status = filter_input(INPUT_POST, 'e_status');
$trans_type_to = filter_input(INPUT_POST, trim('trans_type_to'));
$trans_type_from = filter_input(INPUT_POST, trim('trans_type_from'));

$showForm = false;
$linkMSG = null;
$linkMSG2 = null;
$confirmMSG = null;
$confirmMSG2 = null;
$errorMSG = null;
$errorMSG2  = null;
$progName = NULL;
$progDay = NULL;
$progRange =NULL;
$progDesc  = NULL;

if (isset ($action) /* == "Submit Form" || $action == "Search" */)
{

    //check if child exists 
    $query_child_already_exists = 
        'SELECT COUNT(*)
        FROM child
        WHERE c_dob = :c_dob
        AND c_fname = :c_fname
        AND c_lname = :c_lname';
    $stmt = $db->prepare($query_child_already_exists);
    $stmt->bindValue(':c_dob', $c_dob);
    $stmt->bindValue(':c_fname', $c_fname);
    $stmt->bindValue(':c_lname', $c_lname);
    $stmt->execute();
    $child_count = $stmt->fetchColumn();
    $stmt->closeCursor();

    //if child doesn't exist create errorMSG and halt logic and prevent screen rendering
    if ($child_count == 0)
    {
        $errorMSG2 = '<b>ERROR: No Children with this name and birthday have been registered. Please Check your spelling and click HERE to try again</b>';
        $linkMSG = "<b>Register a new child HERE</b>";
    }
    else 
    {
        $errorMSG2 = null;
        $linkMSG =null;
    }


    //if child exists get child's c_id
    $query_child_id = 
        'SELECT c_id
        FROM child
        WHERE c_dob = :c_dob
        AND c_fname = :c_fname
        AND c_lname = :c_lname';
    $stmt1 = $db->prepare($query_child_id);
    $stmt1->bindValue(':c_fname', $c_fname);
    $stmt1->bindValue(':c_lname', $c_lname);
    $stmt1->bindValue(':c_dob', $c_dob);
    $stmt1->execute();
    $c_id = $stmt1->fetchColumn();
    $stmt1->closeCursor();


    //get all enrollments for child with given c_id to create drop down to choose from
    $query_child_enrollments =
        'SELECT 
        e.e_num,
        e.c_id,
        e.person_id,
        e.prog_sec,
        e.e_status,
        e.e_consent_sacm_van,
        e.e_consent_attend,
        e.e_consent_sm_phone,
        e.e_consent_emg_med,
        e.e_consent_to_publish,
        p.prog_name, 
        ps.prog_age_range, 
        ps.prog_day, 
        ps.prog_sec_desc, 
        ps.prog_time, 
        ps.prog_sec
    FROM enrollment e    
        JOIN prog_section ps 
            ON e.prog_sec = ps.prog_sec
        JOIN program p
            ON ps.prog_id = p.prog_id
    WHERE ps.prog_sec_active = true
    AND e.c_id = :c_id';
    $stmt3 = $db->prepare($query_child_enrollments);
    $stmt3->bindValue(':c_id', $c_id);
    $stmt3->execute();
    $enrollments = $stmt3->fetchAll();
    $stmt3->closeCursor();

 // trying this one to include tranportation update   

    //fill in new update


    //working selection
    
    $query_child_edit =
    'SELECT 
        e.e_num,
        e.c_id,
        e.person_id,
        e.prog_sec,
        e.e_status,
        e.e_consent_sacm_van,
        e.e_consent_attend,
        e.e_consent_sm_phone,
        e.e_consent_emg_med,
        e.e_consent_to_publish,
        p.prog_name, 
        ps.prog_age_range, 
        ps.prog_day, 
        ps.prog_sec_desc, 
        ps.prog_time, 
        ps.prog_sec
    FROM enrollment e    
        JOIN prog_section ps 
            ON e.prog_sec = ps.prog_sec
        JOIN program p
            ON ps.prog_id = p.prog_id
    WHERE ps.prog_sec_active = true
    AND e.e_num = :e_num';
    $stmt3 = $db->prepare($query_child_edit);
    //$stmt3->bindValue(':c_id', $c_id);
    $stmt3->bindValue(':e_num', $e_num);
    $stmt3->execute();
    $edits = $stmt3->fetchAll();
    $stmt3->closeCursor();
    

    // removed c_id ref after where to check effectiveness  AND e.c_id = :c_id
    //get transportation for that section
    $query_child_trans =
    'SELECT 
        t.trans_type_to,
        t.trans_type_from
    FROM enrollment e
    JOIN prog_section ps ON e.prog_sec = ps.prog_sec
    JOIN transportation t ON ps.prog_sec = t.prog_sec
    WHERE e.e_num = :e_num
    AND t.c_id = :c_id';
    $stmt6 = $db->prepare($query_child_trans);
    $stmt6->bindValue(':c_id', $c_id);
    $stmt6->bindValue(':e_num', $e_num);
    $stmt6->execute();
    $trans = $stmt6->fetchAll();
    $stmt6->closeCursor();
    

    foreach ($trans as $tran)
    {
        $to = $tran ["trans_type_to"];
        $from = $tran ["trans_type_from"];
    }

    //if Yes update new e_status boolean using e_num
    if($action == "Submit Form")
    {   

        //if No Update enrollment consent forms using then e_num
        $update_child = 
            'UPDATE 
                enrollment
            SET
                e_status = :e_status,
                e_consent_sacm_van = :e_consent_sacm_van, 
                e_consent_attend = :e_consent_attend, 
                e_consent_sm_phone = :e_consent_sm_phone, 
                e_consent_emg_med = :e_consent_emg_med, 
                e_consent_to_publish = :e_consent_to_publish
            WHERE e_num = :e_num';
        $stmt5 = $db->prepare($update_child);
        $stmt5->bindValue(':e_num', $e_num);
        $stmt5->bindValue(':e_status', $e_status);
        $stmt5->bindValue(':e_consent_sacm_van', $e_consent_sacm_van);
        $stmt5->bindValue(':e_consent_attend', $e_consent_attend);
        $stmt5->bindValue(':e_consent_sm_phone', $e_consent_sm_phone);
        $stmt5->bindValue(':e_consent_emg_med', $e_consent_emg_med);
        $stmt5->bindValue(':e_consent_to_publish', $e_consent_to_publish);
        $stmt5->execute();
        $stmt5->closeCursor();

        //if No Update enrollment consent forms using then e_num
        $update_trans = 
            'UPDATE
                enrollment e
            JOIN prog_section ps 
                ON e.prog_sec = ps.prog_sec
            JOIN transportation t 
                ON ps.prog_sec = t.prog_sec
            SET
                t.trans_type_to = :trans_type_to,
                t.trans_type_from = :trans_type_from 
            WHERE e.e_num = :e_num
            AND t.c_id = :c_id';
        $stmt5 = $db->prepare($update_trans);
        $stmt5->bindValue(':e_num', $e_num);
        $stmt5->bindValue(':c_id', $c_id);
        $stmt5->bindValue(':trans_type_to', $trans_type_to);
        $stmt5->bindValue(':trans_type_from', $trans_type_from);
        $stmt5->execute();
        $stmt5->closeCursor();
        $action = null;
    

        // create confirmMSG & errogMSG of e_staus change
        $confirmMSG= "CONFIRMATION: <b>$c_fname $c_lname's</b>  Consent forms, transportation, and active status has been updated.";
    }
}
include_once ('edit_enrollment.php');


?>