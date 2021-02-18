<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td width="100%" height="150px" bgcolor="#FFFFFF">
<?php
include 'loading.php';
$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";

$id_unit=isset($_REQUEST["id_unit"])?$_REQUEST["id_unit"]:"";
$id_bahagian=isset($_REQUEST["id_bahagian"])?$_REQUEST["id_bahagian"]:"";
$nama_unit=isset($_REQUEST["nama_unit"])?$_REQUEST["nama_unit"]:"";
$status_unit=isset($_REQUEST["status_unit"])?$_REQUEST["status_unit"]:"";

// proses penghapusan data
if($actions=='DELETE'){
	$sql = "DELETE FROM kod_unit WHERE id_unit=".tosql($id_unit,"Number");
	$result = &$conn->Execute($sql);
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	//echo $sql;
	//ecit;
	$url = base64_encode('4;utiliti/unit.php;');
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	//echo '<meta http-equiv="refresh" content="1; URL=bahagian.php">';
} else {

	if($actions=='INSERT'){
		// proses kemasukan data
		$sql = "INSERT INTO kod_unit(nama_unit, id_bahagian, status_unit)
		VALUES(".tosql($nama_unit,"Text").", ".tosql($id_bahagian,"Number").", ".tosql($status_unit,"Number").")";
		$result = &$conn->Execute($sql);
		//if(!$result){ echo "Invalid query : " . mysql_error(); }
		//$id_unit = mysql_insert_id();
//		$url = base64_encode('utiliti/unit_form.php;'.$id_unit);
		$url = base64_encode('4;utiliti/unit.php;');
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&id_bahagian=".$id_bahagian."&PageNo=".$PageNo."\">";
		//echo '<meta http-equiv="refresh" content="1; URL=bahagian_form.php?id='.$id_bahagian.'&PageNo='.$PageNo.'">';
	
	} else if($actions=='UPDATE'){
		// proses kemaskini data
		$sql = "UPDATE kod_unit SET nama_unit=".tosql($nama_unit,"Text").", id_bahagian=".tosql($id_bahagian,"Number").", status_unit=".tosql($status_unit,"Number");
		$sql .= " WHERE id_unit=".tosql($id_unit,"Number");
		$result = &$conn->Execute($sql);
		//if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		//$url = base64_encode('utiliti/unit_form.php;'.$id_unit);
		$url = base64_encode('4;utiliti/unit.php;');
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&id_bahagian=".$id_bahagian."&PageNo=".$PageNo."\">";
	} 
}
?>
&nbsp;</td></tr>
</table>
