<?php 
include('../inc/db_connect.php');
$action = filter_input(INPUT_POST, 'action');
$select = filter_input(INPUT_POST, 'select');
$c_fname = filter_input(INPUT_POST, trim('c_fname'));
$c_fname =ucwords(strtolower($c_fname));
$c_lname = filter_input(INPUT_POST, trim('c_lname'));
$c_lname =ucwords(strtolower($c_lname));
$c_dob =  filter_input(INPUT_POST, trim('c_dob'));
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
$p_fname = filter_input(INPUT_POST, trim('p_fname'));
$p_fname =ucwords(strtolower($p_fname));
$p_lname = filter_input(INPUT_POST, trim('p_lname'));
$p_lname =ucwords(strtolower($p_lname));
$p_email = filter_input(INPUT_POST, trim('p_email', FILTER_VALIDATE_EMAIL));
$p_email =strtolower($p_email);
$org_id = filter_input(INPUT_POST, 'org_id');
$p_cell_phone = filter_input(INPUT_POST, trim('p_cell_phone'));
$p_work_phone = filter_input(INPUT_POST, trim('p_work_phone'));
$p_home_phone = filter_input(INPUT_POST, trim('p_home_phone'));
$p_city = filter_input(INPUT_POST, trim('p_city'));
$p_city =ucwords(strtolower($p_city));
$p_zipcode = filter_input(INPUT_POST, trim('p_zipcode'));
$p_state = filter_input(INPUT_POST, 'p_state');
$p_st_address = filter_input(INPUT_POST, trim('p_st_address'));
$p_st_address =ucwords(strtolower($p_st_address));
$p_is_guardian = filter_input(INPUT_POST, trim('p_is_guardian'));
$has_vehicle = filter_input(INPUT_POST, 'has_vehicle');
$c_needs_trans = filter_input(INPUT_POST, trim('c_needs_trans'));
$c_emg_contact_name = filter_input(INPUT_POST, trim('c_emg_contact_name'));
$c_emg_contact_name = ucwords(strtolower($c_emg_contact_name));
$c_emg_contact_num = filter_input(INPUT_POST, trim('c_emg_contact_num'));
$c_allergies = filter_input(INPUT_POST, trim('c_allergies'));
$c_allergies =strtolower($c_allergies);
$prog_sec = filter_input(INPUT_POST, trim('prog_sec'));
$prog_time = filter_input(INPUT_POST, trim('prog_time'));
$trans_type_to = filter_input(INPUT_POST, trim('trans_type_to'));
$trans_type_from = filter_input(INPUT_POST, trim('trans_type_from'));
$e_consent_sacm_van = filter_input(INPUT_POST, 'e_consent_sacm_van');
$e_consent_attend = filter_input(INPUT_POST, 'e_consent_attend');
$e_consent_sm_phone = filter_input(INPUT_POST, 'e_consent_sm_phone');
$e_consent_emg_med = filter_input(INPUT_POST, 'e_consent_emg_med');
$e_consent_to_publish = filter_input(INPUT_POST, 'e_consent_to_publish');
$errorMSG=null;
$confirmMSG= null;
$linkMSG = null;

//select to list area schools
$query_school = 
    'SELECT DISTINCT 
        c_school 
    FROM child
    ORDER BY c_school';
$stmt = $db->prepare($query_school);
$stmt->execute();
$schools = $stmt->fetchAll();
$stmt->closeCursor();

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

//populate list of active sections
$query_activeSections = 
    'SELECT 
        p.prog_id, 
        p.prog_name, 
        ps.prog_age_range, 
        ps.prog_day, 
        ps.prog_sec_desc, 
        ps.prog_time, 
        ps.prog_sec  
    FROM prog_section ps
    JOIN program p
        ON ps.prog_id = p.prog_id
    WHERE 
        ps.prog_sec_active = true
    GROUP BY ps.prog_sec
    ORDER BY 
        p.prog_name, 
        ps.prog_day, 
        ps.prog_time, 
        ps.prog_sec,
        ps.prog_age_range';
$stmt4 = $db->prepare($query_activeSections);
$stmt4->execute();
$active_sections = $stmt4->fetchAll();
$stmt4->closeCursor();

if ($action == "Submit Form"){
    $errorMSG=null;

    //select
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
        //insert
        $insert_child = 
        'INSERT INTO child
            (c_fname, c_lname, c_st_address, c_city, c_state, c_zipcode, c_gender, c_email, c_dob, c_allergies, c_cell_phone, c_school, c_grade,c_emg_contact_name,c_emg_contact_num,c_needs_trans)
        VALUES
            (:c_fname, :c_lname, :c_st_address, :c_city, :c_state, :c_zipcode, :c_gender, :c_email, :c_dob, :c_allergies, :c_cell_phone, :c_school, :c_grade,:c_emg_contact_name, :c_emg_contact_num, :c_needs_trans)';
        $stmt = $db->prepare($insert_child);
        $stmt->bindValue(':c_fname', $c_fname);
        $stmt->bindValue(':c_lname', $c_lname);
        $stmt->bindValue(':c_st_address', $c_st_address);
        $stmt->bindValue(':c_city', $c_city);
        $stmt->bindValue(':c_state', $c_state);
        $stmt->bindValue(':c_zipcode', $c_zipcode);
        $stmt->bindValue(':c_gender', $c_gender);
        $stmt->bindValue(':c_email', $c_email);
        $stmt->bindValue(':c_dob', $c_dob);
        $stmt->bindValue(':c_allergies', $c_allergies);
        $stmt->bindValue(':c_cell_phone', $c_cell_phone);
        $stmt->bindValue(':c_school', $c_school);
        $stmt->bindValue(':c_grade', $c_grade);
        $stmt->bindValue(':c_emg_contact_name', $c_emg_contact_name);
        $stmt->bindValue(':c_emg_contact_num', $c_emg_contact_num);
        $stmt->bindValue(':c_needs_trans', $c_needs_trans);
        $stmt->execute();
        $c_id = $db->lastInsertId(); 
        $stmt->closeCursor();
    }
    else
    {
        //select
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

        //update existing child
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
                c_needs_trans = :c_needs_trans
            WHERE c_id = :c_id';
        $stmt = $db->prepare($update_child);
        $stmt->bindValue(':c_id', $c_id);
        $stmt->bindValue(':c_fname', $c_fname);
        $stmt->bindValue(':c_lname', $c_lname);
        $stmt->bindValue(':c_st_address', $c_st_address);
        $stmt->bindValue(':c_city', $c_city);
        $stmt->bindValue(':c_state', $c_state);
        $stmt->bindValue(':c_zipcode', $c_zipcode);
        $stmt->bindValue(':c_gender', $c_gender);
        $stmt->bindValue(':c_email', $c_email);
        $stmt->bindValue(':c_dob', $c_dob);
        $stmt->bindValue(':c_allergies', $c_allergies);
        $stmt->bindValue(':c_cell_phone', $c_cell_phone);
        $stmt->bindValue(':c_school', $c_school);
        $stmt->bindValue(':c_grade', $c_grade);
        $stmt->bindValue(':c_emg_contact_name', $c_emg_contact_name);
        $stmt->bindValue(':c_emg_contact_num', $c_emg_contact_num);
        $stmt->bindValue(':c_needs_trans', $c_needs_trans);
        $stmt->execute();
        $stmt->closeCursor();
    }

    //select to see if person already exist in the system
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

    if ($person_count == 0){

        //insert
        $insert_person =
        'INSERT INTO person
            (p_fname, org_id, p_lname, p_st_address, p_city, p_state, p_zipcode, p_email, p_cell_phone, p_work_phone, p_home_phone,p_is_guardian)
        VALUES
            (:p_fname, :org_id, :p_lname, :p_st_address, :p_city, :p_state, :p_zipcode, :p_email, :p_cell_phone, :p_work_phone, :p_home_phone, :p_is_guardian)';
        $stmt2 = $db->prepare($insert_person);
        $stmt2->bindValue(':p_fname', $p_fname);
        $stmt2->bindValue(':p_lname', $p_lname);
        $stmt2->bindValue(':org_id', $org_id);
        $stmt2->bindValue(':p_st_address', $p_st_address);
        $stmt2->bindValue(':p_city', $p_city);
        $stmt2->bindValue(':p_state', $p_state);
        $stmt2->bindValue(':p_zipcode', $p_zipcode);
        $stmt2->bindValue(':p_email', $p_email);
        $stmt2->bindValue(':p_cell_phone', $p_cell_phone);
        $stmt2->bindValue(':p_work_phone', $p_work_phone);
        $stmt2->bindValue(':p_home_phone', $p_home_phone);
        $stmt2->bindValue(':p_is_guardian', $p_is_guardian);
        $stmt2->execute();
        $person_id = $db->lastInsertId(); 
        $stmt2->closeCursor();

        //insert guardian
        $insert_guardian = 
        'INSERT INTO guardian
            (person_id, has_vehicle)
        VALUES
            (:person_id, :has_vehicle)';
        $stmt2 = $db->prepare($insert_guardian);
        $stmt2->bindValue(':person_id', $person_id);
        $stmt2->bindValue(':has_vehicle', $has_vehicle);
        $stmt2->execute();
        $stmt2->closeCursor();
    }
    else
    {
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

        $update_person =
            'UPDATE 
                person
            SET
                p_fname = :p_fname,
                p_lname = :p_lname,
                org_id = :org_id,
                p_st_address = :p_st_address,
                p_city = :p_city,
                p_state = :p_state,
                p_zipcode = :p_zipcode,
                p_email = :p_email,
                p_cell_phone = :p_cell_phone,
                p_work_phone = :p_work_phone,
                p_home_phone = :p_home_phone,
                p_is_guardian = :p_is_guardian
            WHERE person_id = :person_id';
        $stmt2 = $db->prepare($update_person);
        $stmt2->bindValue(':person_id', $person_id);
        $stmt2->bindValue(':org_id', $org_id);
        $stmt2->bindValue(':p_fname', $p_fname);
        $stmt2->bindValue(':p_lname', $p_lname);
        $stmt2->bindValue(':p_st_address', $p_st_address);
        $stmt2->bindValue(':p_city', $p_city);
        $stmt2->bindValue(':p_state', $p_state);
        $stmt2->bindValue(':p_zipcode', $p_zipcode);
        $stmt2->bindValue(':p_email', $p_email);
        $stmt2->bindValue(':p_cell_phone', $p_cell_phone);
        $stmt2->bindValue(':p_work_phone', $p_work_phone);
        $stmt2->bindValue(':p_home_phone', $p_home_phone);
        $stmt2->bindValue(':p_is_guardian', $p_is_guardian);
        $stmt2->execute();
        $stmt2->closeCursor();

        $is_person_guardian =
            'SELECT COUNT(*)
            FROM guardian
            WHERE person_id = :person_id';
        $stmt2 = $db->prepare($is_person_guardian);
        $stmt2->bindValue(':person_id', $person_id);
        $stmt2->execute();
        $guard_count = $stmt2->fetchColumn();
        $stmt2->closeCursor();

        if($guard_count<1)
        {
            $insert_guardian = 
            'INSERT INTO guardian
                (person_id, has_vehicle)
            VALUES
                (:person_id, :has_vehicle)';
            $stmt2 = $db->prepare($insert_guardian);
            $stmt2->bindValue(':person_id', $person_id);
            $stmt2->bindValue(':has_vehicle', $has_vehicle);
            $stmt2->execute();
            $stmt2->closeCursor();
        }


    }

    if ($action == "Submit Form"){

        $query_child_already_enrolled_in_section = 
            'SELECT COUNT(*)
            FROM enrollment
            WHERE c_id = :c_id
            AND prog_sec = :prog_sec';
        $stmt = $db->prepare($query_child_already_enrolled_in_section);
        $stmt->bindValue(':c_id', $c_id);
        $stmt->bindValue(':prog_sec', $prog_sec);
        $stmt->execute();
        $enroll_count = $stmt->fetchColumn();
        $stmt->closeCursor();

        if ($enroll_count == 0)
        {
            $e_status = TRUE;

            //insert
            $insert_enrollment = 
            'INSERT INTO enrollment
                (c_id, person_id, e_status, prog_sec, e_consent_sacm_van, e_consent_attend, e_consent_sm_phone, e_consent_emg_med, e_consent_to_publish)
            VALUES
                (:c_id, :person_id, :e_status, :prog_sec, :e_consent_sacm_van, :e_consent_attend, :e_consent_sm_phone, :e_consent_emg_med, :e_consent_to_publish)';
            $stmt = $db->prepare($insert_enrollment);
            $stmt->bindValue(':c_id', $c_id);
            $stmt->bindValue(':person_id', $person_id);
            $stmt->bindValue(':e_status', $e_status);
            $stmt->bindValue(':prog_sec', $prog_sec);
            $stmt->bindValue(':e_consent_sacm_van', $e_consent_sacm_van);
            $stmt->bindValue(':e_consent_attend', $e_consent_attend);
            $stmt->bindValue(':e_consent_sm_phone', $e_consent_sm_phone);
            $stmt->bindValue(':e_consent_emg_med', $e_consent_emg_med);
            $stmt->bindValue(':e_consent_to_publish', $e_consent_to_publish);
            $stmt->execute();
            $last_e_num = $db->lastInsertId(); 
            $stmt->closeCursor();
        
            //insert
            $insert_transportation =
            'INSERT INTO transportation
                (c_id, prog_sec, trans_type_to, trans_type_from)
            VALUES
                (:c_id, :prog_sec, :trans_type_to, :trans_type_from)';
            $stmt = $db->prepare($insert_transportation);
            $stmt->bindValue(':c_id', $c_id);
            $stmt->bindValue(':prog_sec', $prog_sec);
            $stmt->bindValue(':trans_type_to', $trans_type_to);
            $stmt->bindValue(':trans_type_from', $trans_type_from);
            $stmt->execute();
            $stmt->closeCursor();

            $confirmMSG= "CONFIRMATION #$last_e_num : Child has been enrolled in the program section.";
            $linkMSG = "To enroll in another program section click HERE";
            include_once('child_entry.php');
        }
        else
        {
            $errorMSG="ERROR: Child has already been enrolled into this program section. Click <b>browser's back arrow</b> to enroll in another program section";
        }
    }
}   
include_once('child_entry.php');
?>
