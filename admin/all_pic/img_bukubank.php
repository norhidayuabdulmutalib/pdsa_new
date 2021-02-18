<? include '../../common.php';
//$conn->debug=true;
$idlogo = $_GET['id'];
//echo "ID-->".$id_files;
$sqlimg = "SELECT sijil_image, fld_image, filesize, filetype FROM _tbl_instructor_bank WHERE ingenid_bank=".tosql($idlogo,"Text");
//echo "see-->".$sql;
$rsimg = &$conn->Execute($sqlimg);
$data = $rsimg->fields['sijil_image'];
$name = $rsimg->fields['fld_image']; //@mysql_result($result, 0, "fld_image");
$size = $rsimg->fields['filesize']; //@mysql_result($result, 0, "fldsize");
$type = $rsimg->fields['filetype']; //@mysql_result($result, 0, "filetype");

header("Content-type: $type");
header("Content-length: $size");
header("Content-Disposition: attachment; filename=$name");
header("Content-Description: PHP Generated Data");
echo $data;
?>