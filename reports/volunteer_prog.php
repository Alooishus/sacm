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
                            <?php foreach($vol_by_prog as $p){
                                $title = $p['prog_name']."&emsp;".$p['prog_sec_desc'];
                            } 
                            if(isset($title)):
                            ?>
                                <h4><b>Volunteer List:&emsp; <?php echo $title; ?></b></h4>
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
                            </tr>
                            <?php foreach($vol_by_prog as $p):?>
                            <tr>
                                <td><?php echo $p['p_fname']." ".$p['p_lname']; ?></td>
                                <td><?php echo $p["p_st_address"]."&emsp; ".$p["p_city"].", ".$p['p_state']." ".$p['p_zipcode']; ?></td>      
                                <td><?php echo $p['p_cell_phone']; ?></td>
                                <td><?php echo $p['p_email']; ?></td>
                                <td><?php echo $p['org_name']; ?></td>
                                <td><?php echo $p['don_date']."&emsp;".$p['don_desc']; ?></td>
                            </tr>
                            <?php endforeach; endif;?>

                        </tbody>
                    </thread>
                </table>
            </div>


<script src="../scripts/jquery-3.4.1.js"></script>
<script src="../scripts/js/bootstrap.bundle.js"></script>
</body>
</html>