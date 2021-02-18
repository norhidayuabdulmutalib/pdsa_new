<?
include '../../common.php';
    // This code only works on Linux-based s
    //     ervers ;)
    // Some lines, like this one, are longer
    //     than this window and may have wrapped; y
    //     ou can get the original, if necessary, a
    //     t the address shown in the code descript
    //     ion
    // File Upload Script for PHP/3 for Linu
    //     x
    // Released under the terms of the publi
    //     c GNU license
    // Based upon code written by Rasmus Ler
    //     dorf and Boaz Yahav
    // Modified for Linux by Saif Slatewala
    // E-mail: saif_slatewala@india.com
    // site :- http://systemprg.hypermart.ne
    //     t
    // You need to write-enable a directory,
    //     named "/tmp", below the one you place th
    //     is script in
	
	$id = $_GET['id'];
	$action1 = $_GET['action'];
	if($action1==""){
		$action1 = false;
	} else {
		$action1 = true;
	}
    if($action1){// if files have been uploaded, process them
		$error1 = "";
		$id=$_POST['pid'];
    ?> 
    <html>
    <head>
    <title>File Upload Results</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <body bgcolor="#FFFFFF" text="#000000">
    <p><font face="Arial, Helvetica, sans-serif"><font size="+1">File Upload Results</font><br><br>
    <?
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
		switch( $file_extension ) { 
		case "jpg": $jenisfail1="application/JPEG"; break; 
		case "jpeg": $jenisfail1="application/JPEG"; break; 
		case "pdf": $jenisfail1="application/PDF"; break; 
		case "gif": $jenisfail1="application/GIF"; break; default: 
		$jenisfail1="application/GIF";
		}
		// This is the temporary file created by PHP
		$uploadedfile = $_FILES['file1']['tmp_name'];
		// Create an Image from it so we can do the resize
		if($file_extension=='jpg'){
			$src = imagecreatefromjpeg($file_tmp);
		} else if($file_extension=='gif'){
			$src = imagecreatefromgif($file_tmp);
		}
		// Capture the original size of the uploaded image
		list($width,$height)=getimagesize($uploadedfile);
		if($width>120 || $height> 120){
			if($width > $height){
				$newwidth=120;
				$newheight=round(($height/$width)*120);
			} else {
				$newheight=120;
				$newwidth=round(($height/$width)*120);
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
		} else if($file_extension=='gif'){
			imagegif($tmp,$upload_dir.$file_name);
		}
		
		$URL = $upload_dir.$file_name; 
		$data = addslashes(fread(fopen($URL, "rb"), filesize($URL)));

		unlink($URL);
		imagedestroy($src);
		imagedestroy($tmp); // NOTE: PHP will clean up the temp file it created when the request has completed.
		
		$conn->debug=true;
		$sSQL = "UPDATE _sis_tblstaff SET 
			fld_image='$file_name',
			gambar_staff = '".$data."', 
			fldsize='$file_size',
			filetype='$jenisfail1'
			WHERE staff_id='$id'";
		$conn->execute($sSQL);
		if(mysql_errno()!= 0){ print 'Error : '.mysql_error(); exit; }
		exit;
    ?>
    </font></p>
    </body>
    </html>
    <script language="javascript" type="text/javascript">
		parent.location.reload();
		//window.close();
		//parent.Update_Img('staff/staff_pic/<? print $file_name;?>');
		parent.emailwindow.hide();
	</script>
    <?
    }
    else {// else, prompt for the files
    // files will be uploaded into the serve
    //     r's temp directory for PHP
    ?>
    <html>
    <head>
    <title>File Upload</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <body bgcolor="#FFFFFF" text="#000000">
    <p><font face="Arial, Helvetica, sans-serif"><font size="+1">File Upload</font><br><br>
    If your browser is upload-enabled, you will see "Browse" (Netscape, Internet Explorer) or ". . ." (Opera) buttons below. Use them to select file(s) to upload, then click the "Upload" button. After the files have been uploaded, you will see a results screen.<br>
    <form method="post" enctype="multipart/form-data" action="upload_img.php?action=1&nsfid=<?=$nsfid;?>">
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
    <input type="hidden" name="action1" value="1">
    File : <input type="file" name="file1" size="30"><br>
    <input type="submit" value="Upload">
    <input type="hidden" name="pid" value="<?=$id;?>">
    </form>
    </font></p>
    </body>
    </html>
    <?
    }
    ?>
