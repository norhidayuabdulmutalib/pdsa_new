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
	<script language="javascript">
    function do_close(){
        parent.emailwindow.hide();
    }
    </script>
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

		$allowedExtensions = array("jpg","jpeg","gif","png","pdf","doc","xls","docx","txt","ppt"); 
		foreach ($_FILES as $file) { 
		if ($file['tmp_name'] > '') { 
			  if (!in_array(end(explode(".", strtolower($file['name']))), $allowedExtensions)) { 
			   die($file['name'].' is an invalid file type!<br/><br>'.'<div align="center"><input type="button" value="Tutup" onClick="do_close()" style="cursor:pointer"></div>'); 
			  } 
			} 
		}

		switch( $file_extension ) { 
			case "pdf": $jenisfail1="application/PDF"; break; 
			case "doc": $jenisfail1="application/msword"; break; 
			case "xls": $jenisfail1="application/vnd.ms-excel"; break; 
			case "docx": $jenisfail1="application/msword"; break; 
			case "txt": $jenisfail1="text/plain"; break; 
			case "ppt": $jenisfail1="application/vnd.ms-powerpoint"; break; 

			case "jpg": $jenisfail1="image/JPEG"; break; 
			case "jpeg": $jenisfail1="image/JPEG"; break; 
			case "png": $jenisfail1="image/PNG"; break; 
			case "gif": $jenisfail1="image/GIF"; break; default: 
			$jenisfail1="image/GIF";
		}
		// This is the temporary file created by PHP
		$uploadedfile = $_FILES['file1']['tmp_name'];
		$URL = $upload_dir.$file_name; 
		$data = addslashes(fread(fopen($URL, "rb"), filesize($URL)));

		unlink($URL);
	
		$conn->debug=true;
		$sSQL = "UPDATE _tbl_kursus_det SET 
			file_name='$file_name',
			file_upload = '".$data."', 
			file_size='$file_size',
			file_type='$jenisfail1'
			WHERE id_kur_det='$id'";
		$conn->execute($sSQL);
		if(mysql_errno()!= 0){ print 'Error : '.mysql_error(); exit; }
		exit;
    ?>
    </font></p>
    </body>
    </html>
    <script language="javascript" type="text/javascript">
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		//parent.Update_Img('staff/staff_pic/<?php print $file_name;?>');
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
	<script language="javascript">
    function do_close(){
        parent.emailwindow.hide();
    }
    </script>
    </head>
    <body bgcolor="#FFFFFF" text="#000000">
    <p><font face="Arial, Helvetica, sans-serif"><font size="+1">File Upload</font><br><br>
    If your browser is upload-enabled, you will see "Browse" (Netscape, Internet Explorer) or ". . ." (Opera) buttons below. Use them to select file(s) to upload, then click the "Upload" button. After the files have been uploaded, you will see a results screen.<br>
    <form method="post" enctype="multipart/form-data" action="upload_img.php?action=1&nsfid=<?=$nsfid;?>">
    <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
    <input type="hidden" name="action1" value="1">
    File : <input type="file" name="file1" size="50"><br>
    <div align="center">
    <input type="submit" value="Upload">
    <input type="button" value="Tutup" onClick="do_close()" style="cursor:pointer"></div>
    <input type="hidden" name="pid" value="<?=$id;?>">
    </form>
    </font></p>
    </body>
    </html>
    <?
    }
    ?>
