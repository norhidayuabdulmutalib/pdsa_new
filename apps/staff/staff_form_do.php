<?php
//$conn->debug=true;
include '../loading_pro.php';
$id 			= $_POST['id'];
$f_noic 		= $_POST['f_noic'];
$f_name 		= $_POST['f_name'];
$f_alamat1 		= $_POST['f_alamat1'];
$f_alamat2 		= $_POST['f_alamat2'];
$f_alamat3 		= $_POST['f_alamat3'];
$f_notel 		= $_POST['f_notel'];
$f_jawatan 		= $_POST['f_jawatan'];
$f_email 		= $_POST['f_email'];
$f_aktif 		= $_POST['f_aktif'];
$f_level 		= $_POST['f_level'];
$f_jabatan 		= $_POST['f_jabatan'];
$kampus_id 		= $_POST['kampus_id'];

$PageQUERY 	= $_POST['PageQUERY'];
$PageNo = $_POST['PageNo'];
$proses = $_POST['proses'];

if($f_level==1){ $is_admin=1; $is_domestik=1; }
else if($f_level==2){ $is_admin=1; $is_domestik=0; }
else if($f_level==3){ $is_admin=0; $is_domestik=1; }

$user = str_replace("-","",$f_noic); 

if(empty($id)){
	echo "insert";
	//$gred = dlookup("ref_gred","gred","gred_id=".tosql($gred_id,"Number"));
	$id = "ILIM_". uniqid();
	$sql = "INSERT INTO _tbl_user(id_user, f_noic, f_name, 
	f_alamat1, f_alamat2, f_alamat3, f_notel, 
	f_email, f_jawatan, f_aktif, f_level,
	f_createdt, f_createby, f_userid, f_password, 
	is_admin, is_hostel, f_jabatan, kampus_id)
	VALUES(".tosql($id,"Text").", ".tosql($f_noic,"Text").", ".tosql($f_name,"Text").", 
	".tosql($f_alamat1,"Text").", ".tosql($f_alamat2,"Text").", ".tosql($f_alamat3,"Text").", ".tosql($f_notel,"Text").", 
	".tosql($f_email,"Text").", ".tosql($f_jawatan,"Text").", ".tosql($f_aktif,"Text").", ".tosql($f_level,"Text").", 
	".tosql(date("Y-m-d H:i:s"),"Text").", ".tosql($_SESSION["s_userid"],"Text").",".tosql($user,"Text").",". tosql(md5("Password@123")).", 
	".$is_admin.",".$is_domestik.",".$f_jabatan.",".$kampus_id.")";
	$result = $conn->Execute($sql);
	if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
	//$url = base64_encode('user;staff/staff_list.php;admin;staff;');
	$url = base64_encode('user;staff/staff_form.php;admin;staff;'.$id);
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
} else {
	echo "Update";
	$sql = "";
	if($proses=='HAPUS'){
		$sql = "UPDATE _tbl_user SET f_aktif=0, 
		f_isdeleted=1, f_isdeletedt='".date("Y-m-d H:i:s")."', f_isdeleteby=".tosql($_SESSION["s_userid"],"Text").
		" WHERE id_user=".tosql($id,"Text");
		$result = $conn->Execute($sql);
		//exit;
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		audit_trail($sql);
		$url = base64_encode('user;staff/staff_list.php;admin;staff;;');
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
	} else {
		//$gred = dlookup("ref_gred","gred","gred_id=".tosql($gred_id,"Number"));
		$sql = "UPDATE _tbl_user SET f_name=".tosql($f_name,"Text"). ", f_noic=".tosql($f_noic,"Text"). ", 
		f_jabatan=".tosql($f_jabatan,"Text").", kampus_id=".tosql($kampus_id,"Text").
		", f_alamat1=".tosql($f_alamat1,"Text").", f_alamat2=".tosql($f_alamat2,"Text").", f_alamat3=".tosql($f_alamat3,"Text").
		", f_notel=".tosql($f_notel,"Text").", f_email=".tosql($f_email,"Text").", f_jawatan=".tosql($f_jawatan,"Text").
		", f_aktif=".tosql($f_aktif,"Text").", f_level=".tosql($f_level,"Text").", f_updatedt=".tosql(date("Y-m-d H:i:s"),"Text").
		", f_updateby=".tosql($_SESSION["s_userid"],"Text").", is_admin=".tosql($is_admin,"Text").", is_hostel=".tosql($is_domestik,"Text").
		" WHERE id_user=".tosql($id,"Text");

		$result = $conn->Execute($sql);
		audit_trail($sql);
		//exit;
		$url = base64_encode('user;staff/staff_form.php;admin;staff;'.$id);
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
	}
}
?>