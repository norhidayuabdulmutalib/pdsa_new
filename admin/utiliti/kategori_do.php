<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td width="100%" height="150px" bgcolor="#FFFFFF">
<?
include 'loading.php';
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";
$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";

$id_kategori=isset($_REQUEST["id_kategori"])?$_REQUEST["id_kategori"]:"";
$nama_kategori=isset($_REQUEST["nama_kategori"])?$_REQUEST["nama_kategori"]:"";
$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";

// proses penghapusan data
if($actions=='DELETE'){
	$sql = "DELETE FROM kod_kategori WHERE id_kategori=".tosql($id_kategori,"Number");
	$result = &$conn->Execute($sql);
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	$url = base64_encode('4;utiliti/kategori.php;');
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	//echo '<meta http-equiv="refresh" content="1; URL=kategori.php">';
} else {

	if(empty($id_kategori)){
		// proses kemasukan data
		$sql = "INSERT INTO kod_kategori(nama_kategori, status)
		VALUES(".tosql($nama_kategori,"Text").", ".tosql($status,"NUmber").")";
		$result = &$conn->Execute($sql);
		//if(!$result){ echo "Invalid query : " . mysql_error(); }
		//$id_kategori = mysql_insert_id();
		//$url = base64_encode('utiliti/kategori_form.php;'.$id_kategori);
		$url = base64_encode('4;utiliti/kategori.php;');
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
		//echo '<meta http-equiv="refresh" content="1; URL=kategori_form.php?id='.$id_kategori.'&PageNo='.$PageNo.'">';
	
	} else if($actions=='UPDATE'){
		// proses kemaskini data
		$sql = "UPDATE kod_kategori SET nama_kategori=".tosql($nama_kategori,"Text").", status=".tosql($status,"Number");
		$sql .= " WHERE id_kategori=".tosql($id_kategori,"Number");
		$result = &$conn->Execute($sql);
		//if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		//$url = base64_encode('utiliti/kategori_form.php;'.$id_kategori);
		$url = base64_encode('4;utiliti/kategori.php;');
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	} 
}
?>
&nbsp;</td></tr>
</table>
