<?php include '../common.php'; ?>
<?php
$win = base64_decode($_GET['win']);
$get_win = explode(";", $win);
$pages = $get_win[0]; // piece1
$id = $get_win[1]; // piece1
if(!empty($_SESSION["s_logid"]) && $_SESSION["s_logid"]=='1'){
	//print "PG: ".$pages . " / " . $id;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style media="print" type="text/css">
body{FONT-SIZE: 14px;FONT-FAMILY: Arial;COLOR: #000000;
width:98%;}
.printButton { display: none; }

@media all{
 .page-break { display:none; }
}

@media print{
 .page-break { display:block; page-break-before:always; }
}
</style>
</head>
<body>
<table width="98%" align="center" cellpadding="4" cellspacing="0" border="0">
	<tr>
    	<td>
			<?php include $pages;?>
        </td>
    </tr>
</table>
</body>
</html>
