<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td width="100%" height="150px" bgcolor="#FFFFFF">
<?php
include 'loading.php';
$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";

$id_bahagian=isset($_REQUEST["id_bahagian"])?$_REQUEST["id_bahagian"]:"";
$kod_bahagian=isset($_REQUEST["kod_bahagian"])?$_REQUEST["kod_bahagian"]:"";
$nama_bahagian=isset($_REQUEST["nama_bahagian"])?$_REQUEST["nama_bahagian"]:"";
$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
$lstPegawai=isset($_REQUEST["lstPegawai"])?$_REQUEST["lstPegawai"]:"";

// proses penghapusan data
if($actions=='DELETE'){
	$sql = "DELETE FROM kod_bahagian WHERE id_bahagian=".tosql($id_bahagian,"Number");
	$result = &$conn->Execute($sql);
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	//echo $sql;
	//ecit;
	$url = base64_encode('4;utiliti/bahagian.php;');
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	//echo '<meta http-equiv="refresh" content="1; URL=bahagian.php">';
} else {

	if($actions=='INSERT'){
		// proses kemasukan data
		$sql = "INSERT INTO kod_bahagian(kod_bahagian, nama_bahagian, status)
		VALUES(".tosql($kod_bahagian,"Text").", ".tosql($nama_bahagian,"Text").", ".tosql($status,"Number").")";
		$result = &$conn->Execute($sql);
		//if(!$result){ echo "Invalid query : " . mysql_error(); }
		$id_bahagian = Insert_ID(); //mysql_insert_id();
		$url = base64_encode('4;utiliti/bahagian.php;');
		//$url = base64_encode('utiliti/bahagian_form.php;'.$id_bahagian);
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
		//echo '<meta http-equiv="refresh" content="1; URL=bahagian_form.php?id='.$id_bahagian.'&PageNo='.$PageNo.'">';
	
	} else if($actions=='UPDATE'){
		// proses kemaskini data
		$sql = "UPDATE kod_bahagian SET kod_bahagian=".tosql($kod_bahagian,"Text").", nama_bahagian=".tosql($nama_bahagian,"Text").", status=".tosql($status,"Number").",
		 pegawai_sub=".tosql($lstPegawai,"Number");
		$sql .= " WHERE id_bahagian=".tosql($id_bahagian,"Number");
		$result = &$conn->Execute($sql);
		//if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		$url = base64_encode('4;utiliti/bahagian.php;');
		//$url = base64_encode('utiliti/bahagian_form.php;'.$id_bahagian);
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	} 
}
?>
&nbsp;</td></tr>
</table>
