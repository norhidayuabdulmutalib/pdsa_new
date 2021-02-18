<? include '../common.php'; 
header("Content-type: application/x-excel");
//header("Content-type: application/x-msdownload");
header ("Cache-Control: no-cache, must-revalidate");
header("Content-Disposition: attachment; filename=kursus_dihadir.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>Institut Latihan Islam Malaysia</title>
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
$get_data = isset($_REQUEST["data"])?$_REQUEST["data"]:"";
$width="100%";
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";
$pusat=isset($_REQUEST["pusat"])?$_REQUEST["pusat"]:"";
$grade=isset($_REQUEST["grade"])?$_REQUEST["grade"]:"";
$peserta=isset($_REQUEST["peserta"])?$_REQUEST["peserta"]:"";

//if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sql_tkh = " AND startdate >= ".tosql($tkh_mula)." "; }
$strAddStDate=((strlen($tkh_mula)>0)?" AND C.startdate >= ".tosql(DBDate($tkh_mula))." ":"");
$strAddEndDate=((strlen($tkh_tamat)>0)?" AND C.enddate <= ".tosql(DBDate($tkh_tamat))." ":"");
$strPusat=((strlen($pusat)>0)?" AND BranchCd = ".tosql($pusat)." ":"");
$strGred=((strlen($grade)>0)?" AND f_title_grade = ".tosql($grade)." ":"");

?>
<?php if(!empty($pusat) || !empty($grade)){ 
$sqlpe = "SELECT * FROM _tbl_peserta WHERE is_deleted=0 ";
if(!empty($pusat)){ $sqlpe .= " AND BranchCd=".tosql($pusat); }
if(!empty($grade)){ $sqlpe .= " AND f_title_grade=".tosql($grade); }
$sqlpe .= " ORDER BY f_peserta_nama";
//$conn->debug=true;
$rs = &$conn->execute($sqlpe); $bil=0;
?>
<table width="95%" border="1" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor="#CCCCCC">
    	<td width="5%" align="center"><b>Bil</b></td>
        <td width="45%" align="center"><b>Nama</b></td>
        <td width="15%" align="center"><b>No. KP</b></td>
        <td width="30%" align="center"><b>Jawatan</b></td>
    </tr>
<?php while(!$rs->EOF){ $bil++; 
	$jawatan = dlookup2("_ref_titlegred","f_gred_code","f_gred_name","f_gred_id=".tosql($rs->fields['f_title_grade']));
?>
	<tr>
    	<td align="right"><?php print $bil;?>.</td>
    	<td align="left"><?php print $rs->fields['f_peserta_nama'];?></td>
    	<td align="center"><?php print $rs->fields['f_peserta_noic'];?>&nbsp;</td>
    	<td align="left"><?php print $jawatan;?></td>
    </tr>
<?php $rs->movenext(); } ?>	
</table>
<?php } ?>
</body>
</html>