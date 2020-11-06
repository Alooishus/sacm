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
                
                <?php if (!isset($action) || $action == "Submit Form" || $action !== "Review Form" || $organization_count>0):?>
                <h4>Organization Entry Form</h4>
                <!-- error message and link -->
                <div><?php if ($errorMSG !== null):?>
                    <a href="#" class="btn btn-danger"><?php echo $errorMSG;?></a>
                    <a href="../edit/edit_organization_index.php"
                        class="btn btn-info"><?php echo $linkMSG;?></a><?php endif;?>
                </div>
                <!-- confirm message and link -->
                <div><?php if ($confirmMSG !== null):?>
                    <a href="#" class="btn btn-success"><?php echo $confirmMSG;?></a>
                    <a href="organization_entry_index.php"
                        class="btn btn-info"><?php echo $linkMSG2;?></a><?php endif;?>
                </div>
                <form action="organization_entry_index.php" class="needs-validation" novalidate method="post">
                    <!-- ROW 1 -->
                    <div class="form-row">
                    </div>
                    <div class="form-row">
                        <div class="col-sm-4">
                            <label for="validationCustom03">Organization Name</label>
                            <input type="text" class="form-control" id="validationCustom03"
                                placeholder="Organization Name" name="org_name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom01">Phone Number</label>
                            <input type="tel" id="phone" name="org_phone" class="form-control" id="validationCustom01"
                                placeholder="ex. 555-555-5555" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <label for="validationCustom01">Description</label>
                            <input type="text" class="form-control" id="validationCustom01"
                                placeholder="Organization Description" name="org_desc" required>
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
                                name="org_st_address" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label for="validationCustom01">City</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="City"
                                name="org_city" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">State</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="org_state" required>
                                    <option></option>
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
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label for="validationCustom01">Zip</label>
                            <input type="text" name="org_zipcode" pattern="[0-9]{5}" class="form-control"
                                id="validationCustom01" placeholder="Zip" required />
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="validationCustom01">Email</label>
                            <input type="email" class="form-control" id="validationCustom01" placeholder="Email Address"
                                name="org_email" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <button class="btn btn-success" type="submit" value="Review Form" name="action">Review
                            Form</button>
                        <div>
                            <a href="organization_entry_index.php" class="btn btn-danger">Clear Form</a>
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
    <?php if ($action == "Review Form" && $organization_count==0):?>

    <div class='form-row'>
        <br>
        <div class='col-md-12' id='table_data'>
            <h4>Review Organization Information</h4>
            <form action="organization_entry_index.php" method="post">
                <div class='table-responsive'>
                    <table class='table table-striped table-sm'>
                        <thread>
                            <thead>
                                <tr>
                                    <th colspan="5"><b>Organization's Information</b> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Organization Name</th>
                                    <th>Primary Phone Number</th>
                                    <th>Organization Description</th>
                                    <th>Organization Email</th>

                                </tr>
                                <tr>
                                    <td><?php removeChars($org_name); ?>
                                        <input type="hidden" name="org_name" value="<?php removeChars($org_name); ?>">
                                    </td>
                                    <td><?php echo $org_phone; ?>
                                        <input type="hidden" name="org_phone" value="<?php echo $org_phone; ?>">
                                    </td>
                                    <td><?php removeChars( $org_desc); ?>
                                        <input type="hidden" name="org_desc" value="<?php removeChars( $org_desc); ?>">
                                    </td>
                                    <td><?php echo $org_email; ?>
                                        <input type="hidden" name="org_email" value="<?php echo $org_email; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Street Address</th>
                                    <th>City </th>
                                    <th>State</th>
                                    <th>Zip</th>
                                </tr>
                                <tr>
                                    <td><?php  formatAddress($org_st_address); ?>
                                        <input type="hidden" name="org_st_address"
                                            value="<?php  formatAddress($org_st_address); ?>">
                                    </td>
                                    <td><?php removeChars( $org_city); echo ", ".$org_state; ?>
                                        <input type="hidden" name="org_city" value="<?php removeChars( $org_city); ?>">
                                    </td>
                                    <td><?php  removeChars( $org_state); ?>
                                        <input type="hidden" name="org_state" value="<?php echo $org_state; ?>">
                                    </td>

                                    <td><?php echo $org_zipcode; ?>
                                        <input type="hidden" name="org_zipcode" value="<?php echo $org_zipcode; ?>">
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
                        <a href="organization_entry_index.php" class="btn btn-danger">Clear Form</a>
                    </div>
                </div>
            </form>
            <br>
        </div>
    </div>
    <?php endif;?>
    <br>
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