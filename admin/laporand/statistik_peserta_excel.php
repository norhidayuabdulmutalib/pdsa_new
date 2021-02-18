<? include '../common.php'; 
header("Content-type: application/x-excel");
//header("Content-type: application/x-msdownload");
header ("Cache-Control: no-cache, must-revalidate");
header("Content-Disposition: attachment; filename=statistik_peserta.xls");
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
$bulan=isset($_REQUEST["bulan"])?$_REQUEST["bulan"]:"";
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
              <td align="center" width="70%" colspan="5">
                <div><h3><I><B>INSTITUT LATIHAN ISLAM MALAYSIA<BR>JABATAN KEMAJUAN ISLAM MALAYSIA</B></I></h3></div>
              </td>
              <td align="center" width="15%">
                <div style="float:right">&nbsp;</div>
              </td>
            </tr>
        </table>
    </td></tr>
    <tr>
      <td align="center" colspan="1"><B>LAPORAN STATISTIK PESERTA KURSUS<BR></B></td>
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
    	<td rowspan="3" width="5%" align="center"><b>Bil</b></td>
        <td rowspan="3" width="20%" align="center"><b>Bulan</b></td>
        <td colspan="5" width="75%" align="center"><b>Maklumat Jumlah Kursus Yang Dijalankan Bagi Tahun <?=$tahun;?></b></td>
    </tr>
	<tr  bgcolor="#CCCCCC">
    	<td align="center" colspan="2" width="30%"><b>Kursus ILIM</b></td>
    	<td align="center" colspan="2" width="30%"><b>Kursus Luaran</b></td>
    	<td align="center" rowspan="2" width="15%"><b>Jumlah</b></td>
    </tr>    
	<tr  bgcolor="#CCCCCC">
    	<td align="center" width="15%"><b>Peserta Lelaki</b></td>
    	<td align="center" width="15%"><b>Peserta Perempuan</b></td>
    	<td align="center" width="15%"><b>Peserta Lelaki</b></td>
    	<td align="center" width="15%"><b>Peserta Perempuan</b></td>
    </tr>    
<?php
//$conn->debug=true;
if(!empty($bulan)){ $gb=$bulan; $mth=$bulan; } else { $gb=1; }
for($i=$gb;$i<=$mth;$i++){
	$bil++; $jum_kilim=0; $jum_kluar=0;
	if($i<10){ $gi='0'.$i; } else { $gi=$i; }
	$sql = "SELECT A.id, A.category_code, B.coursename AS Kursus, A.startdate, A.enddate FROM _tbl_kursus_jadual A, _tbl_kursus B 
		WHERE A.category_code=1 AND A.courseid=B.id AND year(startdate)=".tosql($tahun)." AND month(startdate)=".tosql($gi);
	$sql .= " UNION ";
	$sql .= "SELECT A.id, A.category_code, A.acourse_name AS Kursus, A.startdate, A.enddate FROM _tbl_kursus_jadual A 
		WHERE category_code<>1 AND year(startdate)=".tosql($tahun)." AND month(startdate)=".tosql($gi);
	$sql .= " ORDER BY startdate";
	$rs = &$conn->execute($sql);
	$cnt = $rs->recordcount();
	//$jum_papar=0;
	$jum_peserta=0;
	if(!$rs->EOF){
		$ilim_lelaki=0; $ilim_perempuan=0;
		$luar_lelaki=0; $luar_perempuan=0;
		while(!$rs->EOF){
			$kursus_cat='';
			$id=$rs->fields['id'];
			//$nama_kursus=$rs->fields['Kursus'];
			$category_code=$rs->fields['category_code'];
			if($category_code==1){
				$sql = "SELECT count(*) AS jumi FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
					WHERE B.f_peserta_noic=A.peserta_icno AND B.f_peserta_jantina='L'AND A.InternalStudentAccepted=1 AND A.is_selected=1 AND A.EventId=".tosql($id); // AND A.is_sijil=1 
				$rskursus = &$conn->execute($sql);	
				$ilim_lelaki += $rskursus->fields['jumi'];
				$sql = "SELECT count(*) AS jumi FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
					WHERE B.f_peserta_noic=A.peserta_icno AND B.f_peserta_jantina='P' AND A.InternalStudentAccepted=1 AND A.is_selected=1 AND A.EventId=".tosql($id); // AND A.is_sijil=1 
				$rskursus = &$conn->execute($sql);	
				$ilim_perempuan += $rskursus->fields['jumi'];
			} else if($category_code==2){
				$sql = "SELECT count(*) AS jumi FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
					WHERE B.f_peserta_noic=A.peserta_icno AND B.f_peserta_jantina='L' AND A.InternalStudentAccepted=1 AND A.is_selected=1 AND A.EventId=".tosql($id); // AND A.is_sijil=1 
				$rskursus = &$conn->execute($sql);	
				$luar_lelaki += $rskursus->fields['jumi'];
				$sql = "SELECT count(*) AS jumi FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B  
					WHERE B.f_peserta_noic=A.peserta_icno AND B.f_peserta_jantina='P' AND A.InternalStudentAccepted=1 AND A.is_selected=1 AND A.EventId=".tosql($id); // AND A.is_sijil=1 
				$rskursus = &$conn->execute($sql);	 
				$luar_perempuan += $rskursus->fields['jumi'];
			}
			
			//if($jum_papar==0){ 
			$rs->movenext();
			//$jum_papar++;
		}
		$jum_peserta=$ilim_lelaki+$ilim_perempuan+$luar_lelaki+$luar_perempuan;
		?>
			<tr bgcolor="<? if ($bil%2 == 1) echo $bg1; else echo $bg2 ?>">
				<td align="right" height="25" valign="top"><? print $bil;?>.&nbsp;</td>
				<td align="center" valign="top"><? print month($i);?>&nbsp;</td>
				<td align="center" valign="top"><? print $ilim_lelaki;?>&nbsp;</td>
				<td align="center" valign="top"><? print $ilim_perempuan;?>&nbsp;</td>
				<td align="center" valign="top"><? print $luar_lelaki;?>&nbsp;</td>
				<td align="center" valign="top"><? print $luar_perempuan;?>&nbsp;</td>
				<td align="center" valign="top"><? print $jum_peserta;?>&nbsp;</td>
			</tr>
		<?php
	} else {
	?>
        <tr bgcolor="<? if ($bil%2 == 1) echo $bg1; else echo $bg2 ?>">
            <td align="right" height="25" valign="top"><? print $bil;?>.&nbsp;</td>
            <td align="center" valign="top"><? print month($i);?>&nbsp;</td>
            <td align="center" valign="top">-&nbsp;</td>
            <td align="center" valign="top">-&nbsp;</td>
            <td align="center" valign="top">-&nbsp;</td>
            <td align="center" valign="top">-&nbsp;</td>
            <td align="center" valign="top">-&nbsp;</td>
        </tr>
<?php }
}	
?>
</table>
<div class="printButton" align="center">
    <input type="button" value="Paparan Graph" onClick="do_open('statistik_peserta_graph_bar.php?tahun=<?=$tahun;?>')" style="cursor:pointer" />
    <input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup window" style="cursor:pointer">
</div>
</body>
</html>