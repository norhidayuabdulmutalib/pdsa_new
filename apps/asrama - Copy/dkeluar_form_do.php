<?
include 'loading.php';
$conn->debug=true;
$id = $_POST['id'];
$bilik_id = $_POST['bilik_id'];
echo "Update";
$sql = "UPDATE _sis_a_tblasrama SET is_daftar=0, is_keluar=1, update_dt=now(), update_by='".$_SESSION["s_UserID"]."' WHERE daftar_id=".tosql($id,"Text");
//echo $sql;
//$sql = "UPDATE _sis_tblstaff SET fld_image=".tosql($newname,"Text")." WHERE staff_id=".tosql($id,"Text");
$conn->Execute($sql);
echo "Set Status Bilik Kepada KOSONG";
$sql = "UPDATE _sis_a_tblbilik SET status_bilik=0 WHERE bilik_id=".tosql($bilik_id,"Number");
$conn->Execute($sql);
//echo $staff;
$url = base64_encode('user;asrama/dkeluar_list.php;asrama;keluar;');
echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
?>