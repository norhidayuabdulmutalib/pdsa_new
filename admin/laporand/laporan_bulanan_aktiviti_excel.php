<?php include '../common_modal.php';
header("Content-type: application/x-excel");
//header("Content-type: application/x-msdownload");
header ("Cache-Control: no-cache, must-revalidate");
header("Content-Disposition: attachment; filename=laporan_bulanan_aktiviti.xls");
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
?>
<?php if(!empty($bulan) && !empty($tahun)){ //) && !empty($kursus) ?>
<table width="<?=$width;?>">
    <tr><td width="100%">
        <table width="100%" align="center">
            <tr>
              <td align="center" width="15%">
                <div style="float:left"></div>
              </td>
              <td align="center" width="70%" colspan="9">
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
              <td align="center" colspan="11"><B>LAPORAN BULANAN AKTIVITI/KURSUS DI INSTITUT LATIHAN ISLAM MALAYSIA (ILIM)</B></td>
            </tr>
            <tr>
              <td align="center" colspan="11"><B>BULAN : </B><b><u><?php print month($bulan)." " .$tahun;?></u></b></td>
            </tr>
            <?php if(!empty($kursus)){ ?>
            <tr>
              <td align="right"><B>PUSAT : </B></td>
              <td align="left" style="border-bottom:thin;border-bottom-style:dotted;"><?php print dlookup("_tbl_kursus_catsub","SubCategoryDesc","id=".tosql($kursus));?></td>
			  <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="right"><B>DISEDIAKAN OLEH : </B></td>
              <td align="left" style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</td>
			  <td>&nbsp;</td>
            </tr>
            <?php } ?>
        </table>
    </td></tr>
</table>
<table width="100%" cellpadding="2" cellspacing="0" border="1" class="data" >
    <tr bgcolor="#CCCCCC">
        <td align="center" rowspan="2" width="5%"><b>BIL</b></td>
        <td align="center" rowspan="2" width="15%"><b>NAMA AKTIVITI / KURSUS</b></td>
        <td align="center" rowspan="2" width="10%"><b>TARIKH</b></td>
        <td align="center" rowspan="2" width="20%"><b>SENARAI PENCERAMAH<BR>NAMA & INSTITUSI)</b></td>
        <td align="center" colspan="2" width="15%"><b>KOS KURSUS</b></td>
        <td align="center" colspan="5" width="30%"><b>PECAHAN JUMLAH PESERTA</b></td>
        <td align="center" rowspan="2" width="5%"><b>JUMLAH PESERTA</b></td>
    </tr>
	<tr>
        <td align="center" width="8%"><b>PENCERAMAH</b></td>
        <td align="center" width="7%"><b>MAKAN/ MINUM</b></td>
        <td align="center" width="5%"><b>JAKIM</b></td>
        <td align="center" width="5%"><b>JAIN</b></td>
        <td align="center" width="5%"><b>MAIN</b></td>
        <td align="center" width="5%"><b>JBTN MUFTI</b></td>
        <td align="center" width="10%"><b>LAIN-LAIN</b></td>
    </tr>
<?
	$sqld = "SELECT A.*
	FROM _tbl_kursus_jadual A
	WHERE category_code=1 AND year(A.startdate)=".tosql($tahun)." AND month(A.startdate)=".tosql($bulan);
	if(!empty($kursus)){ $sqld .=" AND A.sub_category_code=".tosql($kursus); }
	//$conn->debug=true;
	$rsdata = &$conn->execute($sqld);	

	if(!$rsdata->EOF){ 
		$bil=0;
		while(!$rsdata->EOF){ $bil++;  $penceramah='';
			//$kos = number_format($rsdata->fields['jumkos_sebenar'],2);
			//$kos_ceramah = number_format($rsdata->fields['jumkceramah_sebenar'],2);
			$kos = number_format($rsdata->fields['jumkos'],2);
			$kos_ceramah = number_format($rsdata->fields['jumkceramah'],2);
			if($rsdata->fields['category_code']=='1'){ $kursus = dlookup("_tbl_kursus","coursename","id=".tosql($rsdata->fields['courseid'])); }
			else { $kursus = $rsdata->fields['acourse_name']; }
			$tarikh = DisplayDate($rsdata->fields['startdate'])."<br>-<br>".DisplayDate($rsdata->fields['enddate']);
			$sqlp = "SELECT B.insname, B.insorganization FROM _tbl_kursus_jadual_det A, _tbl_instructor B WHERE A.instruct_id=B.ingenid AND A.event_id=".tosql($rsdata->fields['id']);
			$rsp = &$conn->Execute($sqlp); $bilp=0;
			while(!$rsp->EOF){
				if($bilp==0){ $penceramah .= $rsp->fields['insname'].'<br>'.$rsp->fields['insorganization']; }
				else { $penceramah .= "<br><br>".$rsp->fields['insname'].'<br>'.$rsp->fields['insorganization']; }
				$bilp++;
				$rsp->movenext();
			}
			// delete on 26-12-2011 - laporan on email dec 20, 2011
			$sqlj = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=1 AND A.is_selected=1 AND  
			A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id']);
			$rsj = &$conn->Execute($sqlj); $jakim = $rsj->recordcount();
			$sqlj = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=2 AND A.is_selected=1 AND  
			A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id']);
			$rsj = &$conn->Execute($sqlj); $jain = $rsj->recordcount();
			//print $sqlj;
			$sqlj = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=3 AND A.is_selected=1 AND  
			A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id']);
			$rsj = &$conn->Execute($sqlj); $main = $rsj->recordcount();
			$sqlj = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=4 AND A.is_selected=1 AND  
			A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id']);
			$rsj = &$conn->Execute($sqlj); $jmufti = $rsj->recordcount();
			/*$sqljlain = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=5 AND  
			A.InternalStudentAccepted=1 AND A.EventId=".tosql($rsdata->fields['id']);
			$rsj = &$conn->Execute($sqljlain); $lain = $rsj->recordcount();*/

			$sqljlain = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid>=5 AND A.is_selected=1 AND  
			A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id']);
			$rsj = &$conn->Execute($sqljlain); $lain = $rsj->recordcount();
			$sqlj = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B
			WHERE A.peserta_icno=B.f_peserta_noic AND A.InternalStudentAccepted=1 AND B.BranchCd='0099' AND A.is_selected=1 AND 
			A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id']);
			$rsj = &$conn->Execute($sqlj); $lain += $rsj->recordcount();
			//print $sqljlain;
			//dlookup("","","")
			$jumlah = $jakim+$jain+$main+$jmufti+$lain;
		?>
			<tr>
				<td align="right" valign="top"><?php print $bil;?>.&nbsp;</td>
				<td align="left" valign="top"><?php print stripslashes($kursus);?>&nbsp;</td>
				<td align="center" valign="top"><?php print $tarikh;?></td>
				<td align="center" valign="top"><?php print $penceramah;?>&nbsp;</td>
				<td align="center" valign="top"><?php if(!empty($kos_ceramah)){ print $kos_ceramah; }?></td>
				<td align="center" valign="top"><?php if(!empty($kos)){ print $kos; }?></td>
				<td align="center" valign="top">&nbsp;<?php if(!empty($jakim)){ print $jakim; }?>&nbsp;</td>
				<td align="center" valign="top">&nbsp;<?php if(!empty($jain)){ print $jain; }?>&nbsp;</td>
				<td align="center" valign="top">&nbsp;<?php if(!empty($main)){ print $main; }?>&nbsp;</td>
				<td align="center" valign="top">&nbsp;<?php if(!empty($jmufti)){ print $jmufti; }?>&nbsp;</td>
				<td align="left" valign="top"><div align="center"><?php if(!empty($lain)){ print $lain; }?></div>&nbsp;
					<?php if($lain>0){ 
                        //AND A.is_sijil=1
                        $sqljlain = "SELECT distinct B.BranchCd FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
                            WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid>=5 AND A.is_selected=1 AND  
                            A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id']);
                        $rsjlain = &$conn->Execute($sqljlain); $cnts=0;
                        while(!$rsjlain->EOF){ 
                            $cnts++;
                            print "<br>".$cnts.". ";
                            print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rsjlain->fields['BranchCd']));  
                            // AND A.is_sijil=1 
                            $sqljlain = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
                            WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid>=5 AND A.is_selected=1 
                            AND A.InternalStudentAccepted=1 AND B.is_deleted=0 AND A.EventId=".tosql($rsdata->fields['id'])." AND B.BranchCd=".$rsjlain->fields['BranchCd'];
                            $rsjl = &$conn->Execute($sqljlain); print "<br><i><u>(".$rsjl->recordcount()." Peserta)</u></i>";
                        $rsjlain->movenext(); }
                     } ?>
                     <?php 
                     $cnts++;
                     $sqlj = "SELECT A.* FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B
                        WHERE A.peserta_icno=B.f_peserta_noic AND A.InternalStudentAccepted=1 AND B.BranchCd='0099' AND A.is_selected=1 AND  
                        A.InternalStudentAccepted=1 AND A.EventId=".tosql($rsdata->fields['id']);
                     $rsjl = &$conn->Execute($sqlj); 
                     if(!$rsjl->EOF){
                        print "<br>".$cnts.". Lain-Lain<br><i><u>(".$rsjl->recordcount()." Peserta)</u></i>";
                     }
                    ?>
                </td>
				<td align="center" valign="top">&nbsp;<?php if(!empty($jumlah)){ print $jumlah; }?>&nbsp;</td>
			</tr>
		<? $rsdata->movenext(); 
		} 
	}  // end while rsdata 
?>
</table>
</body>
</html>
<?php } ?>