<?php 
include('../inc/db_connect.php');
include('../inc/func.php');

$nav_click = filter_input(INPUT_GET,'nav_click');




$active_prog_secs = get_active_prog_names();


?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="../scripts/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">

    <title>SACM</title>
</head>
<body>

<div class='container-fluid' id='all'>
<!-- NAV BAR -->
<?php echo navbar($nav_click); ?>
</div>

<div class='container-fluid' id='reports_all'>
            <div class="btn-group" role="group" aria-label="Basic example">
                
                <div class='row' id='report_buttons1'>
                    
                    <div class="col"><a href="master_list.php"><button type="button" class="btn btn-primary">Master</button></a></div>
                    <div class="col"><a href="master_not_enrolled.php"><button type="button" class="btn btn-primary">Not Enrolled</button></a></div>
                    <div class="col"><a href="allergy.php"><button type="button" class="btn btn-primary">Allergy List</button></a></div>
                    <div class="col"><a href="donations_index.php"><button type="button" class="btn btn-primary">Donor Contact List</button></a></div>
                    <div class="col"><a href="registration_special.php"><button type="button" class="btn btn-primary">Registration Special</button></a></div>
                    <div class="col"><a href="volunteer_index.php"><button type="button" class="btn btn-primary">Volunteer Lists</button></a></div>
                    <div class="col"><a href="transportation.php"><button type="button" class="btn btn-primary">Transportation</button></a></div>
                </div>

            </div>
<div class='container-fluid' id='all'>
    <div class="btn-group" role="group" aria-label="Basic example">
        <div class='row' id='report_buttons2'>       
            <div class='col-lg-4'>
                <div class="dropdown">
                    <a class="btn btn-primary dropdown-toggle " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Contact List by Program
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <?php foreach($active_prog_secs as $a): ?>
                        <a class="dropdown-item" href="contact_list_program.php?passed_prog=<?php echo $a['prog_name'];?>"><?php echo $a['prog_name']; ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
                
            
            <div class='col-lg-4'>
                <div class="dropdown">
                    <a class="btn btn-primary dropdown-toggle " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Attendance
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <?php foreach($active_prog_secs as $a): ?>
                        <a class="dropdown-item" href="attendance.php?passed_prog=<?php echo $a['prog_name'];?>"><?php echo $a['prog_name']; ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        
            <div class='col-lg-4'>
                <div class="dropdown">
                    <a class="btn btn-primary dropdown-toggle " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Consent List
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <?php foreach($active_prog_secs as $a): ?>
                        <a class="dropdown-item" href="consent.php?passed_prog=<?php echo $a['prog_name'];?>"><?php echo $a['prog_name']; ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    

<script src="../scripts/jquery-3.4.1.js"></script>
<script src="../scripts/js/bootstrap.bundle.js"></script>
</body>
</html>