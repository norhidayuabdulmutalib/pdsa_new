<?php 
//ob_start();
@session_start();
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
} else {
	$_SESSION["s_userid"]='';
	//$page='login_form.php';
}
//if(!empty($data)){
$UID='';
if(isset($_SESSION['s_userid'])){ $UID = $_SESSION["s_userid"]; }	
if(!empty($_SESSION["s_userid"])){
	// TO CHECK PAGES
	echo '<font color="#000000">USER:'.$userid.';PAGES:'.$pages.';MENU:'.$imenusds.';SUBMENU:'.$submenus.';IDS:'.$ids.'</font>';
	//print '<br>UID:'.$_SESSION["SESS_UserID"];
}
if(!empty($menus)){ $_SESSION['menu']=$menus; }
else { $menus=$_SESSION['menu']; }

$ip = $_SERVER['HTTP_HOST'];
//print $ip;


$DB_dbtype="mysqli"; $DB_hostname="jakimdb"; $DB_username="itis"; $DB_password="kioio&*(6uhwdihui&%hgui908"; $DB_dbname="itis";

//print $DB_hostname."/".$DB_username."/".$DB_password."/".$DB_dbname;
//$conn->debug=1;
$conn = &ADONEWConnection($DB_dbtype);
$conn->Pconnect($DB_hostname, $DB_username, $DB_password, $DB_dbname);

//$path_doc='var/www/html/eparlimen/doc/';

?>