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

<br>
<div class="section-body">
    <div class="row">
        <div class="col-12" style="padding-right:0px;">
            <div class="card">
                <div class="card-header" >
                    <h4>MAKLUMAT KAKITANGAN / PENGGUNA SISTEM</h4>
                </div>
                <form name="ilim" method="post">
                <div class="card-body">

                    <tr>
                        <td colspan="4" class="title" height="30">A.&nbsp;&nbsp;&nbsp;MAKLUMAT AM</td>
                    </tr>

                    <div class="form-group row" style="padding-right:0px;">
                        <label class="col-form-label col-12 col-md-3 col-lg-3"><b>No. K/P <font color="#FF0000">*</font> :</b></label>
                        <div class="col-sm-12 col-md-5">
                            <input  class="form-control" type="text" name="f_noic"  value="<?php print $kp;?>"  
                            <?php if(empty($id)){ ?>onchange="do_search('index.php?data=dXNlcjtzdGFmZi9zdGFmZl9mb3JtLnBocDthZG1pbjtzdGFmZjs=')" <?php } ?>/>
                        </div>
                        <div class="col-sm-12 col-md-3" style="padding-right:0px;">
                            <font color="#FF0000">cth: 700104102478</font>
                        </div>
                    </div>
                    
                    <!--<td width="20%" rowspan="6" align="center">
                    <?php //if(!empty($id)){ ?>
                    <img src="staff/staffimgdownload.php?id=<?php// echo $id;?>" width="100" height="120" border="0">
                        <br>
                        <input type="button" value="Upload Gambar" onclick="upload_gambar('staff/staff_pic/upload_img.php?id=<?=$id;?>'); return false" />
                    <?php //} ?>
                    </td>-->

                    <div class="form-group row" style="padding-right:0px;">
                        <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Nama Penuh :</b></label>
                        <div class="col-sm-12 col-md-5">
                            <input class="form-control" type="text" size="65" name="f_name" value="<?php print $rs->fields['f_name'];?>" />
                        </div>
                    </div>

                    <div class="form-group row" style="padding-right:0px;">
                        <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Alamat Surat-menyurat :</b></label>
                        <div class="col-sm-12 col-md-5">
                            <input type="text" class="form-control" size="65" name="f_alamat1" value="<?php print $rs->fields['f_alamat1'];?>" />
                        </div>
                    </div>

                    <div class="form-group row" style="padding-right:0px;">
                        <label class="col-form-label col-12 col-md-3 col-lg-3"><b> </b></label>
                        <div class="col-sm-12 col-md-5">
                            <input type="text" class="form-control" size="65" name="f_alamat2" value="<?php print $rs->fields['f_alamat2'];?>" />
                        </div>
                    </div>

                    <div class="form-group row" style="padding-right:0px;">
                        <label class="col-form-label col-12 col-md-3 col-lg-3"><b> </b></label>
                        <div class="col-sm-12 col-md-5">
                            <input type="text" class="form-control" size="65" name="f_alamat3" value="<?php print $rs->fields['f_alamat3'];?>" />
                        </div>
                    </div>
                
                    <div class="form-group row" style="padding-right:0px;">
                        <label class="col-form-label col-12 col-md-3 col-lg-3"><b>No. Telefon :</b></label>
                        <div class="col-sm-12 col-md-5">
                            <input type="text" class="form-control" name="f_notel" size="20" maxlength="15" value="<?php print $rs->fields['f_notel'];?>">
                        </div>
                    </div>

                    <!--<tr>
                        <td width="20%"><b>Jantina : </b></td>
                        <td width="50%" colspan="2">
                            <select name="jantina">
                                <option value="L" <?php// if($rs->fields['fld_jantina']=='L'){ print 'selected'; }?>>Lelaki</option>
                                <option value="P" <?php// if($rs->fields['fld_jantina']=='P'){ print 'selected'; }?>>Perempuan</option>
                            </select>
                        </td>
                    </tr>-->

                    <div class="form-group row" style="padding-right:0px;">
                        <label class="col-form-label col-12 col-md-3 col-lg-3"><b>E-Mail :</b></label>
                        <div class="col-sm-12 col-md-5">
                            <input type="text" class="form-control" name="f_email"  size="65" value="<?php print $rs->fields['f_email'];?>" />
                        </div>
                    </div>
                
                <div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <tr>
                    <td colspan="4" class="title" height="30">B.&nbsp;&nbsp;&nbsp;MAKLUMAT KERJA</td>
                </tr>
                </br>
                <?php //$conn->debug=true;
                    $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
                    //if(!empty($rs->fields['kursus_id'])){ $sql_p .= " WHERE kursus_id=".$rs->fields['kursus_id']; }
                    if($_SESSION["s_level"]<>'99'){ $sqlkks .= " AND kampus_id=".tosql($_SESSION['SESS_KAMPUS']); }
                    $rskks = &$conn->Execute($sqlkks);
                ?>

                <div class="form-group row" style="padding-right:0px;">
                    <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Pusat Latihan :</b></label>
                    <div class="col-sm-12 col-md-5">
                        <select class="form-control" name="kampus_id" style="width:100%">
                            <!--<option value="">-- Sila pilih kampus --</option>-->
                            <?php while(!$rskks->EOF){ ?>
                            <option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($rs->fields['kampus_id']==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                            <?php $rskks->movenext(); } ?>
                        </select>
                    </div>
                </div>

                <?php
                    $sql_p = "SELECT * FROM _tbl_kursus_catsub WHERE f_category_code=1 AND is_deleted=0 AND f_status=0 
                    ORDER BY f_category_code";
                    //if(!empty($rs->fields['kursus_id'])){ $sql_p .= " WHERE kursus_id=".$rs->fields['kursus_id']; }
                    $rsgred = &$conn->query($sql_p);
                ?>
                <div class="form-group row" style="padding-right:0px;">
                    <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Pusat / Unit :</b></label>
                    <div class="col-sm-12 col-md-5">
                        <select class="form-control" name="f_jabatan">
                            <option value="0">-- Sila pilih Pusat / Unit --</option>
                            <?php while(!$rsgred->EOF) { ?>
                            <option value="<?=$rsgred->fields['id'];?>" <?php if($rs->fields['f_jabatan']==$rsgred->fields['id']){ print 'selected'; }
                            ?>>&nbsp;<?=$rsgred->fields['SubCategoryDesc'];?></option>
                            <?php $rsgred->MoveNext(); } ?>
                        </select>
                    </div>
                </div>
        
                <div class="form-group row" style="padding-right:0px;">
                    <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Nama Jawatan :</b></label>
                    <div class="col-sm-12 col-md-5">
                        <input type="text" class="form-control" name="f_jawatan" size="80" maxlength="128" value="<?php print $rs->fields['f_jawatan'];?>">
                    </div>
                </div>
        
                <div class="form-group row" style="padding-right:0px;">
                    <label class="col-form-label col-12 col-md-3 col-lg-3"><b>ID Pengguna :</b></label>
                    <div class="col-sm-12 col-md-5">
                        <?php print $rs->fields['f_userid'];?>
                    </div>
                </div>

                <div class="form-group row" style="padding-right:0px;">
                    <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Status :</b></label>
                    <div class="col-sm-12 col-md-5">
                        <select class="form-control" name="f_aktif">
                            <option value="1" <?php if($rs->fields['f_aktif']=='1'){ print 'selected';} ?>>Aktif</option>
                            <option value="0" <?php if($rs->fields['f_aktif']=='0'){ print 'selected';} ?>>Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row" style="padding-right:0px;">
                    <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Kategori Pengguna :</b></label>
                    <div class="col-sm-12 col-md-5">
                        <select class="form-control" name="f_level">
                            <option value="99" <?php if($rs->fields['f_level']=='99'){ print 'selected';} ?>>Administrator Sistem Utama</option>
                            <option value="1" <?php if($rs->fields['f_level']=='1'){ print 'selected';} ?>>Administrator Pusat Latihan</option>
                            <option value="2" <?php if($rs->fields['f_level']=='2'){ print 'selected';} ?>>Pengguna Pengurusan</option>
                            <option value="3" <?php if($rs->fields['f_level']=='3'){ print 'selected';} ?>>Pengguna Domestik</option>
                        </select>
                    </div>
                </div>

                <!--<tr>
                    <td><b>Status : </b></td>
                    <td colspan="3">
                        <select name="f_aktif">
                            <option value="1" <?php// if($rs->fields['f_aktif']=='1'){ print 'selected';} ?>>Aktif</option>
                            <option value="0" <?php// if($rs->fields['f_aktif']=='0'){ print 'selected';} ?>>Tidak Aktif</option>
                        </select>
                    </td>
                </tr>-->

                <div class="card-footer text-right">
                    <input type="button" class="btn btn-success" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat kakitangan" 
                    onClick="form_hantar('index.php?data=<?php print base64_encode($userid.';staff/staff_form_do.php;admin;staff;')?>')">
                    <?php if(!empty($id)){ ?>
                    <input type="button" class="btn btn-danger" value="Hapus" class="button_disp" title="Sila klik untuk hapus maklumat kakitangan" 
                    onClick="form_hapus('index.php?data=<?php print base64_encode($userid.';staff/staff_form_do.php;admin;staff;')?>')">
                    <?php } ?>
                    <input type="button" class="btn btn-secondary" value="Kembali" class="button_disp" title="Sila klik untuk ke senarai kakitangan" 
                    onClick="do_back('index.php?data=<?php print base64_encode($userid.';staff/staff_list.php;admin;staff;');?>')">
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="proses" value="" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                </div>

            </div>
        </div>
    </div>
</div>

<script LANGUAGE="JavaScript">
	document.ilim.f_noic.focus();
</script>
