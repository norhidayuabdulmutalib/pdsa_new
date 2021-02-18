<?php include '../common_modal.php'; ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>Institut Latihan Islam Malaysia</title>
<script language="javascript" type="text/javascript">	
function do_close(){
	window.close();
}
function handleprint(){
	window.print();
}
function do_post(){
	document.ilim.action='laporan_perlaksanna_kursus.php';
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
<?
//$conn->debug=true;
$tahun=isset($_REQUEST["tahun"])?$_REQUEST["tahun"]:date("Y");
$bulan=isset($_REQUEST["bulan"])?$_REQUEST["bulan"]:"";
$kursus=isset($_REQUEST["kursus"])?$_REQUEST["kursus"]:"";
$width="100%";
$sqly = "SELECT DISTINCT year(startdate) AS yr FROM _tbl_kursus_jadual WHERE year(startdate)<>0 ORDER BY year(startdate) DESC ";
//$rsyear = &$conn->execute($sqly);
//$conn->debug=true;
/*$curmth = date("m");
$curyr = date("Y");
if($tahun==$curyr){ $mth = $curmth; } else { $mth=12; }*/
$curmth = date("m");
$curyr = date("Y");
?>
<form name="ilim" method="post" action="">
<div class="printButton" align="center">
<table width="<?=$width?>" border="0" align="center" cellpadding="1" cellspacing="0">
	<tr>
	  <td colspan="2" align="center"><b>PROSES CETAKAN LAPORAN PELAKSANAAN KURSUS / PROGRAM DI ILIM</b><BR /></td></tr>
    <tr>
        <td align="center">Pilih Tahun : 
            <select name="tahun" onChange="do_post()">
            <?php for($y=$curyr;$y>=2008;$y--){ ?>
            	<option value="<?=$y;?>"<?php if($tahun==$y){ print 'selected'; }?>><?=$y?></option>
            <?php  } ?>
            </select> 
        &nbsp;&nbsp;&nbsp;
        Pilih Bulan : 
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
	    <input type="button" value="Salin Ke Excel" onClick="do_open('laporan_perlaksanna_kursus_excel.php?tahun=<?=$tahun;?>&bulan=<?=$bulan;?>&kursus=<?=$kursus;?>')" style="cursor:pointer" />
        <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup window" style="cursor:pointer">
        </td>
    </tr>
</table>
</div>
</form>
<?php //if(!empty($bulan) && !empty($tahun)){ // && !empty($kursus)?>
<?php if(!empty($tahun) && !empty($bulan) || !empty($kursus)){ // && !empty($kursus)?>
<table width="<?=$width;?>">
    <tr><td width="100%">
        <table width="100%" align="center">
            <tr>
              <td align="center" width="15%">
                <div style="float:left"><img src="../images/crestmalaysia.gif" border="0" width="90" height="68" /></div>
              </td>
              <td align="center" width="70%">
                <div><h3><I><B>INSTITUT LATIHAN ISLAM MALAYSIA<BR>JABATAN KEMAJUAN ISLAM MALAYSIA</B></I></h3></div>
              </td>
              <td align="center" width="15%">
                <div style="float:right">&nbsp;</div>
              </td>
            </tr>
        </table>
    </td></tr>
    <tr><td width="100%">
        <table width="100%" align="center">
            <tr>
              <td align="center" colspan="3"><B>LAPORAN PELAKSANAAN KURSUS / PROGRAM DI ILIM</B></td>
            </tr>
            <tr>
              <td align="center" width="100%" style="border-bottom:thin;" colspan="3"><b>
              <?php if(!empty($bulan)){ ?>BULAN : <u><?php print month($bulan);?></u> <?php } ?>
              <?php if(!empty($tahun)){ ?>TAHUN : <u><?php print $tahun;?></u><?php } ?>
              </b></td>
            </tr>
        </table>
  </td></tr>
</table>
<table width="100%" cellpadding="3" cellspacing="0" border="1" class="data" >
    <tr bgcolor="#CCCCCC">
        <td align="center" width="5%"><b>BIL</b></td>
        <td align="center" width="15%"><b>NAMA PROGRAM</b></td>
        <td align="center" width="10%"><b>TARIKH</b></td>
        <td align="center" width="5%"><b>BILANGAN PESERTA</b></td>
        <td align="center" width="15%"><b>PUSAT</b></td>
        <td align="center" width="25%"><b>KUMPULAN SASARAN</b></td>
        <td align="center" width="10%"><b>KOS</b></td>
        <td align="center" width="15%"><b>CATATAN</b></td>
    </tr>
<?
	$sqld = "SELECT A.*, B.ksasar
	FROM _tbl_kursus_jadual A, _tbl_kursus B
	WHERE A.sub_category_code=B.id AND A.category_code=1 AND year(A.startdate)=".tosql($tahun)." AND month(A.startdate)=".tosql($bulan);
	//if(!empty($kursus)){ $sqld .=" AND A.sub_category_code=".tosql($kursus); }
	//$conn->debug=true;
	$rsdata = &$conn->execute($sqld);	

	if(!$rsdata->EOF){ 
		$bil=0;
		while(!$rsdata->EOF){ $bil++;  $penceramah='';
			//$kos = number_format($rsdata->fields['jumkos_sebenar'],2);
			//$kos_ceramah = number_format($rsdata->fields['jumkceramah_sebenar'],2);
			$sub_category_code = $rsdata->fields['sub_category_code'];
			$kos = $rsdata->fields['jumkos'];
			$kos_ceramah = $rsdata->fields['jumkceramah'];
			$ksasar = $rsdata->fields['ksasar'];
			if($rsdata->fields['category_code']=='1'){ $kursus = dlookup("_tbl_kursus","coursename","id=".tosql($rsdata->fields['courseid'])); }
			else { $kursus = $rsdata->fields['acourse_name']; }
			$tarikh = DisplayDate($rsdata->fields['startdate'])."<br>-<br>".DisplayDate($rsdata->fields['enddate']);

			// delete on 26-12-2011 - laporan on email dec 20, 2011
			$sqlj = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
			WHERE A.peserta_icno=B.f_peserta_noic AND A.is_selected IN (1) AND  
			A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id']). "  GROUP BY A.peserta_icno";
			$rsj = &$conn->Execute($sqlj); $jakim1 = $rsj->recordcount();

			/*$sqlj = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=1 AND A.is_selected IN (1,9) AND  
			A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id']). "  GROUP BY A.peserta_icno";
			$rsj = &$conn->Execute($sqlj); $jakim = $rsj->recordcount();
			
			$sqlj = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=2 AND A.is_selected IN (1,9) AND  
			A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id']). "  GROUP BY A.peserta_icno";
			$rsj = &$conn->Execute($sqlj); $jain = $rsj->recordcount();
			//print $sqlj;
			$sqlj = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=3 AND A.is_selected IN (1,9) AND  
			A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id']). "  GROUP BY A.peserta_icno";
			$rsj = &$conn->Execute($sqlj); $main = $rsj->recordcount();
			$sqlj = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=4 AND A.is_selected IN (1,9) AND  
			A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id']). "  GROUP BY A.peserta_icno";
			$rsj = &$conn->Execute($sqlj); $jmufti = $rsj->recordcount();
			/*$sqljlain = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=5 AND  
			A.InternalStudentAccepted=1 AND A.EventId=".tosql($rsdata->fields['id']);
			$rsj = &$conn->Execute($sqljlain); $lain = $rsj->recordcount();*

			$sqljlain = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid>=5 AND A.is_selected IN (1,9) AND  
			A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id']). "  GROUP BY A.peserta_icno";
			$rsj = &$conn->Execute($sqljlain); $lain = $rsj->recordcount();
			$sqlj = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B
			WHERE A.peserta_icno=B.f_peserta_noic AND A.InternalStudentAccepted=1 AND B.BranchCd='0099' AND A.is_selected IN (1,9) AND 
			A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id']). "  GROUP BY A.peserta_icno";
			$rsj = &$conn->Execute($sqlj); $lain += $rsj->recordcount();
			//print $sqljlain;
			//dlookup("","","")
			$jumlah = $jakim+$jain+$main+$jmufti+$lain;*/
			$cost = $kos_ceramah + $kos;
		?>
			<tr>
				<td align="right" valign="top"><?php print $bil;?>.&nbsp;</td>
				<td align="left" valign="top"><?php print stripslashes($kursus);?>&nbsp;</td>
				<td align="center" valign="top"><?php print $tarikh;?></td>
				<td align="center">&nbsp;<?php if(!empty($jakim1)){ print $jakim1."<br>orang"; }?>&nbsp;</td>
				<td align="center" valign="top"><?php print dlookup("_tbl_kursus_catsub","SubCategoryDesc","id=".tosql($sub_category_code));?>&nbsp;</td>
				<td align="left" valign="top"><?php print $ksasar;?>&nbsp;</td>
				<td align="right" valign="top">RM<?php print number_format($cost,2); ?>&nbsp;</td>
                <td>&nbsp;</td>

			</tr>
		<? $rsdata->movenext(); 
		} 
	}  // end while rsdata 
?>
</table>
<div class="printButton" align="center">
    <input type="button" value="Salin Ke Excel" onClick="do_open('laporan_bulanan_aktiviti_excel.php?tahun=<?=$tahun;?>&bulan=<?=$bulan;?>&kursus=<?=$kursus;?>')" style="cursor:pointer" />
    <input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup window" style="cursor:pointer">
</div>
</body>
</html>
<?php } ?>