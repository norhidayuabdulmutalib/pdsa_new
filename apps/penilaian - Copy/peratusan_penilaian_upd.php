<?php include_once '../../common.php';
$conn->debug=true;
$pkid=isset($_REQUEST["pkid"])?$_REQUEST["pkid"]:"";
$pk1=isset($_REQUEST["pk1"])?$_REQUEST["pk1"]:"";
$pk2=isset($_REQUEST["pk2"])?$_REQUEST["pk2"]:"";
$pk3=isset($_REQUEST["pk3"])?$_REQUEST["pk3"]:"";
$pk4=isset($_REQUEST["pk4"])?$_REQUEST["pk4"]:"";
$pk5=isset($_REQUEST["pk5"])?$_REQUEST["pk5"]:"";

$sSQL="UPDATE _tbl_penilaian_kursus SET
pk_1=$pk1, pk_2=$pk2, pk_3=$pk3, pk_4=$pk4, pk_5=$pk5 
WHERE pk_id = ".$pkid;
$conn->execute($sSQL);
?>
<script language="javascript">
	//parent.location.reload();
</script>

