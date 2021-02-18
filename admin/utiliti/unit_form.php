<script language="javascript">
function do_simpan(URL){
	if(document.frm.nama_unit.value==''){
		alert("Sila masukkan nama unit");
		document.frm.nama_unit.focus();
	}else if(document.frm.id_bahagian.value==''){
		alert("Sila pilih nama bahagian");
		document.frm.id_bahagian.focus();
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
</script>
<?php
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";
$actions = "INSERT";
if(!empty($id)){
	$sql = "SELECT * FROM kod_unit WHERE id_unit=".tosql($id,"Number");
	$result = &$conn->Execute($sql);
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	//$row = mysql_fetch_array($result, MYSQL_BOTH);
	$actions = "UPDATE";
	$title = "Kemaskini Maklumat Unit";
} else {
	$title = "Tambah Maklumat Unit";
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
                          	<?	$sql_b = "SELECT * FROM kod_bahagian WHERE status=0";
						  		$rs_b = &$conn->Execute($sql_b);
							?>
                          <tr>
                            <td width="20%" align="left">Bahagian : </td>
                            <td width="80%" align="left">
                            	<select name="id_bahagian">
                                	<option value=""> -- Sila pilih bahagian -- </option>
                                    <?php while(!$rs_b->EOF){ ?>
                                    <option value="<?=$rs_b->fields['id_bahagian'];?>" <?php if($rs_b->fields['id_bahagian']==$result->fields['id_bahagian']){ print 'selected'; } ?>><?php print $rs_b->fields['nama_bahagian'];?></option>
                                    <?php $rs_b->movenext(); } ?>
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <td width="20%" align="left">Nama Unit <div style="float:right">: </div>
                            <td width="80%" align="left">
                              <input name="nama_unit" type="text" size="50" maxlength="80" 
                              value="<?php echo $result->fields['nama_unit']?>" />    </td>
                          </tr>
                          <tr>
                            <td align="left">Status <div style="float:right">: </div>
                            <td align="left">
                            	<select name="status_unit">
                                	<!--<option value="">-- Sila pilih --</option>-->
                                	<option value="0" <?php if($result->fields['status_unit']=='0'){ print 'selected'; }?>>Aktif</option>
                                	<option value="1" <?php if($result->fields['status_unit']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                                </select>
                             </td>
                          </tr>
                          <tr><td>&nbsp;</td></tr>
                          <tr>
                            <td colspan="2" align="center"><input type="button" name="button" id="button" value="Simpan" 
                            onclick="do_simpan('index.php?data=<?=base64_encode('4;utiliti/unit_do.php;');?>')" style="cursor:pointer" />
                            <?php if(!empty($id)){ ?>  
                              <input type="button" name="button2" id="button" value="Hapus" 
                              onclick="do_hapus('index.php?data=<?=base64_encode('4;utiliti/unit_do.php;');?>')" style="cursor:pointer" />
                            <?php } ?>
                              <input type="button" name="button3" id="button" value="Kembali" 
                              onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/unit.php;');?>&PageNo=<?php echo $PageNo?>')" style="cursor:pointer" />
                              <input type="hidden" name="id_unit" value="<?php echo $result->fields['id_unit']?>" />
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
</td></tr></table>
