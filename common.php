<?php
date_default_timezone_set('UTC');
@session_start();
error_reporting (E_ALL ^ E_NOTICE);
require_once('adodb.inc.php');
require_once 'include/dateformat.php';
require_once('include/color.php');

$ip = $_SERVER['HTTP_HOST'];
//define("DATABASE_NAME","moste");
//define("DATABASE_USER","root");
//define("DATABASE_PASSWORD","");
//define("DATABASE_HOST","localhost");
// ====== START DATABASE CONFIG =======
//ODBC_MSSQL
if($ip=='localhost'){
	$DB_dbtype="mysql"; $DB_hostname="localhost"; $DB_username="root"; $DB_password="root"; $DB_dbname="db_itis";
} else {
	$DB_dbtype="mysqli"; $DB_hostname="dbprod"; $DB_username="itis"; $DB_password="kioio&*(6uhwdihui&%hgui908"; $DB_dbname="itis";
}

// ====== END DATABASE CONFIG ======

//$conn = &ADONewConnection("mysql");  // create a connection
////$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
//$conn->debug=1;
//$conn->PConnect("localhost", "root", "", "test"); // connect to MySQL, testdb

//$conn->debug=1;
$conn = &ADONEWConnection($DB_dbtype);
$conn->Pconnect($DB_hostname, $DB_username, $DB_password, $DB_dbname);


function tohtml($strValue)
{
  return htmlspecialchars($strValue);
}

function tourl($strValue)
{
  return urlencode($strValue);
}

function get_param($ParamName)
{
  global $HTTP_POST_VARS;
  global $HTTP_GET_VARS;

  $ParamValue = "";
  if(isset($HTTP_POST_VARS[$ParamName]))
    $ParamValue = $HTTP_POST_VARS[$ParamName];
  else if(isset($HTTP_GET_VARS[$ParamName]))
    $ParamValue = $HTTP_GET_VARS[$ParamName];

  return $ParamValue;
}

function get_session($ParamName)
{
  global $HTTP_POST_VARS;
  global $HTTP_GET_VARS;
  global ${$ParamName};
  $ParamValue = "";
  if(!isset($HTTP_POST_VARS[$ParamName]) && !isset($HTTP_GET_VARS[$ParamName]) && session_is_registered($ParamName))
     $ParamValue = ${$ParamName};
  return $ParamValue;
}

function set_session($ParamName, $ParamValue)
{
  global ${$ParamName};
  if(session_is_registered($ParamName)) 
    session_unregister($ParamName);
  ${$ParamName} = $ParamValue;
  session_register($ParamName);
}

function is_number($string_value)
{
  if(is_numeric($string_value) || !strlen($string_value))
    return true;
  else 
    return false;
}

function is_param($param_value)
{
  if($param_value)
    return 1;
  else
    return 0;
}

function tosql($value, $type="Text")
{
  if($value == "")
  {
    return "NULL";
  }
  else
  {
    if($type == "Number")
      return doubleval($value);
    else
    {
      // if(get_magic_quotes_gpc() == 0)
      // {
      //   $value = str_replace("'","''",$value);
      //   $value = str_replace("\\","\\\\",$value);
      // }
      // else
      {
        $value = str_replace("\\'","''",$value);
        $value = str_replace("\\\"","\"",$value);
      }
      return "'" . $value . "'";
     }
   }
}

function strip($value)
{
  if(get_magic_quotes_gpc() == 0)
    return $value;
  else
    return stripslashes($value);
}

function get_checkbox_value($sVal, $CheckedValue, $UnCheckedValue)
{
  if(!strlen($sVal))
    return tosql($UnCheckedValue);
  else
    return tosql($CheckedValue);
}

function dlookup($Table, $fName, $sWhere)
{
  global $conn;
  $sSQL = "";
  
  $sSQL = "SELECT " . $fName . " FROM " . $Table . " WHERE " . $sWhere;
  //echo $sSQL;
  $rs2 = &$conn->Execute($sSQL);
  if ($rs2) {
    //$_SESSION["s_group"] = $rs2->fields($fName);
    return $rs2->fields($fName);
  }
  else 
    return "";
}

function dlookup_cnt($Table, $fName, $sWhere)
{
  global $conn;
  $sSQL = "";
  
  $sSQL = "SELECT " . $fName . " FROM " . $Table . " WHERE " . $sWhere;
  //echo $sSQL;
  $rs2 = &$conn->Execute($sSQL);
  return $rs2->recordcount();
}

function dlookupid($Table, $fName, $id, $sWhere)
{
  global $conn;
  $sSQL = "";
  
  $sSQL = "SELECT " . $fName . " FROM " . $Table . " WHERE " . $id ."=" . $sWhere;
  //echo $sSQL;
  $rs2 = &$conn->Execute($sSQL);
  if ($rs2) {
    $_SESSION["s_group"] = $rs2->fields($fName);
    return $rs2->fields($fName);
  }
  else 
    return "";
}

function dlookup2($Table, $fName1, $fName2, $sWhere)
{
  global $conn;
  $sSQL = "";
  
  $sSQL = "SELECT " . $fName1 . ", " . $fName2 . " FROM " . $Table . " WHERE " . $sWhere;
  //echo $sSQL;
  $rs2 = &$conn->Execute($sSQL);
  if ($rs2) {
	  $data = "".$rs2->fields($fName1)."" . " [ ".$rs2->fields($fName2)." ]" ;
   	  return $data;
  }
  else 
    return "";
}

function audit_trail($remarks){
	global $conn;
	$sSQL = "";
	$sid = $_SESSION["s_userid"];
	$user = $_SESSION["s_logid"];
	$ip = $_SERVER['REMOTE_ADDR'];

	$sSQL = "INSERT INTO auditrail(id_user, log_user, ip, remarks, trans_date) 
	VALUES('".$sid."', '".$user."', '".$ip."', '".addslashes($remarks)."', '".date("Y-m-d H:i:s")."')";
	$conn->Execute($sSQL);
}

function audit_log($remarks,$type,$users, $pro){
	global $conn;
	$sSQL = "";
	$sid = $_SESSION["s_userid"];
	$user = $_SESSION["s_logid"];
	$ip = $_SERVER['REMOTE_ADDR'];
	
	if($pro=='ERR'){ $user = $users; }
	$time = date("Y-m-d H:i:s");

	$rs = &$conn->execute("SELECT * FROM auditlog WHERE log_user=".tosql($user)." AND trans_date=".tosql($time));
	if($rs->EOF){
		$sSQLLog = "INSERT INTO auditlog(id_user, log_user, ip, type, remarks, trans_date) 
		VALUES('".$sid."', '".$user."', '".$ip."', '".$type."', '".addslashes($remarks)."', '".$time."')";
		$conn->Execute($sSQLLog);
	}
}

function set_pg($Page)
{
  $Page = 30;
  global ${$Page};
}

function get_pg()
{
  $Page = 30;
  global ${$Page};
  return;
}


//-------------------------------
// Verify user's security level and redirect to login page if needed
//-------------------------------

function check_security($security_level)
{
  global $UserRights;
  if(!session_is_registered("UserID"))
  {
    header ("Location: default.php?querystring=" . urlencode(getenv("QUERY_STRING")) . "&ret_page=" . urlencode(getenv("REQUEST_URI")));
    exit;
  }
//  else
//    if(get_session("UserRights") != "00")
//    {
//      header ("Location: default.php?querystring=" . urlencode(getenv("QUERY_STRING")) . "&ret_page=" . urlencode(getenv("REQUEST_URI")));
//      exit;
//    }
}

//===============================
//  GlobalFuncs begin
//function get_config($var)
//{
//  if (! dlookup("config","count(*)","config_variable='$var'")) {

//  Create if doesn't exist
//    $db = new DB_Sql();
//    $db->Database = DATABASE_NAME;
//    $db->User     = DATABASE_USER;
//    $db->Password = DATABASE_PASSWORD;
//    $db->Host     = DATABASE_HOST;
//    $db->query("INSERT INTO config (config_variable) VALUES (" . ToSQL($var,"Text") . ")");
//  }
//  return dlookup("config","config_value","config_variable='$var'");
//}

function now()
{
  return date("Y-m-d G:i:s");
}

function vdate($ldate)
{
  $ldate = str_replace(":","-",$ldate);
  $ldate = str_replace(" ","-",$ldate);
  list ($year, $month, $day, $hour, $minute) = explode("-", $ldate);
  if ($newdate = mktime ($hour, $minute, 0, $month, $day, $year)) {
    if (@date("H-i", $newdate) == "00-00")
      return @date("m/d/y", $newdate);
    else
      return @date("m/d/y h:i A", $newdate);
  }
}

function sdate($ldate)
{
  list ($year, $month, $day, $hour, $minute) = explode("-", $ldate);
  $newdate = mktime (0, 0, 0, $month, $day, $year);
  return date("m/d/Y", $newdate);
}
function yy($ldate)
{
  list ($day, $month, $year, $hour, $minute) = explode("-", $ldate);
  $newdate = mktime (0, 0, 0, $month, $day, $year);
  return date("Y", $newdate);
}
function ndate($ldate)
{
  list ($day, $month, $year, $hour, $minute) = explode("-", $ldate);
  $newdate = mktime (0, 0, 0, $month, $day, $year);
//  return date("Y-m-d", $newdate);
  return $year . "-" . $month . "-" . $day;
}
function mdate($ldate)
{
  list ($year, $month, $day, $hour, $minute) = explode("-", $ldate);
  $newdate = mktime(0, 0, 0, $month, $day, $year);
//  return date("d-m-Y", $newdate);
  return $day . "-" . $month . "-" . $year;
}
function datetodb($edate)
{
  return date("Y-m-d H:i:s",strtotime($edate));
}

function sendemails($email_sql, $email_from, $email_subject, $email_body)
{
    $db = new DB_Sql();
    $db->Database = DATABASE_NAME;
    $db->User     = DATABASE_USER;
    $db->Password = DATABASE_PASSWORD;
    $db->Host     = DATABASE_HOST;

    $db->query($email_sql);
    while($db->next_record())
      mail($db->f(0), $email_subject, $email_body,"From: $email_from");
}

function sendemail($email_to, $email_from, $email_subject, $email_body)
{
    mail($email_to, $email_subject, $email_body,"From: $email_from");
}

$currSesi = dlookup("tblm_sesi","fldsesi_id","fldstatus='Y'");
$currSem = dlookup("tblm_trimester","fldtrimesterid","fldstatus='Y'");

//echo $sUpd . "<br>";

// YEAR END
$year_lahir="1940";
$year_select="1980";
$year_end = "2040";
$username = $_SESSION["s_username"];
$UserID = $_SESSION["s_userid"];
$staff_id=$_SESSION["s_fld_user_id"]; //'STAFF-20040421-11404';
$usr_level=$_SESSION["s_levelID"];
//   GlobalFuncs end
//===============================

function set_hari($ha){
	if($ha==1){ $h = "Ahad"; }
	else if($ha==2){ $h = "Isnin"; }
	else if($ha==3){ $h = "Selasa"; }
	else if($ha==4){ $h = "Rabu"; }
	else if($ha==5){ $h = "Khamis"; }
	else if($ha==6){ $h = "Jumaat"; }
	else if($ha==7){ $h = "Sabtu"; }
	
	return $h;
}

function listLookup($Table, $fName, $sWhere, $sOrder){
  	global $conn; $sSQL='';
	$sSQL = "SELECT " . $fName . " FROM " . $Table . " WHERE " . $sWhere . " ORDER BY ". $sOrder;
  	$rs2 = &$conn->execute($sSQL);
	if($rs2->recordcount() > 0){  
		return $rs2;
	} else {
		return "";
	}
}

/**
 *
 * @param string $dt            // MySQL formatted date (like 2010-01-01)
 * @param int $year_offset        // like 2 or -2, or 5 or -5 ...
 * @param int $month_offset    // like 2 or -2, or 5 or -5 ...
 * @param in $day_offset        // like 2 or -2, or 5 or -5 ...    
 * @return string             // the new MySQL formatted date (like 2009-07-01)
 */

function MySQLDateOffset($dt,$year_offset='',$month_offset='',$day_offset=''){
      return ($dt=='0000-00-00') ? '' : date ("Y-m-d", mktime(0,0,0,substr($dt,5,2)+$month_offset,substr($dt,8,2)+$day_offset,substr($dt,0,4)+$year_offset));
} 



?>
