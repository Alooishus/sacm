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
                                <h4><b>Volunteer List:&emsp; <?php echo $prog_day; ?></b></h4>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Organization</th>
                                <th>Date&emsp;Description</th>
                                <th>Program</th>
                            </tr>
                            <?php foreach($vol_by_day as $v):?>
                            <tr>
                                <td><?php echo $v['p_fname']." ".$v['p_lname']; ?></td>
                                <td><?php echo $v["p_st_address"]."&emsp; ".$v["p_city"].", ".$v['p_state']." ".$v['p_zipcode']; ?></td>      
                                <td><?php echo $v['p_cell_phone']; ?></td>
                                <td><?php echo $v['p_email']; ?></td>
                                <td><?php echo $v['org_name']; ?></td>
                                <td><?php echo $v['don_date']."&emsp;".$v['don_desc']; ?></td>
                                <td><?php echo $v['prog_name']."&emsp;".$v['prog_sec_desc']; ?></td>
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