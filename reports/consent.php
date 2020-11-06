<?php

include('../inc/db_connect.php');

$passed_prog = filter_input(INPUT_GET,'passed_prog');

$query_consent =
    'SELECT c_fname,
    c_lname,
    p_fname,
    p_lname,
    prog_name,
    p_cell_phone,
    p_home_phone,
    p_work_phone,
    e_consent_sacm_van,
    e_consent_attend,
    e_consent_sm_phone,
    e_consent_emg_med,
    e_consent_to_publish
FROM child c
JOIN enrollment e ON e.c_id = c.c_id
JOIN person p ON p.person_id = e.person_id
JOIN prog_section ps ON ps.prog_sec = e.prog_sec
JOIN program pr ON pr.prog_id = ps.prog_id
WHERE prog_name = :passed_prog
GROUP BY c_fname, c_lname';
$stmt = $db->prepare($query_consent);
$stmt->bindValue('passed_prog', $passed_prog);
$stmt->execute();
$consent = $stmt->fetchAll();
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
        
            <div class='table-responsive'>
                <table class='table table-striped table-sm' id='table1'>
                    <thread>
                        <thead>
                            <tr>
                                <h4><b>Consent List:&emsp; <?php echo $passed_prog; ?></b></h4>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Child Name</th>
                                <th>Guardian Name</th>
                                <th>Cell Phone</th>
                                <th>Home Phone</th>
                                <th>Work Phone</th>
                                <th>Transportation</th>
                                <th>Attend</th>
                                <th>Phone</th>
                                <th>Medical</th>
                                <th>Publish</th>

                            </tr>
                            <?php foreach($consent as $c):?>
                            <tr>
                                <td><?php echo $c['c_fname']." ".$c['c_lname']; ?></td>
                                <td><?php echo $c['p_fname']." ".$c['p_lname']; ?></td>
                                <td><?php echo $c['p_cell_phone']; ?></td>
                                <td><?php echo $c['p_home_phone']; ?></td>
                                <td><?php echo $c['p_work_phone']; ?></td>
                                <td><?php if($c['e_consent_sacm_van']){echo 'Yes';}else{echo 'No';} ?></td>
                                <td><?php if($c['e_consent_attend']){echo 'Yes';}else{echo 'No';} ?></td>
                                <td><?php if($c['e_consent_sm_phone']){echo 'Yes';}else{echo 'No';} ?></td>
                                <td><?php if($c['e_consent_emg_med']){echo 'Yes';}else{echo 'No';} ?></td>
                                <td><?php if($c['e_consent_to_publish']){echo 'Yes';}else{echo 'No';} ?></td>
                            </tr>
                            <?php endforeach;?>

                        </tbody>
                    </thread>
                </table>
            </div>
            <br>
    
        <!-- <input type="button" id="print-button" value="Make this table printable"> -->
    </div>
    <!--  </div> -->
    <!-- </div> -->
    
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