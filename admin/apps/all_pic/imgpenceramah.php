<?php include '../../common.php';
//$conn->debug=true;
$idlogo = $_GET['id'];
//echo "ID-->".$id_files;
$sqlimg = "SELECT gambar_staff, fld_image, fldsize, filetype FROM _tbl_instructor WHERE  ingenid=".tosql($idlogo,"Text");
//echo "see-->".$sql;
$rsimg = &$conn->Execute($sqlimg);
$data = $rsimg->fields['gambar_staff'];
$name = $rsimg->fields['fld_image']; //@mysql_result($result, 0, "fld_image");
$size = $rsimg->fields['fldsize']; //@mysql_result($result, 0, "fldsize");
$type = $rsimg->fields['filetype']; //@mysql_result($result, 0, "filetype");


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