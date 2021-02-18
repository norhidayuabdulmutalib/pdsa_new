<? include '../../common.php';
//$conn->debug=true;
$idlogo = $_GET['id'];
$sqlimg = "SELECT file_upload, file_name, file_size, file_type FROM _tbl_kursus_det WHERE id_kur_det=".tosql($idlogo,"Number");
$rsimg = &$conn->Execute($sqlimg);
$data = $rsimg->fields['file_upload'];
$name = $rsimg->fields['file_name']; //@mysql_result($result, 0, "fld_image");
$size = $rsimg->fields['file_size']; //@mysql_result($result, 0, "fldsize");
$type = $rsimg->fields['file_type']; //@mysql_result($result, 0, "filetype");

header("Content-type: $type");
header("Content-length: $size");
header("Content-Disposition: attachment; filename=$name");
header("Content-Description: PHP Generated Data");
echo $data;
?>