<?php

include('../inc/db_connect.php');

$action = filter_input(INPUT_POST, 'action');
$child = 0;

$query_registration_list =
    'SELECT c_fname,
    c_lname,
    c.c_id,
    TIMESTAMPDIFF(YEAR, c.c_dob, CURDATE()) AS c_age,
    c_grade,
    c_gender,
    p_fname,
    p_lname,
    p_cell_phone,
    prog_name,
    prog_day
FROM child c
JOIN enrollment e ON e.c_id = c.c_id
JOIN person p ON p.person_id = e.person_id
JOIN prog_section ps ON ps.prog_sec = e.prog_sec
JOIN program pr ON pr.prog_id = ps.prog_id
WHERE prog_day = "Special Event"
AND prog_name = :passed_name
GROUP BY p.person_id, c_fname
ORDER BY c.c_id';
$stmt = $db->prepare($query_registration_list);
$stmt->bindValue(':passed_name', $action);
$stmt->execute();
$registration = $stmt->fetchAll();
$stmt->closeCursor();



$query_special_event =
    'SELECT prog_name
    FROM program pr
    JOIN prog_section ps ON ps.prog_id = pr.prog_id
    WHERE prog_day = "Special Event"
    AND ps.prog_sec_active = TRUE';
$stmt1 = $db->prepare($query_special_event);
$stmt1->execute();
$special = $stmt1->fetchAll();
$stmt1->closeCursor();

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
<div class='container-fluid' id='day_buttons'>
            <div id='content'>
                <form action="" class="needs-validation" novalidate method="post">
                <?php foreach($special as $s): ?>
                    <button class="btn btn-success" type="submit" name="action" value="<?php echo $s['prog_name']; ?>"><?php echo $s['prog_name']; ?></button>
                <?php endforeach; ?>
                    <button class="btn btn-warning" type="button" id="hide" value="hide">Hide Progam Buttons</button>
                    <a href="reports.php"><button type="button" class="btn btn-primary">Back</button></a>
                </form>
            </div>
        </div>
    <div class='col-md-12' id='table_data'>
        <br>
<?php if(isset($action)): ?>
            <div class='table-responsive' id='report_box'>
                <table class='table table-striped table-sm' id='table1'>
                    <thread>
                        <thead>
                            <tr>
                                <h4><b>Registration:&emsp; <?php echo $action; ?></b></h4>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Child Name</th>
                                <th>Age</th>
                                <th>Grade</th>
                                <th>Gender</th>
                                <th>Guardian Name</th>
                                <th>Phone</th>
                            </tr>
                            <?php foreach($registration as $r):?>
                            <tr>
                            <?php if($child != $r['c_id']){ ?>
                                <td><?php echo $r['c_fname']." ".$r['c_lname']; ?></td>
                                <td><?php echo $r['c_age']; ?></td>
                                <td><?php echo $r['c_grade']; ?></td>
                                <td><?php echo $r['c_gender']; ?></td>
                                <td><?php echo $r['p_fname']." ".$r['p_lname']; ?></td>
                                <td><?php echo $r['p_cell_phone']; ?></td>
                            <?php $child = $r['c_id'];
                            }else{ ?>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?php echo $r['p_fname']." ".$r['p_lname']; ?></td>
                                <td><?php echo $r['p_cell_phone']; ?></td>
                            <?php } ?>
                            </tr>
                            <?php endforeach;?>
                            

                        </tbody>
                    </thread>
                </table>
            </div>
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