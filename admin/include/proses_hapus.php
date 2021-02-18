<?php
include '../../common.php';
//$conn->debug=true;
$jenis_del=isset($_REQUEST["jenis"])?$_REQUEST["jenis"]:"";
$idh=isset($_REQUEST["idh"])?$_REQUEST["idh"]:"";
$sqld1='';
$sqld2='';

if($jenis_del=='SENARAI_P'){
	//$sqld = "DELETE FROM _tbl_kursus_jadual_peserta WHERE InternalStudentId=".tosql($idh,"Number");
	$sqld = "UPDATE _tbl_kursus_jadual_peserta SET is_selected=0, InternalStudentAccepted='0' WHERE InternalStudentId=".tosql($idh,"Number");
} else if($jenis_del=='jadual_kursus_maklumat'){
	$sqld = "DELETE FROM _tbl_kursus_jadual_masa WHERE id_jadmasa=".tosql($idh,"Number");
	$iddet = dlookup("_tbl_set_penilaian_bhg","fsetb_id","fsetb_jadmasaid=".tosql($idh));
	$sqld1 = "DELETE FROM _tbl_set_penilaian_bhg WHERE fsetb_jadmasaid=".tosql($idh,"Number");
	$sqld2 = "DELETE FROM _tbl_nilai_bahagian_detail WHERE fsetb_jadmasaid=".tosql($iddet);
} else if($jenis_del=='jadual_kursus_ceramah'){
	$sqld = "DELETE FROM _tbl_kursus_jadual_det WHERE kur_eve_id=".tosql($idh,"Number");
} else if($jenis_del=='ref_kategori_kursus'){
	$sqld = "DELETE FROM _tbl_kursus_cat WHERE id=".tosql($idh,"Number");
} else if($jenis_del=='_ref_penilaian_kategori'){
	$sqld = "DELETE FROM _ref_penilaian_kategori WHERE f_penilaianid=".tosql($idh,"Number");
} else if($jenis_del=='_ref_penilaian_maklumat'){
	$sqld = "DELETE FROM _ref_penilaian_maklumat WHERE f_penilaian_detailid=".tosql($idh,"Number");
} else if($jenis_del=='_ref_blok_bangunan'){
	$sqld = "DELETE FROM _ref_blok_bangunan WHERE f_bb_id=".tosql($idh,"Number");
} else if($jenis_del=='_ref_kategori_blok'){
	$sqld = "DELETE FROM _ref_kategori_blok WHERE f_kb_id=".tosql($idh,"Number");
} else if($jenis_del=='_ref_aras_bangunan'){
	$sqld = "DELETE FROM _ref_aras_bangunan WHERE f_ab_id=".tosql($idh,"Number");
} else if($jenis_del=='_ref_titlegred'){
	$sqld = "DELETE FROM _ref_titlegred WHERE f_gred_id=".tosql($idh,"Number");
} else if($jenis_del=='_ref_tempatbertugas'){
	$sqld = "DELETE FROM _ref_tempatbertugas WHERE f_tbcode=".tosql($idh);
} else if($jenis_del=='_ref_akademik'){
	$sqld = "DELETE FROM _ref_akademik WHERE f_akademik_id=".tosql($idh,"Number");
} else if($jenis_del=='_tbl_bilikkuliah'){
	$sqld = "DELETE FROM _tbl_bilikkuliah WHERE f_bilikid=".tosql($idh,"Number");
} else if($jenis_del=='_ref_kepakaran'){
	$sqld = "DELETE FROM _ref_kepakaran WHERE f_pakar_code=".tosql($idh);
} else if($jenis_del=='tbl_kursus'){
	$sqld = "DELETE FROM _tbl_kursus WHERE id=".tosql($idh,"Number");
} else if($jenis_del=='tbl_kursus_catsub'){
	$sqld = "DELETE FROM _tbl_kursus_catsub WHERE id=".tosql($idh,"Number");
	
/*} else if($jenis_del=='_ref_akademik'){
	$sqld = "DELETE FROM _ref_akademik WHERE f_akademik_id=".tosql($idh,"Number");
} else if($jenis_del=='_ref_akademik'){
	$sqld = "DELETE FROM _ref_akademik WHERE f_akademik_id=".tosql($idh,"Number");
} else if($jenis_del=='_ref_akademik'){
	$sqld = "DELETE FROM _ref_akademik WHERE f_akademik_id=".tosql($idh,"Number");*/
	
}
//$conn->debug=true;
$conn->execute($sqld);

if(!empty($sqld1)){ $conn->execute($sqld1); }
if(!empty($sqld2)){ $conn->execute($sqld2); }
$conn->debug=false;
//print $sqld; exit;
?>
<script language="javascript">
	//parent.location.reload();	
	refresh = parent.location; 
	parent.location = refresh;
</script>