<!-- variables -->
<?php
/* posssible variables if needed */
$errorMSG = null;
$confirmMSG = null;
$linkMSG = null;

//inline
$errorMSG = "ERROR: ...";
$confirmMSG = 'CONFIRMATION: ...';
$linkMSG = "<b>HERE</b>";
?>


<!-- Clear FORM BUTTON THAT WORKS!!! -->
<div>
    <a href="#" class="btn btn-danger">Clear Form</a>
</div>

<!----------------------------- error msg ----------------------------->
<div><?php if ($errorMSG !== null):?>
    <a href="#" class="btn btn-danger"><?php echo $errorMSG;?></a><?php endif;?>
</div>
<!-- ----------------------------------------------------------------- -->

<!----------------------------- confirm message ----------------------------->
<div><?php if ($confirmMSG !== null):?>
    <a href="#" class="btn btn-success"><?php echo $confirmMSG;?></a><?php endif;?>
</div>
<!-- ----------------------------------------------------------------- -->

<!----------------------------- refferal link ONLY----------------------------->
<div><?php if ($linkMSG !== null):?>
    <a href="<?php echo $linkMSG;?>" class="btn btn-link"><?php echo "HERE";?></a><?php endif;?>
</div>
<!-- ----------------------------------------------------------------- -->

<!---------------------- error msg with link referral ---------------------->
<?php
//declarations
$errorMSG = null;
$linkMSG = null;
//inline
$errorMSG = "ERROR: ...";
$linkMSG = "<b>HERE</b>";
?>

<div><?php if ($errorMSG !== null):?>
    <a href="#" class="btn btn-danger"><?php echo $errorMSG;?></a>
    <a href="#" class="btn btn-info"><?php echo $linkMSG;?></a><?php endif;?>
</div>
<!-- ----------------------------------------------------------------- -->

<!-------- confirm msg with link referral and requireed variables-------->
<?php
//declarations
$confirmMSG = null;
$linkMSG = null;
//inline
$confirmMSG = 'CONFIRMATION: ...';
$linkMSG = "<b>HERE</b>";
?>

<div><?php if ($confirmMSG !== null):?>
    <a href="#" class="btn btn-success"><?php echo $confirmMSG;?></a>
    <a href="#" class="btn btn-info"><?php echo $linkMSG;?></a><?php endif;?>
</div>
<!-- ------------------------------------------------------------------- -->

<!-- just confirmation text ---if it doesn't need to be loud -->
<p class="text-success"><?php echo $confirmMSG;?> </p>
<!-- ------------------------------------------------------- -->

<div><?php if ($errorMSG !== null): echo $errorMSG;?>
    <?php endif;?>
</div>

<?php
/* use for checking variables

echo '<br>action = '.$action;
echo '<br>search = '.$search;
echo '<br>c_id = '.$c_id;
echo '<br>c_fname = '.$c_fname;
echo '<br>c_lname = '.$c_lname;
echo '<br>c_dob = '.$c_dob;
echo '<br>c_gender = '.$c_gender;
echo '<br>c_grade = '.$c_grade;
echo '<br>c_school = '.$c_school;
echo '<br>c_cell_phone = '.$c_cell_phone;
echo '<br>c_email = '.$c_email;
echo '<br>c_st_address = '.$c_st_address;
echo '<br>c_city = '.$c_city;
echo '<br>c_state = '.$c_state;
echo '<br>c_zipcode = '.$c_zipcode;
echo '<br>c_needs_trans = '.$c_needs_trans;
echo '<br>c_emg_contact_name = '.$c_emg_contact_name;
echo '<br>c_emg_contact_num = '.$c_emg_contact_num;
echo '<br>c_allergies = '.$c_allergies;
echo '<br>person_id = '.$person_id; 
echo '<br>p_fname = '.$p_fname;
echo '<br>p_lname = '.$p_lname;
echo '<br>p_email = '.$p_email;
echo '<br>p_cell_phone = '.$p_cell_phone;
echo '<br>p_work_phone = '.$p_work_phone;
echo '<br>p_home_phone = '.$p_home_phone;
echo '<br>p_city = '.$p_city;
echo '<br>p_zipcode = '.$p_zipcode;
echo '<br>p_state = '.$p_state;
echo '<br>p_st_address = '.$p_st_address;
echo '<br>has_vehicle = '.$has_vehicle;
echo '<br>p_is_guardian = '.$p_is_guardian;
echo '<br>org_id = '.$org_id;
echo '<br>org_name = '.$org_name;
echo '<br>prog_sec = '.$prog_sec;
echo '<br>prog_name = '.$prog_name;
echo '<br>prog_time = '.$prog_time;
echo '<br>prog_day = '.$prog_day;
echo '<br>prog_age_range = '.$prog_age_range;
echo '<br>prog_sec_desc = '.$prog_sec_desc; 
echo '<br>trans_type_to = '.$trans_type_to;
echo '<br>trans_type_from = '.$trans_type_from;
echo '<br>e_consent_sacm_van = '.$e_consent_sacm_van;
echo '<br>e_consent_attend = '.$e_consent_attend;
echo '<br>e_consent_sm_phone = '.$e_consent_sm_phone;
echo '<br>e_consent_emg_med = '.$e_consent_emg_med;
echo '<br>e_consent_to_publish = '.$e_consent_to_publish;
echo'<br/>prog_sec = '. $prog_sec;
echo'<br/>prog_id = '. $prog_id;
echo'<br/>prog_sec_desc = '. $prog_sec_desc;    
echo'<br/>prog_sec_active = '. $prog_sec_active;
echo'<br/>prog_day = '. $prog_day;
echo'<br/>prog_van_trans_avail = '. $prog_van_trans_avail;
echo'<br/>prog_seat_cap = '. $prog_seat_cap;
echo'<br/>prog_room = '. $prog_room;
echo'<br/>prog_age_range = '. $prog_age_range;
echo'<br/>prog_time = '. $prog_time;

echo '<br/>org_id = '.$org_id;
echo '<br/>org_name = '.$org_name;
echo '<br/>org_attn_contact_person = '.$org_attn_contact_person ;
echo '<br/>org_desc = '.$org_desc;
echo '<br/>org_st_address = '.$org_st_address;
echo '<br/>org_city = '.$org_city;
echo '<br/>org_state = '.$org_state;
echo '<br/>org_zipcode = '.$org_zipcode;
echo '<br/>org_phone = '.$org_phone;
echo '<br/>org_email = '.$org_email;
echo "<br>organization_count = ".$organization_count;

echo '<br/>action = '.$action;
//echo '<br/>select = '.$select;
echo '<br/>p_fname = '.$p_fname;
echo '<br/>p_lname = '.$p_fname;
echo '<br/>don_desc = '.$don_desc;
echo '<br/>don_type = '.$don_type;
echo '<br/>don_date = '.$don_date;
echo '<br/>org_id = '.$org_id;
echo '<br/>org_name = '.$org_name;

?>

