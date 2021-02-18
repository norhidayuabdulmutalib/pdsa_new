<? include '../common.php'; 
header("Content-type: application/x-excel");
//header("Content-type: application/x-msdownload");
header ("Cache-Control: no-cache, must-revalidate");
header("Content-Disposition: attachment; filename=peserta_kursus.xls");
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
$href_back = "index.php?data=".base64_encode('user;../laporana/laporan_list.php;laporan;laporan');
$href_search = "index.php?data=".base64_encode('user;../laporana/peserta_kursus.php;laporan;laporan');
$get_data = isset($_REQUEST["data"])?$_REQUEST["data"]:"";
$width="100%";
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";

//if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sql_tkh = " AND startdate >= ".tosql($tkh_mula)." "; }
$strAddStDate=((strlen($tkh_mula)>0)?" AND A.startdate >= ".tosql(DBDate($tkh_mula))." ":"");
$strAddEndDate=((strlen($tkh_tamat)>0)?" AND A.enddate <= ".tosql(DBDate($tkh_tamat))." ":"");

?>
<?php
//$conn->debug=true;
$sqlpe = "SELECT B.courseid, B.coursename, A.startdate, A.enddate, A.id FROM _tbl_kursus_jadual A, _tbl_kursus B WHERE B.is_deleted=0 AND A.courseid=B.id ";
$sqlpe .= $strAddStDate . $strAddEndDate;
$sqlpe .= " ORDER BY A.startdate DESC";
$rs = &$conn->execute($sqlpe); $bil=0;
?>
<table width="95%" border="1" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor="#CCCCCC">
    	<td width="5%" align="center"><b>Bil</b></td>
        <td width="10%" align="center"><b>Kod Kursus</b></td>
        <td width="45%" align="center"><b>Nama Kursus</b></td>
        <td width="15%" align="center"><b>Tarikh Mula</b></td>
        <td width="30%" align="center"><b>Tarikh Tamat</b></td>
    </tr>
<?php while(!$rs->EOF){ $bil++; 
	//$jawatan = dlookup2("_ref_titlegred","f_gred_code","f_gred_name","f_gred_id=".tosql($rs->fields['f_title_grade']));
?>
	<tr>
    	<td align="right"><?php print $bil;?>.</td>
    	<td align="left"><?php print $rs->fields['courseid'];?></td>
    	<td align="left"><?php print $rs->fields['coursename'];?></td>
    	<td align="center"><?php print DisplayDate($rs->fields['startdate']);?></td>
    	<td align="center"><?php print DisplayDate($rs->fields['enddate']);?></td>
    </tr>
<?php $rs->movenext(); } ?>	
</table>
</body>
</html>