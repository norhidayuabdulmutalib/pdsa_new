<?php
$hijri = HijriCalendar::GregorianToHijri( time() );
$date_hijrah = $hijri[1].' '.HijriCalendar::monthName($hijri[0]).' '.$hijri[2];

$rsm = $conn->execute("SELECT * FROM _tbl_peserta A, _ref_tempatbertugas B WHERE A.BranchCd=B.f_tbcode AND A.f_peserta_noic=".tosql($p_ic));
$nama_jabatan = $rsm->fields['f_tempat_nama'];
$alamat_majikan = $rsm->fields['f_tempat_nama'];
$f_peserta_nama = $rsm->fields['f_peserta_nama'];

$surat ="<p>&nbsp;</p>
<table width=100% border=0 cellpadding=0 cellspacing=0>
<tr>
	<td>&nbsp;</td>
	<td align=right>Ruj. Kami : </td>
	<td align=left>".$no_rujukan_surat."(&nbsp;&nbsp;&nbsp;&nbsp;)</td>
</tr>
<tr>
	<td width=10% align=left>&nbsp;</td>
	<td width=60% align=right>Tarikh : </td>
	<td width=29% align=left>".date("d/m/Y")."</td>
</tr>
<tr>
	<td align=left>&nbsp;</td>
	<td align=right>Bersamaan : </td>
	<td align=left>".$date_hijrah."</td>
</tr>
</table>

<table width=100% border=0 cellpadding=3 cellspacing=0>
	<tr><td height=40 colspan=4>&nbsp;</td></tr>
	<tr><td colspan=4>YBhg. Tan Sri / Datuk / Dato' / Tuan / Puan</td></tr>
	<tr><td colspan=4>&nbsp;</td></tr>
	<tr><td colspan=4><b>PERMOHONAN KURSUS ".$kursus."</b></td></tr>
	<tr><td colspan=4>&nbsp;</td></tr>
	<tr><td width=5%>&nbsp;</td>
		<td width=95% colspan=3>
		<table width=90% cellpading=3 cellspacing=0 border=0>
			<tr>
				<td width=15%><b>Nama</td>
				<td width=1%>:</td>
				<td>".$f_peserta_nama."</td>
			</tr>
			<tr>
				<td><b>Tarikh</td>
				<td>:</td>
				<td>".$tarikh_kursus."</td>
			</tr>
			<tr>
				<td valign=top><b>Tempat</td>
				<td valign=top>:</td>
				<td>Institut Latihan Islam Malaysia Wilayah Timur (ILTIM)</td>
			</tr>
		</table>
	</td></tr>
	<tr><td colspan=4>&nbsp;</td></tr>
	<tr><td colspan=4>Adalah dimaklumkan bahawa permohonan pegawai di atas daripada Kementerian/Jabatan YBhg. Tan Sri/Datuk/Dato'/Tuan/Puan telah diterima dan akan diproses.<br /><br /></td></tr>
	<tr><td colspan=4>2. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ILTIM beranggapan bahawa pegawai ini telah mendapat kebenaran daripada pihak tuan/puan. 
<b>Sekiranya berjaya, surat tawaran akan dikeluarkan</b>.
	</td></tr>

	<tr><td colspan=4>Sekian, terima kasih.<br><br><br>
	<b>\"Berkhidmat Untuk Negara\"</B><br><br>
	Saya yang menurut perintah,<br><br><br><br><br>
	
	<b>".$rs_kursus->fields['penyelaras']."</b><br>
	b.p. ".$jawatan.",<br>".$nama_inst."
	</td></tr>
	<tr>
		<td colspan=4>s.k.:</td>
	</tr>
	<tr>
		<td colspan=4>".$f_peserta_nama."</td>
	</tr>
	<tr><td colspan=4><br><br><i>Surat tawaran ini dijana menerusi sistem. Oleh itu, tanda tangan tidak diperlukan.</i></td></tr>
</table>";

$sqlu = "UPDATE _tbl_kursus_jadual_peserta SET surat_majikan=".tosql($surat)."
WHERE InternalStudentId=".tosql($rs->fields['InternalStudentId']);
//print "<br>".$bil." : ".$sqlu."<br>";
//$conn->debug=true;
$conn->execute($sqlu);
/*<tr>
	<td colspan=4>'.$nama_jabatan.'<br>'.$alamat_majikan.'<br>'.$f_peserta_nama.'</td>
</tr>
*/
?>