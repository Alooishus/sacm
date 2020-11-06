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
        <div id="content">
        <div class='col-12'>
            <h4>Volunteer List Search</h4>
<!-- prog -->
            <form action="volunteer_index.php" class="needs-validation" novalidate method="post">
                <div class='row' id='vol_search_row'>
                    <div class='col-sm-10'>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Search by program</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="prog_name">
                                <option></option>
                                <?php foreach ($all_prog_secs as $a): ?>
                                <?php if($a['prog_id']==$prog_name){$selected="selected";}else{$selected="";}?>
                                <option <?php echo $selected;?> value="<?php echo $a['prog_id']; ?>">
                                    <?php echo $a['prog_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!  
                            </div>
                        </div>

                    </div>
                    <div class='col-sm-2' id='vol_search_button'> 
                        <button class="btn btn-success" type="submit" name="action" value="prog">Search</button>
                    </div>
                </div>
            </form>
<!-- org_prog -->
            <div id='right_vol'>
                <form action="volunteer_index.php" class="needs-validation" novalidate method="post">
                    <div class='row' id='vol_search_row'>
                        <div class='col-sm-10'>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Search by organization</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="org_name">
                                    <option></option>
                                    <?php foreach ($org_list as $o): ?>
                                    <?php if($o['org_id']==$org_name){$selected="selected";}else{$selected="";}?>
                                    <option <?php echo $selected;?> value="<?php echo $o['org_id']; ?>">
                                        <?php echo $o['org_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="exampleFormControlSelect1">Associated with a program</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="prog_name">
                                    <option></option>
                                    <?php foreach ($all_prog_secs as $a): ?>
                                    <?php if($a['prog_id']==$prog_name){$selected="selected";}else{$selected="";}?>
                                    <option <?php echo $selected;?> value="<?php echo $a['prog_id']; ?>">
                                        <?php echo $a['prog_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!  
                                </div>
                            </div>
                        </div>
                        <div class='col-sm-2' id='vol_dbl_search'>
                            <button class="btn btn-success" type="submit" name="action" value="org_prog">Search</button>
                        </div>
                    </div>
                </form>
            
<!-- day -->
            <form action="volunteer_index.php" class="needs-validation" novalidate method="post">
                <div class='row' id='vol_search_row'>
                    <div class='col-sm-10'>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Search by day</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="day">
                                <option></option>
                                <?php foreach ($days as $d): ?>
                                <?php if($d['prog_day']==$prog_day){$selected="selected";}else{$selected="";}?>
                                <option <?php echo $selected;?> value="<?php echo $d['prog_day']; ?>">
                                    <?php echo $d['prog_day']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!  
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-2' id='vol_search_button'>
                        <button class="btn btn-success" type="submit" name="action" value="day">Search</button>
                    </div>
                </div>
                
            </form>
        </div>
<!-- person -->
            <form action="volunteer_index.php" class="needs-validation" novalidate method="post">
                <div class='row' id='vol_search_row'>
                    <div class='col-sm-10'>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Search by person</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="person">
                                <option></option>
                                <?php foreach ($volunteers as $v): ?>
                                <?php if($v['person_id']==$person){$selected="selected";}else{$selected="";}?>
                                <option <?php echo $selected;?> value="<?php echo $v['person_id']; ?>">
                                    <?php echo $v['p_fname']." ".$v['p_lname']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!  
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-2' id='vol_search_button'>
                        <button class="btn btn-success" type="submit" name="action" value="person">Search</button>
                    </div>
                </div>
                
            </form>
<!-- org -->
            <form action="volunteer_index.php" class="needs-validation" novalidate method="post">
                <div class='row' id='vol_search_row'>
                    <div class='col-sm-10'>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Search by organization</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="org_name">
                                <option></option>
                                <?php foreach ($org_list as $o): ?>
                                <?php if($o['org_id']==$org_name){$selected="selected";}else{$selected="";}?>
                                <option <?php echo $selected;?> value="<?php echo $o['org_id']; ?>">
                                    <?php echo $o['org_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!  
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-2' id='vol_search_button'>
                        <button class="btn btn-success" type="submit" name="action" value="org">Search</button>
                    </div>
                </div>
                <div id="vol_bottom_buttons">
                    <button class="btn btn-success" type="submit" name="action" value="all">Show All Registered Volunteers</button>
                    <button class="btn btn-warning" type="button" id="hide" value="hide">Hide Search Bars</button>
                    <a href="reports.php"><button type="button" class="btn btn-primary">Back to Reports</button></a>
                </div>
            </form>
        </div>
        
    </div>
    
        <?php if($action == 'all'): ?>
            <?php include('volunteer_all.php'); ?>
        <?php endif; ?>                    
        
        <?php if($action == 'prog' && $prog_name != ""): ?>
            <?php include('volunteer_prog.php'); ?>
        <?php endif; ?>

        <?php if($action == 'org_prog' && $prog_name != "" && $org_name != ""): ?>
            <?php include('volunteer_org_prog.php'); ?>
        <?php endif; ?>

        <?php if($action == 'day' && $prog_day != ""): ?>
            <?php include('volunteer_day.php'); ?>
        <?php endif; ?>

        <?php if($action == 'person' && $person != ""): ?>
            <?php include('volunteer_person.php'); ?>
        <?php endif; ?>
        <?php if($action == 'org' && $org_name != ""): ?>
            <?php include('volunteer_org.php'); ?>
        <?php endif; ?>


    </div>

            <script>
                jQuery(document).ready(function(){
                    jQuery('#hide').on('click', function(event) {        
                        jQuery('#content').hide('fast');
                    });
                });
            </script>

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