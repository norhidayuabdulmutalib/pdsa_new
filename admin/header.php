<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$start = $time;
?>
<?
@session_start();
require_once 'common.php';
require_once 'include/dateformat.php';
include_once 'security.php';
require_once 'browser.php';
$idk = $_SESSION['session_id_kakitangan']; 
$user_lvl = $_SESSION['session_status'];
$user_bahagian = $_SESSION['session_id_bahagian'];
//include 'top/menu1.php';
//exit;
?>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>Sistem e-Parlimen</title>
<link href="css/template-css.css" rel="stylesheet" type="text/css" media="screen">
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
<!--<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">-->
<!--<script type="text/javascript" language="JavaScript1.2" src="include/stm31.js"></script>-->
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
  <tbody>
  	<tr>
    	<td width="5" height="5"background="img/b1.gif"></td>
    	<td background="img/b_top.gif"></td>
    	<td width="5" height="5"background="img/b2.gif"></td>
  	</tr>
    <tr>
        <td background="img/b_left.gif">&nbsp;</td>
       	<td align="left" bgcolor="#EDAEFF"><img src="img/eparlimen2.jpg" border="0"></td>
        <td background="img/b_right.gif">&nbsp;</td>
    </tr>
	<tr>
        <td background="img/b_left.gif">&nbsp;</td>
        <td bgcolor="#CCCCCC" height="25px">
        <div style="float:left">&nbsp;&nbsp;Selamat Datang : <b><?php print strtoupper($_SESSION['session_nama']);?> <i>[ <?php print strtoupper($_SESSION['session_bahagian']);?> ]</i></b></div>
        <div style="float:right">
        <a href="index.php?data=<?php print base64_encode('home.php');?>"><b>Laman Utama</b></a> <b>|</b> 
        <a href="index.php?data=<?=base64_encode('utiliti/kakitangan_pass_upd.php;');?>"><b>Tukar Katalaluan</b></a> <b>|</b> 
        <a href="logout.php"><b>Keluar</b></a>&nbsp;&nbsp;</div> 
        </td>
        <td background="img/b_right.gif">&nbsp;</td>
    </tr>
    <tr>
        <td background="img/b_left.gif">&nbsp;</td>
        <td bgcolor="#EEEEEE"><?php
		//print  $browser['name']."/".$browser['version']."/".$browser['platform'];
			if($browser['name']=='msie'){
				if($browser['version']=='8.0' || $browser['version']=='6.0'){
					include 'top/menu.php'; 
					//include 'top/mmenu1.php'; 
				} else {
					include 'top/mmenu1.php';  
				}
				//include 'top/menu_BM.php'; 
			} else {
				include 'top/mmenu1.php'; 
			}
			?>
			<?php //include 'top/mmenu1.php'; ?></td>
        <td background="img/b_right.gif">&nbsp;</td>
    </tr>