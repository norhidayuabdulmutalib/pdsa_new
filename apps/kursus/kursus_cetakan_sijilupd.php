<?php
include '../../common.php';
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$chk=isset($_REQUEST["chk"])?$_REQUEST["chk"]:"";
if($chk=='ALL'){
	$sSQL = "UPDATE _tbl_kursus_jadual_peserta SET is_sijil=1 WHERE EventId=".tosql($id);
} else {
	if($chk==0){
		$sSQL = "UPDATE _tbl_kursus_jadual_peserta SET is_sijil=1 WHERE InternalStudentId=".tosql($id);
	} else {
		$sSQL = "UPDATE _tbl_kursus_jadual_peserta SET is_sijil=0 WHERE InternalStudentId=".tosql($id);
	}
}
//$sqls = "SEELCT * FROM _tbl_kursus_jadual_peserta";
$rs = &$conn->Execute($sSQL);
?>
<script language="javascript">
	//parent.location.reload();	
	refresh = parent.location; 
	parent.location = refresh;
</script>