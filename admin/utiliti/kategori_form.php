<script language="javascript">
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
</script>
<?php
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";
$actions = "INSERT";
if(!empty($id)){
	$sql = "SELECT * FROM kod_kategori WHERE id_kategori=".tosql($id,"Number");
	$rs = &$conn->Execute($sql);
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	//$row = mysql_fetch_array($result, MYSQL_BOTH);
	$actions = "UPDATE";
	$title = "Kemaskini Maklumat Kategori";
} else {
	$title = "Tambah Maklumat Kategori";
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
                            <td width="20%" align="left">Kategori <div style="float:right">: </div>
                            <td width="80%" align="left">
                              <input name="nama_kategori" type="text" size="80" maxlength="80" 
                              value="<?php print $rs->fields['nama_kategori']?>" />    </td>
                          </tr>
                          <tr>
                            <td align="left">Status <div style="float:right">: </div>
                            <td align="left">
                            	<select name="status">
                                	<option value="0" <?php if($rs->fields['status']=='0'){ print 'selected'; }?>>Aktif</option>
                                	<option value="1" <?php if($rs->fields['status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                                </select>
                          </tr>
                          <tr><td>&nbsp;</td></tr>
                          <tr>
                            <td colspan="2" align="center"><input type="button" name="button" id="button" value="Simpan" 
                            onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/kategori_do.php;');?>')" />
                            <?php if(!empty($id)){ ?>  
                              <input type="button" name="button2" id="button" value="Hapus" 
                              onclick="do_hapus('index.php?data=<?=base64_encode('4;utiliti/kategori_do.php;');?>')" />
                            <?php } ?>
                              <input type="button" name="button3" id="button" value="Kembali" 
                              onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/kategori.php;');?>&PageNo=<?php print $PageNo?>')" />
                              <input type="hidden" name="id_kategori" value="<?php print $rs->fields['id_kategori']?>" />
                              <input type="hidden" name="actions" id="actions" value="<?php print $actions?>" />
                              <input type="hidden" name="PageNo" value="<?php print $PageNo?>" />
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
