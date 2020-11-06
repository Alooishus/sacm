<?php 
include('../inc/func.php');

$nav_click = filter_input(INPUT_GET,'nav_click');

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
    </div>
    <div class='container-fluid' id='logo'>
        <img src="../inc/images/Salvation-Army-logo.jpg" class="img-fluid" alt="Responsive image">
    </div>
        

<script src='../scripts/jquery-3.4.1.js'></script>
<script src='../scripts/js/bootstrap.bundle.min.js'></script>
</body>
</html>