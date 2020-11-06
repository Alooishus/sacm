<?php

include('../inc/db_connect.php');

$passed_prog = filter_input(INPUT_GET,'passed_prog');
$action = filter_input(INPUT_POST,'action');

$query_attendance =
    'SELECT 
    c.c_fname,
    c.c_lname,
    t.trans_type_to,
    t.trans_type_from,
    pr.prog_name,
    ps.prog_sec,
    prog_age_range,
    prog_day
FROM child c
    JOIN enrollment e ON c.c_id = e.c_id
        AND e.e_status = true
    JOIN transportation t ON c.c_id = t.c_id
        AND e.prog_sec = t.prog_sec
    JOIN prog_section ps ON ps.prog_sec = t.prog_sec
    JOIN program pr ON ps.prog_id = pr.prog_id
    JOIN person p ON e.person_id = p.person_id
WHERE ps.prog_sec_active = true
AND  ps.prog_sec = :placeholder
GROUP BY c.c_fname,c.c_lname';
$stmt = $db->prepare($query_attendance);
$stmt->bindValue(':placeholder', $action);
$stmt->execute();
$attendance = $stmt->fetchAll();
$stmt->closeCursor();

$query_music =
    'SELECT 
    c.c_fname,
    c.c_lname,
    t.trans_type_to,
    t.trans_type_from,
    pr.prog_name,
    ps.prog_sec,
    prog_age_range,
    prog_day
FROM child c
    JOIN enrollment e ON c.c_id = e.c_id
        AND e.e_status = true
    JOIN transportation t ON c.c_id = t.c_id
        AND e.prog_sec = t.prog_sec
    JOIN prog_section ps ON ps.prog_sec = t.prog_sec
    JOIN program pr ON ps.prog_id = pr.prog_id
    JOIN person p ON e.person_id = p.person_id
WHERE ps.prog_sec_active = true
AND  prog_name = :placeholder
GROUP BY c.c_fname,c.c_lname';
$stmt3 = $db->prepare($query_music);
$stmt3->bindValue(':placeholder', $passed_prog);
$stmt3->execute();
$music = $stmt3->fetchAll();
$stmt3->closeCursor();

$query_buttons =
    'SELECT 
    c.c_fname,
    c.c_lname,
    t.trans_type_to,
    t.trans_type_from,
    pr.prog_name,
    ps.prog_sec,
    prog_age_range,
    prog_day
FROM child c
    JOIN enrollment e ON c.c_id = e.c_id
    JOIN transportation t ON c.c_id = t.c_id
        AND e.prog_sec = t.prog_sec
    JOIN prog_section ps ON ps.prog_sec = t.prog_sec
    JOIN program pr ON ps.prog_id = pr.prog_id
    JOIN person p ON e.person_id = p.person_id
WHERE ps.prog_sec_active = true
AND  prog_name = :passed_prog
GROUP BY ps.prog_sec';
$stmt2 = $db->prepare($query_buttons);
$stmt2->bindValue(':passed_prog', $passed_prog);
$stmt2->execute();
$buttons = $stmt2->fetchAll();
$stmt2->closeCursor();


$query_volunteer =
    "SELECT p_fname, p_lname
    FROM donations d
    JOIN volunteer v ON v.person_id = d.person_id
    JOIN person p ON p.person_id = v.person_id
    JOIN program_donation pd ON pd.don_id = d.don_id
    JOIN prog_section ps ON ps.prog_sec = pd.prog_sec
    JOIN program pr ON pr.prog_id = ps.prog_id
    WHERE ps.prog_sec = :passed_prog
    AND don_type = 'Time'";
$stmt1 = $db->prepare($query_volunteer);
$stmt1->bindValue(':passed_prog', $action);
$stmt1->execute();
$volunteer = $stmt1->fetchAll();
$stmt1->closeCursor();

$query_volunteer_music =
    "SELECT p_fname, p_lname
    FROM donations d
    JOIN volunteer v ON v.person_id = d.person_id
    JOIN person p ON p.person_id = v.person_id
    JOIN program_donation pd ON pd.don_id = d.don_id
    JOIN prog_section ps ON ps.prog_sec = pd.prog_sec
    JOIN program pr ON pr.prog_id = ps.prog_id
    WHERE ps.prog_sec = :passed_prog
    AND don_type = 'Time'";
$stmt4 = $db->prepare($query_volunteer_music);
$stmt4->bindValue(':passed_prog', $passed_prog);
$stmt4->execute();
$volunteer_music = $stmt4->fetchAll();
$stmt4->closeCursor();

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
    <div id='content'>
        <form action="attendance.php?passed_prog=<?php echo $passed_prog; ?>" method="post">
            <?php foreach($buttons as $b): ?>
                <?php if($passed_prog != 'Private Music Lesson'): ?>
                <button class="btn btn-success" type="submit" name="action" value="<?php echo $b['prog_sec']; ?>" ><?php echo $b['prog_name'].": ".$b['prog_age_range']; ?></button>
               <input type="hidden" name='passed_prog' value='<?php echo $b['prog_name']; ?>'>
                <?php endif; endforeach; ?> 
            <button class="btn btn-warning" type="button" id="hide" value="hide">Hide Buttons</button>
           <a href="reports.php"><button type="button" class="btn btn-primary">Back</button></a>
        </form>
    </div>
    
<?php if(isset($action) && $passed_prog != 'Private Music Lesson'): ?>
    <div id='attendance'> 
        <div class='col-md-12' id='table_data'>
           
                <div class='table-responsive'>
                    <table class='table table-striped table-sm' id='table1'>
                        <thread>
                            <thead colspan =7> 
                                    <h4><b>Attendance Sheet: <?php echo $passed_prog; ?></b></h4></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Child Name</th>
                                    <th>Paid(y/n)&nbsp;</th>
                                    <th>&nbsp;/&nbsp;</th>
                                    <th>&nbsp;/&nbsp;</th>
                                    <th>&nbsp;/&nbsp;</th>
                                    <th>&nbsp;/&nbsp;</th>
                                    <th>&nbsp;/&nbsp;</th>
    
                                </tr>
                                <?php foreach($attendance as $a):?>
                                <tr>
                                    <td><?php echo $a['c_fname']." ".$a['c_lname']; ?></td>
                                    <td>$</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </thread>
                    </table>
                    <table class='table table-striped table-sm' id='table1'>
                        <thread>
                            <thead>
                                <tr>
                                <th colspan =7><h4><b>Volunteers: Record required information for system below</b></h4></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Organization</th>
                                    <th>Address</th>
                                    <th>City, State</th>
                                    <th>Zip</th>
                                    <th>Phone</th>
                                </tr>
                                <?php foreach($volunteer as $v):?>
                                <tr>
                                    <td><?php echo $v['p_fname']." ".$v['p_lname']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php endforeach;?>
                                <?php for ($i=0;$i<10;$i++){ ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </thread>
                    </table>
                </div>
        </div>
    </div>
<?php endif; ?>
<?php if($passed_prog == 'Private Music Lesson'): ?>
<div id='attendance'> 
        <div class='col-md-12' id='table_data'>
           
                <div class='table-responsive'>
                    <table class='table table-striped table-sm' id='table1'>
                        <thread>
                            <thead colspan =7> 
                                    <h4><b>Attendance Sheet: <?php echo $passed_prog; ?></b></h4></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Child Name</th>
                                    <th>Paid(y/n)&nbsp;</th>
                                    <th>&nbsp;/&nbsp;</th>
                                    <th>&nbsp;/&nbsp;</th>
                                    <th>&nbsp;/&nbsp;</th>
                                    <th>&nbsp;/&nbsp;</th>
                                    <th>&nbsp;/&nbsp;</th>
    
                                </tr>
                                <?php foreach($music as $a):?>
                                <tr>
                                    <td><?php echo $a['c_fname']." ".$a['c_lname']; ?></td>
                                    <td>$</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </thread>
                    </table>
                    <table class='table table-striped table-sm' id='table1'>
                        <thread>
                            <thead>
                                <tr>
                                <th colspan =7><h4><b>Volunteers: Record required information for system below</b></h4></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Organization</th>
                                    <th>Address</th>
                                    <th>City, State</th>
                                    <th>Zip</th>
                                    <th>Phone</th>
                                </tr>
                                <?php foreach($volunteer_music as $v):?>
                                <tr>
                                    <td><?php echo $v['p_fname']." ".$v['p_lname']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php endforeach;?>
                                <?php for ($i=0;$i<10;$i++){ ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </thread>
                    </table>
                </div>
        </div>
    </div>
<?php endif; ?>
    
    <script src="../scripts/jquery-3.4.1.js"></script>
    <script src="../scripts/js/bootstrap.bundle.min.js"></script>

    <script>
        jQuery(document).ready(function(){
            jQuery('#hide').on('click', function(event) {        
                jQuery('#content').toggle('fast');
            });
        });
    </script>
</body>

</html>