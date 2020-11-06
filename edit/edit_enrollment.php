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
            <h4>Edit Enrollment Form</h4>
            <div class='row'>

                <div><?php if ($errorMSG !== null ):?>
                    <a href="#" class="btn btn-danger"><?php echo $errorMSG;?></a><?php endif;?>
                </div>

                <!-- changes button to confirmation and update new child button -->
                <div><?php if ($confirmMSG !== null):?>
                    <a href="#" class="btn btn-success"><?php echo $confirmMSG;?></a><?php endif;?>
                </div>

            </div>

            <!-- shows a message that child doesn't exist and provides link to new child registration page -->
            <div><?php if ($errorMSG2 !== null):?>
                <a href="#" class="btn btn-danger"><?php echo $errorMSG2;?></a>
                <b>OR</b>
                <a href="../entry/child_index.php" class="btn btn-info"><?php echo $linkMSG;?></a><?php endif;?>
            </div>

            <form action="edit_enrollment_index.php" class="needs-validation" novalidate method="post">
                <input type="hidden" name="c_fname" value="<?php removeChars ($c_fname);?>">
                <input type="hidden" name="c_lname" value="<?php allowHyphenLastNames ($c_lname);?>">
                <input type="hidden" name="c_dob" value="<?php echo $c_dob;?>">
                <input type="hidden" name="c_id" value="<?php echo $c_id;?>">
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
                </div>
                <br>
                <div class='form-row'>
                    <button class="btn btn-success" type="submit" name="action" value="Search">Search</button>
                    <div>
                        <a href="edit_enrollment_index.php" class="btn btn-danger">Clear Form</a>
                    </div>
                </div>
                <br>
            </form>

        </div>
    </div>
    <?php if ( isset($child_count) && $child_count >0): ?>

    <?php if($action =="Search" || ($action !=="Review Form2"&&$action !==null) ):?>
    <div class='row' id='main_form'>
        <div class='col-12'>

            <form action="edit_enrollment_index.php" class="needs-validation" novalidate method="post">
                <input type="hidden" name="prog_sec" value="<?php echo $prog_sec;?>">
                <input type="hidden" name="c_fname" value="<?php removeChars ($c_fname);?>">
                <input type="hidden" name="c_lname" value="<?php allowHyphenLastNames ($c_lname);?>">
                <input type="hidden" name="c_dob" value="<?php echo $c_dob;?>">
                <input type="hidden" name="c_id" value="<?php echo $c_id;?>">

                <!-- ROW 1 -->
                <h4>Choose a Program Section to Edit</h4>
                <div class='form-row'>
                    <div class="col-sm-6">
                        <label for="validationCustom01">Choose a Program</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="e_num" required>
                            <option></option>
                            <?php foreach($enrollments as $enrollment): if ($enrollment['e_num'] == $e_num) {$selected = "selected";}else{$selected = "";}?>
                            <option <?php echo $selected;?> value="<?php echo $enrollment['e_num'];?>">
                                <?php echo
                                 $enrollment['prog_name']." @ ".
                                 $enrollment['prog_time']."&emsp;".
                                 $enrollment['prog_day']."&emsp;".
                                 $enrollment['prog_age_range']."&emsp;".
                                 $enrollment['prog_sec_desc'];
                                ?>
                            </option>
                            <?php endforeach;?>
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                </div>
                <br>
                <?php if ($action == null || $action !== "Review Form1"):?>
                <div class="form-row">
                    <button class="btn btn-success" name="action" value="Review Form1"
                        type="submit">Review&nbsp;Form</button>
                    <div>
                        <a href="edit_enrollment_index.php" class="btn btn-danger">Clear Form</a>
                    </div>
                </div>
                <?php endif ;?>
            </form>


            <?php if ($action == "Review Form1"):?>
            <form action="edit_enrollment_index.php" class="needs-validation" novalidate method="post">
                <input type="hidden" name="c_fname" value="<?php removeChars ($c_fname);?>">
                <input type="hidden" name="c_lname" value="<?php allowHyphenLastNames ($c_lname);?>">
                <input type="hidden" name="c_dob" value="<?php echo $c_dob;?>">
                <input type="hidden" name="c_id" value="<?php echo $c_id;?>">
                <input type="hidden" name="prog_sec" value="<?php echo $prog_sec;?>">
                <input type="hidden" name="e_num" value="<?php echo $e_num;?>">
                <input type="hidden" name="action" value="<?php echo $action;?>">
                <h4>Update Active Status, Consent Forms, and Transportation</h4>
                <?php foreach($edits as $edit):?>

                <div class='form-row'>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Set Active Status</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='e_status' required>
                                <option <?php if ($edit['e_status'] == true){echo 'value=1';}else{echo 'value=0';}?>>
                                    <?php if ($edit['e_status'] == true){echo "YES";}else{echo "NO";}?>
                                </option>
                                <!-- reverse logic to remove duplicate entry -->
                                <option <?php if ($edit['e_status'] == true){echo 'value=0';}else{echo 'value=1';}?>>
                                    <?php if ($edit['e_status'] == true){echo "NO";}else{echo "YES";}?>
                                </option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">SACM Transport</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='e_consent_sacm_van'
                                required>

                                <option
                                    <?php if ($edit['e_consent_sacm_van'] == true){echo 'value=1';}else{echo 'value=0';}?>>
                                    <?php if ($edit['e_consent_sacm_van'] == true){echo "YES";}else{echo "NO";}?>
                                </option>
                                <!-- reverse logic to remove duplicate entry -->
                                <option
                                    <?php if ($edit['e_consent_sacm_van'] == true){echo 'value=0';}else{echo 'value=1';}?>>
                                    <?php if ($edit['e_consent_sacm_van'] == true){echo "NO";}else{echo "YES";}?>
                                </option>

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
                                <option
                                    <?php if ($edit['e_consent_attend'] == true){echo 'value=1';}else{echo 'value=0';}?>>
                                    <?php if ($edit['e_consent_attend'] == true){echo "YES";}else{echo "NO";}?>
                                </option>
                                <!-- reverse logic to remove duplicate entry -->
                                <option
                                    <?php if ($edit['e_consent_attend'] == true){echo 'value=0';}else{echo 'value=1';}?>>
                                    <?php if ($edit['e_consent_attend'] == true){echo "NO";}else{echo "YES";}?>
                                </option>
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
                                <option
                                    <?php if ($edit['e_consent_to_publish'] == true){echo 'value=1';}else{echo 'value=0';}?>>
                                    <?php if ($edit['e_consent_to_publish'] == true){echo "YES";}else{echo "NO";}?>
                                </option>
                                <!-- reverse logic to remove duplicate entry -->
                                <option
                                    <?php if ($edit['e_consent_to_publish'] == true){echo 'value=0';}else{echo 'value=1';}?>>
                                    <?php if ($edit['e_consent_to_publish'] == true){echo "NO";}else{echo "YES";}?>
                                </option>
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

                                <option
                                    <?php if ($edit['e_consent_sm_phone'] == true){echo 'value=1';}else{echo 'value=0';}?>>
                                    <?php if ($edit['e_consent_sm_phone'] == true){echo "YES";}else{echo "NO";}?>
                                </option>
                                <!-- reverse logic to remove duplicate entry -->
                                <option
                                    <?php if ($edit['e_consent_sm_phone'] == true){echo 'value=0';}else{echo 'value=1';}?>>
                                    <?php if ($edit['e_consent_sm_phone'] == true){echo "NO";}else{echo "YES";}?>
                                </option>

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

                                <option
                                    <?php if ($edit['e_consent_emg_med'] == true){echo 'value=1';}else{echo 'value=0';}?>>
                                    <?php if ($edit['e_consent_emg_med'] == true){echo "YES";}else{echo "NO";}?>
                                </option>
                                <!-- reverse logic to remove duplicate entry -->
                                <option
                                    <?php if ($edit['e_consent_emg_med'] == true){echo 'value=0';}else{echo 'value=1';}?>>
                                    <?php if ($edit['e_consent_emg_med'] == true){echo "NO";}else{echo "YES";}?>
                                </option>

                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Transported to Program</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='trans_type_to' required>
                                <option><?php echo $to;?></option>
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
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Transported from Program</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='trans_type_from' required>
                                <option><?php echo $from;?></option>
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
                <?php endforeach;?>
                <!-- <div id="dividerLine" class="form-row"></div> -->
                <br>
                <div class="form-row">
                    <button class="btn btn-success" name="action" value="Review Form2"
                        type="submit">Review&nbsp;Form</button>
                    <div>
                        <a href="edit_enrollment_index.php" class="btn btn-danger">Clear Form</a>
                    </div>
                </div>

                <?php endif;?>
            </form>
            <br>
        </div>
    </div><!-- class='row' id='main_form'> -->
    <?php endif;?>



    <?php if ($action == "Review Form2" ) :?>
    <div class='row' id='main_form'>
        <div class='col-md-12' id='table_data'>
            <br>
            <form action="edit_enrollment_index.php" class="needs-validation" novalidate method="post">
                <input type="hidden" name="c_fname" value="<?php removeChars ($c_fname);?>">
                <input type="hidden" name="c_lname" value="<?php allowHyphenLastNames ($c_lname);?>">
                <input type="hidden" name="c_dob" value="<?php echo $c_dob;?>">

                <input type="hidden" name="e_num" value="<?php echo $e_num;?>">
                <div class='table-responsive'>
                    <table class='table table-striped table-sm'>
                        <thread>
                            <thead>
                                <tr>
                                    <th colspan="6">
                                        <h4><b>Update Child Enrollment Review Form</b></h4>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Active Status</th>
                                    <th>SACM Transport</th>
                                    <th>Attend Programs</th>
                                    <th>Publication Consent</th>
                                    <th>Contact Child Directly</th>
                                    <th>Medical Treatment</th>

                                </tr>
                                <tr>
                                    <td><?php if ($e_status ==true){echo "YES";}else{echo "NO";} ?>
                                        <input type="hidden" name="e_status" value="<?php echo $e_status; ?>">
                                    </td>
                                    <td><?php if  ($e_consent_sacm_van ==true){echo "YES";}else{echo "NO";} ?>
                                        <input type="hidden" name="e_consent_sacm_van"
                                            value="<?php echo $e_consent_sacm_van; ?>">
                                    </td>
                                    <td><?php if ($e_consent_attend ==true){echo "YES";}else{echo "NO";} ?>
                                        <input type="hidden" name="e_consent_attend"
                                            value="<?php echo $e_consent_attend; ?>">
                                    </td>
                                    <td><?php if ($e_consent_to_publish ==true){echo "YES";}else{echo "NO";} ?>
                                        <input type="hidden" name="e_consent_to_publish"
                                            value="<?php echo $e_consent_to_publish; ?>">
                                    </td>
                                    <td><?php if ($e_consent_sm_phone ==true){echo "YES";}else{echo "NO";} ?>
                                        <input type="hidden" name="e_consent_sm_phone"
                                            value="<?php echo $e_consent_sm_phone; ?>">
                                    </td>
                                    <td><?php if ($e_consent_emg_med ==true){echo "YES";}else{echo "NO";} ?>
                                        <input type="hidden" name="e_consent_emg_med"
                                            value="<?php echo $e_consent_emg_med; ?>">
                                    </td>

                                </tr>
                                <tr>
                                    <th colspan="3">Transportatation to the Army</th>
                                    <th colspan="3">Transportatation from the Army</th>
                                </tr>

                                <tr>
                                    <td colspan="3"><?php echo $trans_type_to; ?>
                                        <input type="hidden" name="trans_type_to" value="<?php echo $trans_type_to; ?>">
                                    </td>
                                    <td colspan="3"><?php echo $trans_type_from; ?>
                                        <input type="hidden" name="trans_type_from"
                                            value="<?php echo $trans_type_from; ?>">
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
                        <a href="edit_enrollment_index.php" class="btn btn-danger">Clear Form</a>
                    </div>
                </div>
            </form>
            <br>
        </div>
    </div>
    <?php endif ;?>
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
</body>

</html>