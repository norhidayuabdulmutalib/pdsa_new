<script LANGUAGE="JavaScript">

function form_hantar(URL){

		document.ilim.action = URL;

		document.ilim.submit();
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



$PageNo = $_POST['PageNo'];


	$sSQL="SELECT * FROM _tbl_claim  WHERE cl_id= ".tosql($id,"Text");
	

$rs = &$conn->Execute($sSQL);

?>

<form name="ilim" id="frm" method="post">

<table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">

    <tr bgcolor="#00CCFF">

    	<td colspan="2" height="30">&nbsp;<b>BORANG TUNTUTAN PENCERAMAH</b></td>

    </tr>

	<tr><td colspan="2">
        
    	<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">

            <tr>

                <td colspan="3" class="title" height="30">KEMENTERIAN / JABATAN / AGENSI PENGANJUR</td>
            </tr>
            <tr>

                <td colspan="3"><table width="80%" cellpadding="3" cellspacing="0" border="1" align="center">
<tr>
                               <td width="14%">Kod Jabatan</td>
                               <td width="48%"><input type="text" name="cl_depcd" size="20" maxlength="15" value="<? print $rs->fields['cl_depcd'];?>" /></td>
                  <td width="16%">Kod Pejabat Perakaunan</td>
                  <td width="22%"><input name="cl_accoffcd" type="text" id="cl_accoffcd" value="<? print $rs->fields['cl_accoffcd'];?>" size="20" maxlength="15" /></td>
                  </tr>
                           <tr>
                               <td>PTJ</td>
                               <td><input type="text" name="cl_ptjdesc"  size="65" value="<? print $rs->fields['cl_ptjdesc'];?>" /></td>
                             <td>Kod PTJ</td>
                               <td><input type="text" name="cl_ptjcd" size="20" maxlength="15" value="<? print $rs->fields['cl_ptjcd'];?>" /></td>
                  </tr>
                           <tr>
                             <td>Pusat Pembayaran</td>
                             <td><input type="text" name="cl_payctrdesc"  size="65" value="<? print $rs->fields['cl_payctrdesc'];?>" /></td>
                             <td>Kod Pusat Pembayaran</td>
                             <td><input type="text" name="cl_payctrcd" size="20" maxlength="15" value="<? print $rs->fields['cl_payctrcd'];?>" /></td>
                           </tr>
                           <tr>
                             <td>Cawangan</td>
                             <td><input type="text" name="cl_brchdesc"  size="65" value="<? print $rs->fields['cl_brchdesc'];?>" /></td>
                             <td>Kod Cawangan</td>
                             <td><input type="text" name="cl_brchcd" size="20" maxlength="15" value="<? print $rs->fields['cl_brchcd'];?>" /></td>
                           </tr>
                           <tr>
                             <td>Jenis Dok. Asal</td>
                             <td><input type="text" name="cl_doctype"  size="65" value="<? print $rs->fields['cl_doctype'];?>" /></td>
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

                <td colspan="3" class="title" height="30">BAHAGIAN 1 : BUTIR-BUTIR PERIBADI</td>
            </tr>


            <tr>

                <td width="30%">Nama Penuh : </td>

                <td width="80%" colspan="3"><input type="text" size="65" name="cl_name" value="<?=dlookup("_tbl_instructor", "insname", " ingenid = ".$_SESSION['ingenid'])?>" /></td>
            </tr>

            <tr>
              <td>No. K/P : </td>
              <td colspan="2"><input name="cl_kp" type="text" id="cl_kp"  value="<?=dlookup("_tbl_instructor", "insid", " ingenid = ".$_SESSION['ingenid'])?>"/>
                </td>
            </tr>
            <tr>
              <td>Gred / Jawatan Yang Disandang :</td>
            <td colspan="2"> <input name="cl_titlegredcd" type="text" id="cl_titlegredcd"  value="<?=dlookup("_tbl_instructor", "titlegredcd", " ingenid = ".$_SESSION['ingenid'])?>"/></td>
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

                <td width="30%">No. Gaji / Pekerja: </td>

                <td width="80%" colspan="2"><input name="cl_gajino" type="text" id="cl_gajino" value="<? print $rs->fields['cl_gajino'];?>" size="20" maxlength="15"></td>
            </tr>




            <tr>

                <td>Nama Bank : </td>

                <td colspan="3"><input type="text" name="cl_bank"  size="65" value="<? print $rs->fields['cl_bank'];?>" /></td>
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

                <td colspan="3" class="title" height="30">C.&nbsp;&nbsp;&nbsp;BUTIR - BUTIR PERMOHONAN</td>
            </tr>

            <tr>

                <td colspan="3">

                	<table width="100%" cellpadding="3" cellspacing="0" border="0">

                    	<tr class="title" >

                        	<td colspan="3">MAKLUMAT KURSUS / CERAMAH</td>

                            <td colspan="3" align="right"><? $new_page = "modal_form.php?win=".base64_encode('penceramah/_claim_event_form.php;');?>

				        	<input type="button" value="Tambah Maklumat Kursus / Ceramah" style="cursor:pointer" 

            				<?php if(empty($id)) { print "onclick=\"alert('Sila tekan SIMPAN dahulu sebelum menambah maklumat Kursus / Ceramah!')\""; } 

							else { print "onclick=\"open_modal('".$new_page."','Penambahan Maklumat Kursus / Ceramah',800,450)\""; } ?> /> &nbsp;&nbsp;</td>
						</tr>
                </table>

                <table width="100%" cellpadding="3" cellspacing="0" border="1">

                    	<tr class="title" >

	                       	<td width="4%">Bil</td>

                            <td width="31%">Nama Jabatan yg menganjurkan kursus / ceramah</td>

                            <td width="17%" align="center">Tarikh kursus / ceramah</td>

                            <td width="13%" align="center">Tempoh (Dalam jam)</td>

                            <td width="15%" align="center">Tuntutan (RM)</td>

                           <td width="20%">&nbsp;</td>
                        </tr>

                        <?php 
						
						if(!empty($id)) {	

								$_SESSION['cl_id'] = $id;
								
								$payperhour = dlookup("_tbl_instructor", "payperhours", " ingenid = ".$_SESSION['ingenid']);

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

							$del_href_link = "modal_form.php?win=".base64_encode('penceramah/_claim_event_del.php;'.$rs2->fields['cl_eve_id']);
							
							$pay = $rs2->fields['cl_eve_tempoh']*$payperhour;
							
							$sum += $pay;

						?>

                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">

                            <td valign="top" align="right"><?=$bil;?>.</td>

            				<td valign="top" align="left"><?=dlookup("_tbl_kursus", "coursename", " id = ".$rs2->fields['cl_eve_course_id'])?>&nbsp;</td>

            				<td valign="top" align="left"><? echo DisplayDate($rs2->fields['cl_eve_startdate'])." - ".DisplayDate($rs2->fields['cl_eve_enddate']);?>&nbsp;</td>

            				<td valign="top" align="left"><?=$rs2->fields['cl_eve_tempoh']?>&nbsp;</td>

                            <td valign="top" align="center"><? echo $pay; ?>&nbsp;</td>

                            <td align="center">

	                            <?php if(!empty($rs2->fields['fld_image'])){ ?>

                                <img src="../images/btn_certificates_bg.gif" width="30" height="30" style="cursor:pointer" title="Sila klik paparan sijil akademik" 

                                onclick="open_modal('<?=$href_img;?>','Kemaskini Maklumat Kursus / Ceramah',800,450)" />

                                <?php } ?>

                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 

                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Kursus / Ceramah',800,450)" />

                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data" 

                                onclick="open_modal('<?=$del_href_link;?>','Padam Maklumat Kursus / Ceramah',700,300)" />                            </td>
                        </tr>

                        <?

                        $cnt = $cnt + 1;

                        $bil = $bil + 1;

                        $rs2->movenext();

                    }  ?>
                    
					   <tr class="title" >

	                       	<td colspan="4" align="right">Jumlah &nbsp;(RM)&nbsp;</td>

                         <td width="15%" align="center"><?=$sum?>&nbsp;</td>

                         <td width="20%">&nbsp;</td>
                        </tr>
				<?

                } else {

                ?>

                <tr><td colspan="10" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>

                <? } } ?> 
                  </table>                </td>
            </tr>
            <tr>

                <td></td>

                <td><br>

                	<input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat tuntutan" 

                    onClick="form_hantar('index.php?data=<? print base64_encode('user;penceramah/claim_form_do.php;penceramah;daftar')?>')">

                	<? if(!empty($id)){ ?>

                    <input type="button" value="Hapus" class="button_disp" title="Sila klik untuk hapus maklumat tuntutan" 

                    onClick="form_hapus('index.php?data=<? print base64_encode('user;penceramah/claim_form_do.php;penceramah;daftar')?>')">
                    
                     <input type="button" value="Cetak" class="button_disp" title="Sila klik untuk cetak maklumat tuntutan" 

                    onClick="form_hapus('index.php?data=<? print base64_encode('user;penceramah/claim_form_do.php;penceramah;daftar')?>')">
                    

                    <? } ?>

                	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk ke senarai tuntutan" 

                    onClick="do_back('index.php?data=<? print base64_encode('user;penceramah/claim_list.php;penceramah;daftar');?>')">

                    <input type="hidden" name="id" value="<?=$id?>" />

                    <input type="hidden" name="proses" value="" />

                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />                </td>
            </tr>
        </table>

      </td>

   </tr>

</table>

</form>


