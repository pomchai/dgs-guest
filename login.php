<?
error_reporting( error_reporting() & ~E_NOTICE );
session_start();
include "inc/config.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>DGS : User Management</title>
</head>
<body>	
<?
$email=mysql_real_escape_string(addslashes($_POST[email]));
$pass=mysql_real_escape_string(addslashes($_POST[pass]));
//$s="SELECT id, name FROM `member` WHERE email='$email' AND pass='$pass' AND type=1";
$s="SELECT u_id, u_name FROM `dgs_user` WHERE u_email='$email' AND u_pass='$pass' AND u_enable='Y'";
$re=mysql_query($s) or die("ERROR $s");
$num=mysql_num_rows($re);

if($num<=0){
?>
	<script language="JavaScript"> 	
		alert("Sorry, your user does not exist in system."); 	
		window.location = 'index.php'; 
	</script> 
<?
}else{
$r=mysql_fetch_assoc($re);
$_SESSION[user_login]="user_login";
$_SESSION[m_id]=$r['u_id'];
$_SESSION[m_name]=$r['u_name'];

mysql_close();
//echo "<meta http-equiv=refresh content=0;URL=data.php>"; 
echo "<meta http-equiv=refresh content=0;URL=villa-guest-list.php>";
}
?>
</body>
</html>