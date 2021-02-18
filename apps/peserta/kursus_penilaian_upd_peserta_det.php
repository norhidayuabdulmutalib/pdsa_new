<?php
include '../../common.php';
//$conn->debug=true;
//pp_id='+pp_id+'&id='+id+'&ppset_id='+ppset_id+'&mark='+mark
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$fset_pid=isset($_REQUEST["fset_pid"])?$_REQUEST["fset_pid"]:"";
$mark=isset($_REQUEST["mark"])?$_REQUEST["mark"]:"";
$ty=isset($_REQUEST["ty"])?$_REQUEST["ty"]:"";

if(empty($ty)){
	if($mark=='1'){ $sql 		= " fsetdet_1=1, fsetdet_2=0, fsetdet_3=0, fsetdet_4=0, fsetdet_5=0 "; }
	else if($mark=='2'){ $sql 	= " fsetdet_1=0, fsetdet_2=1, fsetdet_3=0, fsetdet_4=0, fsetdet_5=0 "; }
	else if($mark=='3'){ $sql 	= " fsetdet_1=0, fsetdet_2=0, fsetdet_3=1, fsetdet_4=0, fsetdet_5=0 "; }
	else if($mark=='4'){ $sql 	= " fsetdet_1=0, fsetdet_2=0, fsetdet_3=0, fsetdet_4=1, fsetdet_5=0 "; }
	else if($mark=='5'){ $sql 	= " fsetdet_1=0, fsetdet_2=0, fsetdet_3=0, fsetdet_4=0, fsetdet_5=1 "; }
	$sSQL = "UPDATE _tbl_set_penilaian_peserta_detail SET ". $sql ." WHERE fset_pid=".tosql($fset_pid,"Number");
	$rs = &$conn->Execute($sSQL);
} else if($ty=='U'){
	$sSQL = "UPDATE _tbl_set_penilaian_peserta_bhg SET fsetbp_remarks=".tosql($mark)." WHERE fsetbp_id=".tosql($fset_pid,"Number")." AND id_peserta=".tosql($id);
	$rs = &$conn->Execute($sSQL);
} else if($ty=='K'){
	$sSQL = "UPDATE _tbl_set_penilaian_peserta SET fsetp_remarks =".tosql($mark)." WHERE fsetp_id=".tosql($fset_pid,"Number")." AND id_peserta=".tosql($id);
	$rs = &$conn->Execute($sSQL);
}
//print "SQL:".$sSQL; exit;
?>
<script>
	//alert('<?=$sSQL;?>');
	//parent.location.reload();	
	//refresh = parent.location; 
	//parent.location = refresh;

</script>