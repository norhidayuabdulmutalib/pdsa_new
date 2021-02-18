<?
 require_once '../common.php';

//$conn->debug=true;
$intIDBlok = $_GET['IDBlok'];
//$lst = $_GET['lst'];
$lst = "bilik_id";
$sSQL="SELECT * FROM _sis_a_tblbilik WHERE blok_id = ".$intIDBlok." AND status_bilik = 0  AND is_deleted = 0 AND keadaan_bilik = 1 ORDER BY no_bilik, bilik_id";
$rs = $conn->Execute($sSQL);
//$result = mysql_query($strSQL,$dbLink);
$ID = '';
$Data = '';
while(!$rs->EOF) {
	if(empty($ID)){
		$ID = $rs->fields['bilik_id'];
		$Data = $rs->fields['no_bilik'];
		//$Data = $row[1];
	}else{
		$ID = $ID.';'.$rs->fields['bilik_id'];
		$Data = $Data.';'.$rs->fields['no_bilik'];
		//$ID = $ID.','.$row[0];
		//$Data = $Data.','.$row[1];
	}
	$rs->movenext();
}
$rs->Close();

//echo $Data;
mysql_close();
?>     
<script type="text/javascript">
  window.parent.handleResponse('<? echo $ID ?>','<? echo $Data ?>','<? echo $lst ?>');
</script>
