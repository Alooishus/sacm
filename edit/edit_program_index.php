<?php
include('../inc/db_connect.php');

$action = filter_input(INPUT_POST, 'action');
$select = filter_input(INPUT_POST, 'select');
$prog_id = filter_input(INPUT_POST, 'prog_id', FILTER_VALIDATE_INT);
$prog_name = filter_input(INPUT_POST, trim('prog_name'));
$prog_name =ucwords(strtolower($prog_name));
$errorMSG = null;
$linkMSG = null;
$confirmMSG = null;

//populate list of program names from which to edit
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

if ($action == "Review Program"){

    //make sure new name doesn't already exist
    $queryCheckprog_name = 
        'SELECT COUNT(*) 
        FROM program 
        WHERE prog_name =:prog_name
        and prog_id <> :prog_id';
    $stmt = $db->prepare( $queryCheckprog_name);
    $stmt->bindValue(':prog_name', $prog_name);
    $stmt->bindValue(':prog_id', $prog_id);
    $stmt->execute();
    $countProgramName = $stmt->fetchColumn();

    //give a msg if the name is already in use
    if ($countProgramName > 0 )
    {
        $linkMSG = "<b>HERE</b>";
        $errorMSG = '<b>ERROR: This program name already exists. Please choose a different name or edit the Progam Section</b>';
        include_once('edit_program_index.php');     
    }

    // if name is unique, then that portion of html has been activated
    // if user choose to submit name will be updated
    if ($select == "Submit Form")
    {
        //update program name if it doesn't already exist
        $update_prog_name = 
            'UPDATE program
            SET prog_name = :prog_name
            WHERE prog_id = :prog_id';
        $stmt = $db->prepare($update_prog_name);
        $stmt->bindValue(':prog_id', $prog_id);
        $stmt->bindValue(':prog_name', $prog_name);
        $stmt->execute();
        $stmt->closeCursor();
        
        $confirmMSG = "<b>Confirmation:</b> The program name has been changed to $prog_name";

        //refresh program list
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

        $action = null;
    }
}
include_once('edit_program.php');
?>
