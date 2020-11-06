<?php

include('../inc/db_connect.php');

$passed_prog = filter_input(INPUT_GET, 'passed_prog');
$action = filter_input(INPUT_POST, 'action');

//select list might work 
$query_all_active_prog_secs = 
    'SELECT 
        ps.prog_id, 
        ps.prog_sec,
        p.prog_name, 
        ps.prog_sec_desc,
        prog_day
    FROM prog_section ps
        JOIN program p
            ON ps.prog_id = p.prog_id
        JOIN enrollment e
            ON ps.prog_sec = e.prog_sec
    WHERE ps.prog_sec_active = true';
$stmt = $db->prepare($query_all_active_prog_secs);
$stmt->execute();
$active_prog_secs = $stmt->fetchAll();
$stmt->closeCursor();

$query_distinct_prog = 
    'SELECT 
        ps.prog_id, 
        ps.prog_sec,
        p.prog_name, 
        ps.prog_sec_desc,
        prog_time,
        prog_day,
        ps.prog_age_range
    FROM prog_section ps
        JOIN program p
            ON ps.prog_id = p.prog_id
        JOIN enrollment e
            ON ps.prog_sec = e.prog_sec
    WHERE ps.prog_sec_active = true
    GROUP BY prog_sec';
$stmt1 = $db->prepare($query_distinct_prog);
$stmt1->execute();
$one_section = $stmt1->fetchAll();
$stmt1->closeCursor();

/* print_r('<pre>');
print_r($active_prog_secs);
print_r('</pre>'); */


//select list might work 
$query_all_active_enrollments = 
    'SELECT 
        e.e_num, 
        e.c_id
    FROM enrollment e';
$stmt = $db->prepare($query_all_active_enrollments);
$stmt->execute();
$e_nums_for_c_ids = $stmt->fetchAll();
$stmt->closeCursor();



$query_all_active_enrollments = 
    "SELECT e.c_id,
        c.c_fname,
        c.c_gender,
        c.c_lname,
        c.c_grade,
        TIMESTAMPDIFF(YEAR, c.c_dob, CURDATE()) AS age,
        c.c_city,
        c.c_st_address,
        c.c_school,
        e.person_id,
        p.p_fname,
        p.p_lname,
        e.e_num,
        pr.prog_id,
        ps.prog_sec,
        pr.prog_name,
        ps.prog_sec_desc,
        ps.prog_day,
        t.trans_type_to,
        t.trans_type_from,
        p.p_cell_phone,
        prog_time
    FROM child c
        JOIN enrollment e
            ON c.c_id = e.c_id
        JOIN transportation t
            ON c.c_id = t.c_id
            AND e.prog_sec = t.prog_sec
        JOIN prog_section ps
            ON ps.prog_sec = t.prog_sec
        JOIN program pr
            ON ps.prog_id = pr.prog_id
        jOIN person p 
            ON e.person_id = p.person_id
    WHERE ps.prog_sec_active = true
    AND  prog_name = :passed_prog
    GROUP BY c.c_fname,c.c_lname,ps.prog_sec
    ORDER BY c.c_lname,c.c_fname, c.c_id, prog_time";

$stmt = $db->prepare($query_all_active_enrollments);
$stmt->bindValue(':passed_prog', $passed_prog);
$stmt->execute();
$enrollments = $stmt->fetchAll();
$stmt->closeCursor(); 

$query_music_lesson =
    'SELECT 
        c.c_fname,
        c.c_lname,
        t.trans_type_to,
        t.trans_type_from,
        pr.prog_name,
        prog_day,
        prog_time
    FROM child c
        JOIN enrollment e
            ON c.c_id = e.c_id
        JOIN transportation t
            ON c.c_id = t.c_id
            AND e.prog_sec = t.prog_sec
        JOIN prog_section ps
            ON ps.prog_sec = t.prog_sec
        JOIN program pr
            ON ps.prog_id = pr.prog_id
        jOIN person p 
            ON e.person_id = p.person_id
    WHERE ps.prog_sec_active = true
    AND  prog_name = :passed_prog
    GROUP BY c.c_fname,c.c_lname,ps.prog_sec
    ORDER BY prog_time'; 
$stmt2 = $db->prepare($query_music_lesson);
$stmt2->bindValue(':passed_prog', $passed_prog);
$stmt2->execute();
$time = $stmt2->fetchAll();
$stmt2->closeCursor(); 


$data = array();
$currentRow = null;

foreach($enrollments as $row)
{
    if ($currentRow && $currentRow["c_id"] == $row["c_id"])
    {
        array_push($currentRow["enrollments"],
                array(
                    "guardian_name" => ($row["p_fname"]." ".$row["p_lname"]),
                    "prog_sec" => $row["prog_sec"],
                    "prog_name" => $row["prog_name"],
                    "trans_type_to" => $row["trans_type_to"],
                    "trans_type_from" => $row["trans_type_from"],
                    "p_cell_phone" => $row["p_cell_phone"]
                )
            );
    }
    else
    {
        if ($currentRow)
        {
            array_push($data, $currentRow);
        }
        $currentRow = array(
            "c_id" => $row["c_id"], 
            "child_name" => ($row["c_fname"]." ".$row["c_lname"]),
            "c_gender" => $row["c_gender"],
            "c_grade" => $row["c_grade"],
            "age" => $row["age"],
            "address" => ($row["c_st_address"].",&emsp;  ".$row["c_city"]),
            "c_school" => $row["c_school"],

            "enrollments" =>array(array(
                "guardian_name" => ($row["p_fname"]." ".$row["p_lname"]),
                "prog_sec" => $row["prog_sec"],
                "prog_name" => $row["prog_name"],
                "trans_type_to" => $row["trans_type_to"],
                "trans_type_from" => $row["trans_type_from"],
                "p_cell_phone" => $row["p_cell_phone"]
                ))
            );
    }
}

if ($currentRow)
{
    array_push($data, $currentRow);
}

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

<?php if($passed_prog != 'Private Music Lesson'): ?>

    <div class='col-md-12' id='table_data'>
        <br>
            <div class='table-responsive'>
                <table class='table table-striped table-sm' id='table1'>
                    <thread>
                        <thead>
                            <tr>
                                <h4><b>Contact Information:&emsp; <?php echo $passed_prog; ?></b></h4>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Child Name</th>
                                <th>M/F</th>
                                <th>Age</th>
                                <th>Grade</th>
                                <th>Street Address, City</th>
                                <th>Guardian(s)</th>
                                <th>School</th>
                                <?php foreach($one_section as $os): ?>
                                <?php if($os['prog_name'] == $passed_prog): ?>
                                <th>
                                    <?php 
                                        echo $passed_prog."&emsp; ".$os['prog_age_range']."&emsp;".$os['prog_time'];
                                    ?>
                                </th>
                                <?php endif; ?>
                                <?php endforeach; ?>

                            </tr>
                            <?php foreach($data as $child):?>
                            <tr>
                                <td><?php echo $child['child_name']; ?></td>


                                <td><?php echo $child['c_gender'];?>
                                </td>
                                <td><?php echo $child['age'];?>
                                </td>
                                <td><?php echo $child['c_grade'];?>
                                </td>
                                <td><?php echo $child['address']; ?>
                                </td>

                                <td>
                
                                <?php 
                                $guardians = array();
                                foreach($child["enrollments"] as $enrollment)
                                {
                                    $name = $enrollment['guardian_name']."&emsp; (".$enrollment["p_cell_phone"].") ";
                                    if (!in_array($name, $guardians))
                                    {
                                        echo $name;
                                        array_push($guardians, $name);
                                    }
                                }
                                ?>
                                </td>

                                <td><?php echo $child['c_school']; ?>
                                </td>

                                <?php foreach($one_section as $os):?>
                                    <?php if($os['prog_name'] == $passed_prog): ?>
                                    <td>
                                    <?php
                                        $to = "---";
                                        $from = "---";
                                        foreach($child['enrollments'] as $enrollment)
                                        {
                                            if($enrollment["prog_sec"] == $os['prog_sec'])
                                            {
                                                $to = $enrollment['trans_type_to'];
                                                $from = $enrollment['trans_type_from'];
                                            }
                                        }
                                        if ($to == "---")
                                        {
                                            echo "---";
                                        }
                                        else
                                        { ?>    
                                            <b>T:</b>&nbsp;<?php echo $to;?><br />
                                            <b>F:</b>&nbsp;<?php echo $from;
                                        }
                                    ?>
                                    </td>
                                    <?php endif; ?>
                                <?php endforeach;?>

                            </tr>

                            <?php endforeach;?>
                        </tbody>
                    </thread>
                </table>
            </div>
<?php endif; ?>

<?php if($passed_prog == 'Private Music Lesson'): ?>
    <div id='content'>
        <div class='container-fluid' id='day_buttons'>
            <form action="" class="needs-validation" novalidate method="post">
                <button class="btn btn-success" type="submit" name="action" value="Monday">Monday</button>
                <button class="btn btn-success" type="submit" name="action" value="Tuesday">Tuesday</button>
                <button class="btn btn-success" type="submit" name="action" value="Wednesday">Wednesday</button>
                <button class="btn btn-success" type="submit" name="action" value="Thursday">Thursday</button>
                <button class="btn btn-success" type="submit" name="action" value="Friday">Friday</button>
                <button class="btn btn-success" type="submit" name="action" value="Saturday">Saturday</button>
                <button class="btn btn-success" type="submit" name="action" value="Sunday">Sunday</button>
                <button class="btn btn-warning" type="button" id="hide" value="hide">Hide Day Buttons</button>
                <a href="reports.php"><button type="button" class="btn btn-primary">Back</button></a>
            </form>
        </div>
    </div>

<?php if(isset($action)): ?>
    <div class='table-responsive' id='report_box'>
                <table class='table table-striped table-sm' id='table1'>
                    <thread>
                        <thead>
                            <tr>
                                <h4><b><?php echo $action; ?></b></h4>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Child Name</th>
                                <th>Time</th>
                                <th>To</th>
                                <th>From</th>

                            </tr>
                            <?php foreach($time as $t):?>
                            <?php if($t['prog_day'] == $action): ?>
                            <tr>
                                <td><?php echo $t['c_fname']." ".$t['c_lname']; ?></td>
                                <td><?php echo $t['prog_time'];?></td>
                                <td><?php echo $t['trans_type_to']?></td>
                                <td><?php echo $t['trans_type_from']?></td>
                            </tr>
                            <?php endif; ?>
                            <?php endforeach;?>

                        </tbody>
                    </thread>
                </table>
    </div>
    
<?php endif; ?>


<?php endif; ?>
            <br>
        
        
    </div>
    <!--  </div> -->
    <!-- </div> -->
    
    <script src="../scripts/jquery-3.4.1.js"></script>
    <script src="../scripts/js/bootstrap.bundle.min.js"></script>

    <script>
        jQuery(document).ready(function(){
            jQuery('#hide').on('click', function(event) {        
                jQuery('#content').hide('fast');
            });
        });
    </script>

    <script>
        $(function() {
            
			$("#print-button").on("click", function() {
				var table = $("#table1"),
					tableWidth = table.outerWidth(),
					pageWidth = 1000,
					pageCount = Math.ceil(tableWidth / pageWidth),
					printWrap = $("<div></div>").insertAfter(table),
					i,
					printPage;
				for (i = 0; i < pageCount; i++) {
					printPage = $("<div></div>").css({
						"overflow": "hidden",
						"width": pageWidth,
						"page-break-before": i === 0 ? "auto" : "always"
					}).appendTo(printWrap);
					table.clone().removeAttr("id").appendTo(printPage).css({
						"position": "relative",
						"left": -i * pageWidth
					});
				}
				table.hide();
				$(this).prop("disabled", true);
			});
		});
    </script>
</body>

</html>