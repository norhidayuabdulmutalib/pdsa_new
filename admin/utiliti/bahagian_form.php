<script language="javascript">
function do_submit(URL){
	if(document.frm.nama_bahagian.value==''){
		alert("Sila masukkan nama bahagian.");
		document.frm.nama_bahagian.focus();
	} else if(document.frm.status.value==''){
		alert("Sila pilih status.");
		document.frm.status.focus();
	} else {
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
}

function do_hapus(URL){
	if(confirm("Adakah anda pasti?")){
		document.frm.actions.value = 'DELETE';
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
</script>
<?php
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";
$actions = "INSERT";
if(!empty($id)){
	$sql = "SELECT * FROM kod_bahagian WHERE id_bahagian=".tosql($id,"Number");
	$result = &$conn->Execute($sql);
	//echo $sql;
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	//$row = mysql_fetch_array($result, MYSQL_BOTH);
	$actions = "UPDATE";
	$title = "Kemaskini Maklumat Bahagian";
} else {
	$title = "Tambah Maklumat Bahagian";
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
                            <td width="20%" align="left">Kod Bahagian <div style="float:right">: </div>
                            <td width="80%" align="left">
                              <input name="kod_bahagian" type="text" size="50" maxlength="80" 
                              value="<?php echo $result->fields['kod_bahagian']?>" />    </td>
                          </tr>
                          <tr>
                            <td width="20%" align="left">Bahagian <div style="float:right">: </div>
                            <td width="80%" align="left">
                              <input name="nama_bahagian" type="text" size="50" maxlength="80" 
                              value="<?php echo $result->fields['nama_bahagian']?>" />    </td>
                          </tr>
                          <tr>
                            <td align="left">Status <div style="float:right">: </div>
                            <td align="left">
                            	<select name="status">
                                	<option value=""> -- Sila pilih -- </option>
                                	<option value="0" <?php if($result->fields['status']=='0'){ print 'selected'; }?>>Aktif</option>
                                	<option value="1" <?php if($result->fields['status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                                </select>
                             </td>
                          </tr>
                          <tr><td colspan="2"><hr /></td></tr>
                          <?
                          $sqlp = "SELECT * FROM kakitangan WHERE id_bahagian = ".tosql($result->fields['id_bahagian'],"Number")." ORDER BY nama_kakitangan";
                          $res_p = &$conn->Execute($sqlp);
                          ?>
                          <tr>
                            <td align="left">Nama Pegawai SUB <div style="float:right">: </div>
                            <td align="left">
                                <select name="lstPegawai">
                                <?php while(!$res_p->EOF){ ?>
                                    <option value="<?=$res_p->fields['id_kakitangan']?>" <?php if($result->fields['peg_id']==$res_p->fields['id_kakitangan']){ echo 'selected'; }?>>
									<?=$res_p->fields['nama_kakitangan'];?></option>
                                <?php $res_p->movenext(); } ?>
                                </select>
                            </td>
                          </tr>
                          <tr><td>&nbsp;</td></tr>
                          <tr>
                            <td colspan="2" align="center"><input type="button" name="button" id="button" value="Simpan" 
                            onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/bahagian_do.php;');?>')" />
                            <?php if(!empty($id)){ ?>  
                              <input type="button" name="button2" id="button" value="Hapus" 
                              onclick="do_hapus('index.php?data=<?=base64_encode('4;utiliti/bahagian_do.php;');?>')" />
                            <?php } ?>
                              <input type="button" name="button3" id="button" value="Kembali" 
                              onclick="do_back('index.php?data=<?=base64_encode('4;utiliti/bahagian.php;');?>&PageNo=<?php echo $PageNo?>')" />
                              <input type="hidden" name="id_bahagian" value="<?php echo $result->fields['id_bahagian']?>" />
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
