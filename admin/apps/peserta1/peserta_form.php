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

<form name="ilim" id="frm" method="post">
<table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
    <tr bgcolor="#00CCFF">
    	<td colspan="2" height="30">&nbsp;<b>MAKLUMAT PESERTA KURSUS</b></td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
            <tr>
                <td width="25%" align="left"><b>No. K/P <font color="#FF0000">*</font> : </b></td>
                <td width="60%" colspan="2" align="left">
                <input type="hidden" name="id_peserta"  value="<?php print $rs->fields['id_peserta'];?>" />
                <input type="text" name="f_peserta_noic"  value="<?php print $f_peserta_noic;?>" maxlength="20"  
                <?php if(empty($pro)){ ?>onchange="do_search('index.php?data=<?php print base64_encode($userid.';apps/peserta/peserta_form.php;peserta;peserta');?>')" <?php } ?>/> cth: 700104102478</td>
                <td width="15%" rowspan="6" align="center">
                	<?php if(!empty($rs->fields['id_peserta'])){ ?>
                    	<img src="../apps/all_pic/imgpeserta.php?id=<?php echo $rs->fields['id_peserta'];?>" width="100" height="120" border="0">
                        <br>
                        <input type="button" value="Upload Gambar" onclick="upload_gambar('all_pic/upload_img.php?id=<?=$rs->fields['id_peserta'];?>'); return false" 
                        title="Muatnaik gambar peserta" style="cursor:pointer" />
					<?php } ?>               </td>
            </tr>
            <tr>
                <td align="left"><b>Nama Penuh Peserta <font color="#FF0000">*</font> : </b></td>
                <td colspan="2"><input type="text" size="65" name="f_peserta_nama" value="<?php print $rs->fields['f_peserta_nama'];?>" /></td>
            </tr>
			<?php
            $sqlp = "SELECT * FROM _ref_titlegred WHERE is_deleted=0 AND f_status=0 ORDER BY f_gred_code";
            $rspg = &$conn->execute($sqlp);
            ?>
            <tr>
                <td align="left"><b>Gred Jawatan <font color="#FF0000">*</font> : </b></td>
                <td align="left" colspan="2">
				<select name="f_title_grade">
                    <?php while(!$rspg->EOF){ ?>
                    <option value="<?php print $rspg->fields['f_gred_id'];?>" <?php if($rspg->fields['f_gred_id']==$rs->fields['f_title_grade']){ print 'selected'; }?>><?php print $rspg->fields['f_gred_code'] ." - ". $rspg->fields['f_gred_name'];?></option>
                    <?php $rspg->movenext(); } ?>
               </select>                </td>
            </tr>
			<?php
            $sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
            $rspu = &$conn->execute($sqlp);
            ?>
            <tr>
                <td align="left"><b>Tempat Bertugas <font color="#FF0000">*</font> : </b></td>
              	<td align="left" colspan="2">
                <select name="BranchCd">
                    <option value="">-- Sila pilih --</option>
                    <?php while(!$rspu->EOF){ ?>
                    <option value="<?php print $rspu->fields['f_tbcode'];?>" <?php if($rspu->fields['f_tbcode']==$rs->fields['BranchCd']){ print 'selected'; }?>><?php print $rspu->fields['f_tempat_nama'];?></option>
                    <?php $rspu->movenext(); } ?>
                </select>                </td>
            </tr>
			<!--<?php
            $sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
            $rspu = &$conn->execute($sqlp);
            ?>
            <tr>
                <td align="left"><b>Jabatan/Agensi/Kementerian <font color="#FF0000">*</font> : </b></td>
              	<td align="left" colspan="2">
                <select name="BranchCd">
                    <option value="">-- Sila pilih --</option>
                    <?php while(!$rspu->EOF){ ?>
                    <option value="<?php print $rspu->fields['f_tbcode'];?>" <?php if($rspu->fields['f_tbcode']==$rs->fields['BranchCd']){ print 'selected'; }?>><?php print $rspu->fields['f_tempat_nama'];?></option>
                    <?php $rspu->movenext(); } ?>
                </select>
                </td>
            </tr>-->
            <tr>
                <td align="left"><b>Jantina : </b></td>
                <td align="left" colspan="2">
                	<select name="f_peserta_jantina">
                    	<option value="L" <?php if($rs->fields['f_peserta_jantina']=='L'){ print 'selected'; }?>>Lelaki</option>
                    	<option value="P" <?php if($rs->fields['f_peserta_jantina']=='P'){ print 'selected'; }?>>Perempuan</option>
                    </select>                </td>
            </tr>
            <tr>
                <td align="left"><b>Tarikh Lantikan : </b></td>
                <td align="left" colspan="3"><input name="f_peserta_appoint_dt" type="text" size="12" value="<?=DisplayDate($rs->fields['f_peserta_appoint_dt'])?>" />&nbsp;
                <img src="../cal/img/screenshot.gif" alt="Sila klik untuk pilih tarikh" width="18" height="19" 
                onclick="displayCalendar(document.ilim.f_peserta_appoint_dt,'dd/mm/yyyy',this)"  onmouseover="this.style.cursor='pointer'" /> ( Cth : 30/04/1977 ) </td>
          </tr>
            <tr>
                <td align="left"><b>Tarikh Sah Jawatan : </b></td>
                <td align="left" colspan="2"><input name="f_peserta_sah_dt" type="text" size="12" value="<?=DisplayDate($rs->fields['f_peserta_sah_dt'])?>" />&nbsp;
                <img src="../cal/img/screenshot.gif" alt="Sila klik untuk pilih tarikh" width="18" height="19" 
                onclick="displayCalendar(document.ilim.f_peserta_sah_dt,'dd/mm/yyyy',this)"  onmouseover="this.style.cursor='pointer'" /> ( Cth : 30/04/1977 ) </td>
                <td align="center" rowspan="5" valign="top"><?php include 'view_kursus_calc.php'; ?>
          </tr>
            <tr>
                <td align="left"><b>No. Telefon Pejabat : </b></td>
                <td align="left" colspan="2"><input type="text" name="f_peserta_tel_pejabat" size="20" maxlength="15" value="<?php print $rs->fields['f_peserta_tel_pejabat'];?>"></td>
            </tr>
            <tr>
                <td align="left"><b>No. Telefon Rumah : </b></td>
                <td align="left" colspan="2"><input type="text" name="f_peserta_tel_rumah" size="20" maxlength="15" value="<?php print $rs->fields['f_peserta_tel_rumah'];?>"></td>
            </tr>
            <tr>
                <td align="left"><b>No. Telefon Bimbit : </b></td>
                <td align="left" colspan="2"><input type="text" name="f_peserta_hp" size="20" maxlength="15" value="<?php print $rs->fields['f_peserta_hp'];?>"></td>
            </tr>
            <tr>
                <td align="left"><b>No. Faks : </b></td>
                <td colspan="2" align="left"><input type="text" name="f_peserta_faks" size="20" maxlength="15" value="<?php print $rs->fields['f_peserta_faks'];?>"></td>
            </tr>
            <tr>
                <td align="left"><b>Email : </b></td>
                <td colspan="2"><input type="text" name="f_peserta_email" size="80" value="<?php print $rs->fields['f_peserta_email'];?>" /></td>
          </tr>
            <tr>
                <td valign="top" align="left"><b>Alamat Tempat Bertugas : </b></td>
                <td colspan="2"><input type="text" name="f_peserta_alamat1" size="80" value="<?php print $rs->fields['f_peserta_alamat1'];?>" /></td>
            </tr>
            <tr>
                <td valign="top" align="left">&nbsp;</td>
                <td colspan="2"><input type="text" name="f_peserta_alamat2" size="80" value="<?php print $rs->fields['f_peserta_alamat2'];?>" /></td>
            </tr>
            <tr>
                <td valign="top">&nbsp;</td>
                <td colspan="2"><input type="text" name="f_peserta_alamat3" size="80" value="<?php print $rs->fields['f_peserta_alamat3'];?>" /></td>
            </tr>
            <tr>
                <td valign="top" align="left"><b>Poskod : </b></td>
                <td colspan="2"><input type="text" name="f_peserta_poskod" size="7" maxlength="5" value="<?php print $rs->fields['f_peserta_poskod'];?>" /></td>
            </tr>
            <tr>
                <td valign="top" align="left"><b>Negeri Tempat Bertugas <font color="#FF0000">*</font> : </b></td>
                <td colspan="2">
				<select name="f_peserta_negeri">
                <?php 
				$r_country = listLookup('ref_negeri', 'kod_negeri, negeri', '1', 'kod_negeri');
				while(!$r_country->EOF){ ?>
				<option value="<?=$r_country->fields['kod_negeri'] ?>" 
					<?php if($rs->fields['f_peserta_negeri']==$r_country->fields['kod_negeri']) echo "selected"; ?>><?=$r_country->fields['negeri']?></option>
                <?php $r_country->movenext(); }?>        
               </select>				</td>
            </tr>
            <tr>
                <td align="left"><b>Tarikh Lahir : </b></td>
                <td align="left" colspan="3"><input name="f_peserta_lahir" type="text" size="12" value="<?=DisplayDate($rs->fields['f_peserta_lahir'])?>" />&nbsp;
                <img src="../cal/img/screenshot.gif" alt="Sila klik untuk pilih tarikh" width="18" height="19" 
                onclick="displayCalendar(document.ilim.f_peserta_lahir,'dd/mm/yyyy',this)"  onmouseover="this.style.cursor='pointer'" /> ( Cth : 30/04/1977 ) </td>
          </tr>
          <tr>
                <td align="left"><b>Warganegara : </b></td>
                <td align="left" colspan="2">
				<select name="insnationality">
                <?php 
				$r_country = listLookup('_ref_negara', 'kod_negara, nama_negara', '1', 'nama_negara');
				while(!$r_country->EOF){ ?>
				<option value="<?=$r_country->fields['kod_negara'] ?>" <?php if($negara == $r_country->fields['kod_negara']) echo "selected"; ?> ><?=$r_country->fields['nama_negara']?></option>
                <?php $r_country->movenext(); }?>        
               </select>                </td>
            </tr>

            <tr>			
                <td colspan="4"><hr /></td>
            </tr>
            <tr>
                <td><strong>Nama Penyelia : </strong></td>
                <td colspan="2"><input type="text" size="65" name="nama_ketuajabatan" value="<?php print $rs->fields['nama_ketuajabatan'];?>"/></td>
            </tr>
            <tr>
                <td><strong>Jawatan : </strong></td>
                <td colspan="2"><input type="text" size="65" name="jawatan_ketuajabatan" value="<?php print $rs->fields['jawatan_ketuajabatan'];?>"/></td>
            </tr>
            <tr>
                <td><strong>Emel : </strong></td>
                <td colspan="2"><input type="text" size="65" name="email_ketuajabatan" value="<?php print $rs->fields['email_ketuajabatan'];?>"/></td>
            </tr>

            <tr>			
                <td colspan="4"><hr /></td>
            </tr>
			<tr>
                <td align="left"><b>Nama Waris : </b></td>
                <td colspan="2"><input type="text" name="f_waris_nama" size="80" value="<?php print $rs->fields['f_waris_nama'];?>"></td>
            </tr>
            <tr>
                <td valign="top" align="left"><b>Alamat Waris : </b></td>
                <td colspan="2"><input type="text" name="f_waris_alamat1" size="80" value="<?php print $rs->fields['f_waris_alamat1'];?>" /></td>
            </tr>
            <tr>
                <td valign="top" align="left">&nbsp;</td>
                <td colspan="2"><input type="text" name="f_waris_alamat2" size="80" value="<?php print $rs->fields['f_waris_alamat2'];?>" /></td>
            </tr>
            <tr>
                <td valign="top">&nbsp;</td>
                <td colspan="2"><input type="text" name="f_waris_alamat3" size="80" value="<?php print $rs->fields['f_waris_alamat3'];?>" /></td>
            </tr>
            <tr>
                <td align="left"><b>No. Telefon : </b></td>
                <td align="left" colspan="2"><input type="text" name="f_waris_tel" size="20" maxlength="15" value="<?php print $rs->fields['f_waris_tel'];?>"></td>
            </tr>


            <tr>
                <td colspan="4" align="center"><br>
                	<input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat peserta" 
                    onClick="form_hantar('index.php?data=<?php print base64_encode($userid.';apps/peserta/peserta_form_do.php;peserta;peserta')?>')">
                	<?php if(!empty($id)){ ?>	
                    <input type="button" value="Hapus" class="button_disp" title="Sila klik untuk hapus maklumat peserta" 
                    onClick="form_hapus('index.php?data=<?php print base64_encode($userid.';apps/peserta/peserta_form_do.php;peserta;peserta')?>')">
                    <?php } ?>
                	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk ke senarai peserta" 
                    onClick="do_back('index.php?data=<?php print base64_encode($userid.';apps/peserta/peserta_list.php;peserta;peserta');?>')">
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="proses" value="" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />                </td>
            </tr>
			<tr>
                <td colspan="4"><hr /></td>
            </tr>
            <tr>
                <td colspan="4"><?php include 'peserta_akademik.php'; ?></td>
            </tr>
            <?php if(!empty($id)){ ?>
            <tr>
                <td colspan="4"><br /><?php include 'peserta_kursus_dalaman.php'; ?></td>
            </tr>
            <?php if($rs->fields['BranchCd']=='0016'){ ?>
            <tr>
                <td colspan="4"><br /><?php include 'peserta_kursus_luaran.php'; ?></td>
            </tr>
            <?php } ?>
            <?php } ?>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.f_peserta_noic.focus();
</script>