<? include '../common.php'; 
header("Content-type: application/x-excel");
//header("Content-type: application/x-msdownload");
header ("Cache-Control: no-cache, must-revalidate");
header("Content-Disposition: attachment; filename=laporan_pengunaan_bilik.xls");
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
$kursus=isset($_REQUEST["kursus"])?$_REQUEST["kursus"]:"";
$width="100%";
$sqly = "SELECT DISTINCT year(startdate) AS yr FROM _tbl_kursus_jadual WHERE year(startdate)<>0 ORDER BY year(startdate) DESC ";
$rsyear = &$conn->execute($sqly);
//$conn->debug=true;
/*$curmth = date("m");
$curyr = date("Y");
if($tahun==$curyr){ $mth = $curmth; } else { $mth=12; }*/
?>
<?php if(!empty($bulan) && !empty($tahun) && !empty($kursus)){ ?>
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
      <td align="center"><B>LAPORAN SENARAI PENGGUNA BILIK ASRAMA<BR>
      </B></td>
    </tr>
</table>
<?php
if(!empty($kursus)){ $sqlku = " AND A.id=".tosql($kursus); } else { $sqlku=''; }
if(!empty($bulan)){ $gb=$bulan; $mth=$bulan; } else { $gb=1; }
//for($i=$gb;$i<=$mth;$i++){
	$bil++; $jum_kilim=0; $jum_kluar=0;
	if(!empty($bulan)){ $gb=$bulan; $mth=$bulan; } else { $gb=1; }
	if($gb<10){ $gi='0'.$gb; } else { $gi=$gb; }
	$sql = "SELECT A.id, A.category_code, B.coursename AS Kursus, A.startdate, A.enddate FROM _tbl_kursus_jadual A, _tbl_kursus B 
		WHERE A.category_code=1 AND A.courseid=B.id AND year(startdate)=".tosql($tahun)." AND month(startdate)=".tosql($gi).$sqlku;
	$sql .= " UNION ";
	$sql .= "SELECT A.id, A.category_code, A.acourse_name AS Kursus, A.startdate, A.enddate FROM _tbl_kursus_jadual A 
		WHERE category_code<>1 AND year(startdate)=".tosql($tahun)." AND month(startdate)=".tosql($gi).$sqlku;
	$sql .= " ORDER BY startdate";
	$rs = &$conn->execute($sql);
	$cnt = $rs->recordcount();
	$jum_papar=0;
	if(!$rs->EOF){
		$nama_kursus=$rs->fields['Kursus'];
		$tarikh = DisplayDate($rs->fields['startdate'])."-".DisplayDate($rs->fields['enddate']);
		if($rs->fields['category_code']==1){ $kursus_cat = 'Kursus ILIM'; } else { $kursus_cat='<i>Kursus Luar</i>'; } 
?>	
<table width="<?=$width;?>" class="data" border="1" cellpadding="3" cellspacing="0">
	<tr>
    	<td><b>Bulan : </b></td>
        <td colspan="3"><? print month($gb)." / ".$tahun;?></td>
    </tr>
	<tr>
    	<td><b>Kursus : </b></td>
        <td colspan="3"><? print $nama_kursus."<i> (".$tarikh.")</i>";?> &nbsp;<? print $kursus_cat;?>&nbsp;</td>
    </tr>
</table>
<table width="100%" cellpadding="2" cellspacing="0" border="1" class="data" >
    <tr bgcolor="#CCCCCC">
        <td align="center" width="5%"><b>Bil</b></td>
        <td align="center" width="60%"><b>Nama Peserta</b></td>
        <td align="center" width="25%"><b>No. Telefon</b></td>
        <td align="center" width="10%"><b>No. Bilik</b></td>
    </tr>
<?
		//while(!$rs->EOF){
			//$conn->debug=true;
			$kursus_cat='';
			$nama_kursus=$rs->fields['Kursus'];
			$tarikh = DisplayDate($rs->fields['startdate'])."-".DisplayDate($rs->fields['enddate']);
			$gid=$rs->fields['id'];
			if($rs->fields['category_code']==1){ $kursus_cat = 'Kursus ILIM'; 
				$sqld = "SELECT A.*, B.f_peserta_nama AS Nama, B.f_peserta_hp AS tel
				FROM _sis_a_tblasrama A, _tbl_peserta B 
				WHERE A.peserta_id=B.f_peserta_noic AND A.kursus_type='I' AND A.event_id=".tosql($gid);
			} else { 
				$kursus_cat='<i>Kursus Luar</i>'; 
				$sqld .= "SELECT A.*, A.nama_peserta AS Nama, A.no_tel AS tel FROM _sis_a_tblasrama A
				WHERE A.kursus_type='L' AND A.event_id=".tosql($gid);
			} 
			$rsdata = &$conn->execute($sqld);	
			$conn->debug=false;
		
			if(!$rsdata->EOF){ 
				$bil=0;
				while(!$rsdata->EOF){ $bil++; ?>
					<tr>
						<td align="right"><?php print $bil;?>.&nbsp;</td>
						<td align="left"><?php print $rsdata->fields['Nama'];?>&nbsp;</td>
						<td align="center"><?php print $rsdata->fields['tel'];?>&nbsp;</td>
						<td align="center"><?php print dlookup("_sis_a_tblbilik","no_bilik","bilik_id=".tosql($rsdata->fields['bilik_id']));?>&nbsp;</td>
					</tr>
				<? $rsdata->movenext(); 
				} 
			}  // end while rsdata 
		//} //end if
		//$rs->movenext();
		//$jum_papar++;
	}  // end if
//}  // end for
?>
</table>
<div class="printButton" align="center">
    <input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup window" style="cursor:pointer">
</div>
</body>
</html>
<?php } ?>