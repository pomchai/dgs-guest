<?
error_reporting( error_reporting() & ~E_NOTICE );
session_start();
include "../inc/config.inc.php";
//echo "$_SESSION[m_login]<br>$_SESSION[m_id]";
if(!isset($_SESSION[admin_login])) {
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
$vg_id=$_GET[vg_id];

//select id property_post
//del admin
$sql=mysql_query("delete from villa_guest where vg_id='$vg_id'")or die("ERROR $sql");

mysql_close();
echo "<meta http-equiv='refresh' content='0;url=villa-guest.php'>"; 
?>
</body>
</html>