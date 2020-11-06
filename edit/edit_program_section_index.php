<?php

include('../inc/db_connect.php');

$action = filter_input(INPUT_POST, 'action');
$select = filter_input(INPUT_POST, 'select');
$person_id = filter_input(INPUT_POST, 'person_id', FILTER_VALIDATE_INT);
$prog_id = filter_input(INPUT_POST, 'prog_id', FILTER_VALIDATE_INT);
$prog_name = filter_input(INPUT_POST, trim('prog_name'));
$prog_name =ucwords(strtolower($prog_name));
$prog_time = filter_input(INPUT_POST, trim('prog_time'));
$prog_time_spot = filter_input(INPUT_POST, trim('prog_time_spot'));
$am_pm = filter_input(INPUT_POST, trim('am_pm'));
$prog_day = filter_input(INPUT_POST, trim('prog_day'));
$prog_age_range = filter_input(INPUT_POST, trim('prog_age_range'));
$low_prog_age_range = filter_input(INPUT_POST, trim('low_prog_age_range'));
$high_prog_age_range = filter_input(INPUT_POST, trim('high_prog_age_range'));
$prog_seat_cap = filter_input(INPUT_POST, 'prog_seat_cap', FILTER_VALIDATE_INT);
$prog_room = filter_input(INPUT_POST, trim('prog_room'));
$prog_room =ucwords(strtolower($prog_room));
$prog_van_trans_avail = filter_input(INPUT_POST, 'prog_van_trans_avail');
$prog_sec_desc = filter_input(INPUT_POST, trim('prog_sec_desc'));
$prog_sec_desc =ucwords(strtolower($prog_sec_desc));
$prog_sec = filter_input(INPUT_POST, 'prog_sec');
$prog_sec_active  = filter_input(INPUT_POST, 'prog_sec_active');
$errorMSG = null;
$confirmMSG = null;
$linkMSG = null;
$confirmMSG2 = null;
$linkMSG2 = null;
$linkMSG4 = null;

//restructured for readability get active program section information
$query_program_sections = 
    'SELECT 
        p.prog_id, 
        p.prog_name, 
        ps.prog_age_range, 
        ps.prog_day, 
        ps.prog_sec_desc,  
        ps.prog_sec, 
        ps.prog_sec_active, 
        ps.prog_van_trans_avail, 
        ps.prog_seat_cap, 
        ps.prog_room,
        ps.prog_time
    FROM prog_section ps
	JOIN program p
		ON ps.prog_id = p.prog_id
    WHERE  
		ps.prog_sec_active = true
    ORDER BY p.prog_name, ps.prog_day, ps.prog_sec, ps.prog_age_range';
$stmt4 = $db->prepare($query_program_sections);
$stmt4->execute();
$program_sections = $stmt4->fetchAll();
$stmt4->closeCursor();

//get list of available class rooms
$query_prog_Rooms = 
    'SELECT DISTINCT 
        prog_room  
    FROM prog_section 
    ORDER BY prog_room';
$stmt5 = $db->prepare($query_prog_Rooms);
$stmt5->execute();
$prog_Rooms = $stmt5->fetchAll();
$stmt5->closeCursor();

/* EDITING THIS ON TO GET TEACHER NAME AND ID */
$query_get_teacher_details = 
    'SELECT 
        t.person_id, 
        p.p_fname, 
        p.p_lname, 
        t.prog_sec
    FROM  person p
    JOIN teaches t
        ON p.person_id = t.person_id
    WHERE t.prog_sec =:prog_sec';
$stmt40 = $db->prepare($query_get_teacher_details);
$stmt40->bindValue(':prog_sec', $prog_sec);
$stmt40->execute();
$teacherDetails = $stmt40->fetchAll();
$stmt40->closeCursor();



/* EDITING THIS ON TO GET TEACHERs NAMEs AND IDs */
$query_get_teachers = 
    'SELECT 
        t.person_id,
        p.p_fname,
        p.p_lname,
        t.prog_sec
    FROM  person p
	JOIN teaches t
		ON p.person_id = t.person_id
    GROUP BY t.person_id';
$stmt40 = $db->prepare($query_get_teachers);
$stmt40->execute();
$teachers = $stmt40->fetchAll();
$stmt40->closeCursor();

//set name for teacher in the review page
foreach ($teachers as $teacher){
    if($person_id == $teacher['person_id']){
        $teacherName = $teacher['p_fname']." ". $teacher['p_lname'];
    }
}

if($select == "Deactivate Section")
{
    //get program information for the section that will be deactivated
    $query_deactivate_sections = 
        'SELECT 
            p.prog_id, 
            p.prog_name, 
            ps.prog_age_range, 
            ps.prog_day, 
            ps.prog_sec_desc,  
            ps.prog_sec , 
            ps.prog_sec_active
        FROM prog_section ps
        JOIN program p
            ON ps.prog_id = p.prog_id
        ORDER BY p.prog_name, ps.prog_sec';
    $stmt1 = $db->prepare($query_deactivate_sections);
    $stmt1->execute();
    $deactivate_sections = $stmt1->fetchAll();
    $stmt1->closeCursor();

    if ($action == "Change Active Status")
    {
        //change the active status of that program if user confirmed in review page
        $query_update_prog_sec= 
            'UPDATE 
                prog_section 
            SET 
                prog_sec_active = :prog_sec_active
            WHERE 
                prog_sec = :prog_sec';
        $stmt = $db->prepare( $query_update_prog_sec);
        $stmt->bindValue(':prog_sec', $prog_sec);
        $stmt->bindValue(':prog_sec_active', $prog_sec_active);
        $stmt->execute();
        $stmt->closeCursor();

        $confirmMSG = 'CONFIRMATION for Change of Status';
        $linkMSG = "Click HERE to Update another Section";
        include_once('edit_program_section.php');
    }
}

else
{
    //concatennate the age range
    if(!isset($prog_age_range))
    {
        $prog_age_range = $low_prog_age_range."-".$high_prog_age_range;
    }

    //concatennate the program time
    if(!isset($prog_time))
    {
        $prog_time = $prog_time_spot." ".$am_pm;
    }

    //check for unique section details not including the section currently in question
    $queryCheckprog_sec= 
        'SELECT COUNT(*) 
        FROM prog_section 
        WHERE prog_sec <> :prog_sec
        AND prog_id = :prog_id
        AND prog_sec_desc = :prog_sec_desc
        AND prog_day = :prog_day
        AND prog_van_trans_avail = :prog_van_trans_avail
        AND prog_seat_cap = :prog_seat_cap
        AND prog_room = :prog_room
        AND prog_age_range = :prog_age_range
        AND prog_time = :prog_time';
    $stmt = $db->prepare( $queryCheckprog_sec);
    $stmt->bindValue(':prog_sec', $prog_sec);
    $stmt->bindValue(':prog_id', $prog_id);
    $stmt->bindValue(':prog_sec_desc', $prog_sec_desc);
    $stmt->bindValue(':prog_day', $prog_day);
    $stmt->bindValue(':prog_van_trans_avail', $prog_van_trans_avail);
    $stmt->bindValue(':prog_seat_cap', $prog_seat_cap);
    $stmt->bindValue(':prog_room', $prog_room);
    $stmt->bindValue(':prog_age_range', $prog_age_range);
    $stmt->bindValue(':prog_time', $prog_time);
    $stmt->execute();
    $countProgramSection = $stmt->fetchColumn();

    //if section details are not unique give a message to user
    if ($countProgramSection > 0)
    {
        $errorMSG = "<b>ERROR: That section already exists.</b>";
        $linkMSG4 = "<b>To edit that section click HERE</b>";

        include_once('edit_program_section.php');
    }
    else if($countProgramSection == 0 && $action =="Submit Form" )
    {
        //update if unique program details
        $query_update_prog_sec= 
            'UPDATE 
                prog_section 
            SET 
                prog_sec_desc = :prog_sec_desc,
                prog_day = :prog_day,
                prog_van_trans_avail = :prog_van_trans_avail,
                prog_seat_cap = :prog_seat_cap,
                prog_room = :prog_room,
                prog_age_range = :prog_age_range,
                prog_time = :prog_time
            WHERE prog_sec = :prog_sec';
        $stmt = $db->prepare( $query_update_prog_sec);
        $stmt->bindValue(':prog_sec', $prog_sec);
        $stmt->bindValue(':prog_sec_desc', $prog_sec_desc);
        $stmt->bindValue(':prog_day', $prog_day);
        $stmt->bindValue(':prog_van_trans_avail', $prog_van_trans_avail);
        $stmt->bindValue(':prog_seat_cap', $prog_seat_cap);
        $stmt->bindValue(':prog_room', $prog_room);
        $stmt->bindValue(':prog_age_range', $prog_age_range);
        $stmt->bindValue(':prog_time', $prog_time);
        $stmt->execute();
        $stmt->closeCursor();

        $confirmMSG2 = '<b>CONFIRMATION: Program Section Updated.</b>';
        $linkMSG2 = "<b>Update another program by clicking HERE</b>";
        include_once('edit_program_section.php');

    }
}
include_once('edit_program_section.php');
?>
<!-- 






