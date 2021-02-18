<?
include 'loading.php';
$actions = $_POST['actions'];
$PageNo = $_POST['PageNo'];

$id_ap 		= $_POST['id_ap'];
$nama_ap 	= $_POST['nama_ap'];
//$no_kp_ap 	= $_POST['no_kp_ap'];
$kod_kaw_ap = $_POST['kod_kaw_ap'];
//$kawasan_ap = $_POST['kawasan_ap'];
$status_ap 	= $_POST['status_ap'];

// proses penghapusan data
if($actions=='DELETE'){
	$sql = "DELETE FROM ahliparlimen WHERE id_ap=$id_ap";
	$result = &$conn->Execute($sql);
	if(!$result){ echo "Invalid query : " . mysql_errno(); }
	$url = base64_encode('utiliti/ap.php;');
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
} else {
	if(!empty($_SESSION['session_status']) && $_SESSION['session_status']=='P'){
		$status_a='K';
	}

	if(!empty($_FILES['binFile'])){
		//echo $daerah; 
		$upload_dir = "gambar_ap/";	
		
		//if (!file_exists($daerah)) {
		//	mkdir($daerah, 0777);
		//}
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
		
		// This is the temporary file created by PHP
		$uploadedfile = $_FILES['binFile']['tmp_name'];
		// Create an Image from it so we can do the resize
		$src = imagecreatefromjpeg($uploadedfile);
		// Capture the original size of the uploaded image
		list($width,$height)=getimagesize($uploadedfile);
		if($width>200 || $height> 200){
			if($width > $height){
				$newwidth=200;
				$newheight=($height/$width)*200;
			} else {
				$newheight=200;
				$newwidth=($height/$width)*200;
			}
		} else {
			$newwidth = $width;
			$newheight = $height;
		}
		$tmp=imagecreatetruecolor($newwidth,$newheight);
		// this line actually does the image resizing, copying from the original
		// image into the $tmp image
		imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		imagejpeg($tmp,$upload_dir.$file_name,100);
		
		imagedestroy($src);
		imagedestroy($tmp); // NOTE: PHP will clean up the temp file it created when the request
	}
	
	if($actions=='INSERT'){
		// proses kemasukan data
		$sql = "INSERT INTO ahliparlimen(nama_ap, kod_kaw_ap, status_ap, gambar, type)
		VALUES('$nama_ap', '$kod_kaw_ap', '$status_ap', '".$file_name."', 'AP')";
		$result = &$conn->Execute($sql);
		if(!$result){ print "Invalid query : " . mysql_error(); }
		$id_ap = mysql_insert_id();
		$url = base64_encode('utiliti/ap.php;'.$id_ap);
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	
	} else if($actions=='UPDATE'){
		// proses kemaskini data
		$sql = "UPDATE ahliparlimen SET nama_ap='$nama_ap', kod_kaw_ap='$kod_kaw_ap', 
		status_ap='$status_ap' , gambar='".$file_name."' 
		WHERE id_ap=$id_ap";
		//echo $sql; exit;
		$result = &$conn->Execute($sql);
		if(!$result){ print "Invalid query : " . mysql_error(); exit; }
		$url = base64_encode('utiliti/ap.php;'.$id_ap);
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
	} 
}
?>
