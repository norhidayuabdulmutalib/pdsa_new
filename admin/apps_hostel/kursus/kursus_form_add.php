<?php
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
$proses = $_GET['pro'];
$id_kur_det = $_GET['id_kur_det'];
if(empty($proses)){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(document.ilim.jenis.value==''){
		alert("Sila pilih jenis maklumat terlebih dahulu.");
		document.ilim.jenis.focus();
		return true;
	} else if(document.ilim.maklumat.value==''){
		alert("Sila masukkan maklumat berkaitan terlebih dahulu.");
		document.ilim.maklumat.focus();
		return true;
	} else {
		document.ilim.action = URL;
		document.ilim.submit();
	}
}
function form_back(URL){
	parent.emailwindow.hide();
}

</script>
</head>

<body>
<?php
//print $_SERVER['HTTP_ACCEPT'];
$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id = ".tosql($id,"Number");
$rs = &$conn->Execute($sSQL);
if(!empty($id_kur_det)){
	$sql_det = "SELECT * FROM _tbl_kursus_det WHERE id_kur_det=".tosql($id_kur_det,"Number");
	$rs_det = &$conn->Execute($sql_det);
}
?>
<form name="ilim" method="post" enctype="multipart/form-data" >
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">SELENGGARA MAKLUMAT TAMBAHAN BAGI KURSUS</td>
    </tr>
	<tr><td colspan="2">
    	<table width="90%" cellpadding="4" cellspacing="0" border="0" align="center">
        	<tr>
            	<td width="25%" align="right"><b>Kursus</b></td>
            	<td width="1%" align="center"><b> : </b></td>
				<td width="74%" align="left"><?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></td>                
            </tr>
        	<tr>
            	<td align="right"><b>Kategori</b></td>
            	<td align="center"><b> : </b></td>
				<td align="left"><?php print $rs->fields['categorytype'];?></td>                
            </tr>
        	<tr>
            	<td align="right"><b>Pusat</b></td>
            	<td align="center"><b> : </b></td>
				<td align="left"><?php print $rs->fields['SubCategoryNm'];?></td>                
            </tr>
        	<tr>
            	<td align="right"><b>Jenis Maklumat</b></td>
            	<td align="center"><b> : </b></td>
				<td align="left">
					<select name="jenis">
                    	<option value="">Sila pilih</option>
                    	<option value="File" <?php if($rs_det->fields['jenis']=='File'){ print 'selected'; }?>> Softcopy </option>
                    	<option value="Tool" <?php if($rs_det->fields['jenis']=='Tool'){ print 'selected'; }?>> Tools </option>
                    	<option value="Nota" <?php if($rs_det->fields['jenis']=='Nota'){ print 'selected'; }?>> Nota Kuliah </option>
                    </select>
                </td>                
            </tr>
        	<tr>
            	<td align="right"><b>Maklumat</b></td>
            	<td align="center"><b> : </b></td>
				<td align="left"><input type="text" size="80" name="maklumat" value="<?php print $rs_det->fields['maklumat'];?>" /></td>                
            </tr>
			<tr>
              	<td valign="top" align="right"><b>Muatnaik Maklumat</b></td>
            	<td align="center" valign="top"><b> : </b></td>
            	<td><input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                <input type="hidden" name="action1" value="1">
                <input type="file" name="file1" size="50">
                <br />
                <input type="radio" name="img_baru" value="Y" />Muatnaik Dokumen &nbsp;&nbsp;&nbsp;
                <input type="radio" name="img_baru" value="N" checked="checked" />Kekalkan Dokumen                
                <br />
                <?php if(!empty($rs_det->fields['file_name'])){ ?>
                --> <?php print $rs_det->fields['file_name'];?>
                <?php } ?>
                </td>
            </tr>
        	<tr>
            	<td align="right"><b>Status</b></td>
            	<td align="center"><b> : </b></td>
				<td align="left">
                	<select name="status">
                    	<option value="1"<?php if($rs_det->fields['status']=='1'){ print 'selected'; }?>>Aktif</option>
                    	<option value="0"<?php if($rs_det->fields['status']=='0'){ print 'selected'; }?>>Tidak Aktif</option>
                    </select>
                </td>                
            </tr>
            <tr>
                <td colspan="3" align="center"><hr />
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')" >
                    <input type="button" value="Tutup" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan disiplin" onClick="form_back()" >
                    <input type="text" name="id" value="<?=$id?>" />
                    <input type="text" name="id_kur_det" value="<?=$id_kur_det?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                </td>
            </tr>
		</table>
	</td></tr>
</table>
</form>
</body>
</html>
<script language="javascript">
	document.ilim.jenis.focus();
</script>
<?php } else {
	$conn->debug=true;
	//print 'simpan';
	include '../loading_pro.php';
	$id 			= $_POST['id'];
	$id_kur_det		= $_POST['id_kur_det'];
	$jenis 			= $_POST['jenis'];
	$maklumat 		= $_POST['maklumat'];
	$status 		= $_POST['status'];
	$img_baru 		= $_POST['img_baru'];
	
	if(empty($id_kur_det)){
		$sql = "INSERT INTO _tbl_kursus_det(kursus_id, jenis, maklumat, status) 
		VALUES(".tosql($id,"Text").", ".tosql($jenis,"Text").", ".tosql($maklumat,"Text").", ".tosql($status,"Text").")";
		$rs = &$conn->Execute($sql);
		$id_kur_det = mysql_insert_id();
	} else {
		$sql = "UPDATE _tbl_kursus_det SET 
			status=".tosql($status,"Text").",
			jenis=".tosql($jenis,"Text").",
			maklumat=".tosql($maklumat,"Text")."
			WHERE id_kur_det=".tosql($id_kur_det,"Number");
		$rs = &$conn->Execute($sql);
	}
	
	//print $id;

	if($img_baru=='Y'){

		set_time_limit(60);// make reasonably sure the script does not time out on large files
		$upload_dir = '';
		$new_file = $_FILES['file1'];
		//echo "Mana fail-->".$_FILES['file1'];
		$file_name = str_replace(" ","_",$new_file['name']); 
		$file_size = $new_file['size']; 
		$file_tmp = $new_file['tmp_name'];
		//echo "Mana fail-->".$file_name;
		$file_extension = end(explode(".", $file_name));
		//echo "<br>File Ext-->".$file_extension;
	
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
		
		$target = "../all_pic"; 
		$target = $target . basename( $_FILES['file1']['name']); 
		$ok=1; 
		if(move_uploaded_file($_FILES['file1']['tmp_name'], $target)) { 
			echo "The file ". basename( $_FILES['file1']['name']). " has been uploaded"; } else { echo "Sorry, there was a problem uploading your file."; }
		$data = addslashes(fread(fopen($target, "rb"), filesize($target)));
		
		unlink($target);
	
		$conn->debug=true;
		$sSQL = "UPDATE _tbl_kursus_det SET 
			file_name='$file_name',
			file_upload = '".$data."', 
			file_size='$file_size',
			file_type='$jenisfail1'
			WHERE id_kur_det='$id_kur_det'";
		$conn->execute($sSQL);
		if(mysql_errno()!= 0){ print 'Error : '.mysql_error(); exit; }
	}
	//exit;
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		</script>";
}
?>