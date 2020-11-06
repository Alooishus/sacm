<?php 
include('../inc/func.php');
include('../inc/db_connect.php');

$action = filter_input(INPUT_POST, 'action');
$prog_name = filter_input(INPUT_POST, 'prog_name');
$org_name = filter_input(INPUT_POST, 'org_name');
$prog_day = filter_input(INPUT_POST, 'day');
$person = filter_input(INPUT_POST, 'person');

$previous = "";
$all_prog_secs = get_all_prog_names();
$active_prog_secs = get_active_prog_names();
$volunteers = get_volunteers();
$days = get_days();

$query_vol_by_day =
    'SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day,
    ps.prog_sec_desc, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
JOIN person p 
    ON p.person_id = d.person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
    AND ps.prog_day = :prog_day
JOIN program pr 
    ON pr.prog_id = ps.prog_id
WHERE don_type = "Time"
OR don_type = "Service"
Order by d.don_id DESC';
$stmt = $db->prepare($query_vol_by_day);
$stmt->bindValue(':prog_day', $prog_day);
$stmt->execute();
$vol_by_day = $stmt->fetchAll();
$stmt->closeCursor();

$query_vol_by_prog =
    'SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day,
    ps.prog_sec_desc, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
JOIN person p 
    ON p.person_id = d.person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
JOIN program pr 
    ON pr.prog_id = ps.prog_id
    AND pr.prog_id = :prog_id
WHERE don_type = "Service"
OR don_type = "Time"
Order by d.don_id DESC';
$stmt1 = $db->prepare($query_vol_by_prog);
$stmt1->bindValue(':prog_id', $prog_name);
$stmt1->execute();
$vol_by_prog = $stmt1->fetchAll();
$stmt1->closeCursor();

$query_vol_by_person =
    'SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day,
    ps.prog_sec_desc, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
JOIN person p 
    ON p.person_id = d.person_id
    AND d.person_id = :person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
JOIN program pr 
    ON pr.prog_id = ps.prog_id
WHERE don_type = "Time"
OR don_type = "Service"
Order by d.don_id DESC';
$stmt2 = $db->prepare($query_vol_by_person);
$stmt2->bindValue(':person_id', $person);
$stmt2->execute();
$vol_by_person = $stmt2->fetchAll();
$stmt2->closeCursor();

$query_vol_by_org_prog =
    'SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day,
    ps.prog_sec_desc, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
    AND d.org_id = :org_id
JOIN person p 
    ON p.person_id = d.person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
JOIN program pr 
    ON pr.prog_id = ps.prog_id
    AND pr.prog_id = :prog_id
WHERE don_type = "Time"
OR don_type = "Service"
Order by d.don_id DESC';
$stmt3 = $db->prepare($query_vol_by_org_prog);
$stmt3->bindValue(':org_id', $org_name);
$stmt3->bindValue(':prog_id', $prog_name);
$stmt3->execute();
$vol_by_org_prog = $stmt3->fetchAll();
$stmt3->closeCursor();


$query_vol_by_org =
    'SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day,
    ps.prog_sec_desc, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
    AND d.org_id = :org_id
JOIN person p 
    ON p.person_id = d.person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
JOIN program pr 
    ON pr.prog_id = ps.prog_id
WHERE don_type = "Time"
OR don_type = "Service"
Order by d.don_id DESC';
$stmt4 = $db->prepare($query_vol_by_org);
$stmt4->bindValue(':org_id', $org_name);
$stmt4->execute();
$vol_by_org = $stmt4->fetchAll();
$stmt4->closeCursor();

$query_all =
    'SELECT 
        p_fname,
        p_lname,
        p_st_address,
        p_city,
        p_state,
        p_zipcode,
        p_email,
        p_cell_phone,
        primary_skill_type,
        sec_skill_type
    FROM volunteer v
    JOIN person p
        ON v.person_id = p.person_id
    ORDER BY p_fname, p_lname';
$stmt5 = $db->prepare($query_all);
$stmt5->execute();
$vol_all = $stmt5->fetchAll();
$stmt5->closeCursor();

$query_org = 
    'SELECT org_name, o.org_id 
    FROM organizations o
    JOIN donations d ON d.org_id = o.org_id
    WHERE don_type = "Time"
    OR don_type = "Service"
    GROUP BY org_name
    ORDER BY org_name';
$stmt6 = $db->prepare($query_org);
$stmt6->execute();
$org_list = $stmt6->fetchAll();
$stmt6->closeCursor();

include('volunteer_home.php');
?>