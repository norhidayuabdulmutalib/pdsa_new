<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
//date_default_timezone_set('UTC');

@session_start();
//require_once 'include/dbconnect.php';
$s_userid = $_SESSION["s_userid"];
$s_username = $_SESSION["s_username"];
if(empty($_SESSION["s_userid"])){
	// include '../lout.php';
	exit();
} 
require_once '../common.php';
require_once '../common_func.php';

$data = base64_decode($_GET['data']);
$get_data = explode(";", $data);
$pro = $get_data[0]; // piece1
$page = $get_data[1]; // piece1
$get_page = $get_data[1]; // piece1
$menu = $get_data[2]; // piece2
$submenu = $get_data[3]; // piece2
$id = $get_data[4]; // piece2
$sub_tab = $get_data[5]; // piece2
//if($_SESSION["s_userid"]=='1'){
	echo "<font color=#000000>PROSES:".$pro.";PG:".$page.";MENU:".$menu.";SUBMENU:".$submenu.";ID:".$id.";SUBTAB:".$sub_tab."</font>";
//}
/*if(!empty($pro) && empty($_SESSION["s_userid"])){
	$url = 'index.php';
	print "<meta http-equiv=\"refresh\" content=\"1; URL=".$url."\">"; 
	exit;
}*/
//$conn->debug=true;
$sql = "SELECT A.*, Z.kampus_id, Z.f_level FROM _tbl_user Z, _tbl_menu_user A, _tbl_menu B 
WHERE Z.id_user=A.id_kakitangan AND A.menu_id=B.menu_id AND B.sub_menu=".tosql($submenu)." 
	AND A.id_kakitangan=".tosql($_SESSION["s_userid"]);
$rsmenus = &$conn->execute($sql);

$_SESSION['SESS_KAMPUS']=$rsmenus->fields['kampus_id'];
$_SESSION["s_level"]=$rsmenus->fields['f_level'];
$_SESSION['SESS_ADD']=$rsmenus->fields['is_add'];
$_SESSION['SESS_UPD']=$rsmenus->fields['is_upd'];
$_SESSION['SESS_DEL']=$rsmenus->fields['is_del'];

if($_SESSION["s_level"]=='99'){ 
	$sql_filter=''; 
	$sql_kampus='';
} else { 
	$sql_filter = '';
	$sql_kampus=" AND kampus_id=".$rsmenus->fields['kampus_id']; 
}

?>

<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>Sistem Maklumat Latihan (ITIS)</title> 

<?php  
	if(empty($_SESSION['s_userid'])&& empty($pages)){
	print '<link rel="stylesheet" type="text/css" href="css/styles.css" />'; //untuk menu
	}
?>

<!-- General CSS Files -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<!-- Template CSS -->
<link rel="stylesheet" href="../admin/assets/css/style.css">
<link rel="stylesheet" href="../admin/assets/css/components.css">
<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700,300,200" rel="stylesheet" type="text/css">
<!-- <link rel="stylesheet" href="css/bootstrap-overrides.css" type="text/css" /> -->
<link rel="stylesheet" href="../admin/modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="../admin/modalwindow/dhtmlwindow.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="../admin/cal/dhtmlgoodies_calendar.css" media="screen"></LINK>

<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="../admin/script.js"></script>
<SCRIPT type="text/javascript" src="../admin/cal/dhtmlgoodies_calendar2.js"></script>
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
  <script src="../admin/assets/js/stisla.js"></script>

  <!-- Template JS File -->
  <script src="../admin/assets/js/scripts.js"></script>
  <script src="../admin/assets/js/custom.js"></script>
</script>
<script type="text/javascript" src="../modalwindow/modal.js"></script>
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
	document.ilim.action = URL;
	document.ilim.submit();
}
</script>

</head>



<body>
  <!-- <nav class="navbar navbar-expand-lg main-navbar" style="padding-top:0px;padding-left:0px;padding-bottom:60px;">
    <form class="form-inline mr-auto">
      <ul class="navbar-nav mr-3">
        <li> 
          <button class="btn btn-md" style="shadow:0px;background-color:#fed136;">
            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
              <i class="fas fa-bars" style="color:#000;"></i>
            </a>
          </button>
          
        </li>
      </ul>
      <h2 style="color: #fed136;margin-top: 50px; margin-left:50px;">SISTEM MAKLUMAT LATIHAN ILIM (I-TIS)</h2>
    </form>
    <ul class="navbar-nav navbar-right" style="margin-top:50px;">
      <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="../admin/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">Admin</div></a>
        <div class="dropdown-menu dropdown-menu-right" style="padding:0px;">
          <div class="dropdown-title">Logged in 5 min ago</div>
          <a href="features-profile.html" class="dropdown-item has-icon">
            <i class="far fa-user"></i> Profil
          </a>
          <a href="index.php?data=<? print base64_encode(';../logout.php');?>" class="dropdown-item has-icon text-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav> -->

  <div id="app">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
            <?php include 'header_system.php';
            
            if($_SESSION["s_usertype"]=='PESERTA'){ 
                include 'menu/left_peserta_system.php';
            } else if($_SESSION["s_usertype"]=='PENSYARAH'){ 
                include 'menu/left_pensyarah.php';
            } else { 
                include 'menu/left_menu.php';
            } ?>
			
			<div class="main-content" id="content">
				<section class="section">
					<div class="section-header" style="margin:0px;">
                        <h1 color="#000000"><?php print $pages; ?></h1>
                    </div>
                        <?php
                            if(!empty($page)){ 
                                include $page; //"utiliti/bahagian.php";s
                            } else { 
                                include 'default.php';
                            }
                        ?>
                </section>
            </div>

            <footer class="main-footer">';
			    <?php include_once('footer_system.php'); ?>
            </footer> 
        </div>
    </div>
</div>