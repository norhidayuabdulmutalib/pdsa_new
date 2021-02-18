<?php
//$conn->debug=true;
$userid=isset($_REQUEST["up_userid"])?$_REQUEST["up_userid"]:"";
$pass=isset($_REQUEST["up_password"])?$_REQUEST["up_password"]:"";

$sql = "SELECT * FROM kakitangan WHERE userid=".tosql($userid)." AND pass = ".tosql(md5($pass));
$rsLogin = &$conn->Execute($sql);
if(!$rsLogin->EOF){
	@session_start();
	//session_regenerate_id();
	//$row = mysql_fetch_array($result, MYSQL_BOTH);
	$_SESSION['session_id_kakitangan'] = $rsLogin->fields['id_kakitangan'];
	$_SESSION['session_id_bahagian'] = $rsLogin->fields['id_bahagian'];
	$_SESSION['session_userid'] = $rsLogin->fields['userid'];
	$_SESSION['session_nama'] = $rsLogin->fields['nama_kakitangan'];
	$_SESSION['session_status'] = $rsLogin->fields['type'];
	$_SESSION["s_level"] = $rsLogin->fields['f_level'];
	//$_SESSION['session_status'] = $result->fields['type'];
	//if($result->fields['type']=='P'){
	$_SESSION['session_bahagian'] = dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rsLogin->fields['id_bahagian']));
	
	if($rsLogin->fields['type']=='A' || $rsLogin->fields['type']=='U'){ $_SESSION['session_admin']='A'; } 
	else { $_SESSION['session_admin']=''; }  	
	//}
	//header('Location: left.php');
	$url = "index.php?data=".base64_encode('main;main_home.php');
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=".$url."\">";
	//exit;
} else {
	//header('Location: left.php');
	print '<script language="javascript">
		alert("Maaf anda gagal untuk masuk ke dalam sistem e-Perlimen.");
		window.open(\'index.php\',\'_parent\')
		</script>';
}
?>