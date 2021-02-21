<?php
?>
<link href="login/bootstrap.css" rel="stylesheet" type="text/css" />
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

<head>
<title>Login V12</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="icon" type="image/png" href="images/icons/favicon.ico" />

<link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

<link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">

<link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">

<link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">

<link rel="stylesheet" type="text/css" href="login/css/util.css">
<link rel="stylesheet" type="text/css" href="login/css/main.css">

</head>


<body>
	<div class="limiter">
		<div class="col-10">
			<div class="" style="background-color: rgba(204, 172, 30, 0.56);">
				<form class="login100-form validate-form">
					<span class="login100-form-title">
						<h3 class="section-heading text-uppercase pt-4" style="font-size: 2rem;">SISTEM MAKLUMAT LATIHAN ILIM (I-TIS)</h3> 
						<br><p><div class="text-white">Sila masukkan no. kad pengenalan anda.</div></p><br>
					</span>

					<form name="ilim" method="post" action="login_proses" onSubmit="do_open()">
						
						<div class="col-sm-9 pb-3 pt-3">
							<input class="input100" type="text" name="logid" placeholder="No. KP ">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-user pb-3 pt-3 pl-3 pr-3" aria-hidden="true"></i>
							</span>
						</div>

						<div class="col-sm-9 pb-3 pt-3" data-validate = "Password is required">
							<input class="input100" type="password" name="pass" placeholder="Kata Laluan :">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-lock pb-3 pt-3 pl-3 pr-3" aria-hidden="true"></i>
							</span>
						</div>
						
						<div class="container-login100-form-btn pb-5 pt-4">
							<a href="javascript:void(0);" onClick="do_open('log_systems.php')">
							<button class="btn btn-warning btn-sm" style="cursor:pointer; font-size: 0.8rem; font-weight:bold";>LOG MASUK</button>
							</a>
						</div>
					</form>
				</form>
			</div>
		</div>
	</div>
	
	<script language="javascript" type="text/javascript">
	document.ilim.logid.focus();
	</script>
	
<!--===============================================================================================-->	
	<script src="login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/bootstrap/js/popper.js"></script>
	<script src="login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>

<!-- <body>
	<div style="padding: 1px 0 0 1px;">
	<div id="login-box">
	<label style="font-family:Arial, Helvetica, sans-serif;font-size:20px;font-weight:bold;color:#000">
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
	<!-- <br><br>
</body> -->
<br><br>
