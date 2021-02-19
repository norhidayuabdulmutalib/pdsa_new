<?php

$msg='';
$varUser=isset($_POST["userlog"])?trim($_POST["userlog"]):"";
$varPswd=isset($_POST["upass"])?trim($_POST["upass"]):"";
//print $varUser."/".$varPswd;
if(!empty($varUser) && !empty($varPswd)){	
	//include 'common.php';
	//$conn->debug=true;
	$sql = "SELECT * FROM  _tbl_instructor WHERE is_deleted=0 AND insid=".tosql($varUser,"Text")." AND passwd=".tosql(md5($varPswd),"Text");
	$rslogin = &$conn->Execute($sql);

	if(!$rslogin->EOF){
	
		$_SESSION["s_usertype"]='PENSYARAH';
		$_SESSION["s_level"]='1';
		$_SESSION["s_userid"]=$rslogin->fields['ingenid'];
		$_SESSION["s_logid"]=$rslogin->fields['insid'];
		$_SESSION["s_username"]=$rslogin->fields['insname'];
		$_SESSION["s_pages"]='PENSYARAH';
		//$user_name = $rslogin->fields['f_name'];
		/*session_register("s_level");
		session_register("s_userid");
		session_register("s_username");*/
		$pok=1;
		$msg = 'Anda berjaya log masuk ke dalam sistem.';
		audit_log($msg,'Pensyarah','','');

		//include_once("include/usersOnline.class.php");
		//function ipCheck() {
		/*
		This function will try to find out if user is coming behind proxy server. Why is this important?
		If you have high traffic web site, it might happen that you receive lot of traffic
		from the same proxy server (like AOL). In that case, the script would count them all as 1 user.
		This function tryes to get real IP address.
		Note that getenv() function doesn't work when PHP is running as ISAPI module
		*/
			if (getenv('HTTP_CLIENT_IP')) {
				$ip = getenv('HTTP_CLIENT_IP');
			}
			elseif (getenv('HTTP_X_FORWARDED_FOR')) {
				$ip = getenv('HTTP_X_FORWARDED_FOR');
			}
			elseif (getenv('HTTP_X_FORWARDED')) {
				$ip = getenv('HTTP_X_FORWARDED');
			}
			elseif (getenv('HTTP_FORWARDED_FOR')) {
				$ip = getenv('HTTP_FORWARDED_FOR');
			}
			elseif (getenv('HTTP_FORWARDED')) {
				$ip = getenv('HTTP_FORWARDED');
			}
			else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			//return $ip;
		//}
		$dt = date("m-d");
		$yr = date("Y")-1;
		$get_dt = $yr."-".$dt." 00:00:00";
		
		//$sqld = "DELETE FROM auditrail WHERE trans_date < ".tosql($get_dt);
		//print $sqld;
		//$conn->execute($sqld);
		//exit;

		$tout = time()-300;
		$sqld = "DELETE FROM useronline WHERE timestamp < ".tosql($tout);
		$conn->execute($sqld);

		
		$sqli = "INSERT INTO useronline(timestamp, ip, user_name) VALUES ('".time()."', '$ip', '$user_name')";
		$conn->execute($sqli);
		
		$mnu = base64_encode('user;default_pensyarah.php');
		print '<script>
			<!--
			alert("Anda berjaya log masuk ke dalam sistem.");
			//parent.location.reload();
			//parent.emailwindow.hide();
			document.location.href="apps/index.php?data='.$mnu.'";
			//-->
			</script>';
		
	} else {
		$pok=0;
		$msg = 'Kombinasi ID Pengguna dan Katalaluan anda salah.<br>Sila cuba sekali lagi.';
		audit_log($msg,'sistem',$varUser,'ERR');
		//exit;
		/*print '<script>
			alert("Kombinasi ID Pengguna dan Katalaluan anda salah. Sila cuba sekali lagi.");
			document.location.href="systems.php";
			</script>';
		*/
	}
}
?>
<link href="login/login-box.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
<!--
	function do_logs(URL){
		if(document.ilim.userlog.value==''){
			alert("Please enter your login id");
			document.ilim.userlog.focus();
		} else if(document.ilim.upass.value==''){
			alert("Please enter your password");
			document.ilim.upass.focus();
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
<div align="center"><?php print $msg;?></div>
<div id="login-box">
<label style="font-family:Arial, Helvetica, sans-serif;font-size:20px;font-weight:bold">
SISTEM MAKLUMAT LATIHAN ILIM (I-TIS)<br>(PENSYARAH)</label> 
<br>
Sila masukkan no. kad pengenalan anda.<br>
<table width="80%" cellpadding="5" cellspacing="1" border="0" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
	<tr><td><br></td></tr>
	<tr>
    	<td align="right"><b>No. KP : </b></td>
        <td><input type="text" size="20" name="userlog" maxlength="20" value="" /></td>
    </tr>
	<tr>
    	<td align="right"><b>Katalaluan : </b></td>
        <td><input type="password" size="20" name="upass" maxlength="20" value=""/></td>
    </tr>
	<tr><td colspan="2" align="center">
		<a href="javascript:void(0);" onClick="do_logs('index.php?pages=login_pensyarah')">
        <img src="images/login-btn.png" width="103" height="42" style="cursor:pointer" /></a>
    </td>
    </tr>
</table>
</div>
</div>
<br><br>
</body>
<br><br>
<?php //} ?>
<script language="javascript" type="text/javascript">
document.ilim.userlog.focus();
</script>