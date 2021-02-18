<?php
include '../../common.php';
//$conn->debug=true;
include '../../loading_proses.php';
$ty=isset($_REQUEST["ty"])?$_REQUEST["ty"]:"";
$ids=isset($_REQUEST["ids"])?$_REQUEST["ids"]:"";
if($ty=='HADIR'){
	$sqld = "UPDATE _tbl_kursus_jadual_peserta SET InternalStudentAccepted=1 WHERE InternalStudentId=".tosql($ids,"Number");
} else if($ty=='XHADIR'){
	$sqld = "UPDATE _tbl_kursus_jadual_peserta SET InternalStudentAccepted=0 WHERE InternalStudentId=".tosql($ids,"Number");
}
$conn->execute($sqld);
//exit;
?>
<script language="javascript">
	//parent.location.reload();	
	refresh = parent.location; 
	parent.location = refresh;
</script>