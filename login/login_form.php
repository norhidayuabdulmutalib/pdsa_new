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

<!--<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />-->
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<!-- General CSS Files -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<!-- Template CSS -->
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/components.css">
<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700,300,200" rel="stylesheet" type="text/css">
<!-- <link rel="stylesheet" href="css/bootstrap-overrides.css" type="text/css" /> -->
<link rel="stylesheet" href="modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="../admin/modalwindow/dhtmlwindow.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="cal/dhtmlgoodies_calendar.css" media="screen"></LINK>

<!-- Datatable CSS -->
<link rel="stylesheet" href="include/datatable/datatables.css">
<link rel="stylesheet" href="include/datatable/datatables.min.css">


<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="script.js"></script>
<SCRIPT type="text/javascript" src="cal/dhtmlgoodies_calendar2.js"></script>
<script type="text/javascript" src="../admin/modalwindow/dhtmlwindow.js">
/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>

<!-- General JS Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <!-- Datatable JS -->
<script src="include/datatable/datatables.js"></script>
<script src="include/datatable/datatables.min.js"></script>

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


<body style="padding: 100x; background-image: url('http://1.bp.blogspot.com/-YvjSjUd6vXM/Up_JLwVYjFI/AAAAAAAAFVo/jC7XAzevgHE/s1600/IMG_20131127_140832.jpg');">
    <div class="container" >
		<div class="row justify-content-center">
            <div class="col-10 text-center my-auto">
				
				<div class="card-body text-white" style="background-color: rgba(204, 149, 30, 0.59);">
					<div align="center">
						<img src="../images/logo_ilim.jpg" style="max-height:150px;max-width:100px" alt="image" class="image_parlimen" /></div>
					
					
                    <h3 class="section-heading text-uppercase" style="font-size: 2.5em;">SISTEM MAKLUMAT LATIHAN ILIM (I-TIS)<b></h3> 
					<br><p><div class="text-white">Sila masukkan no. kad pengenalan anda.</div></p><br>

					<div class="card-body text-center my-auto">
					<form name="ilim" method="post" action="login_proses" onSubmit="do_open()">
						
					<div class="form-group row row align-items-center justify-content-center">
						<!-- <label for="logid" class="col-sm-3 col-form-label col-form-label-lg">No. KP</label> -->
						<div class="col-sm-10 ">
							<input style="border-radius: 2rem" type="text" class="form-control form-control-lg" placeholder="No Kad Pengenalan">
						</div>
					</div>

					<div class="form-group row row align-items-center justify-content-center">
						<!-- <label for="logid" class="col-sm-3 col-form-label col-form-label-lg">Kata Laluan :</label> -->
						<div class="col-sm-10 ">
							<input style="border-radius: 2rem" type="text" class="form-control form-control-lg" placeholder="Kata Laluan">
						</div>
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


<br><br>
<script language="javascript" type="text/javascript">
document.ilim.logid.focus();
</script>