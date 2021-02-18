<? include '../common.php'; 
header("Content-type: application/x-excel");
//header("Content-type: application/x-msdownload");
header ("Cache-Control: no-cache, must-revalidate");
header("Content-Disposition: attachment; filename=pegawai_rpt.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
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
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";

//if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sql_tkh = " AND startdate >= ".tosql($tkh_mula)." "; }
$strAddStDate=((strlen($tkh_mula)>0)?" AND startdate >= ".tosql(DBDate($tkh_mula))." ":"");
$strAddEndDate=((strlen($tkh_tamat)>0)?" AND enddate <= ".tosql(DBDate($tkh_tamat))." ":"");

?>
<table width="<?=$width;?>">
    <tr><td width="100%">
        <table width="100%" align="center">
            <tr>
              <td align="center" width="15%">
                <div style="float:left"></div>
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
      <td align="center"><B>LAPORAN KURSUS PEGAWAI ILIM<BR>
      <?php if(!empty($tkh_mula) && !empty($tkh_tamat)){ print 'TARIKH '.$tkh_mula.' - '.$tkh_tamat;} 
      else if(!empty($tkh_mula) && empty($tkh_tamat)){ print 'TARIKH '.$tkh_mula.' - '.date("d/m/Y");}
      ?> 
      </B></td>
    </tr>
</table>

<table width="<?=$width;?>" class="data" border="1" cellpadding="3" cellspacing="0">
	<tr>
    	<td rowspan="2" width="5%" align="center"><b>Bil</b></td>
        <td rowspan="2" width="47%" align="center"><b>Jawatan</b></td>
        <td rowspan="1" width="36%" align="center" colspan="3"><b>Kursus Jangka Pendek</b></td>
        <td rowspan="2" width="12%" align="center"><b>Kursus Jangka Panjang</b></td>
    </tr>
	<tr>
        <td rowspan="1" width="12%" align="center"><b>Kursus < 7 Hari</b></td>
        <td rowspan="1" width="12%" align="center"><b>Kursus > 7 Hari</b></td>
        <td rowspan="1" width="12%" align="center"><b>Belum Berkursus</b></td>
    </tr>
<?
//$conn->debug=true;

$sql = "SELECT * FROM _ref_titlegred WHERE f_status=0 AND is_deleted=0 ORDER BY f_gred_code";
$rstitle = &$conn->execute($sql);
$sqltt= " AND B.BranchCd='0016'"; 
//$conn->debug=false;
if(!$rstitle->EOF){
	while(!$rstitle->EOF){
	$bil++;
	//SELECT TitleGredCd, count(StudCourse1.StaffNoIC),StudCourse1.StaffNoIC, SUM(datediff(EndDt,StDt)+1) TotalDay FROM StudCourse1, tblStaff WHERE StudCourse1.StaffNoIC = tblStaff.StaffNoIC 		
	//AND datediff( EndDt, StDt ) < 60 GROUP BY TitleGredCd, StudCourse1.StaffNoIC 
	
	$sql1 = "SELECT count(*) AS jum1 FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _tbl_kursus_jadual C 
	WHERE A.peserta_icno=B.f_peserta_noic AND A.EventId=C.id AND A.is_sijil=1 AND datediff( enddate, startdate ) < 7 
	AND B.f_title_grade=".tosql($rstitle->fields['f_gred_id']).$sqltt;
	$sql1 .= $strAddStDate.$strAddEndDate;
	$rs1 = $conn->execute($sql1);
	$K7 = $rs1->fields['jum1']; if(empty($K7)){ $K7='-'; }

	$sql2 = "SELECT count(*) AS jum2 FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _tbl_kursus_jadual C 
	WHERE A.peserta_icno=B.f_peserta_noic AND A.EventId=C.id AND A.is_sijil=1 AND datediff( enddate, startdate ) > 6 AND datediff( enddate, startdate ) < 60 
	AND B.f_title_grade=".tosql($rstitle->fields['f_gred_id']).$sqltt;
	$sql2 .= $strAddStDate.$strAddEndDate;
	$rs2 = $conn->execute($sql2);
	$L7 = $rs2->fields['jum2']; if(empty($L7)){ $L7='-'; }

	$sql3 = "SELECT count(*) AS jum3 FROM _tbl_peserta B
	WHERE B.f_title_grade=".tosql($rstitle->fields['f_gred_id']);
	$sql3 .= " AND B.f_peserta_noic NOT IN (SELECT peserta_icno FROM _tbl_kursus_jadual_peserta WHERE is_sijil=1)".$sqltt;
	//$sql3 .= $strAddStDate.$strAddEndDate;
	$rs3 = $conn->execute($sql3);
	$BK = $rs3->fields['jum3']; if(empty($BK)){ $BK='-'; }

	$sql4 = "SELECT count(*) AS jum4 FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _tbl_kursus_jadual C 
	WHERE A.peserta_icno=B.f_peserta_noic AND A.EventId=C.id AND A.is_sijil=1 AND datediff( enddate, startdate ) > 60 
	AND B.f_title_grade=".tosql($rstitle->fields['f_gred_id']).$sqltt;
	$sql4 .= $strAddStDate.$strAddEndDate;
	$rs4 = $conn->execute($sql4);
	$KJP = $rs4->fields['jum4']; if(empty($KJP)){ $KJP='-'; }
?>
    <tr>
    	<td align="right" height="25" valign="top"><? print $bil;?>.&nbsp;</td>
        <td align="left" valign="top"><? print $rstitle->fields['f_gred_code']." - ".$rstitle->fields['f_gred_name'];?></td>
        <td align="center" valign="top"><? print $K7;?></td>
        <td align="center" valign="top"><? print $L7;?></td>
        <td align="center" valign="top"><? print $BK;?></td>
        <td align="center" valign="top"><? print $KJP;?></td>
    </tr>
<?
		$rstitle->movenext();
	}	
}
?>
</table>
</body>
</html>