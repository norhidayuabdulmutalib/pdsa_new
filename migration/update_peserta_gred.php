<? 
include '../common.php';

$strSQL = "SELECT * FROM _ref_titlegred";
$resultGet = mysql_query($strSQL);
if(mysql_errno()!= 0){ print 'Error : '.mysql_error();	}
$cnt=0;
//while($row = mysql_fetch_array($resultGet,MYSQL_BOTH)){
while($row = mysql_fetch_array($resultGet)){
	$cnt++;
	$id = $row['f_gred_id'];
	$f_gred_code = $row['f_gred_code'];
	$sql_r = "UPDATE _tbl_peserta SET `f_title_grade`='".$id."' WHERE f_title_grade1='".$f_gred_code."'";
	mysql_query($sql_r);
	if(mysql_errno()!= 0){ print 'Error : '.mysql_error();	}
	print "<br>".$cnt." - ".$sql_r."<br>";
}
?>
