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
        <!-- CONFIRM MSG -->
            <div><?php if ($confirmMSG !== null):?>
                <a href="#" class="btn btn-success"><?php echo $confirmMSG;?></a>
               <!--  <a href="edit_person_index.php" class="btn btn-info"><?php echo $linkMSG2;?></a>--><?php endif;?> 
            </div>
            <h4>Edit Program Name</h4>
            <form action="edit_program_index.php" class="needs-validation" novalidate method="post">
                <div class='row'>
                    <div class='col-sm-6'>
                        <label for="validationCustom01">Progam Name to Edit</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="prog_id" required>
                            <option></option>
                            <?php foreach($programs as $program):?>
                            <?php if($program['prog_id']==$prog_id){$selected="selected";}else{$selected="";}?>
                            <option <?php echo $selected;?> value="<?php echo $program['prog_id'];?>">
                                <?php echo $program['prog_name'];?>
                            </option>
                            <?php endforeach;?>
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                </div>
                <br>
                <button class="btn btn-success" type="submit" name="action" value="Search Program">Search
                    Program</button>
            </form>
        </div>
        <!-- end of choosing which to edit -->
        <?php if (isset($action) && (!($action == "Review Form"||$action == "Submit Form")) ):?>
        <div class='row' id='main_form'>
            <div class='col-12'>
                <h4>Update Program Name to:</h4>
                <div><?php if ($errorMSG !== null):?>
                    <a href="#" class="btn btn-danger"><?php echo $errorMSG;?></a>
                    <a href="edit_program_section_index.php" class="btn btn-info"><?php echo $linkMSG;?></a><?php endif;?>
                </div>
                <form action="edit_program_index.php" class="needs-validation" novalidate method="post">
                    <!-- ROW 1 -->
                    <div class="form-row">
                        <div class="col-sm-6">
                            <label for="validationCustom01">Program Name</label>
                            <?php foreach($programs as $program):
                            if ($program['prog_id']==$prog_id):?>
                            <input type="hidden" name="prog_id" value="<?php echo $prog_id;?>" />
                            <input type="text" class="form-control" id="validationCustom01" name="prog_name"
                                placeholder="Program name" value="<?php echo $program['prog_name'];?>" required>
                            <?php endif;?>
                            <?php endforeach;?>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <br/>
                        </div>
                    </div>
                    <div class='form-row'>
                        <button class="btn btn-success" type="submit" name="action" value="Review Program">Review
                            Program</button>
                        <div>
                            <a href="edit_program_index.php" class="btn btn-danger">Clear Form</a>
                        </div>
                    </div>
                </form>
                <br />
                <?php endif;?>
                <?php if (!isset($errorMSG) && $action == "Review Program"):?>
                <div class='form-row'>
                    <br>
                    <div class='col-md-12' id='table_data'>
                        <form action="edit_program_index.php" method="post">
                            <input type="hidden" name="action" value="<?php echo $action;?>" />

                            <div class="form-group">
                                <div class='table-responsive'>
                                    <table class='table table-striped table-sm'>
                                        <thread>
                                            <thead>
                                                <tr>
                                                    <th colspan=2>
                                                        <h4><b>New Program Name Review</b></h4>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php removeChars ($prog_name); ?>
                                                        <input type="hidden" name="prog_name"
                                                            value="<?php removeChars ($prog_name); ?>">
                                                    </td>
                                                    <td><input type="hidden" name="prog_id"
                                                            value="<?php echo $prog_id;?>" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </thread>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn btn-success" type="submit" name="select" value="Submit Form">Submit
                                    Form</button>
                                <div>
                                    <a href="edit_program_index.php" class="btn btn-danger">Clear Form</a>
                                </div>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;?>
    </div>
    <br />
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
</body>
</html>