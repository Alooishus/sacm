<?php
include('../inc/db_connect.php');
$action = filter_input(INPUT_POST, 'action');
$search = filter_input(INPUT_POST, 'search');
$c_id =  filter_input(INPUT_POST, 'c_id');
$c_fname = filter_input(INPUT_POST, trim('c_fname'));
$c_fname =ucwords(strtolower($c_fname));
$c_lname = filter_input(INPUT_POST, trim('c_lname'));
$c_lname =ucwords(strtolower($c_lname));
$c_dob =  filter_input(INPUT_POST, trim('c_dob'));
$c_fname2 = filter_input(INPUT_POST, trim('c_fname2'));
$c_fname2 =ucwords(strtolower($c_fname2));
$c_lname2 = filter_input(INPUT_POST, trim('c_lname2'));
$c_lname2 =ucwords(strtolower($c_lname2));
$c_dob2 =  filter_input(INPUT_POST, trim('c_dob2'));
$c_active = filter_input(INPUT_POST, trim('c_active'));
$c_gender = filter_input(INPUT_POST, trim('c_gender'));
$c_grade = filter_input(INPUT_POST, trim('c_grade'));
$c_school = filter_input(INPUT_POST, trim('c_school'));
$c_school =ucwords(strtolower($c_school));
$c_cell_phone = filter_input(INPUT_POST, trim('c_cell_phone'));
$c_email = filter_input(INPUT_POST, trim('c_email', FILTER_VALIDATE_EMAIL));
$c_email =strtolower($c_email);
$c_st_address = filter_input(INPUT_POST, trim('c_st_address'));
$c_st_address =ucwords(strtolower($c_st_address));
$c_city = filter_input(INPUT_POST, trim('c_city'));
$c_city =ucwords(strtolower($c_city));
$c_state = filter_input(INPUT_POST, 'c_state');
$c_zipcode = filter_input(INPUT_POST, trim('c_zipcode', FILTER_VALIDATE_INT));
$c_needs_trans = filter_input(INPUT_POST, 'c_needs_trans');
$c_emg_contact_name = filter_input(INPUT_POST, trim('c_emg_contact_name'));
$c_emg_contact_name = ucwords(strtolower($c_emg_contact_name));
$c_emg_contact_num = filter_input(INPUT_POST, trim('c_emg_contact_num'));
$c_allergies = filter_input(INPUT_POST, trim('c_allergies'));
$c_allergies =strtolower($c_allergies);
$c_sock_size = filter_input(INPUT_POST, trim('c_sock_size'));
$c_sock_size =strtolower($c_sock_size);
$c_under_size = filter_input(INPUT_POST, trim('c_under_size'));
$c_under_size =strtolower($c_under_size);
$c_haircut = filter_input(INPUT_POST, 'c_haircut');
$errorMSG=null;
$linkMSG=null;
$confirmMSG = null;

//select to list area schools
$query_school = 
    'SELECT DISTINCT c_school 
    FROM child
    ORDER BY c_school';
$stmt = $db->prepare($query_school);
$stmt->execute();
$schools = $stmt->fetchAll();
$stmt->closeCursor();

//select to check if child exisits in database
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

if ($child_count == 0)
{
    if(isset($action)){
        $errorMSG='<b>ERROR: No Children with this name and birthday have been registered. Please Check your spelling and try again or enter new child </b>';
        $linkMSG = "<b>HERE</b>";
        $action = null;
    }
}
else
{
    //if child already exists get their id
    $query_child_already_exists = 
        'SELECT c_id
        FROM child
        WHERE c_dob = :c_dob
        AND c_fname = :c_fname
        AND c_lname = :c_lname';
    $stmt = $db->prepare($query_child_already_exists);
    $stmt->bindValue(':c_fname', $c_fname);
    $stmt->bindValue(':c_lname', $c_lname);
    $stmt->bindValue(':c_dob', $c_dob);
    $stmt->execute();
    $c_id = $stmt->fetchColumn();
    $stmt->closeCursor();

    //get all information for child with that id
    $query_child = 
        'SELECT * 
        FROM child
        WHERE c_id = :c_id;';
    $stmt = $db->prepare($query_child);
    $stmt->bindValue(':c_id', $c_id);
    $stmt->execute();
    $childArray = $stmt->fetchAll();
    $stmt->closeCursor();

    foreach($childArray as $child)    {} //initializes details of child

    //update existing child
    if ($action == "Submit Form")
    {
        //update a child with that id
        $update_child = 
        'UPDATE child
        SET
            c_fname = :c_fname, 
            c_lname = :c_lname, 
            c_st_address = :c_st_address, 
            c_city = :c_city, 
            c_state = :c_state, 
            c_zipcode = :c_zipcode, 
            c_gender = :c_gender, 
            c_email = :c_email, 
            c_dob = :c_dob, 
            c_allergies = :c_allergies, 
            c_cell_phone = :c_cell_phone, 
            c_school = :c_school, 
            c_grade = :c_grade,
            c_emg_contact_name = :c_emg_contact_name,
            c_emg_contact_num = :c_emg_contact_num,
            c_needs_trans = :c_needs_trans,
            c_active= :c_active
        WHERE c_id = :c_id';
        $stmt = $db->prepare($update_child);
        $stmt->bindValue(':c_id', $c_id);
        $stmt->bindValue(':c_fname', $c_fname2);
        $stmt->bindValue(':c_lname', $c_lname2);
        $stmt->bindValue(':c_st_address', $c_st_address);
        $stmt->bindValue(':c_city', $c_city);
        $stmt->bindValue(':c_state', $c_state);
        $stmt->bindValue(':c_zipcode', $c_zipcode);
        $stmt->bindValue(':c_gender', $c_gender);
        $stmt->bindValue(':c_email', $c_email);
        $stmt->bindValue(':c_dob', $c_dob2);
        $stmt->bindValue(':c_allergies', $c_allergies);
        $stmt->bindValue(':c_cell_phone', $c_cell_phone);
        $stmt->bindValue(':c_school', $c_school);
        $stmt->bindValue(':c_grade', $c_grade);
        $stmt->bindValue(':c_emg_contact_name', $c_emg_contact_name);
        $stmt->bindValue(':c_emg_contact_num', $c_emg_contact_num);
        $stmt->bindValue(':c_needs_trans', $c_needs_trans);
        $stmt->bindValue(':c_active', $c_active);
        $stmt->execute();
        $stmt->closeCursor();

        $confirmMSG = "UPDATE CONFIRMATION for $c_fname2 $c_lname2";
        $linkMSG = "To update another child click HERE";

        include_once ('edit_child.php');
    }
}
include_once ('edit_child.php');
?>
