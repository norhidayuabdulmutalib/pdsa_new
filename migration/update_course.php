<? 
include '../common.php';

$strSQL = "SELECT * FROM _tbl_kursus";
$resultGet = mysql_query($strSQL);
if(mysql_errno()!= 0){ print 'Error : '.mysql_error();	}
$cnt=0;
//while($row = mysql_fetch_array($resultGet,MYSQL_BOTH)){
while($row = mysql_fetch_array($resultGet)){
	$cnt++;
	$id = $row['id'];
	$courseid = $row['courseid'];
	$sql_r = "UPDATE tblevent SET `courseid`='".$id."' WHERE courseid1='".$courseid."'";
	mysql_query($sql_r);
	if(mysql_errno()!= 0){ print 'Error : '.mysql_error();	}
	print "<br>".$cnt." - ".$sql_r."<br>";
}
?>
