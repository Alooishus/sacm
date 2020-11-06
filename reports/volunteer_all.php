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
<div class='table-responsive'>
                <table class='table table-striped table-sm' id='table1'>
                    <thread>
                        <thead>
                            <tr>
                                <h4><b>Willing to Volunteer</b></h4>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Primary Skill</th>
                                <th>Secondary Skill</th>
                            </tr>
                            <?php foreach($vol_all as $v):?>
                            <tr>
                                <td><?php echo $v['p_fname']." ".$v['p_lname']; ?></td>
                                <td><?php echo $v["p_st_address"]."&emsp; ".$v["p_city"].", ".$v['p_state']." ".$v['p_zipcode']; ?></td>
                                <td><?php echo $v['p_cell_phone']; ?></td>
                                <td><?php echo $v['p_email']; ?></td>
                                <td><?php echo $v['primary_skill_type']; ?></td>
                                <td><?php echo $v['sec_skill_type']; ?></td>
                            </tr>
                            <?php endforeach;?>

                        </tbody>
                    </thread>
                </table>
            </div>


<script src="../scripts/jquery-3.4.1.js"></script>
<script src="../scripts/js/bootstrap.bundle.js"></script>
</body>
</html>