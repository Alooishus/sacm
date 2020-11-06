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
                            <?php $organizations = get_donation_by_org($org_name); 
                                foreach($organizations as $o){
                                    $title = $o['org_name']." &emsp;".$o["org_st_address"]."&emsp; ".$o["org_city"].", ".$o['org_state']." ".$o['org_zipcode'];
                                }
                            ?>
                                <h4><b>Donations from:&emsp; <?php echo $title; ?></b></h4>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Program</th>
                            </tr>
                            <?php foreach($organizations as $o){ ?>
                            <tr>
                                <td><?php echo $o['don_desc']; ?></td>
                                <td><?php echo $o['don_date']; ?></td>
                                <td><?php echo $o['p_fname']." ".$o['p_lname']; ?></td>
                                <td><?php echo $o['p_cell_phone']; ?></td>
                                <td><?php echo $o['p_email']; ?></td>
                                <td><?php echo $o['prog_name']; ?></td>
                            </tr>
                            <?php } ?>
                            

                        </tbody>
                    </thread>
                </table>
            </div>


<script src="../scripts/jquery-3.4.1.js"></script>
<script src="../scripts/js/bootstrap.bundle.js"></script>
</body>
</html>