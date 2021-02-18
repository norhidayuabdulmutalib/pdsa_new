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
		
		
		/*re = /^\w+$/; 
		if(!re.test(form.username.value)) { 
			alert("Error: Username must contain only letters, numbers and underscores!"); 
			form.username.focus(); 
			return false; 
		}*/ 
		
		if(document.ilim.new_pass.value != "" && document.ilim.new_pass.value == document.ilim.retype_pass.value) { 
			if(document.ilim.new_pass.value.length < 12 ) { 
				alert("Ralat: Katalaluan mestilah tidak kurang daripada 12 huruf dimana memerlukan kombinasi seperti contoh: P@22w0rd1t12"); 
				document.ilim.new_pass.focus(); 
				return false; 
			} 
			if(document.ilim.new_pass.value == document.ilim.username.value) { 
				alert("Ralat: Katalaluan mestilah tidak sama dengan ID pengguna!"); 
				document.ilim.new_pass.focus(); 
				return false; 
			} 
			
			re = /[0-9]/; 
			if(!re.test(document.ilim.new_pass.value)) { 
				alert("Ralat: Katalaluan mestilah mengandungi salah satu daripada nombor (0-9)!"); 
				document.ilim.new_pass.focus(); 
				return false; 
			} 
			
			re = /[a-z]/; 
			if(!re.test(document.ilim.new_pass.value)) { 
				alert("Ralat: katalaluan mestilah mengandungi sekurang-kurangnya 1 huruf kecil (a-z)!"); 
				document.ilim.new_pass.focus(); 
				return false; 
			} 
			
			re = /[A-Z]/; 
			if(!re.test(document.ilim.new_pass.value)) { 
				alert("Ralat: katalaluan mestilah mengandungi salah satu daripada huruf besar (A-Z)!"); 
				document.ilim.new_pass.focus(); 
				return false; 
			}
			 
			re = /[!@#$%^&*]/; 
			if(!re.test(document.ilim.new_pass.value)) { 
				alert("Ralat: katalaluan mestilah mengandungi salah satu daripada sombol ini (!@#$%^&*)!"); 
				document.ilim.new_pass.focus(); 
				return false; 
			} 

		} else { 
			alert("Ralat: Please check that you've entered and confirmed your password!"); 
			document.ilim.new_pass.focus(); 
			return false; 
		}
		
		
		if(confirm("Adakah anda pasti untuk mengubah katalaluan anda?")){
			document.ilim.action = URL;
			document.ilim.submit();
		}
	}
}
</script>
<br />
<form name="ilim" method="post">
<table width="80%" align="center" cellpadding="1" cellspacing="1" border="0">
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2" class="title" align="center" height="30">Penukaran Katalaluan Pengguna</td>
    </tr>
	<tr>
    	<td width="30%"><strong>Nama : </strong></td>
        <td width="70%"><?=$_SESSION["s_username"];?></td>
    </tr>
	<tr>
    	<td width="30%"><strong>ID Anda : </strong></td>
        <td width="70%"><?=$_SESSION["s_logid"];?>
        <input type="hidden" name="username" size="20" maxlength="20" value="<?=$_SESSION["s_logid"];?>"></td>
    </tr>
	<tr>
    	<td><strong>Katalaluan Lama : </strong></td>
        <td><input type="text" name="old_pass" size="20" maxlength="20"> <i>Sila masukkan katalaluan lama anda.</i></td>
    </tr>
	<tr>
    	<td><strong>Katalaluan Baru : </strong></td>
        <td><input type="text" name="new_pass" size="20" maxlength="20" min="12"> <i>Sila masukkan katalaluan baru anda.</i></td>
    </tr>
	<tr>
    	<td><strong>Ulang Katalaluan : </strong></td>
        <td><input type="text" name="retype_pass" size="20" maxlength="20" min="12"> <i>Ulang semula kemasukan katalaluan baru anda.</i></td>
    </tr>
	<tr>
    	<td></td>
        <td><br><input type="button" value="Hantar" class="button_disp" 
        onClick="form_hantar('index.php?data=<? print base64_encode('user;../include/user_pass_do.php;;;')?>')">
        </td>
    </tr>
	<tr><td>&nbsp;</td><td><br /><br /><i>Contoh katalaluan yang boleh digunakan adalah seperti <b>Password@123</b></i></td></tr>
</table>

</form>
<script LANGUAGE="JavaScript">
	document.ilim.old_pass.focus();
</script>
