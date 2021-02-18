<?php
@session_start(); 
require_once '../common.php';
//require_once '../include/dateformat.php';

$proses = isset($_REQUEST['proses'])?$_REQUEST['proses']:"";
$id_kakitangan = isset($_REQUEST['kid'])?$_REQUEST['kid']:"";
$no_kp_kakitangan = isset($_REQUEST['nokp'])?$_REQUEST['nokp']:"";

/*$sql_d = "SELECT nama_kakitangan FROM kakitangan WHERE id_kakitangan=".$id_kakitangan;
&$conn->Execute($sql_d);
$row=mysql_fetch_array($result,MYSQL_BOTH);
$nama = $row['nama_kakitangan'];*/
//echo $no_kp_kakitangan;
//echo md5("831130015487");
if(!empty($id_kakitangan)){
	$sql = "UPDATE kakitangan SET pass=".tosql(md5($no_kp_kakitangan),"Text").", fldupdate_dt=".tosql(date("Y-m-d H:i:s")).", 
	fldupdate_by=".tosql($_SESSION['session_userid'])." WHERE id_kakitangan=".tosql($id_kakitangan,"Number");
	//print "<br>".$sql; exit;
	if(!empty($sql)){
		$conn->Execute($sql);
		//if(mysql_errno()<>0){ print "Invalid query : " . mysql_error(); exit(); }
		audit_trail($sql,"RESET PASSWORD");
	}
//exit;
?>
<script language="javascript" type="text/javascript">
	<!--
	alert("Maklumat katalaluan pengguna ini telah dikemaskini.");
	parent.emailwindow.hide();
	//-->
</script>
<?php } else { ?>
<script language="javascript" type="text/javascript">
	<!--
	alert("Terdapat ralat semasa pengemaskinian. Sila hubungi pentadbir sistem.");
	parent.emailwindow.hide();
	//-->
</script>
<?php } ?>