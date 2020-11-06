<?php

include('../inc/db_connect.php');

$action = filter_input(INPUT_POST, 'action');

$query_transportation =
    'SELECT c_fname, 
        c_lname, 
        prog_day,
        p_fname,
        p_lname,
        p_cell_phone,
        c_st_address,
        c_city,
        c_zipcode,
        trans_type_to,
        trans_type_from
    FROM child c
    JOIN enrollment e ON e.c_id = c.c_id
    JOIN person p ON p.person_id = e.person_id
    JOIN transportation t ON t.c_id = c.c_id
    JOIN prog_section ps 
        ON ps.prog_sec = t.prog_sec
        AND ps.prog_sec_active = TRUE
    WHERE (trans_type_to = "Van"
    OR trans_type_from = "Van")
    AND prog_day = :passed_day
    GROUP BY c_fname, c_lname';
$stmt = $db->prepare($query_transportation);
$stmt->bindValue(':passed_day', $action);
$stmt->execute();
$transportation_day = $stmt->fetchAll();
$stmt->closeCursor();

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
    <div class='table-responsive' id="report_box">
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
                                <th>Address</th>
                                <th>Transit To</th>
                                <th>Transit From</th>
                                <th>Guardian</th>
                                <th>Phone</th>

                            </tr>
                            <?php foreach($transportation_day as $t):?>
                            <?php if($t['prog_day'] == $action): ?>
                            <tr>
                                <td><?php echo $t['c_fname']." ".$t['c_lname']; ?></td>
                                <td><?php echo $t["c_st_address"]."&emsp; ".$t["c_city"]; ?></td>
                                <td><?php echo $t['trans_type_to'];?></td>
                                <td><?php echo $t['trans_type_from'];?></td>
                                <td><?php echo $t['p_fname']." ".$t['p_lname']; ?></td>
                                <td><?php echo $t['p_cell_phone']?></td>
                            </tr>
                            <?php endif; ?>
                            <?php endforeach;?>

                        </tbody>
                    </thread>
                </table>
    </div>
<?php endif; ?>
    
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