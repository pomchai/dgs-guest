<?php
/* by Aeh */
/*
$name2=$_POST['villa_id'];
$start=$_POST['start'];
$end=$_POST['end'];

$internetStatus='Ready';
$internetPackage='3 Months';
$internetStart='01-10-2016';
$internetExpire='31-12-2016';
$internetSend=$internetStatus.'|'.$internetPackage.'|'.$internetStart.'|'.$internetExpire;

$tvStatus='Expired';
$tvPackage='3 Months';
$tvStart='01-10-2016';
$tvExpire='31-12-2016'; 
*/
error_reporting( error_reporting() & ~E_NOTICE );
session_start();
include "inc/config.inc.php";
include "function/function.php";

//echo "$_SESSION[m_login]<br>$_SESSION[m_id]";
if(!isset($_SESSION[user_login])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'>" ; 
    exit() ;
}

$villa_id=$_POST['villa_id'];
$start=$_POST['start'];
$end=$_POST['end'];

$sqlQuery="SELECT * FROM villa_package WHERE villa_id='$villa_id' ";
$re_sql=mysql_query($sqlQuery) or die("ERROR $sqlQuery");
while($r_sql=mysql_fetch_assoc($re_sql)){
    $sc_id      = $r_sql['sc_id'];
    $pi_id      = $r_sql['pi_id'];
    $pi_start   = convertDateDMYHyphen($r_sql['pi_start']);
    $pi_start_t   = $r_sql['pi_start'];
    $pi_expire  = convertDateDMYHyphen($r_sql['pi_expire']);
    $pi_expire_t   = $r_sql['pi_expire'];
    
    $pt_id      = $r_sql['pt_id'];
    $pt_start   = convertDateDMYHyphen($r_sql['pt_start']);
    $pt_start_t   = $r_sql['pt_start'];
    $pt_expire  = convertDateDMYHyphen($r_sql['pt_expire']);
    $pt_expire_t = $r_sql['pt_expire'];
}

$start_date = convertDateYMDHyphen($start);

$end_date = convertDateYMDHyphen($end);

//$date_from_user = '2009-08-28';
$result_1   = check_in_range($pi_start_t, $pi_expire_t, $start_date);
$result_2   = check_in_range($pi_start_t, $pi_expire_t, $end_date);

$result_3   = check_in_range($pt_start_t, $pt_expire_t, $start_date);
$result_4   = check_in_range($pt_start_t, $pt_expire_t, $end_date);

$pi_result = $result_1+$result_2;
$pt_result = $result_3+$result_4;

$text1 = $pi_start_t.' + '.$pi_expire_t.' + '.$start_date.' + '.$end_date.' + '.$pi_result;
$text2 = $pt_start_t.' + '.$pt_expire_t.' + '.$start_date.' + '.$end_date.' + '.$pt_result;
//echo $start_date.' + '.$end_date.' + '.$pi_start_t.' + '.$pi_expire_t.' + '.$first+$second;
//echo $text1.' ==> '.$text2;
//exit;

if($pi_result==2){
    $internetStatus='Ready';
}else{
    $internetStatus='Expired';
}

$sqlQuery="SELECT * FROM package_internet WHERE pi_id='$pi_id' ";
$re_sql=mysql_query($sqlQuery) or die("ERROR $sqlQuery");
while($r_sql=mysql_fetch_assoc($re_sql)){
    $pi_title = $r_sql['pi_title'];
}
$internetSend=$internetStatus.'|'.$pi_title.'|'.$pi_start.'|'.$pi_expire;

$sqlQuery="SELECT * FROM package_tv WHERE pt_id='$pt_id' ";
$re_sql=mysql_query($sqlQuery) or die("ERROR $sqlQuery");
while($r_sql=mysql_fetch_assoc($re_sql)){
    $pt_title = $r_sql['pt_title'];
}
if($pt_result==2){
    $tvStatus='Ready';
}else{
    $tvStatus='Expired';
}


$tvSend=$tvStatus.'|'.$pt_title.'|'.$pt_start.'|'.$pt_expire; 
echo $internetSend.'|'.$tvSend;
?>
