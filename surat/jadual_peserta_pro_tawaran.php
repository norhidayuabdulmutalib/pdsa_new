<?php
$rsm = $conn->execute("SELECT * FROM _tbl_peserta A, _ref_tempatbertugas B WHERE A.BranchCd=B.f_tbcode AND A.f_peserta_noic=".tosql($p_ic));
$nama_jabatan = $rsm->fields['f_tempat_nama'];
$alamat_majikan = $rsm->fields['f_tempat_nama'];
$f_peserta_nama = $rsm->fields['f_peserta_nama'];
$pic = $rsm->fields['f_peserta_noic'];
$kid = $id;

$gdate = $rs_kursus->fields['startdate'];
$dt = strtotime($gdate);
$tkh_jawapan = date("d/m/Y", $dt-(86400*7));

$surat ="<p>&nbsp;</p>
<table width=100% border=0 cellpadding=0 cellspacing=0>
<tr>
	<td width=10% >&nbsp;</td>
	<td width=60% align=right>Ruj. Kami : </td>
	<td width=29% align=left>JAKIM(19.00)/".$no_rujukan_surat."(&nbsp;&nbsp;&nbsp;&nbsp;)</td>
</tr>
<tr>
	<td align=left>&nbsp;</td>
	<td align=right>Tarikh : </td>
	<td align=left>".date("d/m/Y")."</td>
</tr>
</table>

<table width=100% border=0 cellpadding=3 cellspacing=0>
	<tr><td height=40 colspan=4>&nbsp;</td></tr>
	<tr><td colspan=4><img src=http://itis.islam.gov.my/images/assalam.jpg>.<br></td></tr>
	<tr><td colspan=4>Tuan/Puan</td></tr>
	<tr><td colspan=4>&nbsp;</td></tr>
	<tr><td colspan=4><b>TAWARAN MENGIKUTI ".$kursus."</b></td></tr>
	<tr><td colspan=4>&nbsp;</td></tr>
	<tr><td colspan=4>Dengan segala hormatnya saya diarah untuk merujuk kepada perkara tersebut di atas.<br /><br /></td></tr>
	<tr><td colspan=4>2. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Sukacita dimaklumkan bahawa permohonan tuan/puan untuk mengikuti kursus tersebut di atas telah diterima. Sehubungan itu, tuan/puan dikehendaki untuk menghadiri kursus tersebut yang akan diadakan pada ketetapan berikut:
	</td></tr>
	<tr><td width=5%>&nbsp;</td>
		<td width=95% colspan=3>
		<table width=90% cellpading=3 cellspacing=0 border=0>
			<tr>
				<td width=15%><b>Tarikh</td>
				<td width=1%>:</td>
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
Untuk makluman tuan/puan, kursus ini merupakan kursus sepenuh masa di mana makan/minum akan disediakan. 
Penginapan hanya disediakan kepada peserta yang memohon dan <b>keutamaan diberikan kepada peserta yang tinggal di luar Lembah Klang</b>. 
Kepada peserta yang menginap, tuan/puan dikehendaki mendaftar di kaunter asrama ILIM bermula pukul 8.00 pagi hingga 5.00 petang pada hari bekerja sahaja.
	</td></tr>
	<tr><td colspan=4>4. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Sukacita kiranya pihak tuan/puan dapat memberikan pengesahan kehadiran dengan mengembalikan <b>Borang Pengesahan Kehadiran sebelum ".$tkh_jawapan."</b>.
Kegagalan tuan/puan mengesahkan kehadiran dianggap tidak berminat dan sebarang penggantian peserta adalah tidak dibenarkan."; 
$surat .= ' Sila klik <a href="http://itis.islam.gov.my/surat/borang_kehadiran.php?ic='.$pic.'&id='.$kid.'">disini</a> 
untuk cetakan Borang Pengesahan Kehadiran.';
$surat .= "	</td></tr>
	<tr><td colspan=4>5. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Kerjasama dan perhatian pihak tuan/puan dalam perkara ini didahului dengan ucapan terima kasih.  Sebarang pertanyaan berhubung dengan kursus ini boleh disalurkan melalui pegawai berikut:
	</td></tr>
	<tr><td>&nbsp;</td>
		<td colspan=3>
			<table width=90% cellpading=3 cellspacing=0 border=0>
			<tr>
				<td width=15%><b>Nama</td>
				<td width=1%>:</td>
				<td width=84%>".$penyelia_nama."</td>
			</tr>
			<tr>
				<td><b>No. Telefon</td>
				<td>:</td>
				<td>".$penyelia_notel."</td>
			</tr>
			<tr>
				<td><b>e-Mel</td>
				<td>:</td>
				<td>".$penyelia_email."</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan=4><br>Sekian, terima kasih.<br><br><br>
	<b>\"Berkhidmat Untuk Negara\"</B><br><br>
	Saya yang menurut perintah,<br><br><br>
	
	<b>(".$pengarah.")</b><br>
	".$jawatan.",
	<br>".$nama_inst."
	</td></tr>
	<tr><td colspan=4><br><br><i>Surat tawaran ini dijana menerusi sistem. Oleh itu, tandatangan tidak diperlukan.</i></td></tr>
</table>";

$sqlu_peserta = "UPDATE _tbl_kursus_jadual_peserta SET surat_tawaran=".tosql($surat)."
WHERE InternalStudentId=".tosql($rs->fields['InternalStudentId']);
//print "<br>".$bil." : ".$sqlu."<br>";
//$conn->debug=true;
$conn->execute($sqlu_peserta);
/*<tr>
	<td colspan=4>'.$nama_jabatan.'<br>'.$alamat_majikan.'<br>'.$f_peserta_nama.'</td>
</tr>
*/
?>