<?php
//if(file_exists('../common.php')){
//	include_once '../common.php';
//}
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$f_peserta_noic=isset($_REQUEST["f_peserta_noic"])?$_REQUEST["f_peserta_noic"]:"";
$pass=isset($_REQUEST["pass"])?$_REQUEST["pass"]:"";
$idk=isset($_REQUEST["idk"])?$_REQUEST["idk"]:"";
if(empty($proses)){
	$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
}
//$proses = $_GET['pro'];

//$conn->debug=true;
//print "PRO:".$proses;
if(!empty($proses) && $proses=='DAFTAR'){
	extract($_POST);
	//$idp = uniqid(date("Ymd"));
	$sqlu = "SELECT * FROM _tbl_peserta WHERE is_deleted=0 AND f_peserta_noic=".tosql($f_peserta_noic);
	$rspe = &$conn->execute($sqlu);	
	if($rspe->EOF){
		$idp = uniqid(date("Ymd"));
		$sql = "INSERT INTO _tbl_peserta(id_peserta, f_peserta_noic, f_peserta_nama, f_peserta_grp, f_title_grade, 
		f_peserta_jantina, BranchCd,
		f_peserta_tel_pejabat, f_peserta_tel_rumah, f_peserta_hp, f_peserta_faks, f_peserta_email,
		f_peserta_alamat1, f_peserta_alamat2, f_peserta_alamat3, f_peserta_poskod, f_peserta_negeri,
		f_peserta_lahir, nama_ketuajabatan, email_ketuajabatan, jawatan_ketuajabatan)
		VALUES(".tosql($idp).", ".tosql(strtoupper($f_peserta_noic)).", ".tosql(strtoupper($f_peserta_nama)).", ".tosql($f_peserta_grp).", ".tosql($f_title_grade).", 
		".tosql($f_peserta_jantina).", ".tosql($BranchCd).", 
		".tosql($f_peserta_tel_pejabat).", ".tosql($f_peserta_tel_rumah).", ".tosql($f_peserta_hp).", ".tosql($f_peserta_faks).", ".tosql($f_peserta_email).", 
		".tosql($f_peserta_alamat1).", ".tosql($f_peserta_alamat2).", ".tosql($f_peserta_alamat3).", ".tosql($f_peserta_poskod).", ".tosql($f_peserta_negeri).", 
		".tosql(DBDate($f_peserta_lahir)).", ".tosql($nama_ketuajabatan,"Text").", ".tosql($email_ketuajabatan,"Text").", ".tosql($jawatan_ketuajabatan,"Text").")";
		//print $sql;
		$conn->execute($sql);
		$id_peserta=$idp;
		audit_trail($sql);
	} else {
		extract($_POST);
		$pass_check = $_POST['pass_check'];
		//$conn->debug=true;
		$sql = "UPDATE _tbl_peserta SET ". 
		" f_peserta_nama=".tosql(strtoupper($f_peserta_nama),"Text").", f_peserta_grp=".tosql($f_peserta_grp,"Text").", f_title_grade=".tosql($f_title_grade,"Text").
		", f_peserta_jantina=".tosql($f_peserta_jantina,"Text").", BranchCd=".tosql($BranchCd,"Text").
		", f_peserta_tel_pejabat=".tosql($f_peserta_tel_pejabat,"Text").", f_peserta_tel_rumah=".tosql($f_peserta_tel_rumah,"Text").
		", f_peserta_hp=".tosql($f_peserta_hp,"Text").", f_peserta_faks=".tosql($f_peserta_faks,"Text").
		", f_peserta_email=".tosql($f_peserta_email,"Text").", f_peserta_alamat1=".tosql($f_peserta_alamat1,"Text").", 
		f_peserta_alamat2=".tosql($f_peserta_alamat2,"Text").
		", f_peserta_alamat3=".tosql($f_peserta_alamat3,"Text").", f_peserta_poskod=".tosql($f_peserta_poskod,"Text").
		", f_peserta_negeri=".tosql($f_peserta_negeri,"Text").", f_peserta_lahir=".tosql(DBDate($f_peserta_lahir),"Text").
		", update_dt=".tosql(date("Y-m-d H:i:s"),"Text"). ", update_by=".tosql($user,"Text"). 
		", f_peserta_negara=".tosql($insnationality,"Text").
		", nama_ketuajabatan=".tosql($nama_ketuajabatan,"Text").", email_ketuajabatan=".tosql($email_ketuajabatan,"Text").
		", jawatan_ketuajabatan=".tosql($jawatan_ketuajabatan,"Text").
		" WHERE id_peserta=".tosql($id_peserta,"Text");
	
		$result = $conn->Execute($sql);
		audit_trail($sql);
	}
	//print "<br>PC:".$pass_check."<br>";
	if(!empty($pass_check)){ 
		$conn->Execute("UPDATE _tbl_peserta SET f_pass=".tosql(md5($fpass))." WHERE id_peserta=".tosql($id_peserta,"Text"));
	}
	//$conn->debug=true;
	$sqlus = "SELECT * FROM _tbl_kursus_jadual_peserta WHERE is_deleted=0 AND peserta_icno=".tosql($f_peserta_noic)." AND EventId=".tosql($idk);
	$rspes = &$conn->execute($sqlus);	
	if($rspes->EOF){
		$sqli ="INSERT INTO _tbl_kursus_jadual_peserta (peserta_icno, EventId, InternalStudentSelectedDt, InternalStudentInputDt, InternalStudentInputBy, is_selected, 
		nama_ketuajabatan, email_ketuajabatan, jawatan_ketuajabatan)
		VALUES (".tosql($f_peserta_noic).", ".tosql($idk).", ".tosql(date("Y-m-d H:i:s")).", ".tosql(date("Y-m-d H:i:s")).", ".tosql($f_peserta_noic).",0, 
		".tosql($nama_ketuajabatan).", ".tosql($email_ketuajabatan).", ".tosql($jawatan_ketuajabatan).")";
		//print $sqli; exit;
		$conn->Execute($sqli);
		audit_trail($sqli);
	}
	
	//exit;

	$sSQL="SELECT * FROM _tbl_peserta A, _tbl_kursus_jadual_peserta B 
	WHERE A.f_peserta_noic=B.peserta_icno AND A.f_peserta_noic = ".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($idk);
	$rs = &$conn->Execute($sSQL);
	//if(!$rs->EOF){
	$nokp = $rs->fields['f_peserta_noic'];	
	$tarikh = DisplayDate($rs->fields['InternalStudentInputDt']);	
	$nama = strtoupper($rs->fields['f_peserta_nama']);	
	$jabatan = strtoupper(dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rs->fields['BranchCd'])));	
	//$kursus = strtoupper(dlookup("_tbl_kursus","coursename","f_tbcode=".tosql($rs->fields['BranchCd'])));		
	//$nokp = $rs->fields['$data'];	
	//$nokp = $rs->fields['$data'];
	
	$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm , D.objektif, D.jadual_masa, D.kandungan, D.startdate, D.enddate, 
	D.penyelaras, D.penyelaras_notel, D.penyelaras_email 
	FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
	WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($idk,"Next");
	$rskursus = &$conn->Execute($sSQL);
	$coursename = strtoupper($rskursus->fields['coursename']);
	$tarikh_kursus = DisplayDate($rskursus->fields['startdate']).' - '.DisplayDate($rskursus->fields['enddate']);
	$tempat = strtoupper(dlookup("_tbl_bilikkuliah","f_bilik_nama","f_bilikid=".tosql($rskursus->fields['bilik_kuliah'])));
	$penyelaras = strtoupper($rskursus->fields['penyelaras']);
	$penyelaras_notel = strtoupper($rskursus->fields['penyelaras_notel']);
	$penyelaras_email = $rskursus->fields['penyelaras_email'];
	
	if(file_exists('../surat/surat_permohonan.php')){
		include '../surat/surat_permohonan.php';
		include '../surat/surat_penyelia.php';
	} else {
		include 'surat/surat_permohonan.php';
		include 'surat/surat_penyelia.php';
	}
	
	if($pass_check==0 && !empty($f_pass)){ 
		//$conn->Execute("UPDATE _tbl_peserta SET f_pass=".tosql(md5($fpass))." WHERE id_peserta=".tosql($idp,"Text"));
	}
	
	//exit;
}

//include '../surat/surat_permohonan.php';
//include '../surat/surat_penyelia.php';
//print dlookup("_tbl_surat","surat","surat_jenis='S' AND peserta_icno=".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($idk));
//print dlookup("_tbl_surat","surat","surat_jenis='E' AND peserta_icno=".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($idk));

$msg='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/printemail.css" rel="stylesheet" type="text/css" media="all">
</head>
<script LANGUAGE="JavaScript">
function do_pages(URL){
	//alert(URL);
	document.ilim.action = URL;
	document.ilim.submit();
}
function form_back(URL){
	parent.emailwindow.hide();
}
</script>
</head>
<form name="ilim" method="post">
<input type="hidden" name="idk" value="<?=$idk;?>" /> 
<!-- EMAIL KEPADA PENYELIA -->
<br />
<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
    <tr><td colspan="3" height="30px" align="center" valign="middle">
        <font style="color:#FF0000;font-size:14px;font-weight:bold">
        	Permohonan tuan/puan telah didaftarkan dan akan diproses.<br /><br />
            Sila semak status permohonan tuan/puan di http://itis.islam.gov.my seminggu sebelum tarikh kursus.<br /><br />
			Sekian, terima kasih</font>
        <br /><br />
        <input type="button" value="Keluar" onclick="form_back()" />
    </td></tr>
</table>
<?php
if(file_exists('../apps/email/smtp.php')){
	include_once '../apps/email/smtp.php';
} else {
	include_once 'apps/email/smtp.php';
}
//$conn->debug=true;
$sSQL="SELECT * FROM _tbl_peserta A, _tbl_kursus_jadual_peserta B 
WHERE A.f_peserta_noic=B.peserta_icno AND A.f_peserta_noic = ".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($idk);
$rs = &$conn->Execute($sSQL);
$email_peserta = $rs->fields['f_peserta_email'];
$f_penyelia_emel = $rs->fields['email_ketuajabatan'];

$kandungan_surat = dlookup("_tbl_surat","surat","surat_jenis='S' AND peserta_icno=".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($idk));
/* penerima */
$mail_to = $email_peserta; //'nizamms@gmail.com';
/* To send HTML mail, you can set the Content-type header. */
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
/* additional headers */
$headers .= "From: webmaster<kursus_ilim@islam.gov.my>\r\n";
//$headers .= "Cc:nizamms@gmail.com\r\n";
$headers .= "bcc:\r\n";
/* perkara */
$subject = "Permohonan mengikuti kursus di ILIM";
smtpmail($mail_to, $subject, $kandungan_surat, $headers);


$kandungan_email = dlookup("_tbl_surat","surat","surat_jenis='E' AND peserta_icno=".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($idk));
/* penerima */
$mail_to = $f_penyelia_emel; //'nizamms@gmail.com';
/* To send HTML mail, you can set the Content-type header. */
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
/* additional headers */
$headers .= "From: webmaster<kursus_ilim@islam.gov.my>\r\n";
//$headers .= "Cc:itis_ilim@islam.gov.my\r\n";
//$headers .= "Cc:itis_ilim@islam.gov.my\r\n";
$headers .= "bcc:\r\n";
/* perkara */
$subject = "Permohonan mengikuti kursus di ILIM : ".$coursename; //Permohonan mengikuti kursus di ILIM : '.$nama.'
smtpmail($mail_to, $subject, $kandungan_email, $headers);

exit;
//}  
?>
</form>
