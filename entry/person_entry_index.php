<?php
include_once('../inc/db_connect.php');
$org_id = filter_input(INPUT_POST, 'org_id');
$p_fname = filter_input(INPUT_POST, trim('p_fname'));
$p_fname =ucwords(strtolower($p_fname));
$p_lname = filter_input(INPUT_POST, trim('p_lname'));
$p_lname =ucwords(strtolower($p_lname));
$p_email = filter_input(INPUT_POST, trim('p_email'), FILTER_VALIDATE_EMAIL);
$p_email =strtolower($p_email);
$p_cell_phone = filter_input(INPUT_POST, 'p_cell_phone');
$p_work_phone = filter_input(INPUT_POST, 'p_work_phone');
$p_home_phone = filter_input(INPUT_POST, 'p_home_phone');
$p_city = filter_input(INPUT_POST, trim('p_city'));
$p_city =ucwords(strtolower($p_city));
$p_zipcode = filter_input(INPUT_POST, 'p_zipcode');
$p_state = filter_input(INPUT_POST, 'p_state');
$p_st_address = filter_input(INPUT_POST, trim('p_st_address'));
$p_st_address =ucwords(strtolower($p_st_address));
//$p_is_donor = filter_input(INPUT_POST, 'p_is_donor');
$p_is_volunteer = filter_input(INPUT_POST, 'p_is_volunteer');
$p_is_staff = filter_input(INPUT_POST, 'p_is_staff');
$primary_skill_type = filter_input(INPUT_POST,trim('primary_skill_type'));
$primary_skill_type =ucwords(strtolower($primary_skill_type));
$sec_skill_type  = filter_input(INPUT_POST,trim('sec_skill_type'));
$sec_skill_type =ucwords(strtolower($sec_skill_type));
$staff_position = filter_input(INPUT_POST,trim('staff_position'));
$staff_position =ucwords(strtolower($staff_position));
$validated = false;
$confirmMSG = null;
$linkMSG = null;
$errorMSG = null;
$errorMSG3 = null;
$errorMSG4 = null;
$errorMSG5= null;

$query_organizations = 
    'SELECT org_id, org_name 
    FROM organizations
    ORDER BY org_name';
$stmt1 = $db->prepare($query_organizations);
$stmt1->execute();
$organizations = $stmt1->fetchAll();
$stmt1->closeCursor();

$action = filter_input(INPUT_POST, 'action');
//to display organization name in dropdowm list
foreach ($organizations as $organization){
    if ($org_id == $organization['org_id']){
        $org_name =  $organization['org_name'];
    }
}

//select to list documented primary_skill_type
$query_primary_skill_type = 
    'SELECT DISTINCT 
        primary_skill_type 
    FROM volunteer
    ORDER BY primary_skill_type';
$stmt2 = $db->prepare($query_primary_skill_type);
$stmt2->execute();
$primary_skill_types = $stmt2->fetchAll();
$stmt2->closeCursor();

//select to list documented sec_skill_type
$query_sec_skill_type = 
    'SELECT DISTINCT 
        sec_skill_type 
    FROM volunteer
    ORDER BY sec_skill_type';
$stmt3 = $db->prepare($query_sec_skill_type);
$stmt3->execute();
$sec_skill_types = $stmt3->fetchAll();
$stmt3->closeCursor();

//select to list documented staff_position
$query_staff_position = 
    'SELECT DISTINCT 
        staff_position 
    FROM staff
    ORDER BY staff_position';
$stmt5 = $db->prepare($query_staff_position);
$stmt5->execute();
$staff_positions = $stmt5->fetchAll();
$stmt5->closeCursor();

//select to see if person already exist in the system
$query_person_already_exists = 
    'SELECT COUNT(*)
    FROM person
    WHERE p_fname = :p_fname
    AND p_lname = :p_lname';
$stmt4 = $db->prepare($query_person_already_exists);
$stmt4->bindValue(':p_fname', $p_fname);
$stmt4->bindValue(':p_lname', $p_lname);
$stmt4->execute();
$person_count = $stmt4->fetchColumn();
$stmt4->closeCursor();
    
if ($person_count > 0)
{
    $linkMSG = "HERE";
    $errorMSG= '<b>ERROR: Person already Exists. To update this Person click </b>';
    $action=null;
}

else if ($p_is_volunteer == 1 && ((isset($primary_skill_type)&&$primary_skill_type == null))&&(isset($sec_skill_type)&&$sec_skill_type == null))
{
    $errorMSG4= "<b>ERROR: Please indicate the volunteer's skills</b>";
    $action=null;
}
else if ($p_is_staff == 1 && (isset($staff_position)&&$staff_position == null))
{
    $errorMSG5=  "<b>ERROR: Please indicate staff's position</b>";
    $action=null;
}
else
{
    $validated=true;
    if ($action == "Submit Form" && $person_count == 0)
    {
        //insert
        $insert_person = 
        'INSERT INTO person
            (org_id,p_fname, p_lname, p_st_address, p_city, p_state, p_zipcode,p_email, p_cell_phone, p_work_phone, p_home_phone, p_is_volunteer,p_is_staff)
        VALUES
            (:org_id,:p_fname, :p_lname, :p_st_address, :p_city, :p_state, :p_zipcode, :p_email, :p_cell_phone, :p_work_phone, :p_home_phone, :p_is_volunteer, :p_is_staff)';
        $stmt = $db->prepare($insert_person);
        $stmt->bindValue(':org_id', $org_id);
        $stmt->bindValue(':p_fname', $p_fname);
        $stmt->bindValue(':p_lname', $p_lname);
        $stmt->bindValue(':p_st_address', $p_st_address);
        $stmt->bindValue(':p_city', $p_city);
        $stmt->bindValue(':p_state', $p_state);
        $stmt->bindValue(':p_zipcode', $p_zipcode);
        $stmt->bindValue(':p_email', $p_email);
        $stmt->bindValue(':p_cell_phone', $p_cell_phone);
        $stmt->bindValue(':p_work_phone', $p_work_phone);
        $stmt->bindValue(':p_home_phone', $p_home_phone);
        //$stmt->bindValue(':p_is_guardian', $p_is_guardian);
        //$stmt->bindValue(':p_is_donor', $p_is_donor);
        $stmt->bindValue(':p_is_volunteer', $p_is_volunteer);
        $stmt->bindValue(':p_is_staff', $p_is_staff);
        //$stmt->bindValue(':p_is_benefactor', $p_is_benefactor);
        $stmt->execute();
        $lastPersonId = $db->lastInsertId(); 
        $stmt->closeCursor();


        if($p_is_volunteer == 1)
        {
            //select to see if person already exist in the system
            $query_volunteer_exists = 
                'SELECT COUNT(*)
                FROM volunteer
                WHERE person_id = :person_id';
            $stmt = $db->prepare($query_volunteer_exists);
            $stmt->bindValue(':person_id', $lastPersonId);
            $stmt->execute();
            $volunteer_count = $stmt->fetchColumn();
            $stmt->closeCursor();

            if($volunteer_count == 0)
            {
                $insert_volunteer = 
                'INSERT INTO volunteer
                    (person_id, primary_skill_type, sec_skill_type) 
                VALUES
                    (:person_id, :primary_skill_type, :sec_skill_type)';
                $stmt = $db->prepare($insert_volunteer);
                $stmt->bindValue(':person_id', $lastPersonId);
                $stmt->bindValue(':primary_skill_type', $primary_skill_type);
                $stmt->bindValue(':sec_skill_type', $sec_skill_type);
                $stmt->execute();
                $stmt->closeCursor();
            }
        }
        if($p_is_staff == 1)
        {
            //select to see if person already exist in the system
            $query_staff_exists = 
                'SELECT COUNT(*)
                FROM staff
                WHERE person_id = :person_id';
            $stmt = $db->prepare($query_staff_exists);
            $stmt->bindValue(':person_id', $lastPersonId);
            $stmt->execute();
            $staff_count = $stmt->fetchColumn();
            $stmt->closeCursor();

             if($staff_count == 0)
            {
                $insert_staff = 
                'INSERT INTO staff
                    (person_id, staff_position) 
                VALUES
                    (:person_id, :staff_position)';
                $stmt = $db->prepare($insert_staff);
                $stmt->bindValue(':person_id', $lastPersonId);
                $stmt->bindValue(':staff_position', $staff_position);
                $stmt->execute();
                $stmt->closeCursor();
            } 
        }
        $confirmMSG = "<b>CONFIRMATION #$lastPersonId:</b> $p_fname $p_lname has been added.";
        $linkMSG2 = "<b>enter a new person by clicking HERE</b>";
        $org_id = null;
        $p_fname = null;
        $p_lname = null;
        $p_email = null;
        $p_cell_phone = null;
        $p_work_phone = null;
        $p_home_phone = null;
        $p_city = null;
        $p_zipcode = null;
        $p_state = null;
        $p_st_address =null;
        $p_is_donor = null;
        $p_is_volunteer = null;
        $p_is_staff = null;
        //$p_is_benefactor = null;
        $primary_skill_type = null;
        $sec_skill_type  = null;
        $staff_position = null;
        include_once('person_entry.php');
    }
}
include_once('person_entry.php');
?>

