<!--<Script Language='JavaScript1.2' src='include/RemoteScriptServer.js'></Script>-->
<Script Language='JavaScript1.2' src='scripts/jquery.min.js'></Script>
<Script Language='JavaScript1.2' src='scripts/jquery.validate.min.js'></Script>

<script src="scripts/jquery.min.js"></script>
<Script Language='JavaScript' src='scripts/jquery.validate.min.js'></Script>
<script language="javascript">
function do_simpan1(URL){
	if(document.frm.nama_kakitangan.value==''){
		alert("Sila masukkan nama kakitangan");
		document.frm.nama_kakitangan.focus();
	} else if(document.frm.no_kp_kakitangan.value==''){
		alert("Sila masukkan nombor kad pengenalan kakitangan");
		document.frm.no_kp_kakitangan.focus();
//	} else if(document.frm.jawatan_kakitangan.value==''){
//		alert("Sila masukkan jawatan yang disandang");
//		document.frm.jawatan_kakitangan.focus();
//	} else if(document.frm.bahagian.value==''){
//		alert("Sila pilih bahagian");
//		document.frm.bahagian.focus();
	} else {
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
}
function do_submit(URL){
	document.frm.action = URL;
	document.frm.target = '_self';
	document.frm.submit();
}

function do_hapus(URL){
	if(confirm("Adakah anda pasti?")){
		document.frm.actions.value = 'DELETE';
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
}

function do_aktif(URL){
	if(confirm("Adakah anda pasti?")){
		document.frm.actions.value = 'AKTIF';
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
}

function SelectData(){
	SelectUnit('do_selunitnama.php');
	//SelectNama('do_selnama.php');
}
function SelectUnit(strFileName){
	var idbhg = document.frm.bahagian.value; 
	var URL = strFileName + '?idbhg=' + idbhg;
	//alert(URL);
	//document.frm.action = URL;
	//document.frm.target = '_blank';
	//document.frm.submit();
	callToServer(URL);
}

/***************************************
 *** To get value from remote server ***
 *** and place them to listbox       ***
 ***************************************/
function handleResponse(ID,Data,lst){
	strID = new String(ID);
	strData = new String(Data);
	if(strID == ''){
		document.frm.elements[lst].length = 0;
		document.frm.elements[lst].options[0]= new Option('Pilih','');
	}else{
		splitID = strID.split(",");
		splitData = strData.split(",");
		document.frm.elements[lst].options[0]= new Option('Pilih','');
		for(i=1;i<=splitID.length;i++){
			document.frm.elements[lst].options[i]= new Option(splitData[i-1],splitID[i-1]);
		}
		document.frm.elements[lst].length = splitID.length + 1;
	}
}

function kakitangan(){
	var userId = document.frm.no_kp_kakitangan.value; 
	if (userId !="" && document.frm.id_kakitangan.value==''){
	var URL = 'do_selkakitangan.php' + '?userId=' + userId;
	//alert(URL);
	//document.frm.action = URL;
	//document.frm.target = '_blank';
	//document.frm.submit();
	callToServer(URL);
	}
}

function handleResponse2(Data){
	strData = new String(Data);
	if(strData == ''){
//		alert("Maklumat Kakitangan Ada");
	}else{
		splitData = strData.split(",");
		id_kakitangan=splitData[0];
		alert('Maklumat '+splitData[1]+' telah terdapat dalam sistem');
		var URL = splitData[16];
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
}
</script>
<script>
$(document).ready(function(){
// jQuery(document).find("input").keyup(function() {
//		if (jQuery(this).attr('id') != "email") {
//			jQuery(this).val(jQuery(this).val().toUpperCase());
//			}
//});
$('#frm').validate({
		rules : {
			"nama_kakitangan" 	: "required",
			"no_kp_kakitangan" 	: {
				required 	: true,
				maxlength	: 12,
				minlength	: 12,
				number		: true
			},
			"jawatan_kakitangan"	: "required",
			"bahagian"				: "required",
		},
			messages : {
				"nama_kakitangan" : "Sila masukkan nama kakitangan",
				"no_kp_kakitangan" : "Sila masukkan nombor kad pengenalan kakitangan contoh '821010105182'",
				"jawatan_kakitangan"	: "Sila masukkan jawatan yang disandang",
				"bahagian"				: "Sila pilih bahagian"
					},		
		
	});
								
});
	
</script>
<?php
$gstatus = isset($_REQUEST['status'])?$_REQUEST['status']:"";
$gsort = isset($_REQUEST['sort'])?$_REQUEST['sort']:"";
$gbhg = isset($_REQUEST['bhg'])?$_REQUEST['bhg']:"";
$gcari = isset($_REQUEST['cari'])?$_REQUEST['cari']:"";

$PageNo = isset($_GET['PageNo'])?$_GET['PageNo']:"";
$actions = "INSERT";
if(!empty($id)){
	$sql = "SELECT * FROM kakitangan WHERE id_kakitangan=".tosql($id,"Number");
	$result = &$conn->Execute($sql);
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	//$row = mysql_fetch_array($result, MYSQL_BOTH);
	$actions = "UPDATE";
	$title = "Kemaskini Maklumat Kakitangan";
} else {
	$title = "Tambah Maklumat Kakitangan";
}
?>
<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td>
<table width="100%" border="0" cellspacing="1" cellpadding="5" align="center">
	<tr>
    	<td colspan="2" height="40">
        	<table width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="2%" height="40" align="left">&nbsp;</td>
                    <td width="96%" align="center"><h2><?=$title;?></h2></td>
                    <td width="2%" align="right">&nbsp;</td>
                </tr>
                <tr>
                	<td width="2%" height="40" align="left">&nbsp;</td>
                    <td width="96%">
                    	<table width="100%">
                          <tr>
                            <td align="left">No K/P <font color="#FF0000"><b>*</b></font> <div style="float:right">: </div></td>
                            <td align="left"><input name="no_kp_kakitangan" type="text" size="15" maxlength="15" 
                            	value="<?php print $result->fields['no_kp_kakitangan']?>" onBlur="kakitangan()" 
                            	<?php if(!empty($result->fields['no_kp_kakitangan'])){?> readonly="readonly"<?php } ?>/>
                            	<?php if($result->fields['is_delete']==1){ print '<font color="#FF0000">Untuk mengaktifkan maklumat kakitangan ini, Sila klik pada butang "Aktif Kembali"</font>'; }?>                            
							</td>
                          </tr>
                          <tr>
                            <td width="20%" align="left">Nama <font color="#FF0000"><b>*</b></font> <div style="float:right">: </div></td>
                            <td width="80%" align="left">
                              <input name="nama_kakitangan" id="nama_kakitangan" type="text" size="70" maxlength="80" style="width:80%" 
                              value="<?php print $result->fields['nama_kakitangan']?>" />    </td>
                          </tr>
                          <tr>
                            <td align="left">Jawatan <div style="float:right">: </div></td>
                            <td align="left"><input name="jawatan_kakitangan" type="text" size="70" maxlength="70" style="width:80%"
                            value="<?php print $result->fields['jawatan_kakitangan']?>" /></td>
                          </tr>
                          <?php
                          $sqlb = "SELECT * FROM kod_bahagian order by nama_bahagian";
                          $res_b = &$conn->Execute($sqlb);
                          ?>
                          <tr>
                            <td align="left">Bahagian <div style="float:right">: </div></td>
                            <td align="left">
                                <select name="bahagian" onChange="SelectData()" style="width:80%">
                                	<option value=""> -- Sila pilih bahagian -- </option>
                                <?php while(!$res_b->EOF){ ?>
                                    <option value="<?=$res_b->fields['id_bahagian']?>" <?php if($result->fields['id_bahagian']==$res_b->fields['id_bahagian']){ echo 'selected'; }?>><?=$res_b->fields['nama_bahagian'];?></option>
                                <?php $res_b->movenext(); } ?>
                                </select>
                            </td>
                          </tr>
                          <?
                          $sqlb = "SELECT * FROM kod_unit";
                          $res_b = &$conn->Execute($sqlb);
                          ?>
                          <tr>
                            <td align="left">Unit <div style="float:right">: </div></td>
                            <td align="left">
                                <select name="lstUnit" style="width:80%">
                                	<option value=""> -- Sila pilih unit -- </option>
                                <?php while(!$res_b->EOF){ ?>
                                    <option value="<?=$res_b->fields['id_unit']?>" <?php if($result->fields['id_unit']==$res_b->fields['id_unit']){ echo 'selected'; }?>><?=$res_b->fields['nama_unit'];?></option>
                                <?php $res_b->movenext(); } ?>
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Gred <div style="float:right">: </div></td>
                            <td align="left"><input name="gred" type="text" size="15" maxlength="10" value="<?php print $result->fields['gred']?>" /></td>
                          </tr>
                          <tr>
                            <td align="left">No. Telefon <div style="float:right">: </div></td>
                            <td align="left"><input name="no_telefon" type="text" size="15" maxlength="15" value="<?php print $result->fields['no_telefon']?>" />
                            </td>
                          </tr>
                          <tr>
                            <td align="left">No. Telefon Bimbit <div style="float:right">: </div></td>
                            <td align="left"><input name="no_hp" type="text" size="15" maxlength="15" value="<?php print $result->fields['no_hp']?>" />
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Email <div style="float:right">: </div></td>
                            <td align="left"><input name="email" type="text" size="70" maxlength="64" style="width:80%"
                            	value="<?php print $result->fields['email']?>" />
                            </td>
                          </tr>

                          <tr>
                            <td align="left">Status <div style="float:right">: </div></td>
                            <td align="left">
                            	<select name="status">
                                	<option value="0" <?php if($result->fields['status']=='0'){ print 'selected'; }?>>Aktif</option>
                                	<option value="1" <?php if($result->fields['status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                                </select>
                          </tr>
                        
                        <?php //if(!empty($_SESSION['session_status']) && $_SESSION['session_status']=='A'){ ?>
                          <!--tr>
                            <td align="left">Userid <div style="float:right">: </div></td>
                            <td align="left"><input name="userid" type="text" id="userid" size="15" maxlength="15" 
                            value="<?php print $result->fields['userid']?>" /></td>
                          </tr -->
                          <!--<tr>
                            <td align="left">Password <div style="float:right">: </div></td>
                            <td align="left"><input name="pass" type="password" id="pass" size="15" maxlength="15" 
                            value="<?php print $result->fields['pass']?>" /></td>
                          </tr>-->
                          <tr>
                            <td align="left">Status <div style="float:right">: </div></td>
                            <td align="left">
                            	<select name="type" id="type" style="width:80%">
                                    <option value="P" <?php if($result->fields['type']=='P'){ echo 'selected'; }?>>Pegawai Bertugas</option>
                                    <option value="U" <?php if($result->fields['type']=='U'){ echo 'selected'; }?> >Urusetia Parlimen</option>
                                    <option value="B" <?php if($result->fields['type']=='B'){ echo 'selected'; }?>>Pengguna Bahagian / Penyedia Jawapan</option>
                                    <option value="A" <?php if($result->fields['type']=='A'){ echo 'selected'; }?>>Administrator</option>
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Penyemak Jawapan  <div style="float:right">: </div></td>
                            <td align="left"><input type="checkbox" name="is_semak" <?php if($result->fields['is_semak']==1){ print 'checked="checked"'; } ?> /></td>
                          </tr>
                          <tr>
                            <td align="left">Pelulus Jawapan  <div style="float:right">: </div></td>
                            <td align="left"><input type="checkbox" name="is_lulus" <?php if($result->fields['is_lulus']==1){ print 'checked="checked"'; } ?> /></td>
                          </tr>
                        <?php //} ?>
                          <tr>
                            <td>&nbsp;</td>
                            <td>
                            <?php if($result->fields['is_delete']==0){ ?>
                            <input type="button" name="button" id="button" value="Simpan" onclick="do_simpan1('index.php?data=<?=base64_encode('4;utiliti/kakitangan_do.php;');?>')" />
                            <?php } ?>
							<?php if(!empty($id) && $result->fields['is_delete']==0){ ?>  
                              <input type="button" name="button2" id="button" value="Hapus" 
                              onclick="do_hapus('index.php?data=<?=base64_encode('4;utiliti/kakitangan_do.php;');?>')" />
                            <?php } ?>
                            <?php if(!empty($id) && $result->fields['is_delete']==1){ ?>  
                              <input type="button" name="button4" id="button" value="Aktifkan Kembali" 
                              onclick="do_aktif('index.php?data=<?=base64_encode('4;utiliti/kakitangan_do.php;');?>')" />
                            <?php } ?>
                            <?php if(!empty($id) && $result->fields['is_delete']==1){ ?>  
                              <input type="button" name="button3" id="button" value="Kembali" 
                              onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/kakitangan_ta.php;');?>&PageNo=<?php print $PageNo?>')" />			
                            <?php } else {?>
                              <input type="button" name="button3" id="button" value="Kembali" 
                              onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/kakitangan.php;');?>&PageNo=<?php print $PageNo?>')" />			
                              <?php } ?>
                              <input type="hidden" name="id_kakitangan" value="<?php print $result->fields['id_kakitangan']?>" />
                              <input type="hidden" name="actions" id="actions" value="<?php print $actions?>" />
                              <input type="hidden" name="PageNo" value="<?php print $PageNo?>" />
                              <input type="hidden" name="gstatus" value="<?php print $gstatus?>" />
                              <input type="hidden" name="gsort" value="<?php print $gsort?>" />
                              <input type="hidden" name="gbhg" value="<?php print $gbhg?>" />
                              <input type="hidden" name="gcari" value="<?php print $gcari?>" />
                              <input type="hidden" name="is_delete" value="" />
                            </td>
                          </tr>
                       </table>
                    </td>
                    <td width="2%" align="right" >&nbsp;</td>
                </tr>
            </table>
    	</td>
    </tr>
</table>
</td></tr></table>
