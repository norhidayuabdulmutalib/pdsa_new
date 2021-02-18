<? include '../common.php'; 
$type=isset($_REQUEST["type"])?$_REQUEST["type"]:"";
//$conn->debug=true;
$tahun=isset($_REQUEST["tahun"])?$_REQUEST["tahun"]:date("Y");
$bulan=isset($_REQUEST["bulan"])?$_REQUEST["bulan"]:"";
$kursus=isset($_REQUEST["kursus"])?$_REQUEST["kursus"]:"";
if($type=='EXCEL'){
	header("Content-type: application/x-excel");
	//header("Content-type: application/x-msdownload");
	header ("Cache-Control: no-cache, must-revalidate");
	header("Content-Disposition: attachment; filename=laporan_pengunaan_bilik.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>Institut Latihan Islam Malaysia</title>
<link href="../css/template-css.css" rel="stylesheet" type="text/css" media="screen">
<script language="javascript" type="text/javascript">	
function do_close(){
	window.close();
}
function handleprint(){
	window.print();
}
function do_post(){
	document.ilim.action = 'laporan_pengunaan_bilik.php';
	document.ilim.target = '_self';
	document.ilim.submit();
}
function do_open(URL){
	document.ilim.action = URL;
	document.ilim.target = '_blank';
	document.ilim.submit();
}
</script>
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
//$conn->debug=true;
$width="100%";
$sqly = "SELECT DISTINCT year(startdate) AS yr FROM _tbl_kursus_jadual WHERE status IN (0,9) AND asrama_perlu='ASRAMA' AND 
year(startdate)<>0 ORDER BY year(startdate) DESC ";
$rsyear = &$conn->execute($sqly);
/*$curmth = date("m");
$curyr = date("Y");
if($tahun==$curyr){ $mth = $curmth; } else { $mth=12; }*/
?>
<form name="ilim" method="post" action="">
<?php if($type<>'EXCEL'){ ?>
<div class="printButton" align="center">
<table width="<?=$width?>" border="0" align="center" cellpadding="1" cellspacing="0">
	<tr>
	  <td colspan="2" align="center"><b>PROSES CETAKAN LAPORAN PENGGUNA BILIK ASRAMA</b><BR /></td></tr>
    <tr>
        <td align="center">Pilih Tahun : 
            <select name="tahun" onChange="do_post()">
            <?php while(!$rsyear->EOF){ ?>
            	<option value="<?=$rsyear->fields['yr'];?>"<?php if($tahun==$rsyear->fields['yr']){ print 'selected'; }?>><?=$rsyear->fields['yr'];?></option>
            <?php $rsyear->movenext(); } ?>
            </select> 
        </td>   
    </tr>
    <tr>
        <td align="center">Pilih Bulan : 
            <select name="bulan" onChange="do_post()">
            	<option value="">-- pilih bulan --</option>
            	<option value="01"<?php if($bulan=='01'){ print 'selected'; }?>>Januari</option>
            	<option value="02"<?php if($bulan=='02'){ print 'selected'; }?>>Februari</option>
            	<option value="03"<?php if($bulan=='03'){ print 'selected'; }?>>Mac</option>
            	<option value="04"<?php if($bulan=='04'){ print 'selected'; }?>>April</option>
            	<option value="05"<?php if($bulan=='05'){ print 'selected'; }?>>Mei</option>
            	<option value="06"<?php if($bulan=='06'){ print 'selected'; }?>>Jun</option>
            	<option value="07"<?php if($bulan=='07'){ print 'selected'; }?>>Julai</option>
            	<option value="08"<?php if($bulan=='08'){ print 'selected'; }?>>Ogos</option>
            	<option value="09"<?php if($bulan=='09'){ print 'selected'; }?>>September</option>
            	<option value="10"<?php if($bulan=='10'){ print 'selected'; }?>>Oktober</option>
            	<option value="11"<?php if($bulan=='11'){ print 'selected'; }?>>November</option>
            	<option value="12"<?php if($bulan=='12'){ print 'selected'; }?>>Disember</option>
            </select> 
        </td>   
    </tr>
    <?php
	//$conn->debug=true;
	//if(!empty($bulan)){ $gb=$bulan; $mth=$bulan; } else { $gb=1; }
	//if($gb<10){ $gi='0'.$gb; } else { $gi=$gb; }
	$sql = "SELECT A.id, A.category_code, B.coursename AS Kursus, A.startdate, A.enddate FROM _tbl_kursus_jadual A, _tbl_kursus B 
		WHERE A.category_code=1 AND A.courseid=B.id AND A.status IN (0,9) AND A.asrama_perlu='ASRAMA' AND 
		year(startdate)=".tosql($tahun)." AND month(startdate)=".tosql($bulan);
	$sql .= " UNION ";
	$sql .= "SELECT A.id, A.category_code, A.acourse_name AS Kursus, A.startdate, A.enddate FROM _tbl_kursus_jadual A 
		WHERE category_code<>1 AND A.status IN (0,9) AND A.asrama_perlu='ASRAMA' AND 
		year(startdate)=".tosql($tahun)." AND month(startdate)=".tosql($bulan);
	$sql .= " ORDER BY startdate";
	$rsk = &$conn->execute($sql);
	?>
    <tr>
        <td align="center">Pilih Kursus : 
            <select name="kursus" onChange="do_post()">
            	<option value="">-- pilih kursus --</option>
            <?php while(!$rsk->EOF){ ?>
            	<option value="<?php print $rsk->fields['id'];?>" <?php if($kursus==$rsk->fields['id']){ print 'selected'; }?>><?php print $rsk->fields['Kursus']." [".DisplayDate($rsk->fields['startdate'])."-".DisplayDate($rsk->fields['enddate'])."]";?></option>
            <?php $rsk->movenext(); } ?>    
            </select> 
        </td>   
    </tr>
    <tr>
        <td align="center" colspan="2"><input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
	    <!--<input type="button" value="Salin Ke Excel" onClick="do_open('laporan_pengunaan_bilik_excel.php?tahun=<?=$tahun;?>&bulan=<?=$bulan;?>&kursus=<?=$kursus;?>')" style="cursor:pointer" />-->
	    <input type="button" value="Salin Ke Excel" onClick="do_open('laporan_pengunaan_bilik.php?type=EXCEL&tahun=<?=$tahun;?>&bulan=<?=$bulan;?>&kursus=<?=$kursus;?>')" style="cursor:pointer" />
        <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup window" style="cursor:pointer">
        </td>
    </tr>
</table>
</div>
<?php } ?>
</form>
<?php //if(!empty($bulan) && !empty($tahun) && !empty($kursus)){ ?>
<?php if(!empty($bulan) && !empty($tahun)){ 

$sql = "SELECT A.id, A.category_code, B.coursename AS Kursus, A.startdate, A.enddate 
	FROM _tbl_kursus_jadual A, _tbl_kursus B 
	WHERE A.category_code=1 AND A.status IN (0,9) AND asrama_perlu='ASRAMA' AND 
	A.courseid=B.id AND year(startdate)=".tosql($tahun)." AND month(startdate)=".tosql($bulan);
if(!empty($kursus)){ $sql .= " AND A.id=".tosql($kursus); }

$sql .= " UNION ";

$sql .= "SELECT A.id, A.category_code, A.acourse_name AS Kursus, A.startdate, A.enddate 
	FROM _tbl_kursus_jadual A 
	WHERE category_code<>1 AND status IN (0,9) AND asrama_perlu='ASRAMA' 
	AND year(startdate)=".tosql($tahun)." AND month(startdate)=".tosql($bulan);
if(!empty($kursus)){ $sql .= " AND A.id=".tosql($kursus); }
$sql .= " ORDER BY startdate";

$rsk = &$conn->execute($sql);

while(!$rsk->EOF){ 
?>
<table width="700px" align="center">
    <tr>
      <td align="center" width="100px">
        <div style="float:left"><img src="../images/crestmalaysia.gif" border="0" width="90" height="68" /></div>
      </td>
      <td align="center" width="500px" colspan="5">
        <div><h3><I><B>INSTITUT LATIHAN ISLAM MALAYSIA<BR>JABATAN KEMAJUAN ISLAM MALAYSIA</B></I></h3></div>
      </td>
      <td align="center" width="100px">
        <div style="float:right">&nbsp;</div>
      </td>
    </tr>
    <!--<tr>
      <td align="center" colspan="3" style="border-bottom:solid;border-top:solid;"><I>Ampang Pecah, Kuala Kubu Bahru, 44000 Selangor</I></td>
    </tr>-->
    <tr>
      <td align="center" colspan="7"><B>LAPORAN SENARAI PENGGUNA BILIK ASRAMA<BR>
      </B></td>
    </tr>
</table>
<?php
/*if(!empty($kursus)){ $sqlku = " AND A.id=".tosql($kursus); } else { $sqlku=''; }
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
	if(!$rs->EOF){*/
	$nama_kursus=$rsk->fields['Kursus'];
	$tarikh = DisplayDate($rsk->fields['startdate'])."-".DisplayDate($rsk->fields['enddate']);
	if($rsk->fields['category_code']==1){ $kursus_cat = 'Kursus ILIM'; } else { $kursus_cat='<i>Kursus Luar</i>'; } 
?>	
<table width="<?=$width;?>" class="data" border="1" cellpadding="3" cellspacing="0">
	<tr>
    	<td width="100px" colspan="2"><b>Bulan : </b></td>
        <td width="600px" colspan="5" align="left">&nbsp;<? print month($bulan)." / ".$tahun;?></td>
    </tr>
	<tr>
    	<td colspan="2"><b>Kursus : </b></td>
        <td colspan="5">&nbsp;<? print $nama_kursus."<i> (".$tarikh.")</i>";?> &nbsp;<? print $kursus_cat;?>&nbsp;</td>
    </tr>
</table>
<table width="100%" cellpadding="2" cellspacing="0" border="1" class="data" >
    <tr bgcolor="#CCCCCC">
        <td align="center" colspan="1" width="50px"><b>Bil</b></td>
        <td align="center" colspan="4" width="400px"><b>Nama Peserta</b></td>
        <td align="center" colspan="1" width="150px"><b>No. Telefon</b></td>
        <td align="center" colspan="1" width="100px"><b>No. Bilik</b></td>
    </tr>
<?
		//while(!$rs->EOF){
			//$conn->debug=true;
			$kursus_cat='';
			$nama_kursus=$rsk->fields['Kursus'];
			$tarikh = DisplayDate($rsk->fields['startdate'])."-".DisplayDate($rsk->fields['enddate']);
			$gid=$rsk->fields['id'];
			if($rsk->fields['category_code']==1){ $kursus_cat = 'Kursus ILIM'; 
				$sqld = "SELECT A.*, B.f_peserta_nama AS Nama, B.f_peserta_hp AS tel
				FROM _sis_a_tblasrama A, _tbl_peserta B 
				WHERE A.peserta_id=B.f_peserta_noic AND A.kursus_type='I' AND A.event_id=".tosql($gid);
			} else { 
				$kursus_cat='<i>Kursus Luar</i>'; 
				$sqld = " SELECT A.*, A.nama_peserta AS Nama, A.no_tel AS tel FROM _sis_a_tblasrama A
				WHERE A.kursus_type='L' AND A.event_id=".tosql($gid);
			} 
			$rsdata = &$conn->execute($sqld);	
			$conn->debug=false;
		
			if(!$rsdata->EOF){ 
				$bil=0;
				while(!$rsdata->EOF){ $bil++; ?>
					<tr>
						<td align="right"><?php print $bil;?>.&nbsp;</td>
						<td align="left" colspan="4"><?php print $rsdata->fields['Nama'];?>&nbsp;</td>
						<td align="center"><?php print $rsdata->fields['tel'];?>&nbsp;</td>
						<td align="center"><?php print dlookup("_sis_a_tblbilik","no_bilik","bilik_id=".tosql($rsdata->fields['bilik_id']));?>&nbsp;</td>
					</tr>
				<? $rsdata->movenext(); 
				} 
			}  // end while rsdata 
		//} //end if
		//$rs->movenext();
		//$jum_papar++;
	//}  // end if
//}  // end for
?>
</table>
<?php $rsk->movenext(); } ?>
<div class="printButton" align="center">
    <input type="button" value="Salin Ke Excel" onClick="do_open('laporan_pengunaan_bilik_excel.php?tahun=<?=$tahun;?>&bulan=<?=$bulan;?>&kursus=<?=$kursus;?>')" style="cursor:pointer" />
    <input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup window" style="cursor:pointer">
</div>
</body>
</html>
<?php } ?>