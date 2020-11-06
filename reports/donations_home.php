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
     <div id="content">
        <div class='col-12' id='table_data'>
        <h4>Donor List Search</h4>
            <form action="donations_index.php" class="needs-validation" novalidate method="post">

<!-- desc -->   <div class='row' id='vol_search_row'>
                    <div class='col-sm-10'>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Search donations by keyword</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="don_desc">
                                <option></option>
                                <?php foreach ($dono_desc as $d): ?>
                                <?php if($d['don_desc']==$don_desc){$selected="selected";}else{$selected="";}?>
                                <option <?php echo $selected;?> value="<?php echo $d['don_desc']; ?>">
                                    <?php echo $d['don_desc']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!  
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-2' id='vol_search_button'>
                        <button class="btn btn-success" type="submit" name="action" value="dono_desc_search">Search</button>
                    </div>
                </div>
                
            </form>
<!-- program -->
            <form action="donations_index.php" class="needs-validation" novalidate method="post">
                <div class='row' id='vol_search_row'>
                    <div class='col-sm-10'>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Search donations by program</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="prog_name">
                                <option></option>
                                <?php foreach ($all_prog_secs as $a): ?>
                                    <?php if($a['prog_id'] == $program){$selected="selected";}else{$selected="";}?>
                                <option <?php echo $selected;?> value="<?php echo $a['prog_id']; ?>">
                                    <?php echo $a['prog_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!  
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-2' id='vol_search_button'>
                        <button class="btn btn-success" type="submit" name="action" value="dono_prog_search">Search</button>
                    </div>
                </div>
                
            </form>
<!-- person -->
            <div id='right_dono'>
                <form action="donations_index.php" class="needs-validation" novalidate method="post">
                    <div class='row' id='vol_search_row'>
                        <div class='col-sm-10'>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Search donations by person</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="person">
                                    <option></option>
                                    <?php foreach ($donors as $d): ?>
                                    <?php if($d['person_id'] == $person){$selected="selected";}else{$selected="";}?>
                                    <option <?php echo $selected;?> value="<?php echo $d['person_id']; ?>">
                                        <?php echo $d['p_fname']." ".$d['p_lname']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!  
                                </div>
                            </div>
                        </div>
                        <div class='col-sm-2' id='vol_search_button'>
                            <button class="btn btn-success" type="submit" name="action" value="dono_person_search">Search</button>
                        </div>
                    </div>
                    
                </form>
    <!-- org -->
                <form action="donations_index.php" class="needs-validation" novalidate method="post">
                    <div class='row' id='vol_search_row'>
                        <div class='col-sm-10'>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Search donations by organizations</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="org_name">
                                    <option></option>
                                    <?php foreach ($org_list as $o): ?>
                                    <?php if($o['org_id']==$org_name){$selected="selected";}else{$selected="";}?>
                                    <option <?php echo $selected;?> value="<?php echo $o['org_id']; ?>">
                                        <?php echo $o['org_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!  
                                </div>
                            </div>
                        </div>
                        <div class='col-sm-2' id='vol_search_button'>
                            <button class="btn btn-success" type="submit" name="action" value="dono_org_search">Search</button></div>
                    </div>
                   
                
                </div> 
            </div>
            <button class="btn btn-warning" type="button" id="hide" value="hide">Hide Search Bars</button>
            <a href="reports.php"><button type="button" class="btn btn-primary">Back to Reports</button></a>
            </form>
    </div>

        <br>
        <div id='report_box'>
            <?php if($action == 'dono_desc_search' && $don_desc != ""): ?>
                <?php include('donations_desc.php'); ?>
            <?php endif; ?>
    
            <?php if($action == 'dono_prog_search' && $program != ""): ?>
                <?php include('donations_program.php'); ?>
            <?php endif; ?>
    
            <?php if($action == 'dono_person_search' && $person != ""): ?>
                <?php include('donations_person.php'); ?>
            <?php endif; ?>
    
            <?php if($action == 'dono_org_search'): ?>
                <?php include('donations_org.php'); ?>
            <?php endif; ?>
        </div>

            <br>
    
</div>
    
    
    <script src="../scripts/jquery-3.4.1.js"></script>
    <script src="../scripts/js/bootstrap.bundle.min.js"></script>

    <script>
        jQuery(document).ready(function(){
            jQuery('#hide').on('click', function(event) {        
                jQuery('#content').hide('fast');
            });
        });
    </script>

    <script>
        $(function() {
            
			$("#print-button").on("click", function() {
				var table = $("#table1"),
					tableWidth = table.outerWidth(),
					pageWidth = 1000,
					pageCount = Math.ceil(tableWidth / pageWidth),
					printWrap = $("<div></div>").insertAfter(table),
					i,
					printPage;
				for (i = 0; i < pageCount; i++) {
					printPage = $("<div></div>").css({
						"overflow": "hidden",
						"width": pageWidth,
						"page-break-before": i === 0 ? "auto" : "always"
					}).appendTo(printWrap);
					table.clone().removeAttr("id").appendTo(printPage).css({
						"position": "relative",
						"left": -i * pageWidth
					});
				}
				table.hide();
				$(this).prop("disabled", true);
			});
		});
    </script>
</body>

</html>