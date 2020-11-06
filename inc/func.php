<?php
//all programs 
function get_all_prog_names(){
    include('../inc/db_connect.php');

    $query_all_prog_secs = 
    'SELECT prog_name, ps.prog_id 
    FROM program pr
    JOIN prog_section ps ON ps.prog_id = pr.prog_id
    GROUP BY ps.prog_id';
    $stmt = $db->prepare($query_all_prog_secs);
    $stmt->execute();
    $all_prog_secs = $stmt->fetchAll();
    $stmt->closeCursor();

    return $all_prog_secs;
}

//active programs
function get_active_prog_names(){
    include('../inc/db_connect.php');

    $query_all_active_prog_secs = 
    'SELECT 
        ps.prog_id, 
        ps.prog_sec,
        p.prog_name, 
        ps.prog_sec_desc,
        prog_day
    FROM prog_section ps
        JOIN program p
            ON ps.prog_id = p.prog_id
        JOIN enrollment e
            ON ps.prog_sec = e.prog_sec
    WHERE ps.prog_sec_active = true
    GROUP BY ps.prog_id';
    $stmt = $db->prepare($query_all_active_prog_secs);
    $stmt->execute();
    $active_prog_secs = $stmt->fetchAll();
    $stmt->closeCursor();

    return $active_prog_secs;
}

//edit_prog_sec dropdown fix
function get_prog_sec_list(){
    include('../inc/db_connect.php');

    $query_program_sections = 
    'SELECT 
        p.prog_id, 
        p.prog_name, 
        ps.prog_age_range, 
        ps.prog_day, 
        ps.prog_sec_desc,  
        ps.prog_sec, 
        ps.prog_sec_active, 
        ps.prog_van_trans_avail, 
        ps.prog_seat_cap, 
        ps.prog_room,
        ps.prog_time
    FROM prog_section ps
	JOIN program p
		ON ps.prog_id = p.prog_id
    WHERE  
		ps.prog_sec_active = true
    ORDER BY p.prog_name, ps.prog_day, ps.prog_sec, ps.prog_age_range';
    $stmt4 = $db->prepare($query_program_sections);
    $stmt4->execute();
    $program_sections = $stmt4->fetchAll();
    $stmt4->closeCursor();

    return $program_sections;
}

//volunteers person
function get_volunteers(){
    include('../inc/db_connect.php');

    $query_volunteers =
    'SELECT p.person_id,
        p_fname,
        p_lname
    FROM person p
    JOIN donations d ON d.person_id = p.person_id
    WHERE p_is_volunteer = TRUE
    AND don_type = "Time"
    OR don_type = "Service"
    GROUP BY p_lname, p_fname
    ORDER BY p_lname, p_fname';
    $stmt = $db->prepare($query_volunteers);
    $stmt->execute();
    $volunteers = $stmt->fetchAll();
    $stmt->closeCursor();

    return $volunteers;

}

//get days
function get_days(){
    include('../inc/db_connect.php');

    $query_days =
    'SELECT prog_day
    FROM prog_section
    GROUP BY prog_day
    ORDER BY FIELD(prog_day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday", "Special Event")';
    $stmt = $db->prepare($query_days);
    $stmt->execute();
    $days = $stmt->fetchAll();
    $stmt->closeCursor();

    return $days;
}

function get_org_list(){
    include('../inc/db_connect.php');

    $query_organization_list = 
    'SELECT org_name, org_id 
    FROM organizations
    ORDER BY org_name';
    $stmt1 = $db->prepare($query_organization_list);
    $stmt1->execute();
    $org_list = $stmt1->fetchAll();
    $stmt1->closeCursor();

    return $org_list;
}

//donation by person queries
function dono_person($passed_person){
    include('../inc/db_connect.php');

    $query_dono_person =
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
    WHERE don_type = "Item"
    OR don_type = "Funds"
    Order by d.don_id DESC';
    $stmt = $db->prepare($query_dono_person);
    $stmt->bindValue(':person_id', $passed_person);
    $stmt->execute();
    $dono_by_person = $stmt->fetchAll();
    $stmt->closeCursor();

    return $dono_by_person;
}

//donation by desc queries
function dono_desc($passed_desc){
    include('../inc/db_connect.php');

    $query_dono_desc =
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
        AND d.don_desc = :don_desc
    JOIN person p 
        ON p.person_id = d.person_id
    JOIN program_donation pd 
        ON pd.don_id = d.don_id
    JOIN prog_section ps 
        ON ps.prog_sec = pd.prog_sec
    JOIN program pr 
        ON pr.prog_id = ps.prog_id
    WHERE don_type = "Item"
    OR don_type = "Funds"
    Order by d.don_id DESC';
    $stmt = $db->prepare($query_dono_desc);
    $stmt->bindValue(':don_desc', $passed_desc);
    $stmt->execute();
    $dono_by_desc = $stmt->fetchAll();
    $stmt->closeCursor();

    return $dono_by_desc;

}

//donation by program
function dono_prog($passed_prog){
    include('../inc/db_connect.php');

    $query_dono_prog =
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
    WHERE don_type = "Item"
    OR don_type = "Funds"
    Order by d.don_id DESC';
    $stmt = $db->prepare($query_dono_prog);
    $stmt->bindValue(':prog_id', $passed_prog);
    $stmt->execute();
    $dono_by_prog = $stmt->fetchAll();
    $stmt->closeCursor();

    return $dono_by_prog;

}

//donation organization query
function get_donation_by_org($passed_org){
    include('../inc/db_connect.php');

    $query_by_org =
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
    WHERE don_type = "Item"
    OR don_type = "Funds"
    Order by d.don_id DESC';
    $stmt4 = $db->prepare($query_by_org);
    $stmt4->bindValue(':org_id', $passed_org);
    $stmt4->execute();
    $dono_by_org = $stmt4->fetchAll();
    $stmt4->closeCursor();

    return $dono_by_org;
}

//sanitize string function
function safeEcho($str)
{
    echo filter_var($str, FILTER_SANITIZE_STRING);
}

//allows letters, hyphens, asterisk and spaces
function allowHyphenLastNames($str)
{
    echo preg_replace("/[^A-Za-z \- \*]/", "", $str);
}

//allows letters, spaces, apostrophes, and periods
function removeChars($str)
{
    echo preg_replace("/[^a-zA-Z \s \. \']/", "", $str);
}

//allows letters, numbers, spaces, hyphens, commas, and semicolons
function formatAllergies($str)
{
    echo preg_replace("/[^A-Za-z0-9 \- \, \;]/", "", $str);
}

function formatDonation($string) {
 
    return preg_replace('/[^A-Za-z0-9 \-]/', '', $string); // Removes special chars.
}

//allows letters, numbers, spaces, periods and apostrophes
function formatAddress($str)
{
    echo preg_replace("/[^A-Za-z0-9\s \. \']/", "", $str);
} 


function navbar($nav_click){
    $entry = 'entry';
    $edit = 'edit';
    $report = 'report';
    $admin = 'admin';
    $active_entry = '';
    $active_edit = '';
    $active_report = '';
    $active_admin = '';

    if($nav_click == 'entry'){
        $active_entry = 'active';
    }
    if($nav_click == 'edit'){
        $active_edit = 'active';
    }
    if($nav_click == 'report'){
        $active_report = 'active';
    }
    if($nav_click == 'admin'){
        $active_admin = 'active';
    }

    $html_string = "<div class='container-fluid' id='all'>    
    <div class='row'>
        <div class='col-12'>
            <nav class='navbar navbar-light' style='background-color: #e3f2fd;'>
                <ul class='nav nav-tabs'>
                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle $active_entry' data-toggle='dropdown' href='#' role='menu'>Data Entry</a>
                        <div class='dropdown-menu'>
                            <a class='dropdown-item' href='../entry/child_index.php?nav_click=$entry'> Child Entry Form</a>
                            <a class='dropdown-item' href='../entry/enroll_entry_index.php?nav_click=$entry'>Enrollment Form</a>
                            <a class='dropdown-item' href='../entry/donation_entry_index.php?nav_click=$entry'>Donation Entry Form</a>
                            <a class='dropdown-item' href='../entry/person_entry_index.php?nav_click=$entry'>Person Entry Form</a>
                            <a class='dropdown-item' href='../entry/program_entry_index.php?nav_click=$entry'>Program Entry Form</a>
                            <a class='dropdown-item' href='../entry/organization_entry_index.php?nav_click=$entry'>Organization Entry Form</a>
                        </div>
                    </li>
                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle $active_edit' data-toggle='dropdown' href='#'>Edit</a>
                        <div class='dropdown-menu'>
                            <a class='dropdown-item' href='../edit/edit_child_index.php?nav_click=$edit'>Edit Child Form</a>
                            <a class='dropdown-item' href='../edit/edit_enrollment_index.php?nav_click=$edit'>Edit Enrollment Form</a>
                            <a class='dropdown-item' href='../edit/edit_donation_index.php?nav_click=$edit'>Edit Donation Form</a>
                            <a class='dropdown-item' href='../edit/edit_person_index.php?nav_click=$edit'>Edit Person Form</a>
                            <a class='dropdown-item' href='../edit/edit_program_index.php?nav_click=$edit'>Edit Program Form</a>
                            <a class='dropdown-item' href='../edit/edit_program_section_index.php?nav_click=$edit'>Edit Program Section Form</a>
                            <a class='dropdown-item' href='../edit/edit_organization_index.php?nav_click=$edit'>Edit Organization Form</a>
                        </div>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link $active_report' href='../reports/reports.php?nav_click=$report'>Reports</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link $active_admin' href='../admin/admin.php?nav_click=$admin'>Admin</a>
                    </li>
                    
                    
                    <li class='nav-item'>
                        <a class='nav-link' href='../home/home.php'>Home</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>";

    return $html_string;
    /* return $active; */
}

?>