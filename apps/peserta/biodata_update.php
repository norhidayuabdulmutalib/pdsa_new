<?php
$lnk='';
/*if(empty($f_peserta_noic)){ 
	include_once '../../common.php';
	$f_peserta_noic=isset($_REQUEST["ic"])?$_REQUEST["ic"]:""; 
	$lnk='../../';
}*/
?>
<link rel="stylesheet" href="<?=$lnk;?>modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="<?=$lnk;?>modalwindow/dhtmlwindow.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="<?=$lnk;?>cal/dhtmlgoodies_calendar2.css?random=20051112" media="screen"></link>
<script type="text/javascript" src="<?=$lnk;?>cal/dhtmlgoodies_calendar2.js?random=20060118"></script>
<script type="text/javascript" src="<?=$lnk;?>modalwindow/dhtmlwindow.js">

/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<script type="text/javascript" src="<?=$lnk;?>modalwindow/modal.js"></script>
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
	} else if (document.ilim.f_peserta_lahir.value == ''){
		alert("Sila masukkan tarikh lahir peserta.");
		document.ilim.f_peserta_lahir.focus();
		return true;
	} else if (document.ilim.insnationality.value == ''){
		alert("Sila pilih warganegara.");
		document.ilim.insnationality.focus();
		return true;
	} else if (document.ilim.f_peserta_tel_rumah.value == ''){
		alert("Sila masukkan no. telefon rumah.");
		document.ilim.f_peserta_tel_rumah.focus();
		return true;
	} else if (document.ilim.f_peserta_hp.value == ''){
		alert("Sila masukkan no. telefon bimbit (HP).");
		document.ilim.f_peserta_hp.focus();
		return true;
	} else if (document.ilim.f_peserta_email.value == ''){
		alert("Sila masukkan alamat e-mel.");
		document.ilim.f_peserta_email.focus();
		return true;
	} else if (document.ilim.f_peserta_grp.value == ''){
		alert("Sila masukkan kumpulan jawatan.");
		document.ilim.f_peserta_grp.focus();
		return true;
	} else if (document.ilim.f_title_grade.value == ''){
		alert("Sila masukkan gred jawatan.");
		document.ilim.f_title_grade.focus();
		return true;
	} else if (document.ilim.nama_ketuajabatan.value == ''){
		alert("Sila masukkan nama penyelia");
		document.ilim.nama_ketuajabatan.focus();
		return true;
	} else if (document.ilim.jawatan_ketuajabatan.value == ''){
		alert("Sila masukkan jawatan penyelia");
		document.ilim.jawatan_ketuajabatan.focus();
		return true;
	} else if (document.ilim.email_ketuajabatan.value == ''){
		alert("Sila masukkan alamat e-mel penyelia");
		document.ilim.email_ketuajabatan.focus();
		return true;
	} else if (document.ilim.BranchCd.value == ''){
		alert("Sila masukkan Jabatan/Agensi/Unit.");
		document.ilim.BranchCd.focus();
		return true;
	} else if (document.ilim.f_peserta_alamat1.value == ''){
		alert("Sila masukkan alamat tempat bertugas");
		document.ilim.f_peserta_alamat1.focus();
		return true;
	} else if (document.ilim.f_peserta_poskod.value == ''){
		alert("Sila masukkan poskod tempat bertugas");
		document.ilim.f_peserta_poskod.focus();
		return true;
	} else if (document.ilim.f_peserta_negeri.value == ''){
		alert("Sila pilih maklumat negeri");
		document.ilim.f_peserta_negeri.focus();
		return true;
	} else {
		document.ilim.proses.value='PROSES';
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

function form_hapus(URL){
	var staff = document.ilim.insname.value;
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

	document.ilim.action = URL+"&kp="+insid;
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
<?
//$conn->debug=true;
if(empty($f_peserta_noic)){ 
	include_once '../../common.php';
	$f_peserta_noic=isset($_REQUEST["ic"])?$_REQUEST["ic"]:""; 
}
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
if(!empty($proses) && $proses=='UPDATE'){
extract($_POST);
	include 'katalog/mohon_daftar.php';
	exit;

} else if(!empty($proses) && $proses=='DAFTAR'){
	extract($_POST);
	//$conn->debug=true;

	include 'katalog/mohon_daftar.php';
	exit;
}
//$conn->debug=true;
$sSQL="SELECT * FROM _tbl_peserta  WHERE is_deleted=0 AND f_peserta_noic = ".tosql($f_peserta_noic,"Text");
$rs = &$conn->Execute($sSQL);
if(!$rs->EOF){
	$id = $rs->fields['id_peserta'];
	$pass = $rs->fields['f_pass'];
	$f_peserta_noic = $rs->fields['f_peserta_noic'];
	$f_negara = $rs->fields['f_peserta_negara'];
	if(empty($f_negara)){ $f_negara='MY'; }
	$tkh_lahir = $rs->fields['f_peserta_lahir'];
}
if(empty($tkh_lahir)){
	$tkh_y = substr($f_peserta_noic,0,2);
	$tkh_m = substr($f_peserta_noic,2,2);
	$tkh_d = substr($f_peserta_noic,4,2);

	if($tkh_y>=50){ $tkh_y='19'.$tkh_y; } else { $tkh_y='20'.$tkh_y; }
 	$tkh_lahir = $tkh_y."-".$tkh_m."-".$tkh_d;
}
//print "P:".$proses."/".$tkh_lahir;
?>

<form name="ilim" id="frm" method="post">
<table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
    <tr bgcolor="#00CCFF">
    	<td colspan="2" height="30">&nbsp;<b>MAKLUMAT PESERTA KURSUS.</b></td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="1" cellspacing="0" border="0" align="center">
            <tr>
                <td width="25%"><strong>No. K/P <font color="#FF0000">*</font> : </strong></td>
                <td width="60%" colspan="2">
                <input type="hidden" name="id_peserta"  value="<? print $rs->fields['id_peserta'];?>" />
                <input type="text" name="f_peserta_noic"  value="<? print $f_peserta_noic;?>" readonly="readonly" style="background-color:#CCCCCC" /></td>
                <td width="15%" rowspan="6" align="center">
                	<? if(!empty($id)){ ?>
                    	<img src="all_pic/imgpeserta.php?id=<? echo $rs->fields['id_peserta'];?>" width="100" height="120" border="0">
                        <br>
                        <!--<input type="button" value="Upload Gambar" onclick="upload_gambar('all_pic/upload_img.php?id=<?=$rs->fields['id_peserta'];?>'); return false" />-->
					<? } ?>
               </td>
            </tr>
            <tr>
                <td><strong>Nama Penuh Peserta <font color="#FF0000">*</font> : </strong></td>
                <td colspan="2"><input type="text" size="65" name="f_peserta_nama" value="<? print $rs->fields['f_peserta_nama'];?>"/></td>
            </tr>
            <tr>
                <td><strong>Jantina : </strong></td>
                <td colspan="2">
                	<select name="f_peserta_jantina">
                    	<option value="L" <? if($rs->fields['f_peserta_jantina']=='L'){ print 'selected'; }?>>Lelaki</option>
                    	<option value="P" <? if($rs->fields['f_peserta_jantina']=='P'){ print 'selected'; }?>>Perempuan</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="20%"><strong>Tarikh lahir <font color="#FF0000">*</font> : </strong></td>
                <td width="80%" colspan="3"><input name="f_peserta_lahir" type="text" id="f_peserta_lahir" size="12" value="<?=DisplayDate($tkh_lahir)?>" />&nbsp;
                <img src="<?=$lnk;?>cal/img/screenshot.gif" alt="Sila klik untuk pilih tarikh" width="18" height="19" 
                onclick="displayCalendar(document.ilim.f_peserta_lahir,'dd/mm/yyyy',this)"  onmouseover="this.style.cursor='pointer'" /> ( Cth : 30/04/1977 ) </td>
          </tr>
			<?php $r_country = listLookup('_ref_negara', 'kod_negara, nama_negara', '1', 'nama_negara'); ?>
          <tr>
                <td width="20%"><strong>Warganegara <font color="#FF0000">*</font> : </strong></td>
                <td width="50%" colspan="2">
				<select name="insnationality">
				<?php while(!$r_country->EOF){ ?>
				<option value="<?=$r_country->fields['kod_negara'] ?>" <?php if($r_country->fields['kod_negara']==$f_negara){ echo "selected"; }?> ><?=$r_country->fields['nama_negara']?></option>
                <?php $r_country->movenext(); }?>        
               </select>   
                </td>
            </tr>
            <tr>
                <td width="20%"><strong>No. Telefon Rumah <font color="#FF0000">*</font> : </strong></td>
                <td width="50%" colspan="1"><input type="text" name="f_peserta_tel_rumah" size="20" maxlength="15" value="<? print $rs->fields['f_peserta_tel_rumah'];?>"></td>
            </tr>
            <tr>
                <td width="20%"><strong>No. Telefon Bimbit <font color="#FF0000">*</font> : </strong></td>
                <td width="50%" colspan="1"><input type="text" name="f_peserta_hp" size="20" maxlength="15" value="<? print $rs->fields['f_peserta_hp'];?>"></td>
            </tr>
            <tr>
                <td width="20%"><strong>Emel <font color="#FF0000">*</font> : </strong></td>
                <td width="50%" colspan="1"><input type="text" name="f_peserta_email" size="50" value="<? print $rs->fields['f_peserta_email'];?>"></td>
            </tr>
            <tr><td colspan="4"><hr /></td></tr>
			<?php
            $sqlp = "SELECT * FROM _ref_kumpulan_kerja WHERE f_kk_status=0 ORDER BY f_kk_id";
            $rspg = &$conn->execute($sqlp);
            ?>
            <tr>
                <td><strong>Kumpulan Jawatan <font color="#FF0000">*</font> : </strong></td>
                <td colspan="2">
				<select name="f_peserta_grp">
                	<option value="">-- Sila pilih --</option>
                    <?php while(!$rspg->EOF){ ?>
                    <option value="<?php print $rspg->fields['f_kk_id'];?>" <?php if($rspg->fields['f_kk_id']==$rs->fields['f_peserta_grp']){ print 'selected'; }?>><?php print $rspg->fields['f_kk_desc'];?></option>
                    <? $rspg->movenext(); } ?>
               </select>   
                </td>
                <td align="center" rowspan="7" valign="top">
					<?php include 'view_kursus_calc.php'; ?>
				</td>
            </tr>
			<?php
            $sqlp = "SELECT * FROM _ref_titlegred WHERE is_deleted=0 AND f_status=0 ORDER BY f_gred_code";
            $rspg = &$conn->execute($sqlp);
            ?>
            <tr>
                <td><strong>Gred Jawatan <font color="#FF0000">*</font> : </strong></td>
                <td colspan="2">
				<select name="f_title_grade">
                    <?php while(!$rspg->EOF){ ?>
                    <option value="<?php print $rspg->fields['f_gred_id'];?>" <?php if($rspg->fields['f_gred_id']==$rs->fields['f_title_grade']){ print 'selected'; }?>><?php print $rspg->fields['f_gred_code'] ." - ". $rspg->fields['f_gred_name'];?></option>
                    <? $rspg->movenext(); } ?>
               </select>   
                </td>
            </tr>
            <tr>
                <td align="left"><b>Tarikh Lantikan : </b></td>
                <td align="left" colspan="2"><input name="f_peserta_appoint_dt" type="text" size="12" value="<?=DisplayDate($rs->fields['f_peserta_appoint_dt'])?>" />&nbsp;
                <img src="<?=$lnk;?>cal/img/screenshot.gif" alt="Sila klik untuk pilih tarikh" width="18" height="19" 
                onclick="displayCalendar(document.ilim.f_peserta_appoint_dt,'dd/mm/yyyy',this)"  onmouseover="this.style.cursor='pointer'" /> ( Cth : 30/04/1977 ) </td>
          </tr>
            <tr>
                <td align="left"><b>Tarikh Sah Jawatan : </b></td>
                <td align="left" colspan="2"><input name="f_peserta_sah_dt" type="text" size="12" value="<?=DisplayDate($rs->fields['f_peserta_sah_dt'])?>" />&nbsp;
                <img src="<?=$lnk;?>cal/img/screenshot.gif" alt="Sila klik untuk pilih tarikh" width="18" height="19" 
                onclick="displayCalendar(document.ilim.f_peserta_sah_dt,'dd/mm/yyyy',this)"  onmouseover="this.style.cursor='pointer'" /> ( Cth : 30/04/1977 ) </td>
          </tr>
            <tr>
                <td width="20%"><strong>No. Telefon Pejabat <font color="#FF0000">*</font> : </strong></td>
                <td width="50%" colspan="2"><input type="text" name="f_peserta_tel_pejabat" size="20" maxlength="15" value="<? print $rs->fields['f_peserta_tel_pejabat'];?>"></td>
            </tr>
            <tr>
                <td width="20%"><strong>No. Faks <font color="#FF0000">*</font> : </strong></td>
                <td width="50%" colspan="2"><input type="text" name="f_peserta_faks" size="20" maxlength="15" value="<? print $rs->fields['f_peserta_faks'];?>"></td>
            </tr>
            <tr><td colspan="4"><hr /></td></tr>
			<?php
            $sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
            $rspu = &$conn->execute($sqlp);
            ?>
            <tr>
                <td><strong>Jabatan/Agensi/Unit <font color="#FF0000">*</font> : </strong></td>
              	<td colspan="2">
                <select name="BranchCd">
                    <option value="">-- Sila pilih --</option>
                    <?php while(!$rspu->EOF){ ?>
                    <option value="<?php print $rspu->fields['f_tbcode'];?>" <?php if($rspu->fields['f_tbcode']==$rs->fields['BranchCd']){ print 'selected'; }?>><?php print $rspu->fields['f_tempat_nama'];?></option>
                    <? $rspu->movenext(); } ?>
                </select>
                </td>
            </tr>
            <tr>
                <td valign="top"><strong>Alamat <font color="#FF0000">*</font> : </strong></td>
                <td colspan="2"><input type="text" name="f_peserta_alamat1" size="50" value="<? print $rs->fields['f_peserta_alamat1'];?>" /></td>
            </tr>
            <tr>
                <td valign="top">&nbsp;</td>
                <td colspan="2"><input type="text" name="f_peserta_alamat2" size="50" value="<? print $rs->fields['f_peserta_alamat2'];?>" /></td>
            </tr>
            <tr>
                <td valign="top">&nbsp;</td>
                <td colspan="2"><input type="text" name="f_peserta_alamat3" size="50" value="<? print $rs->fields['f_peserta_alamat3'];?>" /></td>
            </tr>
            <tr>
                <td valign="top"><strong>Poskod <font color="#FF0000">*</font> : </strong>&nbsp;</td>
                <td colspan="2"><input type="text" name="f_peserta_poskod" size="7" maxlength="5" value="<? print $rs->fields['f_peserta_poskod'];?>" /></td>
            </tr>
            <tr>
                <td valign="top"><strong>Negeri <font color="#FF0000">*</font> : </strong>&nbsp;</td>
                <td colspan="2">
				<select name="f_peserta_negeri">
                <?php 
				$r_country = listLookup('ref_negeri', 'kod_negeri, negeri', '1', 'kod_negeri');
				while(!$r_country->EOF){ ?>
				<option value="<?=$r_country->fields['kod_negeri'] ?>" 
					<?php if($rs->fields['f_peserta_negeri']==$r_country->fields['kod_negeri']) echo "selected"; ?>><?=$r_country->fields['negeri']?></option>
                <?php $r_country->movenext(); }?>        
                </select>
                </td>
            </tr>
            <tr><td colspan="4"><hr /></td></tr>
            <tr>
                <td><strong>Nama Penyelia <font color="#FF0000">*</font> : </strong></td>
                <td colspan="2"><input type="text" size="65" name="nama_ketuajabatan" value="<? print $rs->fields['nama_ketuajabatan'];?>"/></td>
            </tr>
            <tr>
                <td><strong>Jawatan <font color="#FF0000">*</font> : </strong></td>
                <td colspan="2"><input type="text" size="65" name="jawatan_ketuajabatan" value="<? print $rs->fields['jawatan_ketuajabatan'];?>"/></td>
            </tr>
            <tr>
                <td><strong>Emel <font color="#FF0000">*</font> : </strong></td>
                <td colspan="2"><input type="text" size="65" name="email_ketuajabatan" value="<? print $rs->fields['email_ketuajabatan'];?>"/></td>
            </tr>
			<!--<?php //if(empty($pass)){ ?>
            <tr><td colspan="4"><hr /></td></tr>
            <tr>
                <td valign="top"><b>Katalaluan <font color="#FF0000">*</font> : </b></td>
                <td colspan="2"><input type="password" name="f_pass" size="20" maxlength="20" value="<? print $rs->fields['f_pass'];?>" />
                &nbsp;<i>Sila masukkan kata laluan anda</i>
                <input type="hidden" name="pass_check" value="0" />
                </td>
            </tr>
			<?php //} ?>-->
            <tr>
                <td colspan="4" align="center"><br>
                	<!--<input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat penceramah" 
                    onClick="form_hantar('apps/peserta/biodata_update.php')">-->
                    <?php if(!empty($pass)){ ?>
                    	<input type="hidden" name="f_pass" value="123" />
						<input type="hidden" name="pass_check" value="1" />
					<?php } ?>
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="proses" value="" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                </td>
            </tr>
			<?php //} ?>
            <?php //} ?>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.f_peserta_noic.focus();
</script>