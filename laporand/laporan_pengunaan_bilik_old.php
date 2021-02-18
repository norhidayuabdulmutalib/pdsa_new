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
<script language="javascript" type="text/javascript">	
function do_close(){
	window.close();
}
function handleprint(){
	window.print();
}
function do_post(){
	document.ilim.target = '_self';
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
<?
//$conn->debug=true;
$tahun=isset($_REQUEST["tahun"])?$_REQUEST["tahun"]:date("Y");
$bulan=isset($_REQUEST["bulan"])?$_REQUEST["bulan"]:"";
$width="100%";
$sqly = "SELECT DISTINCT year(startdate) AS yr FROM _tbl_kursus_jadual WHERE year(startdate)<>0 ORDER BY year(startdate) DESC ";
$rsyear = &$conn->execute($sqly);
?>
<form name="ilim" method="post" action="laporan_pengunaan_bilik.php">
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
            	<option value="1"<?php if($bulan=='1'){ print 'selected'; }?>>Januari</option>
            	<option value="2"<?php if($bulan=='2'){ print 'selected'; }?>>Februari</option>
            	<option value="3"<?php if($bulan=='3'){ print 'selected'; }?>>Mac</option>
            	<option value="4"<?php if($bulan=='4'){ print 'selected'; }?>>April</option>
            	<option value="5"<?php if($bulan=='5'){ print 'selected'; }?>>Mei</option>
            	<option value="6"<?php if($bulan=='6'){ print 'selected'; }?>>Jun</option>
            	<option value="7"<?php if($bulan=='7'){ print 'selected'; }?>>Julai</option>
            	<option value="8"<?php if($bulan=='8'){ print 'selected'; }?>>Ogos</option>
            	<option value="9"<?php if($bulan=='9'){ print 'selected'; }?>>September</option>
            	<option value="10"<?php if($bulan=='10'){ print 'selected'; }?>>Oktober</option>
            	<option value="11"<?php if($bulan=='11'){ print 'selected'; }?>>November</option>
            	<option value="12"<?php if($bulan=='12'){ print 'selected'; }?>>Disember</option>
            </select> 
        </td>   
    </tr>
    <tr>
        <td align="center" colspan="2"><input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
        <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup window" style="cursor:pointer">
        </td>
    </tr>
</table>
</div>
</form>
<table width="<?=$width;?>">
    <tr><td width="100%">
        <table width="100%" align="center">
            <tr>
              <td align="center" width="15%">
                <div style="float:left"><img src="../../images/crestmalaysia.gif" border="0" width="90" height="68" /></div>
              </td>
              <td align="center" width="70%">
                <div><h3><I><B>INSTITUT LATIHAN ISLAM MALAYSIA<BR>JABATAN KEMAJUAN ISLAM MALAYSIA</B></I></h3></div>
              </td>
              <td align="center" width="15%">
                <div style="float:right">&nbsp;</div>
              </td>
            </tr>
            <!--<tr>
              <td align="center" colspan="3" style="border-bottom:solid;border-top:solid;"><I>Ampang Pecah, Kuala Kubu Bahru, 44000 Selangor</I></td>
            </tr>-->
        </table>
    </td></tr>
    <tr><td width="100%">
        <table width="100%" align="center">
            <tr>
              <td align="center"><B>LAPORAN SENARAI PENGGUNA BILIK ASRAMA<BR>
              </B></td>
            </tr>
        </table>
    </td></tr>
</table>
<?
//$conn->debug=true;
$curmth = date("m");
$curyr = date("Y");
if($tahun==$curyr){ $mth = $curmth; } else { $mth=12; }
?>
<table width="<?=$width;?>" class="data" border="1" cellpadding="3" cellspacing="0">
	<tr bgcolor="#CCCCCC">
    	<td rowspan="2" width="3%" align="center"><b>Bil</b></td>
        <td rowspan="2" width="10%" align="center"><b>Bulan</b></td>
        <td colspan="5" width="87%" align="center"><b>Maklumat Senarai Pengguna Bilik Asrama Bagi Tahun <?=$tahun;?></b></td>
    </tr>
	<tr  bgcolor="#CCCCCC">
    	<td align="center" width="25%"><b>Nama Kursus/Tarikh/Kategori</b></td>
    	<td align="center" width="62%"  colspan="3">&nbsp;</td>
    </tr>    
<?php
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
	$jum_papar=0;
	if(!$rs->EOF){
		while(!$rs->EOF){
			$kursus_cat='';
			$nama_kursus=$rs->fields['Kursus'];
			$tarikh = DisplayDate($rs->fields['startdate'])."-".DisplayDate($rs->fields['enddate']);
			$gid=$rs->fields['id'];
			if($rs->fields['category_code']==1){ $kursus_cat = 'Kursus ILIM'; } else { $kursus_cat='<i>Kursus Luar</i>'; } 
	
			//$conn->debug=true;
			$sql = "SELECT A.*, B.f_peserta_nama AS Nama, B.f_peserta_hp AS tel
				FROM _sis_a_tblasrama A, _tbl_peserta B 
				WHERE A.peserta_id=B.f_peserta_noic AND A.kursus_type='I' AND A.event_id=".tosql($gid);
			$sql .= " UNION ";
			$sql .= "SELECT A.*, A.nama_peserta AS Nama, A.no_tel AS tel FROM _sis_a_tblasrama A
				WHERE A.kursus_type='L' AND A.event_id=".tosql($gid);
			$rsdata = &$conn->execute($sql);	
			$conn->debug=false;
		
			if($jum_papar==0){ 
		?>
			<tr bgcolor="<? if ($bil%2 == 1) echo $bg1; else echo $bg2 ?>">
				<td rowspan="<?=$cnt;?>" align="right" height="25" valign="top"><? print $bil;?>.&nbsp;</td>
				<td rowspan="<?=$cnt;?>" align="center" valign="top"><? print month($i);?>&nbsp;</td>
				<td align="left" valign="top"><? print $nama_kursus."<br><i> (".$tarikh.")</i>";?><br><? print $kursus_cat;?>&nbsp;</td>
				<td align="center" valign="top" colspan="3">
                	<?php if(!$rsdata->EOF){ ?>
                    <table width="100%" cellpadding="2" cellspacing="0" border="1" class="data" >
                    	<tr bgcolor="#CCCCCC">
                            <td align="center" width="35%"><b>Nama Peserta</b></td>
                            <td align="center" width="15%"><b>No. Telefon</b></td>
                            <td align="center" width="10%"><b>No. Bilik</b></td>
                        </tr>
                    <?php while(!$rsdata->EOF){ ?>
                    	<tr>
                        	<td width="60%"><?php print $rsdata->fields['Nama'];?>&nbsp;</td>
                        	<td width="20%" align="center"><?php print $rsdata->fields['tel'];?>&nbsp;</td>
                        	<td width="20%" align="center"><?php print dlookup("_sis_a_tblbilik","no_bilik","bilik_id=".tosql($rsdata->fields['bilik_id']));?>&nbsp;</td>
                        </tr>
                    <? $rsdata->movenext(); } ?>
                    </table>
                    <?php } ?>&nbsp;
                </td>
			</tr>
		<?php
			} else {
		?>
			<tr bgcolor="<? if ($bil%2 == 1) echo $bg1; else echo $bg2 ?>">
				<td align="left" valign="top"><? print $nama_kursus."<br><i> (".$tarikh.")</i>";?><br><? print $kursus_cat;?>&nbsp;</td>
				<td align="center" valign="top" colspan="3">
                	<?php if(!$rsdata->EOF){ ?>
                    <table width="100%" cellpadding="2" cellspacing="0" border="1" class="data" >
                    	<tr bgcolor="#CCCCCC">
                            <td align="center" width="35%"><b>Nama Peserta</b></td>
                            <td align="center" width="15%"><b>No. Telefon</b></td>
                            <td align="center" width="10%"><b>No. Bilik</b></td>
                        </tr>
                    <?php while(!$rsdata->EOF){ ?>
                    	<tr>
                        	<td width="60%"><?php print $rsdata->fields['Nama'];?>&nbsp;</td>
                        	<td width="20%" align="center"><?php print $rsdata->fields['tel'];?>&nbsp;</td>
                        	<td width="20%" align="center"><?php print dlookup("_sis_a_tblbilik","no_bilik","bilik_id=".tosql($rsdata->fields['bilik_id']));?>&nbsp;</td>
                        </tr>
                    <? $rsdata->movenext(); } ?>
                    </table>
                    <?php } ?>&nbsp;
                </td>
			</tr>
		<?php
			}
			$rs->movenext();
			$jum_papar++;
		}
	} else {
	?>
			<tr bgcolor="<? if ($bil%2 == 1) echo $bg1; else echo $bg2 ?>">
				<td rowspan="<?=$cnt;?>" align="right" height="25" valign="top"><? print $bil;?>.&nbsp;</td>
				<td rowspan="<?=$cnt;?>" align="center" valign="top"><? print month($i);?>&nbsp;</td>
				<td align="left" valign="top">-&nbsp;</td>
				<td align="center" valign="top">-&nbsp;</td>
				<td align="center" valign="top">-&nbsp;</td>
				<td align="center" valign="top">-&nbsp;</td>
			</tr>
<?php }
}	
?>
</table>
<div class="printButton" align="center">
    <input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup window" style="cursor:pointer">
</div>
</body>
</html>