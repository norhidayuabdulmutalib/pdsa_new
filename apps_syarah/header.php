<? 
date_default_timezone_set('Asia/Kuala_Lumpur');
@session_start();
//require_once 'include/dbconnect.php';
$s_userid = $_SESSION["s_userid"];
$s_username = $_SESSION["s_username"];
if(empty($_SESSION["s_userid"])){
	include '../lout.php';
	exit();
} 
require_once '../common.php';
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>Sistem Maklumat Latihan Bersepadu ILIM</title>
<link href="../css/domistik.css" rel="stylesheet" type="text/css" media="screen">
<link href="../css/template-css.css" rel="stylesheet" type="text/css" media="screen">
<link rel="stylesheet" href="../modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="../modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../modalwindow/dhtmlwindow.js">
/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<script type="text/javascript" src="../modalwindow/modal.js"></script>
<script language="javascript" type="text/javascript">	
function open_modal(URL,title,width,height){
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, title, 'width='+width+'px,height='+height+'px,center=1,resize=1,scrolling=0')
} //End "opennewsletter" function
</script>
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
  <tbody>
  	<tr>
    	<td width="5" height="5"><img src="../img/b1.gif" width="5" height="5"></td>
    	<td background="../img/b_top.gif"></td>
    	<td width="5"><img src="../img/b2.gif" width="5" height="5"></td>
  	</tr>
    <tr>
        <td background="../img/b_left.gif">&nbsp;</td>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
              <tr>
                <td height="112" width="25%">
                    <img src="../images/banner/oren_lf.jpg" alt="left"/>
                </td>
                <td height="112" width="50%" align="center">
                    <img src="../images/banner/text_itis.png" alt="logo" style="float:none" />
                </td>
                <td height="112" width="25%" align="right">
                    <img src="../images/banner/oren_rt.jpg" />
                </td>
              </tr>
            </table>
        </td>
        <td background="../img/b_right.gif">&nbsp;</td>
    </tr>
