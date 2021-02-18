<?php include 'FormatDate.php'; // Tengok kat function DBDate();
$tarikhlahir = '';
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="dhtmlgoodies_calendar.css" media="screen"></LINK>
<title>Untitled Document</title>
</head>

<SCRIPT type="text/javascript" src="dhtmlgoodies_calendar.js"></script>

<?
$tarikhlahir = $_REQUEST['dt_lantikan'];
$tarikhlahir = DBDate($tarikhlahir);

if($tarikhlahir == '' || $tarikhlahir == "0000-00-00") $dob = "";
 else $dob = date('d-m-Y',strtotime($tarikhlahir));
?>

<body>
<form action="<?php $_SERVER['PHP_SELF']?>" method="get">
<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#0099FF">
    <tr bgcolor="#FFFFFF">
    <td width="11%" height="25" align="left" valign="middle"><strong>&nbsp;&nbsp;TKH. LAHIR </strong></td>
    <td width="1%" height="25" valign="middle"><strong>:</strong></td>
    <td width="88%" height="25" align="left" valign="middle"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
      <input name="dt_lantikan" type="text" id="dt_lantikan" value="<?=$dob?>" />
      <img src="img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" onclick="displayCalendar(document.forms[0].dt_lantikan,'dd-mm-yyyy',this)"/> (DD-MM-YYYY)</font></td>
  </tr>
</table>
<input name="btn_submit" type="submit"  />
</form>
</body>
</html>
