<? include '../common.php'; 
header("Content-type: application/x-excel");
//header("Content-type: application/x-msdownload");
header ("Cache-Control: no-cache, must-revalidate");
header("Content-Disposition: attachment; filename=bilangan_hari_kursus.xls");
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
$width="100%";
$pos=isset($_REQUEST["pos"])?$_REQUEST["pos"]:"";
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";
$pusat=isset($_REQUEST["pusat"])?$_REQUEST["pusat"]:"";
$grade=isset($_REQUEST["grade"])?$_REQUEST["grade"]:"";

//if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sql_tkh = " AND startdate >= ".tosql($tkh_mula)." "; }
$strAddStDate=((strlen($tkh_mula)>0)?" AND startdate >= ".tosql(DBDate($tkh_mula))." ":"");
$strAddEndDate=((strlen($tkh_tamat)>0)?" AND enddate <= ".tosql(DBDate($tkh_tamat))." ":"");
$strPusat=((strlen($pusat)>0)?" AND BranchCd = ".tosql($pusat)." ":"");
$strGred=((strlen($grade)>0)?" AND f_title_grade = ".tosql($grade)." ":"");

?>
<?php if(!empty($pos)){ ?>
<table width="<?=$width;?>">
    <tr><td width="100%">
        <table width="100%" align="center">
            <tr>
              <td align="center" width="15%">
                <div style="float:left"><img src="../images/crestmalaysia.gif" border="0" width="90" height="68" /></div>
              </td>
              <td align="center" width="70%" colspan="4">
                <div><h3><I><B>INSTITUT LATIHAN ISLAM MALAYSIA<BR>JABATAN KEMAJUAN ISLAM MALAYSIA</B></I></h3></div>
              </td>
              <td align="center" width="15%">
                <div style="float:right">&nbsp;</div>
              </td>
            </tr>
        </table>
    </td></tr>
    <tr>
      <td align="center"><B>LAPORAN KURSUS PEGAWAI BERDASARKAN BILANGAN HARI KURSUS
      <? if(!empty($pusat)){ print "<br>JABATAN/PUSAT : " . dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($pusat)); }?>
      <? if(!empty($grade)){ print "<br>BAGI GRED JAWATAN : " . dlookup2("_ref_titlegred","f_gred_code","f_gred_name","f_gred_id=".tosql($grade)); }?>
      <? if(!empty($tkh_mula) && !empty($tkh_tamat)){ print '<br>TARIKH '.$tkh_mula.' - '.$tkh_tamat; }
        else if(!empty($tkh_mula) && empty($tkh_tamat)){ print '<br>TARIKH '.$tkh_mula.' - '.date("d/m/Y"); }?>
      </B></td>
    </tr>
</table>

<table width="<?=$width;?>" class="data" border="1" cellpadding="3" cellspacing="0">
	<tr bgcolor="#CCCCCC">
    	<td rowspan="1" width="5%" align="center"><b>Bil</b></td>
        <td rowspan="1" width="50%" align="center"><b>Nama</b></td>
        <td rowspan="1" width="15%" align="center"><b>No. KP</b></td>
        <td rowspan="1" width="10%" align="center"><b>Jawatan</b></td>
        <td rowspan="1" width="10%" align="center"><b>Kursus ILIM<br>Bil Hari Kursus</b></td>
        <td rowspan="1" width="10%" align="center"><b>Kursus Luaran<br>Bil Hari Kursus</b></td>
    </tr>
<?
//$conn->debug=true;
$sql = "SELECT * FROM _tbl_peserta WHERE is_deleted=0";
$sql .= $strPusat . $strGred;
$sql .= " ORDER BY f_peserta_nama";
$rs = &$conn->execute($sql);
//$conn->debug=false;
if(!$rs->EOF){
	while(!$rs->EOF){
	$bil++;
	$jawatan = dlookup("_ref_titlegred","f_gred_code","f_gred_id=".tosql($rs->fields['f_title_grade']));
	$jum=0; $juml=0;
	$sql1 = "SELECT datediff(enddate, startdate)+1 as dt FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual C 
	WHERE A.EventId=C.id AND A.is_sijil=1 AND A.peserta_icno=".tosql($rs->fields['f_peserta_noic']);
	$sql1 .= $strAddStDate.$strAddEndDate;
	$rs1 = $conn->execute($sql1);
	while(!$rs1->EOF){
		$jum += $rs1->fields['dt'];
		$rs1->movenext();
	}
	if(empty($jum)){ $jum='-'; }
	$sql2 = "SELECT datediff(enddate, startdate)+1 as dt FROM _tbl_peserta_kursusluar 
	WHERE id_peserta=".tosql($rs->fields['id_peserta']);
	$sql2 .= $strAddStDate.$strAddEndDate;
	$rs2 = $conn->execute($sql2);
	while(!$rs2->EOF){
		$juml += $rs2->fields['dt'];
		$rs2->movenext();
	}
	if(empty($juml)){ $juml='-'; }
?>
    <tr height="25">
    	<td align="right" valign="top"><? print $bil;?>.&nbsp;</td>
        <td align="left" valign="top"><? print $rs->fields['f_peserta_nama'];?>&nbsp;</td>
        <td align="center" valign="top"><? print $rs->fields['f_peserta_noic'];?>&nbsp;</td>
        <td align="center" valign="top"><? print $jawatan;?>&nbsp;</td>
        <td align="center" valign="top"><? print $jum;?>&nbsp;</td>
        <td align="center" valign="top"><? print $juml;?>&nbsp;</td>
    </tr>
<?
		$rs->movenext();
	}	
}
?>
</table>
<?php } ?>
</body>
</html>