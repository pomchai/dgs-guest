<?
error_reporting( error_reporting() & ~E_NOTICE );
session_start();
include "inc/config.inc.php";
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
$vg_id=$_POST[vg_id];
$villa_id	=	htmlspecialchars($_POST[villa_id]);
$vg_name	=	htmlspecialchars($_POST[vg_name]);
$vg_visa	=	htmlspecialchars($_POST[vg_visa]);

$date=date("Y-m-d");

if($villa_id!="" && $vg_name!=""){
	$update_member=mysql_query("UPDATE `villa_guest` SET `villa_id`='$villa_id' ,`vg_name`='$vg_name',`vg_visa`='$vg_visa'  WHERE vg_id='$vg_id'") or die ("ERROR update_villa_guest");
	
	mysql_close();
	//echo "<meta http-equiv='refresh' content='0;url=edit-admin.php?u_id=$u_id'>"; 
	echo "<meta http-equiv='refresh' content='0;url=villa-guest.php'>";
}else{
?>
<script language="JavaScript"> 	
	alert('Sorry, you can not fill it.'); 	
	history.back();
</script> 
<?
}
?>
</body>
</html>