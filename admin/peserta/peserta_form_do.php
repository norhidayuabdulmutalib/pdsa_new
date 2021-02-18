<?php
//$conn->debug=true;
include '../loading_pro.php';
extract($_POST);
if(empty($id_peserta)){
	$sqls = "SELECT * FROM _tbl_peserta WHERE is_deleted=0 AND f_peserta_noic=".tosql($f_peserta_noic);
	$rsp = &$conn->query($sqls);
	if($rsp->EOF){
		echo "insert";
		$id_peserta = date("Ymd")."-". uniqid();
		$sql = "INSERT INTO _tbl_peserta(id_peserta, f_peserta_noic, f_peserta_nama, f_title_grade, 
		f_peserta_jantina, BranchCd, f_peserta_tel_pejabat, f_peserta_tel_rumah, f_peserta_hp, 
		f_peserta_faks, f_peserta_email, f_peserta_alamat1, f_peserta_alamat2, f_peserta_alamat3,
		f_peserta_poskod, f_peserta_negeri, create_dt, create_by,
		f_peserta_sah_dt, f_peserta_appoint_dt, f_peserta_lahir, f_peserta_negara,
		f_waris_nama, f_waris_alamat1, f_waris_alamat2, f_waris_alamat3, f_waris_tel,
			nama_ketuajabatan, email_ketuajabatan, jawatan_ketuajabatan)
		VALUES(".tosql($id_peserta,"Text").", ".tosql($f_peserta_noic,"Text").", ".tosql(strtoupper($f_peserta_nama),"Text").", ".tosql($f_title_grade,"Text").", 
		".tosql($f_peserta_jantina,"Text").", ".tosql($BranchCd,"Text").", ".tosql($f_peserta_tel_pejabat,"Text").", ".tosql($f_peserta_tel_rumah,"Text").", ".tosql($f_peserta_hp,"Text").", 
		".tosql($f_peserta_faks,"Text").", ".tosql($f_peserta_email,"Text").", ".tosql($f_peserta_alamat1,"Text").", ".tosql($f_peserta_alamat2,"Text").", ".tosql($f_peserta_alamat3,"Text").", 
		".tosql($f_peserta_poskod,"Text").", ".tosql($f_peserta_negeri,"Text").", ".tosql(date("Y-m-d H:i:s"),"Text").", ".tosql($UserID,"Text")."
		, ".tosql(DBDate($f_peserta_sah_dt),"Text").", ".tosql(DBDate($f_peserta_appoint_dt),"Text").", ".tosql(DBDate($f_peserta_lahir),"Text").", ".tosql($insnationality,"Text")."
		, ".tosql($f_waris_nama,"Text").", ".tosql($f_waris_alamat1,"Text").", ".tosql($f_waris_alamat2,"Text").", ".tosql($f_waris_alamat2,"Text").", ".tosql($f_waris_tel,"Text")."
		, ".tosql($nama_ketuajabatan,"Text").", ".tosql($email_ketuajabatan,"Text").", ".tosql($jawatan_ketuajabatan,"Text").")";
		$result = $conn->Execute($sql);
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		
		audit_trail($sql,"");
		/* if($is_user=='1'){
			$pass = md5("123");
			$sql1 = "UPDATE _tbl_instructor SET flduser_name=".tosql($UserID,"Text").", flduser_password=".tosql($pass,"Text")." 
			WHERE staff_id=".tosql($id,"Text");
			$result = $conn->Execute($sql1);
			if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		} */
		//exit;
		$url = base64_encode($userid.';peserta/peserta_form.php;peserta;peserta;'.$id_peserta);
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
	} else {
		print '<script language="javascript" type="text/javascript">
			alert("Maklumat peserta bernombor kad pengenalan : '.$f_peserta_noic.' telah ada dalam simpanan sistem.");
		</script>';
	}
} else {
	$sql = "";
	if($proses=='HAPUS'){
		echo "Delete";
		$sql = "UPDATE _tbl_peserta SET 
		is_deleted=1, delete_dt='".date("Y-m-d H:i:s")."', delete_by=".tosql($UserID,"Text").
		" WHERE id_peserta=".tosql($id,"Text");
		$result = $conn->Execute($sql);
		audit_trail($sql,"");
	
		$sql = "DELETE FROM _tbl_peserta_akademik WHERE id_peserta=".tosql($id,"Text");
		$result = $conn->Execute($sql);
		$sql = "DELETE FROM _tbl_peserta_kursusluar WHERE id_peserta=".tosql($id,"Text");
		$result = $conn->Execute($sql);
		//exit;
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		$url = base64_encode($userid.';peserta/peserta_list.php;peserta;peserta');
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
	} else {
		echo "Update";
		$sql = "UPDATE _tbl_peserta SET f_peserta_noic=".tosql($f_peserta_noic,"Text").
		", f_peserta_nama=".tosql($f_peserta_nama,"Text").", f_title_grade=".tosql($f_title_grade,"Text").
		", f_peserta_jantina=".tosql($f_peserta_jantina,"Text").", BranchCd=".tosql($BranchCd,"Text").
		", f_peserta_appoint_dt=".tosql(DBDate($f_peserta_appoint_dt),"Text").", f_peserta_sah_dt=".tosql(DBDate($f_peserta_sah_dt),"Text").
		", f_peserta_tel_pejabat=".tosql($f_peserta_tel_pejabat,"Text").", f_peserta_tel_rumah=".tosql($f_peserta_tel_rumah,"Text").
		", f_peserta_hp=".tosql($f_peserta_hp,"Text").", f_peserta_faks=".tosql($f_peserta_faks,"Text").
		", f_peserta_email=".tosql($f_peserta_email,"Text").", f_peserta_alamat1=".tosql($f_peserta_alamat1,"Text").", f_peserta_alamat2=".tosql($f_peserta_alamat2,"Text").
		", f_peserta_alamat3=".tosql($f_peserta_alamat3,"Text").", f_peserta_poskod=".tosql($f_peserta_poskod,"Text").
		", f_peserta_negeri=".tosql($f_peserta_negeri,"Text").", f_peserta_lahir=".tosql(DBDate($f_peserta_lahir),"Text").
		", f_peserta_negara=".tosql($insnationality,"Text").
		", f_waris_nama=".tosql($f_waris_nama,"Text").", f_waris_alamat1=".tosql($f_waris_alamat1,"Text").
		", f_waris_alamat2=".tosql($f_waris_alamat2,"Text").", f_waris_alamat3=".tosql($f_waris_alamat3,"Text").
		", f_waris_tel=".tosql($f_waris_tel,"Text").
		", nama_ketuajabatan=".tosql($nama_ketuajabatan,"Text").", email_ketuajabatan=".tosql($email_ketuajabatan,"Text").
		", jawatan_ketuajabatan=".tosql($jawatan_ketuajabatan,"Text").
		", update_dt=".tosql(date("Y-m-d H:i:s"),"Text"). ", update_by=".tosql($UserID,"Text"). 
		" WHERE id_peserta=".tosql($id_peserta,"Text");

		$result = $conn->Execute($sql);
		//exit;
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		audit_trail($sql,"");

		$url = base64_encode($userid.';peserta/peserta_form.php;peserta;peserta;'.$id_peserta);
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
	}
}
?>