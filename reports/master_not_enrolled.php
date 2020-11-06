
<?php

include('../inc/db_connect.php');


$query_no_active_enrollments = 
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
    p.p_cell_phone
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
    WHERE  e.c_id NOT IN(
                        SELECT e.c_id
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
                        )
    GROUP BY c.c_id
    ORDER BY c.c_lname,c.c_fname";
    
$stmt = $db->prepare($query_no_active_enrollments);
$stmt->execute();
$nonenrollments = $stmt->fetchAll();
$stmt->closeCursor(); 


$data = array();
$currentRow = null;

foreach($nonenrollments as $row)
{
    if ($currentRow && $currentRow["c_id"] == $row["c_id"])
    {
        array_push($currentRow["enrollments"],
                array(
                    "guardian_name" => ($row["p_fname"]." ".$row["p_lname"]),
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
            "address" => ($row["c_st_address"]." ".$row["c_city"]),
            "c_school" => $row["c_school"],

            "enrollments" =>array(array(
                "guardian_name" => ($row["p_fname"]." ".$row["p_lname"]),
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
    <div class='col-md-12' id='table_data'>
        <br>
        <form action="edit_child_index.php" class="needs-validation" novalidate method="post">
        <a href="reports.php">Back</a>
            <div class='table-responsive'>
                <table class='table table-striped table-sm' id='table1'>
                    <thread>
                        <thead>
                            <tr>
                                <h4><b>Master Not Currently Enrolled in any Programs</b></h4>
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
                            </tr>
                            <?php foreach($data as $child):?>
                            <tr>
                                <td><?php echo $child['child_name']; ?></td>
                                <td><?php echo $child['c_gender'];?></td>
                                <td><?php echo $child['age'];?></td>
                                <td><?php echo $child['c_grade'];?></td>
                                <td><?php echo $child['address']; ?></td>
                                <td>
                                <?php 
                                    $guardians = array();
                                    foreach($child["enrollments"] as $n)
                                    {
                                        $name = $n['guardian_name']." (".$n["p_cell_phone"].")&emsp; ";
                                        if (!in_array($name, $guardians))
                                        {
                                            echo $name;
                                            array_push($guardians, $name);
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?php echo $child['c_school']; ?></td>
                                <?php endforeach;?>
                            </tr>
                        </tbody>
                    </thread>
                </table>
            </div>
            <br>
        </form>
      
    </div>
    
    <script src="../scripts/jquery-3.4.1.js"></script>
    <script src="../scripts/js/bootstrap.bundle.min.js"></script>

    <script>
        $(function() {
            
			$("#print-button").on("click", function() {
				var table = $("#table1"),
					tableWidth = table.outerWidth(),
					pageWidth = 1011,
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