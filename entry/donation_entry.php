<?php 
include('../inc/func.php');
//test
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
                <!-- error/confirm here -->
                <div><?php if ($errorMSG !== null):?>
                    <a href="#" class="btn btn-danger"><?php echo $errorMSG;?></a>
                    <?php endif;?>
                </div>
                <div><?php if ($confirmMSG !== null):?>
                    <a href="donation_entry_index.php" class="btn btn-success"><?php echo $confirmMSG;?></a>
                    <a href="donation_entry_index.php" class="btn btn-info"><?php echo $linkMSG2;?></a>
                    <?php endif;?>
                </div>
                <?php if ($action !=="Review Form"):?>
                <h4>Donation Entry Form</h4>
                <form action="donation_entry_index.php" class="needs-validation" novalidate method="post">
                    <!-- ROW 1 -->
                    <div class="form-row">
                        <div class="col-sm-4">
                            <label for="validationCustom01">First Name</label>
                            <input type="text" class="form-control" id="validationCustom01" required placeholder="First name"
                                name="p_fname" value="<?php if($p_fname !== null){echo $p_fname; }?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div><?php if ($errorMSG2 !== null):?>
                                <a href="#" class="btn btn-danger"><?php echo $errorMSG2;?></a>
                                <b>OR</b>
                                <a href="person_entry_index.php" class="btn btn-info"><?php echo $linkMSG;?></a>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="validationCustom02">Last name</label>
                            <input type="text" class="form-control" id="validationCustom02"required  placeholder="Last name"
                                name="p_lname" value="<?php if($p_lname !== null){echo $p_lname; }?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div><?php if ($errorMSG3 !== null):?>
                                <a href="#" class="btn btn-danger"><?php echo $errorMSG3;?></a><?php endif;?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Organization</label>
                                <select class="form-control" id="exampleFormControlSelect1" required name="org_id">
                                    <option></option>
                                    <?php foreach ($organizationLists as $organizationList): ?>
                                    <?php if($organizationList['org_id']==$org_id){$selected="selected";}else{$selected="";}?>
                                    <option <?php echo $selected;?> value="<?php echo $organizationList['org_id']; ?>">
                                        <?php echo $organizationList['org_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div><?php if ($errorMSG4 !== null):?>
                                    <a href="#" class="btn btn-danger"><?php echo $errorMSG4;?></a>
                                    <b>OR</b>
                                    <a href="organization_entry_index.php"
                                        class="btn btn-info"><?php echo $linkMSG2;?></a>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-7">
                            <label for="validationCustom03">Donation Description</label>
                            <input type="text" class="form-control" id="validationCustom01" list="type" required
                                placeholder="(best if 1 word for searches) ex. 'cups', 'teaching','repairs' "
                                name='don_desc' value="<?php if($don_desc !== null){echo $don_desc; }?>" />
                            <datalist id="type">
                                <option></option>
                                <?php foreach ($don_descs as $desc):?>
                                <option><?php echo $desc["don_desc"];?></option>
                                <?php endforeach;?>
                            </datalist>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label for="validationCustom03">Type</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='don_type' required>
                                <option></option>
                                <option>Time</option>
                                <option>Item</option>
                                <option>Funds</option>
                                <option>Service</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom01">Choose a Program</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="prog_sec" required>
                                <option></option>
                                <?php foreach($active_sections as $active_section):?>
                                <?php if($active_section['prog_sec']==$prog_sec){$selected="selected";}else{$selected="";}?>
                                <option <?php echo $selected;?> value="<?php echo $active_section['prog_sec'];?>">
                                    <?php echo $active_section['prog_name']." &emsp; ".$active_section['prog_sec_desc'];?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <?php if ($action !== "Submit Form"): ?>
                        <button class="btn btn-success" type="submit" name="action" value="Review Form">Review
                            Form</button>
                        <?php endif;?>
                        <div>
                            <a href="donation_entry_index.php" class="btn btn-danger">Clear Form</a>
                        </div>
                    </div>
                </form>
                <br>
            </div>
        </div>
        <?php endif;?>
        <?php if ($action == "Review Form" && ($person_id > 0|| $org_id > 0)):?>
        <!-- <div class='row' id='main_form'> -->
        <div class='form-row'>
            <div class='col-md-12' id='table_data'>
                <br>
                <form action="donation_entry_index.php" method="post">
                    <div class='table-responsive'>
                        <table class='table table-striped table-sm'>
                            <thread>
                                <thead>
                                    <tr>
                                        <h4>Review Donation Entry Information</h4>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Person Full Name</th>
                                        <th>Donation Type</th>
                                        <th>Donation Description</th>
                                        <th>Organization Name</th>
                                        <th>Program</th>
                                    </tr>
                                    <tr>
                                        <td><?php removeChars( $p_fname); echo " "; allowHyphenLastNames($p_lname); ?>
                                            <input type="hidden" name="p_fname"
                                                value="<?php removeChars( $p_fname); ?>">
                                            <input type="hidden" name="p_lname"
                                                value="<?php allowHyphenLastNames( $p_lname); ?>">
                                            <input type="hidden" name="person_id" value="<?php echo $person_id; ?>">
                                        </td>
                                        <td><?php echo $don_type; ?>
                                            <input type="hidden" name="don_type" value="<?php echo $don_type; ?>">
                                        </td>
                                        <td><?php formatAllergies($don_desc); ?>
                                            <input type="hidden" name="don_desc"
                                                value="<?php formatAllergies($don_desc); ?>">
                                        </td>
                                        <td><?php foreach ($organizationLists as $organizationList)
                                        {if($organizationList['org_id']==$org_id){echo $organizationList['org_name'];}} ?>
                                            <input type="hidden" name="org_id" value="<?php echo $org_id; ?>">
                                        </td>
                                        <td><?php foreach($active_sections as $active_section)
                                        {if($active_section['prog_sec']==$prog_sec){echo $active_section['prog_name']."&emsp;".$active_section['prog_sec_desc'];}} ?>
                                            <input type="hidden" name="prog_sec" value="<?php echo $prog_sec; ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </thread>
                        </table>
                    </div>
                    <div class='form-row'>

                        <button class="btn btn-success" name="action" type="submit" value="Submit Form">Submit
                            Form</button>

                        <div>
                            <a href="donation_entry_index.php" class="btn btn-danger">Clear Form</a>
                        </div>
                    </div>
                </form>
                <br>
            </div>
        </div>
        <?php endif;?>
    </div><!-- class='container-fluid' id='all' -->
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