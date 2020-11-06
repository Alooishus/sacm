<?php 
include('../inc/db_connect.php');

$action = filter_input(INPUT_POST, 'action');
$org_id  = filter_input(INPUT_POST,trim('org_id'));
$org_name  = filter_input(INPUT_POST,trim('org_name'));
$org_name =ucwords(strtolower($org_name));
$org_desc = filter_input(INPUT_POST,trim('org_desc'));
$org_desc =ucwords(strtolower($org_desc));
$org_st_address = filter_input(INPUT_POST,trim('org_st_address'));
$org_st_address =ucwords(strtolower($org_st_address));
$org_city = filter_input(INPUT_POST,trim('org_city'));
$org_city =ucwords(strtolower($org_city));
$org_state = filter_input(INPUT_POST,'org_state');
$org_zipcode = filter_input(INPUT_POST,'org_zipcode');
$org_phone = filter_input(INPUT_POST,'org_phone');
$org_email = filter_input(INPUT_POST, trim('org_email', FILTER_VALIDATE_EMAIL));
$org_email =strtolower($org_email);
$errorMSG=null;
$confirmMSG= null;
$linkMSG = null;
$linkMSG2 = null;

//get organizations to list
$query_organization_list = 
    'SELECT * 
    FROM organizations
    WHERE org_id <>1';
$stmt1 = $db->prepare($query_organization_list);
$stmt1->execute();
$organizationLists = $stmt1->fetchAll();
$stmt1->closeCursor();

//select get existing information from database
$query_organizations = 
    'SELECT *
    FROM organizations
    WHERE org_id = :org_id';
$stmt = $db->prepare($query_organizations);
$stmt->bindValue(':org_id', $org_id);
$stmt->execute();
$organizations = $stmt->fetchAll();
$stmt->closeCursor();

//make sure edited name doesn't already exist
$queryCheck_org_name = 
    'SELECT COUNT(*) 
    FROM organizations 
    WHERE org_name =:org_name
    AND org_id <>:org_id';
$stmt3 = $db->prepare( $queryCheck_org_name);
$stmt3->bindValue(':org_name', $org_name);
$stmt3->bindValue(':org_id', $org_id);
$stmt3->execute();
$organization_count = $stmt3->fetchColumn();

if($organization_count >=1)
{
    $linkMSG = "<b>Edit the Organization by clicking HERE</b>";
    $errorMSG = '<b>ERROR: This organization name already exists. Please check your spelling or choose a different name variation if more than organization with the same name exists.</b>';
    include_once('edit_organization.php');
}
else if ($action == "Submit Form" && $organization_count !== 0)
{
    //update Organization
    $update_organization =
    'UPDATE organizations
    SET
        org_name = :org_name,
        org_desc = :org_desc, 
        org_st_address = :org_st_address, 
        org_city = :org_city, 
        org_state = :org_state, 
        org_zipcode = :org_zipcode, 
        org_phone = :org_phone, 
        org_email = :org_email
    WHERE
        org_id = :org_id';
    $stmt2 = $db->prepare($update_organization);
    $stmt2->bindValue(':org_id', $org_id);
    $stmt2->bindValue(':org_name', $org_name);
    $stmt2->bindValue(':org_desc', $org_desc);
    $stmt2->bindValue(':org_st_address', $org_st_address);
    $stmt2->bindValue(':org_city', $org_city);
    $stmt2->bindValue(':org_state', $org_state);
    $stmt2->bindValue(':org_zipcode', $org_zipcode);
    $stmt2->bindValue(':org_phone', $org_phone);
    $stmt2->bindValue(':org_email', $org_email);
    $stmt2->execute();
    $stmt2->closeCursor();

    $confirmMSG = "<b>UPDATE CONFIRMATION for $org_name</b>";
    $linkMSG2 = "<b>To update another organization click HERE</b>";
    $action = null;

    //refresh list
    $query_organization_list = 
    'SELECT * 
    FROM organizations
    WHERE org_id <>1';
    $stmt1 = $db->prepare($query_organization_list);
    $stmt1->execute();
    $organizationLists = $stmt1->fetchAll();
    $stmt1->closeCursor();
    //include_once('edit_organization.php');
}

include_once('edit_organization.php');
?>
