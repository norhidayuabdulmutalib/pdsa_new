<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(document.ilim.insname.value==''){
		alert("Sila masukkan nama penceramah terlebih dahulu.");
		document.ilim.insname.focus();
		return true;
	} else if(document.ilim.insid.value==''){
		alert("Sila masukkan No. Kad Pengenalan.");
		document.ilim.insid.focus();
		return true;
	} else if(document.ilim.insorganization.value==''){
		alert("Sila masukkan maklumat jabatan.");
		document.ilim.insorganization.focus();
		return true;
	} else if(document.ilim.inskategori.value==''){
		alert("Sila pilih kategori penceramah.");
		document.ilim.inskategori.focus();
		return true;
	} else if (document.ilim.payperhours.value != '' && isNaN(document.ilim.payperhours.value)){
		alert("Sila masukkan angka sahaja pada kadar bayaran sejam.");
		document.ilim.payperhours.focus();
		return true;
	} else {
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

function form_hapus(URL){
	var staff = document.ilim.insname.value;
	if(confirm("Adakah anda pasti untuk menghapuskan Rekod Penceramah Ini?\n-"+staff)){
		document.ilim.proses.value = "HAPUS";
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

function do_search(URL){
	var insid = document.ilim.insid.value;
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
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Kemaskini Gambar Penceramah', 'width=550px,height=200px,center=1,resize=0,scrolling=1')
} //End "opennewsletter" function
</script>
<?php
//$conn->debug=true;
function dlookupList($Table, $fName, $sWhere, $sOrder){
	global $conn; 
	$sSQL = "SELECT " . $fName . " FROM " . $Table . " " . $sWhere . " ORDER BY ". $sOrder;
	$result = mysql_query($sSQL);
	if(mysql_errno()!= 0){ print 'Error : '.mysql_error(); exit();}
	$intRecCount = mysql_num_rows($result);
	if($intRecCount > 0){  
		return $result;
	} else {
		return "";
	}
}

$PageNo = $_POST['PageNo'];
if(!empty($_GET['kp'])){ 
	$sSQL="SELECT * FROM _tbl_instructor  WHERE is_deleted=0 AND insid = ".tosql($_GET['kp'],"Text");
} else if(!empty($_SESSION["s_logid"]) && $_SESSION["s_usertype"]=='PENSYARAH'){ 
	$sSQL="SELECT * FROM _tbl_instructor  WHERE is_deleted=0 AND insid = ".tosql($_SESSION["s_logid"],"Text");
} else {
	$sSQL="SELECT * FROM _tbl_instructor  WHERE ingenid = ".tosql($id,"Text");
}
$rs = &$conn->Execute($sSQL);
if(!$rs->EOF){ 
	$insid = $rs->fields['insid']; 
	$negara = $rs->fields['insnationality'];
	if(!empty($_GET['kp'])){
		print '<script language="javascript">
			alert("Nama penceramah telah ada dalam pangkalan data.");
		</script>';
		$id = $rs->fields['ingenid'];
	}
} else { 
	$insid=$_GET['kp']; 
	$negara = 'MY';
}
?>


<form name="ilim" id="frm" method="post">
<table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
    <tr bgcolor="#00CCFF">
    	<td colspan="2" height="30">&nbsp;<b>MAKLUMAT PENCERAMAH</b></td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
            <tr>
                <td colspan="4" class="title" height="30">A.&nbsp;&nbsp;&nbsp;MAKLUMAT AM</td>
            </tr>
            <tr>
                <td width="30%"><b>No. K/P <font color="#FF0000">*</font> : </b></td>
                <td width="50%" colspan="2"><input type="text" name="insid"  value="<?php print $insid;?>"  
                <?php if(empty($id)){ ?>onchange="do_search('index.php?data=<?php print base64_encode($userid.';penceramah/penceramah_form.php;penceramah;daftar');?>')" <?php } ?>/> cth: 700104102478</td>
                <td width="20%" rowspan="6" align="center">
                	<?php if(!empty($id)){ ?>
                    	<img src="all_pic/imgpenceramah.php?id=<?php echo $rs->fields['ingenid'];?>" width="100" height="120" border="0">
                        <br>
                        <input type="button" value="Upload Gambar" onclick="upload_gambar('all_pic/upload_imgpenceramah.php?id=<?=$rs->fields['ingenid'];?>'); return false" />
					<?php } ?>
               </td>
            </tr>
            <tr>
                <td width="20%"><b>Nama Penuh <font color="#FF0000">*</font> : </b></td>
                <td width="80%" colspan="3"><input type="text" style="width:70%" name="insname" value="<?php print $rs->fields['insname'];?>" /></td>
            </tr>
            <tr>
                <td width="20%"><b>Gred Jawatan : </b></td>
                <td width="50%" colspan="3">
				<select name="titlegredcd" style="width:70%">
                		<option value="0">Sila pilih gred jawatan</option>
                        <?php 
						   $r_gred = &$conn->query("SELECT * FROM _ref_titlegred ORDER BY f_gred_code ASC");
                           while (!$r_gred->EOF) { ?>
                           <option value="<?=$r_gred->fields['f_gred_code'] ?>" <?php if($rs->fields['titlegredcd'] == $r_gred->fields['f_gred_code']) echo "selected"; ?> ><?=$r_gred->fields['f_gred_code']?> - <?=$r_gred->fields['f_gred_name']?></option>
                        <?php $r_gred->movenext(); } ?>        
                   </select>   
                </td>
            </tr>
            <tr>
                <td width="20%"><b>Organisasi <font color="#FF0000">*</font> : </b></td>
              <td width="80%" colspan="3"><input name="insorganization" type="text" id="insorganization" value="<?php print $rs->fields['insorganization'];?>"  style="width:70%" /></td>
            </tr>
            <tr>
                <td width="20%"><b>Kategori Penceramah <font color="#FF0000">*</font> : </b></td>
                <td width="50%" colspan="3">
				<select name="inskategori" style="width:70%">
                		<option value="">Sila pilih kategori penceramah</option>
                        <?php 
						   $r_kategori = &$conn->query("SELECT * FROM _ref_kategori_penceramah ORDER BY f_kp_sort ASC");
                           while (!$r_kategori->EOF) { ?>
                           <option value="<?=$r_kategori->fields['f_kp_id'] ?>" <?php if($rs->fields['inskategori'] == $r_kategori->fields['f_kp_id']) echo "selected"; ?> ><?=$r_kategori->fields['f_kp_kenyataan']?></option>
                        <?php $r_kategori->movenext(); }?>        
                   </select>   
                </td>
            </tr>
            <tr>
                <td width="20%"><b>No. Telefon Pejabat : </b></td>
                <td width="50%" colspan="3"><input type="text" name="inshometel" size="20" maxlength="15" value="<?php print $rs->fields['inshometel'];?>"></td>
            </tr>
            <tr>
                <td width="20%"><b>No. Telefon Bimbit : </b></td>
                <td width="50%" colspan="3"><input type="text" name="insmobiletel" size="20" maxlength="15" value="<?php print $rs->fields['insmobiletel'];?>"></td>
            </tr>
            <tr>
                <td width="20%"><b>No. Faks : </b></td>
                <td width="50%" colspan="3"><input type="text" name="insfaxno" size="20" maxlength="15" value="<?php print $rs->fields['insfaxno'];?>"></td>
            </tr>
            <tr>
                <td width="20%"><b>Email : </b></td>
                <td width="50%" colspan="3"><input type="text" name="insemail" style="width:70%" value="<?php print $rs->fields['insemail'];?>"></td>
            </tr>
            <tr>
                <td valign="top"><b>Alamat : </b></td>
                <td colspan="3"><textarea cols="60" rows="4" name="insaddress" style="width:70%"><?php print $rs->fields['insaddress'];?></textarea></td>
            </tr>
            <tr>
                <td width="20%"><b>Jantina : </b></td>
                <td width="50%" colspan="3">
                	<select name="insgender">
                    	<option value="L" <?php if($rs->fields['insgender']=='L'){ print 'selected'; }?>>Lelaki</option>
                    	<option value="P" <?php if($rs->fields['insgender']=='P'){ print 'selected'; }?>>Perempuan</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="20%"><b>Tarikh lahir : </b></td>
                <td width="80%" colspan="3"><input name="insdob" type="text" id="insdob" size="12" value="<?=DisplayDate($rs->fields['insdob'])?>" />&nbsp;
                <img src="../cal/img/screenshot.gif" alt="Sila klik untuk pilih tarikh" width="18" height="19" onclick="displayCalendar(document.ilim.insdob,'dd/mm/yyyy',this)"  onmouseover="this.style.cursor='pointer'" /> ( Cth : 30/04/1977 ) </td>
          </tr>
          <tr>
                <td width="20%"><b>Warganegara : </b></td>
                <td width="50%" colspan="2">
				<select name="insnationality">
                <?php 
				$r_country = &$conn->query("SELECT * FROM _ref_negara ORDER BY nama_negara");
                while (!$r_country->EOF) { ?>
                <option value="<?=$r_country->fields['kod_negara'] ?>" <?php if($negara == $r_country->fields['kod_negara']) echo "selected"; ?> ><?=$r_country->fields['nama_negara']?></option>
                <?php $r_country->movenext(); }?>        
               </select>   
                </td>
            </tr>
            <tr>
                <td colspan="4" class="title" height="30">B.&nbsp;&nbsp;&nbsp;MAKLUMAT KEWANGAN</td>
            </tr>
			<tr>
                <td><b>Kadar bayaran sejam : </b></td>
                <td colspan="2">RM <input type="text" name="payperhours" value="<?php print number_format($rs->fields['payperhours'],2);?>" /> 
                (Masukkan angka sahaja)</td>
            </tr>
            <tr>
                <td align="center" colspan="4"><br>
                	<input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat penceramah" 
                    onClick="form_hantar('index.php?data=<?php print base64_encode($userid.';penceramah/penceramah_form_do.php;penceramah;daftar')?>')">
                	<?php if(!empty($id)){ ?>
                    <input type="button" value="Hapus" class="button_disp" title="Sila klik untuk hapus maklumat penceramah" 
                    onClick="form_hapus('index.php?data=<?php print base64_encode($userid.';penceramah/penceramah_form_do.php;penceramah;daftar')?>')">
                    <?php } ?>
					<?php $cetak = "modal_form.php?win=".base64_encode('penceramah/cetak_biodata_penceramah.php;'.$id);?>
                	<input type="button" value="Cetak" class="button_disp" title="Sila klik untuk cetak maklumat penceramah" 
                    onclick="open_modal('<?=$cetak;?>','Cetak Biodata Penceramah',1,1)">

                	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk ke senarai penceramah" 
                    onClick="do_back('index.php?data=<?php print base64_encode($userid.';penceramah/penceramah_list.php;penceramah;daftar');?>')">
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="proses" value="" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                </td>
            </tr>
            <?php if(!empty($id)){ ?>

            <tr>
                <td colspan="4">			<br /><br />

                	<table width="100%" cellpadding="3" cellspacing="0" border="0">
                    	<tr class="title" >
                        	<td colspan="3"><b>MAKLUMAT BUKU BANK</b></td>
                            <td colspan="3" align="right"><?php $new_page = "modal_form.php?win=".base64_encode('penceramah/_bukubank_form.php;');?>
				        	<input type="button" value="Tambah Maklumat Buku Bank" style="cursor:pointer" 
            				<?php if(empty($id)) { print "onclick=\"alert('Sila tekan SIMPAN dahulu sebelum menambah maklumat buku bank!')\""; } 
							else { print "onclick=\"open_modal('".$new_page."','Penambahan Maklumat Buku Bank',70,70)\""; } ?> /> &nbsp;&nbsp;</td>
						</tr>
                </table>
                <table width="100%" cellpadding="5" cellspacing="0" border="1">
                    	<tr class="title" bgcolor="#66CCCC" >
	                       	<td width="5%"><strong>Bil</strong></td>
                            <td width="30%"><strong>Nama Bank</strong></td>
                            <td width="30%"><strong>Cawangan</strong></td>
                            <td width="25%"><strong>No. Akaun Bank</strong></td>
                            <td width="10%">&nbsp;</td>
                        </tr>
                        <?php
						//$conn->debug=true; 	
						$_SESSION['ingenid'] = $id;
						$sSQL2="SELECT * FROM _tbl_instructor_bank WHERE ingenid = ".tosql($id,"Text");
						$sSQL2 .= " ORDER BY inaka_banknama DESC";
						$rs2 = &$conn->Execute($sSQL2);
						$cnt = $rs2->recordcount();
					
						if(!$rs2->EOF) {
						$cnt = 1;
						$bil = 1;
						while(!$rs2->EOF) {
							$href_link = "modal_form.php?win=".base64_encode('penceramah/_bukubank_form.php;'.$rs2->fields['ingenid_bank']);
							$del_href_link = "modal_form.php?win=".base64_encode('penceramah/_bukubank_del.php;'.$rs2->fields['ingenid_bank']);
							$href_img = "modal_form.php?win=".base64_encode('penceramah/_bukubank_sijil.php;'.$rs2->fields['ingenid_bank']);
						?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?=$rs2->fields['inaka_banknama']?>&nbsp;</td>
            				<td valign="top" align="left"><?=$rs2->fields['inaka_bankcawangan']?>&nbsp;</td>
            				<td valign="top" align="left"><?=$rs2->fields['inaka_banknoacct']?>&nbsp;</td>
                            <td align="center">
	                            <?php if(!empty($rs2->fields['fld_image'])){ ?>
                                <img src="../images/btn_certificates_bg.gif" width="30" height="30" style="cursor:pointer" title="Sila klik paparan buku bank" 
                                onclick="open_modal('<?=$href_img;?>','Paparan Maklumat Buku Bank',80,80)" />
                                <?php } ?>
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Buku Bank',80,80)" />
                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data" 
                                onclick="open_modal('<?=$del_href_link;?>','Padam Maklumat Buku Bank',700,300)" />
                            </td>
                        </tr>
                        <?php
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs2->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <?php } ?> 
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="4" class="title" height="30"><br /><br />C.&nbsp;&nbsp;&nbsp;<b>MAKLUMAT PEKERJAAN</b></td>
            </tr>
            <tr>
                <td colspan="4">
                	<table width="100%" cellpadding="3" cellspacing="0" border="0">
                    	<tr class="title" >
                        	<td colspan="3"><b>MAKLUMAT KELAYAKAN AKADEMIK</b></td>
                            <td colspan="3" align="right"><?php $new_page = "modal_form.php?win=".base64_encode('penceramah/_akademik_form.php;');?>
				        	<input type="button" value="Tambah Maklumat Akademik" style="cursor:pointer" 
            				<?php if(empty($id)) { print "onclick=\"alert('Sila tekan SIMPAN dahulu sebelum menambah maklumat akademik!')\""; } 
							else { print "onclick=\"open_modal('".$new_page."','Penambahan Maklumat Akademik',70,70)\""; } ?> /> &nbsp;&nbsp;</td>
						</tr>
                </table>
                <table width="100%" cellpadding="5" cellspacing="0" border="1">
                    	<tr class="title" bgcolor="#66CCCC">
	                       	<td width="5%"><strong>Bil</strong></td>
                            <td width="25%"><strong>Kelulusan Akademik</strong></td>
                            <td width="25%"><strong>Nama Kursus</strong></td>
                            <td width="25%"><strong>Institusi Pengajian</strong></td>
                            <td width="10%"><strong>Tahun</strong></td>
                            <td width="10%">&nbsp;</td>
                        </tr>
                        <?php
						//$conn->debug=true; 	
						$_SESSION['ingenid'] = $id;
						$sSQL2="SELECT * FROM _tbl_instructor_akademik WHERE ingenid = ".tosql($id,"Text");
						$sSQL2 .= " ORDER BY inaka_tahun DESC";
						$rs2 = &$conn->Execute($sSQL2);
						$cnt = $rs2->recordcount();
					
						if(!$rs2->EOF) {
						$cnt = 1;
						$bil = 1;
						while(!$rs2->EOF) {
							$href_link = "modal_form.php?win=".base64_encode('penceramah/_akademik_form.php;'.$rs2->fields['ingenid_akademik']);
							$del_href_link = "modal_form.php?win=".base64_encode('penceramah/_akademik_del.php;'.$rs2->fields['ingenid_akademik']);
							$href_img = "modal_form.php?win=".base64_encode('penceramah/_akademik_sijil.php;'.$rs2->fields['ingenid_akademik']);
						?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?=dlookup("_ref_akademik", "f_akademik_nama", " f_akademik_id = ".$rs2->fields['inaka_sijil'])?>&nbsp;</td>
            				<td valign="top" align="left"><?=$rs2->fields['inaka_kursus']?>&nbsp;</td>
            				<td valign="top" align="left"><?=$rs2->fields['inaka_institusi']?>&nbsp;</td>
                            <td valign="top" align="center"><?=$rs2->fields['inaka_tahun']?>&nbsp;</td>
                            <td align="center">
	                            <?php if(!empty($rs2->fields['fld_image'])){ ?>
                                <img src="../images/btn_certificates_bg.gif" width="30" height="30" style="cursor:pointer" title="Sila klik paparan sijil akademik" 
                                onclick="open_modal('<?=$href_img;?>','Paparan Maklumat Sijil Akademik',80,80)" />
                                <?php } ?>
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Akademik',80,80)" />
                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data" 
                                onclick="open_modal('<?=$del_href_link;?>','Padam Maklumat Akademik',700,300)" />
                            </td>
                        </tr>
                        <?php
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs2->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <?php } ?> 
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4"><br /><br />
                	<table width="100%" cellpadding="1" cellspacing="0" border="0">
                    	<tr class="title" >
                        	<td colspan="3"><b>MAKLUMAT BIDANG KEPAKARAN</b></td>
                            <td colspan="3" align="right"><?php $new_page = "modal_form.php?win=".base64_encode('penceramah/_kepakaran_form.php;');?>
        						<input type="button" value="Tambah Bidang Kepakaran" style="cursor:pointer" 
            					<?php if(empty($id)) { print "onclick=\"alert('Sila tekan SIMPAN dahulu sebelum menambah bidang kepakaran!')\""; }
									else { print "onclick=\"open_modal('".$new_page."','Penambahan Maklumat Kepakaran',700,400)\""; } ?> /> &nbsp;&nbsp;</td>
						</tr>
                     </table>
                     <table width="100%" cellpadding="5" cellspacing="0" border="1">
                    	<tr class="title"  bgcolor="#66CCCC">
                        	<td width="5%"><strong>Bil</strong></td>
                            <td width="40%"><strong>Bidang Kepakaran</strong></td>
                            <td width="45%"><strong>Pengkhususan</strong></td>
                            <td width="10%">&nbsp;</td>
                        </tr>
                        <?php 	
								$_SESSION['ingenid'] = $id;
								$sSQL2="SELECT * FROM _tbl_instructor_kepakaran WHERE ingenid = ".tosql($id,"Text");
							//	$sSQL2 .= "ORDER BY inaka_tahun";
								$rs2 = &$conn->Execute($sSQL2);
								$cnt = $rs2->recordcount();
						 if(!$rs2->EOF) {
						$cnt = 1;
						$bil = 1;
							while(!$rs2->EOF) {
							$href_link = "modal_form.php?win=".base64_encode('penceramah/_kepakaran_form.php;'.$rs2->fields['inpakar_id']);
							$del_href_link = "modal_form.php?win=".base64_encode('penceramah/_kepakaran_del.php;'.$rs2->fields['inpakar_id']);
							?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?=dlookup("_ref_kepakaran", "f_pakar_nama", " f_pakar_code = ".$rs2->fields['inpakar_bidang'])?>&nbsp;</td>
            				<td valign="top" align="left"><?=$rs2->fields['inpakar_pengkhususan']?>&nbsp;</td>
            			    <td align="center">
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Kepakaran',700,400)" />
                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data" onclick="open_modal('<?=$del_href_link;?>','Padam Maklumat Kepakaran',700,300)" />
                            </td>
                        </tr>
                        <?php
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs2->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <?php } ?> 
                   </table>
                </td>
            </tr>
            <?php } ?>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.insid.focus();
</script>