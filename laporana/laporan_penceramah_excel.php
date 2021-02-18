<? include '../common.php'; 
header("Content-type: application/x-excel");
//header("Content-type: application/x-msdownload");
header ("Cache-Control: no-cache, must-revalidate");
header("Content-Disposition: attachment; filename=laporan_penceramah.xls");
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
<?php
$width="100%";
$pos=isset($_REQUEST["pos"])?$_REQUEST["pos"]:"";
$inskategori=isset($_REQUEST["inskategori"])?$_REQUEST["inskategori"]:"";
$penceramah=isset($_REQUEST["penceramah"])?$_REQUEST["penceramah"]:"";
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";

//if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sql_tkh = " AND startdate >= ".tosql($tkh_mula)." "; }
$strAddStDate=((strlen($tkh_mula)>0)?" AND B.startdate >= ".tosql(DBDate($tkh_mula))." ":"");
$strAddEndDate=((strlen($tkh_tamat)>0)?" AND B.enddate <= ".tosql(DBDate($tkh_tamat))." ":"");
$strPusat=((strlen($penceramah)>0)?" AND ingenid = ".tosql($penceramah)." ":"");
$strGred=((strlen($inskategori)>0)?" AND inskategori = ".tosql($inskategori)." ":"");

?>
<?php if(!empty($pos)){ ?>
<table width="<?=$width;?>">
    <tr><td width="100%">
        <table width="100%" align="center">
            <tr>
              <td align="center" width="15%">
                <div style="float:left"></div>
              </td>
              <td align="center" width="70%" colspan="3">
                <div><h3><I><B>INSTITUT LATIHAN ISLAM MALAYSIA<BR>JABATAN KEMAJUAN ISLAM MALAYSIA</B></I></h3></div>
              </td>
              <td align="center" width="15%">
                <div style="float:right">&nbsp;</div>
              </td>
            </tr>
        </table>
    </td></tr>
    <tr>
      <td align="center"><B>LAPORAN PENCERAMAH BERDASARKAN KURSUS
      <?php if(!empty($pusat)){ print "<br>NAMA PENCERAMAH : " . dlookup("_tbl_instructor","insname","ingenid=".tosql($penceramah)); }?>
      <?php if(!empty($grade)){ print "<br>KATEGORI : " . dlookup("_ref_kategori_penceramah","f_kp_kenyataan","f_kp_id=".tosql($inskategori)); }?>
      <?php if(!empty($tkh_mula) && !empty($tkh_tamat)){ print '<br>TARIKH '.$tkh_mula.' - '.$tkh_tamat; }
        else if(!empty($tkh_mula) && empty($tkh_tamat)){ print '<br>TARIKH '.$tkh_mula.' - '.date("d/m/Y"); }?>
      </B></td>
    </tr>
</table>

<table width="<?=$width;?>" class="data" border="1" cellpadding="3" cellspacing="0">
	<tr bgcolor="#CCCCCC">
    	<td rowspan="1" width="5%" align="center"><b>Bil</b></td>
        <td rowspan="1" width="25%" align="center"><b>Nama<br>No. KP</b></td>
        <td rowspan="1" width="20%" align="center"><b>Tempat Bertugas</b></td>
        <td rowspan="1" width="50%" align="center"><b>Tajuk Ceramah/Kursus&nbsp;<i>[Jumlah Jam]</i></b></td>
    </tr>
<?php
//$conn->debug=true;
$sql = "SELECT * FROM _tbl_instructor WHERE is_deleted=0";
$sql .= $strPusat . $strGred;
$sql .= " ORDER BY insname";
$rs = &$conn->execute($sql);
//$conn->debug=false;
if(!$rs->EOF){
	while(!$rs->EOF){
	$bil++;
	$sql1 = "SELECT A.tajuk, timediff(A.masa_tamat, A.masa_mula) AS masa, A.masa_mula, A.masa_tamat, C.coursename, B.startdate, B.enddate 
	FROM _tbl_kursus_jadual_masa A, _tbl_kursus_jadual B, _tbl_kursus C
	WHERE A.event_id=B.id AND B.courseid=C.id AND A.id_pensyarah=".tosql($rs->fields['ingenid']);
	$sql1 .= $strAddStDate.$strAddEndDate;
	$rs1 = $conn->execute($sql1);
?>
    <tr height="25">
    	<td align="right" valign="top"><?php print $bil;?>.&nbsp;</td>
        <td align="left" valign="top"><?php print $rs->fields['insname'];?><br><? print $rs->fields['insid'];?>&nbsp;</td>
        <td align="left" valign="top"><?php print $rs->fields['insorganization'];?>&nbsp;</td>
        <td align="center" valign="top">
        	<table width="100%" cellpadding="2" cellspacing="0" border="1" class="data">
            <?php while(!$rs1->EOF){ 
				$masa = $rs1->fields['masa'];
				if($masa=='00:00:00'){ $masa_disp = '-'; }
				else {
					$masa_disp = intval(substr($masa,0,2)). " Jam "; 
					$masa_disp .= ": ".substr($masa,3,2). " minit"; 
				}
			?>
            	<tr>
                	<td width="80%">
                        Kursus: <?php print $rs1->fields['coursename'];?><br>
                        Tarikh: <?php print DisplayDate($rs1->fields['startdate']);?>-<?php print DisplayDate($rs1->fields['enddate']);?><br>
                        Tajuk: <?php print $rs1->fields['tajuk'];?>&nbsp;
                    </td>
                    <td width="20%" align="center"><?php print $masa_disp;?>&nbsp;</td>
                </tr>
            <?php $rs1->movenext(); } ?>
            </table>
        </td>
    </tr>
<?php
		$rs->movenext();
	}	
}
?>
</table>
<?php } ?>
</body>
</html>