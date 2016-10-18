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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>DGS : User Management</title>
    <meta name="robots" content="index,nofollow">
</head>
<body>
<?
/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
exit;
*/

$vg_id		=	htmlspecialchars($_POST[vg_id]);
$villa_id	=	htmlspecialchars($_POST[villa_id]);
$start		=	convertDateYMDHyphen($_POST[start]);
$end		=	convertDateYMDHyphen($_POST[end]);
$totaldays	=	htmlspecialchars($_POST[totaldays]);
$g_title_id	=	htmlspecialchars($_POST[g_title_id]);
$g_name		=	htmlspecialchars($_POST[g_name]);
$g_mid_name	=	htmlspecialchars($_POST[g_mid_name]);
$g_surname		=	htmlspecialchars($_POST[g_surname]);
$g_nationality	=	htmlspecialchars($_POST[g_nationality]);
$g_passport_id	=	htmlspecialchars($_POST[g_passport_id]);
$gt_id	=	htmlspecialchars($_POST[gt_id]);
$date=date("Y-m-d");

if($villa_id!=""){
	
	if($_POST['action'] == 'add'){
		$insert_member=mysql_query("INSERT INTO `villa_guest` (`villa_id` 
			,`start`,`end`,	`totaldays`,`g_title_id`,
			`g_name`,`g_mid_name` ,	`g_surname`,`g_nationality`,
			`g_passport_id`,`gt_id`)VALUES ('$villa_id', '$start', '$end', '$totaldays', '$g_title_id', '$g_name', '$g_mid_name', '$g_surname', '$g_nationality', '$g_passport_id', '$gt_id')") or die ("ERROR $insert_member");
		mysql_close();
		echo "<meta http-equiv='refresh' content='0;url=villa-guest-list.php'>"; 	
	}
	if($_POST['action'] == 'edit'){
	    $update_member=mysql_query("UPDATE `villa_guest` SET `villa_id`='$villa_id' 
	    	,`start`='$start' 
	    	,`end`='$end'
	    	,`totaldays`='$totaldays'
	    	,`g_title_id`='$g_title_id'
	    	,`g_name`='$g_name'
	    	,`g_mid_name`='$g_mid_name'
	    	,`g_surname`='$g_surname'
	    	,`g_nationality`='$g_nationality'
	    	,`g_passport_id`='$g_passport_id'
	    	,`gt_id`='$gt_id' WHERE vg_id='$vg_id'") or die ("ERROR update_member");
		mysql_close();
		//echo "<meta http-equiv='refresh' content='0;url=edit-admin.php?u_id=$u_id'>"; 
		echo "<meta http-equiv='refresh' content='0;url=villa-guest-list.php'>"; 
	}
}else{
	?>
	<script language="JavaScript"> 	
	alert('Sorry, you can not fill it.'); 	
	history.back();
	</script> 
	<?php
}
?>
</body>
</html>