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
        <div class='row' id='main_form'>
            <div class='col-12'>
                <?php if ($action !== "Review Form") :?>

                <h4>Child Entry Form</h4>
                <div><?php if ($errorMSG !== null):?>
                    <a href="#" class="btn btn-danger"><?php echo $errorMSG;?></a></a><?php endif;?>
                </div>
                <?php if ($confirmMSG !== null):?>
                <div>
                    <a href="#" class="btn btn-success"><?php echo $confirmMSG;?></a>
                    <a href="enroll_entry_index.php" class="btn btn-info"><?php echo $linkMSG;?></a>
                </div><?php endif;?>
                <form action="child_index.php" class="needs-validation" novalidate method="post">
                    <!-- ROW 1 -->
                    <div class="form-row">
                        <div class="col-sm-3">
                            <label for="validationCustom01">First Name</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="First name"
                                value="" required name='c_fname'>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom02"> Last name</label>
                            <input type="text" class="form-control" id="validationCustom02" placeholder="Last name"
                                value="" required name='c_lname'>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom03">Date of Birth</label>
                            <input type="date" class="form-control" id="validationCustom03" required name='c_dob'>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Gender</label>
                                <select class="form-control" id="exampleFormControlSelect1" required name='c_gender'>
                                    <option></option>
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
                                    <option></option>
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
                        <div class="col-sm-6">
                            <label for="validationCustom01">Street Address</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="Address"
                                value="" required name="c_st_address">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom01">City</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="City" value=""
                                required name="c_city">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">State</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="c_state" required>
                                    <option></option>
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
                                id="validationCustom01" placeholder="Zip" required />
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <!-- ROW 2 -->
                    <div class="form-row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Grade</label>
                                <select class="form-control" id="exampleFormControlSelect1" required name='c_grade'>
                                    <option></option>
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
                                <input type="text" class="form-control" id="validationCustom01" list="school"
                                    name='c_school' required />
                                <datalist id="school">
                                    <option></option>
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
                            <input type="tel" id="phone" name="c_cell_phone" class="form-control"
                                placeholder="ex. 123-456-7890" id="validationCustom01"
                                pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="validationCustom01">Child's Email</label>
                            <input type="email" class="form-control" id="validationCustom01" placeholder="Email Address"
                                value="" name="c_email">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <!-- ROW 3 -->
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="exampleFormControlTextarea1">Allergies - Reaction - Treatment (Separate multiple
                                allergies with semicolons ";")</label>
                            <input type="text" class="form-control" id="validationCustom01" name='c_allergies'
                                placeholder="ex. peanuts - anaphylaxis - immediate epiPen injection and call 911" />
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <br />
                    <div id="dividerLine" class="form-row"></div>
                    <b>Guardian Information</b>
                    <!-- ROW 4 -->
                    <div class="form-row">
                        <div class="col-sm-3">
                            <label for="validationCustom01">First Name</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="First name"
                                value="" required name='p_fname'>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom01">Last Name</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="Last Name"
                                value="" required name='p_lname'>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <input type="hidden" name='p_is_guardian' value='TRUE'>
                        <div class="col-sm-2">
                            <label for="validationCustom01">Email</label>
                            <input type="email" class="form-control" id="validationCustom01" placeholder="Email Address"
                                name="p_email">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Organization</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="org_id" required>
                                    <option></option>
                                    <?php foreach ($organizations as $organization): ?>
                                    <option value="<?php echo $organization['org_id']; ?>">
                                        <?php echo $organization['org_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label for="validationCustom01">Have Vehicle?</label>
                            <select class="form-control" id="exampleFormControlSelect1" required name='has_vehicle'>
                                <option></option>
                                <option value=1>YES</option>
                                <option value=0>NO</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <label for="validationCustom01"> Street Address</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="Street Address"
                                value="" required name='p_st_address'>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom01">City</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="City" value=""
                                required name='p_city'>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">State</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="p_state" required>
                                    <option></option>
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
                            <label for="validationCustom01">Zip Code</label>
                            <input type="text" name="p_zipcode" pattern="[0-9]{5}" class="form-control"
                                id="validationCustom01" placeholder="Zip" required />
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-4">
                            <label for="validationCustom01">Primary or Cell Phone</label>
                            <input type="tel" id="phone" name="p_cell_phone" placeholder="ex. 123-456-7890"
                                class="form-control" id="validationCustom01" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="validationCustom02">Home Phone</label>
                            <input type="tel" id="phone" name="p_home_phone" placeholder="ex. 123-456-7890"
                                class="form-control" id="validationCustom01" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="validationCustom03">Work Phone</label>
                            <input type="tel" id="phone" name="p_work_phone" placeholder="ex. 123-456-7890"
                                class="form-control" id="validationCustom01" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <br>
                    <div id="dividerLine" class="form-row"></div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <label for="validationCustom01"><b>Emergency Contact Name</b></label>
                            <input type="text" class="form-control" id="validationCustom01"
                                placeholder="First and Last Name" value="" required name="c_emg_contact_name">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="validationCustom01"><b>Emergency Contact Phone Number</b></label>
                            <input type="tel" id="phone" name="c_emg_contact_num" placeholder="ex. 123-456-7890"
                                class="form-control" id="validationCustom01" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class='form-row'>
                        <button class="btn btn-success" name="action" value="Review Form" type="submit">Review
                            Form</button>
                        <div>
                            <a href="child_index.php" class="btn btn-danger">Clear Form</a>
                        </div>
                    </div>
                    <br>
                </form>
            </div>
            <br>
            <br>
            <!-- End of first Child entry form -->
            <?php endif;?>
            <?php if ($action == "Review Form") :?>
            <h4><b>Enroll Child into Program Section</b></h4>
            <p><b>Consent Forms default to "YES" if consent not given indicate below</b></p>
            <form action="child_index.php" class="needs-validation" novalidate method="post">
                <div class='form-row'>
                    <!-- consent -->
                    <div class='form-row'>
                        <div class="col-md-1">
                            <label for="validationCustom01">SACM<br>Transport</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='e_consent_sacm_van'
                                required>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="validationCustom01">Attend<br>Programs</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='e_consent_attend'
                                required>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="validationCustom01">Publication<br>Consent</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='e_consent_to_publish'
                                required>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="validationCustom01">Contact<br>Child</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='e_consent_sm_phone'
                                required>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="validationCustom01">Medical<br>Treatment</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='e_consent_emg_med'
                                required>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <!-- Program -->
                        <div class="col-md-2" id='child_enroll_dropdown'>
                            <label for="validationCustom01">Choose a Program</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="prog_sec" required>
                                <option></option>
                                <?php foreach($active_sections as $active_section):?>
                                <option value="<?php echo $active_section['prog_sec'];?>">
                                    <?php echo
                                     $active_section['prog_name']." @ ".
                                     $active_section['prog_time']." &emsp; ".
                                     $active_section['prog_day']." &emsp; ".
                                     $active_section['prog_age_range']." &emsp; ".
                                     $active_section['prog_sec_desc'];
                                    ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <br>
                        <div id="error"><?php if(isset($errorMSG)){echo $errorMSG;}?></div>
                        <br>
                        <div class="col-md-2" id='child_enroll_dropdown'>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Transport to Program</label>
                                <select class="form-control" id="exampleFormControlSelect1" name='trans_type_to'
                                    required>
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
                        <div class="col-md-2" id='child_enroll_dropdown'>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Transport from Program</label>
                                <select class="form-control" id="exampleFormControlSelect1" name='trans_type_from'
                                    required>
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
                    <!-- <br> -->
                    <div class='col-md-12' id='table_data'>
                        <!-- <br> -->
                        <div class='table-responsive'>
                            <table class='table table-striped table-sm'>
                                <thread>
                                    <thead>
                                        <tr>
                                            <th colspan="4">
                                                <h4><b>Child's Information</b></h4>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>First Last Name</th>
                                            <th>Date of Birth</th>
                                            <th>Gender</th>
                                            <th>Request Transport</th>
                                        </tr>
                                        <tr>
                                            <td><?php removeChars( $c_fname);echo" "; allowHyphenLastNames($c_lname); ?>
                                                <input type="hidden" name="c_fname"
                                                    value="<?php removeChars( $c_fname); ?>">
                                                <input type="hidden" name="c_lname"
                                                    value="<?php allowHyphenLastNames( $c_lname); ?>">
                                            </td>
                                            <td><?php echo $c_dob; ?>
                                                <input type="hidden" name="c_dob" value="<?php echo $c_dob; ?>">
                                            </td>
                                            <td><?php echo $c_gender; ?>
                                                <input type="hidden" name="c_gender" value="<?php echo $c_gender; ?>">
                                            </td>
                                            <td><?php if ($c_needs_trans ==1){echo "YES";}else {echo "NO";} ?>
                                                <input type="hidden" name="c_needs_trans"
                                                    value="<?php echo $c_needs_trans; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Street Address</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Zip Code</th>
                                        </tr>
                                        <tr>
                                            <td><?php formatAddress( $c_st_address); ?>
                                                <input type="hidden" name="c_st_address"
                                                    value="<?php formatAddress( $c_st_address); ?>">
                                            </td>
                                            <td><?php removeChars($c_city); ?>
                                                <input type="hidden" name="c_city"
                                                    value="<?php removeChars( $c_city); ?>">
                                            </td>
                                            <td><?php echo $c_state; ?>
                                                <input type="hidden" name="c_state" value="<?php echo $c_state; ?>">
                                            </td>
                                            <td><?php echo $c_zipcode; ?>
                                                <input type="hidden" name="c_zipcode" value="<?php echo $c_zipcode; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Grade</th>
                                            <th>School</th>
                                            <th>Phone Number</th>
                                            <th>Email</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo $c_grade ; ?>
                                                <input type="hidden" name="c_grade" value="<?php echo $c_grade ; ?>">
                                            </td>
                                            <td><?php removeChars( $c_school); ?>
                                                <input type="hidden" name="c_school"
                                                    value="<?php removeChars( $c_school); ?>">
                                            </td>
                                            <td><?php echo $c_cell_phone; ?>
                                                <input type="hidden" name="c_cell_phone"
                                                    value="<?php echo $c_cell_phone; ?>">
                                            </td>
                                            <td><?php safeEcho( $c_email); ?>
                                                <input type="hidden" name="c_email"
                                                    value="<?php safeEcho( $c_email); ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Child's Allergies</th>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><?php formatAllergies($c_allergies);?>
                                                <input type="hidden" name="c_allergies"
                                                    value="<?php formatAllergies($c_allergies); ?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th colspan="4">
                                                <h4><b>Guardian's Information</b></h4>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Has Vehicle</th>
                                        </tr>
                                        <tr>
                                            <td><?php removeChars( $p_fname); ?>
                                                <input type="hidden" name="p_fname"
                                                    value="<?php removeChars($p_fname); ?>">
                                                <input type="hidden" name="p_is_guardian" value="<?php echo true; ?>">
                                            </td>
                                            <td><?php allowHyphenLastNames( $p_lname); ?>
                                                <input type="hidden" name="p_lname"
                                                    value="<?php allowHyphenLastNames($p_lname); ?>">
                                            </td>
                                            <td><?php safeEcho( $p_email); ?>
                                                <input type="hidden" name="p_email"
                                                    value="<?php safeEcho( $p_email); ?>">
                                            </td>
                                            <td><?php if ($has_vehicle == 1){echo "YES";}else{echo "NO";} ?>
                                                <input type="hidden" name="has_vehicle"
                                                    value="<?php echo $has_vehicle; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Street Address</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Zip Code</th>
                                        </tr>
                                        <tr>
                                            <td><?php formatAddress($p_st_address); ?>
                                                <input type="hidden" name="p_st_address"
                                                    value="<?php formatAddress( $p_st_address); ?>">
                                            </td>
                                            <td><?php removeChars( $p_city); ?>
                                                <input type="hidden" name="p_city"
                                                    value="<?php removeChars( $p_city); ?>">
                                            </td>
                                            <td><?php echo $p_state; ?>
                                                <input type="hidden" name="p_state" value="<?php echo $p_state; ?>">
                                            </td>
                                            <td><?php echo $p_zipcode; ?>
                                                <input type="hidden" name="p_zipcode" value="<?php echo $p_zipcode; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Organization</th>
                                            <th>Cell Phone Number</th>
                                            <th>Home Phone Number</th>
                                            <th>Work Phone Number</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php if(isset($org_name)){ echo $org_name; ?>
                                                <input type="hidden" name="org_id"
                                                    value="<?php echo $org_id;?>"><?php } ?>
                                            </td>
                                            <td><?php echo $p_cell_phone; ?>
                                                <input type="hidden" name="p_cell_phone"
                                                    value="<?php echo $p_cell_phone; ?>">
                                            </td>
                                            <td><?php echo $p_home_phone; ?>
                                                <input type="hidden" name="p_home_phone"
                                                    value="<?php echo $p_home_phone; ?>">
                                            </td>
                                            <td><?php echo $p_work_phone; ?>
                                                <input type="hidden" name="p_work_phone"
                                                    value="<?php echo $p_work_phone; ?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th colspan="4">
                                                <h4><b>Emergency Contact Info</b></h4>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th colspan="2">Full Name</th>
                                            <th colspan="2">Phone Number</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2"> <?php allowHyphenLastNames( $c_emg_contact_name); ?>
                                                <input type="hidden" name="c_emg_contact_name"
                                                    value="<?php allowHyphenLastNames( $c_emg_contact_name); ?>">
                                            </td>
                                            <td colspan="2"><?php echo $c_emg_contact_num; ?>
                                                <input type="hidden" name="c_emg_contact_num"
                                                    value="<?php echo $c_emg_contact_num; ?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                </thread>
                            </table>
                        </div>
                    </div>
                </div>
                <div class='form-row' id='child_buttons'>
                    <?php if ($action == "Review Form" && $action !== "Submit Form") :?>
                    <div id='child_submit_button'><button class="btn btn-success" name="action" type="submit"
                            value="Submit Form">Submit Form</button></div>
                    <?php else:?>
                    <button class="btn btn-success" name="action" type="submit"
                        value="Register for another Program">Register
                        for another section</button>
                    <?php endif;?>
                    <div>
                        <a href="child_index.php" class="btn btn-danger">Clear Form</a>
                    </div>
                </div>

            </form>
            <br />
            <?php endif;?>
        </div>
    </div>
    </div>
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
</body>

</html>