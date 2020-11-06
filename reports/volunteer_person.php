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
                            <?php foreach ($vol_by_person as $v){
                                $title = $v['p_fname']." ".$v['p_lname']."&emsp; ".$v['p_cell_phone']."&emsp; ".$v['p_email'];
                            } ?>
                                <h4><b>Volunteer:&emsp; <?php echo $title; ?></b></h4>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Date&emsp;Description</th>
                                <th>Program</th>
                                <th>Organization</th>
                            </tr>
                            <?php foreach($vol_by_person as $v):?>
                            <tr>
                                <td><?php echo $v['don_date']."&emsp;".$v['don_desc']; ?></td>
                                <td><?php echo $v['prog_name']."&emsp;".$v['prog_sec_desc']; ?></td>
                                <td><?php echo $v['org_name']; ?></td>
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