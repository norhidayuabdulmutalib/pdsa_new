<?php 
	//print 'simpan';
	include '../../common.php';
	include '../../loading_proses.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$inaka_banknama=isset($_REQUEST["inaka_banknama"])?$_REQUEST["inaka_banknama"]:"";
	$inaka_bankcawangan=isset($_REQUEST["inaka_bankcawangan"])?$_REQUEST["inaka_bankcawangan"]:"";
	$inaka_banknoacct=isset($_REQUEST["inaka_banknoacct"])?$_REQUEST["inaka_banknoacct"]:"";
	//$img_baru=isset($_REQUEST["img_baru"])?$_REQUEST["img_baru"]:"";
	/*$id 			= $_POST['id'];
	$category_code 	= strtoupper($_POST['category_code']);
	$categorytype 	= $_POST['categorytype'];
	$status 		= $_POST['status'];*/
	
	//$conn->debug=true;
	if(empty($id)){
		$sql = "INSERT INTO _tbl_instructor_bank(ingenid, inaka_banknama, inaka_bankcawangan, inaka_banknoacct) 
		VALUES(".tosql($_SESSION['ingenid']).", ".tosql(strtoupper($inaka_banknama),"Text").", ".tosql(strtoupper($inaka_bankcawangan),"Text").", 
		".tosql(strtoupper($inaka_banknoacct),"Text").")";
		$rs = &$conn->Execute($sql);
		$id = mysql_insert_id();
		audit_trail($sql);
	} else {
		$sql = "UPDATE _tbl_instructor_bank SET 
			inaka_banknama=".tosql(strtoupper($inaka_banknama),"Text").",
			inaka_bankcawangan=".tosql(strtoupper($inaka_bankcawangan),"Text").",
			inaka_banknoacct=".tosql($inaka_banknoacct,"Text")."
			WHERE ingenid_bank=".tosql($id,"Text");
		$rs = &$conn->Execute($sql);
		if(mysql_errno()!= 0){ print 'Error : '.mysql_error(); exit; }
		audit_trail($sql);
	}

	if(!empty($_FILES['file1']['name'])){ 
		$img_baru='Y';  
	} else { 
		$img_baru='N'; 
		print "<script language=\"javascript\">
			alert('Rekod telah disimpan');
			//parent.location.reload();	
			refresh = parent.location; 
			parent.location = refresh;
			parent.emailwindow.hide()
			</script>";
	}


	if($img_baru=='Y'){
		set_time_limit(60);// make reasonably sure the script does not time out on large files
		$upload_dir = '../temp/';
		$new_file = $_FILES['file1'];
		//echo "Mana fail-->".$_FILES['binFile'];
		$file_name = str_replace(" ","_",$new_file['name']); 
		$file_size = $new_file['size']; 
		$file_tmp = $new_file['tmp_name'];
		echo "Mana fail-->".$file_name;
		$file_extension = end(explode(".", $file_name));
		echo "<br>File Ext-->".$file_extension;

		$allowedExtensions = array("jpg","jpeg","gif","png","pdf"); 
		foreach ($_FILES as $file) { 
		if ($file['tmp_name'] > '') { 
			  if (!in_array(end(explode(".", strtolower($file['name']))), $allowedExtensions)) { 
			  if (!in_array(end(explode(".", strtolower($file['name']))), $allowedExtensions)) { 
			   die('<br><br><font color="#FF0000">'.$file['name'].' adalah fail yang tidak dibenarkan!</font><br><br>'.
			   '<div align="center"><input type="button" value="Tutup" onClick="javascript:parent.emailwindow.hide();" 
			   style="cursor:pointer"></div>'); 
			   exit;
			  } 
			} 
		}

		switch( $file_extension ) { 
			case "pdf": $jenisfail1="application/PDF"; break; 
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
		$sSQL = "UPDATE _tbl_instructor_bank SET 
			fld_image='$file_name',
			sijil_image = '".$data."', 
			filesize='$file_size',
			filetype='$jenisfail1'
			WHERE ingenid_bank='$id'";
		$conn->execute($sSQL);
		if(mysql_errno()!= 0){ print 'Error : '.mysql_error(); exit; }
	}
	
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		parent.emailwindow.hide()
		</script>";
	}
?>