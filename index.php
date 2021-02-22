<?php @session_start();?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Sistem Maklumat Latihan Bersepadu ILIM</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="img/ico_jata.gif" type="image/x-icon" />
		<!-- Google fonts-->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
		<link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
		<link href="css/styles.css" rel="stylesheet" type="text/css" media="screen">
		<!-- <link href="css/system.css" rel="stylesheet" type="text/css" media="screen"> -->
		<!-- <link href="css/template-css.css" rel="stylesheet" type="text/css" media="screen"> -->
		<!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
		<!-- <link href="css/font-awesome.min.css" rel="stylesheet"> -->
		<script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
		<!-- <link href="css/main.css" rel="stylesheet">-->
		<link href="css/responsive.css" rel="stylesheet">
		<link rel="stylesheet" href="modalwindow/modal.css" type="text/css" />
		<link rel="stylesheet" href="modalwindow/dhtmlwindow.css" type="text/css" />
		<script type="text/javascript" src="modalwindow/dhtmlwindow_main.js">
		/***********************************************
		* DHTML Window Widget- � Dynamic Drive (www.dynamicdrive.com)
		* This notice must stay intact for legal use.
		* Visit http://www.dynamicdrive.com/ for full source code
		***********************************************/
		</script>
		
		<script type="text/javascript" src="modalwindow/modal.js"></script>
		<script language="javascript" type="text/javascript">	
		function open_modal(URL,title,width,height){
			emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, title, 'width='+width+'px,height='+height+'px,center=1,resize=1,scrolling=0')
		} //End "opennewsletter" function
		function login(URL,title){
			emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, title, 'width=400px,height=300px,center=1,resize=0,scrolling=0')
			emailwindow.onclose=function(){ //Define custom code to run when window is closed
				var theform=this.contentDoc.getElementById("eula") //Access form with id="eula" inside iframe
				var yesbox=theform.eulabox[0] //Access the first radio button within form
				var nobox=theform.eulabox[1] //Access the second radio button within form
				if (yesbox.checked==true)
					alert("You agreed to the terms")
				else if (nobox.checked==true)
					alert("You didn't agree to the terms")
				return true //Allow closing of window in both cases
			}
		} //End "opennewsletter" function
		function do_login(){
			var forms = document.ilim.logs.value;
			document.ilim.action = 'index.php?pages='+forms;
			//alert(forms);
			document.ilim.submit();
		}
		</script>
		<!--<script src="assets/js/jquery-1.11.1.js"></script>
		<script src="js/jquery.min.js"></script>-->
		<!--<script src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/js/jquery.backstretch.min.js"></script>
		<script src="assets/js/scripts.js"></script>-->
	</head>
	<?php
	require_once 'common.php';
	//print "ipS:".$ip; exit;
	// var_dump($conn);

	$pages=isset($_REQUEST["pages"])?$_REQUEST["pages"]:"";
	$i_text = 'images/banner/text_itis.png';
	$i_kiri = 'images/banner/biru_kiri.jpg';
	$i_kanan = 'images/banner/biru_kanan.jpg';
	//print "ip:".$ip;

	?>
	<body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
		<Script Language='javascript' src='script/RemoteScriptServer.js'></Script>
		<div align="center" id="page-top">
		<!-- 	<div class="container" align="center">

				<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
					<tbody >
						<tr><td>&nbsp;<br></td></tr>
						<tr><td align="center"> -->
							<?php

							if(empty($pages)){ $pages='index'; }
							if($pages=='index'){
								include './katalog/senarai_new.php'; 
							} else if($pages=='login_staff'){
								//include 'login/login_staff.php'; 
								print "<meta http-equiv=\"refresh\" content=\"0; URL=admin\">"; exit;
							} else if($pages=='login_asrama'){
								include 'login/login_asrama.php'; 
							} else if($pages=='login_pensyarah'){
								include 'login/login_pensyarah.php'; 
							} else if($pages=='login_peserta'){
								include 'login/login_peserta.php'; 
								//include 'apps/default.php'; 
							} else if($pages=='staff'){
								include 'login/login_staff.php'; 
							} else if($pages=='asrama'){
								include 'login/login_asrama.php'; 
							} else if($pages=='pensyarah'){
								include 'login/login_pensyarah.php'; 
							} else if($pages=='peserta'){
								include 'login/login_peserta.php'; 
							} else {
								include $pages.'.php';
							}
							?>
						<!-- </td></tr>
					</tbody>
				</table>
			</div> -->
		</div>
		<!-- Bootstrap core JS-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
				<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
				<!-- Third party plugin JS-->
				<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
				<!-- Contact form JS-->
				<script src="assets/mail/jqBootstrapValidation.js"></script>
		<script src="script/scripts.js"></script>
	</body>
</html>