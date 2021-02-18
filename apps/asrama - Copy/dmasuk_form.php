<Script Language='JavaScript' src='include/RemoteScriptServer.js'></Script>
<script LANGUAGE="JavaScript1.2">
function ClearListBox(lst){
	document.ilim.elements[lst].length = 0;
	//document.ilim.elements[lst].options[0]= new Option('SEMUA BILIK','');
}

function SelectBilik(strFileName){
	ClearListBox('bilik_id');
	
	var IDBlok = document.ilim.blok_id.value; 
	var URL = strFileName + '?IDBlok=' + IDBlok;
	callToServer(URL);
}

/***************************************
 *** To get value from remote server ***
 *** and place them to listbox       ***
 ***************************************/
function handleResponse(ID,Data,lst){
	strID = new String(ID);
	strData = new String(Data);
	if(strID == ''){
		document.ilim.elements[lst].length = 0;
		//document.ilim.elements[lst].options[0]= new Option('SEMUA DAERAH','');
	}else{
		splitID = strID.split(";");
		splitData = strData.split(";");
		//document.ilim.elements[lst].options[0]= new Option('SEMUA DAERAH','');
		for(i=0;i<=splitID.length;i++){
			document.ilim.elements[lst].options[i]= new Option(splitData[i],splitID[i]);
		}
		document.ilim.elements[lst].length = splitID.length;
	}
}
</script>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	document.ilim.action = URL;
	document.ilim.submit();
}

function do_back(URL){
	document.ilim.action =URL;
	document.ilim.submit();
}
</script>
<?
//$conn->debug=true;
$sql = "SELECT A.p_nama, A.p_nokp, A.no_pendaftaran, A.sesi_kemasukan, A.syukbah_id, A.p_alamat1, A.p_alamat2, A.p_alamat3, A.no_matrik,
A.p_poskod, A.p_jantina, A.p_notel, A.img_pelajar, A.semester, B.kod_kursus, B.kursus 
FROM _sis_tblpelajar A, ref_kursus B 
WHERE A.kursus_id=B.kid AND A.pelajar_id=".tosql($id,"Text");
$rs = &$conn->execute($sql);
$jantina = $rs->fields['p_jantina'];
$semester_id = $rs->fields['semester'];
if(empty($semester_id)){
	$semester_id = dlookup("_sis_tblpelajar_semester","max(semester_num)","pelajar_id = ".tosql($id,"Text"));
	$conn->execute("UPDATE _sis_tblpelajar SET semester=".$semester_id." WHERE pelajar_id=".tosql($id,"Text"));
}
//$semester_id = dlookup("_sis_tblpelajar_semester","semester_num","semester_now_id  = ".$_SESSION['s_semester_nowid']." AND pelajar_id = ".tosql($id,"Text"));
//if(!$semester_id
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="1" border="0">
	<tr><td colspan="2">
    	<table width="95%" cellpadding="5" cellspacing="1" border="0" align="center">
           <tr bgcolor="#00CCFF">
    	<td colspan="4" height="30">&nbsp;<b>DAFTAR MASUK ASRAMA</b></td>
    </tr>
           <tr>
             <td colspan="4" class="title">A.&nbsp;&nbsp;&nbsp;MAKLUMAT BILIK</td>
           </tr>
            <?  $sql_l = "SELECT * FROM ref_asrama_blok  WHERE ref_blok_status = 0 AND ref_jantina=".tosql($jantina,"Text")." 
				ORDER BY ref_blok";
				$rs_l = &$conn->Execute($sql_l); 
				//echo $sql_l;
			?>
           <tr>
             <td>Blok : </td>
             <td colspan="3"><select name="blok_id" onchange="SelectBilik('asrama/do_SelectBilik.php')">
             	<option value="">-- Sila Pilih -- </option>
			<?	while(!$rs_l->EOF){
					if($rs_l->fields['ref_jantina']=='L'){ $asrama = 'Asrama Lelaki (Banin)'; } else { $asrama = 'Asrama Perempuan (Banat)'; }
					print '<option value="'.$rs_l->fields['ref_blok_id'].'"';
					//	if($rs_l->fields['ref_blok_id']==$blok_search){ print 'selected'; }
					print '>'. $rs_l->fields['ref_blok'] ." &nbsp;[".$asrama."]".'</option>';
					$rs_l->movenext();
				}
			?>
          </select></td>
           </tr>
            <?  $sql_l = "SELECT * FROM _sis_a_tblbilik  WHERE status_bilik = 0 AND keadaan_bilik = 1 AND is_deleted = 0 AND blok_id = 1 ORDER BY no_bilik";
				$rs_l = $conn->Execute($sql_l); 
				//echo $sql_l;
			?>
           <tr>
             <td>No. Bilik : </td>
             <td colspan="3"><select name="bilik_id">
			 <?	/*while(!$rs_l->EOF){
					print '<option value="'.$rs_l->fields['bilik_id'].'"';
					//if($rs_l->fields['bilik_id']==$blok_search){ print 'selected'; }
					print '>'. $rs_l->fields['no_bilik'].'</option>';
					$rs_l->movenext();
				}*/
			 ?>
          </select></td>
           </tr>
            <tr>
                <td colspan="4" class="title">B.&nbsp;&nbsp;&nbsp;MAKLUMAT PELAJAR</td>
           </tr>
            <tr>
                <td width="25%">1. Nama Pelajar : </td>
              <td colspan="2"><?=$rs->fields['p_nama']?>
          				  <input name="pelajar_id" type="hidden" value="<?=$id?>" />              </td>
              <td rowspan="5" align="center"><span id="ImgViewBoarder"><span id="ImgView">
                    <img id="elImage" src="student/student_pic/<?=$rs->fields['img_pelajar'];?>" width="100" height="120"></span></span>&nbsp;</td>
          </tr>
            <tr>
              <td>2. No. Matrik : </td>
              <td><?=$rs->fields['no_matrik']?></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>3. No. KP / Passport: </td>
              <td><?=$rs->fields['p_nokp']?></td>
              <td>&nbsp;</td>
            </tr>

            <tr>
              <td>4. Kursus : </td>
              <td colspan="2"><?=$rs->fields['kursus'];?> 

        - [<? echo dlookup("ref_syukbah","ref_sukbah","ref_sukbah_id=".tosql($rs->fields['syukbah_id'],"Number"));?>]              
            <input name="syukbah_id" type="hidden" value="<?=$syukbah_id?>" />
            </td>
            </tr>
            <tr>
              <td>5. Semester : </td>
              <td colspan="2"><? echo dlookup("ref_semester","semester","semester_id=".tosql($semester_id,"Number"));?> 
                                           <input name="semester_id" type="hidden" value="<?=$semester_id?>" />
              </td>
            </tr>
            <tr>

                <td>6. Alamat Surat-menyurat : </td>
				<td colspan="3"><? echo nl2br($rs->fields['p_alamat1'])."<br>".
					nl2br($rs->fields['p_alamat2'])."<br>".nl2br($rs->fields['p_alamat3']); ?><br />
				<?=$rs->fields['p_poskod']?><br />
				<? echo dlookup("refstate", "fldstatedesc", "fldstateID = '".$rs->fields['p_negeri_id']."'");?>         
               </td>
            </tr>
            <tr>
              <td>7. Jantina : </td>
              <td><? if($rs->fields['p_jantina'] == 'L') echo 'Lelaki'; ?> <? if($rs->fields['p_jantina'] == 'P') echo 'Perempuan';?> 
              </td>

              <td width="22%">&nbsp;</td>

              <td width="27%">&nbsp;</td>
          </tr>

            <tr>
              <td>8. No. Telefon : </td>
              <td><?=$rs->fields['p_notel']?><input name="no_telefon" type="hidden" value="<?=$rs->fields['p_notel']?>" /></td>

                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

           <!-- <tr>
              <td>13. PNGK : </td>
              <td></td>
              <td>14. HPMG Terakhir: </td>
              <td></td>
            </tr> -->

			 <tr>

                <td colspan="4" class="title">C.&nbsp;&nbsp;&nbsp;MAKLUMAT IBU / BAPA / PENJAGA</td>
            </tr>
			<?

			//$sql = "SELECT * FROM _sis_tblpelajar_keluarga WHERE pelajar_id=".tosql($id,"Text");
			$sql = "SELECT * FROM _sis_a_tblasrama WHERE is_keluar=0 AND pelajar_id=".tosql($id,"Text");
			$rs = &$conn->execute($sql);
			
			?>
            <tr>

                <td>15. Nama : </td>

                <td colspan="3"><input name="penjaga_nama" type="text" size="70" value="<?=$rs->fields['penjaga_nama']?>" /></td>
            </tr>

            <tr>

                <td>16. Alamat Surat-menyurat : </td>

                <td colspan="3"><textarea cols="60" rows="4" name="p_alamat"><?=$rs->fields['p_alamat']?></textarea></td>
            </tr>

            <!--<tr>

              <td>17. Poskod : </td>

              <td colspan="3"><input type="text" name="poskod" size="5" maxlength="5" value="<?=$rs->fields['bapa_nama']?>"></td>
            </tr>-->

            <tr>

                <td>17. No. Telefon (R): </td>

                <td width="26%"><input type="text" name="p_no_tel" size="20" maxlength="15" value="<?=$rs->fields['p_no_tel']?>" ></td>

                <td width="22%">18. No. Telefon (HP) :</td>

                <td width="27%"><input type="text" name="p_no_hp" size="20" maxlength="15" value="<?=$rs->fields['p_no_hp']?>"></td>
            </tr>

            <tr>

              <td>19. Pekerjaan : </td>

              <td colspan="3"><input type="text" name="p_pekerjaan" size="70" maxlength="120" value="<?=$rs->fields['p_pekerjaan']?>"></td>
            </tr>

            <tr>

              <td>20. Pendapatan Bulanan Ibu/Bapa/Penjaga : </td>

              <td colspan="3">RM <input type="text" name="p_pendapatan" size="15" maxlength="15" value="<?=$rs->fields['p_pendapatan']?>">(Masukkan angka sahaja)</td>
            </tr>
            <tr>
              <td colspan="4" class="title">F.&nbsp;&nbsp;&nbsp;LATAR BELAKANG PENEMPATAN</td>
            </tr>
            <?php 
			//$conn->debug=true;
			/*$sSQL="SELECT A.semester semester, B.ref_blok ref_blok, C.no_bilik no_bilik, D.daftar_id daftar_id, D.tkh_masuk tkh_masuk, D.tkh_keluar tkh_keluar 
			FROM ref_semester A, ref_asrama_blok B, _sis_a_tblbilik C, _sis_a_tblasrama D 
			WHERE A.semester_id=D.semester_id AND C.bilik_id=D.bilik_id 
			AND B.ref_blok_id=C.blok_id AND D.is_keluar=1 AND D.pelajar_id= ".tosql($id,"Text");
            $sSQL.= " ORDER BY D.daftar_id";*/
            
			$sSQL = "SELECT D.semester_id, D.daftar_id daftar_id, D.tkh_masuk tkh_masuk, D.tkh_keluar tkh_keluar, C.no_bilik no_bilik, B.ref_blok ref_blok
			FROM ref_asrama_blok B, _sis_a_tblbilik C, _sis_a_tblasrama D
			WHERE C.bilik_id=D.bilik_id 
			AND B.ref_blok_id=C.blok_id AND D.pelajar_id= ".tosql($id,"Text")." 
			ORDER BY D.daftar_id";
            $rs = &$conn->Execute($sSQL);
            $cnt = $rs->recordcount();
			?>
            <tr>
              <td colspan="4"><table border="1" width="90%" cellspacing="0" cellpadding="5" bordercolorlight="#000000" bordercolordark="#FFFFFF">
                <tr bgcolor="#D1E0F9">
                  <td width="5%" align="center"><b>Bil</b></td>
                  <td width="35%" align="center"><strong>Semester</strong></td>
                  <td width="15%" align="center"><b>Blok</b></td>
                  <td width="15%" align="center"><b>No. Bilik</b></td>
                  <td width="15%" align="center"><b>Tarikh Masuk</b></td>
                  <td width="15%" align="center"><b>Tarikh Keluar</b></td>
                  <!-- <td width="12%" align="center"><b>Tindakan</b></td>-->
                </tr>
                <?

        if(!$rs->EOF) {
            $cnt = 1;
            $bil = 1;
            while(!$rs->EOF ) {
                ?>
                <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                  <td align="right"><? echo $bil;?>.&nbsp;</td>
                  <td align="center" valign="top"><? echo dlookup("ref_semester","semester","semester_id=".tosql($rs->fields['semester_id'],"Number"));?>&nbsp;</td>
                  <td align="center"><? echo $rs->fields['ref_blok'];?>&nbsp;</td>
                  <td align="center"><? echo $rs->fields['no_bilik'];?>&nbsp;</td>
                  <td align="center"><? echo DisplayDate($rs->fields['tkh_masuk']);?>&nbsp;</td>
                  <td align="center"><? echo DisplayDate($rs->fields['tkh_keluar']);?>&nbsp;</td>
                  <!--<td align="center"><? //echo DisplayDate($rs->fields['m_submit_dt']);?>&nbsp;</td>-->
                </tr>
                <?
                $cnt = $cnt + 1;
                $bil = $bil + 1;
                $rs->movenext();
            }
            $rs->Close();
        }
            ?>
              </table></td>
            </tr>
            <tr>
            <td></td>
		 <td colspan="3"><br><input type="button" value="Daftar" class="button_disp" title="Sila klik untuk menyimpan maklumat" 

                    onClick="form_hantar('index.php?data=<? print base64_encode('user;asrama/dmasuk_form_do.php;asrama;masuk;')?>')">

                	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai daftar masuk pelajar ke asrama" 

                    onClick="do_back('index.php?data=<? print base64_encode('user;asrama/dmasuk_list.php;asrama;masuk;');?>')">

                    <!--<input type="hidden" name="id" value="<?//$id?>" /> -->

                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" /></td>
            </tr>
        </table>

      </td>

   </tr>

</table>

</form>