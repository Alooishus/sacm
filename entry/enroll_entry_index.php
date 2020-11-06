<?php
include('../inc/db_connect.php');
$action = filter_input(INPUT_POST, 'action');
$search = filter_input(INPUT_POST, 'search');
$c_id =  filter_input(INPUT_POST, 'c_id');
$c_fname = filter_input(INPUT_POST, trim('c_fname'));
$c_fname =ucwords(strtolower($c_fname));
$c_lname = filter_input(INPUT_POST, trim('c_lname'));
$c_lname =ucwords(strtolower($c_lname));
$c_dob =  filter_input(INPUT_POST, 'c_dob');
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
$person_id =  filter_input(INPUT_POST, 'person_id'); 
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
$has_vehicle = filter_input(INPUT_POST, 'has_vehicle');
$p_is_guardian = filter_input(INPUT_POST, 'p_is_guardian');
$p_is_donor = filter_input(INPUT_POST, 'p_is_donor');
$p_is_volunteer = filter_input(INPUT_POST, 'p_is_volunteer');
$p_is_staff = filter_input(INPUT_POST, 'p_is_staff');
$p_is_benefactor = filter_input(INPUT_POST, 'p_is_benefactor');
$action = filter_input(INPUT_POST, 'action');
$org_id = filter_input(INPUT_POST, 'org_id');
$org_name = filter_input(INPUT_POST, 'org_name');
$prog_sec = filter_input(INPUT_POST, 'prog_sec');
$prog_name = filter_input(INPUT_POST, trim('prog_name'));
$prog_time = filter_input(INPUT_POST, trim('prog_time'));
$prog_day = filter_input(INPUT_POST, trim('prog_day'));
$prog_age_range = filter_input(INPUT_POST, trim('prog_age_range'));
$prog_sec_desc = filter_input(INPUT_POST, trim('prog_sec_desc'));
$trans_type_to = filter_input(INPUT_POST, trim('trans_type_to'));
$trans_type_from = filter_input(INPUT_POST, trim('trans_type_from'));
$e_consent_sacm_van = filter_input(INPUT_POST, 'e_consent_sacm_van');
$e_consent_attend = filter_input(INPUT_POST, 'e_consent_attend');
$e_consent_sm_phone = filter_input(INPUT_POST, 'e_consent_sm_phone');
$e_consent_emg_med = filter_input(INPUT_POST, 'e_consent_emg_med');
$e_consent_to_publish = filter_input(INPUT_POST, 'e_consent_to_publish');
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



//to get child and parent info
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

if($child_count <1)
{
    $showForm=false;
    $person=null;

}

//logic to show parent portion of enrollment form
if($c_id >0 &&$c_id !==null && $c_id !==false && $person_id !==false && $person_id !==null ) 
{
    $showForm=true;
}
else if($child_count==0 && $action == "Search")
{
    $errorMSG2 = '<b>ERROR: No Children with this name and birthday have been registered. Please Check your spelling and click HERE to try again</b>';
    $linkMSG = "<b>Register a new child HERE</b>";
    //$action = null;
    $showForm=false;
}

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


$query_child = 
    'SELECT * 
    FROM child
    WHERE c_id = :c_id;';
$stmt2 = $db->prepare($query_child);
$stmt2->bindValue(':c_id', $c_id);
$stmt2->execute();
$childArray = $stmt2->fetchAll();
$stmt2->closeCursor();

foreach($childArray as $child){} //initializes details of child


$query_child_guardians = 
    'SELECT 
        person_id, 
        p_fname, 
        p_lname
    FROM child_guardian_info_table
    WHERE c_id =:c_id
    GROUP BY person_id';
$stmt3 = $db->prepare($query_child_guardians);
$stmt3->bindValue(':c_id', $c_id);
$stmt3->execute();
$guardians = $stmt3->fetchAll();
$stmt3->closeCursor();


$query_person = 
    'SELECT 
        p.*, 
        g.has_vehicle
    FROM person p
    JOIN guardian g
        ON p.person_id = g.person_id
    WHERE p.person_id= :person_id';
$stmt4 = $db->prepare($query_person);
$stmt4->bindValue(':person_id', $person_id);
$stmt4->execute();
$persons = $stmt4->fetchAll();
$stmt4->closeCursor();

foreach($persons as $person){} //initializes details of person

//for drop down of existing organizations
$query_organizations = 
    'SELECT 
        org_id, 
        org_name 
    FROM organizations
    ORDER BY org_name';
$stmt5 = $db->prepare($query_organizations);
$stmt5->execute();
$organizations = $stmt5->fetchAll();
$stmt5->closeCursor();


$query_school = 
    'SELECT DISTINCT 
        c_school 
    FROM child
    ORDER BY c_school';
$stmt6 = $db->prepare($query_school);
$stmt6->execute();
$schools = $stmt6->fetchAll();
$stmt6->closeCursor();

/* **Shows Program sections that c_id is not enrolled in*/

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
    Join program p
        ON ps.prog_id = p.prog_id
    WHERE ps.prog_sec_active = true
        AND ps.prog_sec NOT IN(
                                SELECT 
                                    e.prog_sec 
                                FROM enrollment e
                                WHERE e.c_id =:c_id
                                )
    GROUP BY ps.prog_sec
    ORDER BY 
        p.prog_name, 
        ps.prog_day, 
        ps.prog_time, 
        ps.prog_sec,
        ps.prog_age_range';
$stmt7 = $db->prepare($query_activeSections);
$stmt7->bindValue(':c_id', $c_id);
$stmt7->execute();
$active_sections = $stmt7->fetchAll();
$stmt7->closeCursor();


if ($action == "Review Form")
{
    $query_spec_prog_sec = 
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
        WHERE ps.prog_sec = :prog_sec';
    $stmt31 = $db->prepare($query_spec_prog_sec);
    $stmt31->bindValue(':prog_sec', $prog_sec);
    $stmt31->execute();
    $prog_sec_review_details = $stmt31->fetchAll();
    $stmt31->closeCursor();

    foreach($prog_sec_review_details as $prog_sec_review_detail)
    {
        $progName = $prog_sec_review_detail['prog_name'];
        $progDay = $prog_sec_review_detail['prog_day'];
        $progRange = $prog_sec_review_detail['prog_age_range'];
        $progDesc  = $prog_sec_review_detail['prog_sec_desc'];
    }

}

if($showForm)
{
    if ($action == "Submit Form")
    {
        $update_child = 
            'UPDATE 
                child
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
        $stmt8 = $db->prepare($update_child);
        $stmt8->bindValue(':c_id', $c_id);
        $stmt8->bindValue(':c_fname', $c_fname);
        $stmt8->bindValue(':c_lname', $c_lname);
        $stmt8->bindValue(':c_st_address', $c_st_address);
        $stmt8->bindValue(':c_city', $c_city);
        $stmt8->bindValue(':c_state', $c_state);
        $stmt8->bindValue(':c_zipcode', $c_zipcode);
        $stmt8->bindValue(':c_gender', $c_gender);
        $stmt8->bindValue(':c_email', $c_email);
        $stmt8->bindValue(':c_dob', $c_dob);
        $stmt8->bindValue(':c_allergies', $c_allergies);
        $stmt8->bindValue(':c_cell_phone', $c_cell_phone);
        $stmt8->bindValue(':c_school', $c_school);
        $stmt8->bindValue(':c_grade', $c_grade);
        $stmt8->bindValue(':c_emg_contact_name', $c_emg_contact_name);
        $stmt8->bindValue(':c_emg_contact_num', $c_emg_contact_num);
        $stmt8->bindValue(':c_needs_trans', $c_needs_trans);
        $stmt8->execute();
        $stmt8->closeCursor();

        $update_person = 

        'UPDATE 
            person p
        JOIN
            guardian g	 
            ON p.person_id = g.person_id
        SET
            p.org_id = :org_id,
            p.p_fname =  :p_fname,  
            p.p_lname =  :p_lname,
            p.p_st_address = :p_st_address,
            p.p_city = :p_city, 
            p.p_state =   :p_state,
            p.p_zipcode = :p_zipcode,
            p.p_email = :p_email, 
            p.p_cell_phone = :p_cell_phone, 
            p.p_work_phone = :p_work_phone, 
            p.p_home_phone = :p_home_phone,
            p.p_is_guardian = :p_is_guardian,
            g.has_vehicle = :has_vehicle
        WHERE
            p.person_id =:person_id';
        $stmt9 = $db->prepare($update_person);
        $stmt9->bindValue(':org_id', $org_id);
        $stmt9->bindValue(':p_fname', $p_fname);
        $stmt9->bindValue(':p_lname', $p_lname);
        $stmt9->bindValue(':p_st_address', $p_st_address);
        $stmt9->bindValue(':p_city', $p_city);
        $stmt9->bindValue(':p_state', $p_state);
        $stmt9->bindValue(':p_zipcode', $p_zipcode);
        $stmt9->bindValue(':p_email', $p_email);
        $stmt9->bindValue(':p_cell_phone', $p_cell_phone);
        $stmt9->bindValue(':p_work_phone', $p_work_phone);
        $stmt9->bindValue(':p_home_phone', $p_home_phone);
        $stmt9->bindValue(':p_is_guardian', $p_is_guardian);
        $stmt9->bindValue(':has_vehicle', $has_vehicle);
        $stmt9->bindValue(':person_id', $person_id);
        $stmt9->execute();
        $stmt9->closeCursor();

        $query_child = 
            'SELECT * 
            FROM child
            WHERE c_id = :c_id;';
        $stmt2 = $db->prepare($query_child);
        $stmt2->bindValue(':c_id', $c_id);
        $stmt2->execute();
        $childArray = $stmt2->fetchAll();
        $stmt2->closeCursor();


        $query_person = 
            'SELECT *
            FROM person
            WHERE person_id= :person_id';
        $stmt4 = $db->prepare($query_person);
        $stmt4->bindValue(':person_id', $person_id);
        $stmt4->execute();
        $persons = $stmt4->fetchAll();
        $stmt4->closeCursor();


        //for drop down of existing organizations
        $query_organizations = 
            'SELECT 
                org_id, 
                org_name 
            FROM organizations
            ORDER BY org_name';
        $stmt5 = $db->prepare($query_organizations);
        $stmt5->execute();
        $organizations = $stmt5->fetchAll();
        $stmt5->closeCursor();

        foreach($organizations as $organization)
        {
            if($org_id == $organization['org_id'])
            {
                $org_name = $organization['org_name'];
            }
        }

        $query_child_already_enrolled_in_section = 
            'SELECT COUNT(*)
            FROM enrollment
            WHERE c_id = :c_id
            AND prog_sec = :prog_sec';
        $stmt10 = $db->prepare($query_child_already_enrolled_in_section);
        $stmt10->bindValue(':c_id', $c_id);
        $stmt10->bindValue(':prog_sec', $prog_sec);
        $stmt10->execute();
        $enroll_count = $stmt10->fetchColumn();
        $stmt10->closeCursor();


        if ($enroll_count == 0)
        {
            //insert
            $insert_enrollment = 
            'INSERT INTO enrollment
                (c_id, person_id, prog_sec, e_consent_sacm_van, e_consent_attend, e_consent_sm_phone, e_consent_emg_med, e_consent_to_publish)
            VALUES
                (:c_id, :person_id, :prog_sec, :e_consent_sacm_van, :e_consent_attend, :e_consent_sm_phone, :e_consent_emg_med, :e_consent_to_publish)';
            $stmt11 = $db->prepare($insert_enrollment);
            $stmt11->bindValue(':c_id', $c_id);
            $stmt11->bindValue(':person_id', $person_id);
            $stmt11->bindValue(':prog_sec', $prog_sec);
            $stmt11->bindValue(':e_consent_sacm_van', $e_consent_sacm_van);
            $stmt11->bindValue(':e_consent_attend', $e_consent_attend);
            $stmt11->bindValue(':e_consent_sm_phone', $e_consent_sm_phone);
            $stmt11->bindValue(':e_consent_emg_med', $e_consent_emg_med);
            $stmt11->bindValue(':e_consent_to_publish', $e_consent_to_publish);
            $stmt11->execute();
            $last_e_num = $db->lastInsertId(); 
            $stmt11->closeCursor();

            //insert
            $insert_transportation = 
            'INSERT INTO transportation
                (c_id, prog_sec, trans_type_to, trans_type_from)
            VALUES
                (:c_id, :prog_sec, :trans_type_to, :trans_type_from)';
            $stmt12 = $db->prepare($insert_transportation);
            $stmt12->bindValue(':c_id', $c_id);
            $stmt12->bindValue(':prog_sec', $prog_sec);
            $stmt12->bindValue(':trans_type_to', $trans_type_to);
            $stmt12->bindValue(':trans_type_from', $trans_type_from);
            $stmt12->execute();
            $stmt12->closeCursor();

            $hideButton = true;
            $confirmMSG= "<h5><b>CONFIRMATION #$last_e_num :</b> Child has been enrolled in the program section. <span><b>CLICK HERE to enroll  <u>DIFFERENT CHILD</u> into a program.</b></h5> <p>Choose a different program below to enroll <u>SAME child</u> in another Program.</p>";
            $action = null;
            include('enroll_entry.php');
        }
        else
        {
            $errorMSG="ERROR: Child has already been enrolled into this program section. Choose another program section";
        }
    }
}

include_once ('enroll_entry.php');
?>
