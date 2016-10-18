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
session_destroy();
echo "<meta http-equiv=refresh content=0;URL=index.php>";
?>
</body>
</html>