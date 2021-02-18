<link rel="stylesheet" href="modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="modalwindow/dhtmlwindow.js">

/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<script type="text/javascript" src="modalwindow/modal.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script>
	// Remove advanced tabs for all editors.
	CKEDITOR.config.removeDialogTabs = 'image:advanced;link:advanced;flash:advanced;creatediv:advanced;editdiv:advanced';
</script>
<script language="javascript" type="text/javascript">
function open_win(URL,type){
	var id = document.frm.doc_id.value;
	URL = URL + '?id=' + id + '&type=' + type;
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Maklumat Rujukan Tambahan', 'width=750px,height=500px,center=1,resize=0,scrolling=1')
} //End "opennewsletter" function
</script>
<script language="javascript">
function do_submit(URL){
	if(document.frm.dokumen_tajuk.value==''){
		alert("Sila masukkan tajuk dokumen rujukan.");
		document.frm.dokumen_tajuk.focus();
	/*} else if(document.frm.dokumen.value==''){
		alert("Sila masukkan maklumat rujukan.");
		document.frm.dokumen.focus();*/
	} else {
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
}

function do_back(URL){
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
</script>
<?php
$sql_user = "SELECT * FROM tbl_menu_user WHERE menu_id=18 AND id_kakitangan=".tosql($idk,"Number");
$rs_usermenu = &$conn->execute($sql_user);
if($rs_usermenu->EOF){
	print 'Anda tidak boleh menggunakan menu ini'; exit;
} else {
	$is_add = $rs_usermenu->fields['is_add'];
	$is_upd = $rs_usermenu->fields['is_upd'];
	$is_del = $rs_usermenu->fields['is_del'];
}
/*
$dir='';
$pathtoscript='/editor/';
include_once($dir."editor/config.inc.php");
include_once($dir."editor/FCKeditor/fckeditor.php") ;
*/

//$id = $_GET['id'];
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";
$actions = "INSERT";
if(!empty($id)){
	$sql = "SELECT * FROM doc_rujukan WHERE doc_id=".tosql($id,"Text");
	$result = &$conn->Execute($sql);
	$actions = "UPDATE";
	$title = "Kemaskini Maklumat Dokumen Rujukan";
} else {
	$title = "Tambah Maklumat Dokumen Rujukan";
}
?>
<table width="100%" cellpadding="0" cellspacing="0" align="center">
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
                            <td width="20%" valign="top" align="left">Nama Dokumen <div style="float:right">: </div></td>
                            <td width="80%" align="left">
                            	<textarea name="dokumen_tajuk" rows="2" cols="70" style="width:98%"><?php echo $result->fields['dokumen_tajuk']?></textarea>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><br />
                            	Maklumat Dokuman <div style="float:right">: </div><br /><br />
                                <i style="font-size:11px">
                                <img src="img/copy_word.png" />&nbsp;Sila gunakan ikon ini jika dokumen disalin daripada Microsoft Word.<br /><br />
                                <img src="img/create_table.png" />&nbsp;Sila gunakan ikon ini untuk mewujudkan table di dalam laporan.
                                </i>
                            </td>
                            <td align="left">
                                <textarea name="dokumen" cols="50" rows="10" id="story" style="width:100%"><?=$result->fields['dokumen']?></textarea>
                            </td>
                          </tr>
			
						  <?php if(!empty($id)){ ?> 
                          <tr>
                            <td align="left"></td>
                            <td align="left">
                            	<table width="100%" cellpadding="4" cellspacing="1" border="0" bgcolor="#000000">
                                <b>Sila klik pada ikon <img src="img/boxin2.gif" border="0" width="25" height="25" /> untuk muatnaik dokumen lampiran.</b>
                                	<tr bgcolor="#CCCCCC" align="center">
                                    	<td width="5%">Bil</td>
                                        <td width="40%">Tajuk</td>
                                        <td width="40%">Nama Dokumen</td>
                                        <td width="10%">Jenis</td>
                                        <td width="5%">&nbsp;</td>
                                    </tr>
                                <?php 
									$sql_doc = "SELECT * FROM tbl_attachment WHERE soalan_id=".tosql($id,"Text");
									$rs_doc = &$conn->Execute($sql_doc);
									$bil = 0;
									while(!$rs_doc->EOF){
									$bil++;
								?>    
                                	<tr bgcolor="#FFFFFF">
                                    	<td width="5%" align="right"><?=$bil;?>.&nbsp;</td>
                                        <td width="40%"><?php print $rs_doc->fields['file_tajuk'];?></td>
                                        <td width="40%"><a href="doc/<?php print $rs_doc->fields['file_name'];?>" target="_blank"><?php print $rs_doc->fields['file_name'];?></a></td>
                                        <td width="10%" align="center"><?php print $rs_doc->fields['file_type'];?></td>
                                        <td width="5%" align="center">
                                        	<!--<img src="img/edit.png" border="0" onclick="open_win('doc/upload_doc.php','JAW')" style="cursor:pointer" />-->
                                        	<img src="img/del.gif" border="0" height="25" width="25" 
                                            onclick="open_win('doc/del_doc.php','<?=$rs_doc->fields['attach_id'];?>')" style="cursor:pointer" />
                                        </td>
                                    </tr>
                                <?php $rs_doc->movenext(); } ?>
                                	<tr bgcolor="#FFFFFF">
                                    	<td width="5%">-</td>
                                        <td width="40%">-</td>
                                        <td width="40%">-</td>
                                        <td width="10%">-</td>
                                        <td width="5%" align="center">
                                        	<img src="img/boxin2.gif" border="0" width="25" height="25" onclick="open_win('doc/upload_doc.php','DOC')" style="cursor:pointer" /></td>
                                    </tr>
                                    
                                </table>
                            </td>
                          </tr>
						  <?php } ?>
                          <!--<tr>
                            <td align="left">Muat Naik Dokumen Rujukan <div style="float:right">: </div></td>
                            <td align="left">
                            	<input type="file" name="file_name" />
                          </tr>-->
                          <tr>
                            <td align="left">Status Paparan <div style="float:right">: </div></td>
                            <td align="left">
                            	<select name="is_doc">
                                	<option value="0" <?php if($result->fields['is_doc']=='0'){ print 'selected'; }?>></option>
                                	<option value="1" <?php if($result->fields['is_doc']=='1'){ print 'selected'; }?>>Dokumen sahaja</option>
                                </select>
                          </tr>
                          <tr>
                            <td align="left">Status Dokumen <div style="float:right">: </div></td>
                            <td align="left">
                            	<select name="doc_status">
                                	<option value="0" <?php if($result->fields['doc_status']=='0'){ print 'selected'; }?>>Aktif</option>
                                	<option value="1" <?php if($result->fields['doc_status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                                </select>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>
                            <?php if($is_add==1 || $is_upd==1){ ?>
                            <input type="button" name="button" id="button" value="Simpan" 
                            onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/doc_rujukan_do.php;');?>')" />
                            <?php } ?>
                            <?php if(!empty($id) && $is_del==1){ ?>  
                              <input type="button" name="button2" id="button" value="Hapus" 
                              onclick="do_hapus('index.php?data=<?=base64_encode('4;utiliti/doc_rujukan_do.php;');?>')" />
                            <?php } ?>
                              <input type="button" name="button3" id="button" value="Kembali" 
                              onclick="do_back('index.php?data=<?=base64_encode('4;utiliti/doc_rujukan.php;');?>&PageNo=<?php echo $PageNo?>')" />
                              <input type="hidden" name="doc_id" value="<?php echo $result->fields['doc_id']?>" />
                              <input type="hidden" name="actions" id="actions" value="<?php echo $actions?>" />
                              <input type="hidden" name="PageNo" value="<?php echo $PageNo?>" />
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
</form>
</td></tr></table>
<script language="javascript" type="text/javascript">
	document.frm.dokumen_tajuk.focus();
</script>
<script>
	CKEDITOR.replace('dokumen', {height: 500});
</script>
