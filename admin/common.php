<?php 
//ob_start();
date_default_timezone_set('Asia/Kuala_Lumpur');
error_reporting (E_ALL ^ E_NOTICE);
require_once('adodb.inc.php');
require_once 'include/dateformat.php';
//require_once('include/color.php');
//require_once('lang/lang.php');
require_once('common_func.php');
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$start = $time;

$sistem = 'Portal I-TIS V2';
$data=isset($_REQUEST["data"])?$_REQUEST["data"]:"";
//print $data;
if(!empty($data)){
	$datas = base64_decode($data);
	//print_r($datas); //1;user;kursus/ref_unit_list.php;kursus;unit;kursus;Pusat / Unit;
	$get_data = explode(";", $datas);
	if(!empty($get_data[0])){ $userid = $get_data[0]; } else { $userid=''; }// piece2
	if(!empty($get_data[1])){ $pages = $get_data[1]; } else { $pages=''; }// piece2
	if(!empty($get_data[2])){ $menus = $get_data[2]; } else { $menus=''; }// piece2
	if(!empty($get_data[3])){ $submenus = $get_data[3]; } else { $submenus=''; }// piece2
	if(!empty($get_data[4])){ $id = $get_data[4]; } else { $id=''; }// piece2
	$pages = str_replace(".php","",$pages);

	$_SESSION["s_userid"]=$userid;
	// var_dump($userid);
	// var_dump($pages);

} else {
	$_SESSION["s_userid"]='';
	//$page='login_form.php';
}
//if(!empty($data)){
// var_dump($pages); die();
$UID='';
if(isset($_SESSION['s_userid'])){ $UID = $_SESSION["s_userid"]; }	
if(!empty($_SESSION["s_userid"])){
	// TO CHECK PAGES
	echo '<font color="#fff" style="padding-left:500px;">USER:'.$userid.';PAGES:'.$pages.';MENU:'.$imenusds.';SUBMENU:'.$submenus.';IDS:'.$ids.'level:'.($_SESSION["s_level"]).'</font>';
	//print '<br>UID:'.$_SESSION["SESS_UserID"];
}
if(!empty($menus)){ $_SESSION['menu']=$menus; }
else { $menus=$_SESSION['menu']; }

$ip = $_SERVER['HTTP_HOST'];
//print $ip;
/*if($ip=='localhost'){
	$array = file("include\dbconn.inc");
	$DB_dbtype="mysqli"; 
} else {
//	$array = file("/var/www/html/simpeni/include/dbconn.inc");
	$array = file("include/dbconn.inc");
	$DB_dbtype="mysqli"; 
}
//$array = file("/opt/dbconn.inc");
foreach($array as $row) {
  // $line = explode(",", $row);
  $line = explode(",",$row);
   //print "Name: $line[0], Email: $line[1]<br>";
   $line[0];
   $line[1];
   $line[2];
   $line[3];
}
$db=$line[0];
$users=$line[1];
$pwd=$line[2];
$hosts=$line[3];*/


//$DB_hostname=$hosts; $DB_username=$users; $DB_password=$pwd; $DB_dbname=$db;
if($ip=='localhost'){
	$DB_dbtype="mysqli"; $DB_hostname="localhost"; $DB_username="root"; $DB_password=""; $DB_dbname="db_itis";
} else {
	//$DB_dbtype="mysqli"; $DB_hostname="localhost"; $DB_username="root"; $DB_password="4pp52itis"; $DB_dbname="itis";
	$DB_dbtype="mysqli"; $DB_hostname="dbprod"; $DB_username="itis"; $DB_password="kioio&*(6uhwdihui&%hgui908"; $DB_dbname="db_itis";

}
//print $DB_hostname."/".$DB_username."/".$DB_password."/".$DB_dbname;
//$conn->debug=1;
$conn = &ADONEWConnection($DB_dbtype);
$conn->Pconnect($DB_hostname, $DB_username, $DB_password, $DB_dbname);
// var_dump($conn);

//$path_doc='var/www/html/eparlimen/doc/';

?>