<? include '../common.php'; 
header("Content-type: application/x-excel");
//header("Content-type: application/x-msdownload");
header ("Cache-Control: no-cache, must-revalidate");
header("Content-Disposition: attachment; filename=statistik_kursus.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>Institut Latihan Islam Malaysia</title>
<link href="../css/template-css.css" rel="stylesheet" type="text/css" media="screen">
<style type="text/css">
	table.data{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:11px;
	}
	input.data{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:11px;
		font-style:italic;
		text-decoration:underline;
		background-color:#FFFFFF;
		cursor:pointer;
	}
	input.datahead{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:11px;
		font-weight:bold;
		text-decoration:underline;
		background-color:#FFFFFF;
		cursor:pointer;
	}
</style>
<style media="print" type="text/css">
	body{FONT-SIZE: 14px;FONT-FAMILY: Arial;COLOR: #000000}
	.printButton { display: none; width:900px; }
</style>
</head>
<body>
<?
//$conn->debug=true;
$tahun=isset($_REQUEST["tahun"])?$_REQUEST["tahun"]:date("Y");
$width="100%";
$sqly = "SELECT DISTINCT year(startdate) AS yr FROM _tbl_kursus_jadual WHERE year(startdate)<>0 ORDER BY year(startdate) DESC ";
$rsyear = &$conn->execute($sqly);
?>
<table width="<?=$width;?>">
    <tr><td width="100%">
        <table width="100%" align="center">
            <tr>
              <td align="center" width="15%">
                <div style="float:left"></div>
              </td>
              <td align="center" width="70%" colspan="2">
                <div><h3><I><B>INSTITUT LATIHAN ISLAM MALAYSIA<BR>JABATAN KEMAJUAN ISLAM MALAYSIA</B></I></h3></div>
              </td>
              <td align="center" width="15%">
                <div style="float:right">&nbsp;</div>
              </td>
            </tr>
        </table>
    </td></tr>
    <tr>
      <td align="center"><B>LAPORAN JUMLAH KURSUS DIJALANKAN<BR></B></td>
    </tr>
</table>
<?
//$conn->debug=true;
$curmth = date("m");
$curyr = date("Y");
if($tahun==$curyr){ $mth = $curmth; } else { $mth=12; }
?>
<table width="<?=$width;?>" class="data" border="1" cellpadding="3" cellspacing="0">
	<tr bgcolor="#CCCCCC">
    	<td rowspan="2" width="5%" align="center"><b>Bil</b></td>
        <td rowspan="2" width="35%" align="center"><b>Bulan</b></td>
        <td colspan="2" width="60%" align="center"><b>Maklumat Jumlah Kursus Yang Dijalankan Bagi Tahun <?=$tahun;?></b></td>
    </tr>
	<tr  bgcolor="#CCCCCC">
    	<td align="center" width="30%"><b>Kursus Anjuran Ilim</b></td>
    	<td align="center" width="30%"><b>Kursus Luar</b></td>
    </tr>    
<?php
//$conn->debug=true;
for($i=1;$i<=$mth;$i++){
	$bil++; $jum_kilim=0; $jum_kluar=0;
	if($i<10){ $gi='0'.$i; } else { $gi=$i; }
	$sql = "SELECT count(*) AS jumi FROM _tbl_kursus_jadual WHERE category_code=1 AND year(startdate)=".tosql($tahun)." AND month(startdate)=".tosql($gi);
	$rskursus = &$conn->execute($sql);	
	$jum_kilim = $rskursus->fields['jumi'];
	if(empty($jum_kilim)){ $jum_kilim='-'; }
	$sql = "SELECT count(*) AS jumi FROM _tbl_kursus_jadual WHERE category_code<>1 AND year(startdate)=".tosql($tahun)." AND month(startdate)=".tosql($gi);
	$rskursus = &$conn->execute($sql);	
	$jum_kluar = $rskursus->fields['jumi'];
	if(empty($jum_kluar)){ $jum_kluar='-'; }
?>
    <tr bgcolor="<? if ($bil%2 == 1) echo $bg1; else echo $bg2 ?>">
    	<td align="right" height="25" valign="top"><? print $bil;?>.&nbsp;</td>
        <td align="center" valign="top"><? print month($i);?>&nbsp;</td>
        <td align="center" valign="top"><? print $jum_kilim;?>&nbsp;</td>
        <td align="center" valign="top"><? print $jum_kluar;?>&nbsp;</td>
    </tr>
<?php
}	
?>
</table>
<div class="printButton" align="center">
    <input type="button" value="Paparan Graph" onClick="do_open('statistik_kursus_graph_bar.php?tahun=<?=$tahun;?>')" style="cursor:pointer" />
    <input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup window" style="cursor:pointer">
</div>
</body>
</html>