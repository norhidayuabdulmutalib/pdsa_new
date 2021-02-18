<?php include '../common_modal.php'; ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>Institut Latihan Islam Malaysia</title>
<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar2.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js"></script>
<script language="javascript" type="text/javascript">	
function do_close(){
	window.close();
}
function handleprint(){
	window.print();
}
function do_post(){
	var URL = 'bilangan_hari_kursus.php?pos=POS';
	document.ilim.action=URL;
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
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
if(!empty($kampus_id)){
	$kampus = dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($kampus_id));
} else {
	$kampus = dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($_SESSION['KAMPUS_PRINT']));
}

$width="100%";
$pos=isset($_REQUEST["pos"])?$_REQUEST["pos"]:"";
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";
$pusat=isset($_REQUEST["pusat"])?$_REQUEST["pusat"]:"";
$grade=isset($_REQUEST["grade"])?$_REQUEST["grade"]:"";

//if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sql_tkh = " AND startdate >= ".tosql($tkh_mula)." "; }
$strAddStDate=((strlen($tkh_mula)>0)?" AND startdate >= ".tosql(DBDate($tkh_mula))." ":"");
$strAddEndDate=((strlen($tkh_tamat)>0)?" AND enddate <= ".tosql(DBDate($tkh_tamat))." ":"");
$strPusat=((strlen($pusat)>0)?" AND BranchCd = ".tosql($pusat)." ":"");
$strGred=((strlen($grade)>0)?" AND f_title_grade = ".tosql($grade)." ":"");

?>
<form name="ilim" method="post" action="">
<div class="printButton" align="center">
<table width="<?=$width?>" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr><td colspan="2" align="center"><b>PROSES CETAKAN SENARAI KURSUS</b><BR /></td></tr>
	<?php
    $sqlp = "SELECT * FROM _ref_titlegred WHERE is_deleted=0 AND f_status=0 ORDER BY f_gred_code";
    $rspg = &$conn->execute($sqlp);
    ?>
    <tr><td  width="30%"align="right">Jawatan : </td>
        <td width="70%" align="left">
        <select name="grade">
        	<option value=""> -- Sila pilih -- </option>
            <?php while(!$rspg->EOF){ ?>
            <option value="<?php print $rspg->fields['f_gred_id'];?>" <?php if($rspg->fields['f_gred_id']==$grade){ print 'selected'; }?>><?php print $rspg->fields['f_gred_code'] ." - ". $rspg->fields['f_gred_name'];?></option>
            <? $rspg->movenext(); } ?>
       </select>   
    </td></tr>
 	<?php
	$sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
	$rspu = &$conn->execute($sqlp);
	?>
    <tr><td align="right">Tempat Bertugas : </td>
    	<td><select name="pusat" style="cursor:pointer" title="Sila pilih maklumat untuk carian">
        	<option value="">-- Sila pilih --</option>
            <?php while(!$rspu->EOF){ ?>
            <option value="<?php print $rspu->fields['f_tbcode'];?>" <?php if($rspu->fields['f_tbcode']==$pusat){ print 'selected'; }?>><?php print $rspu->fields['f_tempat_nama'];?></option>
            <? $rspu->movenext(); } ?>
        </select>
    </td></tr>
    <tr>
        <td align="right">Pilih Tarikh Mula : </td>
        <td><input type="text" size="13" name="tkh_mula" value="<? echo $tkh_mula;?>">
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
        <input type="button" value="Proses" onClick="do_post()" style="cursor:pointer" />
        <input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    	<input type="button" value="Salin Ke Excel" onClick="do_open('bilangan_hari_kursus_excel.php?pos=<?=$pos;?>&tkh_mula=<?=$tkh_mula;?>&tkh_tamat=<?=$tkh_tamat;?>&pusat=<?=$pusat;?>&grade=<?=$grade;?>')" style="cursor:pointer" />
        <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup window" style="cursor:pointer">
        <input type="hidden" name="kampus_id" value="<?=$kampus_id;?>">
        </td>
    </tr>
</table>
</div>
</form>
<?php if(!empty($pos)){ ?>
<table width="<?=$width;?>">
    <tr><td width="100%">
        <table width="100%" align="center">
            <tr>
              <td align="center" width="15%">
                <div style="float:left"><img src="../images/crestmalaysia.gif" border="0" width="90" height="68" /></div>
              </td>
              <td align="center" width="70%">
                <div><h3><I><B><?php print strtoupper($kampus);?><BR>JABATAN KEMAJUAN ISLAM MALAYSIA</B></I></h3></div>
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
              <td align="center"><B>LAPORAN KURSUS PEGAWAI BERDASARKAN BILANGAN HARI KURSUS
              <? if(!empty($pusat)){ print "<br>JABATAN/PUSAT : " . dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($pusat)); }?>
              <? if(!empty($grade)){ print "<br>BAGI GRED JAWATAN : " . dlookup2("_ref_titlegred","f_gred_code","f_gred_name","f_gred_id=".tosql($grade)); }?>
              <? if(!empty($tkh_mula) && !empty($tkh_tamat)){ print '<br>TARIKH '.$tkh_mula.' - '.$tkh_tamat; }
             	else if(!empty($tkh_mula) && empty($tkh_tamat)){ print '<br>TARIKH '.$tkh_mula.' - '.date("d/m/Y"); }?>
              </B></td>
            </tr>
        </table>
    </td></tr>
</table>

<table width="<?=$width;?>" class="data" border="1" cellpadding="3" cellspacing="0">
	<tr bgcolor="#CCCCCC">
    	<td rowspan="1" width="5%" align="center"><b>Bil</b></td>
        <td rowspan="1" width="50%" align="center"><b>Nama</b></td>
        <td rowspan="1" width="15%" align="center"><b>No. KP</b></td>
        <td rowspan="1" width="10%" align="center"><b>Jawatan</b></td>
        <td rowspan="1" width="10%" align="center"><b>Kursus ILIM<br>Bil Hari Kursus</b></td>
        <td rowspan="1" width="10%" align="center"><b>Kursus Luaran<br>Bil Hari Kursus</b></td>
    </tr>
<?
//$conn->debug=true;
$sql = "SELECT * FROM _tbl_peserta WHERE is_deleted=0";
$sql .= $strPusat . $strGred;
$sql .= " ORDER BY f_peserta_nama";
$rs = &$conn->execute($sql);
//$conn->debug=false;
if(!$rs->EOF){
	while(!$rs->EOF){
	$bil++;
	$jawatan = dlookup("_ref_titlegred","f_gred_code","f_gred_id=".tosql($rs->fields['f_title_grade']));
	$jum=0; $juml=0;
	$sql1 = "SELECT datediff(enddate, startdate)+1 as dt FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual C 
	WHERE A.EventId=C.id AND A.is_sijil=1 AND A.peserta_icno=".tosql($rs->fields['f_peserta_noic']);
	$sql1 .= $strAddStDate.$strAddEndDate;
	$rs1 = $conn->execute($sql1);
	while(!$rs1->EOF){
		$jum += $rs1->fields['dt'];
		$rs1->movenext();
	}
	if(empty($jum)){ $jum='-'; }
	$sql2 = "SELECT datediff(enddate, startdate)+1 as dt FROM _tbl_peserta_kursusluar 
	WHERE id_peserta=".tosql($rs->fields['id_peserta']);
	$sql2 .= $strAddStDate.$strAddEndDate;
	$rs2 = $conn->execute($sql2);
	while(!$rs2->EOF){
		$juml += $rs2->fields['dt'];
		$rs2->movenext();
	}
	if(empty($juml)){ $juml='-'; }
?>
    <tr height="25">
    	<td align="right" valign="top"><? print $bil;?>.&nbsp;</td>
        <td align="left" valign="top"><? print $rs->fields['f_peserta_nama'];?>&nbsp;</td>
        <td align="center" valign="top"><? print $rs->fields['f_peserta_noic'];?>&nbsp;</td>
        <td align="center" valign="top"><? print $jawatan;?>&nbsp;</td>
        <td align="center" valign="top"><? print $jum;?>&nbsp;</td>
        <td align="center" valign="top"><? print $juml;?>&nbsp;</td>
    </tr>
<?
		$rs->movenext();
	}	
}
?>
</table>
<div class="printButton" align="center">
    <input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup window" style="cursor:pointer">
</div>
<?php } ?>
</body>
</html>