<?php
include('../inc/db_connect.php');
$search_p_fname = filter_input(INPUT_POST, trim('search_p_fname'));
$search_p_fname =ucwords(strtolower($search_p_fname));
$search_p_lname = filter_input(INPUT_POST, trim('search_p_lname'));
$search_p_lname =ucwords(strtolower($search_p_lname));
$p_fname = filter_input(INPUT_POST, trim('p_fname'));
$p_fname =ucwords(strtolower($p_fname));
$p_fname2 = filter_input(INPUT_POST, trim('p_fname2'));
$p_fname2 =ucwords(strtolower($p_fname2));
$p_lname = filter_input(INPUT_POST, trim('p_lname'));
$p_lname =ucwords(strtolower($p_lname));
$p_lname2 = filter_input(INPUT_POST, trim('p_lname2'));
$p_lname2 =ucwords(strtolower($p_lname2));
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
$p_is_guardian = filter_input(INPUT_POST, 'p_is_guardian');
$p_is_donor = filter_input(INPUT_POST, 'p_is_donor');
$p_is_volunteer = filter_input(INPUT_POST, 'p_is_volunteer');
$p_is_staff = filter_input(INPUT_POST, 'p_is_staff');
$has_vehicle = filter_input(INPUT_POST, 'has_vehicle');
$action = filter_input(INPUT_POST, 'action');
$org_id = filter_input(INPUT_POST, 'org_id');
$org_name = filter_input(INPUT_POST, 'org_name');
$primary_skill_type = filter_input(INPUT_POST,trim('primary_skill_type'));
$primary_skill_type =ucwords(strtolower($primary_skill_type));
$sec_skill_type  = filter_input(INPUT_POST,trim('sec_skill_type'));
$sec_skill_type =ucwords(strtolower($sec_skill_type));
$staff_position = filter_input(INPUT_POST,trim('staff_position'));
$staff_position =ucwords(strtolower($staff_position));
$errorMSG = null;
$linkMSG = null;
$confirmMSG2 = null;
$linkMSG2 = null;



//for drop down of existing organizations
$query_organizations = 'SELECT org_id, org_name FROM organizations ORDER BY org_name';
$stmt = $db->prepare($query_organizations);
$stmt->execute();
$organizations = $stmt->fetchAll();
$stmt->closeCursor();

foreach($organizations as $organization)
{
    if($org_id == $organization['org_id'])
    {
        $org_name = $organization['org_name'];
    }
}
$query_person_already_exists = 
    'SELECT COUNT(*)
    FROM person
    WHERE p_fname = :p_fname
    AND p_lname = :p_lname';
$stmt = $db->prepare($query_person_already_exists);
$stmt->bindValue(':p_fname', $p_fname);
$stmt->bindValue(':p_lname', $p_lname);
$stmt->execute();
$person_count = $stmt->fetchColumn();
$stmt->closeCursor();

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

//print_r($primary_skill_types);

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
$query_staff_positions = 
    'SELECT DISTINCT 
        staff_position 
    FROM staff
    ORDER BY staff_position';
$stmt3 = $db->prepare($query_staff_positions);
$stmt3->execute();
$positions = $stmt3->fetchAll();
$stmt3->closeCursor();


//print_r($sec_skill_types);
if ($person_count == 0)
{
    if(isset($action)){
        $errorMSG= '<b>ERROR: No People with this first and last name have been registered. Please Check your spelling and try again.</b>';
        $linkMSG = 'Enter new person by clicking HERE</b>';
        $action = null;
    }
}
else
{
    //check if person exists
    $query_person_already_exists = 
        'SELECT person_id
        FROM person
        WHERE p_fname = :p_fname
        AND p_lname = :p_lname';
    $stmt = $db->prepare($query_person_already_exists);
    $stmt->bindValue(':p_fname', $p_fname);
    $stmt->bindValue(':p_lname', $p_lname);
    $stmt->execute();
    $person_id = $stmt->fetchColumn();
    $stmt->closeCursor();

    //check if person is registered guardian
    $query_guardian_exists =
        'SELECT COUNT(*)
        FROM guardian
        WHERE person_id = :person_id';
    $stmt = $db->prepare($query_guardian_exists);
    $stmt->bindValue(':person_id', $person_id);
    $stmt->execute();
    $guardian_count = $stmt->fetchColumn();
    $stmt->closeCursor();

    //check if person is registered as volunteer
    $query_volunteer_exists =
        'SELECT COUNT(*)
        FROM volunteer
        WHERE person_id = :person_id';
    $stmt = $db->prepare($query_volunteer_exists);
    $stmt->bindValue(':person_id', $person_id);
    $stmt->execute();
    $volunteer_count = $stmt->fetchColumn();
    $stmt->closeCursor();

    //check if person is registered as volunteer
    $query_staff_exists =
        'SELECT COUNT(*)
        FROM staff
        WHERE person_id = :person_id';
    $stmt = $db->prepare($query_staff_exists);
    $stmt->bindValue(':person_id', $person_id);
    $stmt->execute();
    $staff_count = $stmt->fetchColumn();
    $stmt->closeCursor();
    //echo $staff_count;

    //if person is a guradian check if they have vehicle 
    if($guardian_count>0)
    {
        $query_vehicle =
            'SELECT has_vehicle
            FROM guardian
            WHERE person_id = :person_id';
        $stmt = $db->prepare($query_vehicle);
        $stmt->bindValue(':person_id', $person_id);
        $stmt->execute();
        $original_has_vehicle = $stmt->fetchColumn();
        $stmt->closeCursor();

        //echo "<br>Verify has_vehicle = ".$has_vehicle;
    }

    if ($volunteer_count>0)
    {
        $query_person = 
            'SELECT 
                primary_skill_type,
                sec_skill_type
            FROM volunteer
            WHERE person_id= :person_id';
        $stmt = $db->prepare($query_person);
        $stmt->bindValue(':person_id', $person_id);
        $stmt->execute();
        $person_skills = $stmt->fetchAll();
        $stmt->closeCursor();
    }

    if($staff_count>0)
    {
        $query_person = 
            'SELECT 
                staff_position
            FROM staff
            WHERE person_id= :person_id';
        $stmt = $db->prepare($query_person);
        $stmt->bindValue(':person_id', $person_id);
        $stmt->execute();
        $position = $stmt->fetchAll();
        $stmt->closeCursor();

    }

    //if get all persons info if person exist in the system show their info in the form
    $query_person = 
        'SELECT *
        FROM person
        WHERE person_id= :person_id';
    $stmt = $db->prepare($query_person);
    $stmt->bindValue(':person_id', $person_id);
    $stmt->execute();
    $persons = $stmt->fetchAll();
    $stmt->closeCursor();

    

    foreach($persons as $person) {} //initilaize person details

    //foreach($organizations as $organization){} //initilaize organization details

    if ($action == "Submit Form")
    {
        //echo 'p_fname=';
//echo $p_fname;

        
        //insert
        $update_person = 
        'UPDATE person
        SET
            org_id = :org_id,
            p_fname =  :p_fname, 
            p_lname =  :p_lname,
            p_st_address = :p_st_address, 
            p_city = :p_city, 
            p_state =  :p_state, 
            p_zipcode = :p_zipcode,
            p_email = :p_email, 
            p_cell_phone = :p_cell_phone, 
            p_work_phone = :p_work_phone, 
            p_home_phone = :p_home_phone,
            p_is_guardian = :p_is_guardian,  
            p_is_donor = :p_is_donor, 
            p_is_volunteer = :p_is_volunteer,
            p_is_staff = :p_is_staff
        WHERE
            person_id = :person_id';
        $stmt = $db->prepare($update_person);
        $stmt->bindValue(':org_id', $org_id);
        $stmt->bindValue(':person_id', $person_id);
        $stmt->bindValue(':p_fname', $p_fname2);
        $stmt->bindValue(':p_lname', $p_lname2);
        $stmt->bindValue(':p_st_address', $p_st_address);
        $stmt->bindValue(':p_city', $p_city);
        $stmt->bindValue(':p_state', $p_state);
        $stmt->bindValue(':p_zipcode', $p_zipcode);
        $stmt->bindValue(':p_email', $p_email);
        $stmt->bindValue(':p_cell_phone', $p_cell_phone);
        $stmt->bindValue(':p_work_phone', $p_work_phone);
        $stmt->bindValue(':p_home_phone', $p_home_phone);
        $stmt->bindValue(':p_is_guardian', $p_is_guardian);
        $stmt->bindValue(':p_is_donor', $p_is_donor);
        $stmt->bindValue(':p_is_volunteer', $p_is_volunteer);
        $stmt->bindValue(':p_is_staff', $p_is_staff);
        $stmt->execute();
       
        $stmt->closeCursor();

        //if a guardian update has_vehicle

        if ($guardian_count>0)
        {
            $update_guardian =
                'UPDATE
                    guardian
                SET
                    has_vehicle = :has_vehicle
                WHERE
                    person_id = :person_id';
            $stmt2 = $db->prepare($update_guardian);
            $stmt2->bindValue(':person_id', $person_id);
            $stmt2->bindValue(':has_vehicle', $has_vehicle);
            $stmt2->execute();
            $stmt2->closeCursor();
        }

        if ($volunteer_count>0)
        {
            $update_volunteer =
                'UPDATE
                    volunteer
                SET
                    primary_skill_type = :primary_skill_type,
                    sec_skill_type = :sec_skill_type
                WHERE
                    person_id = :person_id';
            $stmt2 = $db->prepare($update_volunteer);
            $stmt2->bindValue(':person_id', $person_id);
            $stmt2->bindValue(':sec_skill_type', $sec_skill_type);
            $stmt2->bindValue(':primary_skill_type', $primary_skill_type);
            $stmt2->execute();
            $stmt2->closeCursor();
        }
        if ($staff_count>0 || $p_is_staff == true)
        {
            
           if($staff_count==0)
           {
            $insert_staff = 
            'INSERT INTO staff
                (person_id) 
            VALUES
                (:person_id)';
            $stmt = $db->prepare($insert_staff);
            $stmt->bindValue(':person_id', $person_id);
            //$stmt->bindValue(':staff_position', $staff_position);
            $stmt->execute();
            $stmt->closeCursor();
           } 
            
           if($staff_count>0)
            {
                $update_staff =
                    'UPDATE
                        staff
                    SET
                        staff_position = :staff_position
                    WHERE
                        person_id = :person_id';
                $stmt2 = $db->prepare($update_staff);
                $stmt2->bindValue(':person_id', $person_id);
                $stmt2->bindValue(':staff_position', $staff_position);
                //$stmt2->bindValue(':primary_skill_type', $primary_skill_type);
                $stmt2->execute();
                $stmt2->closeCursor();
            }
        }
    
        $confirmMSG2 = "<b>UPDATE CONFIRMATION for $p_fname2 $p_lname2</b>";
        $linkMSG2 = 'Update another person by clicking HERE';
        $action=null;
    }
}    

include ('edit_person.php');