<script language="javascript">
function do_simpan(URL){
	if(document.frm.nama_ap.value==''){
		alert("Sila masukkan nama ahli parlimen.");
		document.frm.nama_ap.focus();
	} else if(document.frm.kawasan_ap.value==''){
		alert("Sila masukkan maklumat lantikan.");
		document.frm.kawasan_ap.focus();
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
function do_goback(URL){
	
		document.frm.actions.value = 'DELETE';
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
}

</script>
<?php
//$url = (isset($_SESSION['referer']))? $_SESSION['referer'] : 'index';
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";
$actions = "INSERT";
if(!empty($id)){
	$sql = "SELECT * FROM ahliparlimen WHERE id_ap=".tosql($id,"Number");
	$rs = &$conn->Execute($sql);
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	//$row = mysql_fetch_array($result, MYSQL_BOTH);
	$actions = "UPDATE";
	$title = "Kemaskini Maklumat Ahli Dewan Negara";
} else {
	$title = "Tambah Maklumat Ahli Dewan Negara";
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
                          <tr>
                            <td width="20%" align="left">Nama Ahli Dewan <div style="float:right">: </div></td>
                            <td width="80%" align="left">
                              <input name="nama_ap" type="text" size="70" maxlength="120" 
                              value="<?php print $rs->fields['nama_ap']?>" />    </td>
                          </tr>
                          <tr>
                            <td width="20%" align="left">Lantikan <div style="float:right">: </div></td>
                            <td width="80%" align="left">
                              <input name="kawasan_ap" type="text" size="70" maxlength="120" 
                              value="<?php print $rs->fields['kawasan_ap']?>" />    </td>
                          </tr>
                          <tr>
                            <td width="20%" align="left">Parti <div style="float:right">: </div></td>
                            <td width="80%" align="left">
                              <input name="parti" type="text" size="20" maxlength="20" 
                              value="<?php print $rs->fields['parti']?>" />    </td>
                          </tr>
                            <tr>
                              <td align="left">Tempoh <div style="float:right">: </div></td>
                              <td align="left"><input name="tempoh" type="text" id="tempoh" 
                              value="<?php print $rs->fields['tempoh']?>" size="70" maxlength="100" /></td>
                            </tr>
                            <tr> 
                                <td align="left">Gambar <div style="float:right">: </div></td>
                                <td align="left">
                                    <INPUT TYPE="file" NAME="binFile" size="50" class="TableBtnBlue">
                                    <input type="hidden" name="old_file" value="<?=$images;?>" readonly="" />                                </td>
                            </tr>
                            <tr> 
                                <td align="left">&nbsp;</td>
                                <td align="left" valign="top">
                                    <span id="ImgViewBoarder"><span id="ImgView">
                                    </span></span>
                                    <?php if(!empty($rs->fields['gambar'])){ ?>
	                                    <img src="gambar_ad/<?=$rs->fields['gambar'];?>" height="140" width="120" style="cursor:pointer" border="1">
                                    <?php } else { ?>
	                                    <img src="img/blank_person.jpg" height="140" width="120" style="cursor:pointer" border="1">
                                    <?php } ?>
                                    <br>                                </td>
                            </tr>
                          <!--<tr>
                            <td>Kawasan <div style="float:right">: </div></td>
                            <td><input name="kawasan_ap" type="text" size="70" maxlength="120" 
                            value="<?php print $rs->fields['kawasan_ap']?>" /></td>
                          </tr>-->
                          <tr>
                            <td align="left">Status <div style="float:right">: </div></td>
                            <td align="left"><select name="status_ap" id="status_ap">
                              <option value="0" <?php if($rs->fields['status_ap']=='0'){ echo 'selected'; }?> >Aktif</option>
                              <option value="1" <?php if($rs->fields['status_ap']=='1'){ echo 'selected'; }?>>Tidak Aktif</option>
                            </select>    </td>
                          </tr>
                          <tr>
                            <td colspan="2" align="center">
                            <!--
                            <input type="button" name="button" id="button" value="Simpan" 
                            onclick="do_simpan('index.php?data=<?=base64_encode('4;utiliti/adewan_do.php;');?>')" />
                            <?php if(!empty($id)){ ?>  
                              <input type="button" name="button2" id="button" value="Hapus" 
                              onclick="do_hapus('index.php?data=<?=base64_encode('4;utiliti/adewan_do.php;');?>')" />
                            <?php } ?>
                            -->
                              <input type="button" name="button3" id="button" value="Kembali" 
                              onclick="do_goback('index.php?data=<?=base64_encode('4;utiliti/ad_ta.php;');?>')" />
                              <input type="hidden" name="id_ap" value="<?php print $rs->fields['id_ap']?>" />
                              <input type="hidden" name="actions" id="actions" value="<?php print $actions?>" />
                              <input type="hidden" name="PageNo" value="<?php print $PageNo?>" />
                              <input type="hidden" name="type" value="AP" />                            </td>
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
