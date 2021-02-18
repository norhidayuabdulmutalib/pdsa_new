<?php
@session_start();
error_reporting (E_ALL ^ E_NOTICE);
require_once('adodb.inc.php');
require_once 'include/dateformat.php';
require_once('include/color.php');

$ip = $_SERVER['HTTP_HOST'];
//print "ip:".$ip;
//define("DATABASE_NAME","moste");
//define("DATABASE_USER","root");
//define("DATABASE_PASSWORD","");
//define("DATABASE_HOST","localhost");
// ====== START DATABASE CONFIG =======
//ODBC_MSSQL
//$DB_dbtype="mysql"; $DB_hostname="localhost"; $DB_username="root"; $DB_pasword=""; $DB_dbname="dbupm";
if($ip=='localhost'){
	$DB_dbtype="mysql"; $DB_hostname="localhost"; $DB_username="root"; $DB_password="root"; $DB_dbname="db_itis";
} else {
	$DB_dbtype="mysql"; $DB_hostname="dbprod"; $DB_username="itis"; $DB_password="kioio&*(6uhwdihui&%hgui908"; $DB_dbname="itis";
	//$DB_dbtype="mysql"; $DB_hostname="localhost"; $DB_username="root"; $DB_password="d4t4b4s3"; $DB_dbname="itis";

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

?>
