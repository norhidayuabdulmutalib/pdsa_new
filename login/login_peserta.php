<?php

$msg='';
$varUser=isset($_POST["userlog"])?trim($_POST["userlog"]):"";
$varPswd=isset($_POST["upass"])?trim($_POST["upass"]):"";
//print $varUser."/".$varPswd;
if(!empty($varUser) && !empty($varPswd)){	
	//include 'common.php';
	//$conn->debug=true;
	$sql = "SELECT * FROM _tbl_peserta WHERE f_peserta_noic=".tosql($varUser,"Text")." AND f_peserta_noic=".tosql($varPswd,"Text");
	$rslogin = &$conn->Execute($sql);

	if(!$rslogin->EOF){
	
		$_SESSION["s_usertype"]='PESERTA';
		$_SESSION["s_user"]='PESERTA';
		$_SESSION["s_level"]='PESERTA';
		$_SESSION["s_userid"]=$rslogin->fields['id_peserta'];
		$_SESSION["s_logid"]=$rslogin->fields['f_peserta_noic'];
		$_SESSION["s_username"]=$rslogin->fields['f_peserta_nama'];
		//$user_name = $rslogin->fields['f_name'];
		/*session_register("s_level");
		session_register("s_userid");
		session_register("s_username");*/
		$pok=1;
		$msg = 'Anda berjaya log masuk ke dalam sistem.';
		audit_log($msg,'Peserta','','');

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
		
		$mnu = base64_encode('user;apps/default.php');
		print '<script>
			<!--
			alert("Anda berjaya log masuk ke dalam sistem.");
			//parent.location.reload();
			//parent.emailwindow.hide();
			window.open(\'apps/index.php?data=dXNlcjtkZWZhdWx0X3Blc2VydGEucGhwO2RlZmF1bHQ7ZGVmYXVsdA==\',\'_self\');
			//-->
			</script>';
		exit;
		
	} else {
		$pok=0;
		$msg = 'Kombinasi ID Pengguna dan Katalaluan anda salah.<br>Sila cuba sekali lagi.';
		audit_log($msg,'Peserta',$varUser,'ERR');
		//exit;
		/*print '<script>
			alert("Kombinasi ID Pengguna dan Katalaluan anda salah. Sila cuba sekali lagi.");
			document.location.href="systems.php";
			</script>';
		*/
	}
}
?>
<link href="login/bootstrap.css" rel="stylesheet" type="text/css" />
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
<?php
$id=isset($_REQUEST["id"])?trim($_REQUEST["id"]):"";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Login V12</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="icon" type="image/png" href="images/icons/favicon.ico" />

<link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">

<!-- <link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css"> -->

<link rel="stylesheet" type="text/css" href="login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

<link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">

<link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">

<link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">

<link rel="stylesheet" type="text/css" href="login/css/util.css">
<link rel="stylesheet" type="text/css" href="login/css/main.css">

</head>
<body>
	<div class="limiter">
		<div align="center"><?php print $msg;?></div>
		<div class="col-10">
			<div class="card-body text-white" style="background-color: rgba(204, 112, 30, 0.59);">
					<form class="login100-form validate-form">
						<!-- <div class="login100-form-avatar">
							
						</div> -->
						<span class="login100-form-title">
                            <i class="fas fa-user-circle fa-3x pb-3"></i>
                            <h3 class="section-heading text-uppercase" style="font-size: 1.5em;">SISTEM MAKLUMAT LATIHAN ILIM (I-TIS)<br>(PESERTA KURSUS)</h3> <br>
                            <h6><div class="text-white">Sila masukkan no. kad pengenalan anda.</div></h6><br>
						</span>

						<div class="wrap-input100 validate-input" data-validate="Sila isi No Kad Pengenalan">
							<input class="input100" type="text" name="userlog" value="<?=$id;?>" placeholder="No KP : ">
							<i style="color:white">Sila masukkan no kp anda sebagai id pegguna </i>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-user pb-3"></i>
								</span>
						</div>

						<div class="wrap-input100 validate-input" data-validate="Password is required">
							<input class="input100" type="password" name="pass" placeholder="Password">
							<i style="color:white">Sila masukkan no kp anda sebagai id pegguna</i>
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-lock pb-3"></i>
								</span>
						</div>
						<div class="container-login100-form-btn p-t-10">
							<a href="javascript:void(0);" onClick="do_logs('index.php?pages=login_peserta')">
                            <button class="btn btn-warning btn-sm" style="cursor:pointer; font-size: 0.8rem; font-weight:bold";>LOG MASUK</button>
							</a>
						</div>
						<!-- <div class="text-center w-full p-t-25 p-b-230">
							<a href="#" class="txt1">
								Forgot Username / Password?
							</a>
						</div> -->
					</form>
				</div>
			</div>
		</div>

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>

	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

	<script src="vendor/select2/select2.min.js"></script>

	<script src="js/main.js"></script>

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-23581568-13');
	</script>
</body>

<!-- <body>
	<div style="padding: 1px 0 0 1px;">
	<div align="center"><?php print $msg;?></div>
	<div id="login-box" style="height:320px">
	<i class="fas fa-user-circle fa-7x"></i>
	<h1 class="section-heading text-uppercase" style="font-size: 3.25rem;"><b>SISTEM MAKLUMAT LATIHAN ILIM (I-TIS)<br>(PESERTA KURSUS)<b></h1> 
                    <br><h3>Sila masukkan no. kad pengenalan anda.</h3><br> -->

	<!-- <table width="80%" cellpadding="5" cellspacing="1" border="0" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
		<tr><td><br></td></tr>
		<tr>
			<td align="right"><b>No. KP : </b></td>
			<td><input type="text" size="20"  name="userlog" maxlength="20" value="<?=$id;?>" /><br><font color="#FFFFFF"><i>Sila masukkan no kp anda sebagai id pegguna</i></td>
		</tr>
		<tr>
			<td align="right"><b>Katalaluan : </b></td>
			<td><input type="password" size="20" name="upass" maxlength="20"/><br><font color="#FFFFFF"><i>Sila masukkan no.kp anda sekali lagi untuk pengesahan</i></td>
		</tr>
		<tr><td colspan="2" align="center">
			<a href="javascript:void(0);" onClick="do_logs('index.php?pages=login_peserta')">
			<img src="images/login-btn.png" width="103" height="42" style="cursor:pointer" /></a>
		</td>
		</tr>
	</table> -->

	<!-- <form class="form-signin">
		<div class="form-group row">
			<label for="logid" class="col-sm-3 col-form-label col-form-label-lg">No. KP :</label>
			<div class="col-sm-6">
				<input style="border-radius: 2rem" type="text" class="form-control form-control-lg"  name="userlog" value="<?=$id;?>" placeholder="No Kad Pengenalan">
				<i>Sila masukkan no kp anda sebagai id pegguna</i>
			</div>
		</div>

		<div class="form-group row">
			<label for="pass" class="col-sm-3 col-form-label col-form-label-lg">Kata Laluan :</label>
			<div class="col-sm-6">
				<input style="border-radius: 2rem" type="password" class="form-control form-control-lg" name="upass" placeholder="Kata Laluan">
				<i>Sila masukkan no.kp anda sekali lagi untuk pengesahan</i>
			</div>
		</div>
		<hr class="my-4">
		<div class="custom-control custom-checkbox mb-3">
			<input type="checkbox" class="custom-control-input" id="customCheck1">
			<label class="custom-control-label" for="customCheck1">Remember password</label>
		</div>
		<a href="javascript:void(0);" onClick="do_logs('index.php?pages=login_peserta')">
			<button class="btn btn-warning btn-lg" style="cursor:pointer; font-size: 1 rem; font-weight:bold";>LOG MASUK</button>
		</a>
	</form>
	</div>
	</div> -->
	

</body>

<?php //} ?>
<script language="javascript" type="text/javascript">
document.ilim.logid.focus();
</script>