<?php
//ini_set("Display_errors",0);
//include_once 'common.php';
include 'loading.php';
$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";

$id_ap=isset($_REQUEST["id_ap"])?$_REQUEST["id_ap"]:"";
$nama_ap=isset($_REQUEST["nama_ap"])?$_REQUEST["nama_ap"]:"";
$kawasan_ap=isset($_REQUEST["kawasan_ap"])?$_REQUEST["kawasan_ap"]:"";
$parti=isset($_REQUEST["parti"])?$_REQUEST["parti"]:"";
$tempoh=isset($_REQUEST["tempoh"])?$_REQUEST["tempoh"]:"";
$status_ap=isset($_REQUEST["status_ap"])?$_REQUEST["status_ap"]:"";

// proses penghapusan data
if($actions=='DELETE'){
	//$sql = "DELETE FROM ahliparlimen WHERE id_ap=".tosql($id_ap,"Number");
	$sql = "UPDATE ahliparlimen SET status_ap=".tosql("1","Number")." , tkh_tamat=".tosql(DBDate($_POST['tamat']),"Date").",  
	is_deleted=1, delete_by=".tosql('').", delete_dt=".tosql(date("Y-m-d H:i:s"))." 
	WHERE id_ap=".tosql($id_ap,"Number");
	//$conn->debug=true;
	$result = &$conn->Execute($sql);
	//exit;
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	$url = base64_encode('4;utiliti/adewan.php;');
	//echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
} else {
	if(!empty($_SESSION['session_status']) && $_SESSION['session_status']=='P'){
		$status_a='K';
	}

	$nama = $_FILES['binFile']['name'];
	if(!empty($nama)){
		//echo $daerah; 
		$upload_dir = "gambar_ad/";	

		if (!file_exists($upload_dir)) {
			mkdir($upload_dir, 0777);
		} else {
			echo "Directory exist";
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
		$temp_name = $_FILES["binFile"]["tmp_name"];

		//if(!move_uploaded_file($_FILES["binFile"]["tmp_name"] , $upload_dir.$_FILES["binFile"]["name"])){
		if(!move_uploaded_file($temp_name, $upload_dir.$file_name)){
			print ("failed to copy $file_name...\n");
			exit;
		}
		
		/*if (!copy($file_tmp, $file_name)) {
			print ("failed to copy $imgfile...\n");
		}*/

	}
	//exit;
	if($actions=='INSERT'){
		// proses kemasukan data
// $conn->debug=true;
		$sql = "INSERT INTO ahliparlimen(nama_ap, kawasan_ap, parti, tempoh, status_ap, gambar, type)
		VALUES(".tosql($nama_ap,"Text").", ".tosql($kawasan_ap,"Text").", 
		".tosql($parti,"Text").", ".tosql($tempoh,"Text").", '$status_ap', '".$file_name."', 'AD')";
		//print $sql;
		$result = &$conn->Execute($sql);
		//if(!$result){ print "Invalid query : " . mysql_error(); }
		$id_ap = mysql_insert_id();
		//echo $sql; exit;
		$url = base64_encode('4;utiliti/adewan.php;'.$id_ap);
		//echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	
	} else if($actions=='UPDATE'){
		// proses kemaskini data
		//$conn->debug=true;
		$sql = "UPDATE ahliparlimen SET 
		nama_ap=".tosql($nama_ap,"Text").", kawasan_ap=".tosql($kawasan_ap,"Text").", 
		parti=".tosql($parti,"Text").", tempoh=".tosql($tempoh,"Text").", 
		status_ap=".tosql($status_ap,"Text");
		if(!empty($file_name)){ $sql .= ", gambar=".tosql($file_name,"Text")." "; }
		$sql .= " WHERE id_ap=".tosql($id_ap,"Number");
		$result = &$conn->execute($sql);
		//echo $sql; exit;
		//if(!$result){ print "Invalid query : " . mysql_error(); exit; }
		$url = base64_encode('4;utiliti/adewan.php;'.$id_ap);
		//echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	} 
}
?>
<?php
//mysql_set_charset('utf8',$connection);
// we produce XML
$filename = 'xml/ahli_dewan.xml';

if (file_exists($filename)) {
    //echo "The file $filename exists";
	unlink($filename) or die("Error");
} else {
    echo "The file $filename does not exist";
	$file = fopen($dir . $filename, "w");
	fwrite($file, $text);
	fclose($file);
}

$sql = "SELECT * FROM ahliparlimen WHERE type='AD' AND status_ap=0 ORDER BY nama_ap";
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
	//$kod_kaw_ap = $rs->fields['kod_kaw_ap'];
  
    $xmlWriter->startElement('ahliap');
    $xmlWriter->writeElement('id', $id_ap);
    $xmlWriter->writeElement('nama', $nama);
    //$xmlWriter->writeElement('kawasan', $kod_kaw_ap);
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

echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";

?>
