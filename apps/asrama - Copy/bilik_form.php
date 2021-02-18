<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(document.ilim.no_bilik.value==''){
		alert("Sila masukkan no bilik terlebih dahulu.");
		document.ilim.no_bilik.focus();
		return true;
	} else if(document.ilim.tingkat_id.value==''){
		alert("Sila masukkan Tingkat");
		document.ilim.tingkat_id.focus();
		return true;
	} else {
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

function form_delete(URL){
	if(confirm('Adakah anda pasti untuk menghapuskan data ini?')) {
		document.ilim.del.value = '1';
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

function do_back(URL){
	document.ilim.action =URL;
	document.ilim.submit();
}

function Update_Img(msg){
	//window.parent.frm.submit();
	document.ilim.pic.value = msg;
	document.ilim.elImage.src = msg;
//alert(msg);
	//window.refresh();
}
</script>
<?
//$conn->debug=true;
$PageNo = $_GET['PageNo'];
$sSQL="SELECT * FROM _sis_a_tblbilik  WHERE bilik_id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
$bil_penghuni = dlookup("_sis_a_tblasrama", "count(daftar_id)", "bilik_id = ".$id." AND is_daftar = 1");
?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="1" cellspacing="0" border="0">
    <tr bgcolor="#00CCFF">
    	<td colspan="2" height="30">&nbsp;<b>MAKLUMAT BILIK ASRAMA/PENGINAPAN</b></td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="1" cellspacing="0" border="0" align="center">
            <tr>
                <td colspan="3" class="title">A.&nbsp;&nbsp;&nbsp;MAKLUMAT BILIK</td>
           </tr>
            <tr>
                <td width="30%">No Bilik : </td>
                <td width="80" colspan="2"><input name="no_bilik" type="text" id="no_bilik" value="<? print $rs->fields['no_bilik'];?>" size="20" /></td>
            </tr>
            <tr>
              <td>Blok : </td>
              <td colspan="2"><select name="blok_id">
			   <?  	//$conn->debug=true;
                    $sql_l = "SELECT * FROM _ref_blok_bangunan WHERE f_kb_id=2 AND f_bb_status = 0 AND is_deleted=0 ORDER BY f_bb_desc";
                    $rs_l = &$conn->Execute($sql_l); 
                    while(!$rs_l->EOF){
                        print '<option value="'.$rs_l->fields['f_bb_id'].'"'; 
                        if($rs_l->fields['f_bb_id']==$blok_search){ print 'selected'; }
                        print '>'. $rs_l->fields['f_bb_desc'] .'</option>';
                        $rs_l->movenext();
                    }
                ?>
	         </select></td>
            </tr>
            <tr>
                <td width="30%">Aras : </td>
                <td width="80" colspan="2"><select name="tingkat_id">
            <?  $sql_l = "SELECT * FROM _ref_aras_bangunan WHERE f_ab_status = 0 ORDER BY f_ab_desc";
						$rs_l = &$conn->Execute($sql_l); 
						while(!$rs_l->EOF){
							print '<option value="'.$rs_l->fields['f_ab_id'].'"';
							if($rs_l->fields['f_ab_id']==$rs->fields['tingkat_id']){ print 'selected'; }
							print '>'. $rs_l->fields['f_ab_desc'].'</option>';
							$rs_l->movenext();
						}
					?>
            </select></td>
            </tr>
            <tr>
              <td>Jenis Bilik</td>
              <td colspan="2"><select name="jenis">
                 <option value="1" <? if($rs->fields['jenis_bilik'] == '1') echo 'selected';?> >BILIK SEORANG</option>
                 <option value="2" <? if($rs->fields['jenis_bilik'] == '2') echo 'selected';?> >SEBILIK 2 ORANG</option>
                 <option value="3" <? if($rs->fields['jenis_bilik'] == '3') echo 'selected';?> >SEBILIK 3 ORANG</option>
              </select></td>
            </tr>
           <?php if( $bil_penghuni == 0) {?>
            <tr>
                <td width="30%">Keadaan Bilik : </td>
                <td width="80" colspan="2"><select name="keadaan">
               			<option value="1" <? if($rs->fields['keadaan_bilik'] == '1') echo 'selected';?> >SEDIA DIDUDUKI</option>
                    	<option value="0" <? if($rs->fields['keadaan_bilik'] == '0') echo 'selected';?> >SEDANG DISELENGGARA</option>
                    </select>    </td>
            </tr>
			<?php }?>

            <tr>
                <td></td>
                <td><br>
                    <?php //if( $bil_penghuni == 0){ ?>
			<input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" 
                    onClick="form_hantar('index.php?data=<? print base64_encode('user;asrama/bilik_form_do.php;asrama;bilik;')?>')">
			<? //} ?>
                    <?php if( $bil_penghuni == 0 && !empty($id)) {?>
                    <input type="button" value="Hapus"  name="hapus" id="hapus" class="button_disp" title="Sila klik untuk menghapus maklumat" 
                    onClick="form_delete('index.php?data=<? print base64_encode('user;asrama/bilik_form_do.php;asrama;bilik;')?>')">
                     <?php } ?>
                	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai maklumat bilik" 
                    onClick="do_back('index.php?data=<? print base64_encode('user;asrama/bilik_list.php;asrama;bilik;');?>&blok_id=<?=$blok_id?>&page=<?=$PageNo?>')">
                     <input type="hidden" name="del" value="0" />
			<input type="hidden" name="bilp" value="<?=$bil_penghuni;?>" />
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />                </td>
            </tr>

			<tr><td>&nbsp;</td></td></tr>
            <tr>
                <td colspan="3" class="title">B.&nbsp;&nbsp;&nbsp;MAKLUMAT PENGHUNI</td>
            </tr>
            <tr>
                <td colspan="3">
               <?
                $sSQL="SELECT A.bilik_id bilik_id,A.pelajar_id pelajar_id,A.daftar_id daftar_id,A.semester_id semester_id, B.p_nama p_nama, B.kursus_id kursus_id FROM                       _sis_a_tblasrama A, _sis_tblpelajar B WHERE B.pelajar_id = A.pelajar_id AND A.is_daftar = 1 AND A.bilik_id = ".tosql($id,"Number");
                $sSQL.= " ORDER BY B.p_nama";
                //$rs2 = $conn->Execute($sSQL);
				//$cnt = $rs2->recordcount();
				?>
                <table border="1" width=100% cellspacing="0" cellpadding="5" bordercolorlight="#000000" bordercolordark="#FFFFFF">
                  <tr bgcolor="#D1E0F9"> 
                    <td width="2%" align="center"><b>Bil</b></td>
                    <td width="35%" align="center"><b>Nama Peserta</b></td>
                    <td width="30%" align="center"><b>Agensi</b></td>
                    <td width="33%" align="center"><b>Kursus</b></td>
                  </tr>
          <?
        	/*if(!$rs2->EOF) {
            $cnt = 1;
            $bil = 1;
            while(!$rs2->EOF ) {
                $href_link = "index.php?data=".base64_encode('user;asrama/penghuni_form.php;asrama;penghuni;'.$rs2->fields['daftar_id']);
            ?>
          <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
            <td align="right"><? echo $bil;?>.&nbsp;</td>
            <td align="left" valign="top">
            	<a href='<?=$href_link;?>'><? echo stripslashes($rs2->fields['p_nama']);?></a>&nbsp;            </td>
            <td align="center"><? echo dlookup("ref_semester", "semester", "semester_id = '".$rs2->fields['semester_id']."'");?>&nbsp;</td>
            <td align="center"><? echo dlookup("ref_kursus", "kursus", "kid = '".$rs2->fields['kursus_id']."'");?>&nbsp;</td>
            <!--<td align="center"><? //echo DisplayDate($rs->fields['m_submit_dt']);?>&nbsp;</td>-->
         </tr>
          <?
                $cnt = $cnt + 1;
                $bil = $bil + 1;
                $rs2->movenext();
            	}
            	$rs2->Close();
        	}
            */?>
        </table>         </td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.no_bilik.focus();
</script>