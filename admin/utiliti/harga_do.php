<?
include 'loading.php';
include_once '../common.php';
include_once '../include/dateformat.php';

$actions = $_POST['actions'];
$PageNo = $_POST['PageNo'];

$destinasi = $_POST['destinasi'];
$kelas = $_POST['kelas'];
$sehala = $_POST['sehala'];
$dua_hala = $_POST['dua_hala'];
$cukai = $_POST['cukai'];

// proses penghapusan data
if($act=='DELETE'){
	$sql = "DELETE FROM harga WHERE id_harga=$id_harga";
	$result = &$conn->Execute($sql);
	if(!$result){ echo "Invalid query : " . mysql_errno(); }
	echo '<meta http-equiv="refresh" content="1; URL=harga.php">';
} else {

	if($actions=='INSERT'){
		// proses kemasukan data
		$sql = "INSERT INTO harga(destinasi, kelas, sehala, dua_hala, cukai,)
		VALUES('$destinasi', '$kelas', '$sehala', '$dua_hala', '$cukai')";
		$result = &$conn->Execute($sql);
		if(!$result){ echo "Invalid query : " . mysql_error(); }
		$id_harga = mysql_insert_id();
		echo '<meta http-equiv="refresh" content="1; URL=harga_form.php?id='.$id_harga.'&PageNo='.$PageNo.'">';
	
	} else if($actions=='UPDATE'){
		// proses kemaskini data
		$sql = "UPDATE harga SET destinasi='$destinasi', kelas='$kelas', 
		sehala='$sehala',
		dua_hala='$dua_hala', cukai='$cukai'";
		$sql .= " WHERE id_harga=$id_harga";
		$result = &$conn->Execute($sql);
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		echo '<meta http-equiv="refresh" content="1; URL=harga_form.php?id='.$id_harga.'&PageNo='.$PageNo.'">';
	} 
}
?>
