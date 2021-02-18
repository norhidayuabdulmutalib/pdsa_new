<? //include '../../common.php'; ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>Institut Latihan Islam Malaysia</title>
<link href="../css/template-css.css" rel="stylesheet" type="text/css" media="screen">
<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar2.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js"></script>
<script language="javascript" type="text/javascript">	
function handleprint(){
	window.print();
}
function do_pages(URL){
	document.ilim.action = URL;
	document.ilim.target = '_self';
	document.ilim.submit();
}
function do_cetakan(ic){
	var URL = '../laporana/kursus_dihadiri_detail.php?ic='+ic;
	document.ilim.action = URL;
	document.ilim.target = '_blank';
	document.ilim.submit();
}
function do_post(ty){
	var nama = document.ilim.peserta.value;
	var URL = '../laporana/kursus_dihadiri_detail.php?ic='+nama;
	var data = document.ilim.data.value;
	if(nama==''){ 
		document.ilim.action = data;
		document.ilim.target = '_self';
		document.ilim.submit();
	} else {
		document.ilim.action = URL;
		document.ilim.target = '_blank';
		document.ilim.submit();
	}
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
$href_back = "index.php?data=".base64_encode('user;../laporana/laporan_list.php;laporan;laporan');
$href_search = "index.php?data=".base64_encode('user;../laporana/kursus_dihadiri.php;laporan;laporan');
$get_data = isset($_REQUEST["data"])?$_REQUEST["data"]:"";
$width="100%";
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";
$pusat=isset($_REQUEST["pusat"])?$_REQUEST["pusat"]:"";
$grade=isset($_REQUEST["grade"])?$_REQUEST["grade"]:"";
$peserta=isset($_REQUEST["peserta"])?$_REQUEST["peserta"]:"";

//if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sql_tkh = " AND startdate >= ".tosql($tkh_mula)." "; }
$strAddStDate=((strlen($tkh_mula)>0)?" AND C.startdate >= ".tosql(DBDate($tkh_mula))." ":"");
$strAddEndDate=((strlen($tkh_tamat)>0)?" AND C.enddate <= ".tosql(DBDate($tkh_tamat))." ":"");
$strPusat=((strlen($pusat)>0)?" AND BranchCd = ".tosql($pusat)." ":"");
$strGred=((strlen($grade)>0)?" AND f_title_grade = ".tosql($grade)." ":"");

?>
<form name="ilim" method="post" action="bilangan_hari_kursus.php">
<div class="printButton" align="center">
<table width="<?=$width?>" border="0" align="center" cellpadding="1" cellspacing="0">
	<tr><td colspan="2" align="center"><b>PROSES CETAKAN SENARAI KURSUS</b><BR /></td></tr>
 	<?php
	$sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
	$rspu = &$conn->execute($sqlp);
	?>
    <tr><td colspan="1" align="right">Tempat Bertugas : </td>
    	<td>
    	<select name="pusat" style="cursor:pointer" title="Sila pilih maklumat untuk carian" onChange="do_post('sel')">
        	<option value="">-- Sila pilih --</option>
            <?php while(!$rspu->EOF){ ?>
            <option value="<?php print $rspu->fields['f_tbcode'];?>" <?php if($rspu->fields['f_tbcode']==$pusat){ print 'selected'; }?>><?php print $rspu->fields['f_tempat_nama'];?></option>
            <? $rspu->movenext(); } ?>
        </select>
    </td></tr>
	<?php
    $sqlp = "SELECT * FROM _ref_titlegred WHERE is_deleted=0 AND f_status=0 ORDER BY f_gred_code";
    $rspg = &$conn->execute($sqlp);
    ?>
    <tr><td colspan="1" align="right">Jawatan : </td>
    	<td>
        <select name="grade" style="cursor:pointer" onChange="do_post('sel')">
        	<option value=""> -- Sila pilih -- </option>
            <?php while(!$rspg->EOF){ ?>
            <option value="<?php print $rspg->fields['f_gred_id'];?>" <?php if($rspg->fields['f_gred_id']==$grade){ print 'selected'; }?>><?php print $rspg->fields['f_gred_code'] ." - ". $rspg->fields['f_gred_name'];?></option>
            <? $rspg->movenext(); } ?>
       </select>   
    </td></tr>
	<?php
    $sqlp = "SELECT * FROM _tbl_peserta WHERE is_deleted=0 ";
	if(!empty($pusat)){ $sqlp .= " AND BranchCd=".tosql($pusat); }
	if(!empty($grade)){ $sqlp .= " AND f_title_grade=".tosql($grade); }
	$sqlp .= " ORDER BY f_peserta_nama";
    $rspg = &$conn->execute($sqlp);
    ?>
    <tr><td colspan="1" align="right" width="30%">Nama Peserta : </td>
    	<td width="70%" align="left">
        <select name="peserta">
        	<option value=""> -- Sila pilih -- </option>
            <?php while(!$rspg->EOF){ ?>
            <option value="<?php print $rspg->fields['f_peserta_noic'];?>" <?php if($rspg->fields['f_peserta_noic']==$peserta){ print 'selected'; }?>><?php print $rspg->fields['f_peserta_nama'] ." - ". $rspg->fields['f_peserta_noic'];?></option>
            <? $rspg->movenext(); } ?>
       </select>   
    </td></tr>
    <tr>
        <td align="right" colspan="1">Pilih Tarikh Mula : </td>
        	<td>
            <input type="text" size="13" name="tkh_mula" value="<? echo $tkh_mula;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
            &nbsp;&nbsp;&nbsp;Tamat : 
            <input type="text" size="13" name="tkh_tamat" value="<? echo $tkh_tamat;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/> [dd/mm/yyyy]
        </td>   
    </tr>
    <tr>
        <td align="center" colspan="2">
        <input type="button" value="Proses" onClick="do_post('pro')" style="cursor:pointer" />
    	<input type="button" value="Salin Ke Excel" onClick="do_open('../laporana/kursus_dihadiri_excel.php?tkh_mula=<?=$tkh_mula;?>&tkh_tamat=<?=$tkh_tamat;?>&pusat=<?=$pusat;?>&grade=<?=$grade;?>&peserta=<?=$peserta;?>')" style="cursor:pointer" />
        <input type="button" value="Kembali" onClick="do_pages('<?=$href_back;?>')" title="Sila klik untuk kembali ke senarai laporan" style="cursor:pointer">
        <input type="hidden" name="data" value="<?=$href_search;?>" />
        </td>
    </tr>
</table>
</div>
<?php if(!empty($pusat) || !empty($grade)){ 
$sqlpe = "SELECT * FROM _tbl_peserta WHERE is_deleted=0 ";
if(!empty($pusat)){ $sqlpe .= " AND BranchCd=".tosql($pusat); }
if(!empty($grade)){ $sqlpe .= " AND f_title_grade=".tosql($grade); }
$sqlpe .= " ORDER BY f_peserta_nama";
//$conn->debug=true;
$rs = &$conn->execute($sqlpe); $bil=0;
?>
<table width="95%" border="1" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor="#CCCCCC">
    	<td width="5%" align="center"><b>Bil</b></td>
        <td width="45%" align="center"><b>Nama</b></td>
        <td width="15%" align="center"><b>No. KP</b></td>
        <td width="30%" align="center"><b>Jawatan</b></td>
        <td width="5%" align="center"><b>Cetak</b></td>
    </tr>
<?php while(!$rs->EOF){ $bil++; 
	$jawatan = dlookup2("_ref_titlegred","f_gred_code","f_gred_name","f_gred_id=".tosql($rs->fields['f_title_grade']));
?>
	<tr>
    	<td align="right"><?php print $bil;?>.</td>
    	<td align="left"><?php print $rs->fields['f_peserta_nama'];?></td>
    	<td align="center"><?php print $rs->fields['f_peserta_noic'];?></td>
    	<td align="left"><?php print $jawatan;?></td>
    	<td align="center">
        	<img src="../images/printicon.gif" border="0" onClick="do_cetakan('<?php print $rs->fields['f_peserta_noic'];?>')" style="cursor:pointer">
        </td>
    </tr>
<?php $rs->movenext(); } ?>	
</table>
<?php } ?>
</form>
</body>
</html>
