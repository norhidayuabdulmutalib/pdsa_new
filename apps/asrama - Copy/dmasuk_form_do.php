<?
include 'loading.php';
//$conn->debug=true;
$bilik_id = $_POST['bilik_id'];
$pelajar_id = $_POST['pelajar_id'];
$semester_id = $_POST['semester_id'];
$no_telefon = $_POST['no_telefon'];
//$no_hp = $_POST['no_hp'];
//$pngk = $_POST['pngk'];
//$hpmg = $_POST['hpmg'];
$penjaga_nama = $_POST['penjaga_nama'];
$p_pekerjaan = $_POST['p_pekerjaan'];
$p_pendapatan = $_POST['p_pendapatan'];
$p_alamat = $_POST['p_alamat'];
$p_no_tel = $_POST['p_no_tel'];
$p_no_hp = $_POST['p_no_hp'];
//echo "insert";
$sql = "INSERT INTO _sis_a_tblasrama(bilik_id, pelajar_id, semester_id, no_telefon, penjaga_nama, p_pekerjaan, p_pendapatan, p_alamat, p_no_tel, p_no_hp, create_dt, tkh_masuk, create_by, is_daftar,is_keluar )
VALUES(".tosql($bilik_id,"Number").", ".tosql($pelajar_id,"Text").", ".tosql($semester_id,"Text").", ".tosql($no_telefon,"Text").", ".tosql($penjaga_nama,"Text").", ".tosql($p_pekerjaan,"Text").",".tosql($p_pendapatan,"Text").", ".tosql($p_alamat,"Text").", ".tosql($p_no_tel,"Text").", ".tosql($p_no_hp,"Text")." ,now(),now(), '".$_SESSION["s_UserID"]."',1,0)";

$conn->Execute($sql);
$new_id = mysql_insert_id();

$jenis_bilik = dlookup("_sis_a_tblbilik", "jenis_bilik", "bilik_id = ".$bilik_id." ");
$jumlah_penghuni = dlookup("_sis_a_tblasrama", "count(daftar_id)", "bilik_id = ".$bilik_id." AND is_daftar = 1");
if($jenis_bilik == $jumlah_penghuni) {
	echo "Set Status Bilik Kepada PENUH";
	$sql = "UPDATE _sis_a_tblbilik SET status_bilik=1 WHERE bilik_id=".tosql($bilik_id,"Number");
	$conn->Execute($sql);
}
//echo $staff;
$url = base64_encode('user;asrama/penghuni_form.php;asrama;penghuni;'.$new_id);
echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
?>