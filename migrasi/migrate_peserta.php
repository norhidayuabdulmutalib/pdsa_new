<?php
require_once('../adodb.inc.php');
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
      if(get_magic_quotes_gpc() == 0)
      {
        $value = str_replace("'","''",$value);
        $value = str_replace("\\","\\\\",$value);
      }
      else
      {
        $value = str_replace("\\'","''",$value);
        $value = str_replace("\\\"","\"",$value);
      }
      return "'" . $value . "'";
     }
   }
}

$DB_dbtype="mysql"; $DB_hostname="localhost"; $DB_username="root"; $DB_password="4pp52itis"; $DB_dbname="iltim_db";
$conn = &ADONEWConnection($DB_dbtype);
$conn->Pconnect($DB_hostname, $DB_username, $DB_password, $DB_dbname);

$DB_dbtype="mysql"; $DB_hostname="localhost"; $DB_username="root"; $DB_password="4pp52itis"; $DB_dbname="itis";
$conn1 = &ADONEWConnection($DB_dbtype);
$conn1->Pconnect($DB_hostname, $DB_username, $DB_password, $DB_dbname);


$conn->debug=true;
$conn1->debug=true;
//$sSQL = "SELECT * FROM tbl_pelajar WHERE length(ic)=13 AND ic like '099%' ";
$sSQL = "SELECT * FROM _tbl_peserta WHERE 1";
$rs = &$conn->query($sSQL);
//print $rs->recordcount(); exit;
while(!$rs->EOF){
	$sqls = "SELECT * FROM _tbl_peserta WHERE f_peserta_noic=".tosql($rs->fields['f_peserta_noic']);
	$rs1 = &$conn1->query($sqls);
	if($rs1->EOF){
		print '<br>ADA';
	} else {
		print '<br>';
		//print '<br>TIADA';
	}

	//$conn->execute($sqls);
	$rs->movenext();
}	

//print "<br><br>Sama : " . $sama;
//echo "<br><br>selesai";

?>
