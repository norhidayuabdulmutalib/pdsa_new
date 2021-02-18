<link type="text/css" rel="stylesheet" href="cal/dhtmlgoodies_calendar.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="cal/dhtmlgoodies_calendar.js"></script>
<Script Language='JavaScript1.2' src='include/RemoteScriptServer.js'></Script>
<script src="scripts/jquery.min.js"></script>
<Script Language='JavaScript' src='scripts/jquery.validate.min.js'></Script>

<script language="javascript">
function do_simpan(URL){
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
}

function do_submit(URL){
	document.frm.action = URL;
	document.frm.target = '_self';
	document.frm.submit();
}

function do_hapus(URL){
	if(document.frm.tamat.value==''){
		alert("Sila masukkan tarikh tamat perkhidmatan");
		document.frm.tamat.focus(); 
	} else if(confirm("Adakah anda pasti?")){
		document.frm.actions.value = 'DELETE';
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
$.validator.addMethod(
    "valDate",
    function(value, element) {
        // put your own logic here, this is just a (crappy) example
        return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
    },
    "Please enter a date in the format dd/mm/yyyy."
);

$('#frm').validate({
		rules : {
			"nama_ap" 	: "required",
			"kod_kaw_ap" 	: "required",
			"mula" 	: {
				required	: true,
				date		: false,
				valDate		: true
			},
		},
			messages : {
				"nama_ap" : "Sila masukkan nama ahli parlimen.",
				"kod_kaw_ap" : "Sila pilih kawasan yang diwakili.",
				"mula"	: "Sila masukkan tarikh mula berkhidmat."
					},		
		
	});
								
});
	
</script>

<?php
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";
$actions = "INSERT";
if(!empty($id)){
	$sql = "SELECT * FROM ahliparlimen WHERE id_ap=".tosql($id,"Number");
	$result = &$conn->Execute($sql);
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	//$row = mysql_fetch_array($result, MYSQL_BOTH);
	$actions = "UPDATE";
	$title = "Kemaskini Maklumat Ahli Dewan Rakyat";
} else {
	$title = "Tambah Maklumat Ahli Dewan Rakyat";
}
?>
<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td>
<table width="90%" border="0" cellspacing="1" cellpadding="5" align="center">
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
                          <?php $sel_p = "SELECT * FROM kod_parlimen WHERE p_status=0 ORDER BY p_kod ";
						  	$rs_kp = &$conn->Execute($sel_p); ?>
                          <tr>
                            <td align="left">Kawasan <div style="float:right">: </div></td>
                            <td align="left">
                            	<select name="kod_kaw_ap">
                                	<option value="">-- Sila pilih --</option>
                                    <?php while (!$rs_kp->EOF){ ?>
                                    <option value="<?=$rs_kp->fields['p_kod'];?>" <?php if($rs_kp->fields['p_kod']==$result->fields['kod_kaw_ap']){ print 'selected';} ?>
                                    ><?php print "". $rs_kp->fields['p_kod'] ." - " .$rs_kp->fields['p_nama'];?></option>
                                    <?php $rs_kp->movenext(); } ?>
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <td width="20%" align="left">Nama <div style="float:right">: </div></td>
                            <td width="80%" align="left">
                              <input name="nama_ap" type="text" size="70" maxlength="120" 
                              value="<?php echo $result->fields['nama_ap']?>" />    </td>
                          </tr>
                            <tr> 
                                <td align="left">Gambar <div style="float:right">: </div></td>
                                <td align="left">
                                    <INPUT TYPE="file" NAME="binFile" size="50" class="TableBtnBlue">
                                    <input type="hidden" name="old_file" value="<?=$images;?>" readonly="" />
                                </td>
                            </tr>
                            <tr> 
                                <td align="left">&nbsp;</td>
                                <td align="left" valign="top">
                                    <span id="ImgViewBoarder"><span id="ImgView">
                                    </span></span> 
                                    <?php if(!empty($result->fields['gambar'])){ ?>
	                                    <img src="gambar_ap/<?=$result->fields['gambar'];?>" height="140" width="120" style="cursor:pointer" border="1">
                                    <?php } else { ?>
	                                    <img src="img/blank_person.jpg" height="140" width="120" style="cursor:pointer" border="1">
                                    <?php } ?>
                                    <br>
                                </td>
                            </tr>
                          <!--<tr>
                            <td>Kawasan <div style="float:right">: </div></td>
                            <td><input name="kawasan_ap" type="text" size="70" maxlength="120" 
                            value="<?php echo $result->fields['kawasan_ap']?>" /></td>
                          </tr>-->
            				<tr>
                            <td align="left">Tarikh Mula <div style="float:right">: </div></td>
                            <td width="75%" align="left"><input name="mula" id="mula" type="text" size="10" maxlength="10" onclick="displayCalendar(document.forms[0].mula,'dd/mm/yyyy',this)" value="<?php echo displaydate($result->fields['tkh_mula'])?>"/>
                             <img src="cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                             onclick="displayCalendar(document.forms[0].mula,'dd/mm/yyyy',this)"/></td><tr></tr>
                             <td align="left">Tarikh Tamat <div style="float:right">: </div></td>
                            <td width="75%" align="left"><input name="tamat" id="tamat" type="text" size="10" maxlength="10" onclick="displayCalendar(document.forms[0].tamat,'dd/mm/yyyy',this)" value="<?php echo displaydate($result->fields['tkh_tamat'])?>"/>
                             <img src="cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                             onclick="displayCalendar(document.forms[0].tamat,'dd/mm/yyyy',this)"/></td>
                           </tr>
                          <tr>
                            <td align="left">Status <div style="float:right">: </div></td>
                            <td align="left"><select name="status_ap" id="status_ap">
                              <option value="0" <?php if($result->fields['status_ap']=='0'){ echo 'selected'; }?> >Aktif</option>
                              <option value="1" <?php if($result->fields['status_ap']=='1'){ echo 'selected'; }?>>Tidak Aktif</option>
                            </select>    </td>
                          </tr>
                          <tr>
                            <td colspan="2" align="center">
                           <!-- <input type="button" name="button" id="button" value="Simpan" 
                            	onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/ap_do.php;');?>')" />
                            <?php if(!empty($id)){ ?>  
                              <input type="button" name="button2" id="button" value="Hapus" 
                              onclick="do_hapus('index.php?data=<?=base64_encode('4;utiliti/ap_do.php;');?>')" />
                            <?php } ?>-->
                              <input type="button" name="button3" id="button" value="Kembali" 
                              onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/ap_ta.php;');?>&PageNo=<?php echo $PageNo?>')" />
                              <input type="hidden" name="id_ap" value="<?php echo $result->fields['id_ap']?>" />
                              <input type="hidden" name="actions" id="actions" value="<?php echo $actions?>" />
                              <input type="hidden" name="PageNo" value="<?php echo $PageNo?>" />
                              <input type="hidden" name="type" value="AP" />
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
