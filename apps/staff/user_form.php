<link rel="stylesheet" href="modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="modalwindow/dhtmlwindow.js">

/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<script type="text/javascript" src="modalwindow/modal.js"></script>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(document.ilim.fld_staff.value==''){
		alert("Sila masukkan nama kakitangan akademik terlebih dahulu.");
		document.ilim.fld_staff.focus();
		return true;
	} else if(document.ilim.fld_kp.value==''){
		alert("Sila masukkan No. Kad Pengenalan.");
		document.ilim.fld_kp.focus();
		return true;
	} else {
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
function upload_gambar(URL){
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Kemaskini Gambar Kakitangan', 'width=550px,height=200px,center=1,resize=0,scrolling=1')
} //End "opennewsletter" function

</script>
<?
//$conn->debug=true;
$PageNo = $_POST['PageNo'];
$sSQL="SELECT * FROM _sis_tblstaff WHERE staff_id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
?>
<form name="ilim" method="post">
<table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
    <tr bgcolor="#00CCFF">
    	<td colspan="2" height="30">&nbsp;<b>MAKLUMAT PENGGUNA SISTEM</b></td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="1" cellspacing="0" border="0" align="center">
            <tr>
                <td colspan="4" class="title">A.&nbsp;&nbsp;&nbsp;MAKLUMAT AM</td>
            </tr>
            <tr>
                <td width="30%">Nama Penuh : </td>
                <td width="50%" colspan="2"><input type="text" size="65" name="fld_staff" value="<? print $rs->fields['fld_staff'];?>" /></td>
                <td width="20%" rowspan="4" align="center">
                	<? if(!empty($id)){ ?>
                    <img src="staff/staffimgdownload.php?id=<? echo $id;?>" width="100" height="120" border="0">
                    <!--<span id="ImgViewBoarder"><span id="ImgView">
                        <img id="elImage" src="staff/staff_pic/<?=$rs->fields['fld_image'];?>" width="100" height="120"></span></span>-->
                        <input type="hidden" name="pic" size="40" value="<?=$rs->fields['fld_image'];?>" readonly=""><br>
                        <!--<a style="cursor:pointer" onclick="Javascript:open('staff/staff_pic/upload_img.php?id=<?=$id;?>', 'upload', 'toolbar=0,scrollbars=1,location=0,status=0,menubar=0,resizable=0,width=500,height=300,left=200,top=200');"><b>Upload Gambar</b></a>--> 
                        <input type="button" value="Upload Gambar" onclick="upload_gambar('staff/staff_pic/upload_img.php?id=<?=$id;?>'); return false" />
					<? } ?>
               </td>
            </tr>
            <tr>
                <td width="20%">No. K/P : </td>
                <td width="80%" colspan="3"><input type="text" name="fld_kp"  value="<? print $rs->fields['fld_kp'];?>" /></td>
            </tr>
            <tr>
                <td valign="top">Alamat Surat-menyurat : </td>
                <td colspan="2"><textarea cols="60" rows="4" name="fld_alamat"><? print $rs->fields['fld_alamat'];?></textarea></td>
            </tr>
            <!--<tr>
              <td>Poskod : </td>
              <td colspan="3"><input type="text" name="new_pass" size="5" maxlength="5" value="<? print $rs->fields['fld_staff'];?>"></td>
            </tr>-->
            <tr>
                <td width="20%">No. Telefon : </td>
                <td width="50%" colspan="2"><input type="text" name="fld_tel" size="20" maxlength="15" value="<? print $rs->fields['fld_tel'];?>"></td>
            </tr>
            <tr>
                <td width="20%">Jantina : </td>
                <td width="50%" colspan="2">
                	<select name="jantina">
                    	<option value="L" <? if($rs->fields['fld_jantina']=='L'){ print 'selected'; }?>>Lelaki</option>
                    	<option value="P" <? if($rs->fields['fld_jantina']=='P'){ print 'selected'; }?>>Perempuan</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="20%">e-Mail : </td>
                <td width="80%" colspan="3"><input type="text" name="fld_email"  size="65" value="<? print $rs->fields['fld_email'];?>" /></td>
            </tr>
            <tr>
                <td colspan="4" class="title">B.&nbsp;&nbsp;&nbsp;MAKLUMAT KERJA</td>
            </tr>
			<?
                $sql_p = "SELECT * FROM ref_pusat_pengajian WHERE pusat_status=0";
				//if(!empty($rs->fields['kursus_id'])){ $sql_p .= " WHERE kursus_id=".$rs->fields['kursus_id']; }
                $rspusat = &$conn->Execute($sql_p);
            ?>
            <tr>
                <td align="left">Pusat Pengajian :</td>
                <td colspan="3">
                    <select name="pusatid">
                        <? while(!$rspusat->EOF) { ?>
                        <option value="<?=$rspusat->fields['pusat_id'];?>" <? if($rs->fields['fldpusat']==$rspusat->fields['pusat_id']){ print 'selected'; }?>>[<?=$rspusat->fields['pusat_no'];?>]&nbsp;&nbsp;<?=$rspusat->fields['pusat_nama'];?></option>
                        <? $rspusat->MoveNext(); } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td valign="top">Jawatan : </td>
                <td colspan="3">
                	<input type="checkbox" name="is_pensyarah" value="Y" <? if($rs->fields['is_pensyarah']=='Y'){ print 'checked';} ?> />&nbsp;&nbsp;Pensyarah<br />
                	<input type="checkbox" name="is_tutor" value="Y" <? if($rs->fields['is_tutor']=='Y'){ print 'checked';} ?> />&nbsp;&nbsp;Tutor<br />
                	<input type="checkbox" name="is_warden" value="Y" <? if($rs->fields['is_warden']=='Y'){ print 'checked';} ?> />&nbsp;&nbsp;Penyelia Asrama<br />
                	<input type="checkbox" name="is_hep" value="Y" <? if($rs->fields['is_hep']=='Y'){ print 'checked';} ?> />&nbsp;&nbsp;Pegawai HEP<br />
                </td>
            </tr>
            <tr>
                <td valign="top" height="25">ID pengguna : </td>
                <td colspan="3"><b><? print $rs->fields['flduser_name'];?></b>
                <input type="hidden" name="user_name" value="<? print $rs->fields['flduser_name'];?>"  />
                </td>
            </tr>
            <tr>
                <td>Status : </td>
                <td>
                	<select name="flduser_activated">
                    	<option value="1" <? if($rs->fields['flduser_activated']=='1'){ print 'selected';} ?>>Aktif</option>
                        <option value="0" <? if($rs->fields['flduser_activated']=='0'){ print 'selected';} ?>>Tidak Aktif</option>
                    </select>
                </td>
                <td>Pengguna Sistem : </td>
                <td>
                	<select name="is_user">
                    	<option value="1" <? if($rs->fields['is_user']=='1'){ print 'selected';} ?>>Ya</option>
                    	<option value="0" <? if($rs->fields['is_user']=='0'){ print 'selected';} ?>>Tidak</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="3"><br>
                	<input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" 
                    onClick="form_hantar('index.php?data=<? print base64_encode('user;staff/user_form_do.php;admin;user;')?>')">
                	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai pengguna sistem" 
                    onClick="do_back('index.php?data=<? print base64_encode('user;staff/user_list.php;admin;user;');?>')">
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                </td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.fld_staff.focus();
</script>
