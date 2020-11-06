<?php 
include('../inc/func.php');

$nav_click = filter_input(INPUT_GET,'nav_click');

$action = filter_input(INPUT_POST,'action');

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
    <div class='container-fluid' id='all'>
    <!-- NAV BAR -->
    <?php echo navbar($nav_click); ?>

        <form action="admin.php" method="post">
            <div id="launch">
                <button type="submit" class="btn btn-warning" name="action" value='go'>Launch Backup/Restore Application </button>
            </div>
        </form>
            <?php if($action == "go"){ 
                exec('"C:\Program Files (x86)\AOMEI Backupper\script.cmd');
            } 
            ?>
            
        <div id='direction_buttons'>
            <button class="btn btn-success" type="button" id="backup" >Backup Directions</button>
            <button class="btn btn-success" type="button" id="restore" >Restore Directions</button>
            <button class="btn btn-success" type="button" id="time" >Set Time/Date Directions</button>
        </div>

        <div class='admin_img' id='backup_content'>
            <img src="../inc/images/2020-02-29_12h19_58.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_13h31_49.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_13h32_37.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_13h33_12.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_13h35_39.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_12h22_29.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_12h25_53.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_12h32_37.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_12h37_51.png" class="img-fluid" alt="Responsive image">
            <a href="admin.php">Back to top</a>
        </div>

        <div class='admin_img' id='restore_content'>
            <img src="../inc/images/2020-02-29_12h19_58.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_12h40_17.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_12h40_33.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-03-02_19h41_01.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_12h41_16.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_12h50_37.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_13h25_47.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_12h41_17.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_13h23_12.png" class="img-fluid" alt="Responsive image">
            <a href="admin.php">Back to top</a>
        </div>
        
        <div class='admin_img' id='time_content'>
            <img src="../inc/images/2020-02-29_19h22_47.png" class="img-fluid" alt="Responsive image">
            <img src="../inc/images/2020-02-29_19h23_16.png" class="img-fluid" alt="Responsive image">
        </div>

    </div>
    
            

    <script src="../scripts/jquery-3.4.1.js"></script>
    <script src="../scripts/js/bootstrap.bundle.min.js"></script>

    <script>
        jQuery(document).ready(function(){
            jQuery('#backup').on('click', function(event) {        
                jQuery('#backup_content').toggle('fast');
                jQuery('#restore_content').hide('fast');
                jQuery('#time_content').hide('fast');
            });
        });
        jQuery(document).ready(function(){
            jQuery('#restore').on('click', function(event) {        
                jQuery('#restore_content').toggle('fast');
                jQuery('#backup_content').hide('fast');
                jQuery('#time_content').hide('fast');
            });
        });
        jQuery(document).ready(function(){
            jQuery('#time').on('click', function(event) {        
                jQuery('#time_content').toggle('fast');
                jQuery('#backup_content').hide('fast');
                jQuery('#restore_content').hide('fast');
            });
        });
    </script>
</body>
</html>