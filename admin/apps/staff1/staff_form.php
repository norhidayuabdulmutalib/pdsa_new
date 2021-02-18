<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(document.ilim.f_name.value==''){
		alert("Sila masukkan nama pengguna sistem terlebih dahulu.");
		document.ilim.f_name.focus();
		return true;
	} else if(document.ilim.f_noic.value==''){
		alert("Sila masukkan No. Kad Pengenalan.");
		document.ilim.f_noic.focus();
		return true;
	} else {
		document.ilim.action = URL;
		document.ilim.submit();
	}
}


function form_hapus(URL){
	var staff = document.ilim.f_name.value;
	if(confirm("Adakah anda pasti untuk menghapuskan Rekod Kakitangan Ini.?\n-"+staff)){
		document.ilim.proses.value = "HAPUS";
		document.ilim.action = URL;
		document.ilim.submit();
	}
}
function do_search(URL){
	var fld_kp = document.ilim.f_noic.value;
	var kp1=''; var kp2=''; var kp3='';
	if(fld_kp.length=='12'){
		kp1 = fld_kp.substring(0,6)
		kp2 = fld_kp.substring(6,8)
		kp3 = fld_kp.substring(8,12)
		//alert(kp2);
		fld_kp = kp1+'-'+kp2+'-'+kp3;
	}
	document.ilim.action = URL+"&kp="+fld_kp;
	document.ilim.submit();
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
<?php
//$conn->debug=true;
$PageNo = $_POST['PageNo'];
if(!empty($_POST['f_noic'])){ 
	$sSQL="SELECT * FROM _tbl_user WHERE f_isdeleted=0 AND f_noic = ".tosql($_POST['f_noic'],"Text");
} else {
	$sSQL="SELECT * FROM _tbl_user WHERE id_user = ".tosql($id,"Text");
}
$rs = &$conn->Execute($sSQL);
if(!$rs->EOF){ 
	$kp=$rs->fields['f_noic']; 
	if(!empty($_POST['f_noic'])){
		print '<script language="javascript">
			alert("Nama kakitangan telah ada dalam pangkalan data.");
		</script>';
	}
} else { $kp=$_POST['f_noic']; }
?>
<form name="ilim" method="post">
<table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
    <tr bgcolor="#00CCFF">
    	<td colspan="2" height="30">&nbsp;<b>MAKLUMAT KAKITANGAN / PENGGUNA SISTEM</b></td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
            <tr>
                <td colspan="4" class="title" height="30">A.&nbsp;&nbsp;&nbsp;MAKLUMAT AM</td>
            </tr>
            <tr>
                <td width="30%"><b>No. K/P : </b></td>
                <td width="50%" colspan="2"><input type="text" name="f_noic"  value="<?php print $kp;?>"  
                <?php if(empty($id)){ ?>onchange="do_search('index.php?data=dXNlcjtzdGFmZi9zdGFmZl9mb3JtLnBocDthZG1pbjtzdGFmZjs=')" <?php } ?>/> cth: 700104102478</td>
                <td width="20%" rowspan="6" align="center">
                	<?php if(!empty($id)){ ?>
                    <img src="../staff/staff/staffimgdownload.php?id=<?php echo $id;?>" width="100" height="120" border="0">
                        <br>
                        <input type="button" value="Upload Gambar" onclick="upload_gambar('staff/staff_pic/upload_img.php?id=<?=$id;?>'); return false" />
					<?php } ?>
               </td>
            </tr>
            <tr>
                <td width="20%"><b>Nama Penuh : </b></td>
                <td width="80%" colspan="3"><input type="text" size="65" name="f_name" value="<?php print $rs->fields['f_name'];?>" /></td>
            </tr>
            <tr>
                <td valign="top"><b>Alamat Surat-menyurat : </b></td>
                <td colspan="3"><input type="text" size="65" name="f_alamat1" value="<?php print $rs->fields['f_alamat1'];?>" /></td>
            </tr>
            <tr>
                <td valign="top">&nbsp;</td>
                <td colspan="3"><input type="text" size="65" name="f_alamat2" value="<?php print $rs->fields['f_alamat2'];?>" /></td>
            </tr>
            <tr>
                <td valign="top">&nbsp;</td>
                <td colspan="3"><input type="text" size="65" name="f_alamat3" value="<?php print $rs->fields['f_alamat3'];?>" /></td>
            </tr>
            <tr>
                <td width="20%"><b>No. Telefon : </b></td>
                <td width="50%" colspan="2"><input type="text" name="f_notel" size="20" maxlength="15" value="<?php print $rs->fields['f_notel'];?>"></td>
            </tr>
            <!--<tr>
                <td width="20%"><b>Jantina : </b></td>
                <td width="50%" colspan="2">
                	<select name="jantina">
                    	<option value="L" <?php if($rs->fields['fld_jantina']=='L'){ print 'selected'; }?>>Lelaki</option>
                    	<option value="P" <?php if($rs->fields['fld_jantina']=='P'){ print 'selected'; }?>>Perempuan</option>
                    </select>
                </td>
            </tr>-->
            <tr>
                <td width="20%"><b>e-Mail : </b></td>
                <td width="80%" colspan="3"><input type="text" name="f_email"  size="65" value="<?php print $rs->fields['f_email'];?>" /></td>
            </tr>
            <tr>
                <td colspan="4" class="title" height="30">B.&nbsp;&nbsp;&nbsp;MAKLUMAT KERJA</td>
            </tr>
			<?php //$conn->debug=true;
                $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
				//if(!empty($rs->fields['kursus_id'])){ $sql_p .= " WHERE kursus_id=".$rs->fields['kursus_id']; }
				if($_SESSION["s_level"]<>'99'){ $sqlkks .= " AND kampus_id=".tosql($_SESSION['SESS_KAMPUS']); }
				$rskks = &$conn->Execute($sqlkks);
            ?>
            <tr>
                <td width="20%"><b>Pusat Latihan : </b></td>
                <td width="50%" colspan="2">
                    <select name="kampus_id" style="width:100%">
                        <!--<option value="">-- Sila pilih kampus --</option>-->
                        <?php while(!$rskks->EOF){ ?>
                        <option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($rs->fields['kampus_id']==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                        <?php $rskks->movenext(); } ?>
                    </select>
                </td>
            </tr>
			<?php
                $sql_p = "SELECT * FROM _tbl_kursus_catsub WHERE f_category_code=1 AND is_deleted=0 AND f_status=0 
				ORDER BY f_category_code";
				//if(!empty($rs->fields['kursus_id'])){ $sql_p .= " WHERE kursus_id=".$rs->fields['kursus_id']; }
                $rsgred = &$conn->query($sql_p);
            ?>
            <tr>
                <td width="20%"><b>Pusat / Unit : </b></td>
                <td width="50%" colspan="2">
                    <select name="f_jabatan">
                    	<option value="0">-- Sila pilih Pusat / Unit --</option>
                        <?php while(!$rsgred->EOF) { ?>
                        <option value="<?=$rsgred->fields['id'];?>" <?php if($rs->fields['f_jabatan']==$rsgred->fields['id']){ print 'selected'; }
						?>>&nbsp;<?=$rsgred->fields['SubCategoryDesc'];?></option>
                        <?php $rsgred->MoveNext(); } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="20%"><b>Nama Jawatan : </b></td>
                <td width="50%" colspan="2"><input type="text" name="f_jawatan" size="80" maxlength="128" value="<?php print $rs->fields['f_jawatan'];?>"></td>
            </tr>
            <tr>
                <td width="20%"><b>ID Pengguna : </b></td>
                <td width="50%" colspan="2"><?php print $rs->fields['f_userid'];?></td>
            </tr>
            <tr>
                <td><b>Status : </b></td>
                <td>
                	<select name="f_aktif">
                    	<option value="1" <?php if($rs->fields['f_aktif']=='1'){ print 'selected';} ?>>Aktif</option>
                        <option value="0" <?php if($rs->fields['f_aktif']=='0'){ print 'selected';} ?>>Tidak Aktif</option>
                    </select>
                </td>
                <td><b>Kategori Pengguna : </b></td>
                <td>
                	<select name="f_level">
                    	<option value="99" <?php if($rs->fields['f_level']=='99'){ print 'selected';} ?>>Administrator Sistem Utama</option>
                    	<option value="1" <?php if($rs->fields['f_level']=='1'){ print 'selected';} ?>>Administrator Negeri</option>
                    	<option value="2" <?php if($rs->fields['f_level']=='2'){ print 'selected';} ?>>Pengguna Pengurusan</option>
                    	<option value="3" <?php if($rs->fields['f_level']=='3'){ print 'selected';} ?>>Pengguna Domestik</option>
                    </select>
                </td>
            </tr>
            <!--<tr>
                <td><b>Status : </b></td>
                <td colspan="3">
                	<select name="f_aktif">
                    	<option value="1" <?php if($rs->fields['f_aktif']=='1'){ print 'selected';} ?>>Aktif</option>
                        <option value="0" <?php if($rs->fields['f_aktif']=='0'){ print 'selected';} ?>>Tidak Aktif</option>
                    </select>
                </td>
            </tr>-->
            <tr>
                <td></td>
                <td><br>
                	<input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat kakitangan" 
                    onClick="form_hantar('index.php?data=<?php print base64_encode($userid.';apps/staff/staff_form_do.php;admin;staff;')?>')">
                	<?php if(!empty($id)){ ?>
                    <input type="button" value="Hapus" class="button_disp" title="Sila klik untuk hapus maklumat kakitangan" 
                    onClick="form_hapus('index.php?data=<?php print base64_encode($userid.';apps/staff/staff_form_do.php;admin;staff;')?>')">
                    <?php } ?>
                	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk ke senarai kakitangan" 
                    onClick="do_back('index.php?data=<?php print base64_encode($userid.';apps/staff/staff_list.php;admin;staff;');?>')">
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="proses" value="" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                </td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.f_noic.focus();
</script>
