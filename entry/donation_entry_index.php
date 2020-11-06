<?php 
include('../inc/db_connect.php');
$action = filter_input(INPUT_POST, 'action');
$select = filter_input(INPUT_POST, 'select');
$p_fname = filter_input(INPUT_POST, trim('p_fname'));
$p_fname =ucwords(strtolower($p_fname));
$p_lname = filter_input(INPUT_POST, trim('p_lname'));
$p_lname =ucwords(strtolower($p_lname));
$don_desc = filter_input(INPUT_POST,trim('don_desc'));
$don_desc =ucwords(strtolower($don_desc));
$don_type = filter_input(INPUT_POST,trim('don_type'));
$don_type =ucwords(strtolower($don_type));
$org_id  = filter_input(INPUT_POST,'org_id');
$org_name  = filter_input(INPUT_POST,'org_name');
$prog_sec = filter_input(INPUT_POST, 'prog_sec');
//set time zone
date_default_timezone_set('America/New_York');
//get time for orderDate
$don_date = date("Y-m-d");
//echo $don_date;
$errorMSG = null;
$errorMSG2 = null;
$linkMSG = null;
$linkMSG2 = null;
$confirmMSG = null;
$errorMSG3= null;
$errorMSG4=null;

$query_don_types = 
    'SELECT DISTINCT 
        don_type 
    FROM donations
    ORDER BY don_type';
$stmta = $db->prepare($query_don_types);
$stmta->execute();
$don_types = $stmta->fetchAll();
$stmta->closeCursor();

$query_don_desc = 
    'SELECT DISTINCT 
        don_desc 
    FROM donations
    ORDER BY don_desc';
$stmtb = $db->prepare($query_don_desc);
$stmtb->execute();
$don_descs = $stmtb->fetchAll();
$stmtb->closeCursor();

$query_organization_list = 
    'SELECT * 
    FROM organizations
    ORDER BY org_name';
$stmt1 = $db->prepare($query_organization_list);
$stmt1->execute();
$organizationLists = $stmt1->fetchAll();
$stmt1->closeCursor();
//echo '<br/>org_id = '.$org_id;

$query_activeSections = 
    'SELECT 
        p.prog_id, 
        p.prog_name, 
        ps.prog_sec, 
        ps.prog_sec_desc 
    FROM prog_section ps
        JOIN program p
            ON ps.prog_id = p.prog_id
    WHERE 
        ps.prog_sec_active = true
    GROUP BY p.prog_id
    ORDER BY p.prog_name, ps.prog_sec';
$stmt3 = $db->prepare($query_activeSections);
$stmt3->execute();
$active_sections = $stmt3->fetchAll();
$stmt3->closeCursor();

//select to see if person already exist in the system
$query_person_already_exists =
    'SELECT COUNT(*)
    FROM person
    WHERE p_fname = :p_fname
    AND p_lname = :p_lname';
$stmt2 = $db->prepare($query_person_already_exists);
$stmt2->bindValue(':p_fname', $p_fname);
$stmt2->bindValue(':p_lname', $p_lname);
$stmt2->execute();
$person_count = $stmt2->fetchColumn();
$stmt2->closeCursor();
//echo'<br/>person_count = '. $person_count;

//select to get existing persons id
$query_person_already_exists = 
    'SELECT person_id
    FROM person
    WHERE p_fname = :p_fname
    AND p_lname = :p_lname';
$stmt4 = $db->prepare($query_person_already_exists);
$stmt4->bindValue(':p_fname', $p_fname);
$stmt4->bindValue(':p_lname', $p_lname);
$stmt4->execute();
$person_id = $stmt4->fetchColumn();
$stmt4->closeCursor();
//echo'<br/>person_id = '. $person_id;   


if (($person_id == null && $org_id == null && isset($action)) || ($person_count<1 && isset($action)))
{
    $errorMSG = '<b>ERROR:</b> Donation must be listed with a previously registered person or organization or both.';
    $linkMSG = "Register new person <b>HERE</b>";
    $linkMSG2 = "Register new organization <b>HERE</b>";
    $errorMSG2= "Enter first name of a registered donor";
    $errorMSG3= "Enter last name of a registered donor";
    $errorMSG4= "Select from registered organizations";

    $action = null;
    //include_once('donation_entry.php');
}
else
{
    if($action == "Submit Form")
    {
        $errorMSG = null;
        $linkMSG = null;
        $linkMSG2 = null;

        $update_person =
            'UPDATE person
            SET p_is_donor = true
            WHERE person_id = :person_id';
        $stmt5 = $db->prepare($update_person);
        $stmt5->bindValue(':person_id', $person_id);
        $stmt5->execute();
        $stmt5->closeCursor();

        if($don_type == "Time" || $don_type == "Service")
        {

            $is_person_person_reg_vol =
                'SELECT COUNT(*)
                FROM volunteer
                WHERE person_id = :person_id';
            $stmt2 = $db->prepare($is_person_person_reg_vol);
            $stmt2->bindValue(':person_id', $person_id);
            $stmt2->execute();
            $vol_count = $stmt2->fetchColumn();
            $stmt2->closeCursor();

            if ($vol_count<1)
            {
                $primary_skill_type = "Time";
                $sec_skill_type = "Service";
                $insert_volunteer =
                    'INSERT INTO volunteer
                    (person_id, primary_skill_type, sec_skill_type)
                VALUES
                    (:person_id, :primary_skill_type, :sec_skill_type)';
                $stmt = $db->prepare($insert_volunteer);
                $stmt->bindValue(':person_id', $person_id);
                $stmt->bindValue(':primary_skill_type', $primary_skill_type);
                $stmt->bindValue(':sec_skill_type', $sec_skill_type);
                $stmt->execute();
                $stmt->closeCursor();

                $p_is_volunteer = true;
                $update_volunteer =
                    'UPDATE person
                    SET p_is_volunteer = true
                    WHERE person_id = :person_id';
                $stmt5b = $db->prepare($update_volunteer);
                $stmt5b->bindValue(':person_id', $person_id);
                $stmt5b->execute();
                $stmt5b->closeCursor();
            }
            else
            {
                $p_is_volunteer = true;
                $update_volunteer =
                    'UPDATE person
                    SET p_is_volunteer = true
                    WHERE person_id = :person_id';
                $stmt5a = $db->prepare($update_volunteer);
                $stmt5a->bindValue(':person_id', $person_id);
                $stmt5a->execute();
                $stmt5a->closeCursor();
            }   
        }

        





        //w/o this statement donations would not post if no org was chosen
        if ($org_id == ""){$org_id=null;}
        if ($person_id == ""){$person_id=null;}
        if ($org_id == ""){$org_id=null;}

        $insert_donation = 
        'INSERT INTO donations
            (person_id, org_id, don_date, don_desc, don_type)
        VALUES
            (:person_id, :org_id, :don_date, :don_desc, :don_type)';
        $stmt6 = $db->prepare($insert_donation);
        $stmt6->bindValue(':person_id', $person_id);
        $stmt6->bindValue(':org_id', $org_id);
        $stmt6->bindValue(':don_date', $don_date);
        $stmt6->bindValue(':don_desc', $don_desc);
        $stmt6->bindValue(':don_type', $don_type);
        $stmt6->execute();
        $don_id = $db->lastInsertId(); 
        $stmt6->closeCursor();

        $insert_program_donation = 
        'INSERT INTO program_donation
            (don_id, prog_sec)
        VALUES
            (:don_id, :prog_sec)';
        $stmt7 = $db->prepare($insert_program_donation);
        $stmt7->bindValue(':don_id', $don_id);
        $stmt7->bindValue(':prog_sec', $prog_sec);
        $stmt7->execute();
        $stmt7->closeCursor();

        $confirmMSG = "<b>CONFIRMATION #$don_id:</b> $don_type Donation of <b>$don_desc</b> recorded on $don_date.";
        $linkMSG2 = "Enter another donation <b>HERE</b>";
        $action = null;
        $select = null;
        $p_fname =null;
        $p_lname =null;
        $don_desc =null;
        $don_type =null;
        $org_id  =null;
        $org_name  = null;
        $prog_sec = null;

    }
}
include_once('donation_entry.php');
?>