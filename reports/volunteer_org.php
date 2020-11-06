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
                            <?php foreach($vol_by_org as $v)
                            {
                                if ($v['org_name'] !== "*** Not Affiliated ***")
                                {
                                    $title = $v['org_name']."&emsp; ".$v["org_st_address"]."&emsp; ".$v["org_city"].", ".$v['org_state']." ".$v['org_zipcode']."&emsp; ".$v['org_email']."&emsp; ".$v['org_phone'];
                                }
                                else
                                {
                                    $title = "*** No Affilliation with Organization for the events listed below ***";
                                }
                            } ?>
                                <h4><b><?php echo $title; ?></b></h4>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Date&emsp;Description</th>
                                <th>Program</th>
                            </tr>
                            <?php foreach($vol_by_org as $v):?>
                            <tr>
                                <td><?php echo $v['p_fname']." ".$v['p_lname']; ?></td>
                                <td><?php echo $v["p_st_address"]."&emsp; ".$v["p_city"].", ".$v['p_state']." ".$v['p_zipcode']; ?></td>
                                <td><?php echo $v['p_cell_phone']; ?></td>
                                <td><?php echo $v['p_email']; ?></td>
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