<?
include_once '../common.php';
$id=$_GET['id'];
//$conn->debug=true;
$sql = "SELECT * FROM kod_sidang WHERE j_dewan=".tosql($id,"Number");
$sql = "SELECT A.*, B.dewan FROM kod_sidang A, kod_dewan B WHERE A.j_dewan=B.j_dewan AND A.status = 0 AND  A.j_dewan=".tosql($id,"Number");
$result = &$conn->Execute($sql);
//echo $sql;
//if(mysql_errno()!= 0){ print 'Error : '.mysql_error(); exit();}
$ID = '';
$Data = '';
while ($row=mysql_fetch_array($result,MYSQL_BOTH)){
	//$ID .= $row['id_sidang'];
	//$Data = $row['persidangan'];
	if(empty($ID)){
		$ID = $row['id_sidang'];
		$Data = $row['persidangan']." - ".$row['dewan']."";
		//$Data = $row[1];
	}else{
		$ID = $ID.';'.$row['id_sidang'];
		$Data = $Data.';'.$row['persidangan']." - ".$row['dewan']."";
		//$ID = $ID.','.$row[0];
		//$Data = $Data.','.$row[1];
	}
} 
//echo $Data;
?>
<script type="text/javascript">
  window.parent.handleResponse('<?php echo $ID ?>','<?php echo $Data ?>','ljid_sidang');
</script>