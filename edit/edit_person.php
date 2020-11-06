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
            <h4>Edit Person Form</h4>

            <!-- ERROR MSG -->
            <div><?php if ($errorMSG !== null):?>
                <a href="#" class="btn btn-danger"><?php echo $errorMSG;?></a>
                <b>OR</b>
                <a href="../entry/person_entry_index.php" class="btn btn-info"><?php echo $linkMSG;?></a><?php endif;?>
            </div>

            <!-- CONFIRM MSG -->
            <div><?php if ($confirmMSG2 !== null):?>
                <a href="#" class="btn btn-success"><?php echo $confirmMSG2;?></a>
                <a href="edit_person_index.php" class="btn btn-info"><?php echo $linkMSG2;?></a><?php endif;?>
            </div>

            <!-- FIND PARENT FORM -->
            <form action="edit_person_index.php" class="needs-validation" novalidate method="post">
                <div class='row'>
                    <div class='col-sm-3'>
                        <label for="validationCustom01">First Name</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="First name"
                            name="p_fname" value="<?php if(isset($p_fname)){ removeChars ($p_fname);} ?>" required>
                    </div>
                    <div class='col-sm-3'>
                        <label for="validationCustom01">Last Name</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Last name"
                            name="p_lname" value="<?php if(isset($p_lname)){ allowHyphenLastNames ($p_lname);} ?>"
                            required>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <button class="btn btn-success" type="submit" name="action" value="Search">Search</button>
                    <div>
                        <a href="edit_person_index.php" class="btn btn-danger">Clear Form</a>
                    </div>
                </div>
            </form>
        </div>
        <?php endif;?>


        <?php if (isset($action)):?>
        <div class='row' id='main_form'>
            <div class='col-12'>
                <?php if (isset($action) && $action == "Search"&& $person_count!==0):?>
                <h4>Edit Person Information</h4>
                <form action='edit_person_index.php' class="needs-validation" novalidate method="post">
                    <!-- ROW 1 -->
                    <div class="form-row">
                        <div class="col-sm-3">
                            <label for="validationCustom01">First Name</label>
                            <input type="hidden" value="<?php if(isset($p_fname)){ removeChars ($p_fname);} ?>"
                                name='p_fname'>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="First name"
                                name="p_fname2" value="<?php echo $person['p_fname'];?>" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom02">Last Name</label>
                            <input type="hidden" value="<?php if(isset($p_lname)){ allowHyphenLastNames ($p_lname);} ?>"
                                name='p_lname'>
                            <input type="text" class="form-control" id="validationCustom02" placeholder="Last name"
                                name="p_lname2" value="<?php echo $person['p_lname'];?>" required>
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
                                    <option value="<?php if ($person['org_id'] !==null){echo $person['org_id'];}?>">
                                        <?php foreach($organizations as $organization):  
                                                foreach($persons as $person):
                                            if ($person['org_id'] ==$organization['org_id']){echo$organization['org_name'];}
                                        endforeach;
                                        endforeach;?>
                                    </option>
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
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <label for="validationCustom01">Street Address</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="Street Address"
                                name="p_st_address" value="<?php echo $person['p_st_address'];?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom01">City</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="City"
                                name="p_city" value="<?php echo $person['p_city'];?>">
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
                        <!-- 3RD ROW -->
                    </div>
                    <div class="form-row">
                        <div class="col-sm-4">
                            <label for="validationCustom01">Cell Phone</label>
                            <input type="tel" class="form-control" id="validationCustom01"
                                placeholder="ex. 123-456-7890" name="p_cell_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                value="<?php echo $person['p_cell_phone'];?>" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="validationCustom02">Home Phone</label>
                            <input type="tel" class="form-control" id="validationCustom02"
                                placeholder="ex. 123-456-7890" name="p_home_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                value="<?php echo $person['p_home_phone'];?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="validationCustom03">Work Phone</label>
                            <input type="tel" class="form-control" id="validationCustom03"
                                placeholder="ex. 123-456-7890" name="p_work_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                value="<?php echo $person['p_work_phone'];?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <?php if ($volunteer_count>0):?>
                        <?php foreach ($person_skills as $skill):?>
                        <div class="col-sm-3">
                            <label for="validationCustom01">Volunteer Primary Skill</label>
                            <input type="text" class="form-control datalistfix" id="validationCustom01" list="skill1"
                                placeholder="<?php echo $skill["primary_skill_type"];?>" name='primary_skill_type'
                                required
                                value="<?php if($skill["primary_skill_type"] !== null){echo $skill["primary_skill_type"]; }?>" />
                            <datalist id="skill1">
                                <option></option>
                                <?php foreach ($primary_skill_types as $primary_skillType):?>
                                <option><?php echo $primary_skillType["primary_skill_type"];?></option>
                                <?php endforeach;?>
                            </datalist>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom01">Volunteer Secondary Skill</label>
                            <input type="text" class="form-control datalistfix" id="validationCustom01" list="skill2"
                                placeholder="<?php echo $skill["sec_skill_type"];?>" name='sec_skill_type' required
                                value="<?php if($skill["sec_skill_type"] !== null){echo $skill["sec_skill_type"]; }?>" />
                            <datalist id="skill2">
                                <option></option>
                                <?php foreach ($sec_skill_types as $sec_skillType):?>
                                <option><?php echo $sec_skillType["sec_skill_type"];?></option>
                                <?php endforeach;?>
                            </datalist>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <?php endforeach;?>
                        <?php endif;?>



                        <?php if ($staff_count>0):?>
                        <?php foreach ($position as $pos):?>
                        <div class="col-sm-3">
                            <label for="validationCustom01">Staff Position</label>
                            <input type="text" class="form-control datalistfix" id="validationCustom01" list="pos"
                                placeholder="<?php echo $pos["staff_position"];?>" name='staff_position' required
                                value="<?php if($pos["staff_position"] !== null){echo $pos["staff_position"]; }?>" />
                            <datalist id="pos">
                                <option></option>
                                <?php foreach ($positions as $p):?>
                                <option><?php echo $p["staff_position"];?></option>
                                <?php endforeach;?>
                            </datalist>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <?php endforeach;?>
                        <?php endif;?>
                    </div>
                    <br>
                    <div id="dividerLine" class="form-row"></div>
                    <h4>Person's Historical Roles for Salvation Army Children's Ministry</h4>
                    <!-- 4TH ROW -->
                    <div class="form-row">
                        <?php foreach ($persons as $person):?>
                        <!-- removes ability to change status after records have been created -->
                        <div class="col-sm-2">
                            <label for="validationCustom02">Donor?&emsp;(DONATION)</label>
                            <p><?php if ($person['p_is_donor'] ==true){echo "YES";}else{echo "NO";}?></p>
                            <input type="hidden" name="p_is_donor" value="<?php echo $person['p_is_donor'];?>">
                        </div>

                        <!-- removes ability to change status after records have been created -->
                        <div class="col-sm-2">
                            <label for="validationCustom02">Volunteer?</label>
                            <p><?php if ($person['p_is_volunteer'] ==true){echo "YES";}else{echo "NO";}?></p>
                            <input type="hidden" name="p_is_volunteer" value="<?php echo $person['p_is_volunteer'];?>">
                        </div>
                        <?php if ($person['p_is_staff']==0):?>

                        <div class="col-sm-2">
                            <label for="validationCustom03">Staff?</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='p_is_staff'>
                                <option <?php if ($person['p_is_staff'] ==true){echo "value=1";}else{echo "value=0";}?>>
                                    <?php if ($person['p_is_staff'] ==true){echo "YES";}else{echo "NO";}?>
                                </option>
                                <!-- reverse logic to remove duplicate entry -->
                                <option <?php if ($person['p_is_staff'] ==true){echo "value=0";}else{echo "value=1";}?>>
                                    <?php if ($person['p_is_staff'] ==true){echo "NO";}else{echo "YES";}?>
                                </option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <?php else:?>
                        <!-- removes ability to change status after records have been created -->
                        <div class="col-sm-2">
                            <label for="validationCustom02">Staff?</label>
                            <p><?php if ($person['p_is_staff'] ==true){echo "YES";}else{echo "NO";}?></p>
                            <input type="hidden" name="p_is_staff" value="<?php echo $person['p_is_staff'];?>">
                        </div>
                        <?php endif;?>
                        <div class="col-sm-2">
                            <label for="validationCustom02">Guardian?&emsp;(ENROLLMENT)</label>
                            <p>&nbsp;<?php if ($person['p_is_guardian'] ==true){echo "YES";}else{echo "NO";}?></p>
                            <input type="hidden" name="p_is_guardian" value="<?php echo $person['p_is_guardian'];?>">
                        </div>
                        <?php if($person['p_is_guardian'] ==true):?>
                        <div class="col-sm-2">
                            <label for="validationCustom01">Guardian w/Vehicle?</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='has_vehicle'>

                                <option <?php if ($original_has_vehicle ==true){echo "value=1";}else{echo "value=0";}?>>
                                    <?php if ($original_has_vehicle ==true){echo "YES";}else{echo "NO";}?>
                                </option>
                                <!-- reverse logic to remove duplicate entry -->
                                <option <?php if ($original_has_vehicle ==true){echo "value=0";}else{echo "value=1";}?>>
                                    <?php if ($original_has_vehicle==true){echo "NO";}else{echo "YES";}?>
                                </option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <?php endif;?>
                    </div>
                    <br />
                    <button class="btn btn-success" type="submit" name="action" value="Review Form">Review
                        Form</button>
                    <button class="btn btn-danger" type="submit">Clear Form</button>
                    <br> <?php endforeach;?>
                </form>
                <p></p>
            </div>
            <?php endif;?>
            <!-- submit form -->
            <br />
            <?php if ($action == "Review Form" ):?>
            <div class='form-row'>
                <br>
                <div class='col-md-12' id='table_data'>
                    <div class='table-responsive'>
                        <form action="edit_person_index.php" method="post">
                            <table class='table table-striped table-sm'>
                                <thread>
                                    <thead>
                                        <tr>
                                            <th colspan=6>
                                                <h4><b>Edit Person's Information Review </b></h4>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Organization</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td><?php removeChars( $p_fname2); ?>
                                                <input type="hidden" name="p_fname"
                                                    value="<?php removeChars( $p_fname); ?>">
                                                <input type="hidden" name="p_fname2"
                                                    value="<?php removeChars( $p_fname2); ?>">
                                            </td>
                                            <td><?php allowHyphenLastNames( $p_lname2); ?>
                                                <input type="hidden" name="p_lname"
                                                    value="<?php allowHyphenLastNames( $p_lname); ?>">
                                                <input type="hidden" name="p_lname2"
                                                    value="<?php allowHyphenLastNames( $p_lname2); ?>">
                                            </td>
                                            <td><?php echo $p_email; ?>
                                                <input type="hidden" name="p_email" value="<?php echo $p_email; ?>">
                                            </td>
                                            <td>
                                                <?php if(isset($org_name)){ echo $org_name; ?>
                                                <input type="hidden" name="org_id"
                                                    value="<?php echo $org_id;?>"><?php } ?>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Street Address</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Zip Code</th>
                                            <?php if($staff_count>0):?>
                                            <th>Staff Position</th>
                                            <?php else:?>
                                            <th></th>
                                            <?php endif;?>
                                        </tr>
                                        <tr>
                                            <td><?php formatAddress( $p_st_address); ?>
                                                <input type="hidden" name="p_st_address"
                                                    value="<?php formatAddress( $p_st_address); ?>">
                                            </td>
                                            <td><?php removeChars($p_city); ?>
                                                <input type="hidden" name="p_city"
                                                    value="<?php removeChars($p_city); ?>">
                                            </td>
                                            <td><?php echo $p_state; ?>
                                                <input type="hidden" name="p_state" value="<?php echo $p_state; ?>">
                                            </td>
                                            <td><?php echo $p_zipcode; ?>
                                                <input type="hidden" name="p_zipcode" value="<?php echo $p_zipcode; ?>">
                                            </td>
                                            <?php if($staff_count>0):?>
                                            <td><?php removeChars($staff_position); ?>
                                                <input type="hidden" name="staff_position"
                                                    value="<?php removeChars($staff_position); ?>">
                                            </td>
                                            <?php else:?>
                                            <th></th>
                                            <?php endif;?>
                                        </tr>
                                        <tr>
                                            <th>Cell Phone Number</th>
                                            <th>Home Phone Number</th>
                                            <th>Work Phone Number</th>
                                            <?php if($volunteer_count>0):?>
                                            <th>Volunteer Primary Skill</th>
                                            <th>Volunteer Secondary Skill</th>
                                            <?php else:?>
                                            <th></th>
                                            <th></th>
                                            <?php endif;?>
                                        </tr>
                                        <tr>
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
                                            <?php if($volunteer_count>0):?>
                                            <td><?php removeChars($primary_skill_type); ?>
                                                <input type="hidden" name="primary_skill_type"
                                                    value="<?php removeChars($primary_skill_type); ?>">
                                            </td>
                                            <td><?php removeChars($sec_skill_type); ?>
                                                <input type="hidden" name="sec_skill_type"
                                                    value="<?php removeChars($sec_skill_type); ?>">
                                            </td>
                                            <?php else:?>
                                            <td></td>
                                            <td></td>
                                            <?php endif;?>
                                        </tr>
                                        <tr>
                                            <th>Donor</th>
                                            <th>Volunteer</th>
                                            <th>Staff</th>
                                            <th><?php if ($p_is_guardian == true){echo "Guardian";}?></th>
                                            <th><?php if ($p_is_guardian == true){echo "Guardian has Vehicle?";}?></th>
                                        </tr>
                                        <tr>
                                            <td><?php if ($p_is_donor ==true){echo "YES";}else{echo "NO";}?>
                                                <input type="hidden" name="p_is_donor"
                                                    value="<?php echo $p_is_donor; ?>">
                                            </td>
                                            <td><?php if ($p_is_volunteer ==true){echo "YES";}else{echo "NO";}?>
                                                <input type="hidden" name="p_is_volunteer"
                                                    value="<?php echo $p_is_volunteer; ?>">
                                            </td>
                                            <td><?php if ($p_is_staff ==true){echo "YES";}else{echo "NO";}?>
                                                <input type="hidden" name="p_is_staff"
                                                    value="<?php echo $p_is_staff; ?>">
                                            </td>
                                            <?php if ($p_is_guardian == true):?>
                                            <td><?php if ($p_is_guardian ==true){echo "YES";}else{echo "NO";}?>
                                                <input type="hidden" name="p_is_guardian"
                                                    value="<?php echo $p_is_guardian; ?>">
                                            </td>
                                            <td><?php if ($has_vehicle ==true){echo "YES";}else{echo "NO";}?>
                                                <input type="hidden" name="has_vehicle"
                                                    value="<?php echo $has_vehicle; ?>">
                                            </td>
                                            <?php else:?>
                                            <td></td>
                                            <td></td>
                                            <?php endif;?>
                                        </tr>
                                        <tr>

                                        </tr>
                                    </tbody>
                                </thread>
                            </table>
                            <button class="btn btn-success" name="action" type="submit" value="Submit Form">Submit
                                Form</button>
                            <button class="btn btn-danger" type="submit" name="select" value="Clear Form">Start
                                Over</button>
                        </form>
                        <?php endif;?>
                        <?php endif;?>
                        <br>
                    </div>
                </div>
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
    <script src="../scripts/js/bootstrap.min.js"></script>
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