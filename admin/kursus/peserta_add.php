<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js"></script>
<script LANGUAGE="JavaScript">
function semak(){
	if(document.ilim.f_peserta_noic.value==''){
		alert("Sila masukkan No. Kad Pengenalan peserta terlebih dahulu.");
		document.ilim.f_peserta_noic.focus();
		return true;
	} else {
		var url = document.ilim.url.value;
		document.ilim.action = 'peserta_add.php';
		document.ilim.submit();
	}
}
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
		alert("Sila masukkan Jabatan/Agensi/Unig.");
		document.ilim.BranchCd.focus();
		return true;
	} else {
		document.ilim.action = URL+"&save=SAVE";
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
<?

$href_peserta_add = "modal_form.php?win=".base64_encode('kursus/peserta_add.php;'.$id);
$simpan=$_GET['save'];
if(empty($simpan)){
//$conn->debug=true;
$PageNo = $_POST['PageNo'];
$pro = $_GET['pro'];
if(!empty($_GET['kp'])){ 
	$sSQL="SELECT * FROM _tbl_peserta  WHERE is_deleted=0 AND f_peserta_noic = ".tosql($_GET['kp'],"Text");
}
$rs = $conn->query($sSQL);
if(!$rs->EOF){ 
	$f_peserta_noic = $rs->fields['f_peserta_noic']; 
	$negara = $rs->fields['f_peserta_negara'];
	if(!empty($_GET['kp'])){
		print '<script language="javascript">
			alert("Nama peserta telah ada dalam pangkalan data.");
		</script>';
		//$id = $rs->fields['id_peserta'];
	}
} else {
	if(!empty($_GET['kp'])){ 
	print '<script language="javascript">
		alert("Peserta Baru.");
	</script>';}
	$insid=$_GET['kp']; 
	$negara = 'MY';
}
if($pro=='SEARCH'){ $f_peserta_noic=$_GET['kp']; }
?>

<form name="ilim" id="frm" method="post">
<input type="hidden" value="<?=$href_peserta_add;?>" name="url" />
<input type="hidden" value="<?=$id;?>" name="event_id" />
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
                <?php if(empty($pro)){ ?>onchange="do_search('<?=$href_peserta_add;?>')" <?php } ?>/> cth: 700104102478
                <!--&nbsp;&nbsp;<input type="button" value="Semak" onclick="semak()" style="cursor:pointer" />-->
                </td>
                <td width="15%" rowspan="6" align="center">
                	<?php if(!empty($rs->fields['id_peserta'])){ ?>
                    	<img src="../apps/all_pic/imgpeserta.php?id=<?php echo $rs->fields['id_peserta'];?>" width="100" height="120" border="0">
                        <br>
                        <input type="button" value="Upload Gambar" onclick="upload_gambar('all_pic/upload_img.php?id=<?=$rs->fields['id_peserta'];?>'); return false" 
                        title="Muatnaik gambar peserta" style="cursor:pointer" />
					<?php } ?>
               </td>
            </tr>
            <tr>
                <td align="left"><b>Nama Penuh Peserta <font color="#FF0000">*</font> : </b></td>
                <td colspan="2"><input type="text" size="65" name="f_peserta_nama" value="<?php print $rs->fields['f_peserta_nama'];?>" /></td>
            </tr>
			<?php
            $sqlp = "SELECT * FROM _ref_titlegred WHERE is_deleted=0 AND f_status=0 ORDER BY f_gred_code";
            $rspg = &$conn->query($sqlp);
            ?>
            <tr>
                <td align="left"><b>Gred Jawatan <font color="#FF0000">*</font> : </b></td>
                <td align="left" colspan="2">
				<select name="f_title_grade">
                    <?php while(!$rspg->EOF){ ?>
                    <option value="<?php print $rspg->fields['f_gred_id'];?>" <?php if($rspg->fields['f_gred_id']==$rs->fields['f_title_grade']){ print 'selected'; }?>><?php print $rspg->fields['f_gred_code'] ." - ". $rspg->fields['f_gred_name'];?></option>
                    <?php $rspg->movenext(); } ?>
               </select>   
                </td>
            </tr>
			<?php
            $sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
            $rspu = &$conn->query($sqlp);
            ?>
            <tr>
                <td align="left"><b>Tempat Bertugas <font color="#FF0000">*</font> : </b></td>
              	<td align="left" colspan="2">
                <select name="BranchCd">
                    <option value="">-- Sila pilih --</option>
                    <?php while(!$rspu->EOF){ ?>
                    <option value="<?php print $rspu->fields['f_tbcode'];?>" <?php if($rspu->fields['f_tbcode']==$rs->fields['BranchCd']){ print 'selected'; }?>><?php print $rspu->fields['f_tempat_nama'];?></option>
                    <?php $rspu->movenext(); } ?>
                </select>
                </td>
            </tr>
			<!--<?php
            $sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
            $rspu = &$conn->query($sqlp);
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
                    </select>
                </td>
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
                <td align="center" rowspan="5" valign="top">
					<?php 
						$lepas = date("Y")-1; $semasa = date("Y"); 
						$sSQL2="SELECT B.startdate, B.enddate, A.* 
						FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B 
						WHERE A.EventId=B.id AND year(B.startdate)=".tosql($lepas)." AND A.InternalStudentAccepted=1 
						AND A.is_sijil=1 AND A.peserta_icno=".tosql($rs->fields['f_peserta_noic']);
						$sSQL2 .= " ORDER BY B.startdate DESC";
						$rs2 = &$conn->query($sSQL2);
						$jumlah1=0;
						while(!$rs2->EOF){
							$ddiff = get_datediff($rs2->fields['startdate'],$rs2->fields['enddate']);
							$jumlah1+=$ddiff;
							$rs2->movenext();
						}
						//$jumlah1 = $rs2->recordcount();
						//print $sSQL2;

						$sSQL2="SELECT B.startdate, B.enddate, A.* 
						FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B 
						WHERE A.EventId=B.id AND year(B.startdate)=".tosql($semasa)." AND A.InternalStudentAccepted=1 
						AND A.is_sijil=1 AND A.peserta_icno=".tosql($rs->fields['f_peserta_noic']);
						$sSQL2 .= " ORDER BY B.startdate DESC";
						$rs2 = &$conn->query($sSQL2);
						$jumlah2=0;
						while(!$rs2->EOF){
							$ddiff = get_datediff($rs2->fields['startdate'],$rs2->fields['enddate']);
							$jumlah2+=$ddiff;
							$rs2->movenext();
						}
					?>
                	<b>Maklumat Jumlah Kursus Tahunan</b><br /><br />
					<b>Tahun <?php print $lepas;?> :</b> <?=$jumlah1;?> hari.<br /><br />
					<b>Tahun <?php print $semasa;?> :</b> <?=$jumlah2;?> hari.<br /><br />
                
                </td>
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
                <td colspan="2"><input type="text" name="f_peserta_email" size="50" value="<?php print $rs->fields['f_peserta_email'];?>"></td>
            </tr>
            <tr>
                <td valign="top" align="left"><b>Alamat : </b></td>
                <td colspan="2"><input type="text" name="f_peserta_alamat1" size="50" value="<?php print $rs->fields['f_peserta_alamat1'];?>" /></td>
            </tr>
            <tr>
                <td valign="top" align="left">&nbsp;</td>
                <td colspan="2"><input type="text" name="f_peserta_alamat2" size="50" value="<?php print $rs->fields['f_peserta_alamat2'];?>" /></td>
            </tr>
            <tr>
                <td valign="top">&nbsp;</td>
                <td colspan="2"><input type="text" name="f_peserta_alamat3" size="50" value="<?php print $rs->fields['f_peserta_alamat3'];?>" /></td>
            </tr>
            <tr>
                <td valign="top" align="left"><b>Poskod : </b></td>
                <td colspan="2"><input type="text" name="f_peserta_poskod" size="7" maxlength="5" value="<?php print $rs->fields['f_peserta_poskod'];?>" /></td>
            </tr>
            <tr>
                <td valign="top" align="left"><b>Negeri : </b></td>
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
               </select>   
                </td>
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
                <td colspan="2"><input type="text" name="f_waris_nama" size="50" value="<?php print $rs->fields['f_waris_nama'];?>"></td>
            </tr>
            <tr>
                <td valign="top" align="left"><b>Alamat Waris : </b></td>
                <td colspan="2"><input type="text" name="f_waris_alamat1" size="50" value="<?php print $rs->fields['f_waris_alamat1'];?>" /></td>
            </tr>
            <tr>
                <td valign="top" align="left">&nbsp;</td>
                <td colspan="2"><input type="text" name="f_waris_alamat2" size="50" value="<?php print $rs->fields['f_waris_alamat2'];?>" /></td>
            </tr>
            <tr>
                <td valign="top">&nbsp;</td>
                <td colspan="2"><input type="text" name="f_waris_alamat3" size="50" value="<?php print $rs->fields['f_waris_alamat3'];?>" /></td>
            </tr>
            <tr>
                <td align="left"><b>No. Telefon : </b></td>
                <td align="left" colspan="2"><input type="text" name="f_waris_tel" size="20" maxlength="15" value="<?php print $rs->fields['f_waris_tel'];?>"></td>
            </tr>


            <tr>
                <td colspan="4" align="center"><br>
                	<input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat peserta" 
                    onClick="form_hantar('<?=$href_peserta_add;?>')">
                	<?php if(!empty($rs->fields['id_peserta'])){ ?>
                    <input type="button" value="Hapus" class="button_disp" title="Sila klik untuk hapus maklumat peserta" 
                    onClick="form_hapus('<?=$href_peserta_add;?>')">
                    <?php } ?>
                	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk ke senarai peserta" 
                    onClick="javascript:parent.emailwindow.hide()">
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="proses" value="" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                </td>
            </tr>
			<tr>
                <td colspan="4"><hr /></td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.f_peserta_noic.focus();
</script>
<?php } else {
	//$conn->debug=true;
	include '../loading_pro.php';
	$proses='';
	extract($_POST);
	if(empty($id_peserta)){
		$sqls = "SELECT * FROM _tbl_peserta WHERE is_deleted=0 AND f_peserta_noic=".tosql($f_peserta_noic);
		$rsp = &$conn->query($sqls);
		if($rsp->EOF){
			echo "insert";
			$id_peserta = date("Ymd")."-". uniqid();
			$sql = "INSERT INTO _tbl_peserta(id_peserta, f_peserta_noic, f_peserta_nama, f_title_grade, 
			f_peserta_jantina, BranchCd, f_peserta_tel_pejabat, f_peserta_tel_rumah, f_peserta_hp, 
			f_peserta_faks, f_peserta_email, f_peserta_alamat1, f_peserta_alamat2, f_peserta_alamat3,
			f_peserta_poskod, f_peserta_negeri, create_dt, create_by,
			f_peserta_sah_dt, f_peserta_appoint_dt, f_peserta_lahir, f_peserta_negara,
			f_waris_nama, f_waris_alamat1, f_waris_alamat2, f_waris_alamat3, f_waris_tel,
			nama_ketuajabatan, email_ketuajabatan, jawatan_ketuajabatan)
			VALUES(".tosql($id_peserta,"Text").", ".tosql($f_peserta_noic,"Text").", ".tosql(strtoupper($f_peserta_nama),"Text").", ".tosql($f_title_grade,"Text").", 
			".tosql($f_peserta_jantina,"Text").", ".tosql($BranchCd,"Text").", ".tosql($f_peserta_tel_pejabat,"Text").", ".tosql($f_peserta_tel_rumah,"Text").", ".tosql($f_peserta_hp,"Text").", 
			".tosql($f_peserta_faks,"Text").", ".tosql($f_peserta_email,"Text").", ".tosql($f_peserta_alamat1,"Text").", ".tosql($f_peserta_alamat2,"Text").", ".tosql($f_peserta_alamat3,"Text").", 
			".tosql($f_peserta_poskod,"Text").", ".tosql($f_peserta_negeri,"Text").", ".tosql(date("Y-m-d H:i:s"),"Text").", ".tosql($UserID,"Text")."
			, ".tosql(DBDate($f_peserta_sah_dt),"Text").", ".tosql(DBDate($f_peserta_appoint_dt),"Text").", ".tosql(DBDate($f_peserta_lahir),"Text").", ".tosql($insnationality,"Text")."
			, ".tosql($f_waris_nama,"Text").", ".tosql($f_waris_alamat1,"Text").", ".tosql($f_waris_alamat2,"Text").", ".tosql($f_waris_alamat2,"Text").", ".tosql($f_waris_tel,"Text")."
			, ".tosql($nama_ketuajabatan,"Text").", ".tosql($email_ketuajabatan,"Text").", ".tosql($jawatan_ketuajabatan,"Text").")";
			$result = $conn->Execute($sql);
			if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
			$proses='SAVE';
			audit_trail($sql,"");
			/* if($is_user=='1'){
				$pass = md5("123");
				$sql1 = "UPDATE _tbl_instructor SET flduser_name=".tosql($UserID,"Text").", flduser_password=".tosql($pass,"Text")." 
				WHERE staff_id=".tosql($id,"Text");
				$result = $conn->Execute($sql1);
				if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
			} */
			//exit;
		} else {
			print '<script language="javascript" type="text/javascript">
				alert("Maklumat peserta bernombor kad pengenalan : '.$f_peserta_noic.' telah ada dalam simpanan sistem.");
			</script>';
		}
	} else {
		$sql = "";
		if($proses=='HAPUS'){
			echo "Delete";
			$sql = "UPDATE _tbl_peserta SET 
			is_deleted=1, delete_dt='".date("Y-m-d H:i:s")."', delete_by=".tosql($UserID,"Text").
			" WHERE id_peserta=".tosql($id,"Text");
			$result = $conn->Execute($sql);
			audit_trail($sql,"");
		
			$sql = "DELETE FROM _tbl_peserta_akademik WHERE id_peserta=".tosql($id,"Text");
			$result = $conn->Execute($sql);
			$sql = "DELETE FROM _tbl_peserta_kursusluar WHERE id_peserta=".tosql($id,"Text");
			$result = $conn->Execute($sql);
			//exit;
			if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
			$proses='DELETE';
	
		} else {
			echo "Update";
			$sql = "UPDATE _tbl_peserta SET f_peserta_noic=".tosql($f_peserta_noic,"Text").
			", f_peserta_nama=".tosql($f_peserta_nama,"Text").", f_title_grade=".tosql($f_title_grade,"Text").
			", f_peserta_jantina=".tosql($f_peserta_jantina,"Text").", BranchCd=".tosql($BranchCd,"Text").
			", f_peserta_appoint_dt=".tosql(DBDate($f_peserta_appoint_dt),"Text").", f_peserta_sah_dt=".tosql(DBDate($f_peserta_sah_dt),"Text").
			", f_peserta_tel_pejabat=".tosql($f_peserta_tel_pejabat,"Text").", f_peserta_tel_rumah=".tosql($f_peserta_tel_rumah,"Text").
			", f_peserta_hp=".tosql($f_peserta_hp,"Text").", f_peserta_faks=".tosql($f_peserta_faks,"Text").
			", f_peserta_email=".tosql($f_peserta_email,"Text").", f_peserta_alamat1=".tosql($f_peserta_alamat1,"Text").", f_peserta_alamat2=".tosql($f_peserta_alamat2,"Text").
			", f_peserta_alamat3=".tosql($f_peserta_alamat3,"Text").", f_peserta_poskod=".tosql($f_peserta_poskod,"Text").
			", f_peserta_negeri=".tosql($f_peserta_negeri,"Text").", f_peserta_lahir=".tosql(DBDate($f_peserta_lahir),"Text").
			", f_peserta_negara=".tosql($insnationality,"Text").
			", f_waris_nama=".tosql($f_waris_nama,"Text").", f_waris_alamat1=".tosql($f_waris_alamat1,"Text").
			", f_waris_alamat2=".tosql($f_waris_alamat2,"Text").", f_waris_alamat3=".tosql($f_waris_alamat3,"Text").
			", f_waris_tel=".tosql($f_waris_tel,"Text").
			", nama_ketuajabatan=".tosql($nama_ketuajabatan,"Text").", email_ketuajabatan=".tosql($email_ketuajabatan,"Text").
			", jawatan_ketuajabatan=".tosql($jawatan_ketuajabatan,"Text").
			", update_dt=".tosql(date("Y-m-d H:i:s"),"Text"). ", update_by=".tosql($UserID,"Text"). 
			" WHERE id_peserta=".tosql($id_peserta,"Text");
	
			$result = $conn->Execute($sql);
			//exit;
			if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
			$proses='SAVE';
			audit_trail($sql,"");
		}
	
	}

	if($proses=='SAVE'){
		$m_update_dt 	= date("Y-m-d H:i:s");
		$update_by = $_SESSION["s_fld_user_id"];
		//$List = $_POST['chbCheck'];
		$sqlu = "INSERT INTO _tbl_kursus_jadual_peserta(EventId, id_peserta, peserta_icno, InternalStudentSelectedDt, InternalStudentAccepted, 
			InternalStudentInputDt, InternalStudentInputBy, is_selected) 
		VALUES(".tosql($event_id).", '', ".tosql($f_peserta_noic,"Text").", ".tosql(date("Y-m-d H:i:s")).", 1, 
			".tosql(date("Y-m-d H:i:s")).", ".tosql($_SESSION["s_logid"]).", 1)";
		//print $sqlu."<br>";
		$result = $conn->Execute($sqlu);
		if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
	}
	
	//$conn->debug=false; exit;
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		refresh = parent.location; 
		parent.location = refresh;
		</script>";

}
?>