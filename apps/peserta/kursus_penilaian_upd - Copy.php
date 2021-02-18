<?php
include '../../common.php';
//$conn->debug=true;
//pp_id='+pp_id+'&id='+id+'&ppset_id='+ppset_id+'&mark='+mark
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$pp_event=isset($_REQUEST["event_id"])?$_REQUEST["event_id"]:"";
$pp_id=isset($_REQUEST["pp_id"])?$_REQUEST["pp_id"]:"";
$ppset_id=isset($_REQUEST["ppset_id"])?$_REQUEST["ppset_id"]:"";
$mark=isset($_REQUEST["mark"])?$_REQUEST["mark"]:"";
if(empty($pp_id)){
	$sSQL = "INSERT INTO _tbl_penilaian_peserta(pp_eventid, pp_peserta_id, pset_detailid, pp_marks) 
	VALUES(".tosql($pp_event,"Text").",".tosql($id,"Text").",".tosql($ppset_id,"Number").",".tosql($mark,"Number").")";
} else {
	$sSQL = "UPDATE _tbl_penilaian_peserta SET pp_marks=".tosql($mark,"Number")." WHERE pp_id=".tosql($pp_id,"Number");
}
$rs = &$conn->Execute($sSQL);
?>
<script>parent.location.reload();</script>