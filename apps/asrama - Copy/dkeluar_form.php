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
$sql = "SELECT * FROM _sis_tblpelajar A, _sis_a_tblasrama C 
WHERE A.pelajar_id=C.pelajar_id AND C.daftar_id=".tosql($id,"Text");
$rs = &$conn->execute($sql);
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="1" border="0">
	<tr><td colspan="2">
    	<table width="95%" cellpadding="5" cellspacing="1" border="0" align="center">
	        <tr bgcolor="#00CCFF">
	    		<td colspan="4" height="30">&nbsp;<b>DAFTAR KELUAR ASRAMA</b></td>
    		</tr>
           <tr>
             <td colspan="4" class="title">A.&nbsp;&nbsp;&nbsp;MAKLUMAT BILIK</td>
           </tr>
           <tr>
             <td>No. Bilik : </td>
             <td colspan="3"><? echo dlookup("_sis_a_tblbilik", "no_bilik", "bilik_id = '".$rs->fields['bilik_id']."'");?>
             <input name="bilik_id" type="hidden" value="<?=$rs->fields['bilik_id']?>" /></td>
           </tr>
            <tr>
                <td colspan="4" class="title">B.&nbsp;&nbsp;&nbsp;MAKLUMAT PELAJAR</td>
            </tr>
            <tr>
                <td width="25%">1. Nama Pelajar : </td>
              <td colspan="2"><input type="text" size="60" value="<?=$rs->fields['p_nama']?>" /></td>
              <td rowspan="5" align="center"><span id="ImgViewBoarder"><span id="ImgView">
              <img id="elImage" src="student/student_pic/<?=$rs->fields['img_pelajar'];?>" width="100" height="120"></span></span>
&nbsp;</td>
          </tr>
            <tr>
              <td>2. No. Matrik : </td>
              <td><input type="text" size="30" maxlength="30" value="<?=$rs->fields['no_pendaftaran']?>" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>3. No. KP / Passport: </td>
              <td><input type="text" size="30" maxlength="30" value="<?=$rs->fields['p_nokp']?>" /></td>
              <td>&nbsp;</td>
            </tr>

            <tr>
              <td>4. Syukbah : </td>
              <td colspan="2"><input type="text" size="30" maxlength="30" value="<? echo dlookup("ref_kursus", "kursus", "kid = '".$rs->fields['kursus_id']."'");?>" />
                                </td>
            </tr>
            <tr>
              <td>5. Semester : </td>
              <td colspan="2"><input type="text" size="30" maxlength="30" value="" /></td>
            </tr>
            <tr>

                <td>6. Alamat Surat-menyurat : </td>

                <td colspan="3"><textarea cols="50" rows="5"><? echo $rs->fields['p_alamat1'].$rs->fields['p_alamat2'].$rs->fields['p_alamat3'].dlookup("refstate", "fldstatedesc", "fldstateID = '".$rs->fields['p_negeri_id']."'");?></textarea></td>
            </tr>

            <tr>

              <td>7. Poskod : </td>

              <td colspan="3"><input type="text" size="5" maxlength="5" value="<?=$rs->fields['p_poskod']?>"></td>
            </tr>

            <tr>

                <td>8. Tarikh Lahir : </td>

                <td width="26%"><input type="text" size="20" maxlength="15" value="<?=DisplayDate($rs->fields['p_tkh_lahir']);?>"/></td>

              <td width="22%">9. Jantina : </td>

              <td width="27%">

   	  <select name="">

                    	<option value="L"  <? if($rs->fields['p_jantina'] == 'L') echo 'selected';?> >Lelaki</option>

                    	<option value="P"  <? if($rs->fields['p_jantina'] == 'P') echo 'selected';?> >Perempuan</option>
                    </select>                </td>
          </tr>

            <tr>
              <td>10. No. Telefon (R): </td>
              <td><input type="text" name="no_telefon" size="20" maxlength="15" value="<?=$rs->fields['p_notel']?>" /></td>

                <td>11. No. Telefon (HP): </td>
                <td><input type="text" name="no_hp" size="20" maxlength="15" /></td>
            </tr>

            <tr>
              <td>12. Kewarganegaraan : </td>
              <td><select name="">
                  <option value="M">Warganegara</option>
                  <option value="T">Thailand</option>
                </select>              </td>

                <td>&nbsp;</td>

          <td>&nbsp;</td>
          </tr>
            <tr>
              <td>13. PNGK : </td>
              <td><input type="text" name="pngk" size="10" maxlength="10" /></td>
              <td>14. HPMG Terakhir: </td>
              <td><input type="text" name="hpmg" size="10" maxlength="10" /></td>
            </tr>

         
            <tr>

                <td colspan="4" class="title">C.&nbsp;&nbsp;&nbsp;MAKLUMAT IBU / BAPA / PENJAGA</td>
            </tr>
			<tr>

                <td>15. Nama : </td>

                <td colspan="3"><input name="penjaga_nama" type="text" size="70" value="<?=$rs->fields['penjaga_nama']?>" /></td>
            </tr>

            <tr>

                <td>16. Alamat Surat-menyurat : </td>

                <td colspan="3"><textarea cols="60" rows="4" name="p_alamat"><?=$rs->fields['p_alamat']?></textarea></td>
            </tr>

            <tr>

              <td>17. Poskod : </td>

              <td colspan="3"><input type="text" name="poskod" size="5" maxlength="5"></td>
            </tr>

            <tr>

                <td>18. No. Telefon (R): </td>

                <td width="26%"><input type="text" name="p_no_tel" size="20" maxlength="15" value="<?=$rs->fields['p_no_tel']?>"></td>

                <td width="22%">19. No. Telefon (HP) :</td>

                <td width="27%"><input type="text" name="p_no_hp" size="20" maxlength="15" value="<?=$rs->fields['p_no_hp']?>"></td>
            </tr>

            <tr>

              <td>21. Pekerjaan : </td>

              <td colspan="3"><input type="text" name="p_pekerjaan" size="70" maxlength="120" value="<?=$rs->fields['p_pekerjaan']?>"></td>
            </tr>

            <tr>

              <td>22. Pendapatan Bulanan Ibu/Bapa/Penjaga : </td>

              <td colspan="3"><input type="text" name="p_pendapatan" size="15" maxlength="15" value="<?=$rs->fields['p_pendapatan']?>"></td>
            </tr>
            <tr>
              <td colspan="4" class="title">D.&nbsp;&nbsp;&nbsp;LATAR BELAKANG PENEMPATAN</td>
            </tr>
            <?php 
			$sSQL="SELECT A.semester semester, B.ref_blok ref_blok, C.no_bilik no_bilik, D.daftar_id daftar_id FROM ref_semester A, ref_asrama_blok B,
			       _sis_a_tblbilik C, _sis_a_tblasrama D WHERE A.semester_id=D.semester_id AND C.bilik_id=D.bilik_id AND B.ref_blok_id=C.blok_id AND D.is_keluar=1 
			        AND D.pelajar_id= ".tosql($rs->fields['pelajar_id'],"Text");
            
            $sSQL.= " ORDER BY D.daftar_id";
            
            $rs = &$conn->Execute($sSQL);
            
            $cnt = $rs->recordcount();
			?>
            <tr>
              <td colspan="4"><table border="1" width="80%" cellspacing="0" cellpadding="5" bordercolorlight="#000000" bordercolordark="#FFFFFF">
                <tr bgcolor="#D1E0F9">
                  <td width="10%" align="center"><b>Bil</b></td>
                  <td width="29%" align="center"><strong>Semester</strong></td>
                  <td width="31%" align="center"><b>Blok</b></td>
                  <td width="30%" align="center"><b>No. Bilik</b></td>
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
                  <td align="left" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <!--<td width="7%" valign="top"><input type="checkbox" name="chkPilih[]" value="" /></td>-->
                        <td width="93%" valign="top"><? echo $rs->fields['semester'];?>&nbsp;</td>
                      </tr>
                  </table></td>
                  <td align="center"><? echo $rs->fields['ref_blok'];?>&nbsp;</td>
                  <td align="center"><? echo $rs->fields['no_bilik'];?>&nbsp;</td>
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
		 <td colspan="3"><br><input type="button" value="Daftar Keluar" class="button_disp" title="Sila klik untuk menyimpan maklumat" 

                    onClick="form_hantar('index.php?data=<? print base64_encode('user;asrama/dkeluar_form_do.php;asrama;keluar;'.$id);?>')">

                	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai pelajar yang mendaftar di asrama" 

                    onClick="do_back('index.php?data=<? print base64_encode('user;asrama/dkeluar_list.php;asrama;keluar;');?>')">

                    <input type="hidden" name="id" value="<?=$id?>" />

                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" /></td>
            </tr>
        </table>

      </td>

   </tr>

</table>

</form>