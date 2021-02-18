<?php 
include '../../common.php';
$cat = $_POST['cat'];
if(empty($cat)){ $cat=1; }
$tot_mos=0;
?>
<style type="text/css">
<!--
.detail_data{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
}
-->
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
<style media="print" type="text/css">
	body{FONT-SIZE: 12px;FONT-FAMILY: Arial;COLOR: #000000}
	.printButton { display: none; }

@media all{
	body{FONT-SIZE: 12px;FONT-FAMILY: Arial;COLOR: #000000}
 	.page-break { display:none; }
}

@media print{
	body{FONT-SIZE: 12px;FONT-FAMILY: Arial;COLOR: #000000}
	.page-break { display:block; page-break-before:always; }
}
</style>
<body>
<?php
//$conn->debug=true;
$tkh_mula=isset($_REQUEST["mula"])?$_REQUEST["mula"]:"";
$tkh_tamat=isset($_REQUEST["tamat"])?$_REQUEST["tamat"]:"";
$varSort=isset($_REQUEST["sb"])?$_REQUEST["sb"]:"startdate";
?>
<div class="printButton" align="center">
	<table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
   	<input type="button" value="Print" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Close" onClick="do_close()" title="Please click to close window" style="cursor:pointer">
    <br>Please change the printing Orientation to <b>Landscape</b> before printing.
	<br />
    </td></tr></table>
</div>

<table width="100%" align="center" cellpadding="0" cellspacing="1" border="0" class="detail_data">
    <tr valign="top"> 
    	<td valign="top" width="100%" align="center"><font size="1"><b>
    	<h2>Jadual Kursus  di ILIM mulai 
    	  <?=$tkh_mula;?> hingga <?=$tkh_tamat;?></h2>
    	</b></font></td>
    </tr>
	<tr><td>
      <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" class="detail_data">
      <tr bgcolor="#CCCCCC"> 
        <td align="center" width="3%"><b>Bil</b></td>
        <td align="center" width="30%"><b>Kursus</b></td>
        <td align="center" width="10%"><b>Tarikh</b></td>
        <td align="center" width="5%"><b>Jumlah Peserta</b></td>
        <td align="center" width="5%"><b>Penginapan Asrama</b></td>
        <td align="center" width="15%"><b>Bilik Kuliah</b></td>
        <td align="center" width="17%"><b>Nama & Tel Urusetia</b></td>
        <td align="center" width="15%"><b>Catatan</b></td>
      </tr>
<?php
//$conn->debug=true;
$sSQL = "SELECT A.* FROM _tbl_kursus_jadual A, _tbl_kursus B WHERE A.courseid=B.id AND A.enddate>=".tosql(date("Y-m-d"));
if(!empty($kategori)){ $sSQL.=" AND A.category_code=".tosql($kategori,"Text"); } 
if(!empty($search)){ $sSQL.=" AND B.coursename LIKE '%".$search."%' "; } 
if(!empty($tkh_mula) && empty($tkh_tamat)){ $sSQL.=" AND startdate>=".tosql(DBDate($tkh_mula),"Text"); } 
if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sSQL.=" AND startdate BETWEEN ".tosql(DBDate($tkh_mula),"Text")." AND ".tosql(DBDate($tkh_tamat),"Text"); } 
$sSQL .= " UNION ";
$sSQL .= "SELECT * FROM _tbl_kursus_jadual WHERE acourse_name<>'' AND enddate>=".tosql(date("Y-m-d"));
if(!empty($kategori)){ $sSQL.=" AND category_code=".tosql($kategori,"Text"); } 
if(!empty($search)){ $sSQL.=" AND acourse_name LIKE '%".$search."%' "; } 
if(!empty($tkh_mula) && empty($tkh_tamat)){ $sSQL.=" AND startdate>=".tosql(DBDate($tkh_mula),"Text"); } 
if(!empty($tkh_mula) && !empty($tkh_tamat)){ 
	$sSQL.=" AND ( startdate BETWEEN ".tosql(DBDate($tkh_mula),"Text")." AND ".tosql(DBDate($tkh_tamat),"Text"); 
	$sSQL.=" OR enddate BETWEEN ".tosql(DBDate($tkh_mula),"Text")." AND ".tosql(DBDate($tkh_tamat),"Text").")"; 
} 

$sSQL .= " ORDER BY startdate"; //"ORDER BY B.coursename";

$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

while(!$rs->EOF) {
	$bil++;
	$courseid=''; $coursename=''; $SubCategoryCd='';
	$sqlk = "SELECT * FROM _tbl_kursus WHERE id=".tosql($rs->fields['courseid']);
	$rsk = $conn->execute($sqlk);
	if(!$rsk->EOF){
		$courseid = $rsk->fields['courseid'];
		$coursename = $rsk->fields['coursename'];
		$SubCategoryCd = $rsk->fields['subcategory_code'];
	} else {
		$courseid = '-';
		$coursename = $rs->fields['acourse_name'];
		$SubCategoryCd = $rs->fields['sub_category_code'];
	}
	$asmara = $rs->fields['asrama_perlu'];
	if(empty($asmara)){ $asmara='TIDAK'; }
	//$anjuran = dlookup("_tbl_kursus_cat","categorytype","id=".tosql($rs->fields['category_code'],"Text"));
	$bilik = strtoupper(dlookup("_tbl_bilikkuliah","f_bilik_nama","f_bilikid=".tosql($rs->fields['bilik_kuliah'])));
	if(!empty($rs->fields['nama_agensi'])){ $nama_agensi = "<i>".$rs->fields['nama_agensi']."</i>"; }
	//lelaki 	perempuan 	vip
	$jump = ($rs->fields['lelaki']-0)+($rs->fields['perempuan']-0)+($rs->fields['vip']-0);
?>
      <tr> 
        <td align="center" valign="top"><?php print $bil;?>.</td>
        <td align="left" valign="top"><?php print stripslashes($coursename);?>&nbsp;<?php if(!empty($nama_agensi)){ print "<br>Agensi: ".$nama_agensi; }?></td>
        <td valign="top" align="center"><? echo DisplayDate($rs->fields['startdate'])?><br /><? echo DisplayDate($rs->fields['enddate'])?></td>
        <td align="center" valign="top"><?php print $jump;?> Org&nbsp;</td>
        <td align="center" valign="top"><?php print $asmara;?>&nbsp;</td>
        <td align="left" valign="top"><?php print stripslashes($bilik);?>&nbsp;</td>
        <td align="left" valign="top"><?php print stripslashes($rs->fields['penyelaras']);?><br><?php print "No. Tel: ".stripslashes($rs->fields['penyelaras_notel']);?>&nbsp;</td>
        <td align="left" valign="top"><?php print stripslashes($rs->fields['catatan']);?>&nbsp;</td>
      </tr>
<?php 
	$rs->movenext();
} ?>

	    </table>
    </td></tr>
</table>
<div class="printButton" align="center">
	<br>
	<table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
   	<input type="button" value="Print" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Close" onClick="do_close()" title="Please click to close window" style="cursor:pointer">
    <br>Please change the printing Orientation to <b>Landscape</b> before printing.
	<br /><br />
    </td></tr></table>
</div>
</body>