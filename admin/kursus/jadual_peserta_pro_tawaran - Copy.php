<?php
		$surat ='
		<table width=100% border=0 cellpadding=0 cellpadding=0>
		<tr>
			<td width=10% align="left">&nbsp;</td>
			<td width=60% align=right>Tarikh : </td>
			<td width=29% align="left">'.date("d/m/Y").'</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align=right>Ruj. Kami : </td>
			<td align="left">JAKIM(19.00)/12/700-1/1-2(&nbsp;&nbsp;&nbsp;&nbsp;)</td>
		</tr>
		</table>
		<table width=100% border=0 cellpadding=3 cellpadding=0>
		<tr>
			<td colspan=4 align=left>'.$rs->fields['f_peserta_nama'].'</td>
		</tr>
		<tr>
			<td colspan=4 align=left>'.$rs->fields['f_peserta_alamat1'].'</td>
		</tr>
		<tr><td height=40 colspan=4>&nbsp;</td></tr>
		<tr><td colspan=4>Tuan/Puan</td></tr>
		<tr><tdcolspan=4>&nbsp;</td></tr>
		<tr><td colspan=4><b><u>'.$rs_kursus->fields['course_name'].'</u></b></td></tr>
		<tr><td colspan=4>&nbsp;</td></tr>
		<tr><td colspan=4>Dengan segala hormatnya saya diarah untuk merujuk kepada perkara tersebut di atas.<br /><br /></td></tr>
		<tr><td colspan=4>2. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Sukacita dimaklumkan bahawa permohonan tuan/puan dikehendaki untuk meghadiri kursus tersebut yang akan diadakan pada:
		</td>  </tr>
		<tr><td width=5%>&nbsp;</td>
			<td width=95% colspan=3>
			<table width=90% cellpading=3 cellspacing=0 border=0>
				<tr>
					<td width=15%><b>Tarikh</td>
					<td width=1%>:</td>
					<td>'.DisplayDate($rs_kursus->fields['startdate']).' - '.DisplayDate($rs_kursus->fields['enddate']).'</td>
				</tr>
				<tr>
					<td width=15% valign=top><b>Tempat</td>
					<td width=1% valign=top>:</td>
					<td>'.$nama_tempat.'<br>'.$nama_blok.'<br>Institut Latihan Islam Malaysia</td>
				</tr>
			</tr>
			</table>
		</td></tr>
		<tr><td colspan=4>3. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Kursus ini merupakan kursus sepenuh masa di mana penginapan dan makanan akan disediakan oleh penganjur. Tuan/Puan dikehendaki melaporkan diri di Institut Latihan Islam Malaysia pada <b>'.DisplayDate($rs_kursus->fields['startdate']).' mulai pukul '.substr($rs_kursus->fields['timestart'],0,5).' - '.substr($rs_kursus->fields['timeend'],0,5).'</b> bertempat di Asrama Institut Latihan Islam Malaysia.  Taklimat kursus akan dimulakan pada pukul '. substr($rs_kursus->fields['timeend'],0,5).'.  Bersama-sama ini disertakan jadual kursus untuk makluman tuan/puan.
		</td></tr>
		<tr><td colspan=4>4. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Sukacita kiranya pihak tuan/puan dapat memberikan pengesahan kehadiran dengan menghubungi pihak urusetia sebelum '.DisplayDate($rs_kursus->fields['startdate']).'. Kegagalan tuan/puan mengesahkan kehadiran dianggap tidak berminat dan tempat tuan/puan akan digantikan dengan peserta lain.
		</td></tr>
		<tr><td colspan=4>5. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Kerjasama dan perhatian pihak tuan/puan dalam perkara ini didahului dengan ucapan terima kasih.  Sebarang pertanyaan berhubung dengan kursus ini boleh disalurkan melalui pegawai-pegawai berikut:
		</td></tr>
		<tr><td>&nbsp;</td>
			<td colspan=3>
			<table width=90% cellpading=3 cellspacing=0 border=0>
				<tr>
					<td width=5%><b>i.</td>
					<td width=1%></td>
					<td width=94%>'.$rs_kursus->fields['penyelaras'].'</td>
				</tr>
			</table>
		</td></tr>
		<tr><td colspan=4>Sekian<br><br><br>
		<b>"MENJANA KECEMERLANGAN"</B><br><br>
		Saya yang menurut perintah,<br><br><br><br><br>
		
		<b>'.strtoupper($rs_kursus->fields['penyelaras']).'</b><br>
		b.p. Pengarah, Institut Latihan Islam Malaysia
		</td></tr>
		</table>';
	
		$sqlu = "UPDATE _tbl_kursus_jadual_peserta SET 
		surat_tawaran=".tosql(addslashes($surat))."
		WHERE InternalStudentId=".tosql($rs->fields['InternalStudentId']);
		//print "<br>".$bil." : ".$sqlu."<br>";
		if($rs->fields['f_peserta_nama']=='FARALIZA BINTI MD. SALLEH'){ $conn->debug=true; }
		$conn->execute($sqlu);
		$conn->debug=false;

		$sqlu = "UPDATE _tbl_surat SET 
		surat=".tosql(addslashes($surat))."
		WHERE peserta_icno=".tosql($p_ic)." AND EventId=".tosql($id); //InternalStudentId=".tosql($rs->fields['InternalStudentId']);
		//print "<br>".$bil." : ".$sqlu."<br>";
		$conn->execute($sqlu);
?>