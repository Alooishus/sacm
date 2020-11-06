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
        <?php if (!isset($action) ||$action !=="Review Form" ):?>
        <div class='col-12'>
            <h4>Edit Child Form</h4>
            <!-- shows a message that child doesn't exist and provides link to new child registration page -->
            <div><?php if ($errorMSG !== null):?>
                <a href="#" class="btn btn-danger"><?php echo $errorMSG;?></a>
                <a href="../entry/child_index.php" class="btn btn-info"><?php echo $linkMSG;?></a><?php endif;?>
            </div>
            <!-- changes button to confirmation and update new child button -->
            <div><?php if ($confirmMSG !== null):?>
                <a href="#" class="btn btn-success"><?php echo $confirmMSG;?></a>
                <a href="edit_child_index.php" class="btn btn-info"><?php echo $linkMSG;?></a><?php endif;?>
            </div>
            <form action="edit_child_index.php" class="needs-validation" novalidate method="post">
                <div class='row'>
                    <div class='col-sm-3'>
                        <label for="validationCustom01">First Name</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="First name"
                            name="c_fname" value="<?php if(isset($c_fname)){ removeChars ($c_fname);} ?>" required>
                    </div>
                    <div class='col-sm-3'>
                        <label for="validationCustom01">Last Name</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Last name"
                            name="c_lname" value="<?php if(isset($c_lname)){ allowHyphenLastNames ($c_lname);} ?>"
                            required>
                    </div>
                    <div class="col-sm-3">
                        <label for="validationCustom03">Date of Birth</label>
                        <input type="date" class="form-control" id="validationCustom03" required name='c_dob'
                            value="<?php if(isset($c_dob)){ echo $c_dob;} ?>">
                    </div>
                </div>
                <br>
                <!-- removes search button if a child has already been updated and allows new child update button -->
                <?php if ($confirmMSG == "" ):?>
                <button class="btn btn-success" type="submit" name="action" value="Search">Search</button>
                <?php endif; ?>
            </form>
        </div>
        <?php endif;?>
        <?php if (isset($action) && $action == "Search"&& $child_count!==0):?>
        <div class='row' id='main_form'>
            <div class='col-12'>
                <h4>Edit Child Information</h4>
                <input type="hidden" name="c_id" value="<?php echo $child['c_id'] ; ?>">
                <form action="edit_child_index.php" class="needs-validation" novalidate method="post">
                    <!-- ROW 1 -->
                    <div class="form-row">
                        <div class="col-sm-3">
                            <label for="validationCustom01">First Name</label>
                            <input type="hidden" value="<?php removeChars ($c_fname);?>" name='c_fname'>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="First name"
                                value="<?php echo $child['c_fname'] ; ?>" required name='c_fname2'>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom02"> Last Name</label>
                            <input type="hidden" value="<?php allowHyphenLastNames ($c_lname);?>" name='c_lname'>
                            <input type="text" class="form-control" id="validationCustom02" placeholder="Last name"
                                value="<?php echo $child['c_lname'] ; ?>" required name='c_lname2'>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom03">Date of Birth</label>
                            <input type="hidden" value="<?php echo $c_dob;?>" name='c_dob'>
                            <input type="date" class="form-control" id="validationCustom03" required name='c_dob2'
                                value="<?php echo $child['c_dob'] ; ?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Gender</label>
                                <select class="form-control" id="exampleFormControlSelect1" required name='c_gender'>
                                <option
                                        <?php if ($child['c_gender'] == 'F'){echo 'value="F"';}else {echo 'value="M"';}?>>
                                        <?php if ($child['c_gender'] == 'F'){echo "F";}else{echo "M";}?>
                                    </option>
                                    <!-- reverse logic for given answer to remove duplicate M/F -->
                                    <option
                                        <?php if ($child['c_gender'] == 'F'){echo 'value="M"';}else {echo 'value="F"';}?>>
                                        <?php if ($child['c_gender'] == 'F'){echo "M";}else{echo "F";}?>
                                    </option>
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
                                    <option
                                        <?php if ($child['c_needs_trans'] ==1){echo 'value=1';}else {echo 'value=0';}?>>
                                        <?php if ($child['c_needs_trans'] ==1){echo "YES";}else{echo "NO";}?>
                                    </option>
                                    <!-- reverse logic for given answer to remove duplicate yes/no -->
                                    <option
                                        <?php if ($child['c_needs_trans'] ==1){echo 'value=0';}else {echo 'value=1';}?>>
                                        <?php if ($child['c_needs_trans'] ==1){echo "NO";}else{echo "YES";}?> </option>

                                    <!--  <option value=1>YES</option>
                                    <option value=0>NO</option> -->
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
                                    name='c_school' value="<?php echo $child['c_school'];?>" required placeholder="<?php echo $child['c_school'];?>"/>
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
                            <label for="validationCustom01">Child's&nbsp;Cell</label>
                            <input type="tel" id="phone" name="c_cell_phone" class="form-control"
                                placeholder="ex. 123-456-7890" id="validationCustom01"
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
                        <div class="col-sm-4">
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
                        <div class="col-sm-2">
                            <label for="validationCustom01">Active Status</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='c_active' required>
                                <option <?php if ($child['c_active'] ==1){echo 'value=1';}else {echo 'value=0';}?>>
                                    <?php if ($child['c_active'] ==1){echo "ACTIVE";}else{echo "INACTIVE";}?>
                                </option>
                                <!-- Remove duplicate entry -->
                                <option <?php if ($child['c_active'] ==1){echo 'value=0';}else {echo 'value=1';}?>>
                                    <?php if ($child['c_active'] ==1){echo "INACTIVE";}else{echo "ACTIVE";}?>
                                </option>
                                <!-- <option value=1>ACTIVE</option>
                                <option value=0>INACTIVE</option> -->
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <label for="exampleFormControlTextarea1">Allergies - Reaction - Treatment (Separate
                                    multiple allergies with semicolons ";")</label>
                                <input type="text" class="form-control" id="validationCustom01" name='c_allergies'
                                    value="<?php echo $child['c_allergies']; ?>" placeholder="update as needed" />
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- ROW 6 -->
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
                            <input type="tel" id="phone" name="c_emg_contact_num" placeholder="ex. 123-456-7890"
                                class="form-control" id="validationCustom01" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                value="<?php echo $child['c_emg_contact_num']; ?>" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="form-row">
                        <!-- BUTTON -->
                        <button class="btn btn-success" name="action" value="Review Form" type="submit">Review
                            Form</button>
                        <div>
                            <a href="edit_child_index.php" class="btn btn-danger">Clear Form</a>
                        </div>
                    </div>
                </form>
                <br />
            </div>
            <?php endif;?>
            <?php if (isset($action) && $action == "Review Form" ) :?>
            <div class='row' id='main_form'>
                <div class='col-md-12' id='table_data'>
                    <br>
                    <form action="edit_child_index.php" class="needs-validation" novalidate method="post">
                        <div class='table-responsive'>
                            <table class='table table-striped table-sm'>
                                <thread>
                                    <thead>
                                        <tr>
                                            <th colspan=5>
                                                <h4><b>Submit to Confirm Child's Information Update</b></h4>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>First Last Name</th>
                                            <th>Date of Birth</th>
                                            <th>Gender</th>
                                            <th>Request Transport</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td><?php removeChars($c_fname2); echo" ";  allowHyphenLastNames($c_lname2); ?>
                                                <input type="hidden" name="c_fname" value="<?php echo $c_fname; ?>">
                                                <input type="hidden" name="c_lname" value="<?php echo $c_lname; ?>">
                                                <input type="hidden" name="c_fname2"
                                                    value="<?php removeChars($c_fname2); ?>">
                                                <input type="hidden" name="c_lname2"
                                                    value="<?php allowHyphenLastNames($c_lname2); ?>">
                                            </td>
                                            <td><?php echo $c_dob2; ?>
                                                <input type="hidden" name="c_dob" value="<?php echo $c_dob; ?>">
                                                <input type="hidden" name="c_dob2" value="<?php echo $c_dob2; ?>">
                                            </td>
                                            <td><?php echo $c_gender; ?>
                                                <input type="hidden" name="c_gender" value="<?php echo $c_gender; ?>">
                                            </td>
                                            <td><?php if ($c_needs_trans ==1){echo "YES";}else{echo "NO";} ?>
                                                <input type="hidden" name="c_needs_trans"
                                                    value="<?php echo $c_needs_trans; ?>">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Grade</th>
                                            <th>School</th>
                                            <th>Child's Cell</th>
                                            <th>Child's Email</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td><?php echo $c_grade ; ?>
                                                <input type="hidden" name="c_grade" value="<?php echo $c_grade ; ?>">
                                            </td>
                                            <td><?php removeChars($c_school); ?>
                                                <input type="hidden" name="c_school"
                                                    value="<?php removeChars($c_school); ?>">
                                            </td>
                                            <td><?php echo $c_cell_phone; ?>
                                                <input type="hidden" name="c_cell_phone"
                                                    value="<?php echo $c_cell_phone; ?>">
                                            </td>
                                            <td><?php echo $c_email; ?>
                                                <input type="hidden" name="c_email" value="<?php echo $c_email; ?>">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Street Address</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Zip Code</th>
                                            <th>Enrollment Status</th>
                                        </tr>
                                        <tr>
                                            <td><?php formatAddress($c_st_address); ?>
                                                <input type="hidden" name="c_st_address"
                                                    value="<?php formatAddress($c_st_address); ?>">
                                            </td>
                                            <td><?php removeChars($c_city); ?>
                                                <input type="hidden" name="c_city"
                                                    value="<?php removeChars($c_city); ?>">
                                            </td>
                                            <td><?php echo $c_state; ?>
                                                <input type="hidden" name="c_state" value="<?php echo $c_state; ?>">
                                            </td>
                                            <td><?php echo $c_zipcode; ?>
                                                <input type="hidden" name="c_zipcode" value="<?php echo $c_zipcode; ?>">
                                            </td>
                                            <td><?php if ($c_active ==true){echo "ACTIVE";}else{echo "INACTIVE";} ?>
                                                <input type="hidden" name="c_active" value="<?php echo $c_active; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="5">Child's Allergies</th>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><?php formatAllergies( $c_allergies);?>
                                                <input type="hidden" name="c_allergies"
                                                    value="<?php formatAllergies( $c_allergies); ?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th colspan=2>Emergency Contact Full Name</th>
                                            <th colspan=4>Emergency Contact Phone Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan=2> <?php allowHyphenLastNames($c_emg_contact_name); ?>
                                                <input type="hidden" name="c_emg_contact_name"
                                                    value="<?php allowHyphenLastNames($c_emg_contact_name); ?>">
                                            </td>
                                            <td colspan=4><?php echo $c_emg_contact_num; ?>
                                                <input type="hidden" name="c_emg_contact_num"
                                                    value="<?php echo $c_emg_contact_num; ?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                </thread>
                            </table>
                        </div>
                        <div class="form-row">
                            <button class="btn btn-success" name="action" type="submit" value="Submit Form">Submit
                                Form</button>
                            <div>
                                <a href="edit_child_index.php" class="btn btn-danger">Clear Form</a>
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
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