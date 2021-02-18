<?php
$surat = '<html><body>
<table width="800px" cellpadding="5" cellspacing="1" border="0" align="center">
	<tr><td height="100px" colspan="4">&nbsp;</td></td>

	<tr>
    	<td width="10%">&nbsp;</td>
    	<td width="20%">&nbsp;</td>
    	<td width="3%">&nbsp;</td>
    	<td width="67%">&nbsp;</td>
    </tr>
	<tr>
    	<td align="left" colspan="4">From : kursus_ilim@islam.gov.my</td>
    </tr>
	<tr>
    	<td align="left" colspan="4">To : nizamms@gmail.com</td>
    </tr>
	<tr>
    	<td align="left" colspan="4">Cc : itis_ilim@islam.gov.my</td>
    </tr>
	<tr>
    	<td align="left" colspan="4">Date : 12/02/1023 10:40AM</td>
    </tr>
	<tr>
    	<td align="left" colspan="4"><b>Subjejct : <b>Permohonan mengikuti kursus di ILIM : '.$nama.'</b></b></td>
    </tr>
	<tr>
    	<td align="left" colspan="4"><br /></td>
    </tr>
	<tr>
    	<td align="left" colspan="4">Tuan/Puan</td>
    </tr>
	<tr>
    	<td align="left" colspan="4"><br /></td>
    </tr>
	<tr>
    	<td align="left" colspan="4"><b><b>PERMOHONAN '.$coursename.'</b></b></td>
    </tr>
	<tr>
    	<td align="left" colspan="4"><br /></td>
    </tr>
	<tr>
    	<td>&nbsp;</td>
    	<td align="left"><b>Nama</b></td>
        <td align="center"> : </td>
        <td align="left">'.$nama.'</td>
    </tr>
	<tr>
    	<td>&nbsp;</td>
    	<td align="left"><b>Tarikh</b></td>
        <td align="center"> : </td>
        <td align="left">'.$tarikh_kursus.'</td>
    </tr>
	<tr>
    	<td>&nbsp;</td>
    	<td align="left"><b>Tempat Kursus</b></td>
        <td align="center"> : </td>
        <td align="left">'.$tempat.'</td>
    </tr>
	<tr>
    	<td align="left" colspan="4"><br /></td>
    </tr>
	<tr>
    	<td align="left" colspan="4">Adalah dimaklumkan bahawa permohonan pegawai di atas daripada Kementerian/Jabatan taun/puan telah didaftarkan dan akan diproses.</td>
    </tr>
	<tr>
    	<td align="left" colspan="4"><br /></td>
    </tr>
	<tr>
    	<td align="left" colspan="4">2.&nbsp;&nbsp;ILIM beranggapan bahawa pegawai ini telah mendapat kebenaran daripada pihak tuan/puan.&nbsp;&nbsp;
        <b>Sekiranya berjaya, surat tawaran akan dikeluarkan.</b></td>
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
    	<td align="left" colspan="4"><b>(FARALIZA)</b></td>
    </tr>
	<tr>
    	<td align="left" colspan="4">b.p Pengarah</td>
    </tr>
	<tr>
    	<td align="left" colspan="4">Institut Latihan Islam Malaysia</td>
    </tr>
	<tr>
    	<td align="left" colspan="4" height="60px"><br /></td>
    </tr>
	<tr>
    	<td align="left" colspan="4">Thus message is auto-generated, PLEASE DO NOT REPLY TO THIS E-MAIL<br /><br /></td>
    </tr>
</table>
</body>
</html>';


$rss = $conn->execute("SELECT * FROM _tbl_surat WHERE surat_jenis='E' AND peserta_icno=".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($idk));
if($rss->EOF){
	$sqle = "INSERT INTO _tbl_surat(peserta_icno, EventId, surat_jenis, surat_tarikh, surat, create_by, create_dt) ";
	$sqle .= "VALUES(".tosql($f_peserta_noic).", ".tosql($idk).", ".tosql("E").", ".tosql(date("Y-m-d")).", ".tosql($surat).", ".tosql($by).", ".tosql(date("Y-m-d H:i:s")).")";
	$conn->Execute($sqle);
}
?>