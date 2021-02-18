<script LANGUAGE="JavaScript">
function form_hantar(URL){
		document.ilim.action = URL;
		document.ilim.submit();
}

function form_hapus(URL){
	var staff = document.ilim.cl_name.value;
	if(confirm("Adakah anda pasti untuk menghapuskan Rekod Tuntutan bagi penceramah ini?\n-"+staff)){
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

function update_bank(name,caw,acct){
	document.ilim.cl_bank.value=name;
	document.ilim.cl_bankbrch.value=caw;
	document.ilim.cl_akaun.value=acct;

}
</script>
<?
//$conn->debug=true;
function dlookupList($Table, $fName, $sWhere, $sOrder){
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
//$ingid = $_GET['ingid'];
$PageNo = $_POST['PageNo'];
$sSQL="SELECT * FROM _tbl_claim  WHERE cl_id= ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
$ingid=$rs->fields['cl_ins_id'];
?>
<form name="ilim" id="frm" method="post">
<table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
    <tr bgcolor="#00CCFF">
    	<td colspan="2" height="30">&nbsp;<b>BORANG TUNTUTAN PENCERAMAH</b></td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
            <tr>

                <td colspan="3" class="title" height="30">BAHAGIAN 1 : BUTIR-BUTIR PERIBADI</td>
            </tr>
			<?php
				$sqlinst = "SELECT * FROM _tbl_instructor WHERE ingenid=".tosql($rs->fields['cl_ins_id']);
				$rs_inst = $conn->execute($sqlinst);
			?>

            <tr>
                <td width="30%">Nama Penuh : </td>
                <td width="80%" colspan="3"><input type="text" size="65" name="cl_name" value="<?php print $rs_inst->fields['insname'];?>" />
                <?php if(empty($id)){ $new_penc = "modal_form.php?win=".base64_encode('penceramah/_penceramah_list.php;'); ?>
                	<input type="button" value="Pilih Penceramah" style="cursor:pointer" title="Sila klik untuk pemilihan maklumat penceramah" 
                    onclick="open_modal('<?=$new_penc;?>','Senarai Nama Penceramah',80,80)" />
                <?php } ?>
                </td>
            </tr>

            <tr>
              <td>No. K/P : </td>
              <td colspan="2"><input name="cl_kp" type="text" id="cl_kp"  value="<?php print $rs_inst->fields['insid'];?>"/>
                </td>
            </tr>
            <tr>
              <td>Gred / Jawatan Yang Disandang :</td>
            <td colspan="2"> <input name="cl_titlegredcd" type="text" id="cl_titlegredcd"  value="<?php print $rs_inst->fields['titlegredcd'];?>"/></td>
            </tr>
            

            <tr>
              <td>Taraf Jawatan : </td>
              <td colspan="2"><select name="cl_tarafpost">
                  					<option value="01" <?php if($rs->fields['cl_tarafpost'] == '01') echo "selected"; ?> >TETAP</option>
                                    <option value="02" <?php if($rs->fields['cl_tarafpost'] == '02') echo "selected"; ?> >SAMBILAN</option>
                                    <option value="03" <?php if($rs->fields['cl_tarafpost'] == '03') echo "selected"; ?> >KONTRAK</option>
               				  </select>              
              </td>
            </tr>
            <tr>
                <td width="30%">Gaji pokok : </td>
                <td width="80%" colspan="2"><input name="cl_gaji" type="text" id="cl_gaji" value="<? print $rs->fields['cl_gaji'];?>" size="20" maxlength="15"></td>
            </tr>
            <tr>
                <td width="30%">Elaun Memangku (Jika ada) : </td>
                <td width="80%" colspan="2"><input name="cl_elaun" type="text" id="cl_elaun" value="<? print $rs->fields['cl_elaun'];?>" size="20" maxlength="15"></td>
            </tr>
            <tr>
                <td width="30%">No. Gaji / Pekerja : </td>
                <td width="80%" colspan="2"><input name="cl_gajino" type="text" id="cl_gajino" value="<? print $rs->fields['cl_gajino'];?>" size="20" maxlength="15"></td>
            </tr>
            <tr>
                <td width="30%">Kadar Bayaran Sejam : </td>
                <td width="80%" colspan="2"><input name="payperhours" type="text" id="cl_gajino" value="<? print $rs_inst->fields['payperhours'];?>" size="20" maxlength="15"></td>
            </tr>
            <tr>
                <td>Nama Bank : </td>
                <td colspan="3"><input type="text" name="cl_bank"  size="65" value="<? print $rs->fields['cl_bank'];?>" />
                <? $new_page = "modal_form.php?win=".base64_encode('penceramah/_bukubank_list.php;'.$ingid);?>
                &nbsp;<input type="button" value="Pilih Bank" title="Sila klik untuk membuat pilihan Bank" 
                onclick="open_modal('<?=$new_page;?>&idp=<?=$ingid;?>','Senarai Maklumat Bank Penceramah',800,350)" />
                </td>
            </tr>
            <tr>
                <td>Cawangan Bank : </td>
                <td colspan="2"><input type="text" name="cl_bankbrch"  size="65" value="<? print $rs->fields['cl_bankbrch'];?>" /></td>
            </tr>
            <tr>
                <td>No. Akaun Bank : </td>
                <td colspan="2"><input type="text" name="cl_akaun"  size="65" value="<? print $rs->fields['cl_akaun'];?>" /></td>
            </tr>
            <tr>
              <td>Nama Kementerian / Jabatan / Agensi : </td>
              <td colspan="2"><input name="cl_orgdesc" type="text" id="cl_orgdesc" value="<? print $rs->fields['cl_orgdesc'];?>" size="80" /></td>
            </tr>
            <tr>
              <td valign="top">Alamat Kementerian / Jabatan / Agensi : </td>
              <td colspan="2"><textarea cols="80" rows="4" name="cl_orgadd" id="cl_orgadd"><? print $rs->fields['cl_orgadd'];?></textarea></td>
            </tr>
            <tr>
                <td colspan="3" class="title" height="30">KEMENTERIAN / JABATAN / AGENSI PENGANJUR</td>
           </tr>
            <tr>
                <td colspan="3"><table width="99%" cellpadding="3" cellspacing="0" border="1" align="center">
<tr>
                  <td width="14%">Kod Jabatan</td>
                  <td width="48%"><input type="text" name="cl_depcd" size="20" maxlength="15" value="<? print $rs->fields['cl_depcd'];?>" /></td>
                  <td width="16%">Kod Pejabat Perakaunan</td>
                  <td width="22%"><input name="cl_accoffcd" type="text" id="cl_accoffcd" value="<? print $rs->fields['cl_accoffcd'];?>" size="20" maxlength="15" /></td>
                  </tr>
                  <tr>
                               <td>PTJ</td>
                               <td><input type="text" name="cl_ptjdesc"  size="60" value="<? print $rs->fields['cl_ptjdesc'];?>" /></td>
                             <td>Kod PTJ</td>
                               <td><input type="text" name="cl_ptjcd" size="20" maxlength="15" value="<? print $rs->fields['cl_ptjcd'];?>" /></td>
                  </tr>
                           <tr>
                             <td>Pusat Pembayaran</td>
                             <td><input type="text" name="cl_payctrdesc"  size="60" value="<? print $rs->fields['cl_payctrdesc'];?>" /></td>
                             <td>Kod Pusat Pembayaran</td>
                             <td><input type="text" name="cl_payctrcd" size="20" maxlength="15" value="<? print $rs->fields['cl_payctrcd'];?>" /></td>
                           </tr>
                           <tr>
                             <td>Cawangan</td>
                             <td><input type="text" name="cl_brchdesc"  size="60" value="<? print $rs->fields['cl_brchdesc'];?>" /></td>
                             <td>Kod Cawangan</td>
                             <td><input type="text" name="cl_brchcd" size="20" maxlength="15" value="<? print $rs->fields['cl_brchcd'];?>" /></td>
                           </tr>
                           <tr>
                             <td>Jenis Dok. Asal</td>
                             <td><input type="text" name="cl_doctype"  size="60" value="<? print $rs->fields['cl_doctype'];?>" /></td>
                             <td>No. Rujukan Dok. Asal</td>
                             <td><input type="text" name="cl_docno" size="20" maxlength="15" value="<? print $rs->fields['cl_docno'];?>" /></td>
                           </tr>
                           <tr>
                             <td>Bulan</td>
                             <td><select id="cl_month" name="cl_month">
                                   		<?php $mth = date('m');?>
                                  	<option value= "1" <?php if($rs->fields['cl_month'] == 1) echo "selected"; ?>>Januari</option>
                                    <option value= "2" <?php if($rs->fields['cl_month'] == 2) echo "selected"; ?>>Februari</option>
                                    <option value= "3" <?php if($rs->fields['cl_month'] == 3) echo "selected"; ?>>Mac</option>
                                    <option value= "4" <?php if($rs->fields['cl_month'] == 4) echo "selected"; ?>>April</option>
                                    <option value= "5" <?php if($rs->fields['cl_month'] == 5) echo "selected"; ?>>Mei</option>
                                    <option value= "6" <?php if($rs->fields['cl_month'] == 6) echo "selected"; ?>>Jun</option>
                                    <option value= "7" <?php if($rs->fields['cl_month'] == 7) echo "selected"; ?>>Julai</option>
                                    <option value= "8" <?php if($rs->fields['cl_month'] == 8) echo "selected"; ?>>Ogos</option>
                                    <option value= "9" <?php if($rs->fields['cl_month'] == 9) echo "selected"; ?>>September</option>
                                    <option value= "10" <?php if($rs->fields['cl_month'] == 10) echo "selected"; ?>>Oktober</option>
                                    <option value= "11" <?php if($rs->fields['cl_month'] == 11) echo "selected"; ?>>November</option>
                                    <option value= "12" <?php if($rs->fields['cl_month'] == 12) echo "selected"; ?>>Disember</option>		
                                 </select>
                                </td>
                             <td>Tahun</td>
                             <td><select id="cl_year" name="cl_year">
                                   		<?php 
										$yr = date('Y');
										for ($t = $yr; $t >= $yr-10; $t--) { ?>
                                  	<option value= "<?=$t?>" <?php if($rs->fields['cl_year'] == $t) echo "selected"; ?>>
                                    	<?=$t?>
                                     </option>		
                                  		<?php }?>
                                </select></td>
                           </tr>
                           
              </table>              </td>
            </tr>
            <tr>
                <td colspan="3" class="title" height="30">BUTIR - BUTIR PERMOHONAN</td>
          </tr>
            <tr>
                <td colspan="3">
                	<table width="100%" cellpadding="3" cellspacing="0" border="0">
                    	<tr class="title" >
                        	<td colspan="3">MAKLUMAT KURSUS / CERAMAH</td>
                            <td colspan="3" align="right"><? $new_page = "modal_form.php?win=".base64_encode('penceramah/_claim_event_form.php;');?>
				        	<input type="button" value="Tambah Maklumat Kursus / Ceramah" style="cursor:pointer" 
            				<?php if(empty($id)) { print "onclick=\"alert('Sila tekan SIMPAN dahulu sebelum menambah maklumat Kursus / Ceramah!')\""; } 
							else { print "onclick=\"open_modal('".$new_page."&m=".$rs->fields['cl_month']."&y=".$rs->fields['cl_year']."&iding=".$ingid."','Penambahan Maklumat Kursus / Ceramah',800,400)\""; } ?> /> &nbsp;&nbsp;</td>
						</tr>
                </table>

                <table width="100%" cellpadding="3" cellspacing="0" border="1">
                    	<tr class="title" >
	                       	<td width="5%">Bil</td>
                            <td width="50%">Nama Jabatan yg menganjurkan kursus / ceramah</td>
                            <td width="15%" align="center">Tarikh Kursus / Ceramah</td>
                            <td width="10%" align="center">Tempoh (Dalam jam)</td>
                            <td width="13%" align="center">Tuntutan (RM)</td>
                           <td width="7%">&nbsp;</td>
                        </tr>
                        <?php 
						if(!empty($id)) {	
						$_SESSION['cl_id'] = $id;
						$payperhour = dlookup("_tbl_instructor", "payperhours", " ingenid = ".tosql($rs->fields['cl_ins_id']));
						$sSQL2="SELECT * FROM _tbl_claim_event WHERE cl_id = ".tosql($id,"number");
						$sSQL2 .= " ORDER BY cl_eve_startdate";
						$rs2 = &$conn->Execute($sSQL2);
						$cnt = $rs2->recordcount();
						 if(!$rs2->EOF) {
						$cnt = 1;
						$bil = 1;
						$sum = 0;
						while(!$rs2->EOF) {
							$href_link = "modal_form.php?win=".base64_encode('penceramah/_claim_event_form.php;'.$rs2->fields['cl_eve_id']);
							$del_href_link = "modal_form.php?win=".base64_encode('penceramah/_claim_event_form.php;'.$rs2->fields['cl_eve_id']);
							$pay = $rs2->fields['cl_eve_tempoh']*$payperhour;
							$sum += $pay;
						?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?=dlookup("_tbl_kursus", "coursename", " id = ".tosql($rs2->fields['cl_eve_course_id']))?>&nbsp;</td>
            				<td valign="top" align="center"><? echo DisplayDate($rs2->fields['cl_eve_startdate'])." - ".DisplayDate($rs2->fields['cl_eve_enddate']);?>&nbsp;</td>
            				<td valign="top" align="center"><?=$rs2->fields['cl_eve_tempoh']?>&nbsp;</td>
                            <td valign="top" align="center"><? echo number_format($pay,2); ?>&nbsp;</td>
                            <td align="center">
                            	<img src="../img/icon-info1.gif" width="20" height="20" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>&iding=<?=$ingid?>&m=<?=$rs->fields['cl_month']?>&y=<?=$rs->fields['cl_year']?>','Kemaskini Maklumat Kursus / Ceramah',800,400)" />
                            	<img src="../img/ico-cancel.gif" width="20" height="20" style="cursor:pointer" title="Sila klik untuk penghapusan data" 
                                onclick="open_modal('<?=$del_href_link;?>&pro=DEL&iddel=<?=$rs2->fields['cl_eve_id'];?>','Padam Maklumat Kursus / Ceramah',700,300)" />                            </td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs2->movenext();
                    }  ?>
					   <tr class="title" >
	                       	<td colspan="4" align="right">Jumlah &nbsp;(RM)&nbsp;</td>
                         <td width="13%" align="center"><?=number_format($sum,2)?>&nbsp;</td>
                         <td width="7%">&nbsp;</td>
                        </tr>
				<?
                } else {
                ?>
                <tr><td colspan="10" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <? } } ?> 
                  </table>                </td>
            </tr>
            <tr>
                <td>Status Tuntutan : </td>
                <td colspan="2">
                	<select name="is_process">
                    	<option value="0" <?php if($rs->fields['is_process']==0){ print 'selected'; }?>>Baru</option>
                    	<option value="1" <?php if($rs->fields['is_process']==1){ print 'selected'; }?>>Dalam Proses</option>
                    	<option value="2" <?php if($rs->fields['is_process']==2){ print 'selected'; }?>>Telah Dijelaskan</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><br>
                	<?php if($rs->fields['is_process']!=2){ ?>
                	<input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat tuntutan" 
                    onClick="form_hantar('index.php?data=<? print base64_encode('user;penceramah/claim_form_do.php;penceramah;tuntutan')?>')">
                    <?php } ?>
                	<? if(!empty($id)){ 
					$href_surat = "modal_form.php?win=".base64_encode('penceramah/claim_print.php;'.$id);
					?>
                	<?php if($rs->fields['is_process']!=2){ ?>
                    <input type="button" value="Hapus" class="button_disp" title="Sila klik untuk hapus maklumat tuntutan" 
                    onClick="form_hapus('index.php?data=<? print base64_encode('user;penceramah/claim_form_do.php;penceramah;tuntutan')?>')">
					<?php } ?>
                     <input type="button" value="Cetak" class="button_disp" title="Sila klik untuk cetak maklumat tuntutan" 
                    onClick="open_modal('<?=$href_surat;?>','Cetakan borang tuntutan penceramah',1,1)">
                    <? } ?>
                	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk ke senarai tuntutan" 
                    onClick="do_back('index.php?data=<? print base64_encode('user;penceramah/penceramah_claim.php;penceramah;tuntutan;');?>')">
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="ingid" value="<?=$ingid?>" />
                    <input type="hidden" name="proses" value="" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />                
                </td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>