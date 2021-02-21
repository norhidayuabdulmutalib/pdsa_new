<?php
$msg='';
$varUser=isset($_POST["userlog"])?trim($_POST["userlog"]):"";
$varPswd=isset($_POST["upass"])?trim($_POST["upass"]):"";
//print $varUser."/".$varPswd;
if(!empty($varUser) && !empty($varPswd)){	
	//include 'common.php';
	//$conn->debug=true;
	$sql = "SELECT A.* FROM _tbl_user A
	WHERE A.is_admin=1 AND A.f_isdeleted=0 AND A.f_aktif=1  
	AND A.f_userid=".tosql($varUser,"Text")." AND A.f_password=".tosql(md5($varPswd),"Text");
	$rslogin = &$conn->Execute($sql);
	$cnt = $rslogin->recordcount();
	//print "CNT:".$cnt;
	if(!$rslogin->EOF){
		@session_start();
		$_SESSION["s_usertype"]='SYSTEM';
		$_SESSION["s_pusat"]=$rslogin->fields['kod_jabatan'];
		$_SESSION["s_level"]=$rslogin->fields['f_level'];
		$_SESSION["s_userid"]=$rslogin->fields['id_user'];
		$_SESSION["s_logid"]=$rslogin->fields['f_userid'];
		$_SESSION["s_username"]=$rslogin->fields['f_name'];
		$_SESSION["s_jabatan"]=$rslogin->fields['f_jabatan'];
		$_SESSION["s_pages"]='SYSTEM';
		$user_name = $rslogin->fields['f_name'];
		$_SESSION['SESS_KAMPUS']=$rslogin->fields['kampus_id'];
		//$_SESSION["s_level"]=$rsmenus->fields['f_level'];
		
		if(!empty($_SESSION["s_pusat"])){ 
			$_SESSION["s_pusatnama"]=dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rslogin->fields['kod_jabatan'])); //$rslogin->fields['kampus_nama'];
		}
		/*session_register("s_level");
		session_register("s_userid");
		session_register("s_username");*/
		//print "S:".$_SESSION["s_jabatan"]; exit;
		$pok=1;
		$msg = 'Anda berjaya log masuk ke dalam sistem.';
		audit_log($msg,'sistem','','');

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
		
		print '<script>
			<!--
			alert("Anda berjaya log masuk ke dalam sistem.");
			//parent.location.reload();
			//parent.emailwindow.hide();
			document.location.href="apps/index.php?data=dXNlcjtkZWZhdWx0LnBocDtkZWZhdWx0";
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
<!-- <title>Login V12</title> -->
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

<body style="padding: 120px; background-image: url('http://1.bp.blogspot.com/-YvjSjUd6vXM/Up_JLwVYjFI/AAAAAAAAFVo/jC7XAzevgHE/s1600/IMG_20131127_140832.jpg');">
    <div class="container">
		<div class="row justify-content-center">
		<?php print $msg;?>
            <div class="col-10 text-center my-auto">
				
				<div class="card-body text-white" style="background-color: rgba(204, 149, 30, 0.59);">
					<div align="center">
						<img src="../images/logo_ilim.jpg" style="max-height:150px;max-width:100px" alt="image" class="image_parlimen" />
				</div>
				
					
                    <h3 class="section-heading text-uppercase" style="font-size: 2.5em;"><b>SISTEM MAKLUMAT LATIHAN ILIM (I-TIS)<br>(PENGURUSAN SISTEM)</b></h3> 
					<br><p><div class="text-white">Sila masukkan no. kad pengenalan anda.</div></p><br>

					<div class="card-body text-center my-auto">

					<div class="form-group row row align-items-center justify-content-center">
						<!-- <label for="logid" class="col-sm-3 col-form-label col-form-label-lg"></label> -->
						<div class="col-sm-10 ">
							<input style="border-radius: 2rem" type="text" class="form-control form-control-lg" id="logid" placeholder="No Kad Pengenalan">
						</div>
					</div>

					<div class="form-group row row align-items-center justify-content-center">
						 <!-- <label for="pass" class="col-sm-3 col-form-label col-form-label-lg"></label> -->
						<div class="col-sm-10 ">
							<input style="border-radius: 2rem" type="password" class="form-control form-control-lg" id="pass" placeholder="Kata Laluan">
						</div>
					</div>

					<hr class="my-4">
					<div colspan="2" align="center">
						<a href="javascript:void(0);" onClick="do_logs('index.php?pages=login_staff')">
							<button class="btn btn-warning btn-sm" style="cursor:pointer; font-size: 1rem; font-weight:bold";>LOG MASUK</button>
						</a>
					</div>
				</div>
			</div>
	</div>
</body>

<br><br>
<?php //} ?>
<script language="javascript" type="text/javascript">
document.ilim.userlog.focus();
</script>