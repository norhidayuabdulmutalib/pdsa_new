<? include '../../common.php';
//$conn->debug=true;
$idlogo = $_GET['id'];
//echo "ID-->".$id_files;
$sqlimg = "SELECT f_bukubank, f_bb_image, f_bb_size, f_bb_type FROM _tbl_instructor_bank WHERE ingenid_bank=".tosql($idlogo,"Text");
//echo "see-->".$sql;
$rsimg = &$conn->Execute($sqlimg);
$data = $rsimg->fields['f_bukubank'];
$name = $rsimg->fields['f_bb_image']; //@mysql_result($result, 0, "fld_image");
$size = $rsimg->fields['f_bb_size']; //@mysql_result($result, 0, "fldsize");
$type = $rsimg->fields['f_bb_type']; //@mysql_result($result, 0, "filetype");


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