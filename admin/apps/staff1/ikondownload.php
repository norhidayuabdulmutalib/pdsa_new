<?php include '../common1.php';
$idlogo = $_GET['id'];
$sql = "SELECT gambar_staff,fld_image,fldsize, filetype FROM _sis_tblstaff WHERE  staff_id= '$idlogo' ";
/*$result = mysql_query($sql);
$data = @mysql_result($result, 0, "gambar_staff");
$name = @mysql_result($result, 0, "fld_image");
$size = @mysql_result($result, 0, "fldsize");
$type = @mysql_result($result, 0, "filetype");*/
$result = $conn->execute($sql);
$data = $result->fields['gambar_staff'];
$name = $result->fields['fld_image'];
$size = $result->fields['fldsize'];
$type = $result->fields['filetype'];
header("Content-type: $type");
header("Content-length: $size");
header("Content-Disposition: attachment; filename=$name");
header("Content-Description: PHP Generated Data");
echo $data;
?>