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
            <form action="edit_program_section_index.php" class="needs-validation" novalidate method="post">
                <div class='row'>
                    <div class='col-sm-6'>
                        <div><?php if ($confirmMSG !== null):?>
                            <a href="#" class="btn btn-success"><?php echo $confirmMSG;?></a>
                            <a href="edit_program_section_index.php"
                                class="btn btn-info"><?php echo $linkMSG;?></a><?php endif;?>
                        </div>
                        <div><?php if ($errorMSG !== null):?>
                            <a href="#" class="btn btn-danger"><?php echo $errorMSG;?></a>
                            <a href="edit_program_section_index.php"
                                class="btn btn-info"><?php echo $linkMSG4;?></a><?php endif;?>
                        </div>
                        <div><?php if ($confirmMSG2 !== null):?>
                            <a href="#" class="btn btn-success"><?php echo $confirmMSG2;?></a>
                            <a href="edit_program_section_index.php"
                                class="btn btn-info"><?php echo $linkMSG2;?></a><?php endif;?>
                        </div>
                        <h4>Edit Program Section Form</h4>
                        <?php $prog_sec_list = get_prog_sec_list(); ?>
                        <label for="validationCustom01">Choose from active Program Sections to Edit</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="prog_sec" required>
                            <option></option>
                            <?php foreach($prog_sec_list as $program_section):?>
                            <option value="<?php echo $program_section['prog_sec'];?>">
                                <?php echo $program_section['prog_name']." - ".$program_section['prog_age_range']." - ".$program_section['prog_day']." - ".$program_section['prog_time']." - ".$program_section['prog_sec_desc'];
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
                <?php if (!($action == "Submit Form" || $action == "Change Active Status")):?>
                <button class="btn btn-success" type="submit" name="action" value="Search Section">Search
                    Section</button>
                <?php if ($action !== "Search Section" && $action !== "Review Form" ):?>
                <button class="btn btn-warning" type="submit" name="select" value="Deactivate Section">Deactivate
                    Section</button>
                <?php endif;?>
                <?php endif;?>
            </form>
        </div>
        <!-- end of choosing which to edit -->
        <?php if(isset($prog_sec)):?>
        <?php if( $action == "Search Section"):?>
        <div class='row' id='main_form'>
            <div class='col-12'>
                <div class='col-12'>
                    <?php foreach($program_sections as $program_section):
                    if ($program_section['prog_sec']==$prog_sec):?>
                    <h4>Editing Program Section:</h4>
                    <h3>&nbsp;<b><?php echo $program_section['prog_name']."&emsp;".$program_section['prog_sec_desc']."&emsp;".$program_section['prog_age_range']."&emsp;".$program_section['prog_day']." @ ".$program_section['prog_time']."&emsp;".$program_section['prog_room']." &emsp;seat cap= ".$program_section['prog_seat_cap'];?></b>
                    </h3>
                    <form action="edit_program_section_index.php" class="needs-validation" novalidate method="post">
                        <input type="hidden" name="prog_name" value="<?php echo $program_section['prog_name'];?>">
                        <input type="hidden" name="prog_id" value="<?php echo $program_section['prog_id'];?>">
                        <input type="hidden" name="prog_sec" value="<?php echo $program_section['prog_sec'];?>">
                        <!-- ROW 1 -->
                        <div class="form-row">
                            <div class="col-sm-4">
                                <label for="validationCustom01">School Year ("YYYY/YYYY")
                                </label>
                                <input type="text" class="form-control" id="validationCustom01" placeholder="YYYY/YYYY"
                                    name="prog_sec_desc" pattern="[0-9]{4}/[0-9]{4}"
                                    value="<?php echo $program_section['prog_sec_desc'];?>" required />
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Day</label>
                                    <select class="form-control" id="exampleFormControlSelect1" value="" name="prog_day"
                                        required>
                                        <option><?php echo $program_section['prog_day'];?></option>
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
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Transport Available</label>
                                    <select class="form-control" id="exampleFormControlSelect1"
                                        name='prog_van_trans_avail'>
                                        <option
                                            <?php if ($program_section['prog_van_trans_avail'] ==1){echo "value=1";}else{echo "value=0";}?>>
                                            <?php if ($program_section['prog_van_trans_avail'] ==1){echo "YES";}else{echo "NO";}?>
                                        </option>
                                        <!-- reverse logic to remove duplicate entry -->
                                        <option
                                            <?php if ($program_section['prog_van_trans_avail'] ==1){echo "value=0";}else{echo "value=1";}?>>
                                            <?php if ($program_section['prog_van_trans_avail'] ==1){echo "NO";}else{echo "YES";}?>
                                        </option>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <label for="validationCustom02">Capacity</label>
                                <input type="number" class="form-control" id="validationCustom02" placeholder="Seat Cap"
                                    min='0' value="<?php echo $program_section['prog_seat_cap'];?>"
                                    name="prog_seat_cap">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="validationCustom03">Room</label>
                                <div class="form-group">
                                    <?php $jq_prog_room = $program_section['prog_room']; ?>
                                    <input type="text" class="form-control datalistfix" id="validationCustom01"
                                        list="programRooms" name="prog_room"
                                        value="<?php echo $program_section['prog_room'];?>" required
                                        placeholder="<?php echo $program_section['prog_room'];?>" />
                                    <datalist id="programRooms">
                                        <option></option>
                                        <?php foreach ($prog_Rooms as $prog_Room):?>
                                        <option><?php echo $prog_Room['prog_room'];?></option>
                                        <?php endforeach;?>
                                    </datalist>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW 1 -->
                        <div class="form-row">
                            <div class="col-sm-2">
                                <label for="validationCustom03">Lowest Grade</label>
                                <div class="form-group">
                                    <select class="form-control" id="exampleFormControlSelect1"
                                        name="low_prog_age_range" required>
                                        <option>
                                            <?php echo substr($program_section['prog_age_range'], 0, strrpos($program_section['prog_age_range'],"-"));?>
                                        </option>
                                        <option>All</option>
                                        <option>Below</option>
                                        <option>School</option>
                                        <option>Youth</option>
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
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <label for="validationCustom03">Highest Grade</label>
                                <div class="form-group">
                                    <select class="form-control" id="exampleFormControlSelect1"
                                        name="high_prog_age_range" required>
                                        <option>
                                            <?php echo ltrim(strstr($program_section['prog_age_range'], '-'), '-');?>
                                        </option>
                                        <option>Ages</option>
                                        <option>Nursery</option>
                                        <option>Youth</option>
                                        <option>and Up</option>
                                        <option>and Below</option>
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
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <label for="validationCustom03">Program Time</label>
                                <div class="form-group">
                                    <select class="form-control" id="exampleFormControlSelect1" name="prog_time_spot"
                                        required>
                                        <option>
                                            <?php echo substr($program_section['prog_time'], 0, strrpos($program_section['prog_time']," "));?>
                                        </option>
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
                                    <?php $data = ltrim(strstr($program_section['prog_time'], ' '), ' ');?>

                                    <select class="form-control" id="exampleFormControlSelect1" name="am_pm" required>
                                        <option><?php echo $data;?></option>
                                        <option><?php if ( $data =='PM'){echo "AM";}else{echo "PM";}?></option>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <!-- editing to get teacher list and printed out -->
                            <div class="col-sm-5">
                                <label for="validationCustom03">Program Section Leader</label>
                                <div class="form-group">
                                    <select class="form-control" id="exampleFormControlSelect1" name="person_id"
                                        required>
                                        <?php foreach ($teacherDetails as $teacherDetail):?>
                                        <option value="<?php echo $teacherDetail['person_id'];?>">
                                            <?php echo $teacherDetail['p_fname']." ". $teacherDetail['p_lname'];?>
                                        </option>
                                        <?php endforeach;?>
                                        <?php foreach($teachers as $teacher):?>
                                        <option value="<?php echo $teacher['person_id'];?>">
                                            <?php echo $teacher['p_fname']." ". $teacher['p_lname'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <!-- ROW 3 -->
                            <button class="btn btn-success" type="submit" name="action" value="Review Form">Review
                                Form</button>
                            <div>
                                <a href="edit_program_section_index.php" class="btn btn-danger">Clear Form</a>
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
                <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>
        <?php endif;?>
        <?php if ($action == "Review Form" && !isset($errorMSG) ):?>
        <div class='row' id='main_form'>
            <div id="error">
                <?php if(isset($countProgramSection)&&isset($errorMSG)){echo $errorMSG;}?>
            </div>
            <div class='col-md-12' id='table_data'>
                <form action="edit_program_section_index.php" method="post">
                    <input type="hidden" name="prog_sec" value="<?php echo $prog_sec;?>">
                    <br>
                    <div class='table-responsive'>
                        <table class='table table-striped table-sm'>
                            <thread>
                                <tr>
                                    <th colspan=5>
                                        <h4><b>Program Section To Edit</b></h4>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Program Name</th>
                                    <th>Section School Year</th>
                                    <th>Program Day</th>
                                    <th>Age Range</th>
                                    <th>Program Time</th>
                                </tr>
                                <tr>
                                    <td><?php echo $prog_name; ?>
                                        <input type="hidden" name="prog_sec" value="<?php echo $prog_sec; ?>">
                                    </td>
                                    <td><?php echo $prog_sec_desc; ?>
                                        <input type="hidden" name="prog_sec_desc" value="<?php echo $prog_sec_desc; ?>">
                                    </td>
                                    <td><?php echo $prog_day; ?>
                                        <input type="hidden" name="prog_day" value="<?php echo $prog_day; ?>">
                                    </td>
                                    <td><?php echo $prog_age_range; ?>
                                        <input type="hidden" name="prog_age_range"
                                            value="<?php echo "$prog_age_range";?>">
                                    </td>
                                    <td><?php echo $prog_time; ?>
                                        <input type="hidden" name="prog_time" value="<?php echo $prog_time; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Seat Capacity</th>
                                    <th>Transport Available</th>
                                    <th>Room</th>
                                    <th>Section Teacher</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td><?php echo $prog_seat_cap; ?>
                                        <input type="hidden" name="prog_seat_cap" value="<?php echo $prog_seat_cap; ?>">
                                    </td>
                                    <td><?php if ($prog_van_trans_avail == 1){echo "YES";}else{echo "NO";} ?>
                                        <input type="hidden" name="prog_van_trans_avail"
                                            value="<?php echo $prog_van_trans_avail; ?>">
                                    </td>
                                    <td><?php removeChars($prog_room); ?>
                                        <input type="hidden" name="prog_room"
                                            value="<?php echo removeChars($prog_room); ?>">
                                    </td>
                                    <td><?php echo $teacherName;?>
                                        <input type="hidden" name="person_id" value="<?php echo $person_id;?>">
                                    </td>
                                    <td></td>
                                </tr>
                            </thread>
                        </table>
                    </div>
                    <div class='form-row'>
                        <button class="btn btn-success" type="submit" name="action" value="Submit Form">Submit
                            Form</button>
                        <div>
                            <a href="edit_program_section_index.php" class="btn btn-danger">Clear Form</a>
                        </div>
                    </div>
                    <br>
                </form>
            </div>
            <br>
        </div>
        <?php endif;?>
    </div>
    <!-- FROM HERE -->
    <?php if($select == "Deactivate Section"&& $action !== "Change Active Status"):?>
    <!-- <div class='form-row'> -->
    <div class='row' id='main_form'>
        <div class='col-md-12' id='table_data'>
            <form action="edit_program_section_index.php" method="post">
                <br>
                <div class='table-responsive'>
                    <input type="hidden" name="prog_sec" value="<?php echo $prog_sec;?>">
                    <input type="hidden" name="select" value="<?php echo $select;?>">
                    <table class='table table-striped table-sm'>
                        <thread>
                            <tr>
                                <th colspan=5>
                                    <h3><b>To Confirm Deactivation of Program Section: Choose "INACTIVE"
                                            in the dropdown list</b></h3>
                                            <p><b>CAUTION:</b>  Please make sure that all donations and volunteer efforts for this section have been recorded before DEACTIVATING the section.</p>  <p>Setting this section to INACTIVE <u>cannot</u> be reversed.</p>    
                                </th>
                            </tr>
                            <tr>
                                <th>Active Status</th>
                                <th>Program Name</th>
                                <th>Program Section School Year</th>
                                <th>Program Day</th>
                                <th>Age Range</th>
                                
                            </tr>
                            <?php foreach($deactivate_sections as $deactivate_section):?>
                            <?php if ($deactivate_section['prog_sec'] == $prog_sec):?>
                            <tr>
                                <td><select class="form-control" id="exampleFormControlSelect1" name='prog_sec_active'
                                        required>
                                        <option
                                            <?php if ($deactivate_section['prog_sec_active'] ==1){echo 'value=1';}else {echo 'value=0';}?>>
                                            <?php if ($deactivate_section['prog_sec_active'] ==1){echo "ACTIVE";}else{echo "INACTIVE";}?>
                                        </option>
                                        <!-- reverse logic to remove duplicate entry -->
                                        <option
                                            <?php if ($deactivate_section['prog_sec_active'] ==1){echo 'value=0';}else {echo 'value=1';}?>>
                                            <?php if ($deactivate_section['prog_sec_active'] ==1){echo "INACTIVE";}else{echo "ACTIVE";}?>
                                        </option>
                                    </select>
                                    <?php endif;?>
                                    <?php endforeach;?>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </td>
                                
                                <td><?php echo $deactivate_section['prog_name']; ?>
                                    <input type="hidden" name="prog_sec" value="<?php echo $prog_sec; ?>">
                                </td>
                                <td><?php echo $deactivate_section['prog_sec_desc']; ?></td>
                                <td><?php echo $deactivate_section['prog_day']; ?></td>
                                <td><?php echo $deactivate_section['prog_age_range']; ?></td>
                            </tr>
                        </thread>
                    </table>
                </div>
                <div class='form-row'>
                    <button class="btn btn-warning" type="submit" name="action"
                        value="Change Active Status">Confirm&nbsp;<b>Status</b></button>
                    <div>
                        <a href="edit_program_section_index.php" class="btn btn-danger">Clear Form</a>
                    </div>
                </div>
            </form>
            <br>
        </div>
    </div>
    <?php endif;?>
    <?php endif;?>
    <br />
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