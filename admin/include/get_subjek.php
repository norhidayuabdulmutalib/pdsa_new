<?php
include '../../common.php';
$conn->debug=true;
$code = $_GET['code'];
$pusat = $_GET['pusat'];
$lst = $_GET['lst'];
$sSQL="SELECT * FROM _tbl_kursus WHERE is_deleted=0 AND category_code = '".$code."' AND subcategory_code = '".$pusat."' ";
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
$sSQL.=" ORDER BY courseid, coursename";
$rsData = &$conn->Execute($sSQL);
//$result = mysql_query($strSQL,$dbLink);
$ID = '';
$Data = '';
while (!$rsData->EOF){
	if(empty($ID)){
		$ID = $rsData->fields['id'];
		$Data = $rsData->fields['courseid'] . ' - ' . addslashes(str_replace(","," - ",$rsData->fields['coursename']));
		//$Data = $row[1];
	}else{
		$ID = $ID.','.$rsData->fields['id'];
		$Data = $Data.','.$rsData->fields['courseid'] . ' - ' . addslashes(str_replace(","," - ",$rsData->fields['coursename']));
		//$ID = $ID.','.$row[0];
		//$Data = $Data.','.$row[1];
	}
	$rsData->movenext();
}
//$ID .= ","; $Data .= ",";
//echo $ID;
?>     
<script type="text/javascript">
  window.parent.handleResponse('<?php print $ID ?>','<?php print $Data ?>','subjek');
</script>