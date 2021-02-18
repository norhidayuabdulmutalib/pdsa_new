<?php
$ip = $_SERVER['HTTP_HOST'];
//if($ip=='10.21.133.33'){
	$dblink = mysql_connect("localhost","root","d4t4b4s3") or die("<b><font color=red>Pastikan database anda aktif</font></b>");
	mysql_select_db("parlimen");
//}
// else {
//	$dblink = mysql_connect("10.21.133.33","eragtcom_kklw","") or die("<b><font color=red>Pastikan database anda aktif</font></b>");
//	mysql_select_db("eragtcom_parlimen");
//}


function dlookup($Table, $fName, $sWhere){
	$sSQL = "SELECT " . $fName . " FROM " . $Table . " WHERE " . $sWhere;
	$result1 = &$conn->Execute($sSQL);
	if(mysql_errno()!= 0){ print 'Error : '.mysql_error(); exit();}
	$intRecCount1 = mysql_num_rows($result1);
	if($intRecCount1 > 0){  
		$row1 = mysql_fetch_array($result1, MYSQL_BOTH);
		return $row1['0'];
	} else {
		return "";
	}
}
function tosql($value, $type="Text"){
  if($value == ""){
    return "NULL";
  } else {
    if($type == "Number"){
      return doubleval($value);
    } else {
      if(get_magic_quotes_gpc() == 0){
        $value = str_replace("'","''",$value);
        $value = str_replace("\\","\\\\",$value);
      } else {
        $value = str_replace("\\'","''",$value);
        $value = str_replace("\\\"","\"",$value);
      }
      return "'" . $value . "'";
     }
   }
}

function audit_trail($remarks){
	$sSQL = "";
	$sid = $_SESSION['session_id_kakitangan'];
	$user = $_SESSION['session_userid'];
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$sSQL = "INSERT INTO auditrail(id_user, log_user, ip, remarks, trans_date) 
	VALUES('".$sid."', '".$user."', '".$ip."', '".addslashes($remarks)."', '".date("Y-m-d H:i:s")."')";
	$result_au = &$conn->Execute($sSQL);
}

?>
