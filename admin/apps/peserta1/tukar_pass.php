<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(document.ilim.old_pass.value==''){
		alert("Sila masukkan katalaluan lama anda terlebih dahulu.");
		document.ilim.old_pass.focus();
		return true;
	} else if(document.ilim.new_pass.value==''){
		alert("Sila masukkan katalaluan baru anda.");
		document.ilim.new_pass.focus();
		return true;
	} else if(document.ilim.retype_pass.value==''){
		alert("Ulang semula katalaluan baru anda.");
		document.ilim.retype_pass.focus();
		return true;
	} else if(document.ilim.retype_pass.value != document.ilim.new_pass.value){
		alert("Sila pastikan katalaluan baru anda sama dengan katalaluan yang dimasukkan dalam ruangan ulang katalaluan.");
		document.ilim.new_pass.value='';
		document.ilim.retype_pass.value='';
		document.ilim.new_pass.focus();
		return true;
	} else {
		document.ilim.action = URL;
		document.ilim.submit();
	}
}
</script>
<br />
<form name="ilim" method="post">
<table width="80%" align="center" cellpadding="4" cellspacing="1" border="0">
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2" class="title" align="center" height="30">Penukaran Katalaluan Pengguna</td>
    </tr>
	<tr>
    	<td width="30%"><b>Nama : </b></td>
        <td width="70%"><?=$_SESSION["s_username"];?></td>
    </tr>
	<tr>
    	<td width="30%"><b>ID Anda : </b></td>
        <td width="70%"><?=$_SESSION["s_logid"];?></td>
    </tr>
	<tr>
    	<td><b>Katalaluan Lama : </b></td>
        <td><input type="text" name="old_pass" size="20" maxlength="15"></td>
    </tr>
	<tr>
    	<td><b>Katalaluan Baru : </b></td>
        <td><input type="text" name="new_pass" size="20" maxlength="15"></td>
    </tr>
	<tr>
    	<td><b>Ulang Katalaluan : </b></td>
        <td><input type="text" name="retype_pass" size="20" maxlength="15"></td>
    </tr>
	<tr>
    	<td></td>
        <td><br><input type="button" value="Hantar" class="button_disp" 
        onClick="form_hantar('index.php?data=<?php print base64_encode($userid.';apps/peserta/tukar_pass_do.php;peserta;pass;')?>')"></td>
    </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.old_pass.focus();
</script>
