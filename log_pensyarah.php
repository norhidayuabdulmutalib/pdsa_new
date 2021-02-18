<?php isset($_GET['log']); ?>
<?php if(empty($_GET['log'])){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/css_default.css" rel="stylesheet" type="text/css">
</head>
<script language="javascript" type="text/javascript">
function login(){
	var uname = document.ilim.userlog.value;
	var pass = document.ilim.upass.value;
	if(uname==''){
		alert('Sila masukkan ID pengguna anda.');
		document.ilim.userlog.focus();
	} else if(pass==''){
		alert('Sila masukkan katalaluan anda.');
		document.ilim.upass.focus();
	} else {
		document.ilim.action='log_pensyarah.php?log=LOG';
		document.ilim.submit();
	}
}
</script>
<body >
<table width="100%" cellpadding="0" cellspacing="0" border="0" height="280px" class="font-std" 
style="background-image:url(img/login.gif);background-repeat:no-repeat;background-position:center">
	<tr><td width="80%">
    	<form name="ilim" method="post" action="">
    	<table width="70%" align="center" cellpadding="3" cellspacing="0" border="0" class="font-std" >
            <tr valign="top"><td align="right" colspan="2"><br /><b>Log Masuk</b><br /><br /><br /><br /><br /><br /><br /></td></tr>
            <tr valign="top">
            	<td><b>ID Pengguna : </b></td>
            	<td><input type="text" size="16" maxlength="20" name="userlog" value="800501105050" /></td>
            </tr>
            <tr valign="top">
            	<td><b>Katalaluan : </b></td>
            	<td><input type="password" size="16" maxlength="20" name="upass" /></td>
            </tr>
            <tr valign="top">
            	<td colspan="2" align="center">
                	<input type="submit" value="Masuk" onclick="login()" /> 
                    <input type="button" value="Batal" onclick="javascript:parent.emailwindow.hide()" />
                </td>
            </tr>
    	</table>
        </form>
    </td></tr>
</table>
</body>
</html>
<script language="javascript" type="text/javascript">
	document.ilim.userlog.focus();
</script>
<?php
} else {
include 'common.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/css_default.css" rel="stylesheet" type="text/css">
<script language="javascript">
	function do_ok(type){
		if(type==1){
			parent.do_pensyarah();
		} else {
			document.location.href="log_pensyarah.php";
		}
	}
</script>
</head>
<?php	
	//$conn->debug=true;
	@session_start();
	$msg='';
	$varUser=isset($_POST["userlog"])?trim($_POST["userlog"]):"";
	$varPswd=isset($_POST["upass"])?trim($_POST["upass"]):"";
	
	$sql = "SELECT * FROM  _tbl_instructor WHERE is_deleted=0 AND insid=".tosql($varUser,"Text")." AND passwd=".tosql(md5($varPswd),"Text");
	$rslogin = &$conn->Execute($sql);

	if(!$rslogin->EOF){
	
		$_SESSION["s_usertype"]='PENSYARAH';
		$_SESSION["s_level"]='1';
		$_SESSION["s_userid"]=$rslogin->fields['ingenid'];
		$_SESSION["s_logid"]=$rslogin->fields['insid'];
		$_SESSION["s_username"]=$rslogin->fields['insname'];
		$_SESSION["s_pages"]='PENSYARAH';
		
		/*session_register("s_level");
		session_register("s_userid");
		session_register("s_username");*/
		$pok=1;
		$msg = 'Anda berjaya log masuk ke dalam sistem.';
		audit_log($msg,'Pensyarah','','');
		/*print '<script>
			<!--
			alert("Anda berjaya log masuk ke dalam sistem.");
			//parent.location.reload();
			//parent.emailwindow.hide();
			parent.do_open();
			//-->
			</script>';
		*/
	} else {
		$pok=0;
		$msg = 'Kombinasi ID Pengguna dan Katalaluan anda salah.<br>Sila cuba sekali lagi.';
		audit_log($msg,'pensyarah',$varUser,'ERR');
		/*print '<script>
			alert("Kombinasi ID Pengguna dan Katalaluan anda salah. Sila cuba sekali lagi.");
			document.location.href="systems.php";
			</script>';
		*/
	}
?>
<body>
<form name="ilim" method="post">
<table width="90%" align="center" cellpadding="2" cellspacing="0" height="200px" class="font-std" >
	<tr><td width="90%" align="center"><?php print $msg;?></td></tr>
    <tr><td align="center"><input type="button" name="btnok" value=" OK " onclick="do_ok('<?=$pok;?>')" style="cursor:pointer" /></td></tr>
</table>
</form>
</body>
</html>
<script language="javascript">
document.ilim.btnok.focus();
</script>
<?php } ?>