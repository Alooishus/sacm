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
                            <?php 
                                foreach($donors as $p){ 
                                    $passed_person = $person;
                                }
                                    $dono_by_person = dono_person($passed_person);
                                    foreach($dono_by_person as $d){
                                        $title = $d['p_fname']." ".$d['p_lname']."&emsp; ".$d["p_st_address"]."&emsp;".$d["p_city"].", ".$d['p_state']." ".$d['p_zipcode']."&emsp; ".$d['p_email']."&emsp; ".$d['p_cell_phone'];
                                    }
                            ?>
                                <h4><b><?php echo $title; ?></b></h4>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Date&emsp;Description</th>
                                <th>Program</th>
                                <th>Organization</th>

                            </tr>
                            <?php 
                                foreach($dono_by_person as $d){ ?>
                                <tr>
                                    <td><?php echo $d['don_date']." &emsp;".$d['don_desc']; ?></td>
                                    <td><?php echo $d['prog_name']."-".$d['prog_sec_desc']; ?></td>
                                    <td><?php echo $d['org_name']; ?></td>

                               
                                
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