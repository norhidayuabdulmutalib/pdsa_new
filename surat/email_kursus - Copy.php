<?php
include_once '../common.php';
include_once '../apps/email/smtp.php';
$idk=isset($_REQUEST["idk"])?$_REQUEST["idk"]:"";
//$conn->debug=true;
$sSQL="SELECT A.f_peserta_noic, B.EventId, A.f_peserta_nama, A.f_peserta_email, B.email_ketuajabatan, C.penyelaras_email, C.startdate, C.enddate, D.coursename 
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

$dates = $startdate . " hingga " . $enddate;


$surat = '<html><body>
<table width="800px" cellpadding="5" cellspacing="1" border="0" align="center">
	<tr><td height="20px" colspan="4">&nbsp;</td></td>

	<tr>
    	<td width="10%">&nbsp;</td>
    	<td width="20%">&nbsp;</td>
    	<td width="3%">&nbsp;</td>
    	<td width="67%">&nbsp;</td>
    </tr>
	<tr>
    	<td align="left" colspan="4">Tuan/Puan</td>
    </tr>
	<tr>
    	<td align="left" colspan="4"><br /></td>
    </tr>
	<tr>
    	<td align="left" colspan="4">Saya dengan segala hormatnya merujuk kepada perkara diatas.</td>
    </tr>
	<tr>
    	<td align="left" colspan="4"><br /></td>
    </tr>
	<tr>
    	<td align="left" colspan="4">2.&nbsp;&nbsp;Sukacita dimaklumkan bahawa pegawai dari jabatan tuan/puan, '.strtoupper(addslashes($f_peserta_nama)).' telah dipilih untuk 
		mengikuti kursus/bengkel '.addslashes($coursename).' dari '.$dates.' bertempat di Institut Latihan Islam Malaysia (ILIM), Bangi.  
		Sehubungan dengan itu, tuan/puan boleh mencetak surat tawaran menerusi pautan berikut:-<br><br>
		<a href="http://itis.islam.gov.my/surat/surat_tawaran.php?ic='.$f_peserta_noic.'&id='.$EventId.'">[ CETAK SURAT TAWARAN ]</a><br><br></td>
    </tr>
	<tr>
    	<td align="left" colspan="4"><br /></td>
    </tr>
	<tr>
    	<td align="left" colspan="4">3.&nbsp;&nbsp;Status permohonan pegawai tuan/puan boleh disemak melalui URL 
		<a href="http://itis.islam.gov.my/katalog/semakan_permohonan_online.php?nokp='.$f_peserta_noic.'">http://itis.islam.gov.my/katalog/status_permohonan.php</a><br></td>
    </tr>
	<tr>
    	<td align="left" colspan="4"><br /><br /><br />Sekian, terima kasih.<br /><br /></td>
    </tr>
	<tr>
    	<td align="left" colspan="4" valign="top" height="30px"><strong>"ILIM, Pusat Kecemerlangan Islam"</strong></td>
    </tr>
	<tr>
    	<td align="left" colspan="4" height="60px"><br /></td>
    </tr>
	<tr>
    	<td align="left" colspan="4"><b>'.strtoupper(addslashes($penyelaras)).'</b></td>
    </tr>
	<tr>
    	<td align="left" colspan="4">b.p Pengarah</td>
    </tr>
	<tr>
    	<td align="left" colspan="4">Institut Latihan Islam Malaysia (ILIM)</td>
    </tr>
	<tr>
    	<td align="left" colspan="4"><br><br>Emel : '.$penyelaras_email.'</td>
    </tr>
	<tr>
    	<td align="left" colspan="4" height="60px"><br /></td>
    </tr>
	<tr>
    	<td align="left" colspan="4">E-mel makluman ini dijana menerusi sistem. Oleh itu, tanda tangan tidak diperlukan.<br /><br /></td>
    </tr>
</table>
</body>
</html>';

//$conn->debug=true;
$rss = $conn->execute("SELECT * FROM _tbl_surat WHERE surat_jenis='T' AND peserta_icno=".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($idk));
if($rss->EOF){
	$sqle = "INSERT INTO _tbl_surat(peserta_icno, EventId, surat_jenis, surat_tarikh, surat, create_by, create_dt) ";
	$sqle .= "VALUES(".tosql($f_peserta_noic).", ".tosql($EventId).", ".tosql("T").", ".tosql(date("Y-m-d")).", ".tosql($surat).", ".tosql($by).", ".tosql(date("Y-m-d H:i:s")).")";
	$conn->Execute($sqle);
}

$kandungan_email = dlookup("_tbl_surat","surat","surat_jenis='T' AND peserta_icno=".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($EventId));
/* penerima */
$mail_to = $f_penyelia_emel; //'nizamms@gmail.com';
/* To send HTML mail, you can set the Content-type header. */
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
/* additional headers */
$headers .= "From: webmaster<kursus_ilim@islam.gov.my>\r\n";
//$headers .= "Cc:itis_ilim@islam.gov.my\r\n";
$headers .= "Cc:".$email_peserta;
if(!empty($email_penyelaras)){ $headers .= ", ".$email_penyelaras; }
$headers .= "\r\n";
$headers .= "bcc:\r\n";
/* perkara */
$subject = "Tawaran Mengikuti ".$coursename; //Permohonan mengikuti kursus di ILIM : '.$nama.'
smtpmail($mail_to, $subject, $kandungan_email, $headers);
smtpmail($email_peserta, $subject, $kandungan_email, $headers);
print '<script language="javascript" type="text/javascript">
	parent.emailwindow.hide();
</script>';
//}  
?>
</form>
