<?php
include '../../common.php';
//$conn->debug=true;
$event_id=isset($_REQUEST["kursus_id"])?$_REQUEST["kursus_id"]:"";
$icno=isset($_REQUEST["icno"])?$_REQUEST["icno"]:"";
$fsetp_id=isset($_REQUEST["fsetp_id"])?$_REQUEST["fsetp_id"]:"";
$id=$_GET["id"];
//print $id;

$sSQL = "UPDATE _tbl_set_penilaian_peserta SET is_nilai=1 WHERE fsetp_id=".tosql($fsetp_id)." AND id_peserta=".tosql($id);
$rs = &$conn->Execute($sSQL);
$sSQL1 = "UPDATE _tbl_kursus_jadual_peserta SET is_nilai=1 WHERE EventId=".tosql($event_id)." AND InternalStudentId=".tosql($id);
$rs = &$conn->Execute($sSQL1);
//exit;
?>
<script>
//parent.location.reload();	
refresh = parent.location; 
parent.location = refresh;
</script>