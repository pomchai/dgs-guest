<?
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
		$sql_where_txt = 'WHERE '.$sql_where;
		$sql_where_txt = substr($sql_where_txt,0,-4);
		
		$villa_guest_sqlQuery="SELECT * FROM `villa_guest` ".$sql_where_txt." ";

	}else{
		?>
		<script language="JavaScript">
		alert("ขออภัยครับ ข้อมูลผู้ใช้ไม่มี Villa ให้จัดการ");
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
    //villa_id  villa_name  villa_enable
    $villaDB[$r_sql['villa_id']]['villa_id'] = $r_sql['villa_id'];
    $villaDB[$r_sql['villa_id']]['sc_id'] = $r_sql['sc_id'];
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
    <title>Admin Panel : ระบบจัดการข้อมูลผู้เข้าพัก</title>
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
                            Guest Check-in
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <input type="button" onclick="location.href='villa-guest.php?action=add';" name="add" id="add" value="Add" class="btn btn-success">
                                <!--
                                <h3 class="panel-title">ข้อมูลผู้เพัก</h3>
                                
                                -->
                                <input type="button" onclick="location.href='logout.php';" name="logout" id="logout" value="Logout" class="btn btn-success pull-right">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width:5%;">#</th>
                                                <th style="width:13%;">Check-In</th>
                                                <th style="width:13%;">Check-Out</th>
                                                <th style="width:7%;">Villa</th>
                                                <th style="width:27%;">Guest</th>
                                                <th style="width:15%;">Service Company</th>
                                                <th style="width:10%;">Show Password</th>
                                                <th style="width:10%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?
                                            include "function/pagination.php";
                                            //$strSQL = "SELECT * FROM `villa_guest` WHERE 1=1 ";
                                            //echo $strSQL;
                                            
                                            $objQuery = mysql_query($villa_guest_sqlQuery);
                                            $Num_Rows = mysql_num_rows($objQuery);

                                            $Per_Page = 10;   // Per Page

                                            $Page = $_GET["Page"];
                                            if(!$_GET["Page"])
                                            {
                                                $Page=1;
                                            }

                                            $Prev_Page = $Page-1;
                                            $Next_Page = $Page+1;

                                            $Page_Start = (($Per_Page*$Page)-$Per_Page);
                                            if($Num_Rows<=$Per_Page)
                                            {
                                                $Num_Pages =1;
                                            }
                                            else if(($Num_Rows % $Per_Page)==0)
                                            {
                                                $Num_Pages =($Num_Rows/$Per_Page) ;
                                            }
                                            else
                                            {
                                                $Num_Pages =($Num_Rows/$Per_Page)+1;
                                                $Num_Pages = (int)$Num_Pages;
                                            }
                                            $villa_guest_sqlQuery.=" ORDER BY vg_id DESC LIMIT $Page_Start , $Per_Page";
                                            $objQuery=mysql_query($villa_guest_sqlQuery);
                                            $i = 0;
                                            while($objResult=mysql_fetch_assoc($objQuery)){
                                                $i++;
                                        ?>
                                            <tr>
                                                <td >
                                                    <?php echo $i;?>
                                                </td>
                                                <td >
                                                    <?php echo convertDateM3char($objResult['start'])
                                                    ?>
                                                </td>
                                                <td >
                                                    <?php 
                                                        echo convertDateM3char($objResult['end']);
                                                    ?>
                                                </td>
                                                <td >
                                                    <?php 
                                                    echo $villaDB[$objResult['villa_id']]['villa_name'];
                                                    ?>
                                                </td>
                                                <td >
                                                    <?php 
                                                    echo $objResult['g_name'].' '.$objResult['g_mid_name'].' '.$objResult['g_surname'];
                                                    ?>
                                                        
                                                </td>
                                                <td >
                                                    <?php 
                                                    echo $service_companyDB[$villaDB[$objResult['villa_id']]['sc_id']]['sc_title'];
                                                    //echo $service_companyDB[$objResult['sc_id']]['sc_title'];
                                                    ?>
                                                        
                                                </td>
                                                <td >
                                                    <?php 
                                                    echo '';
                                                    ?>
                                                        
                                                </td>
                                                <td >
                                                    <a href="villa-guest.php?vg_id=<?=$objResult['vg_id'];?>&action=edit" class="label label-success">Edit</a>
                                                    <a href="del-villa-guest.php?vg_id=<?=$objResult['vg_id'];?>" class="label label-danger" onclick="javascript:if(!confirm('ท่านต้องการลบข้อมูลจริงหรือไม่')){return false;}">Delete</a>
                                                </td>
                                            </tr>
                                        <? } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 text-center">
                        <?
                            $pages = new Paginator;
                            $pages->items_total = $Num_Rows;
                            $pages->mid_range = 20;
                            $pages->current_page = $Page;
                            $pages->default_ipp = $Per_Page;
                            $pages->url_next = $_SERVER["PHP_SELF"]."?QueryString=value&Page=";

                            $pages->paginate();

                            echo $pages->display_pages()
                        ?>
                    </div>
                </div>

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
     
</body>
</html>