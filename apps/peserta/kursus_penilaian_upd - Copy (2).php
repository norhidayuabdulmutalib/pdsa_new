<?php
include '../../common.php';
//$conn->debug=true;
//pp_id='+pp_id+'&id='+id+'&ppset_id='+ppset_id+'&mark='+mark
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$ingenid=isset($_REQUEST["ingenid"])?$_REQUEST["ingenid"]:"";
$pp_event=isset($_REQUEST["event_id"])?$_REQUEST["event_id"]:"";
$pp_id=isset($_REQUEST["pp_id"])?$_REQUEST["pp_id"]:"";
$ppset_id=isset($_REQUEST["ppset_id"])?$_REQUEST["ppset_id"]:"";
$mark=isset($_REQUEST["mark"])?$_REQUEST["mark"]:"";
$remarks=isset($_REQUEST["remarks"])?$_REQUEST["remarks"]:"";
if(empty($pp_id)){
	$sSQL = "INSERT INTO _tbl_penilaian_peserta(pp_eventid, pp_peserta_id, pset_detailid, pp_marks, id_pensyarah, pp_remarks) 
	VALUES(".tosql($pp_event,"Text").",".tosql($id,"Text").",".tosql($ppset_id,"Number").",".tosql($mark,"Number").",".tosql($ingenid).",".tosql($remarks).")";
} else {
	$sSQL = "UPDATE _tbl_penilaian_peserta SET pp_marks=".tosql($mark,"Number").", pp_remarks=".tosql($remarks)." WHERE pp_id=".tosql($pp_id,"Number");
}
$rs = &$conn->Execute($sSQL);
//print "SQL:".$sSQL; exit;
?>
<script>parent.location.reload();</script>