<?
//$conn->debug=true;
$id 			= $_POST['id'];
$fld_staff 		= $_POST['fld_staff'];
$fld_alamat 	= $_POST['fld_alamat'];
$fld_tel 		= $_POST['fld_tel'];
$jantina 		= $_POST['jantina'];
$fld_kp 		= $_POST['fld_kp'];
$fld_email 		= $_POST['fld_email'];
$pusatid 		= $_POST['pusatid'];
$is_pensyarah 	= $_POST['is_pensyarah'];
$is_tutor 		= $_POST['is_tutor'];
$is_warden 		= $_POST['is_warden'];
$is_hep 		= $_POST['is_hep'];
$flduser_activated = $_POST['flduser_activated'];
$is_user 		= $_POST['is_user'];

$user_name 		= $_POST['user_name'];
$strkp = str_replace("-","",$fld_kp);
if(empty($user_name)){ $user_name = $strkp; }
else if(!empty($user_name) && $user_name<>$strkp){ $user_name = $strkp; }

$PageQUERY 	= $_POST['PageQUERY'];
$PageNo = $_POST['PageNo'];

if(empty($id)){
	//echo "insert";
	$id = "DQ_". uniqid();
	$sql = "INSERT INTO _sis_tblstaff(staff_id, fld_staff, fld_alamat, fld_tel, 
	fld_jantina, fld_kp, fld_email, is_pensyarah, is_tutor, 
	is_warden, is_hep, flduser_activated, is_user, fldpusat, 
	flduser_name, create_dt, create_by)
	VALUES(".tosql($id,"Text").", ".tosql($fld_staff,"Text").", ".tosql($fld_alamat,"Text").", ".tosql($fld_tel,"Text").", 
	".tosql($jantina,"Text").", ".tosql($fld_kp,"Text").", ".tosql($fld_email,"Text").", ".tosql($is_pensyarah,"Text").", ".tosql($is_tutor,"Text").", 
	".tosql($is_warden,"Text").", ".tosql($is_hep,"Text").", ".tosql($flduser_activated,"Number").", ".tosql($is_user,"Number").", ".tosql($pusatid,"Number").", 
	".tosql($user_name,"Text"). ", ".tosql(date("Y-m-d H:i:s"),"Text").", ".tosql('',"Text").")";
	$result = $conn->Execute($sql);
	if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
	if($is_user=='1'){
		$pass = md5("123");
		$sql1 = "UPDATE _sis_tblstaff SET flduser_password=".tosql($pass,"Text")." 
		WHERE staff_id=".tosql($id,"Text");
		$result = $conn->Execute($sql1);
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
	}
	$url = base64_encode($userid.';apps/staff/staff_list.php;staff;staff;');
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
} else {
	//echo "Update";
	$sql = "";
	$sql = "UPDATE _sis_tblstaff SET fld_staff=".tosql($fld_staff,"Text").
	", fld_alamat=".tosql($fld_alamat,"Text").", fld_tel=".tosql($fld_tel,"Text").
	", fld_jantina=".tosql($jantina,"Text").", fld_kp=".tosql($fld_kp,"Text").
	", fld_email=".tosql($fld_email,"Text").", is_pensyarah=".tosql($is_pensyarah,"Text").
	", is_tutor=".tosql($is_tutor,"Text").", is_warden=".tosql($is_warden,"Text").
	", is_hep=".tosql($is_hep,"Text").", flduser_activated=".tosql($flduser_activated,"Number").
	", is_user=".tosql($is_user,"Number").", update_dt=".tosql(date("Y-m-d H:i:s"),"Text").
	", flduser_name=".tosql($user_name,"Number"). ", fldpusat=".tosql($pusatid,"Number"). ", update_by=".tosql("","Text").
	" WHERE staff_id=".tosql($id,"Text");
	$result = $conn->Execute($sql);
	if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
	if($is_user=='1'){
		$sql_s = "SELECT * FROM _sis_tblstaff WHERE staff_id=".tosql($id,"Text")." AND flduser_name IS NULL";
		$rs = $conn->Execute($sql_s);
		if(!$rs->EOF) {
			$pass = md5("123");
			$sql1 = "UPDATE _sis_tblstaff SET flduser_password=".tosql($pass,"Text")." 
			WHERE staff_id=".tosql($id,"Text");
			$result = $conn->Execute($sql1);
			if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		}
	}
	//exit;
	$url = base64_encode($userid.';apps/staff/user_form.php;admin;user;'.$id);
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
}
?>