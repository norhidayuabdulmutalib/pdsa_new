<?
//$conn->debug=true;
include '../loading_pro.php';
extract($_POST);
$instypecd = '01';
$insid = str_replace("-","",$insid); 
$insname = strtoupper($insname);
$insdob = DBDate($insdob);
$position = dlookup("_ref_titlegred","f_gred_name","f_gred_code=".tosql($titlegredcd,"Text"));

if(empty($id)){
	echo "insert";
	$id = date("Ymd")."-". uniqid();
	$sql = "INSERT INTO _tbl_instructor(ingenid, insname, p_jantina, titlegredcd, insposition, 
	insorganization, inskategori, insid, insaddress, inspostcode, insstate, 
	inscountry, inshometel, insmobiletel, insemail, payperhours,
	instypecd, institle, insfaxno, insstatus, 
	insrace, insgender, insnationality, insreligion, insdob,
	insbank, insbankbrch, insakaun, insqual, insfieldstudy, 
	create_dt, create_by)
	VALUES(".tosql($id,"Text").", ".tosql($insname,"Text").", ".tosql($p_jantina,"Text").", ".tosql($titlegredcd,"Text").", ".tosql($position,"Text").", 
	".tosql($insorganization,"Text").", ".tosql($inskategori,"Number").", ".tosql($insid).", ".tosql($insaddress).", ".tosql($inspostcode,"Text").", ".tosql($insstate,"Text").", 
	".tosql($inscountry,"Text").", ".tosql($inshometel,"Text").", ".tosql($insmobiletel,"Text").", ".tosql($insemail,"Text").", ".tosql($payperhours,"Number").", 
	".tosql($instypecd,"Text").", ".tosql($institle,"Text").", ".tosql($insfaxno,"Text").", ".tosql($insstatus,"Text").",  
	".tosql($insrace,"Number").", ".tosql($insgender,"Text").", ".tosql($insnationality,"Text").", ".tosql($insreligion,"Text").",
	".tosql($insdob,"Text").", ".tosql($insbank,"Text").", ".tosql($insbankbrch,"Text").", ".tosql($insakaun,"Text").", ".tosql($insqual,"Text").",
	".tosql($insfieldstudy,"Number").", ".tosql(date("Y-m-d H:i:s"),"Text").", ".tosql($user,"Text").")";
	$result = $conn->Execute($sql);

	if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
	audit_trail($sql);
	/* if($is_user=='1'){
		$pass = md5("123");
		$sql1 = "UPDATE _tbl_instructor SET flduser_name=".tosql($user,"Text").", flduser_password=".tosql($pass,"Text")." 
		WHERE staff_id=".tosql($id,"Text");
		$result = $conn->Execute($sql1);
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
	} */
	$url = base64_encode('user;penceramah/penceramah_form.php;penceramah;daftar;'.$id);
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
} else {

	echo "Update";
	$sql = "";
	if($proses=='HAPUS'){
		$sql = "UPDATE _tbl_instructor SET insstatus=0,
		is_deleted=1, delete_dt='".date("Y-m-d H:i:s")."', delete_by=".tosql("","Text").
		" WHERE ingenid=".tosql($id,"Text");
		$result = $conn->Execute($sql);
		audit_trail($sql);
		
		$sql = "DELETE FROM _tbl_instructor_akademik WHERE ingenid=".tosql($id,"Text");
		$result = $conn->Execute($sql);
		
		$sql = "DELETE FROM _tbl_instructor_kepakaran WHERE ingenid=".tosql($id,"Text");
		$result = $conn->Execute($sql);

		//exit;
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		$url = base64_encode('user;penceramah/penceramah_list.php;penceramah;daftar');
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";

	} else {

		$sql = "UPDATE _tbl_instructor SET insname=".tosql($insname,"Text"). ", p_jantina=".tosql($p_jantina,"Text").
		", titlegredcd=".tosql($titlegredcd,"Text").", insposition=".tosql($position,"Text").
		", insorganization=".tosql($insorganization,"Text").", inskategori=".tosql($inskategori,"Text").", insid=".tosql($insid,"Text").
		", insaddress=".tosql($insaddress,"Text").", inspostcode=".tosql($inspostcode,"Text").
		", insstate=".tosql($insstate,"Text").", inscountry=".tosql($inscountry,"Text").
		", inshometel=".tosql($inshometel,"Text").", insmobiletel=".tosql($insmobiletel,"Text").", insemail=".tosql($insemail,"Text").
		", payperhours=".tosql($payperhours,"Number").", instypecd=".tosql($instypecd,"Text").", institle=".tosql($institle,"Text").", insfaxno=".tosql($insfaxno,"Text").
		", insstatus=".tosql($insstatus,"Text"). ", insrace=".tosql($insrace,"Text"). ", insgender=".tosql($insgender,"Text").
		", insnationality=".tosql($insnationality,"Text").", insreligion=".tosql($insreligion,"Text").", insdob=".tosql($insdob,"Text").
		", insbank=".tosql($insbank,"Text").", insbankbrch=".tosql($insbankbrch,"Text").", insakaun=".tosql($insakaun,"Text").
		", insqual=".tosql($insqual,"Text").", insfieldstudy=".tosql($insfieldstudy,"Text").", update_dt=".tosql(date("Y-m-d H:i:s"),"Text").
		", update_by=".tosql($user,"Text"). " WHERE ingenid=".tosql($id,"Text");
		$result = $conn->Execute($sql);
		//exit;

		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
		audit_trail($sql);
		/* if($is_user=='1'){
			$sql_s = "SELECT * FROM _tbl_instructor WHERE staff_id=".tosql($id,"Text")." AND flduser_name IS NULL";
			$rs = $conn->Execute($sql_s);
			if($rs->EOF) {
				$user = str_replace("-","",$rs->fields['fld_kp']);
				$pass = md5("123");
				$sql1 = "UPDATE _tbl_instructor SET flduser_name=".tosql($user,"Text").", flduser_password=".tosql($pass,"Text")." 
				WHERE staff_id=".tosql($id,"Text");
				$result = $conn->Execute($sql1);
				if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
			}
		} */
		//exit;
		//$url = base64_encode('user;penceramah/penceramah_form.php;penceramah;daftar;'.$id);
		$url = base64_encode('user;penceramah/penceramah_list.php;penceramah;daftar;');
		echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
	}
}
?>