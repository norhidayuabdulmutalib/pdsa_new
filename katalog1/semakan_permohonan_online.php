<?php 
include_once '../common.php';
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$nokp=isset($_REQUEST["nokp"])?$_REQUEST["nokp"]:"";
$proses = $_GET['pro'];
$msg='';
?>
<script LANGUAGE="JavaScript">
function do_pages(URL){
	//alert(URL);
	document.ilim.action = URL;
	document.ilim.submit();
}
function form_back(URL){
	parent.emailwindow.hide();
}
</script>
<?php
//print $nokp;
if(!empty($nokp)){ 
	//$conn->debug=true;
	$sql_det = "SELECT DISTINCT(B.f_peserta_noic), A.*, B.f_peserta_nama, B.BranchCd, B.f_title_grade, 
	D.courseid, D.coursename, C.startdate, C.enddate 
	FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _tbl_kursus_jadual C, _tbl_kursus D 
	WHERE A.peserta_icno=B.f_peserta_noic AND A.is_selected=1 AND A.peserta_icno=".tosql($nokp);
	$sql_det .= " AND A.EventId=C.id AND C.courseid=D.id AND C.startdate>".tosql(date("Y-m-d"));
	$sql_det .= " GROUP BY B.f_peserta_noic ORDER BY C.enddate ASC";
	$rs = &$conn->Execute($sql_det);
	if(!$rs->EOF){ 
		$nama = $rs->fields['f_peserta_nama'];
		$kursus = "<br>".$rs->fields['courseid']." - ".$rs->fields['coursename'];
		$kursus .= "<br> Pada : ".DisplayDate($rs->fields['startdate'])." - ".DisplayDate($rs->fields['enddate']);
		$kursus .= "<br>";
?>
<br />
<hr /><br />
<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
	<tr><td colspan="3" height="30px" align="center" valign="middle">
    	Permohonan <b><?php print strtoupper($nama);?></b> untuk menghadiri kursus <b><?=$kursus;?></b> telah berjaya dan memerlukan pengesahan kehadiran tuan/puan.<br />
        <!--<br />Sila log masuk ke dalam sistem untuk mengesahkan kehadiran anda.-->
        <br />Sila rujuk email untuk muat-turun surat tawaran dan borang pengesahan kehadiran pengesahan kursus
        <br /><br />
        <!--<input type="button" value="Log Masuk" style="cursor:pointer" />-->
	</td></tr>
</table>
<?php } ?>
<?php
}
?>
