<? include '../common_prn.php';
//$conn->debug=true;
$idlogo = $_GET['id'];
//echo "ID-->".$id_files;
  $sql = "SELECT gambar_staff, fld_image, fldsize, filetype FROM _sis_tblstaff WHERE  staff_id= '$idlogo' ";
  //echo "see-->".$sql;
  $rs = &$conn->Execute($sql);
  $data = $rs->fields['gambar_staff'];
  $name = $rs->fields['fld_image']; //@mysql_result($result, 0, "fld_image");
  $size = $rs->fields['fldsize']; //@mysql_result($result, 0, "fldsize");
  $type = $rs->fields['filetype']; //@mysql_result($result, 0, "filetype");
  
  
  /*$result = mysql_query($sql);
  $data = @mysql_result($result, 0, "gambar_staff");
  $name = @mysql_result($result, 0, "fld_image");
  $size = @mysql_result($result, 0, "fldsize");
  $type = @mysql_result($result, 0, "filetype");*/
	
  header("Content-type: $type");
  header("Content-length: $size");
  header("Content-Disposition: attachment; filename=$name");
  header("Content-Description: PHP Generated Data");
  echo $data;
?>