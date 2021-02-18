<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(document.ilim.f_peserta_noic.value==''){
		alert("Sila masukkan No. Kad Pengenalan peserta terlebih dahulu.");
		document.ilim.f_peserta_noic.focus();
		return true;
	} else if(document.ilim.f_peserta_nama.value==''){
		alert("Sila masukkan Nama Peserta terlebih dahulu.");
		document.ilim.f_peserta_nama.focus();
		return true;
	} else if (document.ilim.f_title_grade.value == ''){
		alert("Sila masukkan Gred Jawatan.");
		document.ilim.f_title_grade.focus();
		return true;
	} else if (document.ilim.BranchCd.value == ''){
		alert("Sila masukkan Jabatan/Agensi/Unit.");
		document.ilim.BranchCd.focus();
		return true;
	} else if (document.ilim.f_peserta_negeri.value == '' || document.ilim.f_peserta_negeri.value == '00'){
		alert("Sila pilih negeri tempat bertugas.");
		document.ilim.f_peserta_negeri.focus();
		return true;
	} else {
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

function form_hapus(URL){
	var staff = document.ilim.f_peserta_nama.value;
	if(confirm("Adakah anda pasti untuk menghapuskan Rekod peserta Ini?\n-"+staff)){
		document.ilim.proses.value = "HAPUS";
		document.ilim.action = URL;
		document.ilim.submit();
	}
}
function do_search(URL){
	var insid = document.ilim.f_peserta_noic.value;
	var kp1=''; var kp2=''; var kp3='';
	insid = cleanIcNum(insid);

	document.ilim.action = URL+"&pro=SEARCH&kp="+insid;
	document.ilim.submit();
}

function cleanIcNum(icValue) {
	//  var icValue = ic.value;
	  var sepArr = new Array("-"," ");
	  for (i = 0; i < sepArr.length; i++) {
		  if (icValue.indexOf(sepArr[i]) != -1) 
			var repStr = eval("/" + sepArr[i] + "/g");
			var myNewIc = icValue.replace(repStr,"");
	   }  
	//  ic.value = myNewIc;
	    return myNewIc;
	  }
  
function isValidDate(input, inputDesc){
	//var validformat=/^\d{2}\/\d{2}\/\d{4}$/ //Basic check for format validity
	 var sepArr = new Array("/","-",".");
     var strDate = input.value;
	 var sepArrOcc = 0;
	 var returnval=true;
   
     if (strDate=="") return true;
	 for (i = 0; i < sepArr.length; i++) {
      if (strDate.indexOf(sepArr[i]) != -1) {
	      sepArrOcc = sepArrOcc + 1;
		  var sep = sepArr[i];
		  }
	  }
	   if (sepArrOcc != 1) {
				alert("Format "+inputDesc+" tidak sah. Sila masuk format tarikh yang sah (dd/mm/yyyy).");
				returnval=false;
			}
		else {
	        strDateArray = strDate.split(sep);
      		if (strDateArray.length != 3) {
				alert("Format "+inputDesc+" tidak sah. Sila masuk format tarikh yang sah (dd/mm/yyyy).");
				returnval=false;
			}
			 else {
				var repStr = eval("/" + sep + "/g");
  				strDate = strDate.replace(repStr,"/");
			}
		}
		
	 if (returnval==true) { //Detailed check for valid date ranges
	 		var dayfield=strDate.split("/")[0]
			var monthfield=strDate.split("/")[1]
			var yearfield=strDate.split("/")[2]
			if (parseInt(dayfield) < 10 && dayfield.length == 1) dayfield = "0" + dayfield ;
			if (parseInt(monthfield) < 10 && monthfield.length == 1) monthfield = "0" + monthfield ;
			if (yearfield.length != 4) {
					if (parseInt(yearfield) > 30) yearfield = "19" + yearfield ;
      				else yearfield = "20" + yearfield;
				}
            input.value = dayfield + "/" + monthfield + "/" + yearfield;
			
			var dayobj = new Date(yearfield, monthfield-1, dayfield)
			if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield)) {
			returnval=false;
			alert(inputDesc+" yang dimasukkan tidak sah. Sila masuk tarikh yang sah (dd/mm/yyyy).");
			}
	 }
	if (returnval==false) {
    input.focus();
    input.select();
    }
  return returnval;
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
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Kemaskini Gambar Peserta', 'width=550px,height=200px,center=1,resize=0,scrolling=1')
} //End "opennewsletter" function
</script>
<?php
//$conn->debug=true;
//$PageNo = $_POST['PageNo'];
//$pro = $_GET['pro'];
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";

if(!empty($_GET['kp'])){ 
	$sSQL="SELECT * FROM _tbl_peserta  WHERE is_deleted=0 AND f_peserta_noic = ".tosql($_GET['kp'],"Text");
} else {
	$sSQL="SELECT * FROM _tbl_peserta  WHERE id_peserta = ".tosql($id,"Text");
}
$rs = &$conn->Execute($sSQL);
if(!$rs->EOF){ 
	$f_peserta_noic = $rs->fields['f_peserta_noic']; 
	$negara = $rs->fields['f_peserta_negara'];
	if(!empty($_GET['kp'])){
		print '<script language="javascript">
			alert("Nama peserta telah ada dalam pangkalan data.");
		</script>';
		$id = $rs->fields['id_peserta'];
	}
} else { 
	$insid=$_GET['kp']; 
	$negara = 'MY';
}
if($pro=='SEARCH'){ $f_peserta_noic=$_GET['kp']; }
?>

<br>
<div class="section-body">
    <div class="row">
        <div class="col-9" style="padding-right:0px;">
            <div class="card">
                <div class="card-header" >
                    <h4>MAKLUMAT PESERTA KURSUS</h4>
                </div>
                <form name="ilim"  id="frm" method="post">
                    <div class="card-body">
                        <?php
                            $sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
                            $rspu = &$conn->execute($sqlp);
                        ?>
                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>No. K/P <font color="#FF0000">*</font> :</b></label>
                            <div class="col-sm-12 col-md-5">
                                <input type="hidden" name="id_peserta"  value="<?php print $rs->fields['id_peserta'];?>" />
                                <input class="form-control" type="text" name="f_peserta_noic"  value="<?php print $f_peserta_noic;?>" maxlength="20"  
                                <?php if(empty($pro)){ ?>onchange="do_search('index.php?data=<?php print base64_encode($userid.';peserta/peserta_form.php;peserta;peserta');?>')" <?php } ?>/>
                            </div>
                            <div class="col-sm-12 col-md-3" style="padding-right:0px;">
                                <font color="#FF0000">cth: 700104102478</font>
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Nama Penuh Peserta <font color="#FF0000">*</font> :</b></label>
                            <div class="col-sm-12 col-md-9">
                                <input class="form-control" type="text" size="65" name="f_peserta_nama" value="<?php print $rs->fields['f_peserta_nama'];?>" />
                            </div>
                        </div>

                        <?php
                            $sqlp = "SELECT * FROM _ref_titlegred WHERE is_deleted=0 AND f_status=0 ORDER BY f_gred_code";
                            $rspg = &$conn->execute($sqlp);
                        ?>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Gred Jawatan <font color="#FF0000">*</font> :</b></label>
                            <div class="col-sm-12 col-md-9">
                                <select name="f_title_grade" class="form-control">
                                    <?php while(!$rspg->EOF){ ?>
                                    <option value="<?php print $rspg->fields['f_gred_id'];?>" <?php if($rspg->fields['f_gred_id']==$rs->fields['f_title_grade']){ print 'selected'; }?>><?php print $rspg->fields['f_gred_code'] ." - ". $rspg->fields['f_gred_name'];?></option>
                                    <?php $rspg->movenext(); } ?>
                                </select> 
                            </div>
                        </div>

                        <?php
                            $sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
                            $rspu = &$conn->execute($sqlp);
                        ?>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Tempat Bertugas <font color="#FF0000">*</font> :</b></label>
                            <div class="col-sm-12 col-md-9">
                                <select name="BranchCd" class="form-control">
                                    <option value="">-- Sila pilih --</option>
                                    <?php while(!$rspu->EOF){ ?>
                                    <option value="<?php print $rspu->fields['f_tbcode'];?>" <?php if($rspu->fields['f_tbcode']==$rs->fields['BranchCd']){ print 'selected'; }?>><?php print $rspu->fields['f_tempat_nama'];?></option>
                                    <?php $rspu->movenext(); } ?>
                                </select> 
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Jantina :</b></label>
                            <div class="col-sm-12 col-md-3">
                                <select name="f_peserta_jantina" class="form-control">
                                    <option value="L" <?php if($rs->fields['f_peserta_jantina']=='L'){ print 'selected'; }?>>Lelaki</option>
                                    <option value="P" <?php if($rs->fields['f_peserta_jantina']=='P'){ print 'selected'; }?>>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Tarikh Lantikan :</b></label>
                            <div class="col-sm-12 col-md-4">
                                <input type="date" class="form-control" name="f_peserta_appoint_dt" value="<?//=DisplayDate($rs->fields['f_peserta_appoint_dt'])?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Tarikh Sah Jawatan :</b></label>
                            <div class="col-sm-12 col-md-4">
                                <input type="date" class="form-control" name="f_peserta_sah_dt" value="<?//=DisplayDate($rs->fields['f_peserta_sah_dt'])?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>No. Telefon Pejabat :</b></label>
                            <div class="col-sm-12 col-md-4">
                                <input class="form-control" type="text" name="f_peserta_tel_pejabat" value="<?php print $rs->fields['f_peserta_tel_pejabat'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>No. Telefon Rumah :</b></label>
                            <div class="col-sm-12 col-md-4">
                                <input class="form-control" type="text" name="f_peserta_tel_rumah" value="<?php print $rs->fields['f_peserta_tel_rumah'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>No. Telefon Bimbit :</b></label>
                            <div class="col-sm-12 col-md-4">
                                <input class="form-control" type="text" name="f_peserta_hp" value="<?php print $rs->fields['f_peserta_hp'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>No. Telefon Faks :</b></label>
                            <div class="col-sm-12 col-md-4">
                                <input class="form-control" type="text" name="f_peserta_faks" value="<?php print $rs->fields['f_peserta_faks'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Emel :</b></label>
                            <div class="col-sm-12 col-md-6">
                                <input class="form-control" type="text" name="f_peserta_email" value="<?php print $rs->fields['f_peserta_email'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Alamat Tempat Bertugas :</b></label>
                            <div class="col-sm-12 col-md-9">
                                <input class="form-control" type="text" name="f_peserta_alamat1" value="<?php print $rs->fields['f_peserta_alamat1'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3" type="hidden"><b></b></label>
                            <div class="col-sm-12 col-md-9">
                                <input class="form-control" type="text" name="f_peserta_alamat2" value="<?php print $rs->fields['f_peserta_alamat2'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3" type="hidden"><b></b></label>
                            <div class="col-sm-12 col-md-9">
                                <input class="form-control" type="text" name="f_peserta_alamat3" value="<?php print $rs->fields['f_peserta_alamat3'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Poskod :</b></label>
                            <div class="col-sm-12 col-md-9">
                                <input class="form-control" type="text" maxlength="5" name="f_peserta_poskod" value="<?php print $rs->fields['f_peserta_poskod'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Negeri Tempat Bertugas <font color="#FF0000">*</font> :</b></label>
                            <div class="col-sm-12 col-md-4">
                                <select name="f_peserta_negeri" class="form-control">
                                    <?php 
                                        $r_country = listLookup('ref_negeri', 'kod_negeri, negeri', '1', 'kod_negeri');
                                        while(!$r_country->EOF){ ?>
                                        <option value="<?=$r_country->fields['kod_negeri'] ?>" 
                                            <?php if($rs->fields['f_peserta_negeri']==$r_country->fields['kod_negeri']) echo "selected"; ?>><?=$r_country->fields['negeri']?></option>
                                    <?php $r_country->movenext(); }?>
                                </select> 
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Tarikh Lahir :</b></label>
                            <div class="col-sm-12 col-md-4">
                                <input  class="form-control" name="f_peserta_lahir" onfocus="(this.type='date')" value="<?php echo date('d-m-Y', strtotime($rs->fields['f_peserta_lahir'])); ?> ">
                            </div>

                            <div class="col-sm-12 col-md-4">
                                ( Cth : 30/04/1977 )
                            </div>
                        </div>

                        

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Warganegara :</b></label>
                            <div class="col-sm-12 col-md-6">
                                <select name="insnationality" class="form-control">
                                    <?php 
                                        $r_country = listLookup('_ref_negara', 'kod_negara, nama_negara', '1', 'nama_negara');
                                        while(!$r_country->EOF){ ?>
                                        <option value="<?=$r_country->fields['kod_negara'] ?>" <?php if($negara == $r_country->fields['kod_negara']) echo "selected"; ?> ><?=$r_country->fields['nama_negara']?></option>
                                        <?php $r_country->movenext(); }
                                    ?>
                                </select> 
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Nama Penyelia :</b></label>
                            <div class="col-sm-12 col-md-9">
                                <input class="form-control" type="text" name="nama_ketuajabatan" value="<?php print $rs->fields['nama_ketuajabatan'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Jawatan :</b></label>
                            <div class="col-sm-12 col-md-9">
                                <input class="form-control" type="text" name="jawatan_ketuajabatan" value="<?php print $rs->fields['jawatan_ketuajabatan'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Emel :</b></label>
                            <div class="col-sm-12 col-md-6">
                                <input class="form-control" type="text" name="email_ketuajabatan" value="<?php print $rs->fields['email_ketuajabatan'];?>">
                            </div>
                        </div>
                        
                        <hr>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Nama Waris :</b></label>
                            <div class="col-sm-12 col-md-9">
                                <input class="form-control" type="text" name="f_waris_nama" value="<?php print $rs->fields['f_waris_nama'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Alamat Waris :</b></label>
                            <div class="col-sm-12 col-md-9">
                                <input class="form-control" type="text" name="f_waris_alamat1" value="<?php print $rs->fields['f_waris_alamat1'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3" type="hidden"><b></b></label>
                            <div class="col-sm-12 col-md-9">
                                <input class="form-control" type="text" name="f_waris_alamat2" value="<?php print $rs->fields['f_waris_alamat2'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3" type="hidden"><b></b></label>
                            <div class="col-sm-12 col-md-9">
                                <input class="form-control" type="text" name="f_waris_alamat3" value="<?php print $rs->fields['f_waris_alamat3'];?>">
                            </div>
                        </div>

                        <div class="form-group row" style="padding-right:0px;">
                            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>No. Telefon</b></label>
                            <div class="col-sm-12 col-md-4">
                                <input class="form-control" type="text" name="f_waris_tel" value="<?php print $rs->fields['f_waris_tel'];?>">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-success" title="Sila klik untuk menyimpan maklumat peserta" onClick="form_hantar('index.php?data=<?php print base64_encode($userid.';peserta/peserta_form_do.php;peserta;peserta')?>')"><i class="fas fa-save"></i> Simpan</button>

                        <?php if(!empty($id)){ ?>
                            <button class="btn btn-danger" title="Sila klik untuk hapus maklumat peserta" onClick="form_hapus('index.php?data=<?php print base64_encode($userid.';peserta/peserta_form_do.php;peserta;peserta')?>')"><i class="fas fa-trash"></i> Hapus</button>
                        <?php } ?>

                        <button class="btn btn-secondary" title="Sila klik untuk ke senarai peserta" onClick="do_back('index.php?data=<?php print ($userid.';peserta/peserta_list.php;peserta;peserta;peserta;Senarai Peserta;');?>')"><i class="fas fa-undo"></i> Kembali</button>

                        <input type="hidden" name="id" value="<?=$id?>" />
                        <input type="hidden" name="proses" value="" />
                        <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                    </div>
                </form>

            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <form name="ilim"  id="frm" method="post">
                    <div class="card-body">
                        <?php
                            $sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
                            $rspu = &$conn->execute($sqlp);
                        ?>
                        <div class="form-group row" style="padding-right:0px;">
                            <div class="col-sm-12 col-md-12" align="center">
                                <?php if(!empty($rs->fields['id_peserta'])){ ?>
                                    <img src="../all_pic/imgpeserta.php?id=<?php echo $rs->fields['id_peserta'];?>" width="100" height="120" border="0">
                                    <br><br>
                                    <button class="form-control btn btn-success" onclick="upload_gambar('all_pic/upload_img.php?id=<?=$rs->fields['id_peserta'];?>'); return false" 
                                    title="Muatnaik gambar peserta" style="cursor:pointer;width:150px;">
                                        Muatnaik Gambar
                                    </button>
                                <?php } ?>
                                
                                <br>
                                
                                <td align="left" colspan="2"><?//=DisplayDate($rs->fields['f_peserta_sah_dt'])?>&nbsp;</td>
                                <td align="center" rowspan="5" valign="top">
                                    <?php include 'view_kursus_calc.php'; ?>
                                </td>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12" style="padding-right:0px;">
            <div class="card">
                <div class="card-header" >
                    <h4>MAKLUMAT KELAYAKAN AKADEMIK</h4>
                </div>
                
                <div class="card-body">
                    <div>
                        <div><?php include 'peserta_akademik.php'; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12" style="padding-right:0px;">
            <div class="card">
                <div class="card-header" >
                    <h4>MAKLUMAT KURSUS YANG TELAH DIAMBIL</h4>
                </div>
                <div class="card-body">
                    <?php if(!empty($id)){ ?>
                        <div>
                            <div><br /><?php include 'peserta_kursus_dalaman.php'; ?></div>
                        </div>
                        <?php if($rs->fields['BranchCd']=='0016'){ ?>
                            <div>
                                <div><br /><?php include 'peserta_kursus_luaran.php'; ?></div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script LANGUAGE="JavaScript">
	document.ilim.f_peserta_noic.focus();
</script>