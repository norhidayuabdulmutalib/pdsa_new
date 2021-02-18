<link href="login-box.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
<!--
	function do_open(URL){
		if(document.ilim.logid.value==''){
			alert("Please enter your login id");
			document.ilim.logid.focus();
		} else if(document.ilim.pass.value==''){
			alert("Please enter your password");
			document.ilim.pass.focus();
		} else {
			//alert(URL);
			document.ilim.action=URL;
			document.ilim.submit();
		}
	}
-->
</script>
<body>
<div style="padding: 1px 0 0 1px;">
<div id="login-box">
<label style="font-family:Arial, Helvetica, sans-serif;font-size:20px;font-weight:bold">
SISTEM MAKLUMAT LATIHAN ILIM (I-TIS)</label><br>
Sila masukkan no. kad pengenalan anda.<br>
<form name="ilim" method="post" action="login_proses" onSubmit="do_open()">
<table width="80%" cellpadding="5" cellspacing="1" border="0" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
	<tr><td><br></td></tr>
	<tr>
    	<td align="right"><b>No. KP : </b></td>
        <td><input type="text" size="20" name="logid" maxlength="20" /></td>
    </tr>
	<tr>
    	<td align="right"><b>Katalaluan : </b></td>
        <td><input type="password" size="20" name="pass" maxlength="20"/></td>
    </tr>
	<tr><td colspan="2" align="center">
		<a href="javascript:void(0);" onClick="do_open('log_systems.php')">
        <img src="images/login-btn.png" width="103" height="42" style="cursor:pointer" /></a>
    </td>
    </tr>
</table>
</form>
</div>
</div>
<!--<div align="center" style="widows:700px">
    <tr>
    	<td colspan="2" align="center" style="font-weight:bold"><br />
        	<a href="index.php?data=<? print base64_encode('../register/user_register.php;;;');?>">
            <b>Sila klik disini untuk pendaftaran syarikat.<br><i>(Please click here to register new account.)</i></b></a>
            <br><br>
        </td>
    </tr>
</div>-->
<br><br>
</body>
<br><br>
<script language="javascript" type="text/javascript">
document.ilim.logid.focus();
</script>