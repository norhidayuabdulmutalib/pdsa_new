<?php
include_once '../common.php';
include_once '../apps/email/smtp.php';
$idk=isset($_REQUEST["idk"])?$_REQUEST["idk"]:"";
//$conn->debug=true;
$sSQL="SELECT A.f_peserta_noic, B.EventId, A.f_peserta_nama, A.f_peserta_email, B.email_ketuajabatan, B.surat_tawaran, B.surat_majikan, 
C.penyelaras_email, C.startdate, C.enddate, D.coursename 
FROM _tbl_peserta A, _tbl_kursus_jadual_peserta B, _tbl_kursus_jadual C, _tbl_kursus D	 
WHERE A.f_peserta_noic=B.peserta_icno AND C.id=B.EventId AND C.courseid=D.id
AND B.InternalStudentId = ".tosql($idk,"Text");
$rs = &$conn->Execute($sSQL);
$f_peserta_noic = $rs->fields['f_peserta_noic']; 
$EventId = $rs->fields['EventId']; 

$f_penyelia_emel = $rs->fields['email_ketuajabatan'];
$email_peserta = $rs->fields['f_peserta_email']; 
$email_penyelaras = $rs->fields['penyelaras_email']; 
$f_peserta_nama = $rs->fields['f_peserta_nama']; 
$coursename = $rs->fields['coursename']; 
$startdate = DisplayDate($rs->fields['startdate']); 
$enddate = DisplayDate($rs->fields['enddate']); 
$surat_tawaran = $rs->fields['surat_tawaran']; 
$surat_majikan = $rs->fields['surat_majikan']; 
$surat_kehadiran = $rs->fields['surat_jawapan']; 


$dates = $startdate . " hingga " . $enddate;


$surat = '<html><body>';

$surat.='</body>
</html>';

// EMAIL KEPADA PENYELIA
//$conn->debug=true;
$rss = $conn->execute("SELECT * FROM _tbl_surat WHERE surat_jenis='P' AND peserta_icno=".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($EventId));
if($rss->EOF){
	$sqle = "INSERT INTO _tbl_surat(peserta_icno, EventId, surat_jenis, surat_tarikh, surat, create_by, create_dt) ";
	$sqle .= "VALUES(".tosql($f_peserta_noic).", ".tosql($EventId).", ".tosql("P").", ".tosql(date("Y-m-d")).", ".tosql($surat_majikan).", 
	".tosql($by).", ".tosql(date("Y-m-d H:i:s")).")";
	$conn->Execute($sqle);
} else {
	$sqle = "UPDATE _tbl_surat SET surat=".tosql($surat_majikan).", create_by=".tosql($by).", create_dt=".tosql(date("Y-m-d H:i:s"))." 
	WHERE surat_jenis='P' AND peserta_icno=".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($EventId);
	$conn->Execute($sqle);
}

$kandungan_email = $surat_majikan; //dlookup("_tbl_surat","surat","surat_jenis='P' AND peserta_icno=".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($EventId));
/* penerima */
$mail_to = $f_penyelia_emel; //'nizamms@gmail.com';
//$mail_to = 'nizamms@gmail.com';
/* To send HTML mail, you can set the Content-type header. */
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
/* additional headers */
$headers .= "From: webmaster<kursus_ilim@islam.gov.my>\r\n";
//$headers .= "Cc:nizamms@gmail.com\r\n";
//$headers .= "Cc:".$email_peserta;
//if(!empty($email_penyelaras)){ $headers .= ", ".$email_penyelaras; }
$headers .= "\r\n";
$headers .= "bcc:\r\n";
/* perkara */
$subject = "Tawaran Mengikuti ".$coursename; //Permohonan mengikuti kursus di ILIM : '.$nama.'
smtpmail($mail_to, $subject, $kandungan_email, $headers);


// EMAIL KEPADA PESERTA
//$conn->debug=true;
$rss = $conn->execute("SELECT * FROM _tbl_surat WHERE surat_jenis='T' AND peserta_icno=".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($EventId));
if($rss->EOF){
	$sqle = "INSERT INTO _tbl_surat(peserta_icno, EventId, surat_jenis, surat_tarikh, surat, create_by, create_dt) ";
	$sqle .= "VALUES(".tosql($f_peserta_noic).", ".tosql($EventId).", ".tosql("T").", ".tosql(date("Y-m-d")).", ".tosql($surat_tawaran).", ".tosql($by).", ".tosql(date("Y-m-d H:i:s")).")";
	$conn->Execute($sqle);
} else {
	$sqle = "UPDATE _tbl_surat SET surat=".tosql($surat_majikan).", create_by=".tosql($by).", create_dt=".tosql(date("Y-m-d H:i:s"))." 
	WHERE surat_jenis='T' AND peserta_icno=".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($EventId);
	$conn->Execute($sqle);
}

$kandungan_email = $surat_tawaran; //dlookup("_tbl_surat","surat","surat_jenis='T' AND peserta_icno=".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($EventId));

$kandungan_email .= '<br>Sila klik <a href="http://itis.islam.gov.my/surat/borang_kehadiran.php?ic='.$f_peserta_noic.'&id='.$EventId.'">disini</a> untuk cetakan borang kehadiran.'; 
$kandungan_email .= "<br><br><br><br>";
/* penerima */
/* To send HTML mail, you can set the Content-type header. */
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
/* additional headers */
$headers .= "From: webmaster<kursus_ilim@islam.gov.my>\r\n";
//$headers .= "Cc:nizamms@gmail.com\r\n";
//$headers .= "Cc:".$email_penyelaras;
//if(!empty($email_penyelaras)){ $headers .= ", ".$email_penyelaras; }
$headers .= "\r\n";
$headers .= "bcc:\r\n";
/* perkara */
//$email_peserta = 'nizamms@gmail.com';
$subject = "Tawaran Mengikuti ".$coursename; //Permohonan mengikuti kursus di ILIM : '.$nama.'
smtpmail($email_peserta, $subject, $kandungan_email, $headers);

//exit; 

print '<script language="javascript" type="text/javascript">
	parent.emailwindow.hide();
</script>';
//}  
?>
</form>
