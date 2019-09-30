<?php
/* TEST */
error_reporting( error_reporting() & ~E_NOTICE );
session_start();
include "inc/config.inc.php";
include "function/function.php";
//echo "$_SESSION[m_login]<br>$_SESSION[m_id]";
if(!isset($_SESSION[user_login])) {
echo "<meta http-equiv='refresh' content='0;url=index.php'>" ; 
exit() ;
}

if($_SESSION['m_id']){
	$sqlQuery="SELECT * FROM villa WHERE villa_enable='Y' order by villa_name asc";
	$re_sql=mysql_query($sqlQuery) or die("ERROR $sqlQuery");
	while($r_sql=mysql_fetch_assoc($re_sql)){
		//villa_id  villa_name  villa_enable
		$villaDB[$r_sql['villa_id']]['villa_id'] = $r_sql['villa_id'];
		$villaDB[$r_sql['villa_id']]['sc_id'] = $r_sql['sc_id'];
		$villaDB[$r_sql['villa_id']]['villa_name'] = $r_sql['villa_name'];
		$villaDB[$r_sql['villa_id']]['villa_enable'] = $r_sql['villa_enable'];
	}

	$sp="select `u_name`, `u_email`, `u_pass`,  `u_villa_id`, `u_enable` from dgs_user where u_id='".$_SESSION['m_id']."' ";
	$rep=mysql_query($sp) or die("Error $sp");
	$rp=mysql_fetch_assoc($rep);
	$u_villa_id = $rp['u_villa_id'];

	$villa_id_arr = explode(",",$u_villa_id);

	$sql_where ='';
	foreach($villa_id_arr as $key => $value ){
		$villaUser[$value]['villa_id'] = $villaDB[$value]['villa_id'];
		$villaUser[$value]['villa_name'] = $villaDB[$value]['villa_name'];
		$sql_where .= 'villa_id='.$value.' OR ';
	}
	if($sql_where!=''){
		//$sql_where_txt = 'WHERE '.$sql_where;
		//$sql_where_txt = substr($sql_where_txt,0,-4);

		//$villa_guest_sqlQuery="SELECT * FROM `villa_guest` ".$sql_where_txt." ";

	}else{
		?>
		<script language="JavaScript">
		alert("Sorry, no villa data to manage.");
		window.location = 'index.php';
		</script>
		<?php 
	}


}

if($_GET['action']=='edit'){
    $action = 'edit';
    if(isset($_GET['vg_id'])){
        $vg_id=$_GET[vg_id];

        $sp="select * from villa_guest where vg_id='$vg_id' ";
        $rep=mysql_query($sp) or die("Error $sp");
        $villa_guest =mysql_fetch_assoc($rep);
    }
}
if($_GET['action']=='add'){
    $action = 'add';
    $villa_guest['start']=date('Y-m-d');
    $villa_guest['end'] = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
}
/*
echo '<pre>';
print_r($villa_guest);
echo '</pre>';
exit;
*/
/*
$sqlQuery="SELECT * FROM villa WHERE villa_enable='Y' order by villa_name asc";
$re_sql=mysql_query($sqlQuery) or die("ERROR $sqlQuery");
while($r_sql=mysql_fetch_assoc($re_sql)){
	//villa_id 	villa_name 	villa_enable
	$villaDB[$r_sql['villa_id']]['villa_id'] = $r_sql['villa_id'];
	$villaDB[$r_sql['villa_id']]['villa_name'] = $r_sql['villa_name'];
	$villaDB[$r_sql['villa_id']]['villa_enable'] = $r_sql['villa_enable'];
}
*/
$sqlQuery="SELECT * FROM service_company ORDER BY sc_order";
$re_sql=mysql_query($sqlQuery) or die("ERROR $sqlQuery");
while($r_sql=mysql_fetch_assoc($re_sql)){
    $service_companyDB[$r_sql['sc_id']]['sc_title'] = $r_sql['sc_title'];
}

$sqlQuery="SELECT * FROM guest_type ORDER BY gt_order ";
$re_sql=mysql_query($sqlQuery) or die("ERROR $sqlQuery");
while($r_sql=mysql_fetch_assoc($re_sql)){
    $guest_typeDB[$r_sql['gt_id']]['gt_title'] = $r_sql['gt_title'];
}

$sqlQuery="SELECT * FROM guest_title ORDER BY g_title_order ";
$re_sql=mysql_query($sqlQuery) or die("ERROR $sqlQuery");
while($r_sql=mysql_fetch_assoc($re_sql)){
    $guest_titleDB[$r_sql['g_title_id']]['g_title_title'] = $r_sql['g_title_title'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>DGS : User Management</title>
    <meta name="robots" content="index,nofollow">
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom CSS -->
    <!-- 
    <link href="css/sb-admin.css" rel="stylesheet">
     -->
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Pagination -->
    <link rel="stylesheet" href="css/pagination.css">
    
    <!-- Date Picker CSS-->
    <link rel="stylesheet" href="css/bootstrap-datepicker3.min.css">
    
    
</head>
<body>
    <div id="wrapper">
    <!-- Navigation -->
        <? //include "menu.php"; ?>
    <!-- Main Data -->
        <div id="page-wrapper">

            <div class="container-fluid">

            <!-- Title Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php
                            if($_GET['action']=='add'){ echo 'Add Guest';}
                            if($_GET['action']=='edit'){ echo 'Edit Guest';}
                            ?>
                            <input type="button" onclick="location.href='logout.php';" name="logout" id="logout" value="Logout" class="btn btn-success pull-right">
                        </h1>
                    </div>
                </div>
            <!-- Add Admin -->
            		 <!-- start -->
            	<form action="p-add-villa-guest.php" role="form" method="post" enctype="multipart/form-data" id="sandbox-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                        <!-- Start Form -->
                            <div class="container-fluid">
								
                                <div class="col-lg-4"> 
									<div class="form-group">
                                        <label for="InputName">Villa</label>
                                        <select class="form-control" id="villa_id" name="villa_id" style="width: 200px;" required >
                                       	<?php 
                                       	foreach($villaUser as $key =>$value){
                                       		$villa_select = '';
                                            if($villa_guest['villa_id'] == $key){
                                                $villa_select = 'SELECTED';
                                            }
                                            ?>
                                      		<option value="<?=$value['villa_id'];?>" <?php echo $villa_select;?> >
                                       		<?=$value['villa_name'];?>
                                       		</option>
                                       		<?php 
                                       	}
                                       	?>
                                        </select>
									</div>
								</div>
								<div class="col-lg-4"> 
									<div class="form-group">
								    	<label for="InputName">Date Check-In</label>
                                       	<div class="input-daterange input-group" id="datepicker">
        									<input type="text" class="form-control" name="start" id="start" value="<?php echo convertDateDMYHyphen($villa_guest['start']);?>" />
        									<span class="input-group-addon">to</span>
        									<input type="text" class="form-control" name="end" id="end" value="<?php echo convertDateDMYHyphen($villa_guest['end']);?>" />
    									</div>
									</div>
								</div>
								<div class="col-lg-4"> 
									<div class="form-group">
                                        <label for="InputName">No. of nights</label>
                                        <input type="text" class="form-control" id="totaldays" name="totaldays" placeholder="No. of nights" value="<?php echo $villa_guest['totaldays'];?>">
									</div>
								</div>
																		<!-- REC #2  -->	
                                <div class="col-lg-3">  
                                   	<div class="form-group">
                                        <label for="InputName">Guest Title</label>
                                        <select class="form-control" id="g_title_id" name="g_title_id" style="width: 200px;"  >
                                       	<?php 
                                        foreach($guest_titleDB as $key =>$value){
                                            $guest_title_select = '';
                                            if($villa_guest['g_title_id'] == $key){
                                                $guest_title_select = 'SELECTED';
                                            }
                                            ?>
                                            <option value="<?=$key;?>" <?php echo $guest_title_select;?> >
                                            <?=$value['g_title_title'];?>
                                            </option>
                                            <?php 
                                        }
                                        ?>
                                       	</select>
									</div>
								</div>

                                <div class="col-lg-3">    
                                        <div class="form-group">
                                            <label for="GuestName">Guest Name</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="g_name" name="g_name" placeholder="Guest Name" value="<?php echo $villa_guest['g_name'];?>" required>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                                            </div>
                                        </div>
                                </div>
                                    
                                <div class="col-lg-3">    
                                        <div class="form-group">
                                            <label for="GuestName">Guest Middle Name</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="g_mid_name" name="g_mid_name" placeholder="Guest Middle Name" value="<?php echo $villa_guest['g_mid_name'];?>"  >
                                            </div>
                                        </div>
                                </div>
                                    
                                <div class="col-lg-3">    
                                        <div class="form-group">
                                            <label for="GuestName">Guest Surname</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="g_surname" name="g_surname" placeholder="Guest Surname" value="<?php echo $villa_guest['g_surname'];?>"  required>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                                            </div>
                                        </div>
                                </div>
                                    
                                <div class="col-lg-4">    
                                    <div class="form-group">
                                        <label for="GuestName">Guest Nationality</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="g_nationality" name="g_nationality" placeholder="Guest Nationality" value="<?php echo $villa_guest['g_nationality'];?>" required>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                                            </div>
                                    </div>
                                </div>
                                    
                                <div class="col-lg-4">    
                                        <div class="form-group">
                                            <label for="GuestName">Guest Passport ID.</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="g_passport_id" name="g_passport_id" placeholder="Guest Passport ID." value="<?php echo $villa_guest['g_passport_id'];?>" required>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                                            </div>
                                        </div>
                                </div>
                                    
                                <div class="col-lg-4">    
                                    <div class="form-group">
                                        <label for="GuestName">Guest Type</label>
                                        <div class="input-group">
                                            
                                            <select class="form-control" id="gt_id" name="gt_id" style="width: 200px;"  >
                                                <?php 
                                                foreach($guest_typeDB as $key =>$value){
                                                    $guest_type_select = '';
                                                    if($villa_guest['gt_id'] == $key){
                                                        $guest_type_select = 'SELECTED';
                                                    }
                                                    ?>
                                                    <option value="<?=$key;?>" <?php echo $guest_type_select;?> >
                                                    <?=$value['gt_title'];?>
                                                    </option>
                                                    <?php 
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                       <input type="submit" name="chkStatus" id="chkStatus" value="Check Package" class="btn btn-success left">
                                    </div>
                                </div>
                                
                            </div>
                        <!-- End Form -->
                        </div>
                    </div>
                </div>
            		 <!-- end -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                        <!-- Start Form -->
                            <div class="container-fluid">
                                
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="InputName">Villa Internet Status</label>
                                        <input type="text" class="form-control" id="internetStatus" name="internetStatus" value="">
                                            
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="InputName">Package</label>
                                        <input type="text" class="form-control" id="internetPackage" name="internetPackage" value="">
                                            
                                    </div>
                                </div>


                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="InputName">Start Date</label>
                                            <div class="input-group date">
                                                <input type='text' class="form-control" id="internetStart" name="internetStart" value="" />
                                                <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="InputName">Expire Date</label>
                                            <div class="input-group date">
                                                <input type='text' class="form-control" id="internetExpire" name="internetExpire" value="" />
                                                <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- End Form -->
                            </div>
                        </div>
                    </div>
            <!-- List Admin -->
            <!-- TV Package -->
                    <div class="row" >
                    <div class="col-lg-12" >
                        <div class="alert alert-info alert-dismissable" style="border-color: #FAFAD2;background-color: #FAFAD2;">
                        <!-- Start Form -->
                            <div class="container-fluid">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="InputName">Villa TV Status</label>
                                        <input type="text" class="form-control" id="tvStatus" name="tvStatus" value="">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="InputName">TV Package</label>
                                        <input type="text" class="form-control" id="tvPackage" name="tvPackage" value="">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="InputName">Start Date</label>
                                        <div class="input-group date">
                                                <input type="text" class="form-control" id="tvStart" name="tvStart" value=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="InputName">Expire Date</label>
                                        <div class="input-group date">
                                            <input type='text' class="form-control" id="tvExpire" name="tvExpire" value=""/>
                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" >
                        <div class="container-fluid">
                            <div class="col-lg-4">
                                <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success">
                                
                                <input type="button"  onclick="location.href='villa-guest-list.php';" name="cancel" id="cancel" value="Cancel" class="btn btn-warning" style="border-color: #bdc3c7 ;background-color: #bdc3c7 ;">
                            </div>
                            
                        </div>
                    </div>
                </div>
                <input type="hidden" name="action" id="action" value="<?php echo $action;?>">
                <input type="hidden" name="vg_id" id="vg_id" value="<?php echo $vg_id;?>">
                </form>
                <?php 
                //include 'villa-guest-list.php';
                ?>
            </div>
            <!-- END container-fluid -->
        </div>
        <!-- END page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- JS Date Picker-->
    <script src="js/bootstrap-datepicker.js"></script>
    <script>
    
		function days(){
			var tmp_start = $("#start").val();
			var parts = tmp_start.split('-');
			var start = parts[1]+'/'+parts[0]+'/'+parts[2];
			var start_date = new Date(start);

			var tmp_end = $("#end").val();
			var parts = tmp_end.split('-');
			var end = parts[1]+'/'+parts[0]+'/'+parts[2];
			var end_date = new Date(end);

			var a = new Date(start_date),
		       b = new Date(end_date),
		      c = 24*60*60*1000,
		      diffDays = Math.round(Math.abs((a - b)/(c)));
		      $("#totaldays").val(diffDays);
			
		}
		
		</script>
    <script>
    $('#sandbox-container .input-daterange').datepicker({
    	format: "dd-mm-yyyy",
        autoclose: true
    })
    .on('changeDate', function(ev){
    	days();
      $(this).datepicker('hide').blur();
});
    </script>
    <script>
    $(document).ready(function(){
        $("#chkStatus").click(function(){
            var villa_id = $("#villa_id").val();
            var start = $("#start").val();
            var end = $("#end").val();
            var dataString = 'villa_id='+ villa_id + '&start='+ start + '&end='+ end;
            // AJAX Code To Submit Form.
            if(villa_id=='' || start=='' || end=='' ){
                alert('Please input Villa Id, Date Check-In and Check-Out');
            }else{
                $.ajax({
                    type: "POST",
                    url: "villa-guest-status.php",
                    data: dataString,
                    cache: false,
                    success: function(result){
                        var result = result.split("|");
                        var internetStatus  = result[0];
                        var internetPackage = result[1];
                        var internetStart   = result[2];
                        var internetExpire   = result[3];

                        var tvStatus  = result[4];
                        var tvPackage = result[5];
                        var tvStart   = result[6];
                        var tvExpire   = result[7];

                        $("#internetStatus").val( internetStatus );
                        $("#internetPackage").val( internetPackage );
                        $("#internetStart").val( internetStart );
                        $("#internetExpire").val( internetExpire );

                        $("#tvStatus").val( tvStatus );
                        $("#tvPackage").val( tvPackage );
                        $("#tvStart").val( tvStart );
                        $("#tvExpire").val( tvExpire );
                        
                        if(internetStatus.trim()=='Expired'){
                            document.getElementById("internetStatus").style.color = "#ff0000";
                        }else{
                            document.getElementById("internetStatus").style.color = "#555555";
                        }
                        if(tvStatus=='Expired'){
                            document.getElementById("tvStatus").style.color = "#ff0000";
                        }else{
                            document.getElementById("tvStatus").style.color = "#555555";
                        }
                    }
                });
                return false;
            }
        });
    });
    </script>    
</body>
</html>
