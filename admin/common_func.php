<?php 
//$css_pop = '../../css/general.css';
//$css_pop1 = '../css/general.css';
//$css_cetak = '../include/printsurat.css';

//session_start();
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
      //   //$value = str_replace("'","''",$value);
      //   //$value = str_replace("\\","\\\\",$value);
      //   $value = str_replace("'","\'",$value);
      //   $value = str_replace('"','\"',$value);
      //   //$value = str_replace("\\","\\'",$value);
      // }
      // else
      // {
      //   //$value = str_replace("\\'","''",$value);
      //   //$value = str_replace("\\\"","\"",$value);
      //   $value = str_replace("\\'","\'",$value);
      //   $value = str_replace('\\"',"\'",$value);
      //   //$value = str_replace("\\\"","\"",$value);
      // }
	  $val = "'" . $value . "'";
      //if($val=="'\'"){ $val="''"; }
	  return $val;
	  
	  //return "'" . addslashes($value) . "'";
     }
   }
}

function tosqln($value, $type="Text")
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
      if(get_magic_quotes_gpc() == 0)
      {
        //$value = str_replace("'","''",$value);
        //$value = str_replace("\\","\\\\",$value);
        $value = str_replace("'","\'",$value);
        $value = str_replace('"','\"',$value);
        //$value = str_replace("\\","\\'",$value);
      }
      else
      {
        //$value = str_replace("\\'","''",$value);
        //$value = str_replace("\\\"","\"",$value);
        $value = str_replace("\\'","\"",$value);
        $value = str_replace('\\"','\"',$value);
        //$value = str_replace("\\\"","\"",$value);
      }
	  $val = "'" . $value . "'";
      if($val=="'\'"){ $val="''"; }
	  return $val;
	  
	  //return "'" . addslashes($value) . "'";
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
  $rs2 = &$conn->query($sSQL);
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
  $rs2 = &$conn->query($sSQL);
  return $rs2->recordcount();
}

function dlookupid($Table, $fName, $id, $sWhere)
{
  global $conn;
  $sSQL = "";
  
  $sSQL = "SELECT " . $fName . " FROM " . $Table . " WHERE " . $id ."=" . $sWhere;
  //echo $sSQL;
  $rs2 = &$conn->query($sSQL);
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
  $rs2 = &$conn->query($sSQL);
  if ($rs2) {
	  $data = $rs2->fields($fName1).": ".$rs2->fields($fName2) ;
   	  return $data;
  }
  else 
    return "";
}

function dlookup_state($jakim_state)
{
  global $conn;
  $sSQL = "";
  
  $sSQL = "SELECT * FROM ref_state WHERE fldstateID=" . tosql($jakim_state);
  //echo $sSQL;
  $rs2 = &$conn->query($sSQL);
  if (!$rs2->EOF) {
	  $data = $rs2->fields['fldstatedesc'];
   	  return $data;
  }
  else 
    return "Jakim";
}

function audit_trail($remarks, $actions){
	global $conn;
	$sSQL = "";
	//$page_name = $_SESSION['page_name']; //curPageName();
	$kid = $_SESSION['SESS_KAMPUS'];
	$idusers = $_SESSION["s_userid"];
	$users = $_SESSION["s_logid"];
	$ip = $_SERVER['REMOTE_ADDR'];
	$time = date("Y-m-d H:i:s");
	
	$remarks = str_replace("\'","",$remarks);
	$remarks = str_ireplace("'","",$remarks);
	
	$sSQL = "INSERT INTO auditrail(kampus_id, id_user, log_user, ip, actions, remarks, trans_date) 
		VALUES('{$kid}', '{$idusers}', '{$users}', '{$ip}', '{$actions}', '{$remarks}', '{$time}')";
	//$conn->debug=true;
	$conn->Execute($sSQL);
	//exit;
}

function audit_log($remarks,$type,$users, $pro){
	global $conn;
	$sSQL = "";
	$kid = $_SESSION['SESS_KAMPUS'];
	$sid = $_SESSION["s_userid"];
	$user = $_SESSION["s_logid"];
	$ip = $_SERVER['REMOTE_ADDR'];
	
	if($pro=='ERR'){ $user = $users; }
	$time = date("Y-m-d H:i:s");

	$rs = &$conn->query("SELECT * FROM auditlog WHERE log_user=".tosql($user)." AND trans_date=".tosql($time));
	if($rs->EOF){
		$sSQLLog = "INSERT INTO auditlog(kampus_id, id_user, log_user, ip, type, remarks, trans_date) 
		VALUES('{$kid}', '{$sid}', '{$user}', '{$ip}', '{$type}', '".addslashes($remarks)."', '".$time."')";
		$conn->Execute($sSQLLog);
	}
}

function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
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

//echo $sUpd . "<br>";

// YEAR END
$year_lahir="1940";
$year_select="1980";
$year_end = "2040";
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
	//$conn->debug=true;
	$sSQL = "SELECT " . $fName . " FROM " . $Table . " WHERE " . $sWhere . " ORDER BY ". $sOrder;
	//print $sSQL;
  	$rs2 = &$conn->query($sSQL);
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

function cleanHTML($html) {
	/// <summary>
	/// Removes all FONT and SPAN tags, and all Class and Style attributes.
	/// Designed to get rid of non-standard Microsoft Word HTML tags.
	/// </summary>
	// start by completely removing all unwanted tags
	
	$html = ereg_replace("<(/)?(font|span|del|ins)[^>]*>","",$html);
	
	// then run another pass over the html (twice), removing unwanted attributes
	$html = ereg_replace("<([^>]*)(class|lang|style|size|face)=(\"[^\"]*\"|'[^']*'|[^>]+)([^>]*)>","<\\1>",$html);
	$html = ereg_replace("<([^>]*)(class|lang|style|size|face)=(\"[^\"]*\"|'[^']*'|[^>]+)([^>]*)>","<\\1>",$html);
	// sample word html <p class="aaa" style="background:dot">abc</p> will return <p > </p>
	return $html;
}

function remove_tags($values){
	
	$values  = str_ireplace("<b>","",$values);
	$values  = str_ireplace("</b>","",$values);
	$values  = str_ireplace("<i>","",$values);
	$values  = str_ireplace("</i>","",$values);
	//$values  = str_ireplace("<br>","",$values);
	return $values;
}

function countdown ($dateto,$ty){
    $tstampfrom = strtotime(date("Y-m-d 00:00:00"));
    $tstampto = strtotime($dateto);
	//if($ty=='H'){ $datediff = $tstampto - $tstampfrom; }
	if($ty=='H'){ $datediff = $tstampto - $tstampfrom; }
	else if($ty=='T') { $datediff = $tstampfrom - $tstampto; }
	else { $datediff = $tstampto - $tstampfrom; }
    $daysdiff = $datediff / 86400;
    //if (round($daysdiff,0) > $daysdiff){
        //$numdays = $daysdiff;
		
		//print $tstampto."-".$tstampfrom."/"."[".$datediff."]".$daysdiff;
        
		if($daysdiff<29) { $numdays = "<1"; }
        else if($daysdiff>=30 && $daysdiff<=50) { $numdays = 1; }
        else if($daysdiff>=51 && $daysdiff<=80) { $numdays = 2; }
        else if($daysdiff>=81 && $daysdiff<=110) { $numdays = 3; }
        else if($daysdiff>=111 && $daysdiff<=140) { $numdays = 4; }
        else if($daysdiff>=141 && $daysdiff<=170) { $numdays = 5; }
        else if($daysdiff>=171 && $daysdiff<=200) { $numdays = 6; }
        else if($daysdiff>=201 && $daysdiff<=230) { $numdays = 7; }
        else if($daysdiff>=231 && $daysdiff<=260) { $numdays = 8; }
        else if($daysdiff>=261 && $daysdiff<=290) { $numdays = 9; }
        else if($daysdiff>=291 && $daysdiff<=320) { $numdays = 10; }
        else if($daysdiff>=321 && $daysdiff<=350) { $numdays = 11; }
        else if($daysdiff>=351) { $numdays = 12; }
        //else
        //if
        //return $daysdiff."(".$numdays.")". $ty;
        return $numdays;
}

function pusat_kursus($pusat_id){
  	global $conn; $sSQL='';
	$sSQL = "SELECT SubCategoryNm, SubCategoryDesc FROM _tbl_kursus_catsub WHERE id=".tosql($pusat_id);
  	$rs2 = &$conn->query($sSQL);
	//print $sSQL;
	$pusat_name = $rs2->fields['SubCategoryDesc']."<br><i>[ ".$rs2->fields['SubCategoryNm']." ]</i>";
	
	return $pusat_name;
}

function pusat_list($pusat_id){
  	global $conn; $sSQL='';
	$sSQL = "SELECT SubCategoryNm, SubCategoryDesc FROM _tbl_kursus_catsub WHERE id=".tosql($pusat_id);
  	$rs2 = &$conn->query($sSQL);
	//print $sSQL;
	$pusat_name = $rs2->fields['SubCategoryDesc']." [".$rs2->fields['SubCategoryNm']."]";
	
	return $pusat_name;
}


class HijriCalendar
{
    function monthName($i) // $i = 1..12
    {
        static $month  = array(
            "Muharam", "Safar", "Rabiul Awal", "Rabiul Akhir",
            "Jamadil Awal", "Jamadil Akhir", "Rejab", "Syaaban",
            "Ramadhan", "Syawal", "Zulkaedah", "Zulhijah"
        );
        return $month[$i-1];
    }

    function GregorianToHijri($time = null)
    {
        if ($time === null) $time = time();
        $m = date('m', $time);
        $d = date('d', $time);
        $y = date('Y', $time);

        return HijriCalendar::JDToHijri(
            cal_to_jd(CAL_GREGORIAN, $m, $d, $y));
    }

    function HijriToGregorian($m, $d, $y)
    {
        return jd_to_cal(CAL_GREGORIAN,
            HijriCalendar::HijriToJD($m, $d, $y));
    }

    # Julian Day Count To Hijri
    function JDToHijri($jd)
    {
        $jd = $jd - 1948440 + 10632;
        $n  = (int)(($jd - 1) / 10631);
        $jd = $jd - 10631 * $n + 354;
        $j  = ((int)((10985 - $jd) / 5316)) *
            ((int)(50 * $jd / 17719)) +
            ((int)($jd / 5670)) *
            ((int)(43 * $jd / 15238));
        $jd = $jd - ((int)((30 - $j) / 15)) *
            ((int)((17719 * $j) / 50)) -
            ((int)($j / 16)) *
            ((int)((15238 * $j) / 43)) + 29;
        $m  = (int)(24 * $jd / 709);
        $d  = $jd - (int)(709 * $m / 24);
        $y  = 30*$n + $j - 30;

        return array($m, $d, $y);
    }

    # Hijri To Julian Day Count
    function HijriToJD($m, $d, $y)
    {
        return (int)((11 * $y + 3) / 30) +
            354 * $y + 30 * $m -
            (int)(($m - 1) / 2) + $d + 1948440 - 385;
    }
};

//if(isset($_SESSION['SESS_levelID'])){ $levelid = $_SESSION["SESS_levelID"]; }
//if(isset($_SESSION['SESS_fldpenerima'])){ $pegawai_terima = $_SESSION["SESS_fldpenerima"]; }
//if(isset($_SESSION['SESS_fldpenaksircaj'])){ $pegawai_caj = $_SESSION["SESS_fldpenaksircaj"]; }
//if(isset($_SESSION['SESS_fldpemeriksa'])){ $pegawai_periksa = $_SESSION["SESS_fldpemeriksa"]; }
//if(isset($_SESSION['SESS_fldpemantau'])){ $pegawai_pantau = $_SESSION["SESS_fldpemantau"]; }
//if(isset($_SESSION['SESS_fldpengesah'])){ $pegawai_sah = $_SESSION["SESS_fldpengesah"]; }
//if(isset($_SESSION['SESS_fldcetak'])){ $pegawai_cetak = $_SESSION["SESS_fldcetak"]; }
//if(isset($_SESSION['SESS_levelID'])){ $levelid = $_SESSION["SESS_levelID"]; }
//if(isset($_SESSION['SESS_jakim_state'])){ $jakim_state = $_SESSION["SESS_jakim_state"]; }
//if(isset($_SESSION['SESS_comp_reg'])){ $mycoid = $_SESSION["SESS_comp_reg"]; }
//if(isset($_SESSION['SESS_compcode'])){ $compcode = $_SESSION["SESS_compcode"]; }


// comment untuk buang error
// $user_id=$_SESSION['session_id_kakitangan'];
// $log_id=$_SESSION['session_userid'];

$ip = getenv('HTTP_CLIENT_IP')?:
getenv('HTTP_X_FORWARDED_FOR')?:
getenv('HTTP_X_FORWARDED')?:
getenv('HTTP_FORWARDED_FOR')?:
getenv('HTTP_FORWARDED')?:
getenv('REMOTE_ADDR');
?>