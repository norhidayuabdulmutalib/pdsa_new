<?
include '../../common.php';
$conn->debug=true;
$code = $_GET['code'];
$kampus = $_GET['kampus'];
$lst = $_GET['lst'];
$sSQL="SELECT * FROM _tbl_kursus_catsub WHERE f_status=0 AND f_category_code = '".$code."' ";
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus)){ $sSQL .= " AND kampus_id=".$kampus; }
$sSQL.=" ORDER BY SubCategoryNm";
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