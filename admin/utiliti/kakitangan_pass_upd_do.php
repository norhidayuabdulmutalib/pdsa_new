<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td width="100%" height="150px" bgcolor="#FFFFFF">
<?php
include '../loading_pro.php';

$id = $_SESSION['s_userid'];
$new_pass1 = $_POST['new_pass1'];

if(!empty($id) && !empty($new_pass1)){
	$sql = "UPDATE _tbl_user SET f_password = ".tosql(md5($new_pass1),"Text").", 
	f_updatedt=".tosql(date("Y-m-d H:i:s")).", f_updateby=".tosql($_SESSION['s_userid'])." 
	WHERE id_user=".tosql($id);
	$result = &$conn->execute($sql); 
	//print $sql; exit;
	//if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
	audit_trail($sql,"KEMASKINI KATALALUAN"); //exit;
	$url = "index.php?data=".base64_encode('user;default.php');
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=".$url."\">";
} else {
	print "PROSES GAGAL. SAMADA ANDA TELAH TERKELUAR DARIPADA SESSION ATAU KATALALUAN ANDA TIDAK DIMASUKKAN";
}
?>
&nbsp;</td></tr>
</table>
