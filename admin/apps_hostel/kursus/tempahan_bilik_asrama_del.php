<?php
//include '../../common.php';
//$conn->debug=true;
$jenis_del=isset($_REQUEST["jenis"])?$_REQUEST["jenis"]:"";
$tid=isset($_REQUEST["tid"])?$_REQUEST["tid"]:"";
$sqld = "DELETE FROM _sis_a_tblasrama_tempah WHERE tempahan_id=".tosql($tid);
$conn->execute($sqld);
//exit;
?>
<script language="javascript">
	//parent.location.reload();	
	refresh = parent.location; 
	parent.location = refresh;
</script>