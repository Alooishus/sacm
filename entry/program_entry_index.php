<?php
include('../inc/db_connect.php');
$action = filter_input(INPUT_POST, 'action');
$select = filter_input(INPUT_POST, 'select');
$prog_id = filter_input(INPUT_POST, 'prog_id', FILTER_VALIDATE_INT);
$person_id = filter_input(INPUT_POST, 'person_id', FILTER_VALIDATE_INT);
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
$errorMSG = null;
$errorMSG2 = null;
$linkMSG = null;
$confirmMSG = null;
$linkMSG3 = null;
$confirmMSG3 = null;

//check for existing programs with the same name to avoid duplicates
$queryCheckprog_name = 
    'SELECT COUNT(*) 
    FROM program 
    WHERE prog_name =:prog_name';
$stmt = $db->prepare( $queryCheckprog_name);
$stmt->bindValue(':prog_name', $prog_name);
$stmt->execute();
$countProgramName = $stmt->fetchColumn();

if ($action == "Submit Form"||$action == "Review Form")
{
    if ($countProgramName>0)
    {
        $errorMSG = "<b>ERROR:</b> That program name already exists. Please select a different name <b><u>OR</u></b> clear form and create a new section of the program instead.";
    }
    elseif($action == "Submit Form")
    {
        //insert the program if it doesn't already exist
        $insert_program = 
        'INSERT INTO program
            (prog_name)
        VALUES
            (:prog_name)';
        $stmt2 = $db->prepare($insert_program);
        $stmt2->bindValue(':prog_name', $prog_name);
        $stmt2->execute();
        $stmt2->closeCursor();

        //show confirmation message and link
        $errorMSG = null;
        $confirmMSG = "<b>CONFIRMATION</b> of new program: <b>$prog_name</b>";
        $linkMSG2 = "To enter new program section click <b>HERE</b>";
        include_once('program_entry.php');
    }
}

//select to create list of programs
$query_programs = 
    'SELECT 
        prog_id, 
        prog_name 
    FROM program
    ORDER BY prog_name';
$stmt3 = $db->prepare($query_programs);
$stmt3->execute();
$programs = $stmt3->fetchAll();
$stmt3->closeCursor();

//select to create list of active prog sec description
$query_prog_Desc = 
    'SELECT DISTINCT 
        prog_sec_desc  
    FROM prog_section
    WHERE prog_sec_active = true
    ORDER BY prog_sec_desc';
$stmt4 = $db->prepare($query_prog_Desc);
$stmt4->execute();
$prog_sec_Descs = $stmt4->fetchAll();
$stmt4->closeCursor();

//select to create list of possible teachers
$query_teachers_staff = 
    'SELECT 
        person_id, 
        p_fname, 
        p_lname  
    FROM person 
    WHERE p_is_volunteer=true 
    OR p_is_staff = true 
    ORDER BY p_fname, p_lname';
$stmt10 = $db->prepare($query_teachers_staff);
$stmt10->execute();
$teachers_staffs = $stmt10->fetchAll();
$stmt10->closeCursor();

//select to create list of possible rooms
$query_prog_Rooms = 
    'SELECT DISTINCT 
        prog_room  
    FROM prog_section 
    ORDER BY prog_room';
$stmt5 = $db->prepare($query_prog_Rooms);
$stmt5->execute();
$prog_Rooms = $stmt5->fetchAll();
$stmt5->closeCursor();

//concatenate the age range
if(!isset($prog_age_range))
{
    $prog_age_range = $low_prog_age_range."-".$high_prog_age_range;
}

foreach ($programs as $program){
    if ($prog_id == $program['prog_id']){
        $prog_name =  $program['prog_name'];
    }
}

//concatenate the program time
if(!isset($prog_time))
{
    $prog_time = $prog_time_spot." ".$am_pm;
}

//make sure there are no other identical program sections already in the database
    $queryCheckprog_sec= 
        'SELECT COUNT(*) 
        FROM prog_section 
        WHERE prog_id = :prog_id
        AND prog_time = :prog_time
        AND prog_day = :prog_day
        AND prog_age_range = :prog_age_range
        AND prog_sec_active = true
        AND prog_sec_desc = :prog_sec_desc';
    $stmt = $db->prepare( $queryCheckprog_sec);
    $stmt->bindValue(':prog_id', $prog_id);
    $stmt->bindValue(':prog_time', $prog_time);
    $stmt->bindValue(':prog_day', $prog_day);
    $stmt->bindValue(':prog_age_range', $prog_age_range);
    $stmt->bindValue(':prog_sec_desc', $prog_sec_desc);
    $stmt->execute();
    $countProgramSection = $stmt->fetchColumn();

if ($select == "Submit Form")
{
    
   
    if($countProgramSection >0)
    {
        //show an error if the section has already been created
        $errorMSG2 = '<b>ERROR:</b> This section has already been created.';
        //offer link to edit the section to user
        $linkMSG = "If you need you make changes to a program section click <b>HERE</b>";
       
    }
    else
    {
        //insert a new program section into the database
        $insert_program_section = 
        'INSERT INTO prog_section
            (prog_id, prog_time, prog_day, prog_age_range, prog_seat_cap, prog_room, prog_van_trans_avail, prog_sec_desc)
        VALUES
            (:prog_id, :prog_time, :prog_day, :prog_age_range, :prog_seat_cap, :prog_room, :prog_van_trans_avail, :prog_sec_desc)';
        $stmt7 = $db->prepare($insert_program_section);
        $stmt7->bindValue(':prog_id', $prog_id);
        $stmt7->bindValue(':prog_time', $prog_time);
        $stmt7->bindValue(':prog_day', $prog_day);
        $stmt7->bindValue(':prog_age_range', $prog_age_range);
        $stmt7->bindValue(':prog_seat_cap', $prog_seat_cap);
        $stmt7->bindValue(':prog_room', $prog_room);
        $stmt7->bindValue(':prog_van_trans_avail', $prog_van_trans_avail);
        $stmt7->bindValue(':prog_sec_desc', $prog_sec_desc);
        $stmt7->execute();
        $lastSecID = $db->lastInsertId();
        $stmt7->closeCursor();

        //insert into the teaches table the person designated to teach the section
        $insert_teaches = 
        'INSERT INTO teaches
            (person_id, prog_sec)
        VALUES
            (:person_id, :prog_sec)';
        $stmt7 = $db->prepare($insert_teaches);
        $stmt7->bindValue(':person_id', $person_id);
        $stmt7->bindValue(':prog_sec', $lastSecID);
        $stmt7->execute();
        $stmt7->closeCursor();

        $confirmMSG3 = "<b>CONFIRMATION: #$lastSecID</b> ";
        $linkMSG3 = "To enter a new program name click <b>HERE</b>";
        include_once('program_entry.php');
    }
}
include_once('program_entry.php');
?>
