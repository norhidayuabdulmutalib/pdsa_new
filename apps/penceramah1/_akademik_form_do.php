<?php 
	//print 'simpan';
	include '../../common.php';
	include '../../loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$inaka_sijil=isset($_REQUEST["inaka_sijil"])?$_REQUEST["inaka_sijil"]:"";
	$inaka_kursus=isset($_REQUEST["inaka_kursus"])?$_REQUEST["inaka_kursus"]:"";
	$inaka_institusi=isset($_REQUEST["inaka_institusi"])?$_REQUEST["inaka_institusi"]:"";
	$inaka_tahun=isset($_REQUEST["inaka_tahun"])?$_REQUEST["inaka_tahun"]:"";
	$img_baru=isset($_REQUEST["img_baru"])?$_REQUEST["img_baru"]:"";
	/*$id 			= $_POST['id'];
	$category_code 	= strtoupper($_POST['category_code']);
	$categorytype 	= $_POST['categorytype'];
	$status 		= $_POST['status'];*/

	if(empty($id)){
		$sql = "INSERT INTO _tbl_instructor_akademik(ingenid,inaka_sijil, inaka_kursus, inaka_institusi, inaka_tahun) 
		VALUES(".tosql($_SESSION['ingenid']).", ".tosql(strtoupper($inaka_sijil),"Text").", ".tosql(strtoupper($inaka_kursus),"Text").", 
		".tosql(strtoupper($inaka_institusi),"Text").", ".tosql($inaka_tahun,"Number").")";
		$rs = &$conn->Execute($sql);
		$id = mysql_insert_id();
		audit_trail($sql);
	} else {
		$sql = "UPDATE _tbl_instructor_akademik SET 
			inaka_sijil=".tosql(strtoupper($inaka_sijil),"Text").",
			inaka_kursus=".tosql(strtoupper($inaka_kursus),"Text").",
			inaka_institusi=".tosql($inaka_institusi,"Text").",
			inaka_tahun=".tosql($inaka_tahun,"Number")."
			WHERE ingenid_akademik=".tosql($id,"Text");
		$rs = &$conn->Execute($sql);
		audit_trail($sql);
	}

	if($img_baru=='Y'){
		set_time_limit(60);// make reasonably sure the script does not time out on large files
		$upload_dir = '';
		$new_file = $_FILES['file1'];
		//echo "Mana fail-->".$_FILES['binFile'];
		$file_name = str_replace(" ","_",$new_file['name']); 
		$file_size = $new_file['size']; 
		$file_tmp = $new_file['tmp_name'];
		echo "Mana fail-->".$file_name;
		$file_extension = end(explode(".", $file_name));
		echo "<br>File Ext-->".$file_extension;

		$allowedExtensions = array("jpg","jpeg","gif","png"); 
		foreach ($_FILES as $file) { 
		if ($file['tmp_name'] > '') { 
			  if (!in_array(end(explode(".", strtolower($file['name']))), $allowedExtensions)) { 
			   die($file['name'].' is an invalid file type!<br/><br>'.'<div align="center"><input type="button" value="Tutup" onClick="do_close()" style="cursor:pointer"></div>'); 
			  } 
			} 
		}

		switch( $file_extension ) { 
			case "jpg": $jenisfail1="image/JPEG"; break; 
			case "jpeg": $jenisfail1="image/JPEG"; break; 
			case "png": $jenisfail1="image/PNG"; break; 
			case "gif": $jenisfail1="image/GIF"; break; default: 
			$jenisfail1="image/GIF";
		}
		// This is the temporary file created by PHP
		$uploadedfile = $_FILES['file1']['tmp_name'];
		// Create an Image from it so we can do the resize
		if($file_extension=='jpg'){
			$src = imagecreatefromjpeg($file_tmp);
		} else if($file_extension=='jpeg'){
			$src = imagecreatefromjpeg($file_tmp);
		} else if($file_extension=='gif'){
			$src = imagecreatefromgif($file_tmp);
		} else if($file_extension=='png'){
			$src = imagecreatefrompng($file_tmp);
		}
		// Capture the original size of the uploaded image
		list($width,$height)=getimagesize($uploadedfile);
		if($width>620 || $height> 620){
			if($width > $height){
				$newwidth=620;
				$newheight=round(($height/$width)*620);
			} else {
				$newheight=620;
				$newwidth=round(($height/$width)*620);
			}
			//echo "<br>".$width ."/" .$height;
			//echo "<br>".$newwidth ."/" .$newheight;
		} else {
			$newwidth = $width;
			$newheight = $height;
		}
		//$newwidth = $width;
		//$newheight = $height;
		$tmp=imagecreatetruecolor($newwidth,$newheight);
		// this line actually does the image resizing, copying from the original image into the $tmp image
		imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		//imagejpeg($tmp,$upload_dir.$file_name,100);
		if($file_extension=='jpg'){
			imagejpeg($tmp,$upload_dir.$file_name,100);
		} else if($file_extension=='jpeg'){
			imagejpeg($tmp,$upload_dir.$file_name);
		} else if($file_extension=='png'){
			imagepng($tmp,$upload_dir.$file_name);
		} else if($file_extension=='gif'){
			imagegif($tmp,$upload_dir.$file_name);
		}
		
		$URL = $upload_dir.$file_name; 
		$data = addslashes(fread(fopen($URL, "rb"), filesize($URL)));

		unlink($URL);
		imagedestroy($src);
		imagedestroy($tmp); // NOTE: PHP will clean up the temp file it created when the request has completed.
		
		//$conn->debug=true;
		$sSQL = "UPDATE _tbl_instructor_akademik SET 
			fld_image='$file_name',
			sijil_image = '".$data."', 
			filesize='$file_size',
			filetype='$jenisfail1'
			WHERE ingenid_akademik='$id'";
		$conn->execute($sSQL);
		if(mysql_errno()!= 0){ print 'Error : '.mysql_error(); exit; }
	}
	
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		parent.location.reload();
		parent.emailwindow.hide()
		</script>";
?>