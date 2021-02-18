<script language="javascript">
function do_simpan(URL){
	var pass = document.ilim.new_pass.value;
	var pass1 = document.ilim.new_pass1.value;
	if(pass!=pass1){
		alert("Sila pastikan maklumat 'Katalaluan Baru' sama dengan 'Ulang Katalaluan Baru'");
		document.ilim.new_pass.value='';
		document.ilim.new_pass1.value = '';
		document.ilim.new_pass.focus();
	} else {
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
}
function do_submit(URL){
	document.ilim.action = URL;
	document.ilim.target = '_self';
	document.ilim.submit();
}
</script>
<?php
//$conn->debug=true;
$id = $_SESSION["s_userid"];
$sql = "SELECT * FROM _tbl_user WHERE id_user=".tosql($id);
$result = &$conn->query($sql);
//if(!$result){ echo "Invalid query : " . mysql_errno(); }
//$row = mysql_fetch_array($result, MYSQL_BOTH);
$title = "Tukar Katalaluan";
?>
<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td>
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
                    	<table width="89%" align="center">
                          <tr>
                            <td width="25%" align="left">Nama Kakitangan <div style="float:right">: </div></td>
                            <td width="75%" align="left"><?php echo $result->fields['f_name']?></td>
                          </tr>
                          <tr>
                            <td align="left">ID Kakitangan <div style="float:right">: </div></td>
                            <td align="left"><?php echo $result->fields['f_userid']?></td>
                          </tr>
                          <!--<tr>
                            <td align="left">Katalaluan Lama <div style="float:right">: </div></td>
                            <td align="left">
                              <input name="old_pass" type="text" size="50" maxlength="80" value="" /></td>
                          </tr>-->
                          <tr>
                            <td align="left">Katalaluan Baru <div style="float:right">: </div></td>
                            <td align="left">
                              <input name="new_pass" type="text" size="30" maxlength="20" value="" /></td>
                          </tr>
                          <tr>
                            <td align="left">Ulang Katalaluan Baru <div style="float:right">: </div></td>
                            <td align="left">
                              <input name="new_pass1" type="text" size="30" maxlength="20" value="" /></td>
                          </tr>
                          <tr>
                            <td align="center">&nbsp;</td>
                            <td align="left">
                            	<input type="button" name="button" id="button" value="Kemaskini" 
                            	onclick="do_simpan('index.php?data=<?php print base64_encode(';utiliti/kakitangan_pass_upd_do.php;');?>')" />
                              	<input type="button" name="button3" id="button" value="Kembali" 
                              	onclick="do_submit('index.php?data=MTtkZWZhdWx0O21haW47Ow==')" />
                              	<input type="hidden" name="id_unit" value="<?php echo $result->fields['id_unit']?>" />
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
<script language="javascript" type="text/javascript">
	document.ilim.new_pass.focus();
</script>
