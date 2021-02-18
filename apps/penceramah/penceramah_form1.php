<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar2.css?random=20051112" media="screen"></link>

<script type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js?random=20060118"></script>

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

if(!empty($_GET['kp'])){ 

	$sSQL="SELECT * FROM _tbl_instructor  WHERE is_deleted=0 AND insid = ".tosql($_GET['kp'],"Text");

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

                <td width="30%">No. K/P : </td>

                <td width="50%" colspan="2"><input type="text" name="insid"  value="<? print $insid;?>"  

                <?php if(empty($id)){ ?>onchange="do_search('index.php?data=<? print base64_encode('user;penceramah/penceramah_form.php;penceramah;daftar');?>')" <?php } ?>/> cth: 700104102478</td>

                <td width="20%" rowspan="6" align="center">

                	<? if(!empty($id)){ ?>

                    	<img src="all_pic/imgpenceramah.php?id=<? echo $rs->fields['ingenid'];?>" width="100" height="120" border="0">

                        <br>

                        <input type="button" value="Upload Gambar" onclick="upload_gambar('all_pic/upload_imgpenceramah.php?id=<?=$rs->fields['ingenid'];?>'); return false" />

					<? } ?>

               </td>

            </tr>

            <tr>

                <td width="20%">Nama Penuh : </td>

                <td width="80%" colspan="3"><input type="text" size="65" name="insname" value="<? print $rs->fields['insname'];?>" /></td>

            </tr>

            <tr>

                <td width="20%">Gred Jawatan : </td>

                <td width="50%" colspan="2">

				<select name="titlegredcd">

                        <?php 

                           $r_gred = dlookupList('_ref_titlegred', 'f_gred_code,f_gred_name', '', 'f_gred_code DESC');

                           while ($row_gred = mysql_fetch_array($r_gred, MYSQL_BOTH)) { ?>

                           <option value="<?=$row_gred['f_gred_code'] ?>" <?php if($rs->fields['titlegredcd'] == $row_gred['f_gred_code']) echo "selected"; ?> ><?=$row_gred['f_gred_code']?> - <?=$row_gred['f_gred_name']?></option>

                        <?php }?>        

                   </select>   

                </td>

            </tr>

            <tr>

                <td width="20%">Organisasi : </td>

              <td width="80%" colspan="3"><input name="insorganization" type="text" id="insorganization" value="<? print $rs->fields['insorganization'];?>" size="65" /></td>

            </tr>

            <tr>

                <td width="20%">No. Telefon Pejabat : </td>

                <td width="50%" colspan="2"><input type="text" name="inshometel" size="20" maxlength="15" value="<? print $rs->fields['inshometel'];?>"></td>

            </tr>

            <tr>

                <td width="20%">No. Telefon Bimbit : </td>

                <td width="50%" colspan="2"><input type="text" name="insmobiletel" size="20" maxlength="15" value="<? print $rs->fields['insmobiletel'];?>"></td>

            </tr>

            <tr>

                <td width="20%">No. Faks : </td>

                <td width="50%" colspan="2"><input type="text" name="insfaxno" size="20" maxlength="15" value="<? print $rs->fields['insfaxno'];?>"></td>

            </tr>

            <tr>

                <td width="20%">Email : </td>

                <td width="50%" colspan="2"><input type="text" name="insemail" size="50" value="<? print $rs->fields['insemail'];?>"></td>

            </tr>

            <tr>

                <td valign="top">Alamat : </td>

                <td colspan="2"><textarea cols="60" rows="4" name="insaddress"><? print $rs->fields['insaddress'];?></textarea></td>

            </tr>

            <tr>

                <td width="20%">Jantina : </td>

                <td width="50%" colspan="2">

                	<select name="insgender">

                    	<option value="L" <? if($rs->fields['insgender']=='L'){ print 'selected'; }?>>Lelaki</option>

                    	<option value="P" <? if($rs->fields['insgender']=='P'){ print 'selected'; }?>>Perempuan</option>

                    </select>

                </td>

            </tr>

            <tr>

                <td width="20%">Tarikh lahir : </td>

                <td width="80%" colspan="3"><input name="insdob" type="text" id="insdob" size="12" value="<?=DisplayDate($rs->fields['insdob'])?>" />&nbsp;

                <img src="../cal/img/screenshot.gif" alt="Sila klik untuk pilih tarikh" width="18" height="19" onclick="displayCalendar(document.ilim.insdob,'dd/mm/yyyy',this)"  onmouseover="this.style.cursor='pointer'" /> ( Cth : 30/04/1977 ) </td>

          </tr>

          <tr>

                <td width="20%">Warganegara : </td>

                <td width="50%" colspan="2">

				<select name="insnationality">

                <?php 

                $r_country = dlookupList('_ref_negara', 'kod_negara,nama_negara', '', 'nama_negara');

                while ($row_country = mysql_fetch_array($r_country, MYSQL_BOTH)) { ?>

                <option value="<?=$row_country['kod_negara'] ?>" <?php if($negara == $row_country['kod_negara']) echo "selected"; ?> ><?=$row_country['nama_negara']?></option>

                <?php }?>        

               </select>   

                </td>

            </tr>

            <tr>

                <td colspan="4" class="title" height="30">B.&nbsp;&nbsp;&nbsp;MAKLUMAT KEWANGAN</td>

            </tr>

			<tr>

                <td>Kadar bayaran sejam : </td>

                <td colspan="2">RM <input type="text" name="payperhours" value="<? print $rs->fields['payperhours'];?>" /> (Masukkan angka sahaja!)</td>

                <td rowspan="4" align="center"><? if(!empty($id)){ ?>

                    	<img src="all_pic/img_bukubank.php?id=<? echo $rs->fields['ingenid'];?>" width="100" height="100" border="0">

                        <br>

                        <input type="button" value="Upload Buku Bank" onclick="upload_gambar('all_pic/upload_bukubank.php?id=<?=$rs->fields['ingenid'];?>'); return false" />

					<? } ?>

                 </td>

            </tr>

            <tr>

                <td>Nama Bank : </td>

                <td colspan="3"><input type="text" name="insbank"  size="65" value="<? print $rs->fields['insbank'];?>" /></td>

            </tr>

            <tr>

                <td>Cawangan Bank : </td>

                <td colspan="2"><input type="text" name="insbankbrch"  size="65" value="<? print $rs->fields['insbankbrch'];?>" /></td>

            </tr>

            <tr>

                <td>No. Akaun Bank : </td>

                <td colspan="2"><input type="text" name="insakaun"  size="65" value="<? print $rs->fields['insakaun'];?>" /></td>

            </tr>

            <tr>

                <td colspan="4" class="title" height="30">C.&nbsp;&nbsp;&nbsp;MAKLUMAT PEKERJAAN</td>

            </tr>

            <tr>

                <td colspan="4">

                	<table width="100%" cellpadding="3" cellspacing="0" border="0">

                    	<tr class="title" >

                        	<td colspan="3">MAKLUMAT KELAYAKAN AKADEMIK</td>

                            <td colspan="3" align="right"><? $new_page = "modal_form.php?win=".base64_encode('penceramah/_akademik_form.php;');?>

				        	<input type="button" value="Tambah Maklumat Akademik" style="cursor:pointer" 

            				<?php if(empty($id)) { print "onclick=\"alert('Sila tekan SIMPAN dahulu sebelum menambah maklumat akademik!')\""; } 

							else { print "onclick=\"open_modal('".$new_page."','Penambahan Maklumat Akademik',800,450)\""; } ?> /> &nbsp;&nbsp;</td>

						</tr>

                </table>

                <table width="100%" cellpadding="3" cellspacing="0" border="1">

                    	<tr class="title" >

	                       	<td width="5%">Bil</td>

                            <td width="25%">Kelulusan Akademik</td>

                            <td width="25%">Nama Kursus</td>

                            <td width="25%">Institusi Pengajian</td>

                            <td width="10%">Tahun</td>

                            <td width="10%">&nbsp;</td>

                        </tr>

                        <?php 	if(!empty($id)) {

								$_SESSION['ingenid'] = $id;

								$sSQL2="SELECT * FROM _tbl_instructor_akademik WHERE ingenid = ".tosql($id,"Text");

								$sSQL2 .= "ORDER BY inaka_tahun DESC";

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

                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">

                            <td valign="top" align="right"><?=$bil;?>.</td>

            				<td valign="top" align="left"><?=dlookup("_ref_akademik", "f_akademik_nama", " f_akademik_id = ".$rs2->fields['inaka_sijil'])?>&nbsp;</td>

            				<td valign="top" align="left"><?=$rs2->fields['inaka_kursus']?>&nbsp;</td>

            				<td valign="top" align="left"><?=$rs2->fields['inaka_institusi']?>&nbsp;</td>

                            <td valign="top" align="center"><?=$rs2->fields['inaka_tahun']?>&nbsp;</td>

                            <td align="center">

	                            <?php if(!empty($rs2->fields['fld_image'])){ ?>

                                <img src="../images/btn_certificates_bg.gif" width="30" height="30" style="cursor:pointer" title="Sila klik paparan sijil akademik" 

                                onclick="open_modal('<?=$href_img;?>','Kemaskini Maklumat Akademik',800,450)" />

                                <?php } ?>

                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 

                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Akademik',800,450)" />

                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data" 

                                onclick="open_modal('<?=$del_href_link;?>','Padam Maklumat Akademik',700,300)" />

                            </td>

                        </tr>

                        <?

                        $cnt = $cnt + 1;

                        $bil = $bil + 1;

                        $rs2->movenext();

                    } 

                } else {

                ?>

                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>

                <? } } ?> 

                    </table>

                </td>

            </tr>

            <tr>

                <td colspan="4">

                	<table width="100%" cellpadding="1" cellspacing="0" border="0">

                    	<tr class="title" >

                        	<td colspan="3">MAKLUMAT BIDANG KEPAKARAN</td>

                            <td colspan="3" align="right"><? $new_page = "modal_form.php?win=".base64_encode('penceramah/_kepakaran_form.php;');?>

        						<input type="button" value="Tambah Bidang Kepakaran" style="cursor:pointer" 

            					<?php if(empty($id)) { print "onclick=\"alert('Sila tekan SIMPAN dahulu sebelum menambah bidang kepakaran!')\""; }

									else { print "onclick=\"open_modal('".$new_page."','Penambahan Maklumat Kepakaran',700,400)\""; } ?> /> &nbsp;&nbsp;</td>

						</tr>

                     </table>

                     <table width="100%" cellpadding="3" cellspacing="0" border="1">

                    	<tr class="title" >

                        	<td width="5%">Bil</td>

                            <td width="40%">Bidang Kepakaran</td>

                            <td width="45%">Pengkhususan</td>

                            <td width="10%">&nbsp;</td>

                        </tr>

                        <?php 
						
								if(!empty($id)) {	

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

                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">

                            <td valign="top" align="right"><?=$bil;?>.</td>

            				<td valign="top" align="left"><?=dlookup("_ref_kepakaran", "f_pakar_nama", " f_pakar_code = ".$rs2->fields['inpakar_bidang'])?>&nbsp;</td>

            				<td valign="top" align="left"><?=$rs2->fields['inpakar_pengkhususan']?>&nbsp;</td>

            			    <td align="center">

                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 

                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Kepakaran',700,400)" />

                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data" onclick="open_modal('<?=$del_href_link;?>','Padam Maklumat Kepakaran',700,300)" />

                            </td>

                        </tr>

                        <?

                        $cnt = $cnt + 1;

                        $bil = $bil + 1;

                        $rs2->movenext();

                    } 

                } else {

                ?>

                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>

                <? } } ?> 

                   </table>

                </td>

            </tr>

            <tr>

                <td></td>

                <td><br>

                	<input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat penceramah" 

                    onClick="form_hantar('index.php?data=<? print base64_encode('user;penceramah/penceramah_form_do.php;penceramah;daftar')?>')">

                	<? if(!empty($id)){ 
					
					$_SESSION['ingenid'] = $id;
					
					$claim_link = "index.php?data=".base64_encode('user;penceramah/claim_list.php;penceramah;daftar;'.$rs->fields['ingenid']);
					
					?>
                    
                    <input type="button" value="Hapus" class="button_disp" title="Sila klik untuk hapus maklumat penceramah" 

                    onClick="form_hapus('index.php?data=<? print base64_encode('user;penceramah/penceramah_form_do.php;penceramah;daftar')?>')">
                    
                    <input type="button" value="Claim" class="button_disp" title="Sila klik untuk edit maklumat claim penceramah" 

                    onClick="document.location='<? print $claim_link; ?>'">

                    <? } ?>

                	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk ke senarai penceramah" 

                    onClick="do_back('index.php?data=<? print base64_encode('user;penceramah/penceramah_list.php;penceramah;daftar');?>')">

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

	document.ilim.insid.focus();

</script>