<?
/*xxx */
error_reporting( error_reporting() & ~E_NOTICE );
/*yyyy*/
session_start();
include "../inc/config.inc.php";
//echo "$_SESSION[m_login]<br>$_SESSION[m_id]";
if(!isset($_SESSION[admin_login])) {
echo "<meta http-equiv='refresh' content='0;url=index.php'>" ; 
exit() ;
}
$vg_id=$_GET[vg_id];
$sp="select `villa_id`, `vg_name`, `vg_visa` from villa_guest where vg_id='$vg_id' ";
$rep=mysql_query($sp) or die("Error $sp");
$villa_guestDB	=	mysql_fetch_assoc($rep);

$sqlQuery="SELECT * FROM owner WHERE owner_enable='Y' order by owner_name asc";
$re_owner=mysql_query($sqlQuery) or die("ERROR $sqlQuery");
while($r_owner=mysql_fetch_assoc($re_owner)){
	//owner_id 	owner_name 	owner_pass 	owner_email 	owner_enable
	$ownerDB[$r_owner['owner_id']]['owner_id'] = $r_owner['owner_id'];
	$ownerDB[$r_owner['owner_id']]['owner_name'] = $r_owner['owner_name'];
	$ownerDB[$r_owner['owner_id']]['owner_pass'] = $r_owner['owner_pass'];
	$ownerDB[$r_owner['owner_id']]['owner_email'] = $r_owner['owner_email'];
	$ownerDB[$r_owner['owner_id']]['owner_enable'] = $r_owner['owner_enable'];
}

$sqlQuery="SELECT * FROM villa WHERE villa_enable='Y' order by villa_name asc";
$re_sql=mysql_query($sqlQuery) or die("ERROR $sqlQuery");
while($r_sql=mysql_fetch_assoc($re_sql)){
	//villa_id 	villa_name 	villa_enable
	$villaDB[$r_sql['villa_id']]['villa_id'] = $r_sql['villa_id'];
	$villaDB[$r_sql['villa_id']]['villa_name'] = $r_sql['villa_name'];
	$villaDB[$r_sql['villa_id']]['villa_enable'] = $r_sql['villa_enable'];
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
    <link href="css/sb-admin.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Pagination -->
    <link rel="stylesheet" href="css/pagination.css">
</head>
<body>
    <div id="wrapper">
    <!-- Navigation -->
        <? include "menu.php"; ?>
    <!-- Main Data -->
        <div id="page-wrapper">

            <div class="container-fluid">

            <!-- Title Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Edit 
                        </h1>
                    </div>
                </div>
            <!-- Add Admin -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                        <!-- Start Form -->
                            <div class="container-fluid">
                                <form action="p-edit-villa-guest.php" role="form" method="post" enctype="multipart/form-data">
                                    <div class="col-lg-6">
                                    		<div class="form-group">
                                            <label for="InputName">Villa</label>
                                            <input type="hidden" class="form-control" name="vg_id" id="vg_id" value="<?=$vg_id;?>" />
                                            <select class="form-control" id="villa_id" name="villa_id" style="width: 200px;" required >
                                            	<?php 
                                            	foreach($villaDB as $key =>$value){
                                            		$villa_id_select='';
                                            		if($villa_guestDB['villa_id']==$key){$villa_id_select='selected';}
                                            		?>
                                            			<option value="<?=$value['villa_id'];?>" <?php echo $villa_id_select;?> ><?=$value['villa_name'];?></option>
                                            	  <?php 
                                            	  }
                                            	  ?>                                            	
																						</select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="GuestName">Guest Name</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="vg_name" name="vg_name" value="<?php echo $villa_guestDB['vg_name'];?>" placeholder="Guest Name" required>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="GuestName">Visa</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="vg_visa" name="vg_visa" value="<?php echo $villa_guestDB['vg_visa'];?>" placeholder="Visa" required>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                                            </div>
                                        </div>
                                        
                                        
                                        <input type="submit" name="submit" id="submit" value="บันทึกข้อมูล" class="btn btn-success pull-right">
                                    </div>
                                </form>
                            </div>
                        <!-- End Form -->
                        </div>
                    </div>
                </div>
            <!-- List Admin -->
                <?php 
                include "villa-guest-list.php";
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
    <script type="text/javascript">
        $(function(){
            
            // เมื่อเปลี่ยนค่าของ select id เท่ากับ list1
             $("select#province_id").change(function(){  
                 // ส่งค่า ตัวแปร list1 มีค่าเท่ากับค่าที่เลือก ส่งแบบ get ไปที่ไฟล์ data_for_list2.php
                 $.get("data_for_list2.php",{
                     province_id:$(this).val()
                 },function(data){ // คืนค่ากลับมา
                        $("select#amphur_id").html(data);  // นำค่าที่ได้ไปใส่ใน select id เท่ากับ list2      
                        $("select#amphur_id").trigger("change"); // อัพเดท list2 เพื่อให้ list2 ทำงานสำหรับรีเซ็ตค่า
                 });
            });          
            
        });
    </script> 
</body>
</html>
