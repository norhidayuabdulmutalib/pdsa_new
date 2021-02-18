<?
include 'loading.php';
//$conn->debug=true;
$id = $_POST['id'];
$bilik_id = $_POST['bilik_id'];
$penjaga_nama = $_POST['penjaga_nama'];
$p_pekerjaan = $_POST['p_pekerjaan'];
$p_pendapatan = $_POST['p_pendapatan'];
$p_alamat = $_POST['p_alamat'];
$p_poskod = $_POST['p_poskod'];
$p_no_tel = $_POST['p_no_tel'];
$p_no_hp = $_POST['p_no_hp'];

if ($_POST['proses'] == 'update') {
	echo "Update"; //p_poskod = ".tosql($p_poskod,"Text").",
	$sql = "UPDATE _sis_a_tblasrama SET penjaga_nama = ".tosql($penjaga_nama,"Text").", p_pekerjaan = ".tosql($p_pekerjaan,"Text").", 
	p_pendapatan = ".tosql($p_pendapatan,"Text").",	p_alamat = ".tosql($p_alamat,"Text").", 
	p_no_tel = ".tosql($p_no_tel,"Text").",
	p_no_hp = ".tosql($p_no_hp,"Text").", update_dt=now(), update_by='".$_SESSION["s_UserID"]."' WHERE daftar_id=".tosql($id,"Text");
} else {
	echo "Daftar Keluar";
	$sql = "UPDATE _sis_a_tblasrama SET is_daftar=0, is_keluar=1, tkh_keluar=now(), update_dt=now(), 
	update_by='".$_SESSION["s_UserID"]."' WHERE daftar_id=".tosql($id,"Text");
//echo $sql;
//$sql = "UPDATE _sis_tblstaff SET fld_image=".tosql($newname,"Text")." WHERE staff_id=".tosql($id,"Text");
	$conn->Execute($sql);
	echo "Set Status Bilik Kepada KOSONG";
	$sql = "UPDATE _sis_a_tblbilik SET status_bilik=0 WHERE bilik_id=".tosql($bilik_id,"Number");
	$conn->Execute($sql);
}
//echo $sql;
//$sql = "UPDATE _sis_tblstaff SET fld_image=".tosql($newname,"Text")." WHERE staff_id=".tosql($id,"Text");
$conn->Execute($sql);
$url = base64_encode('user;asrama/penghuni_list.php;asrama;penghuni;');
echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
?>