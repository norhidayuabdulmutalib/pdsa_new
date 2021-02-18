<?php
include 'loading.php';
$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";

$id_ap=isset($_REQUEST["id_ap"])?$_REQUEST["id_ap"]:"";
$nama_ap=isset($_REQUEST["nama_ap"])?$_REQUEST["nama_ap"]:"";
$kod_kaw_ap=isset($_REQUEST["kod_kaw_ap"])?$_REQUEST["kod_kaw_ap"]:"";
$status_ap=isset($_REQUEST["status_ap"])?$_REQUEST["status_ap"]:"";

// proses penghapusan data
if($actions=='DELETE'){
	$sql = "UPDATE ahliparlimen SET status_ap=".tosql("1","Number")." , tkh_tamat=".tosql(DBDate($_POST['tamat']),"Date").",  
	is_deleted=1, delete_by=".tosql('').", delete_dt=".tosql(date("Y-m-d H:i:s"))." 
	WHERE id_ap=".tosql($id_ap,"Number");
	$result = &$conn->Execute($sql);
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	$url = base64_encode('4;utiliti/ap.php;');
	//echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
} else {
	if(!empty($_SESSION['session_status']) && $_SESSION['session_status']=='P'){
		$status_a='K';
	}

	if(!empty($_FILES['binFile'])){
		//echo $daerah; 
		$upload_dir = "gambar_ap/";	
		
		if (!file_exists($upload_dir)) {
			mkdir($upload_dir, 0777);
		} else {
			//echo "Directory exist";
		}
		/*if (!file_exists($negeri)) {
			mkdir($negeri, 0777);
		}
		if (!file_exists($upload_dir)) {
			mkdir($upload_dir, 0777);
		}*/
	
		if (!is_dir($upload_dir)) { die ("Error: The directory ($upload_dir) doesn't exist"); } 
		//check if the directory is writable. 
		if (!is_writeable($upload_dir)){ 
		die ("Error: The directory ($upload_dir) is NOT writable, Please CHMOD (777)"); }
		// start get img
		$new_file = $_FILES['binFile'];
		//echo "Mana fail-->".$_FILES['binFile'];
		$file_name = str_replace(" ","_",$new_file['name']);
		$file_name = strtolower($file_name); 
		$file_size = $new_file['size']; 
		$file_tmp = $new_file['tmp_name'];
		if(!empty($file_name)){
		//if(!move_uploaded_file($_FILES["binFile"]["tmp_name"] , $upload_dir.$_FILES["binFile"]["name"])){
		if(!move_uploaded_file($file_tmp, $upload_dir.$file_name)){
			print ("failed to copy $file_name...\n");
			exit;
		}
		}

		/*if (!copy($file_tmp, $upload_dir.$file_name)) {
			print $file_tmp."<br>";
			print ("failed to copy $file_name...\n");
			exit;
		}*/
	}

	if($actions=='INSERT'){
		// proses kemasukan data
		$sql = "INSERT INTO ahliparlimen(nama_ap, kod_kaw_ap, status_ap, gambar, type, tkh_mula)
		VALUES(".tosql($nama_ap,"Text").", ".tosql($kod_kaw_ap,"Text").", ".tosql($status_ap,"Number").", ".tosql($file_name,"Text").", 'AP',".tosql(DBDate($_POST['mula'])).")";
		$result = &$conn->Execute($sql);
		//if(!$result){ print "Invalid query : " . mysql_error(); }
		$id_ap = mysql_insert_id();
		$url = base64_encode('4;utiliti/ap.php;'.$id_ap);
		//echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	
	} else if($actions=='UPDATE'){
		// proses kemaskini data
		$sql = "UPDATE ahliparlimen SET nama_ap=".tosql($nama_ap,"Text").", kod_kaw_ap=".tosql($kod_kaw_ap,"Text").", 
		status_ap=".tosql($status_ap,"Number")." , tkh_mula=".tosql(DBDate($_POST['mula']),"Date");
		if(!empty($file_name)){ $sql .= ", gambar=".tosql($file_name,"Text"); } 
		$sql .= " WHERE id_ap=".tosql($id_ap,"Number");
		//echo $sql; exit;
		$result = &$conn->Execute($sql);
		//if(!$result){ print "Invalid query : " . mysql_error(); exit; }
		$url = base64_encode('4;utiliti/ap.php;'.$id_ap);
		//echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	} 
}
?>
<?php
//mysql_set_charset('utf8',$connection);
// we produce XML
$filename = 'xml/ahli_parlimen.xml';

if (file_exists($filename)) {
    echo "The file $filename exists";
	unlink($filename) or die("Error Unlink");
} else {
    echo "The file $filename does not exist";
	$file = fopen($filename, "w");
	fwrite($file, $text);
	fclose($file);
}

$sql = "SELECT * FROM ahliparlimen WHERE type='AP' AND status_ap=0 ORDER BY kod_kaw_ap";
//$q   = &$conn->Execute($sql) or die(mysql_error());
//$xml .= "<library>";
$rs =  &$conn->Execute($sql);

$xmlWriter = new XMLWriter();
$xmlWriter->openMemory();
$xmlWriter->startDocument('1.0', 'UTF-8');


$i=0;
$xmlWriter->startElement('aparlimen');
//while($r = mysql_fetch_array($q)){
while (!$rs->EOF){
	$i++;
	$nama = trim($rs->fields['nama_ap']);
	$id_ap = $rs->fields['id_ap'];
	$kod_kaw_ap = $rs->fields['kod_kaw_ap'];
	//$col_name = mysql_field_name($result,$i);
  
    $xmlWriter->startElement('ahliap');
    $xmlWriter->writeElement('id', $id_ap);
    $xmlWriter->writeElement('nama', $nama);
    $xmlWriter->writeElement('kawasan', $kod_kaw_ap);
    $xmlWriter->endElement();
    // Flush XML in memory to file every 1000 iterations
    if (0 == $i%1000) {
        file_put_contents($filename, $xmlWriter->flush(true), FILE_APPEND);
    }
	$rs->movenext();
}
$xmlWriter->endElement();
// Final flush to make sure we haven't missed anything
file_put_contents($filename, $xmlWriter->flush(true), FILE_APPEND);

//exit;

echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";

?>