<?php 
include('../inc/func.php');
$nav_click = filter_input(INPUT_GET,'nav_click');
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../scripts/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <title>SACM</title>
</head>

<body>
    <div class='container-fluid' id='all'>
        <!-- NAV BAR -->
        <?php echo navbar($nav_click); ?>
        <div class='col-12'>
            <h4>Enrollment Form</h4>
            <div class='row'>
                <div>
                    <?php if ($errorMSG !== null && !isset($hidebutton)):?>
                    <a href="#" class="btn btn-danger"><?php echo $errorMSG;?></a>
                    <?php endif;?>
                </div>
                <!-- changes button to confirmation and update new child button -->
                <div>
                    <?php if ($confirmMSG !== null):?>
                    <a href="enroll_entry_index.php" class="btn btn-success"><?php echo $confirmMSG;?></a>
                    <?php endif;?>
                </div>
            </div>
            <!-- shows a message that child doesn't exist and provides link to new child registration page -->
            <div>
                <?php if ($errorMSG2 !== null):?>
                <a href="enroll_entry_index.php" class="btn btn-danger"><?php echo $errorMSG2;?></a>
                <b>OR</b>
                <a href="../entry/child_index.php" class="btn btn-info"><?php echo $linkMSG;?></a>
                <?php endif;?>
            </div>
            <form action="enroll_entry_index.php" class="needs-validation" novalidate method="post">
                <input type="hidden" name="c_fname" value="<?php removeChars ($c_fname);?>">
                <input type="hidden" name="c_lname" value="<?php allowHyphenLastNames ($c_lname);?>">
                <input type="hidden" name="c_dob" value="<?php echo $c_dob;?>">
                <input type="hidden" name="c_id" value="<?php echo $c_id;?>">
                <input type="hidden" name="person_id" value="<?php echo $person_id;?>">
                <div class='row'>
                    <div class='col-sm-3'>
                        <label for="validationCustom01">Child First Name</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="First name"
                            name="c_fname" value="<?php if(isset($c_fname)){ removeChars ($c_fname);} ?>" required>
                    </div>
                    <div class='col-sm-3'>
                        <label for="validationCustom01">Child Last Name</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Last name"
                            name="c_lname" value="<?php if(isset($c_lname)){ allowHyphenLastNames ($c_lname);} ?>"
                            required>
                    </div>
                    <div class="col-sm-3">
                        <label for="validationCustom03">Date of Birth</label>
                        <input type="date" class="form-control" id="validationCustom03" required name='c_dob'
                            value="<?php if(isset($c_dob)){ echo $c_dob;} ?>">
                    </div>
                    <?php if ($child_count >0):?>
                    <div class='col-sm-3'>
                        <label for="validationCustom01">Enrolling Guardian</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="person_id">
                            <option></option>
                            <?php foreach($guardians as $guardian):?>
                            <?php if ($guardian['person_id'] == $person_id){ $selected="selected";}else{$selected="";}?>
                            <option <?php echo $selected;?> value="<?php echo $guardian['person_id'];?>">
                                <?php echo $guardian['p_fname']." ".$guardian['p_lname'];?>
                            </option>
                            <?php endforeach;?>
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
               
                <?php if ($action !==  "Review Form"):?>
                <br>
                <div class='form-row'>
                    <button class="btn btn-success" type="submit" name="action" value="Search"><?php if ($child_count >0){echo "Search Parent";}else{echo "Search";}?></button>
                    <div>
                        <a href="enroll_entry_index.php" class="btn btn-danger">Clear Form</a>
                    </div>
                </div>
                <?php endif;?>
                <!-- <br> -->
            </form>
        </div>
    </div>
    <?php if($showForm ==true &&$action !=="Review Form" && $action !==null):?>
    <div class='row' id='main_form'>
        <div class='col-12'>
            <input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
            <input type="hidden" name="person_id" value="<?php echo $person_id;?>">
            <form action="enroll_entry_index.php" class="needs-validation" novalidate method="post">
                <!-- ROW 1 -->
                <h4>Choose a Program in which to Register Child</h4>
                <div class='form-row'>
                    <div class="col-sm-4">
                        <label for="validationCustom01">Choose a Program</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="prog_sec" required>
                            <option></option>
                            <?php foreach($active_sections as $active_section):?>
                            <option value="<?php echo $active_section['prog_sec'];?>">
                                <?php echo
                                 $active_section['prog_name']." @ ".
                                 $active_section['prog_time']."&emsp;".
                                 $active_section['prog_day']." - ".
                                 $active_section['prog_age_range']."&emsp;".
                                 $active_section['prog_sec_desc'];
                                ?>
                            </option>
                            <?php endforeach;?>
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Transported to Program</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='trans_type_to' required>
                                <option></option>
                                <option value="Drop-off">Drop-off</option>
                                <option value="Bus">Bus</option>
                                <option value="Walk">Walk</option>
                                <option value="Van">Van</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Transported from Program</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='trans_type_from' required>
                                <option></option>
                                <option value="Pick-up">Pick-up</option>
                                <option value="Bus">Bus</option>
                                <option value="Walk">Walk</option>
                                <option value="Van">Van</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                </div>
                <h5>Consent Forms default to<b>"YES"</b>,&emsp; If consent not given indicate below.</h5>
                <div class='form-row'>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">SACM Transport</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='e_consent_sacm_van'
                                required>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Attend Progams</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='e_consent_attend'
                                required>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1"> Publication Consent</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='e_consent_to_publish'
                                required>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Contact Child Directly</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='e_consent_sm_phone'
                                required>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Medical Treatment</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='e_consent_emg_med'
                                required>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <button class="btn btn-success" name="action" value="Review Form"
                        type="submit">Review&nbsp;Form</button>
                    <div>
                        <a href="enroll_entry_index.php" class="btn btn-danger">Clear Form</a>
                    </div>
                </div>
                <div id="dividerLine" class="form-row"></div>
                <?php if ($child_count == 1):?>



                <!-- Child Update -->
                <h4>Child Update Form</h4>
                <?php $school = $child['c_school']; ?>
                <div class="form-row">
                    <div class="col-sm-3">
                        <label for="validationCustom01">First Name</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="First name"
                            value="<?php echo $child['c_fname'] ; ?>" readonly name='c_fname'>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="validationCustom02"> Last Name</label>
                        <input type="text" class="form-control" id="validationCustom02" placeholder="Last name"
                            value="<?php echo $child['c_lname'] ; ?>" readonly name='c_lname'>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label for="validationCustom03">Date of Birth</label>
                        <input type="date" class="form-control" id="validationCustom03" readonly name='c_dob'
                            value="<?php echo $child['c_dob'] ; ?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Gender</label>
                            <select class="form-control" id="exampleFormControlSelect1" required name='c_gender'>
                                <option><?php echo $child['c_gender'] ; ?></option>
                                <option>M</option>
                                <option>F</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Request Van?</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='c_needs_trans'>
                                <option <?php if ($child['c_needs_trans'] ==1){echo 'value=1';}else {echo 'value=0';}?>>
                                    <?php if ($child['c_needs_trans'] ==1){echo "YES";}else{echo "NO";}?>
                                </option>
                                <!-- Reverse logic above to remove duplicate entry -->
                                <option <?php if ($child['c_needs_trans'] ==1){echo 'value=0';}else {echo 'value=1';}?>>
                                    <?php if ($child['c_needs_trans'] ==1){echo "NO";}else{echo "YES";}?>
                                </option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW 2 -->
                <div class="form-row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Grade</label>
                            <select class="form-control" id="exampleFormControlSelect1" required name='c_grade'>
                                <option><?php echo $child['c_grade'];?></option>
                                <option>Nursery</option>
                                <option>Pre K</option>
                                <option>K</option>
                                <option>1st</option>
                                <option>2nd</option>
                                <option>3rd</option>
                                <option>4th</option>
                                <option>5th</option>
                                <option>6th</option>
                                <option>7th</option>
                                <option>8th</option>
                                <option>9th</option>
                                <option>10th</option>
                                <option>11th</option>
                                <option>12th</option>
                                <option>Youth</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">School</label>
                            <input type="text" class="form-control datalistfix" id="validationCustom01" list="school"
                                name='c_school' value="<?php echo $child['c_school'];?>" required
                                placeholder="<?php echo $child['c_school']; ?>" />
                            <datalist id="school">
                                <?php foreach ($schools as $school):?>
                                <option><?php echo $school["c_school"];?></option>
                                <?php endforeach;?>
                            </datalist>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label for="validationCustom01">Child's Cell</label>
                        <input type="tel" id="phone" name="c_cell_phone" class="form-control" id="validationCustom01"
                            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="<?php echo $child['c_cell_phone'];?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="validationCustom01">Child's Email</label>
                        <input type="email" class="form-control" id="validationCustom01" placeholder="Email Address"
                            value="<?php echo $child['c_email'];?>" name="c_email">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                </div>
                <!-- ROW 3 -->
                <div class="form-row">
                    <div class="col-sm-6">
                        <label for="validationCustom01">Street Address</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Address"
                            value="<?php echo $child['c_st_address'];?>" required name="c_st_address">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="validationCustom01">City</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="City"
                            value="<?php echo $child['c_city'];?>" required name="c_city">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">State</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="c_state" required>
                                <option><?php echo $child['c_state'];?></option>
                                <option>AL</option>
                                <option>AK</option>
                                <option>AZ</option>
                                <option>AR</option>
                                <option>CA</option>
                                <option>CO</option>
                                <option>CT</option>
                                <option>DE</option>
                                <option>FL</option>
                                <option>GA</option>
                                <option>HI</option>
                                <option>ID</option>
                                <option>IL</option>
                                <option>IN</option>
                                <option>IA</option>
                                <option>KS</option>
                                <option>KY</option>
                                <option>LA</option>
                                <option>ME</option>
                                <option>MD</option>
                                <option>MA</option>
                                <option>MI</option>
                                <option>MN</option>
                                <option>MS</option>
                                <option>MO</option>
                                <option>MT</option>
                                <option>NE</option>
                                <option>NV</option>
                                <option>NH</option>
                                <option>NJ</option>
                                <option>NM</option>
                                <option>NY</option>
                                <option>NC</option>
                                <option>ND</option>
                                <option>OH</option>
                                <option>OK</option>
                                <option>OR</option>
                                <option>PA</option>
                                <option>RI</option>
                                <option>SC</option>
                                <option>SD</option>
                                <option>TN</option>
                                <option>TX</option>
                                <option>UT</option>
                                <option>VT</option>
                                <option>VA</option>
                                <option>WA</option>
                                <option>WV</option>
                                <option>WI</option>
                                <option>WY</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label for="validationCustom01">Zip</label>
                        <input type="text" name="c_zipcode" pattern="[0-9]{5}" class="form-control"
                            id="validationCustom01" placeholder="Zip" value="<?php echo $child['c_zipcode'];?>"
                            required />
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                </div>
                <!-- ROW 4 -->
                <div class="form-row">
                    <div class="col-sm-12">
                        <div class="form-row">
                            <label for="exampleFormControlTextarea1">Allergies - Reaction - Treatment (Separate multiple
                                allergies with semicolons ";")</label>
                            <input type="text" class="form-control" id="validationCustom01" name='c_allergies'
                                value="<?php echo $child['c_allergies']; ?>" placeholder="update as needed" />
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW 5 -->
                <div id="dividerLine" class="form-row"></div>
                <div class="form-row">
                    <div class="col-sm-6">
                        <label for="validationCustom01"><b>Emergency Contact Full Name</b></label>
                        <input type="text" class="form-control" id="validationCustom01"
                            placeholder="First and Last Name" value="<?php echo $child['c_emg_contact_name']; ?>"
                            required name="c_emg_contact_name">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="validationCustom01"><b>Emergency Contact Phone Number</b></label>
                        <input type="tel" name="c_emg_contact_num" placeholder="ex. 123-456-7890" class="form-control"
                            id="validationCustom01" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                            value="<?php echo $child['c_emg_contact_num']; ?>" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                </div>
                <div id="dividerLine" class="form-row"></div>
                <?php endif; ?>
                <h4>Update Guardian Information Form</h4>
                <!-- ROW 7 -->
                <!-- Fix logic of else --><?php if(isset($person)&& $c_id !== false):
                    foreach($persons as $person):?>
                <input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
                <input type="hidden" name="person_id" value="<?php echo $person_id;?>">
                <input type="hidden" name="p_is_a_guardian" value="<?php echo "1";?>">
                <div class="form-row">
                    <div class="col-sm-3">
                        <label for="validationCustom01">First Name</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="First name"
                            name="p_fname" value="<?php echo $person['p_fname'];?>" readonly>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="validationCustom02">Last Name</label>
                        <input type="text" class="form-control" id="validationCustom02" placeholder="Last name"
                            name="p_lname" value="<?php echo $person['p_lname'];?>" readonly>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="validationCustom03">Email</label>
                        <input type="email" class="form-control" id="validationCustom03" placeholder="Email Address"
                            name="p_email" value="<?php echo $person['p_email'];?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Organization</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="org_id">
                                <?php foreach($organizations as $organization):if($person['org_id'] == $organization['org_id']){$selected = "selected";}else{$selected = "";}?>
                                <option <?php echo $selected; ?> value="<?php echo $organization['org_id']; ?>">
                                    <?php echo $org_name = $organization['org_name']; ?></option>
                                <?php  endforeach; ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 8 -->
                <div class="form-row">
                    <div class="col-sm-4">
                        <label for="validationCustom01">Cell Phone</label>
                        <input type="tel" class="form-control" id="validationCustom01" placeholder="ex. 123-456-7890"
                            name="p_cell_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                            value="<?php echo $person['p_cell_phone'];?>" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="validationCustom02">Home Phone</label>
                        <input type="tel" class="form-control" id="validationCustom02" placeholder="ex. 123-456-7890"
                            name="p_home_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                            value="<?php echo $person['p_home_phone'];?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="validationCustom03">Work Phone</label>
                        <input type="tel" class="form-control" id="validationCustom03" placeholder="ex. 123-456-7890"
                            name="p_work_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                            value="<?php echo $person['p_work_phone'];?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                </div>
                <!-- ROW 9 -->
                <div class="form-row">
                    <div class="col-sm-4">
                        <label for="validationCustom01">Street Address</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Street Address"
                            name="p_st_address" value="<?php echo $person['p_st_address'];?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="validationCustom01">City</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="City" name="p_city"
                            value="<?php echo $person['p_city'];?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">State</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="p_state">
                                <option><?php echo $person['p_state'];?></option>
                                <option>AL</option>
                                <option>AK</option>
                                <option>AZ</option>
                                <option>AR</option>
                                <option>CA</option>
                                <option>CO</option>
                                <option>CT</option>
                                <option>DE</option>
                                <option>FL</option>
                                <option>GA</option>
                                <option>HI</option>
                                <option>ID</option>
                                <option>IL</option>
                                <option>IN</option>
                                <option>IA</option>
                                <option>KS</option>
                                <option>KY</option>
                                <option>LA</option>
                                <option>ME</option>
                                <option>MD</option>
                                <option>MA</option>
                                <option>MI</option>
                                <option>MN</option>
                                <option>MS</option>
                                <option>MO</option>
                                <option>MT</option>
                                <option>NE</option>
                                <option>NV</option>
                                <option>NH</option>
                                <option>NJ</option>
                                <option>NM</option>
                                <option>NY</option>
                                <option>NC</option>
                                <option>ND</option>
                                <option>OH</option>
                                <option>OK</option>
                                <option>OR</option>
                                <option>PA</option>
                                <option>RI</option>
                                <option>SC</option>
                                <option>SD</option>
                                <option>TN</option>
                                <option>TX</option>
                                <option>UT</option>
                                <option>VT</option>
                                <option>VA</option>
                                <option>WA</option>
                                <option>WV</option>
                                <option>WI</option>
                                <option>WY</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label for="validationCustom01">Zip</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Zip"
                            name="p_zipcode" pattern="[0-9]{5}" value="<?php echo $person['p_zipcode'];?>">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label for="validationCustom01">Have Vehicle?</label>
                        <select class="form-control" id="exampleFormControlSelect1" required name='has_vehicle'>
                            <option value="<?php if ($person['has_vehicle'] == 1){echo "1";}else{echo "0";} ?>">
                                <?php if ($person['has_vehicle'] == 1){echo "YES";}else{echo "NO";} ?>
                            </option>
                            <!-- logic to remove duplicate entry -->
                            <option value="<?php if ($person['has_vehicle'] == 1){echo "0";}else{echo "1";} ?>">
                                <?php if ($person['has_vehicle'] == 1){echo "NO";}else{echo "YES";} ?>
                            </option>
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
                <div class="form-row">
                    <button class="btn btn-success" name="action" value="Review Form"
                        type="submit">Review&nbsp;Form</button>
                    <div>
                        <a href="enroll_entry_index.php" class="btn btn-danger">Clear Form</a>
                    </div>
                </div>
                <?php else:?>
                <code><h2>Select a Guardian above to complete registration process</h2></code>
                <?php endif;?>
            </form>
            <br>
        </div>
    </div><!-- class='row' id='main_form'> -->
    <?php endif;?>
    <?php if (isset($action) && $action == "Review Form" ) :?>
    <div class='row' id='main_form'>
        <div class='col-md-12' id='table_data'>
            <br>
            <form action="enroll_entry_index.php" class="needs-validation" novalidate method="post">
                <div class='table-responsive'>
                    <table class='table table-striped table-sm'>
                        <thread>
                            <thead>
                                <tr>
                                    <th colspan="6">
                                        <h4><b>Child Enrollment Review Form</b></h4>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="2">Enrolling into Program Section:</th>
                                    <th colspan="2">Transport to Army</th>
                                    <th colspan="2">Transport from Army</th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <?php echo $progName." &emsp; ".$progRange." &emsp; ".$progDay." &emsp; ".$progDesc;?>
                                        <input type="hidden" name="prog_sec" value="<?php echo $prog_sec; ?>">
                                    </td>
                                    <td colspan="2"><?php echo $trans_type_to; ?>
                                        <input type="hidden" name="trans_type_to" value="<?php echo $trans_type_to; ?>">
                                    </td>
                                    <td colspan="2"><?php echo $trans_type_from; ?>
                                        <input type="hidden" name="trans_type_from"
                                            value="<?php echo $trans_type_from; ?>"></td>
                                </tr>
                                <tr>
                                    <th>SACM Transport</th>
                                    <th>Attend Programs</th>
                                    <th>Publication Consent</th>
                                    <th>Contact Child Directly</th>
                                    <th>Medical Treatment</th>
                                    <th>Request Van?</th>
                                </tr>
                                <tr>
                                    <td><?php if ($e_consent_sacm_van ==1){echo "YES";}else{echo "NO";} ?>
                                        <input type="hidden" name="e_consent_sacm_van"
                                            value="<?php echo $e_consent_sacm_van; ?>">
                                    </td>
                                    <td><?php if ($e_consent_attend ==1){echo "YES";}else{echo "NO";} ?>
                                        <input type="hidden" name="e_consent_attend"
                                            value="<?php echo $e_consent_attend; ?>">
                                    </td>
                                    <td><?php if ($e_consent_to_publish ==1){echo "YES";}else{echo "NO";} ?>
                                        <input type="hidden" name="e_consent_to_publish"
                                            value="<?php echo $e_consent_to_publish; ?>">
                                    </td>
                                    <td><?php if ($e_consent_sm_phone ==1){echo "YES";}else{echo "NO";} ?>
                                        <input type="hidden" name="e_consent_sm_phone"
                                            value="<?php echo $e_consent_sm_phone; ?>">
                                    </td>
                                    <td><?php if ($e_consent_emg_med ==1){echo "YES";}else{echo "NO";} ?>
                                        <input type="hidden" name="e_consent_emg_med"
                                            value="<?php echo $e_consent_emg_med; ?>">
                                    </td>
                                    <td><?php if ($c_needs_trans ==1){echo "YES";}else{echo "NO";} ?>
                                        <input type="hidden" name="c_needs_trans" value="<?php echo $c_needs_trans; ?>">
                                    </td>
                                </tr>
                            </tbody>
                        </thread>
                        <thead>
                            <tr>
                                <th colspan="6">
                                    <h4><b>Child's Information</b></h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Full Name</th>
                                <th>Date of Birth</th>
                                <th>Gender</th>
                                <th>Request Transport</th>
                                <th>Grade</th>
                                <th>School</th>
                            </tr>
                            <tr>
                                <td><?php removeChars($c_fname); echo " "; allowHyphenLastNames($c_lname); ?>
                                    <input type="hidden" name="c_fname" value="<?php removeChars($c_fname); ?>">
                                    <input type="hidden" name="c_lname"
                                        value="<?php allowHyphenLastNames($c_lname); ?>">
                                    <input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
                                </td>
                                <td><?php echo $c_dob; ?>
                                    <input type="hidden" name="c_dob" value="<?php echo $c_dob; ?>">
                                </td>
                                <td><?php echo $c_gender; ?>
                                    <input type="hidden" name="c_gender" value="<?php echo $c_gender; ?>">
                                </td>
                                <td><?php if ($c_needs_trans ==1){echo "YES";}else {echo "NO";} ?>
                                    <input type="hidden" name="c_needs_trans" value="<?php echo $c_needs_trans; ?>">
                                </td>
                                <td><?php echo $c_grade ; ?>
                                    <input type="hidden" name="c_grade" value="<?php echo $c_grade ; ?>">
                                </td>
                                <td><?php removeChars($c_school); ?>
                                    <input type="hidden" name="c_school" value="<?php removeChars($c_school); ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>Street Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Zip Code</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                            </tr>
                            <tr>
                                <td><?php formatAddress( $c_st_address) ?>
                                    <input type="hidden" name="c_st_address"
                                        value="<?php formatAddress($c_st_address); ?>">
                                </td>
                                <td><?php removeChars($c_city); ?>
                                    <input type="hidden" name="c_city" value="<?php removeChars($c_city); ?>">
                                </td>
                                <td><?php echo $c_state; ?>
                                    <input type="hidden" name="c_state" value="<?php echo $c_state; ?>">
                                </td>
                                <td><?php echo $c_zipcode; ?>
                                    <input type="hidden" name="c_zipcode" value="<?php echo $c_zipcode; ?>">
                                </td>
                                <td><?php echo $c_cell_phone; ?>
                                    <input type="hidden" name="c_cell_phone" value="<?php echo $c_cell_phone; ?>">
                                </td>
                                <td><?php echo $c_email; ?>
                                    <input type="hidden" name="c_email" value="<?php echo $c_email; ?>">
                                </td>
                            </tr>
                            <tr>
                                <th colspan="6">Child's Allergies</th>
                            </tr>
                            <tr>
                                <td colspan="6"><?php formatAllergies($c_allergies);?>
                                    <input type="hidden" name="c_allergies"
                                        value="<?php formatAllergies($c_allergies); ?>">
                                </td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <th colspan="5">
                                    <h4><b>Guardian's Information</b></h4>
                                </th>
                                <th colspan="1">
                                    <h4><b>Emergency Contact</b></h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Full Name</th>
                                <th>Guardian Has Vehicle?</th>
                                <th>Cell Phone Number</th>
                                <th>Home Phone Number</th>
                                <th>Work Phone Number</th>
                                <th>Full Name</th>
                            </tr>
                            <tr>
                                <td><?php removeChars($p_fname); echo " "; allowHyphenLastNames($p_lname); ?>
                                    <input type="hidden" name="p_fname" value="<?php removeChars($p_fname); ?>">
                                    <input type="hidden" name="p_lname"
                                        value="<?php allowHyphenLastNames($p_lname); ?>">
                                    <input type="hidden" name="person_id" value="<?php echo $person_id;?>">
                                    <input type="hidden" name="p_is_guardian" value="<?php echo "1"; ?>">
                                </td>
                                <td><?php if ($has_vehicle == 1){echo "YES";}else{echo "NO";} ?>
                                    <input type="hidden" name="has_vehicle" value="<?php echo $has_vehicle; ?>">
                                </td>
                                <td><?php echo $p_cell_phone; ?>
                                    <input type="hidden" name="p_cell_phone" value="<?php echo $p_cell_phone; ?>">
                                </td>
                                <td><?php echo $p_home_phone; ?>
                                    <input type="hidden" name="p_home_phone" value="<?php echo $p_home_phone; ?>">
                                </td>
                                <td><?php echo $p_work_phone; ?>
                                    <input type="hidden" name="p_work_phone" value="<?php echo $p_work_phone; ?>">
                                </td>
                                <td><?php removeChars($c_emg_contact_name); ?>
                                    <input type="hidden" name="c_emg_contact_name"
                                        value="<?php removeChars($c_emg_contact_name); ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>Street Address</th>
                                <th>City, State&emsp; Zip Code</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Organization</th>
                                <th>Emergency Contact number</th>
                            </tr>
                            <tr>
                                <td><?php formatAddress($p_st_address); ?>
                                    <input type="hidden" name="p_st_address"
                                        value="<?php formatAddress($p_st_address); ?>">
                                </td>
                                <td><?php removeChars($p_city); echo ", ".$p_state." ".$p_zipcode; ?>
                                    <input type="hidden" name="p_city" value="<?php removeChars($p_city); ?>">
                                    <input type="hidden" name="p_state" value="<?php echo $p_state; ?>">
                                    <input type="hidden" name="p_zipcode" value="<?php echo $p_zipcode; ?>">
                                </td>
                                <td><?php echo $p_email; ?>
                                    <input type="hidden" name="p_email" value="<?php echo $p_email; ?>">
                                </td>
                                <td><?php echo $c_emg_contact_num; ?>
                                    <input type="hidden" name="c_emg_contact_num"
                                        value="<?php echo $c_emg_contact_num; ?>">
                                </td>
                                <td><?php foreach($organizations as $organization):if($org_id == $organization['org_id']):echo $organization['org_name'];?>
                                    <input type="hidden" name="org_id"
                                        value="<?php echo $organization['org_id'];  endif;endforeach;?>">
                                </td>
                                <td><?php echo $c_emg_contact_num; ?>
                                    <input type="hidden" name="c_emg_contact_num"
                                        value="<?php echo $c_emg_contact_num;?>">
                                </td>
                            </tr>
                        </tbody>
                        </thread>
                    </table>
                </div>
                <div class='form-row'>
                    <button class="btn btn-success" name="action" type="submit"
                        value="Submit Form">Submit&nbsp;Form</button>
                    <div>
                        <a href="enroll_entry_index.php" class="btn btn-danger">Clear Form</a>
                    </div>
                </div>

            </form>
            <br>
        </div>
    </div>
    <?php endif;?>
    </div><!-- class='row' id='main_form'> -->
    </div> <!-- class='container-fluid' id='all' -->
    <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    </script>
    <script src="../scripts/jquery-3.4.1.js"></script>
    <script src="../scripts/js/bootstrap.bundle.min.js"></script>

    <script>
    $('.datalistfix').on('click', function() {
        $(this).val('');
    });
    $('.datalistfix').on('mouseleave', function() {
        if ($(this).val() == '') {
            $(this).val($(this).attr('placeholder'));
        }
    });
    </script>
</body>

</html>