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
                <?php if (($action != "Review Form" || $countProgramName > 0 ) && !isset($select)):?>
                <h4>New Program Form</h4>
                <div><?php if ($errorMSG !== null):?>
                    <a href="#" class="btn btn-danger"><?php echo $errorMSG;?></a><?php endif;?>
                </div>
                <div><?php if ($confirmMSG !== null):?>
                    <a href="#" class="btn btn-success"><?php echo $confirmMSG;?></a>
                    <a href="program_entry_index.php" class="btn btn-info"><?php echo $linkMSG2;?></a><?php endif;?>
                </div>

                <form class="needs-validation" action="program_entry_index.php" method="post" novalidate>
                    <!-- ROW 1 -->
                    <div class="form-row">
                        <div class="col-sm-6">
                            <label for="validationCustom01">Program Name</label>
                            <input type="text" class="form-control" id="validationCustom01" maxlength='30'
                                placeholder="i.e. Leaders in Traning" name="prog_name" value="" required='required'>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <button class="btn btn-success" type="submit" name="action" value="Review Form">Review
                            Form</button>
                        <div>
                            <a href="program_entry_index.php" class="btn btn-danger">Clear Form</a>
                        </div>
                    </div>
                </form>
                <?php endif;?>
                <?php if ($action !== null && (!$countProgramName>0) && $action !== "Submit Form" ):?>
                <div class='form-row'>
                    <br>
                </div>
                <form action="program_entry_index.php" method="post">
                    <div class='form-row'>
                        <br>
                        <div class='col-md-12' id='table_data'>
                            <div class='table-responsive'>
                                <table class='table table-striped table-sm'>
                                    <thread>
                                        <thead>
                                            <tr>
                                                <th>
                                                    <h4><b>New Program Name Review</b></h4>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php allowHyphenLastNames($prog_name); ?>
                                                    <input type="hidden" name="prog_name"
                                                        value="<?php allowHyphenLastNames($prog_name); ?>">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </thread>
                                </table>
                            </div>
                        </div>

                        <button class="btn btn-success" name="action" type="submit" value="Submit Form">Submit
                            Form</button>
                        <div>
                            <a href="program_entry_index.php" class="btn btn-danger">Clear Form</a>
                        </div>
                    </div>
                </form>
                <?php endif;?>
                <br />


                <?php if ($action == null   ):?>
                <?php if ($select !== "Review Form"):?>

                <div id="dividerLine" class="form-row"></div>
                <h4>New Program Section Form</h4>
                <div><?php if ($errorMSG2 !== null):?>
                    <a href="#" class="btn btn-danger"><?php echo $errorMSG2;?></a>
                    <a href="../edit/edit_program_section_index.php"
                        class="btn btn-info"><?php echo $linkMSG;?></a><?php endif;?>
                </div>
                <div><?php if ($confirmMSG3 !== null):?>
                    <a href="#" class="btn btn-success"><?php echo $confirmMSG3;?></a>
                    <a href="program_entry_index.php" class="btn btn-info"><?php echo $linkMSG3;?></a><?php endif;?>
                </div>
                <form class="needs-validation" action="program_entry_index.php" method="post" novalidate>
                    <!-- ROW 1 -->
                    <div class="form-row">
                        <div class="col-sm-4">
                            <label for="validationCustom01">Choose a Program</label>
                            <!-- need logic for dynamic dropdown list of active sections -->
                            <select class="form-control" id="exampleFormControlSelect1" name="prog_id" required>
                                <option></option>
                                <?php foreach($programs as $program):?>
                                <option value="<?php echo $program['prog_id'];?>">
                                    <?php safeEcho($program['prog_name']);?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom03">School Year (enter: "YYYY/YYYY")</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="YYYY/YYYY" id="validationCustom01"
                                    list="programDesc" name="prog_sec_desc" pattern="[0-9]{4}/[0-9]{4}" required />
                                <datalist id="programDesc">
                                    <option></option>
                                    <?php foreach($prog_sec_Descs as $prog_sec_Desc):?>
                                    <option><?php safeEcho($prog_sec_Desc['prog_sec_desc']);?>
                                        <?php endforeach;?>
                                </datalist>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Day</label>
                                <select class="form-control" id="exampleFormControlSelect1" value="" name="prog_day"
                                    required>
                                    <option></option>
                                    <option>Sunday</option>
                                    <option>Monday</option>
                                    <option>Tuesday</option>
                                    <option>Wednesday</option>
                                    <option>Thursday</option>
                                    <option>Friday</option>
                                    <option>Saturday</option>
                                    <option>Special Event</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom01">Choose a Leader</label>
                            <!-- need logic for dynamic dropdown list of active sections -->
                            <select class="form-control" id="exampleFormControlSelect1" name="person_id" required>
                                <option></option>
                                <?php foreach($teachers_staffs as $teachers_staff):?>
                                <option value="<?php echo $teachers_staff['person_id'];?>">
                                    <?php echo $teachers_staff['p_fname']." ".$teachers_staff['p_lname'];?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <!-- ROW 1 -->
                    <div class="form-row">
                        <div class="col-sm-2">
                            <label for="validationCustom03">Lowest Grade</label>
                            <div class="form-group">
                                <select class="form-control" id="exampleFormControlSelect1" name="low_prog_age_range"
                                    required>
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
                                    <option>Below</option>
                                    <option>All</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label for="validationCustom03">Highest Grade</label>
                            <div class="form-group">
                                <select class="form-control" id="exampleFormControlSelect1" name="high_prog_age_range"
                                    required>
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
                                    <option>and Up</option>
                                    <option>Ages</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <label for="validationCustom02">Capacity</label>
                            <input type="number" class="form-control" id="validationCustom02" placeholder="Seat Cap"
                                min='0' value="" name="prog_seat_cap">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Transport Available</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="prog_van_trans_avail"
                                    required>
                                    <option></option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom03">Room</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="validationCustom01" list="programRooms"
                                    name="prog_room" required />
                                <datalist id="programRooms">
                                    <option></option>
                                    <?php foreach ($prog_Rooms as $prog_Room):?>
                                    <option><?php safeEcho($prog_Room['prog_room']);?></option>
                                    <?php endforeach;?>
                                </datalist>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <label for="validationCustom03">Time</label>
                            <div class="form-group">
                                <select class="form-control" id="exampleFormControlSelect1" name="prog_time_spot"
                                    required>
                                    <option></option>
                                    <option>1:00</option>
                                    <option>1:15</option>
                                    <option>1:30</option>
                                    <option>1:45</option>
                                    <option>2:00</option>
                                    <option>2:15</option>
                                    <option>2:30</option>
                                    <option>2:45</option>
                                    <option>3:00</option>
                                    <option>3:15</option>
                                    <option>3:30</option>
                                    <option>3:45</option>
                                    <option>4:00</option>
                                    <option>4:15</option>
                                    <option>4:30</option>
                                    <option>4:45</option>
                                    <option>5:00</option>
                                    <option>5:15</option>
                                    <option>5:30</option>
                                    <option>5:45</option>
                                    <option>6:00</option>
                                    <option>6:15</option>
                                    <option>6:30</option>
                                    <option>6:45</option>
                                    <option>7:00</option>
                                    <option>7:15</option>
                                    <option>7:30</option>
                                    <option>7:45</option>
                                    <option>8:00</option>
                                    <option>8:15</option>
                                    <option>8:30</option>
                                    <option>8:45</option>
                                    <option>9:00</option>
                                    <option>9:15</option>
                                    <option>9:30</option>
                                    <option>9:45</option>
                                    <option>10:00</option>
                                    <option>10:15</option>
                                    <option>10:30</option>
                                    <option>10:45</option>
                                    <option>11:00</option>
                                    <option>11:15</option>
                                    <option>11:30</option>
                                    <option>11:45</option>
                                    <option>12:00</option>
                                    <option>12:15</option>
                                    <option>12:30</option>
                                    <option>12:45</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <label for="validationCustom03">AM/PM</label>
                            <div class="form-group">
                                <select class="form-control" id="exampleFormControlSelect1" name="am_pm"
                                    required='required'>
                                    <option></option>
                                    <option>AM</option>
                                    <option>PM</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ROW 3 -->
                    <div class="form-row">
                        <button class="btn btn-success" type="submit" name="select" value="Review Form">Review
                            Form</button>
                        <div>
                            <a href="program_entry_index.php" class="btn btn-danger">Clear Form</a>
                        </div>
                    </div>
                </form>

                <?php endif;?>

                <!-- submit form -->
                <?php if ($select !== "Submit Form" && $select !== null && (!(isset($errorMSG2) && (!(isset($$confirmMSG3)))))):?>
                <form action="program_entry_index.php" method="post">
                    <div class='form-row'>
                        <br>
                        <div class='col-md-12' id='table_data'>
                            <div class='table-responsive'>
                                <table class='table table-striped table-sm'>
                                    <thread>
                                        <thead>
                                            <tr>
                                                <th colspan=5>
                                                    <h4><b>Program Section Review</b></h4>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Program Name</th>
                                                <th>Program Section (School Year)</th>
                                                <th>Program Day</th>
                                                <th>Age Range</th>
                                                <th>Room</th>
                                            </tr>
                                            <tr>
                                                <td><?php echo allowHyphenLastNames($prog_name); ?>
                                                    <input type="hidden" name="prog_id" value="<?php echo $prog_id; ?>">
                                                </td>
                                                <td><?php echo $prog_sec_desc; ?>
                                                    <input type="hidden" name="prog_sec_desc"
                                                        value="<?php safeEcho($prog_sec_desc); ?>">
                                                </td>
                                                <td><?php echo $prog_day; ?>
                                                    <input type="hidden" name="prog_day"
                                                        value="<?php safeEcho($prog_day); ?>">
                                                </td>
                                                <td>
                                                    <?php echo $prog_age_range; ?>
                                                    <input type="hidden" name="prog_age_range"
                                                        value="<?php safeEcho("$prog_age_range");?>">
                                                </td>
                                                <td><?php allowHyphenLastNames($prog_room); ?>
                                                    <input type="hidden" name="prog_room"
                                                        value="<?php allowHyphenLastNames($prog_room); ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Seat Capacity</th>
                                                <th>Transport Available</th>
                                                <th>Program Time</th>
                                                <th>Teacher</th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <td><?php echo $prog_seat_cap; ?>
                                                    <input type="hidden" name="prog_seat_cap"
                                                        value="<?php echo $prog_seat_cap; ?>">
                                                </td>
                                                <td><?php echo $prog_van_trans_avail; ?>
                                                    <input type="hidden" name="prog_van_trans_avail"
                                                        value="<?php echo $prog_van_trans_avail; ?>">
                                                </td>
                                                <td><?php echo $prog_time; ?>
                                                    <input type="hidden" name="prog_time"
                                                        value="<?php echo $prog_time; ?>">
                                                </td>
                                                <td><?php foreach($teachers_staffs as $teachers_staff):?>
                                                    <?php if ($teachers_staff['person_id'] == $person_id){echo $teachers_staff['p_fname']." ".$teachers_staff['p_lname'];} endforeach;?>
                                                    <input type="hidden" name="person_id"
                                                        value="<?php echo $person_id; ?>">
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </thread>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <button class="btn btn-success" type="submit" name="select" value="Submit Form">Submit
                            Form</button>
                        <div>
                            <a href="program_entry_index.php" class="btn btn-danger">Clear Form</a>
                        </div>
                    </div>
                </form>
                <?php endif;?>
                <?php endif;?>
                <br />
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
</body>

</html>