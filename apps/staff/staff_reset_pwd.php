<? 
require_once '../../common.php';
include '../../loading_pro.php';
$id_kakitangan = $_GET['kid'];

//$id = dlookup("_sis_tblstaff","flduser_name","staff_id=".tosql($id_kakitangan,"Text"));
//$pwd=md5("P@22w0rd1t12");
$pwd=md5("Password@123");
$sql = "UPDATE _tbl_user SET f_password=".tosql($pwd,"Text").", f_aktif=1,  
		f_updatedt=".tosql(date("Y-m-d H:i:s"),"Text") .", f_updateby=".tosql($_SESSION["s_userid"],"Text")." 
		WHERE id_user=".tosql($id_kakitangan,"Text");
$result = $conn->execute($sql);
//echo $sql; exit;
if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
?>
<script language="javascript" type="text/javascript">
	<!--
	//parent.location.reload();
	parent.emailwindow.hide();
	//-->
</script>