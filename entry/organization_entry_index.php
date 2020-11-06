<?php 
include('../inc/db_connect.php');

$action = filter_input(INPUT_POST, 'action');
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

//select to see if org is already in database
$query_organization_already_exists = 
    'SELECT COUNT(*)
    FROM organizations
    WHERE org_name = :org_name';
$stmt = $db->prepare($query_organization_already_exists);
$stmt->bindValue(':org_name', $org_name);
$stmt->execute();
$organization_count = $stmt->fetchColumn();
$stmt->closeCursor();


if($organization_count>0)
{
    $errorMSG = "<b>ERROR: This organization already exists.</b>";
    $linkMSG = "<b>You can update the Organization's information by clicking HERE</b>";
}
else if ($organization_count == 0 && $action == "Submit Form")
{
    //insert
    $insert_organization =
    'INSERT INTO organizations
        (org_name, org_desc, org_st_address, org_city, org_state, org_zipcode, org_phone, org_email)
    VALUES
        (:org_name, :org_desc, :org_st_address, :org_city, :org_state, :org_zipcode, :org_phone, :org_email)';
    $stmt2 = $db->prepare($insert_organization);
    $stmt2->bindValue(':org_name', $org_name);
    $stmt2->bindValue(':org_desc', $org_desc);
    $stmt2->bindValue(':org_st_address', $org_st_address);
    $stmt2->bindValue(':org_city', $org_city);
    $stmt2->bindValue(':org_state', $org_state);
    $stmt2->bindValue(':org_zipcode', $org_zipcode);
    $stmt2->bindValue(':org_phone', $org_phone);
    $stmt2->bindValue(':org_email', $org_email);
    $stmt2->execute();
    $organization_id = $db->lastInsertId(); 
    $stmt2->closeCursor();
   

    $confirmMSG = "<b>CONFIRMATION # $organization_id:</b> $org_name";
    $linkMSG2 = "<b>To enter another organization click HERE</b>";





/* 
    //insert
    $insert_organization =
    'INSERT INTO organizations
        (org_name, org_attn_contact_person, org_desc, org_st_address, org_city, org_state, org_zipcode, org_phone, org_email)
    VALUES
        (:org_name, :org_attn_contact_person, :org_desc, :org_st_address, :org_city, :org_state, :org_zipcode, :org_phone, :org_email)';
    $stmt2 = $db->prepare($insert_organization);
    $stmt2->bindValue(':org_name', $org_name);
    $stmt2->bindValue(':org_attn_contact_person', $org_attn_contact_person);
    $stmt2->bindValue(':org_desc', $org_desc);
    $stmt2->bindValue(':org_st_address', $org_st_address);
    $stmt2->bindValue(':org_city', $org_city);
    $stmt2->bindValue(':org_state', $org_state);
    $stmt2->bindValue(':org_zipcode', $org_zipcode);
    $stmt2->bindValue(':org_phone', $org_phone);
    $stmt2->bindValue(':org_email', $org_email);
    $stmt2->execute();
    $organization_id = $db->lastInsertId(); 
    $stmt2->closeCursor();
   

    $confirmMSG = "<b>CONFIRMATION # $organization_id:</b> $org_name";
    $linkMSG2 = "<b>To enter another organization click HERE</b>";
 */
}


include_once('organization_entry.php');
?>
