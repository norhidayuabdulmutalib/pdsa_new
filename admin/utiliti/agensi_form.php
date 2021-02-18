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
<?
//$id = $_GET['id'];
$PageNo = $_GET['PageNo'];
$actions = "INSERT";
if(!empty($id)){
	$sql = "SELECT * FROM kod_agensi WHERE id_agensi=$id";
	$result = &$conn->Execute($sql);
	if(!$result){ echo "Invalid query : " . mysql_errno(); }
	$row = mysql_fetch_array($result, MYSQL_BOTH);
	$actions = "UPDATE";
	$title = "Kemaskini Maklumat Agensi";
} else {
	$title = "Tambah Maklumat Agensi";
}
?>
<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td>
<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
<table width="90%" border="0" cellspacing="1" cellpadding="5" align="center">
	<tr>
    	<td colspan="2" height="40">
        	<table width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="2%" height="40" align="left">&nbsp;</td>
                    <td width="96%" align="center"><h3><?=$title;?></h3></td>
                    <td width="2%" align="right">&nbsp;</td>
                </tr>
                <tr>
                	<td width="2%" height="40" align="left">&nbsp;</td>
                    <td width="96%">
                    	<table width="100%">
                          <tr>
                            <td width="20%">Nama Agensi :</td>
                            <td width="80%">
                              <input name="nama_agensi" type="text" size="50" maxlength="80" 
                              value="<?php echo $row['nama_agensi']?>" />    </td>
                          </tr>
                          <tr>
                            <td>Status :</td>
                            <td>
                            	<select name="status">
                                	<option value="0" <?php if($row['status']=='0'){ print 'selected'; }?>>Tidak Aktif</option>
                                	<option value="1" <?php if($row['status']=='1'){ print 'selected'; }?>>Aktif</option>
                                </select>
                            <!--<input name="status" type="text" size="15" maxlength="15" 
                            value="<?php echo $row['status']?>" />--></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td><input type="button" name="button" id="button" value="Simpan" 
                            onclick="do_submit('index.php?data=<?=base64_encode('utiliti/agensi_do.php;');?>')" />
                            <?php if(!empty($id)){ ?>  
                              <input type="button" name="button2" id="button2" value="Hapus" 
                              onclick="do_hapus('index.php?data=<?=base64_encode('utiliti/agensi_do.php;');?>')" />
                            <?php } ?>
                              <input type="button" name="button3" id="button3" value="Kembali" 
                              onclick="do_submit('index.php?data=<?=base64_encode('utiliti/agensi.php;');?>&PageNo=<?php echo $PageNo?>')" />
                              <input type="hidden" name="id_agensi" value="<?php echo $row['id_agensi']?>" />
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
