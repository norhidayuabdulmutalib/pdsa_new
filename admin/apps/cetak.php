<?
require_once 'common.php';
$id_staff = $_SESSION["s_fld_user_id"];
$data = base64_decode($_GET['data']);
$get_data = explode(";", $data);
$pro = $get_data[0]; // piece1
$page = $get_data[1]; // piece1
$menu = $get_data[2]; // piece2
$submenu = $get_data[3]; // piece2
$id = $get_data[4]; // piece2
$sub_tab = $get_data[5]; // piece2
//echo "PG:".$submenu;
$mid=$_GET['mid'];
echo "Page:".$pro.";".$page.";".$menu.";".$submenu.";".$id.";".$sub_tab;
//print "m:".$mid;
?>
<?php 
//@session_start();
//require_once 'include/dbconnect.php';
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>Sistem Maklumat Pelajar Darul Quran</title>
<!--<link href="css/printsurat.css" rel="stylesheet" type="text/css" media="screen">-->
<style type="text/css">
	FONT{FONT-SIZE: 14px;FONT-FAMILY: Arial;COLOR: #000000}
	TD{FONT-SIZE: 14px;FONT-FAMILY: Arial;COLOR: #000000}
	BODY{FONT-SIZE: 14px;FONT-FAMILY: Arial;COLOR: #000000}
	P{FONT-SIZE: 14px;FONT-FAMILY: Arial;COLOR: #000000}
	DIV{FONT-SIZE: 14px;FONT-FAMILY: Arial;COLOR: #000000}
.title{
	background-color:#CCCCCC;
	font-weight:bold;
}
.td_data{
	border-bottom-style:dotted; 
	border-bottom-width:thin;
}
</style>
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
  <tbody>
    <tr>
        <td valign="top">
            <?php if(!empty($page)){ include $page; } ?>
        </td>
    </tr>
  </tbody>
</table>
</body>
</html>