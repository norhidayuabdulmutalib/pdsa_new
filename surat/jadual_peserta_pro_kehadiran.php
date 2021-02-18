<?php
		$surat ='<table width=100% border=0 cellpadding=0 cellspacing=0>
		<tr><td colspan=3><b>BORANG PENGESAHAN KEHADIRAN KURSUS</b></td></tr>
		<tr><td colspan=3>(Sila kembalikan borang ini melalui pos atau melalui *talian faks seperti yang tertera dibawah)<br><br></td></tr>
		<tr>
			<td width=30% align=left><b>NAMA KURSUS</b></td>
			<td width=5% align=center> : </td>
			<td width=65% align=left>'.$kursus.'</td>
		</tr>
		<tr>
			<td align=left><b>TARIKH KURSUS</b></td>
			<td align=center>: </td>
			<td align=left>'.DisplayDate($rs_kursus->fields['startdate']).' - '.DisplayDate($rs_kursus->fields['enddate']).'</td>
		</tr>
		<tr>
			<td align=left valign=top><b>ALAMAT PUSAT</b></td>
			<td align=center valign=top>: </td>
			<td align=left>'.$nama_tempat.'<br>'.$nama_blok.'<br>Institut Latihan Islam Malaysia</td>
		</tr>
		<tr>
			<td colspan=3>&nbsp;<hr></td>
		</tr>
		<tr>
			<td colspan=3>Dimaklumkan bahawa saya: 
			<label style=border-bottom:thin;border-bottom-style:dotted;border-bottom-width:thin;>&nbsp;&nbsp;'.strtoupper($rs->fields['f_peserta_nama']).'&nbsp;&nbsp;</label> 
			No. K/P: <label style=border-bottom:thin;border-bottom-style:dotted;border-bottom-width:thin;>&nbsp;&nbsp;'.$rs->fields['peserta_icno'].'&nbsp;&nbsp;</label> 
			<br>Jawatan: <label style=border-bottom:thin;border-bottom-style:dotted;border-bottom-width:thin;width:120px>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> 
			<br>Jabatan/Kementerian: <label style=border-bottom:thin;border-bottom-style:dotted;border-bottom-width:thin;width:120px>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<b>**bersetuju / tidak bersetuju</b> untuk menghadiri kursus tersebut di atas dan mematuhi semua peraturan-peraturan.<br><br></td>
		</tr>
		</table>

		<table width=100% border=0 cellpadding=3 cellspacing=0>
		<tr>
			<td width=30%>Tarikh : .............................</td>
			<td width=20%>&nbsp;</td>
			<td width=50% align=center>.............................................</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align=center>Tandatangan</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align=left>Jawatan</td>
		</tr>
		</table><br><br>';
	
$surat .= '<table width=100% cellpadding=5 cellspacing=0 border=0>
	<tr bgcolor=#333333>
    	<td width=100% align=center colspan=3><font color=#FFFFFF><b>PENGESAHAN KETUA JABATAN</b></font></td>
    </tr>
    <tr><td colspan=3>Pegawai yang dicalonkan adalah <strong>**disokong / tidak disokong</strong> untuk menyertai kursus tersebut diatas.</td></tr>
	<tr><td colspan=3><br /></td></tr>
		<tr>
			<td width=30%>Tarikh : .............................</td>
			<td width=20%>&nbsp;</td>
			<td width=50% align=center>.............................................</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align=center>Tandatangan</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align=left>Nama dan<br />Cop Jabatan : </td>
		</tr>
	<tr><td colspan=3><br /><br />
    <hr /><br />
    <i><font style=font-family:Verdana, Geneva, sans-serif;font-size:9px>** Potong mana yang tidak berkenaan.</font></i></td></tr>
</table>

<i><font style=font-family:Verdana, Geneva, sans-serif;font-size:9px>* Talian faks mengikut Pusat adalah seperti berikut:-</font>
<table width=100% cellpadding=5 cellspacing=0 border=1 style=font-family:Verdana, Geneva, sans-serif;font-size:9px>
	<tr bgcolor=#CCCCCC>
    	<td align=center width=30%>Untuk Perhatian</td>
    	<td align=center width=20%>No. Telefon / Faks</td>
    	<td align=center width=30%>Untuk Perhatian</td>
    	<td align=center width=20%>No. Telefon / Faks</td>
    </tr>	
	<tr>
    	<td align=center style=font-family:Verdana, Geneva, sans-serif;font-size:9px>Pusat Ekonomi dan Kewangan Islam (PEKI)</td>
    	<td align=left style=font-family:Verdana, Geneva, sans-serif;font-size:9px>T : 03-8921 8428/8429<br />F : 03-8921 8504</td>
    	<td align=center style=font-family:Verdana, Geneva, sans-serif;font-size:9px>Pusat Pengajian Sains Dakwah (PPSD)</td>
    	<td align=left style=font-family:Verdana, Geneva, sans-serif;font-size:9px>T : 03-8921 8462/8470<br />F : 03-8921 8499</td>
    </tr>	
	<tr>
    	<td align=center style=font-family:Verdana, Geneva, sans-serif;font-size:9px>Pusat Pengurusan dan Undang-Undang Islam (PPUI)</td>
    	<td align=left style=font-family:Verdana, Geneva, sans-serif;font-size:9px>T : 03-8921 8443/8445<br />F : 03-8921 8506</td>
    	<td align=center style=font-family:Verdana, Geneva, sans-serif;font-size:9px>Pusat Bahasa (PB)</td>
    	<td align=left style=font-family:Verdana, Geneva, sans-serif;font-size:9px>T : 03-8921 8459/8460<br />F : 03-8921 8508</td>
    </tr>	
	<tr>
    	<td align=center style=font-family:Verdana, Geneva, sans-serif;font-size:9px>Pusat Pembangunan Keluarga Islam (PPKI)</td>
    	<td align=left style=font-family:Verdana, Geneva, sans-serif;font-size:9px>T : 03-8921 8436/8437<br />F : 03-8921 8505</td>
    	<td align=center style=font-family:Verdana, Geneva, sans-serif;font-size:9px>Pusat Teknologi Maklumat (PTM)</td>
    	<td align=left style=font-family:Verdana, Geneva, sans-serif;font-size:9px>T : 03-8921 8484/8485<br />F : 03-89218502</td>
    </tr>	
	<tr>
    	<td align=center style=font-family:Verdana, Geneva, sans-serif;font-size:9px>Pusat al-Quran dan Ilmu Teras (PQIT)</td>
    	<td align=left style=font-family:Verdana, Geneva, sans-serif;font-size:9px>T : 03-8921 8452/8453<br />F : 03-8921 8507</td>
    	<td align=center style=font-family:Verdana, Geneva, sans-serif;font-size:9px>Unit Pembangunan Latihan & Penerbitan (UPLP)</td>
    	<td align=left style=font-family:Verdana, Geneva, sans-serif;font-size:9px>T : 03-8921 8498<br />F : 03-8921 8510</td>
    </tr>	
</table>';	
	
		$sqlu = "UPDATE _tbl_kursus_jadual_peserta SET surat_jawapan=".tosql(addslashes($surat))."
		WHERE InternalStudentId=".tosql($rs->fields['InternalStudentId']);
		//print "<br>".$bil." : ".$sqlu."<br>";
		//$conn->debug=true;
		$conn->execute($sqlu);
?>
<label style="border-bottom:thin;border-bottom-style:dotted;border-bottom-width:thin;width:120px">

