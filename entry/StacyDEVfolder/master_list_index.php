<?php

include('../inc/db_connect.php');

//select list might work 
$query_all_active_prog_secs = 
    'SELECT ps.prog_id, ps.prog_sec,p.prog_name, ps.prog_sec_desc
    FROM prog_section ps, program p, enrollment e
    WHERE ps.prog_id = p.prog_id
    AND ps.prog_sec = e.prog_sec
    AND ps.prog_sec_active = true
    GROUP BY ps.prog_id';
$stmt = $db->prepare($query_all_active_prog_secs);
$stmt->execute();
$active_prog_secs = $stmt->fetchAll();
$stmt->closeCursor();


//select list might work 
$query_all_active_enrollments = 
    'SELECT e.e_num, e.c_id
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
    WHERE ps.prog_sec_active = true
    GROUP BY c.c_fname,c.c_lname,ps.prog_sec
    ORDER BY c.c_lname,c.c_fname, c.c_id";

$stmt = $db->prepare($query_all_active_enrollments);
$stmt->execute();
$enrollments = $stmt->fetchAll();
$stmt->closeCursor(); 


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
            "address" => ($row["c_st_address"]." ".$row["c_city"]),
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


//include_once ('master_list.php');
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
    <!-- <div class='container-fluid' id='all'> -->
    <!-- NAV BAR -->

    <!--  <div class='row' id='main_form'> -->
    <div class='col-md-12' id='table_data'>
        <br>
        <form action="edit_child_index.php" class="needs-validation" novalidate method="post">
            <div class='table-responsive'>
                <table class='table table-striped table-sm'>
                    <thread>
                        <thead>
                            <tr>
                                <h4><b>Master Enrollment</b></h4>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Child Name</th>
                                <th>M/F</th>
                                <th>Age</th>
                                <th>grade</th>
                                <th>Street Address, City</th>
                                <th>Guardian(s)</th>
                                <th>School</th>
                                <?php foreach($active_prog_secs as $active_prog_sec):?>
                                    <th>
                                        <?php 
                                            echo $active_prog_sec['prog_name'];
                                        ?>
                                    </th>
                                <?php endforeach;?>

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
                                    $name = $enrollment['guardian_name']." (".$enrollment["p_cell_phone"].") ";
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
                                <?php foreach($active_prog_secs as $active_prog_sec):?>
                                    <td>
                                    <?php
                                        $to = "---";
                                        $from = "---";
                                        foreach($child['enrollments'] as $enrollment)
                                        {
                                            if($enrollment["prog_name"] == $active_prog_sec['prog_name'])
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
                                <?php endforeach;?>

                            </tr>

                            <?php endforeach;?>
                        </tbody>
                    </thread>
                </table>
            </div>
            <br>
        </form>
    </div>
    <!--  </div> -->
    <!-- </div> -->
    </script>
    <script src="../scripts/jquery-3.4.1.js"></script>
    <script src="../scripts/js/bootstrap.bundle.min.js"></script>
</body>

</html>