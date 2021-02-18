<?php
include 'loading.php';
$actions = isset($_POST['actions'])?$_POST['actions']:"";
$PageNo = isset($_POST['PageNo'])?$_POST['PageNo']:"";
$gstatus = isset($_REQUEST['gstatus'])?$_REQUEST['gstatus']:"";
$gsort = isset($_REQUEST['gsort'])?$_REQUEST['gsort']:"";
$gbhg = isset($_REQUEST['gbhg'])?$_REQUEST['gbhg']:"";
$gcari = isset($_REQUEST['gcari'])?$_REQUEST['gcari']:"";

$id_kakitangan		  = isset($_POST['id_kakitangan'])?$_POST['id_kakitangan']:"";
$nama_kakitangan		= isset($_POST['nama_kakitangan'])?$_POST['nama_kakitangan']:"";
$no_kp_kakitangan 	   = isset($_POST['no_kp_kakitangan'])?$_POST['no_kp_kakitangan']:"";
$jawatan_kakitangan     = isset($_POST['jawatan_kakitangan'])?$_POST['jawatan_kakitangan']:"";
$bahagian 			   = isset($_POST['bahagian'])?$_POST['bahagian']:"";
$unit 				   = isset($_POST['lstUnit'])?$_POST['lstUnit']:"";
$userid 			     = isset($_POST['no_kp_kakitangan'])?$_POST['no_kp_kakitangan']:"";
//$pass 				= isset($_POST['pass'];
$gred 				   = isset($_POST['gred'])?$_POST['gred']:"";
$no_telefon 		     = isset($_POST['no_telefon'])?$_POST['no_telefon']:"";
$no_hp 				  = isset($_POST['no_hp'])?$_POST['no_hp']:"";
$ringkasan 			  = isset($_POST['ringkasan'])?$_POST['ringkasan']:"";
$status_a 			   = isset($_POST['status'])?$_POST['status']:"";
$types 			      = isset($_POST['type'])?$_POST['type']:"";
$email 				  = isset($_POST['email'])?$_POST['email']:"";
$is_semak 			   = isset($_POST['is_semak'])?$_POST['is_semak']:"";
$is_lulus 			   = isset($_POST['is_lulus'])?$_POST['is_lulus']:"";
$is_delete 			   = isset($_POST['is_delete'])?$_POST['is_delete']:"";

//print "STAT:".$status_a;

if($is_semak=='on'){ $semak=1; } else { $semak=0; }
if($is_lulus=='on'){ $lulus=1; } else { $lulus=0; }

// proses penghapusan data
if($actions=='DELETE'){
	$del = "1";
	$sql = "UPDATE kakitangan SET is_delete =".tosql($del,"Number")." WHERE id_kakitangan=".tosql($id_kakitangan,"Number");
	$result = &$conn->Execute($sql);
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	audit_trail($sql,"UPDATE TABLE kakitangan");
	$url = base64_encode('4;utiliti/kakitangan.php;');
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."\">";
} else {
	//if(!empty($_SESSION['session_status']) && $_SESSION['session_status']=='P'){
	//	$status_a='K';
	//}
	//$conn->debug=true;

	if($actions=='INSERT'){
		$id_kakitangan = dlookup("kakitangan","max(id_kakitangan)","1 ORDER BY id_kakitangan");
		if(!empty($id_kakitangan )){ $id_kakitangan+=1; } else { $id_kakitangan=1; } 
		// proses kemasukan data //, '$pass', 
		$sql = "INSERT INTO kakitangan(id_kakitangan,
		nama_kakitangan, no_kp_kakitangan, jawatan_kakitangan, 
		id_bahagian, id_unit, userid, 
		gred, no_telefon, no_hp, 
		status, email, is_semak, 
		is_lulus, pass, type, fldupdate_dt, fldupdate_by)
		VALUES(".$id_kakitangan.", 
		".tosql($nama_kakitangan,"Text").", ".tosql($no_kp_kakitangan,"Text").", ".tosql($jawatan_kakitangan,"Text").", 
		".tosql($bahagian,"Number").", ".tosql($unit,"Number").", ".tosql($userid,"Text").", 
		".tosql($gred,"Text").", ".tosql($no_telefon,"Text").", ".tosql($no_hp,"Text").", 
		".tosql($status_a,"Text").", ".tosql($email,"Text").", ".tosql($semak,"Number").", 
		".tosql($lulus,"Number").", ".tosql(md5($userid)).", ".tosql($types).", 
		".tosql(date("Y-m-d H:i:s"),"Text").", ".tosql($_SESSION['session_userid']).")";
		$result = &$conn->Execute($sql);
		if(!$result){ echo "Invalid query : " . mysql_error(); }
		audit_trail($sql,"TAMBAH TABLE kakitangan");
		//$id_kakitangan = mysql_insert_id();
		$url = base64_encode('4;utiliti/kakitangan.php;');
		//exit;
		//$url = base64_encode('4;utiliti/kakitangan_form.php;'.$id_kakitangan);
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."&status=".$gstatus."&bhg=".$gbhg."&sort=".$gsort."&cari=".$gcari."\">";
	
	} else if($actions=='UPDATE'){
		// proses kemaskini data
		$sql = "UPDATE kakitangan SET 
			nama_kakitangan=".tosql($nama_kakitangan,"Text").", no_kp_kakitangan=".tosql($no_kp_kakitangan,"Text").", 
			jawatan_kakitangan=".tosql($jawatan_kakitangan,"Text").", id_bahagian=".tosql($bahagian,"Number").", 
			id_unit=".tosql($unit,"Number").", gred=".tosql($gred,"Text").", 
			userid=".tosql($userid,"Text").", no_telefon=".tosql($no_telefon,"Text").", 
			no_hp=".tosql($no_hp,"Text").", type=".tosql($types,"Text").", 
			email=".tosql($email,"Text").", is_semak=".tosql($semak,"Number").", 
			is_lulus=".tosql($lulus,"Number").", fldupdate_dt=".tosql(date("Y-m-d H:i:s")).", 
			fldupdate_by=".tosql($_SESSION['session_userid']).", status=".tosql($status_a);
			//if(!empty($_SESSION['session_status']) && $_SESSION['session_status']=='A'){
			//	$sql .= ", userid='$userid', pass='$pass' ";  
			//}
		$sql .= " WHERE id_kakitangan=".tosql($id_kakitangan,"Number");
		//echo $sql; exit;
		$result = &$conn->Execute($sql);
		//if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		audit_trail($sql,"UPDATE TABLE kakitangan");
		//exit;
		//$url = base64_encode('4;utiliti/kakitangan_form.php;'.$id_kakitangan);
		$url = base64_encode('4;utiliti/kakitangan.php;');
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."&status=".$gstatus."&bhg=".$gbhg."&sort=".$gsort."&cari=".$gcari."\">";
	} else if($actions=='AKTIF'){
		// proses kemaskini data
		$del = "0";
		$sql = "UPDATE kakitangan SET is_delete =".tosql($del,"Number");
		$sql .= " WHERE id_kakitangan=".tosql($id_kakitangan,"Number");
		//echo $sql; exit;
		$result = &$conn->Execute($sql);
		//if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		audit_trail($sql,"HAPUS TABLE kakitangan");
		//exit;
		//$url = base64_encode('4;utiliti/kakitangan_form.php;'.$id_kakitangan);
		$url = base64_encode('4;utiliti/kakitangan_ta.php;');
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."&PageNo=".$PageNo."&status=".$gstatus."&bhg=".$gbhg."&sort=".$gsort."&cari=".$gcari."\">";
	} 
}
?>
