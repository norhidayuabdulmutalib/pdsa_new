<?php
//$conn->debug=true;
include '../loading_pro.php';
extract($_POST);
if(empty($id)){
	echo "insert";
	$sql = "INSERT INTO _tbl_claim(kampus_id, cl_ins_id, cl_depcd, cl_accoffcd, cl_ptjdesc, cl_ptjcd, 
	cl_payctrdesc, cl_payctrcd, cl_brchdesc, cl_brchcd, cl_doctype, 
	cl_docno, cl_month, cl_year, cl_tarafpost, cl_gaji,
	cl_elaun, cl_gajino, cl_orgdesc, cl_orgadd, 
	cl_bank, cl_bankbrch, cl_akaun, 
	is_deleted, create_dt, create_by)
	VALUES(".tosql($_SESSION['SESS_KAMPUS'],"Text").", ".tosql($_SESSION['ingenid'],"Text").", ".tosql($cl_depcd,"Text").", ".tosql($cl_accoffcd,"Text").", ".tosql($cl_ptjdesc,"Text").", ".tosql($cl_ptjcd,"Text").", 
	".tosql($cl_payctrdesc,"Text").", ".tosql($cl_payctrcd,"Text").", ".tosql($cl_brchdesc,"Text").", ".tosql($cl_brchcd,"Text").", ".tosql($cl_doctype,"Text").", 
	".tosql($cl_docno,"Text").", ".tosql($cl_month,"Text").", ".tosql($cl_year,"Text").", ".tosql($cl_tarafpost,"Text").", ".tosql($cl_gaji,"Number").", 
	".tosql($cl_elaun,"Text").", ".tosql($cl_gajino,"Text").", ".tosql($cl_orgdesc,"Text").", ".tosql($cl_orgadd,"Text").", 
	".tosql($cl_bank,"Text").", ".tosql($cl_bankbrch,"Text").", ".tosql($cl_akaun,"Text").", 0,    
	".tosql(date("Y-m-d H:i:s"),"Text").", ".tosql($user,"Text").")";
	$result = $conn->Execute($sql);

	$conn->Execute("UPDATE _tbl_instructor SET payperhours=".tosql($payperhours)." WHERE ingenid=".tosql($_SESSION['ingenid']));

	if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
	$url = base64_encode($userid.';penceramah/claim_form.php;penceramah;tuntutan'.$id);
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
} else {
	echo "Update";
	$sql = "";
	if($proses=='HAPUS'){
		$sql = "UPDATE _tbl_claim set is_deleted=1, delete_dt='".date("Y-m-d H:i:s")."', delete_by=".tosql("","Text").
		" WHERE cl_id=".tosql($id,"Text");
		$result = $conn->Execute($sql);
		//exit;
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		$url = base64_encode($userid.';penceramah/penceramah_claim.php;penceramah;tuntutan'.$id);
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
	} else {
		$sql = "UPDATE _tbl_claim SET cl_depcd=".tosql($cl_depcd,"Text").
		", cl_accoffcd=".tosql($cl_accoffcd,"Text").", cl_ptjdesc=".tosql($cl_ptjdesc,"Text").
		", cl_ptjcd=".tosql($cl_ptjcd,"Text").", cl_payctrdesc=".tosql($cl_payctrdesc,"Text").
		", cl_payctrcd=".tosql($cl_payctrcd,"Text").", cl_brchdesc=".tosql($cl_brchdesc,"Text").
		", cl_brchcd=".tosql($cl_brchcd,"Text").", cl_doctype=".tosql($cl_doctype,"Text").
		", cl_docno=".tosql($cl_docno,"Text").", cl_month=".tosql($cl_month,"Text").", cl_year=".tosql($cl_year,"Text").
		", cl_tarafpost=".tosql($cl_tarafpost,"Text").", cl_gaji=".tosql($cl_gaji,"Number").", cl_elaun=".tosql($cl_elaun,"Text").
		", cl_gajino=".tosql($cl_gajino,"Text").
		", cl_orgdesc=".tosql($cl_orgdesc,"Text"). ", cl_orgadd=".tosql($cl_orgadd,"Text"). ",update_dt=".tosql(date("Y-m-d H:i:s"),"Text").
		", cl_bank=".tosql($cl_bank,"Text"). ", cl_bankbrch=".tosql($cl_bankbrch,"Text"). ",cl_akaun=".tosql($cl_akaun,"Text").
		", update_by=".tosql($user,"Text"). ", is_process=".tosql($is_process)." WHERE cl_id =".tosql($id,"Number");

		$result = $conn->Execute($sql);
		
		$conn->Execute("UPDATE _tbl_instructor SET payperhours=".tosql($payperhours)." WHERE ingenid=".tosql($ingid));
		
		//exit;
		
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		/* if($is_user=='1'){
			$sql_s = "SELECT * FROM _tbl_claim WHERE staff_id=".tosql($id,"Text")." AND flduser_name IS NULL";
			$rs = $conn->Execute($sql_s);
			if($rs->EOF) {
				$user = str_replace("-","",$rs->fields['fld_kp']);
				$pass = md5("123");
				$sql1 = "UPDATE _tbl_claim SET flduser_name=".tosql($user,"Text").", flduser_password=".tosql($pass,"Text")." 
				WHERE staff_id=".tosql($id,"Text");
				$result = $conn->Execute($sql1);
				if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
			}
		} */
		//exit;
		$url = base64_encode($userid.';penceramah/claim_form.php;penceramah;tuntutan;'.$id);
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
	}
}
?>