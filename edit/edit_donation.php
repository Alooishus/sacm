<?php 
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
            <!-- ERROR MSG -->
            <div>
                <?php if ($errorMSG !== null):?>
                <a href="edit_donation_index.php" class="btn btn-danger"><?php echo $errorMSG;?></a>
                <?php endif;?>
            </div>

            <!-- CONFIRM MSG -->
            <div>
                <?php if ($confirmMSG !== null):?>
                <a href="#" class="btn btn-success"><?php echo $confirmMSG;?></a>
                <a href="edit_donation_index.php" class="btn btn-info"><?php echo $linkMSG;?></a>
                <?php endif;?>
            </div>
        </div>

        <div class='col-12'>
            <h4>Edit Donation Form</h4>
            <form action="edit_donation_index.php" class="needs-validation" novalidate method="post">
                <div class='row'>
                    <div class='col-sm-3'>
                        <label for="validationCustom01">Donor's First name</label>
                        <input type="text" class="form-control" name="p_fname" id="validationCustom01"
                            placeholder="First name" value="<?php if(isset($p_fname)){ removeChars ($p_fname);} ?>">
                    </div>
                    <div class='col-sm-3'>
                        <label for="validationCustom01">Donor's Last name</label>
                        <input type="text" class="form-control" name="p_lname" id="validationCustom01"
                            placeholder="Last name"
                            value="<?php if(isset($p_lname)){ allowHyphenLastNames ($p_lname);} ?>">

                    </div>
                    <div class='col-sm-4'>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Organization</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="org_id">
                                <option></option>
                                <?php foreach ($org_list as $org_name): ?>
                                <?php if($org_name['org_id']==$org_id){$selected="selected";}else{$selected="";}?>
                                <option <?php echo $selected;?> value="<?php echo $org_name['org_id']; ?>">
                                    <?php echo $org_name['org_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>

                    </div>
                </div>
                <button class="btn btn-success" type="submit" name="action" value="Search">Search</button>
            </form>
            <?php endif;?>
            <?php if($action == 'Search'):?>
            <div class='col-12'>
                <div class='row' id='main_form'>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Description</th>
                                <th scope="col">Type</th>
                                <th scope="col">Section</th>
                                <th scope="col">Name</th>
                                <th scope="col">Organization</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($p_donations as $p_donation): ?>

                            <tr>
                                <td><?php echo $p_donation['don_date']?></td>
                                <td><?php echo $p_donation['don_desc']?></td>
                                <td><?php echo $p_donation['don_type']?></td>
                                <td><?php echo $p_donation['prog_name']."&emsp;". $p_donation['prog_sec_desc'];?>
                                </td>

                                <td><?php echo $p_donation['p_fname']." ".$p_donation['p_lname'];?></td>
                                <td><?php echo $p_donation['org_name']?></td>


                                <td>
                                    <form action="edit_donation_index.php" method='POST'>
                                        <button type="submit" class="btn btn-info" name="action"
                                            value="edit">Edit</button>
                                        <input type="hidden" value="<?php echo $p_donation['don_date'];?>"
                                            name='don_date2'>
                                        <input type="hidden" value="<?php echo $p_donation['don_desc'];?>"
                                            name='don_desc2'>
                                        <input type="hidden" value="<?php echo $p_donation['don_type'];?>"
                                            name='don_type2'>
                                        <input type="hidden" value="<?php echo $p_donation['prog_sec'];?>"
                                            name='prog_sec2'>
                                        <input type="hidden" value="<?php echo $p_donation['don_id'];?>" name='don_id2'>
                                    </form>
                                </td>
                                <td>
                                    <form action="edit_donation_index.php" method='POST'>
                                        <button type="submit" class="btn btn-danger" name="action"
                                            value="delete">Delete</button>
                                        <input type="hidden" value="<?php echo $p_donation['don_id'];?>" name='don_id2'>
                                    </form>
                                </td>
                            </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <br>
                </div>
            </div>
            <?php endif;?>
            <!--  -->
            <?php if($action == 'edit'): ?>
            <form action="edit_donation_index.php" method='POST'>
                <input type="hidden" value="<?php echo $don_id2;?>" name='don_id3'>
                <div class='row' id='main_form'>
                    <div class='col-12'>
                        <div class="form-row">
                            <div class="col-sm-3">
                                <label for="validationCustom01">Date</label>
                                <input type="date" class="form-control" id="validationCustom01"
                                    value="<?php echo $don_date2;?>" required name='don_date3'>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="validationCustom01">Description</label>
                                <input type="text" class="form-control" id="validationCustom01"
                                    value="<?php echo $don_desc2;?>" required name='don_desc3'>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <label for="validationCustom03">Donation Type</label>
                                <select class="form-control" id="exampleFormControlSelect1" name='don_type3' required>

                                    <option
                                        <?php if($don_type2 == 'Time'){$selected="selected";}else{$selected="";} echo $selected;?>>
                                        Time
                                    </option>
                                    <option
                                        <?php if($don_type2 == 'Item'){$selected="selected";}else{$selected="";} echo $selected;?>>
                                        Item
                                    </option>
                                    <option
                                        <?php if($don_type2 == 'Funds'){$selected="selected";}else{$selected="";} echo $selected;?>>
                                        Funds
                                    </option>
                                    <option
                                        <?php if($don_type2 == 'Service'){$selected="selected";}else{$selected="";} echo $selected;?>>
                                        Service
                                    </option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <label for="validationCustom01">Choose a Program</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="prog_sec3" required>
                                    <option></option>
                                    <?php foreach($active_sections as $active_section):?>
                                    <?php if($active_section['prog_sec']==$prog_sec2){$selected="selected";}else{$selected="";}?>
                                    <option <?php echo $selected;?> value="<?php echo $active_section['prog_sec'];?>">
                                        <?php echo $active_section['prog_name']."&emsp;".$active_section['prog_sec_desc'];?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id='e_dono_buttons'>
                        <button type="submit" class="btn btn-success" name="action" value="submit">Submit</button>
                        <button class="btn btn-danger" type="submit" name="select" value="Clear Form">Start
                            Over</button>
                    </div>
            </form>
        </div>
        <?php endif; ?>




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