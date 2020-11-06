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
                <?php if ($action !=="Review Form"):?>
                <h4>Person Entry Form</h4>
                <div><?php if ($errorMSG !== null):?>
                    <a href="#" class="btn btn-danger"><?php echo $errorMSG;?></a>
                    <a href="../edit/edit_person_index.php"
                        class="btn btn-info"><?php echo $linkMSG;?></a><?php endif;?>
                </div>
                <div><?php if ($confirmMSG !== null):?>
                    <a href="#" class="btn btn-success"><?php echo $confirmMSG;?></a>
                    <a href="person_entry_index.php" class="btn btn-info"><?php echo $linkMSG2;?></a><?php endif;?>
                </div>
                <form class="needs-validation" action='person_entry_index.php' novalidate method="post">
                    <!-- ROW 1 -->
                    <div class="form-row">
                        <div class="col-sm-3">
                            <label for="validationCustom01">First Name</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="First name"
                                name="p_fname" value="<?php if($p_fname !== null){echo $p_fname; }?>" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom02">Last Name</label>
                            <input type="text" class="form-control" id="validationCustom02" placeholder="Last name"
                                name="p_lname" value="<?php if($p_lname !== null){echo $p_lname; }?>" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom03">Email</label>
                            <input type="email" class="form-control" id="validationCustom03" placeholder="Email Address"
                                name="p_email" value="<?php if($p_email !== null){echo $p_email; }?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Organization</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="org_id" required>
                                    <option value="<?php if ($org_id){echo $org_id;} ?>">
                                        <?php if ($org_id)
                                        {
                                            foreach ($organizations as $organization)
                                            { 
                                                    if ($organization['org_id'] == $org_id)
                                                    {
                                                        echo  $organization['org_name']; 
                                                    }
                                                }
                                            }?>
                                    </option>
                                    <?php foreach ($organizations as $organization):?>
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
                    <!-- ROW 2 -->
                    <div class="form-row">
                        <div class="col-sm-6">
                            <label for="validationCustom01">Street Address</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="Street Address"
                                name="p_st_address" value="<?php if($p_st_address !== null){echo $p_st_address; }?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom01">City</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="City"
                                name="p_city" value="<?php if($p_city !== null){echo $p_city; }?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">State</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="p_state">
                                    <option><?php if($p_state !== null){echo $p_state; }?></option>
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
                            <input type="text" class="form-control" id="validationCustom01" placeholder="Zip"
                                name="p_zipcode" pattern="[0-9]{5}"
                                value="<?php if($p_zipcode !== null){echo $p_zipcode; }?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <!-- ROW 3 -->
                    <div class="form-row">
                        <div class="col-sm-4">
                            <label for="validationCustom01">Primary/Cell Phone</label>
                            <input type="tel" class="form-control" id="validationCustom01"
                                placeholder="ex. 123-456-7890" name="p_cell_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                value="<?php if($p_cell_phone !== null){echo $p_cell_phone; }?>" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="validationCustom02">Home Phone</label>
                            <input type="tel" class="form-control" id="validationCustom02"
                                placeholder="ex. 123-456-7890" name="p_home_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                value="<?php if($p_home_phone !== null){echo $p_home_phone; }?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="validationCustom03">Work Phone</label>
                            <input type="tel" class="form-control" id="validationCustom03"
                                placeholder="ex. 123-456-7890" name="p_work_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                value="<?php if($p_work_phone !== null){echo $p_work_phone; }?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- ROW 4 -->
                    <div id="dividerLine" class="form-row"></div>
                    <h4>Person's Roles</h4>
                    <div class="form-row">
                    </div> <br>
                    <div class="form-row">
                        <div class="col-sm-3">
                            <label for="validationCustom02"><b>Willing to Volunteer?</b></label>
                            <select class="form-control" id="exampleFormControlSelect1" name='p_is_volunteer' required>
                                <option value="<?php if($p_is_volunteer !== null){echo $p_is_volunteer; }?>">
                                    <?php if($p_is_volunteer !== null && $p_is_volunteer == 1){echo "YES";}else if($p_is_volunteer !== null && $p_is_volunteer == 0){echo "NO"; }?>
                                </option>
                                <option value=1>YES</option>
                                <option value=0>NO</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom01">Volunteer Primary Skill</label>
                            <input type="text" class="form-control" id="validationCustom01" list="skill1"
                                placeholder="(30 character max)" name='primary_skill_type'
                                value="<?php if($primary_skill_type !== null){echo $primary_skill_type; }?>" />
                            <datalist id="skill1">
                                <option></option>
                                <?php foreach ($primary_skill_types as $primary_skillType):?>
                                <option><?php echo $primary_skillType["primary_skill_type"];?></option>
                                <?php endforeach;?>
                            </datalist>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div><?php if ($errorMSG4 !== null):?>
                                <a href="#" class="btn btn-danger"><?php echo $errorMSG4;?></a><?php endif;?>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom01">Volunteer Secondary Skill</label>
                            <input type="text" class="form-control" id="validationCustom01" list="skill2"
                                placeholder="(30 character max)" name='sec_skill_type'
                                value="<?php if($sec_skill_type !== null){echo $sec_skill_type; }?>" />
                            <datalist id="skill2">
                                <option></option>
                                <?php foreach ($sec_skill_types as $sec_skillType):?>
                                <option><?php echo $sec_skillType["sec_skill_type"];?></option>
                                <?php endforeach;?>
                            </datalist>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div><?php if ($errorMSG4 !== null):?>
                                <a href="#" class="btn btn-danger"><?php echo $errorMSG4;?></a><?php endif;?>
                            </div>
                        </div>
                    </div> <br>
                    <div class="form-row">
                        <div class="col-sm-3">
                            <label for="validationCustom03"><b>Is Staff?</b></label>
                            <select class="form-control" id="exampleFormControlSelect1" name='p_is_staff' required>
                                <option value="<?php if($p_is_staff !== null){echo $p_is_staff; }?>">
                                    <?php if($p_is_staff !== null && $p_is_staff == 1){echo "YES";}else if($p_is_staff !== null && $p_is_staff == 0){echo "NO"; }?>
                                </option>
                                <option value=1>YES</option>
                                <option value=0>NO</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom03">Staff's Position</label>
                            <input type="text" class="form-control" id="validationCustom01" list="position"
                                placeholder="(30 character max)" name='staff_position'
                                value="<?php if($staff_position !== null){echo $staff_position; }?>" />
                            <datalist id="position">
                                <option></option>
                                <?php foreach ($staff_positions as $staffPos):?>
                                <option><?php echo $staffPos["staff_position"];?></option>
                                <?php endforeach;?>
                            </datalist>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div><?php if ($errorMSG5 !== null):?>
                                <a href="#" class="btn btn-danger"><?php echo $errorMSG5;?></a><?php endif;?>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class='row' id='person_buttons'>
                        <button class="btn btn-success" type="submit" name="action" value="Review Form">Review
                            Form</button>
                        <div>
                            <a href="person_entry_index.php" class="btn btn-danger">Clear Form</a>
                        </div>
                    </div>
                </form>
                <br>
                <!-- submit form -->
            </div>
        </div>
    </div>
    <?php endif;?>
    <br />
    <?php if ($action == "Review Form" && $person_count==0 &&$validataed=true):?>
    <div class='form-row'>
        <br>
        <div class='col-md-12' id='table_data'>
            <form action="person_entry_index.php" method="post">
                <div class='table-responsive'>
                    <table class='table table-striped table-sm'>
                        <thread>
                            <thead>
                                <tr>
                                    <th colspan=4><h5><b>Review Person Information</b></h5> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Organization</th>
                                </tr>
                                <tr>
                                    <td><?php removeChars($p_fname); ?>
                                        <input type="hidden" name="p_fname" value="<?php removeChars($p_fname); ?>">
                                    </td>
                                    <td><?php allowHyphenLastNames($p_lname); ?>
                                        <input type="hidden" name="p_lname"
                                            value="<?php allowHyphenLastNames($p_lname); ?>">
                                    </td>
                                    <td><?php echo $p_email; ?>
                                        <input type="hidden" name="p_email" value="<?php echo $p_email; ?>">
                                    </td>
                                    <td><?php if(isset($org_name)){ echo $org_name; ?>
                                        <input type="hidden" name="org_id" value="<?php echo $org_id;?>"><?php } ?>
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
                                            value="<?php formatAddress($p_st_address); ?>">
                                    </td>
                                    <td><?php removeChars($p_city); ?>
                                        <input type="hidden" name="p_city" value="<?php removeChars($p_city); ?>">
                                    </td>
                                    <td><?php echo $p_state; ?>
                                        <input type="hidden" name="p_state" value="<?php echo $p_state; ?>">
                                    </td>
                                    <td><?php echo $p_zipcode; ?>
                                        <input type="hidden" name="p_zipcode" value="<?php echo $p_zipcode; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Primary/Cell Phone Number</th>
                                    <th>Home Phone Number</th>
                                    <th>Work Phone Number</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td><?php echo $p_cell_phone; ?>
                                        <input type="hidden" name="p_cell_phone" value="<?php echo $p_cell_phone; ?>">
                                    </td>
                                    <td><?php echo $p_home_phone; ?>
                                        <input type="hidden" name="p_home_phone" value="<?php echo $p_home_phone; ?>">
                                    </td>
                                    <td><?php echo $p_work_phone; ?>
                                        <input type="hidden" name="p_work_phone" value="<?php echo $p_work_phone; ?>">
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan=4></td>
                                </tr>
                                <tr>
                                    <th colspan=4><h5><b>Person is a </h5></b></th>
                                <tr>
                                    <th>Volunteer</th>
                                    <th>Volunteer Primary Skill</th>
                                    <th>Volunteer Secondary Skill</th>
                                    <th>
                                        <!-- Donor -->
                                    </th>
                                </tr>
                                <tr>
                                    <td><?php if ($p_is_volunteer ==true){echo "YES";}else{echo "NO";}?>
                                        <input type="hidden" name="p_is_volunteer"
                                            value="<?php echo $p_is_volunteer; ?>">
                                    </td>
                                    <td><?php removeChars($primary_skill_type); ?>
                                        <input type="hidden" name="primary_skill_type"
                                            value="<?php removeChars($primary_skill_type); ?>">
                                    </td>
                                    <td><?php removeChars($sec_skill_type); ?>
                                        <input type="hidden" name="sec_skill_type"
                                            value="<?php removeChars($sec_skill_type); ?>">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Staff</th>
                                    <th>Staff Position or Title</th>
                                    <th></th>
                                    <th></th>

                                </tr>
                                <tr>

                                    <td><?php if ($p_is_staff ==true){echo "YES";}else{echo "NO";}?>
                                        <input type="hidden" name="p_is_staff" value="<?php echo $p_is_staff; ?>">
                                    </td>
                                    <td><?php removeChars($staff_position); ?>
                                        <input type="hidden" name="staff_position"
                                            value="<?php removeChars($staff_position); ?>">
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </thread>
                    </table>
                </div>
                <div class='row' id='person_buttons'>
                    <button class="btn btn-success" name="action" type="submit" value="Submit Form">Submit
                        Form</button>
                    <div>
                        <a href="person_entry_index.php" class="btn btn-danger">Clear Form</a>
                    </div>
                </div>
            </form>
            <br>
        </div>
    </div>
    <!--     </div>
    </div>
    </div> -->
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
    <script src="../scripts/js/bootstrap.min.js"></script>
</body>

</html>