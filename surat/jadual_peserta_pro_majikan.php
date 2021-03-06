<?php
$rsm = $conn->execute("SELECT * FROM _tbl_peserta A, _ref_tempatbertugas B WHERE A.BranchCd=B.f_tbcode AND A.f_peserta_noic=".tosql($p_ic));
$nama_jabatan = $rsm->fields['f_tempat_nama'];
$alamat_majikan = $rsm->fields['f_tempat_nama'];
$f_peserta_nama = $rsm->fields['f_peserta_nama'];

$surat ="<p>&nbsp;</p>
<table width=100% border=0 cellpadding=0 cellspacing=0>
<tr>
	<td width=10% align=left>&nbsp;</td>
	<td width=60% align=right>Tarikh : </td>
	<td width=29% align=left>".date("d/m/Y")."</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td align=right>Ruj. Kami : </td>
	<td align=left>JAKIM(19.00)//".$no_rujukan_surat."(&nbsp;&nbsp;&nbsp;&nbsp;)</td>
</tr>
</table>

<table width=100% border=0 cellpadding=3 cellspacing=0>
	<tr><td height=40 colspan=4>&nbsp;</td></tr>
	<tr><td colspan=4><img src=http://itis.islam.gov.my/images/assalam.jpg>.<br></td></tr>
	<tr><td colspan=4>YBhg. Tan Sri / Datuk / Dato' / Tuan / Puan</td></tr>
	<tr><td colspan=4>&nbsp;</td></tr>
	<tr><td colspan=4><b>TAWARAN MENGIKUTI ".$kursus."</b></td></tr>
	<tr><td colspan=4>&nbsp;</td></tr>
	<tr><td colspan=4>Dengan segala hormatnya saya diarah untuk merujuk kepada perkara tersebut di atas.<br /><br /></td></tr>
	<tr><td colspan=4>2. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Sukacita dimaklumkan bahawa calon dari Kementerian / Jabatan / Agensi / Institusi YBhg. Tan Sri / Datuk / Dato' / Tuan / Puan seperti berikut telah dipilih untuk mengikuti kursus/bengkel di atas pada ".$tarikh_kursus.":
	</td></tr>
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
				<td>Institut Latihan Islam Malaysia. ".$nama_tempat."</td>
			</tr>
			<tr>
				<td><b>Pendaftaran</td>
				<td>:</td>
				<td>".$masa_daftar."</td>
			</tr>
			<tr>
				<td><b>Masa Taklimat</td>
				<td>:</td>
				<td>".$masa_takimat."</td>
			</tr>
		</table>
	</td></tr>
	<tr><td colspan=4>3. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Kursus ini merupakan kursus sepenuh masa di mana penginapan dan makanan akan disediakan oleh penganjur. 
Calon dikehendaki melaporkan diri di Institut Latihan Islam Malaysia pada <b>".DisplayDate($rs_kursus->fields['startdate'])." mulai pukul ".$rs_kursus->fields['masa_daftar']."</b>.  Taklimat kursus akan dimulakan pada pukul <b>". $rs_kursus->fields['masa_taklimat']."</b>.  Bersama-sama ini disertakan jadual kursus untuk makluman tuan/puan.
	</td></tr>
	<tr><td colspan=4>4. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Kerjasama dan perhatian pihak tuan/puan dalam perkara ini didahului dengan ucapan terima kasih.  
Sebarang pertanyaan berhubung dengan kursus ini boleh disalurkan melalui pegawai-pegawai berikut:
	</td></tr>
	<tr><td>&nbsp;</td>
		<td colspan=3>
			<table width=90% cellpading=3 cellspacing=0 border=0>
			<tr>
				<td width=15%><b>Nama</td>
				<td width=1%>:</td>
				<td width=84%>".$rs_kursus->fields['penyelaras']."</td>
			</tr>
			<tr>
				<td><b>No. Telefon</td>
				<td>:</td>
				<td>".$rs_kursus->fields['penyelaras_notel']."</td>
			</tr>
			<tr>
				<td><b>e-Mel</td>
				<td>:</td>
				<td>".$rs_kursus->fields['penyelaras_email']."</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan=4>Sekian, terima kasih.<br><br><br>
	<b>\"Berkhidmat Untuk Negara\"</B><br><br>
	Saya yang menurut perintah,<br><br><br><br><br>
	
	<b>".$rs_kursus->fields['penyelaras']."</b><br>
	b.p. ".$jawatan.", ".$nama_inst."
	</td></tr>
	<tr>
		<td colspan=4>s.k.:</td>
	</tr>
	<tr>
		<td colspan=4>".$f_peserta_nama."</td>
	</tr>
	<tr><td colspan=4><br><br><i>Surat tawaran ini dijana menerusi sistem. Oleh itu, tanda tangan tidak diperlukan.</i></td></tr>
</table>";

$sqlu = "UPDATE _tbl_kursus_jadual_peserta SET surat_majikan=".tosql(addslashes($surat))."
WHERE InternalStudentId=".tosql($rs->fields['InternalStudentId']);
//print "<br>".$bil." : ".$sqlu."<br>";
//$conn->debug=true;
$conn->execute($sqlu);
/*<tr>
	<td colspan=4>'.$nama_jabatan.'<br>'.$alamat_majikan.'<br>'.$f_peserta_nama.'</td>
</tr>
*/
?>