<?php 
include('../inc/db_connect.php');
include('../inc/func.php');

date_default_timezone_set('America/New_York');
$don_date = date("Y-m-d");

$action = filter_input(INPUT_POST, 'action');
$select = filter_input(INPUT_POST, 'select');
$p_fname = filter_input(INPUT_POST, trim('p_fname'));
$p_fname =ucwords(strtolower($p_fname));
$p_lname = filter_input(INPUT_POST, trim('p_lname'));
$p_lname =ucwords(strtolower($p_lname));
$don_id  = filter_input(INPUT_POST,'don_id');
$don_desc = filter_input(INPUT_POST,trim('don_desc'));
$don_desc =ucwords(strtolower($don_desc));
$don_type = filter_input(INPUT_POST,trim('don_type'));
$don_type =ucwords(strtolower($don_type));
$org_id  = filter_input(INPUT_POST,'org_id');
$delete = filter_input(INPUT_POST, 'delete');
$row_don_id = filter_input(INPUT_POST, 'row_don_id');
$don_date2 = filter_input(INPUT_POST, 'don_date2');
$prog_name = filter_input(INPUT_POST, 'prog_name');
$don_desc2 = filter_input(INPUT_POST, 'don_desc2');

$don_type2 = filter_input(INPUT_POST, 'don_type2');
$don_id2 =   filter_input(INPUT_POST, 'don_id2');
$prog_sec2 = filter_input(INPUT_POST, 'prog_sec2');
$don_id3 =   filter_input(INPUT_POST, 'don_id3');
$don_date3 = filter_input(INPUT_POST, 'don_date3');
$prog_sec3 = filter_input(INPUT_POST, 'prog_sec3');
$don_desc3 = filter_input(INPUT_POST, 'don_desc3');
$don_type3 = filter_input(INPUT_POST, 'don_type3');
$oname = NULL;
$fname = NULL;
$lname = NULL;
$don_desc3 = formatDonation($don_desc3);
$errorMSG = null;
$linkMSG = null;
$confirmMSG = null;
$id_check = NULL;
$confirm = 0;

$query_person = 
    'SELECT person_id
    FROM person
    WHERE p_fname = :p_fname
    AND p_lname = :p_lname';
$stmt = $db->prepare($query_person);
$stmt->bindValue(':p_fname', $p_fname);
$stmt->bindValue(':p_lname', $p_lname);
$stmt->execute();
$person_id = $stmt->fetchColumn();
$stmt->closeCursor();

$query_organization_list = 
    'SELECT org_name, org_id 
    FROM organizations
    ORDER BY org_name';
$stmt1 = $db->prepare($query_organization_list);
$stmt1->execute();
$org_list = $stmt1->fetchAll();
$stmt1->closeCursor();

$query_person_org =
    'SELECT person_id, p.org_id, org_name, p_fname, p_lname
    FROM person p
    JOIN organizations o ON p.org_id = o.org_id
    WHERE p_fname = :p_fname
    AND p_lname = :p_lname';
$stmt6 = $db->prepare($query_person_org);
$stmt6->bindValue(':p_fname', $p_fname);
$stmt6->bindValue(':p_lname', $p_lname);
$stmt6->execute();
$person_org = $stmt6->fetchAll();
$stmt6->closeCursor();

$query_org = 
    'SELECT org_id
    FROM organizations
    WHERE org_id = :org_id';
$stmt5 = $db->prepare($query_org);
$stmt5->bindValue(':org_id', $org_id);
$stmt5->execute();
$organization_id = $stmt5->fetchColumn();
$stmt5->closeCursor();

$query_output =
    'SELECT org_name, p_fname, p_lname
    FROM donations d
    JOIN organizations o ON d.org_id = o.org_id
    JOIN person p ON d.person_id = p.person_id
    WHERE d.person_id = :person_id
    OR d.org_id = :org_id';
$stmt7 = $db->prepare($query_output);
$stmt7->bindValue(':person_id', $person_id);
$stmt7->bindValue(':org_id', $org_id);
$stmt7->execute();
$output = $stmt7->fetchAll();
$stmt7->closeCursor();


if($action == 'Search'){

    foreach($person_org as $p){
            $id_check = $p['org_id'];
        }
    if($person_org == FALSE){
        $errorMSG ='<b>ERROR: No People with this first and last name have been registered. Please Check your spelling and try again.</b>';
        $action = NULL;
    }elseif($organization_id != $id_check){
        $errorMSG = '<b>ERROR: That person is not affiliated with that organization.</b>';
        $action = NULL;
    }
    if($person_org == TRUE && $org_id == NULL){
        if($org_id != NULL && $organization_id != $id_check){
            $errorMSG = '<b>ERROR: That person is not affiliated with that organization.</b>';
            $action = NULL;
        }else{
            $errorMSG = NULL;
            $confirm = 1;
            $action = 'Search';
        }
    }
    if($person_org == FALSE){
        if($p_fname == NULL && $organization_id == TRUE){
            $errorMSG = NULL;
            $confirm = 1;
            $action = 'Search';
        }
    }
}
if(isset($org_id) && $p_lname == ""){
    $query_donations_by_person = 
        'SELECT d.don_id, d.don_date, d.don_desc, d.don_type,pr.prog_name, ps.prog_sec_desc, pe.p_fname, pe.p_lname, p.prog_sec, org_name
        FROM donations d
        JOIN organizations o ON d.org_id = o.org_id
        JOIN person pe ON d.person_id = pe.person_id
        JOIN program_donation p ON d.don_id = p.don_id
        JOIN prog_section ps ON p.prog_sec = ps.prog_sec
        JOIN program pr ON ps.prog_id = pr.prog_id
        WHERE d.person_id = :person_id
        OR d.org_id = :organization_id';
    $stmt2 = $db->prepare($query_donations_by_person);
    $stmt2->bindValue(':person_id', $person_id);
    $stmt2->bindValue(':organization_id', $organization_id);
    $stmt2-> execute();
    $p_donations = $stmt2->fetchAll();
    $stmt2->closeCursor();
}elseif(isset($p_lname)){
    $query_donations_by_person = 
        'SELECT d.don_id, d.don_date, d.don_desc, d.don_type,pr.prog_name, ps.prog_sec_desc, pe.p_fname, pe.p_lname, p.prog_sec, org_name
        FROM donations d
        JOIN organizations o ON d.org_id = o.org_id
        JOIN person pe ON d.person_id = pe.person_id
        JOIN program_donation p ON d.don_id = p.don_id
        JOIN prog_section ps ON p.prog_sec = ps.prog_sec
        JOIN program pr ON ps.prog_id = pr.prog_id
        WHERE d.person_id = :person_id';
    $stmt2 = $db->prepare($query_donations_by_person);
    $stmt2->bindValue(':person_id', $person_id);
    $stmt2-> execute();
    $p_donations = $stmt2->fetchAll();
    $stmt2->closeCursor();
}


    $query_activeSections = 
        'SELECT p.prog_id, p.prog_name, ps.prog_sec, ps.prog_sec_desc 
        FROM prog_section ps, program p
        WHERE ps.prog_id = p.prog_id
        GROUP BY p.prog_id
        ORDER BY p.prog_name, ps.prog_sec';
    $stmt3 = $db->prepare($query_activeSections);
    $stmt3->execute();
    $active_sections = $stmt3->fetchAll();
    $stmt3->closeCursor();

if($action == 'submit'){
        $update_donation =
            'UPDATE donations
            JOIN program_donation ON donations.don_id = program_donation.don_id
            SET
                don_date = :don_date3,
                don_desc = :don_desc3,
                don_type = :don_type3,
                prog_sec = :prog_sec3
            WHERE
                donations.don_id = :don_id2';
        $stmt4 = $db->prepare($update_donation);
        $stmt4->bindValue(':don_id2', $don_id3);
        $stmt4->bindValue(':don_date3', $don_date3);
        $stmt4->bindValue(':don_desc3', $don_desc3);
        $stmt4->bindValue(':don_type3', $don_type3);
        $stmt4->bindValue(':prog_sec3', $prog_sec3);
        $stmt4->execute();
        $stmt4->closeCursor();
        
}

if($action == 'submit'){
    $confirmMSG = "<b>UPDATE CONFIRMATION</b>";
    $linkMSG = 'Edit another donation by clicking HERE';
    $action=null;
}


if($action == 'delete'){
    $delete_donation =
        'DELETE FROM program_donation
        WHERE don_id = :don_id2;
        DELETE FROM donations
        WHERE don_id = :don_id2';
    $stmt3 = $db->prepare($delete_donation);
    $stmt3->bindValue(':don_id2', $don_id2);
    $stmt3->execute();
    $stmt3->closeCursor();

    $confirmMSG = "<b>DONATION DELETED</b>";
    $linkMSG = 'Edit another donation by clicking HERE';
    $action=null;
}

include_once('edit_donation.php');
?>