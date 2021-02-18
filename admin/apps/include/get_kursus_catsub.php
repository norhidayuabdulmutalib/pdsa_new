<?
include '../../common.php';
$conn->debug=true;
$code = $_GET['code'];
$lst = $_GET['lst'];
$sSQL="SELECT * FROM _tbl_kursus_catsub WHERE f_category_code = '".$code."' ORDER BY SubCategoryNm";
$rsData = &$conn->Execute($sSQL);
//$result = mysql_query($strSQL,$dbLink);
$ID = '';
$Data = '';
while (!$rsData->EOF){
	if(empty($ID)){
		$ID = $rsData->fields['id'];
		$Data = $rsData->fields['SubCategoryNm'];
		//$Data = $row[1];
	}else{
		$ID = $ID.','.$rsData->fields['id'];
		$Data = $Data.','.$rsData->fields['SubCategoryNm'];
		//$ID = $ID.','.$row[0];
		//$Data = $Data.','.$row[1];
	}
	$rsData->movenext();
}
//$ID .= ","; $Data .= ",";

//echo $ID;
?>     
<script type="text/javascript">
  window.parent.handleResponse('<?php echo $ID ?>','<?php echo $Data ?>','subkategori');
</script>