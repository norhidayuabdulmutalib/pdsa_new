
<?php @session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistem Maklumat Latihan ILIM</title>
<?php //$_SESSION['SESS_UID']='SS'; ?>
<?php
// session_save_path('/var/www/session');
error_reporting(E_ALL ^ E_NOTICE);
//print "PG:".$pages;
// var_dump($_SESSION);
// var_dump($_SESSION["s_userid"]);

include_once 'common.php';
// var_dump($conn);
// var_dump($userid);
// var_dump($pages);
// var_dump($_SESSION["s_userid"]);

require_once 'browser.php';
// var_dump($pages);
if(empty($_SESSION['s_userid'])){
	$pages='';
}
// var_dump($_SESSION['s_userid']);
// var_dump($pages);die();
$userid = $_SESSION['s_userid']; 
$user_lvl = $_SESSION['s_level'];
$user_bahagian = $_SESSION['s_jabatan'];

// print $_SESSION['s_level'];
?>



<!--<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />-->
<?php  
//$pages=isset($_REQUEST["pages"])?$_REQUEST["pages"]:"";
//if(empty($_SESSION['s_userid'])&& empty($page)){ 
	//print 'L';
	// print '<link rel="stylesheet" type="text/css" href="css/loginstyle.css" />';
	// print '<link rel="stylesheet" type="text/css" href="css/style.css" />';
	if(empty($_SESSION['s_userid'])&& empty($pages)){
	print '<link rel="stylesheet" type="text/css" href="css/styles.css" />'; //untuk menu
	}
//} else {
	//print "D";
	// print '<link rel="stylesheet" type="text/css" href="css/style.css" />';
//} ?>

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
  

  <!-- Page Specific JS File -->
  <!-- <script src="assets/js/page/index-0.js"></script> -->
<script type="text/javascript" src="modalwindow/modal.js"></script>
<script language="javascript" type="text/javascript">	
function open_modal(URL,title,width,height){
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, title, 'width='+width+'px,height='+height+'px,center=1,resize=1,scrolling=0')
} //End "opennewsletter" function

function open_windows(URL){
	window.open (URL, "mywindow","location=1,status=1,scrollbars=1, width=100,height=100");
} //End "opennewsletter" function
function openModal(URL){
	var height=screen.height-150;
	var width=screen.width-100;

	var returnValue = window.showModalDialog(URL, 'I-TIS','help:no;status:yes;scroll:yes;resize:yes;toolbar=yes;dialogHeight:'+height+'px;dialogWidth:'+width+'px');
	//window.open(URL,'name','height=255,width=250,toolbar=yes,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
} 
</script>
<script language="javascript" type="text/javascript">
function do_page(URL){
	document.ilim.action=URL;
	document.ilim.target='_self';
	document.ilim.submit();
}
function do_back(URL){
	alert(URL);
	document.ilim.action = URL;
	document.ilim.target = '_self';
	document.ilim.submit();
}
function do_open(URL){
	document.ilim.action = URL;
	document.ilim.target = '_blank';
	document.ilim.submit();
}

</script>


</head>

<body>
<Script Language='javascript' src='include/RemoteScriptServer.js'></Script>
<!-- <form id="ilim" name="ilim" method="post" action="" enctype="multipart/form-data"> -->
	<div id="wrapper">
		<?php 
		//print "P".$pages;
		if(empty($_SESSION['s_userid'])&& empty($pages)){ 
			include 'login/login.php'; //exit;
		} else {
			if($pages=='login/login'){ include 'login/login.php'; exit; }
			//include_once 'security.php';
			//print '';
			// print $userid;
			print '<div id="app">
					<div class="main-wrapper">
			  			<div class="navbar-bg"></div>';
							include 'header_system.php';
							// print '<div id="box_wrap">';
							include 'sidebar_menu.php';
			
			print '<div class="main-content" id="content">
					<section class="section">
						<div class="section-header" style="margin:0px;">
							<h1>';
							print $pages;
							// print $user_lvl;
							// print $user_bahagian;
						print '</h1></div>';
						if(empty($pages)){
							include 'main_home.php';
						} else { 
							// print $_SESSION['s_userid'];
							include $pages.'.php';
						} 
			print '</section>
				</div> ';
			// print '<div style="clear:both;">
			// 			<!--dont remove -->
			// 		</div>';
			print '<footer class="main-footer">';
			include_once('footer_system.php');	
			// print '</form>';
			print '</footer> </div></div>';
		}
		?>	
		<?php ?>
	</div>
<!-- </form> -->
</body>
</html>
