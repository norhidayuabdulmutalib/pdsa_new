<?php
include '../../common.php';
//$conn->debug=true;
//pp_id='+pp_id+'&id='+id+'&ppset_id='+ppset_id+'&mark='+mark
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$fsetp_id=isset($_REQUEST["fsetp_id"])?$_REQUEST["fsetp_id"]:"";
$fields=isset($_REQUEST["fields"])?$_REQUEST["fields"]:"";
$mark=isset($_REQUEST["mark"])?$_REQUEST["mark"]:"";


$ppset_id=isset($_REQUEST["ppset_id"])?$_REQUEST["ppset_id"]:"";
$mark=isset($_REQUEST["mark"])?$_REQUEST["mark"]:"";
$remarks=isset($_REQUEST["remarks"])?$_REQUEST["remarks"]:"";


if($fields=='fsetp_umur'){
	if($mark=='19'){ $sql = " fsetp_umur19=1, fsetp_umur20=0, fsetp_umur30=0, fsetp_umur40=0, fsetp_umur50=0 "; }
	else if($mark=='20'){ $sql = " fsetp_umur19=0, fsetp_umur20=1, fsetp_umur30=0, fsetp_umur40=0, fsetp_umur50=0 "; }
	else if($mark=='30'){ $sql = " fsetp_umur19=0, fsetp_umur20=0, fsetp_umur30=1, fsetp_umur40=0, fsetp_umur50=0 "; }
	else if($mark=='40'){ $sql = " fsetp_umur19=0, fsetp_umur20=0, fsetp_umur30=0, fsetp_umur40=1, fsetp_umur50=0 "; }
	else if($mark=='50'){ $sql = " fsetp_umur19=0, fsetp_umur20=0, fsetp_umur30=0, fsetp_umur40=0, fsetp_umur50=1 "; }
} else if($fields=='fsetp_jantina'){
	if($mark=='L'){ $sql = " fsetp_jantina_l=1, fsetp_jantina_p=0 "; }
	else if($mark=='P'){ $sql = " fsetp_jantina_l=0, fsetp_jantina_p=1 "; }
} else if($fields=='fsept_jawatan'){
	if($mark=='J'){ $sql = " fsept_jusa=1, fsetp_pp=0, fsetp_sokongan=0 "; }
	else if($mark=='PP'){ $sql = " fsept_jusa=0, fsetp_pp=1, fsetp_sokongan=0 "; }
	else if($mark=='S'){ $sql = " fsept_jusa=0, fsetp_pp=0, fsetp_sokongan=1 "; }
} else if($fields=='fsetp_kekerapan'){
	if($mark=='1'){ $sql = " fsetp_pertama=1, fsetp_kedua=0, fsetp_sokongan=0 "; }
	else if($mark=='2'){ $sql = " fsetp_pertama=0, fsetp_kedua=1, fsetp_ketiga=0 "; }
	else if($mark=='3'){ $sql = " fsetp_pertama=0, fsetp_kedua=0, fsetp_ketiga=1 "; }
} else if($fields=='f_title_grade'){
	$sql = "fsetp_jawatan =".tosql($mark); 
} else if($fields=='fsetp_tempat_tugas'){
	$sql = " fsetp_tempat_tugas=".tosql($mark); 
} else if($fields=='fsetp_negeri'){
	$sql = " fsetp_negeri=".tosql($mark); 
	$id_peserta = dlookup("_tbl_set_penilaian_peserta","id_peserta","fsetp_id=".tosql($fsetp_id));
	$nokp = dlookup("_tbl_kursus_jadual_peserta","peserta_icno","InternalStudentId=".tosql($id_peserta));
	$sSQL1 = "UPDATE _tbl_peserta SET f_peserta_negeri=".tosql($mark)." WHERE f_peserta_noic=".tosql($nokp,"Text");
	$rs = &$conn->Execute($sSQL1);
}

$sSQL = "UPDATE _tbl_set_penilaian_peserta SET ". $sql ." WHERE fsetp_id=".tosql($fsetp_id,"Number");
$rs = &$conn->Execute($sSQL);
//print "SQL:".$sSQL; exit;
?>
<script>		
	//parent.location.reload();	
	//refresh = parent.location; 
	//parent.location = refresh;
</script>