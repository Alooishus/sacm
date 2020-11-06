<?php

include('../inc/db_connect.php');


$query_allergies =
    'SELECT c_fname, c_lname, c_allergies
    FROM child c
    JOIN enrollment e ON c.c_id = e.c_id
    JOIN prog_section ps ON ps.prog_sec = e.prog_sec
    JOIN program p ON p.prog_id = ps.prog_id
    WHERE prog_sec_active = TRUE
    AND prog_day <>"Special Event"
    AND c_allergies <>""
    GROUP BY c.c_id';
$stmt = $db->prepare($query_allergies);
$stmt->execute();
$allergy_list = $stmt->fetchAll();
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
    
    <div class='col-md-12' id='table_data'>
        <br>
        
            <div class='table-responsive' id='report_box'><a href="reports.php">Back</a>
                <table class='table table-striped table-sm' id='table1'>
                    <thread>
                        <thead>
                            <tr>
                                <h4><b>Allergy List</b></h4>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Child Name</th>
                                <th>Allergies</th>

                            </tr>
                            <?php foreach($allergy_list as $a_l):?>
                            <tr>
                                <td><?php echo $a_l['c_fname']." ".$a_l['c_lname']; ?></td>
                                <td><?php echo $a_l['c_allergies']; ?></td>
                            </tr>
                            <?php endforeach;?>

                        </tbody>
                    </thread>
                </table>
            </div>
            <br>
    
        
    </div>

    <script src="../scripts/jquery-3.4.1.js"></script>
    <script src="../scripts/js/bootstrap.bundle.min.js"></script>

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