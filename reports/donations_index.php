<?php
include('../inc/func.php');
include('../inc/db_connect.php');

$hide = filter_input(INPUT_POST, 'hide');
$action = filter_input(INPUT_POST, 'action');
$org_name = filter_input(INPUT_POST, 'org_name');
$don_desc = filter_input(INPUT_POST, 'don_desc');
$person = filter_input(INPUT_POST, 'person');
$program = filter_input(INPUT_POST, 'prog_name');


$all_prog_secs = get_all_prog_names();
$dono_by_desc = dono_desc($don_desc);
$dono_by_prog = dono_prog($program);

$query_donors =
    'SELECT p.person_id,
        p_fname, 
        p_lname,
        p_cell_phone,
        p_email,
        don_type, 
        don_desc,
        don_date, 
        prog_name, 
        org_name
    FROM donations d
    JOIN organizations o ON o.org_id = d.org_id
    JOIN person p ON p.person_id = d.person_id
    JOIN program_donation pd ON pd.don_id = d.don_id
    JOIN prog_section ps ON ps.prog_sec = pd.prog_sec
    JOIN program pr ON pr.prog_id = ps.prog_id
    WHERE don_type = "Item"
    OR don_type = "Funds"
    group by p_fname, p_lname
    Order by p_lname';
$stmt = $db->prepare($query_donors);
$stmt->execute();
$donors = $stmt->fetchAll();
$stmt->closeCursor();

$query_dono_desc =
    'SELECT don_desc
    FROM donations
    WHERE don_type = "Item"
    OR don_type = "Funds"
    GROUP BY don_desc
    ORDER BY don_desc';
$stmt1 = $db->prepare($query_dono_desc);
$stmt1->execute();
$dono_desc = $stmt1->fetchAll();
$stmt1->closeCursor();

$query_org = 
    'SELECT org_name, o.org_id 
    FROM organizations o
    JOIN donations d ON d.org_id = o.org_id
    WHERE don_type = "Item"
    OR don_type = "Funds"
    GROUP BY org_name
    ORDER BY org_name';
$stmt2 = $db->prepare($query_org);
$stmt2->execute();
$org_list = $stmt2->fetchAll();
$stmt2->closeCursor();




include('donations_home.php');
?>



