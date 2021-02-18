<link rel="stylesheet" href="modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="modalwindow/dhtmlwindow.js"></script>
<script type="text/javascript" src="modalwindow/modal.js"></script>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
		document.ilim.action = URL;
		document.ilim.submit();
}
function form_dkeluar(URL,id) {
	if(confirm('Adakah anda pasti untuk pendaftaran keluar pelajar ini dari asrama?')) {
		var URL = "asrama/penghuni_keluar_form.php?id="+id;
		openModalWindow(URL,"Proses pengesahan keluar dari asrama");
		//document.ilim.proses.value = 'keluar';
		//document.ilim.action = URL;
		//document.ilim.submit();
	}
}
function do_cetak(strFileName,id){
	strFileName = strFileName + '?id='+id;
	window.open(strFileName,"Items","toolbar=no,location=no,directories=no,status=no,menubar=yes,scrollbars=yes,resizable=yes,copyhistory=no,width=900,height=450,top=55,left=160");
}

function do_back(URL){
	document.ilim.action =URL;
	document.ilim.submit();
}

function openModalWindow(URL,Title){
	modalWindow=dhtmlmodal.open('Box', 'iframe', URL, Title, 'width=750px,height=450px,center=1,resize=0,scrolling=1')
	modalWindow.onclose=function(){ //Define custom code to run when window is closed
		var theform=this.contentDoc.forms[0] //Access first form inside iframe just for your reference
		var theemail=this.contentDoc.getElementById("proses") //Access form field with id="emailfield" inside iframe
		if (theemail.value == "selesai"){ //crude check for invalid email
			var url = document.ilim.data.value;
			//alert("refresh");
			//document.getElementById("youremail").innerHTML=theemail.value //Assign the email to a span on the page
			//jah('./cal/calendar_akhbar.php?nextMonth='+mth+'&curYear='+yr+'&p=NEXT','calender');
			//document.ilim.reload();
			document.ilim.action = url;
			document.ilim.submit();
			return true; //allow closing of window
		}
	//	else{ //else if this is a valid email
	//	}
	}
} //End "openModalWindow" function

function open_kemudahan(URL,Title){
	modalWindow=dhtmlmodal.open('Box', 'iframe', URL, Title, 'width=750px,height=200px,center=1,resize=0,scrolling=1')
	modalWindow.onclose=function(){ //Define custom code to run when window is closed
	document.ilim.reload();
	return true; //allow closing of window
	}
} //End "openModalWindow" function
</script>
<?
$sql = "SELECT * FROM _sis_tblpelajar A, _sis_a_tblasrama C, ref_kursus B WHERE A.kursus_id=B.kid 
AND A.pelajar_id=C.pelajar_id AND C.daftar_id=".tosql($id,"Text");
$rs = $conn->execute($sql);
$pelajar_id = $rs->fields['pelajar_id'];
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="1" border="0">
	<tr><td colspan="2">
    	<table width="95%" cellpadding="5" cellspacing="1" border="0" align="center">
          <tr bgcolor="#00CCFF">
    	<td colspan="4" height="30">&nbsp;<b>MAKLUMAT PENGHUNI ASRAMA</b></td>
    </tr>
           <tr>
             <td colspan="4" class="title">A.&nbsp;&nbsp;&nbsp;MAKLUMAT BILIK</td>
           </tr>
           <tr>
             <td>No. Bilik : </td>
             <td colspan="3"><b><? echo dlookup("_sis_a_tblbilik", "no_bilik", "bilik_id = '".$rs->fields['bilik_id']."'");?></b>
             <input name="bilik_id" type="hidden" value="<?=$rs->fields['bilik_id']?>" /> 
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			 <input type="button" value="Cetak Borang Keluar" class="button_disp" onclick="do_cetak('report/cetak_daftark_asrama.php','<?=$pelajar_id;?>')" 
             	title="Sila klik untuk cetak borang keluar asrama" >
             <input type="button" value="Daftar Keluar" class="button_disp" title="Sila klik untuk pendaftaran keluar pelajar" 
             alt="Sila klik untuk pendaftaran keluar pelajar" 
             	onClick="form_dkeluar('index.php?data=<? print base64_encode('user;asrama/penghuni_form_do.php;asrama;penghuni;');?>','<?=$id;?>')"> 
             <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk ke senarai penghuni asrama" 
             	onclick="do_back('index.php?data=<? print base64_encode('user;asrama/penghuni_list.php;asrama;penghuni;');?>')" />
               </td>
           </tr>

            <tr>

                <td colspan="4" class="title">B.&nbsp;&nbsp;&nbsp;MAKLUMAT PELAJAR</td>
            </tr>

            <tr>

                <td width="25%">1. Nama Pelajar : </td>

              <td colspan="2"><?=$rs->fields['p_nama']?>
              				           </td>
              <td rowspan="5" align="center"><span id="ImgViewBoarder"><span id="ImgView">

                    <img id="elImage" src="student/student_pic/<?=$rs->fields['img_pelajar'];?>" width="100" height="120"></span></span>
&nbsp;</td>
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

        - [<? echo dlookup("ref_syukbah","ref_sukbah","ref_sukbah_id=".$rs->fields['syukbah_id']);?>]              </td>
            </tr>
            <tr>
              <td>5. Semester : </td>
              <td colspan="2"><?=dlookup("ref_semester","semester","semester_id=".$rs->fields['semester_id'])?> </td>
            </tr>
            <tr>

                <td>6. Alamat Surat-menyurat : </td>

                <td colspan="3"><? echo $rs->fields['p_alamat1'].$rs->fields['p_alamat2'].$rs->fields['p_alamat3']; ?><br />
				<?=$rs->fields['p_poskod']?><br />
				<? echo dlookup("refstate", "fldstatedesc", "fldstateID = '".$rs->fields['p_negeri_id']."'");?>                </td>
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

              <td colspan="3"><input type="text" name="p_poskod" size="5" maxlength="5" value="<?=$rs->fields['p_poskod']?>"></td>
            </tr>-->

            <tr>

                <td>17. No. Telefon (R): </td>

                <td width="26%"><input type="text" name="p_no_tel" size="20" maxlength="15" value="<?=$rs->fields['p_no_tel']?>"></td>

                <td width="22%">18. No. Telefon (HP) :</td>

                <td width="27%"><input type="text" name="p_no_hp" size="20" maxlength="15" value="<?=$rs->fields['p_no_hp']?>"></td>
            </tr>

            <tr>

              <td>19. Pekerjaan : </td>

              <td colspan="3"><input type="text" name="p_pekerjaan" size="70" maxlength="120" value="<?=$rs->fields['p_pekerjaan']?>"></td>
            </tr>

            <tr>

              <td>20. Pendapatan Bulanan Ibu/Bapa/Penjaga : </td>

              <td colspan="3">RM
                <input type="text" name="p_pendapatan" size="15" maxlength="15" value="<?=$rs->fields['p_pendapatan']?>">
              (Masukkan angka sahaja)</td>
          </tr>
            <tr>
              <td colspan="3" class="title">D.&nbsp;&nbsp;&nbsp;MAKLUMAT BARANGAN ELEKTRIK</td>
              <td class="title" align="right"><input type="button" value="Tambah Maklumat Barangan Elektrik" onclick="open_kemudahan('asrama/asrama_elektrik.php?tid=<?=$id?>','Maklumat Barang Elektrik'); return false" /></td>
            </tr>
            <?php 
			$sSQL="SELECT * FROM _sis_a_tblelektrik WHERE daftar_id=".tosql($id,"Text");
            
            $sSQL.= " ORDER BY jenis";
            
            $rs = $conn->Execute($sSQL);
            
            $cnt = $rs->recordcount();
			?>
            <tr>
              <td colspan="4"><table border="1" width="100%" cellspacing="0" cellpadding="5" bordercolorlight="#000000" bordercolordark="#FFFFFF">
                  <tr bgcolor="#D1E0F9">
                    <td width="10%" align="center"><b>Bil</b></td>
                    <td width="30%" align="center"><strong>Jenis</strong></td>
                    <td width="30%" align="center"><strong>Jenama</strong></td>
                    <td width="15%" align="center"><strong>Model</strong></td>
                    <td width="10%" align="center"><strong>Watt</strong></td>
                    <td width="5%" align="center"><strong>Edit&nbsp;</strong></td>
                   </tr>
                  <?

        if(!$rs->EOF) {

            $cnt = 1;

            $bil = 1;

            while(!$rs->EOF ) {

                ?>
                  <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>" >
                    <td align="center"><? echo $bil;?>&nbsp;</td>
         			<td valign="top"><? echo $rs->fields['jenis'];?>&nbsp;</td>
                    <td align="center"><? echo $rs->fields['jenama'];?>&nbsp;</td>
                    <td align="center"><? echo $rs->fields['model'];?>&nbsp;</td>
                    <td align="center"><? echo $rs->fields['watt'];?>&nbsp;</td>
                    <td align="center"><img src="images/edit.png" onclick="open_kemudahan('asrama/asrama_elektrik.php?id=<?=$rs->fields['barang_id'];?>&tid=<?=$id?>','Maklumat Barang Elektrik'); return false" onMouseOver="this.style.cursor='pointer'"/></td>
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
              <td colspan="3" class="title">E.&nbsp;&nbsp;&nbsp;MAKLUMAT KEMUDAHAN YANG DIPEROLEHI</td>
              <td class="title" align="right"><input type="button" value="Tambah Kemudahan" onclick="open_kemudahan('asrama/asrama_kemudahan.php?tid=<?=$id?>','Maklumat Kemudahan'); return false" />&nbsp;</td>
            </tr>
            <?php 
			$sSQL="SELECT a.*, b.inv_nama FROM _sis_a_tblinventori_det a,_sis_a_tblinventori b WHERE b.inventori_id = a.inv_id AND a.is_deleted= 0 
			AND a.daftar_id=".tosql($id,"Text");
            
            $rs = $conn->Execute($sSQL);
            
            $cnt = $rs->recordcount();
			?>
            <tr>
              <td colspan="4"><table border="1" width="100%" cellspacing="0" cellpadding="5" bordercolorlight="#000000" bordercolordark="#FFFFFF">
                  <tr bgcolor="#D1E0F9">
                    <td width="10%" align="center"><b>Bil</b></td>
                    <td width="40%" align="center"><strong>Jenis Kemudahan</strong></td>
                    <td width="20%" align="center"><strong>Bilangan</strong></td>
                    <td width="20%" align="center"><strong>Tarikh Gunapakai</strong></td>
                    <td width="10%" align="center"><strong>&nbsp;Edit</strong></td>
                </tr>
                  <?

        if(!$rs->EOF) {

            $cnt = 1;

            $bil = 1;

            while(!$rs->EOF ) {

                ?>
                  <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>" >
                    <td align="center"><? echo $bil;?>&nbsp;</td>
         			<td valign="top"><? echo $rs->fields['inv_nama'];?>&nbsp;</td>
                    <td align="center"><? echo $rs->fields['bil'];?>&nbsp;</td>
                    <td align="center"><? echo DisplayDate($rs->fields['create_dt']);?>&nbsp;</td>
                    <td align="center"><img src="images/edit.png" onclick="open_kemudahan('asrama/asrama_kemudahan.php?id=<?=$rs->fields['kemudahan_id'];?>&tid=<?=$id?>','Maklumat Kemudahan'); return false" onMouseOver="this.style.cursor='pointer'"/></td>
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
              <td colspan="4" class="title">F.&nbsp;&nbsp;&nbsp;LATAR BELAKANG PENEMPATAN</td>
            </tr>
            <?php 
			//$conn->debug=true;
			/*$sSQL="SELECT A.semester semester, B.ref_blok ref_blok, C.no_bilik no_bilik, D.daftar_id daftar_id, D.tkh_masuk tkh_masuk, D.tkh_keluar tkh_keluar FROM 				                   ref_semester A, ref_asrama_blok B, _sis_a_tblbilik C, _sis_a_tblasrama D WHERE A.semester_id=D.semester_id AND C.bilik_id=D.bilik_id 
					AND B.ref_blok_id=C.blok_id AND D.is_keluar=1 AND D.pelajar_id= ".tosql($pelajar_id,"Text");
            $sSQL.= " ORDER BY D.daftar_id";*/
			
			$sSQL = "SELECT D.semester_id, D.daftar_id daftar_id, D.tkh_masuk tkh_masuk, D.tkh_keluar tkh_keluar, C.no_bilik no_bilik, B.ref_blok ref_blok
			FROM ref_asrama_blok B, _sis_a_tblbilik C, _sis_a_tblasrama D
			WHERE C.bilik_id=D.bilik_id 
			AND B.ref_blok_id=C.blok_id AND D.is_keluar=1 AND D.pelajar_id= ".tosql($pelajar_id,"Text")." 
			ORDER BY D.daftar_id";
            $rs = $conn->Execute($sSQL);
            $cnt = $rs->recordcount();
			?>
            <tr>
              <td colspan="4"><table border="1" width="100%" cellspacing="0" cellpadding="5" bordercolorlight="#000000" bordercolordark="#FFFFFF">
                <tr bgcolor="#D1E0F9">
                  <td width="5%" align="center"><b>Bil</b></td>
                  <td width="25%" align="center"><strong>Semester</strong></td>
                  <td width="25%" align="center"><b>Blok</b></td>
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
		 		<td colspan="4" align="center">
                <? $href_search = "index.php?data=".base64_encode('user;asrama/penghuni_list.php;asrama;penghuni'); ?>
            	<br><input type="button" value="Kemaskini" class="button_disp" title="Sila klik untuk menyimpan maklumat" 
                    onClick="form_hantar('index.php?data=<? print base64_encode('user;asrama/penghuni_form_do.php;asrama;penghuni;'.$id);?>')">
            		<input type="button" value="Cetak Borang Masuk" title="Sila klik untuk cetak borang pengesahan kemasukan ke asrama" 
                    class="button_disp" onclick="do_cetak('report/cetak_daftar_asrama.php','<?=$pelajar_id;?>')" >
                	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk ke senarai penghuni asrama"  
                    onClick="do_back('index.php?data=<? print base64_encode('user;asrama/penghuni_list.php;asrama;penghuni;');?>')">

                    <input type="hidden" name="proses" value="update" />
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                    <input type="hidden" name="data" value="<?=$href_search;?>" />
                </td>
            </tr>
        </table>

      </td>

   </tr>

</table>

</form>