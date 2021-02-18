<!--	<tr><td height="100px" colspan="5">&nbsp;</td></td>-->
<?php
$surat = '<html><body>
<table width="800px" cellpadding="5" cellspacing="1" border="0" align="center">

	<tr>
    	<td width="20%">&nbsp;</td>
    	<td width="3%">&nbsp;</td>
    	<td width="52%">&nbsp;</td>
    	<td width="10%">&nbsp;</td>
    	<td width="15%">&nbsp;</td>
    </tr>
	<tr>
    	<td align="left">No. Kad Pengenalan</td>
        <td align="center"> : </td>
        <td align="left">'.$nokp.'</td>
        <td align="right">Tarikh : </td>
        <td align="left">'.$tarikh.'</td>
    </tr>
	<tr>
    	<td align="left">Nama</td>
        <td align="center"> : </td>
        <td align="left" colspan="3">'.addslashes($nama).'</td>
    </tr>
	<tr>
    	<td align="left">Jabatan</td>
        <td align="center"> : </td>
        <td align="left" colspan="3">'.addslashes($jabatan).'</td>
    </tr>
	<tr>
    	<td align="left" colspan="5">&nbsp;</td>
    </tr>
	<tr>
    	<td align="left" colspan="5"><b>PERMOHONAN '.addslashes($coursename).'</b></td>
    </tr>
	<tr>
    	<td align="left" colspan="5"><br /></td>
    </tr>
	<tr>
    	<td align="left"><b>Tarikh</b></td>
        <td align="center"> : </td>
        <td align="left" colspan="3">'.$tarikh_kursus.'</td>
    </tr>
	<tr>
    	<td align="left" colspan="5"><br /></td>
    </tr>
	<tr>
    	<td align="left" colspan="5">Adalah dimaklumkan bahawa permohonan tuan/puan telah diterima dan akan diproses.  Sekiranya berjaya, 
        <b>surat tawaran akan dikeluarkan.</b></td>
    </tr>
	<tr>
    	<td align="left" colspan="5">2.&nbsp;&nbsp;Tuan/puan boleh menyemak status permohonan kursus yang dipohon melalui laman web ILIM di http://itis.islam.gov.my seminggu sebelum tarikh kursus djalankan.</td>
    </tr>
	<tr>
    	<td align="left" colspan="5"><br />Sekian, terima kasih.<br /><br /></td>
    </tr>
	<tr>
    	<td align="left" colspan="5" valign="top" height="30px"><strong>"Berkhidmat Untuk Negara"</strong></td>
    </tr>
	<tr>
    	<td align="left" colspan="5"><b>Saya yang menurut perintah.</b></td>
    </tr>
	<tr>
    	<td align="left" colspan="5"><br><b>'.strtoupper(addslashes($penyelaras)).'</b></td>
    </tr>
	<tr>
    	<td align="left" colspan="5"><b>b.p: Pengarah<br>'.$nama_kampus.'<br>Jabatan Kemajuan Islam Malaysia</b></td>
    </tr>
	<tr>
    	<td align="left" colspan="5"><b>Nota : </b></td>
    </tr>
	<tr>
    	<td align="left" colspan="5">Sebarang pertanyaan mengenai permohonan ini sila hubungi:<br /><br />
        No. Telefon : '.$penyelaras_notel.'<br />
        Emel : '.$penyelaras_email.'</td>
    </tr>
</table>
</body>
</html>';

//print $surat; exit;

//$conn->debug=true;
$rss = $conn->execute("SELECT * FROM _tbl_surat WHERE surat_jenis='S' AND peserta_icno=".tosql($f_peserta_noic,"Text"). " AND EventId=".tosql($idk));
if($rss->EOF){
	$sqls = "INSERT INTO _tbl_surat(peserta_icno, EventId, surat_jenis, surat_tarikh, surat, create_by, create_dt) ";
	$sqls .= "VALUES(".tosql($f_peserta_noic).", ".tosql($idk).", ".tosql("S").", ".tosql(date("Y-m-d")).", ".tosql($surat).", ".tosql($by).", ".tosql(date("Y-m-d H:i:s")).")";
	$conn->Execute($sqls);
}
$conn->debug=false;
?>