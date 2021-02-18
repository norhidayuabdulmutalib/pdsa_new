<? //include '../../common.php'; ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>Institut Latihan Islam Malaysia</title>
<link href="../css/template-css.css" rel="stylesheet" type="text/css" media="screen">
<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar2.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js"></script>
<script language="javascript" type="text/javascript">	
function do_page(URL){
	document.ilim.action = URL;
	document.ilim.target = '_self';
	document.ilim.submit();
}
function handleprint(){
	window.print();
}
function do_pages(URL){
	var data = document.ilim.data.value;
	document.ilim.action = data;
	document.ilim.target = '_self';
	document.ilim.submit();
}
function do_back(URL){
	document.ilim.action = URL;
	document.ilim.target = '_self';
	document.ilim.submit();
}
function do_open(URL){
	document.ilim.action = URL;
	document.ilim.target = '_blank';
	document.ilim.submit();
}
function do_cetakan(eventid,hadir){
	var URL = '../laporana/peserta_kursus_detail.php?eventid='+eventid+"&hadir="+hadir;
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
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$subkategori=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
$get_data = isset($_REQUEST["data"])?$_REQUEST["data"]:"";
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";

$href_back = "index.php?data=".base64_encode('user;../laporana/laporan_list.php;laporan;laporan');
$href_search = "index.php?data=".base64_encode('user;../laporana/peserta_tidak_hadir.php;laporan;laporan');
$width="100%";

//if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sql_tkh = " AND startdate >= ".tosql($tkh_mula)." "; }
$strAddStDate=((strlen($tkh_mula)>0)?" AND A.startdate >= ".tosql(DBDate($tkh_mula))." ":"");
$strAddEndDate=((strlen($tkh_tamat)>0)?" AND A.enddate <= ".tosql(DBDate($tkh_tamat))." ":"");

?>
<form name="ilim" method="post" action="laporan/peserta_kursus.php">
<div class="printButton" align="center">
<table width="<?=$width?>" border="0" align="center" cellpadding="2" cellspacing="0">
	<tr><td colspan="2" align="center"><b>PROSES CETAKAN SENARAI KURSUS</b><BR /></td></tr>
 	<?php
	$sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
	$rspu = &$conn->execute($sqlp);
	?>
	<?php
    $sqlp = "SELECT * FROM _ref_titlegred WHERE is_deleted=0 AND f_status=0 ORDER BY f_gred_code";
    $rspg = &$conn->execute($sqlp);
    ?>
	<?php
    $sqlp = "SELECT * FROM _tbl_peserta WHERE is_deleted=0 ";
	if(!empty($pusat)){ $sqlp .= " AND BranchCd=".tosql($pusat); }
	if(!empty($grade)){ $sqlp .= " AND f_title_grade=".tosql($grade); }
	$sqlp .= " ORDER BY f_peserta_nama";
    $rspg = &$conn->execute($sqlp);
    ?>
	<?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
		$rskk = &$conn->Execute($sqlkk);
	?>
	<tr>
		<td width="30%" align="right"><b>Kategori Kursus : </b></td> 
		<td width="60%" align="left">
        	<select name="kategori">
            	<option value="">-- Sila pilih kategori --</option>
                <?php while(!$rskk->EOF){ ?>
                <option value="<?php print $rskk->fields['id'];?>" <?php if($kategori==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
                <?php $rskk->movenext(); } ?>
            </select>
		</td>
	</tr>
	<?php 
		$sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 ORDER BY SubCategoryNm";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td align="right"><b>Pusat / Unit : </b></td> 
        <td align="left" colspan="2" >
            <select name="subkategori" onChange="do_page('<?=$href_search;?>')">
                <option value="">-- Sila pilih sub-kategori --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['id'];?>" <?php if($subkategori==$rskks->fields['id']){ print 'selected'; }?>><?php print $rskks->fields['SubCategoryNm'];?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td width="30%" colspan="1" align="right"><strong>Pilih Tarikh Mula :</strong> </td>
<td width="70%">
            <input type="text" size="13" name="tkh_mula" value="<? echo $tkh_mula;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
            &nbsp;&nbsp;&nbsp;<strong>Tamat :</strong> 
    <input type="text" size="13" name="tkh_tamat" value="<? echo $tkh_tamat;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/> [dd/mm/yyyy]        </td>   
    </tr>
    <tr>
        <td align="center" colspan="2">
        <input type="button" value="Proses" onClick="do_pages('pro')" style="cursor:pointer" />
	    <input type="button" value="Salin Ke Excel" onClick="do_open('../laporana/peserta_kursus_excel.php?tahun=<?=$tahun;?>&bulan=<?=$bulan;?>&kursus=<?=$kursus;?>')" style="cursor:pointer" />
        <input type="button" value="Kembali" onClick="do_back('<?=$href_back;?>')" title="Sila klik untuk kembali ke senarai laporan" style="cursor:pointer">
        <input type="hidden" name="data" value="<?=$href_search;?>" />        </td>
    </tr>
</table>
</div>
<?php
//$conn->debug=true;
$sqlpe = "SELECT B.courseid, B.coursename, A.startdate, A.enddate, A.id FROM _tbl_kursus_jadual A, _tbl_kursus B WHERE B.is_deleted=0 AND A.courseid=B.id ";
$sqlpe .= $strAddStDate . $strAddEndDate;
if(!empty($kategori)){ $sqlpe.=" AND B.category_code=".tosql($kategori,"Text"); } 
if(!empty($subkategori)){ $sqlpe.=" AND B.subcategory_code=".tosql($subkategori,"Text"); } 
$sqlpe .= " ORDER BY A.startdate DESC";
$rs = &$conn->execute($sqlpe); $bil=0;
?>
<table width="95%" border="1" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor="#CCCCCC">
    	<td width="5%" align="center"><b>Bil</b></td>
        <td width="10%" align="center"><b>Kod Kursus</b></td>
        <td width="40%" align="center"><b>Nama Kursus</b></td>
        <td width="15%" align="center"><b>Tarikh Mula</b></td>
        <td width="15%" align="center"><b>Tarikh Tamat</b></td>
        <td width="5%" align="center"><b>Cetak Peserta Tidak Hadir</b></td>
    </tr>
<?php while(!$rs->EOF){ $bil++; 
	//$jawatan = dlookup2("_ref_titlegred","f_gred_code","f_gred_name","f_gred_id=".tosql($rs->fields['f_title_grade']));
?>
	<tr>
    	<td align="right"><?php print $bil;?>.</td>
    	<td align="left"><?php print $rs->fields['courseid'];?></td>
    	<td align="left"><?php print $rs->fields['coursename'];?></td>
    	<td align="center"><?php print DisplayDate($rs->fields['startdate']);?></td>
    	<td align="center"><?php print DisplayDate($rs->fields['enddate']);?></td>
    	<td align="center">
        	<img src="../images/printicon.gif" border="0" onClick="do_cetakan('<?php print $rs->fields['id'];?>','xhadir')" style="cursor:pointer">
        </td>
    </tr>
<?php $rs->movenext(); } ?>	
</table>
</form>
</body>
</html>