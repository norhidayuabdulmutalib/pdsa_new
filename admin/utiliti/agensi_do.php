<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td width="100%" height="150px" bgcolor="#FFFFFF">
<?
include 'loading.php';
$actions = $_POST['actions'];
$PageNo = $_POST['PageNo'];

$id_agensi = $_POST['id_agensi'];
$nama_agensi = $_POST['nama_agensi'];
$status = $_POST['status'];

// proses penghapusan data
if($actions=='DELETE'){
	$sql = "DELETE FROM kod_agensi WHERE id_agensi=$id_agensi";
	$result = &$conn->Execute($sql);
	if(!$result){ echo "Invalid query : " . mysql_errno(); }
	//echo $sql;
	//ecit;
	$url = base64_encode('utiliti/agensi.php;');
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	//echo '<meta http-equiv="refresh" content="1; URL=bahagian.php">';
} else {

	if($actions=='INSERT'){
		// proses kemasukan data
		$sql = "INSERT INTO kod_agensi(nama_agensi, status)
		VALUES('$nama_agensi', '$status')";
		$result = &$conn->Execute($sql);
		if(!$result){ echo "Invalid query : " . mysql_error(); }
		$id_agensi = mysql_insert_id();
		$url = base64_encode('utiliti/agensi_form.php;'.$id_agensi);
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
		//echo '<meta http-equiv="refresh" content="1; URL=bahagian_form.php?id='.$id_bahagian.'&PageNo='.$PageNo.'">';
	
	} else if($actions=='UPDATE'){
		// proses kemaskini data
		$sql = "UPDATE kod_agensi SET nama_agensi='$nama_agensi', status='$status' ";
		$sql .= " WHERE id_agensi=$id_agensi";
		$result = &$conn->Execute($sql);
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		$url = base64_encode('utiliti/agensi_form.php;'.$id_agensi);
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	} 
}
?>
&nbsp;</td></tr>
</table>
