<?
include '../loading_pro.php';
//$conn->debug=true;
$id = $_POST['id'];
$no_bilik = $_POST['no_bilik'];
$tingkat_id = $_POST['tingkat_id'];
$blok_id = $_POST['blok_id'];
$jenis = $_POST['jenis'];
$bilp = $_POST['bilp'];
$status = 0;
$del = $_POST['del'];
$keadaan = $_POST['keadaan'];
$PageQUERY = $_POST['PageQUERY'];
$PageNo = $_POST['PageNo'];
if($del == "0"){
	if(empty($id)){
		echo "insert";
		$sql = "INSERT INTO _sis_a_tblbilik(no_bilik, tingkat_id, blok_id, jenis_bilik, keadaan_bilik)
		VALUES(".tosql($no_bilik,"Text").", ".tosql($tingkat_id,"Text").", ".tosql($blok_id,"Text").", 
		".tosql($jenis,"Text").", ".tosql($keadaan,"Text").")";
	} else {
		echo "Update";
		if($bilp==0){
		$sql = "UPDATE _sis_a_tblbilik SET no_bilik=".tosql($no_bilik,"Text").
		", tingkat_id=".tosql($tingkat_id,"Text").", blok_id=".tosql($blok_id,"Text").
		", jenis_bilik=".tosql($jenis,"Text").", keadaan_bilik=".tosql($keadaan,"Text").
		" WHERE bilik_id=".tosql($id,"Text");
		} else {
		$sql = "UPDATE _sis_a_tblbilik SET no_bilik=".tosql($no_bilik,"Text").
		", tingkat_id=".tosql($tingkat_id,"Text").", blok_id=".tosql($blok_id,"Text").
		" WHERE bilik_id=".tosql($id,"Text");
		}
	}
}
	else {
		echo "Delete";
		$sql = "UPDATE _sis_a_tblbilik SET is_deleted = 1 WHERE bilik_id=".tosql($id,"Text");
}
//echo $sql;
//$sql = "UPDATE _sis_tblstaff SET fld_image=".tosql($newname,"Text")." WHERE staff_id=".tosql($id,"Text");
$conn->Execute($sql);
//echo $staff;
$url = base64_encode('user;asrama/bilik_list.php;asrama;bilik;');
echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&blok_id=".$blok_id."&page=".$PageNo."\">";
?>