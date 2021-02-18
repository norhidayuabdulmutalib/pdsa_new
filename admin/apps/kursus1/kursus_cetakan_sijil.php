<?php include '../../common.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetakan Sijil Peserta Kursus</title>
<style media="screen" type="text/css">
	body{FONT-SIZE: 16px;FONT-FAMILY: Arial;COLOR: #000000}
	.tajuk{FONT-SIZE: 20px;FONT-FAMILY: Arial;COLOR: #000000}
	.nama{FONT-SIZE: 24px;FONT-FAMILY: Arial;COLOR: #000000}
</style>
<style media="print" type="text/css">
	body{FONT-SIZE: 16px;FONT-FAMILY: Arial;COLOR: #000000}
	.nama{FONT-SIZE: 24px;FONT-FAMILY: Arial;COLOR: #000000}
	.tajuk{FONT-SIZE: 20px;FONT-FAMILY: Arial;COLOR: #000000}
	.printButton { display: none; }

@media all{
 .page-break { display:none; }
}

@media print{
 .page-break { display:block; page-break-before:always; }
}
</style>
<script language="javascript" type="text/javascript">	
function do_close(){
	//parent.emailwindow.hide();
	window.close();
}
function handleprint(){
	window.print();
}
</script>
</head>
<body>
<?php
function get_month($tkh){
	$mth = substr($tkh,5,2);
	$dispmth = month($mth);
	return $dispmth;
	
}

$ts_id=$_GET['tsid'];
$sqls = "SELECT * FROM _ref_template_sijil WHERE ref_ts_id=".tosql($ts_id);
$rss = &$conn->Execute($sqls);
//$head = $rss->fields['ref_ts_head'];
$oleh = $rss->fields['ref_ts_oleh'];
$jawatan = $rss->fields['ref_ts_jawatan'];
//$head_height="200px";
?>

<?php
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$idpeserta=isset($_REQUEST["idpeserta"])?$_REQUEST["idpeserta"]:"";

$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);

$start 	= $rs->fields['startdate'];
$end 	= $rs->fields['enddate'];


$mths_disp = ucfirst(strtolower(get_month($start)));
$mthe_disp = ucfirst(strtolower(get_month($end)));

//print $mths_disp."/".$mthe_disp;
// PAPARAN TARIKH MESIHI
$yrs = substr($start,0,4);
$yre = substr($end,0,4);
$disp_from=0;
if($yrs==$yre){ $dispyr = $yrs; 
	if($mths_disp==$mthe_disp){ 
		if($end=='0000-00-00' || $end == $start){
			$disp_from=0;
			$papar_tkh = substr($start,8,2)." ".$mths_disp." ".$dispyr; 
		} else {
			$disp_from=1;
			$papar_tkh = substr($start,8,2)." hingga ".substr($end,8,2)." ".$mths_disp." ".$dispyr; 
		}

	} else { 
		 
		if($end=='0000-00-00' || $end == $start){
			$disp_from=0;
			$papar_tkh = substr($start,8,2)." ".$mths_disp." ".$dispyr; 
		} else {
			$disp_from=1;
			$papar_tkh = substr($start,8,2)." ".$mths_disp." hingga ".substr($end,8,2)." ".$mthe_disp." ".$dispyr; 
		}

	}
} else {
	if($end=='0000-00-00' || $end == $start){
		$disp_from=0;
		$papar_tkh = substr($start,8,2)." ".$mths_disp." ".$yrs; 
	} else {
		$disp_from=1;
		$papar_tkh = substr($start,8,2)." ".$mths_disp." ".$yrs." hingga ".substr($end,8,2)." ".$mthe_disp." ".$yre; 
	}
}


$sql_det = "SELECT A.*, B.f_peserta_nama, B.f_peserta_noic, B.BranchCd FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
WHERE A.InternalStudentAccepted= 1 AND A.peserta_icno=B.f_peserta_noic AND A.is_sijil=1 AND A.is_selected=1 AND A.EventId=".tosql($id);
if(!empty($idpeserta)){ $sql_det .= " AND A.InternalStudentId=".tosql($idpeserta,"Number"); }
$sql_det .= " GROUP BY A.peserta_icno ORDER BY B.f_peserta_nama";

$rs_det = $conn->execute($sql_det);
$cont = $rs_det->recordcount();
while(!$rs_det->EOF){
?>
<table width="80%" cellpadding="5" cellspacing="1" border="0" align="center">
    <tr>
      <td width="100%" align="center" style="height:300px" valign="bottom">
      <div style="widows:100%;height:<?php print $rss->fields['ref_ts_head1_size'];?>">
        <label style="font-family:'<?php print $rss->fields['ref_ts_head1_font']?>';font-size:<?php print $rss->fields['ref_ts_head1_size'];?>;font-style:<?php print $rss->fields['ref_ts_head1_fontstyle']?>">
        <?php print $rss->fields['ref_ts_head1'];?></label></div>
        
      <div style="widows:100%;height:<?php print $rss->fields['ref_ts_head2_size'];?>"">
        <label style="font-family:'<?php print $rss->fields['ref_ts_head2_font']?>';font-size:<?php print $rss->fields['ref_ts_head2_size'];?>;font-style:<?php print $rss->fields['ref_ts_head2_fontstyle']?>">
        <?php print $rss->fields['ref_ts_head2'];?></label></div>
        
      <div style="widows:100%;height:<?php print $rss->fields['ref_ts_head3_size'];?>"">
        <label style="font-family:'<?php print $rss->fields['ref_ts_head3_font']?>';font-size:<?php print $rss->fields['ref_ts_head3_size'];?>;font-style:<?php print $rss->fields['ref_ts_head3_fontstyle']?>">
        <?php print $rss->fields['ref_ts_head3'];?></label></div>
        </td>
    </tr>
    <tr>
        <td align="center" height="50px">
        <label style="font-family:'<?php print $rss->fields['ref_ts_sah_font']?>';font-size:<?php print $rss->fields['ref_ts_sah_size'];?>;font-style:<?php print $rss->fields['ref_ts_sah_fontstyle']?>">Dengan Ini Disahkan Bahawa</label></td>
    </tr>

    <tr>
        <td align="center" height="125px">
        <b><label style="font-family:'<?php print $rss->fields['ref_ts_nama_font']?>';font-size:<?php print $rss->fields['ref_ts_nama_size'];?>;font-style:<?php print $rss->fields['ref_ts_nama_fontstyle']?>"><?php print $rs_det->fields['f_peserta_nama'];?></label></b><br />
       <?php if(!empty($rs_det->fields['f_peserta_noic'])){ ?>
       <b><label style="font-family:'<?php print $rss->fields['ref_ts_kp_font']?>';font-size:<?php print $rss->fields['ref_ts_kp_size'];?>;font-style:<?php print $rss->fields['ref_ts_kp_fontstyle']?>"><?php print $rs_det->fields['f_peserta_noic'];?></label></b><br />
       <?php } ?>
        </td>
    </tr>
    <tr>
        <td align="center" height="50px">
            <label style="font-family:'<?php print $rss->fields['ref_ts_telah_font']?>';font-size:<?php print $rss->fields['ref_ts_telah_size'];?>;font-style:<?php print $rss->fields['ref_ts_telah_fontstyle']?>">Telah Mengikuti Dengan Jayanya</label></td>
    </tr>
    <tr>
        <td align="center" height="125px">
            <b><label style="font-family:'<?php print $rss->fields['ref_ts_kursus_font']?>';font-size:<?php print $rss->fields['ref_ts_kursus_size'];?>;font-style:<?php print $rss->fields['ref_ts_kursus_fontstyle']?>"><?=$rs->fields['coursename'];?></label></b><br /></td>
    </tr>
    <?php if(empty($disp_from)){ ?>
        <tr>
            <td align="center" height="50px">
                <label style="font-family:'<?php print $rss->fields['ref_ts_mulai_font']?>';font-size:<?php print $rss->fields['ref_ts_mulai_size'];?>;font-style:<?php print $rss->fields['ref_ts_mulai_fontstyle']?>">Yang Telah Diadakan Pada</label></td>
        </tr>
        <tr>
            <td align="center" height="100px"><label style="font-family:'<?php print $rss->fields['ref_ts_tkh_font']?>';font-size:<?php print $rss->fields['ref_ts_tkh_size'];?>;font-style:<?php print $rss->fields['ref_ts_tkh_fontstyle']?>"><?=$papar_tkh;?>
            <br />Bersamaan<br /><?=$rss->fields['tarikh_hijrah'];?><!--02 hingga 04 Rejab 1431--></label></td>
        </tr>
	<?php } else { ?>
        <tr>
            <td align="center" height="50px">
                <label style="font-family:'<?php print $rss->fields['ref_ts_mulai_font']?>';font-size:<?php print $rss->fields['ref_ts_mulai_size'];?>;font-style:<?php print $rss->fields['ref_ts_mulai_fontstyle']?>">Yang Telah Diadakan Mulai</label></td>
        </tr>
        <tr>
            <td align="center" height="100px"><label style="font-family:'<?php print $rss->fields['ref_ts_tkh_font']?>';font-size:<?php print $rss->fields['ref_ts_tkh_size'];?>;font-style:<?php print $rss->fields['ref_ts_tkh_fontstyle']?>"><?=$papar_tkh;?>
            <br />Bersamaan<br /><?=$rss->fields['tarikh_hijrah'];?><!--02 hingga 04 Rejab 1431--></label></td>
        </tr>
	<?php } ?>
    <tr>
        <td align="center" height="150px"><br /><br /><br />
        <b>(<?=$oleh;?>)</b><br /><?=$jawatan;?><br />Institut Latihan Islam Malaysia<br />Jabatan Kemajuan Islam Malaysia</td>
    </tr>
</table>
<?php if($cont>1){ ?>
<table width="100%">
	<div style="page-break-after:always">&nbsp;</div>
</table>
<?php } ?>
<?php 
	$rs_det->movenext();
} ?>
<div class="printButton" align="center">
	<br>
	<table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
   	<input type="button" value="Print" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Close" onClick="do_close()" title="Please click to close window" style="cursor:pointer">
    <br>Please change the printing Orientation to <b>Potrait</b> before printing.
	<br /><br />
    </td></tr></table>
</div>
</body>
</html>
