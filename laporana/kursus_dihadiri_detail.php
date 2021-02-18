<? include '../common.php'; ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>Institut Latihan Islam Malaysia</title>
<link href="../css/template-css.css" rel="stylesheet" type="text/css" media="screen">
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
$width="100%";
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";
$pusat=isset($_REQUEST["pusat"])?$_REQUEST["pusat"]:"";
$grade=isset($_REQUEST["grade"])?$_REQUEST["grade"]:"";

//if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sql_tkh = " AND startdate >= ".tosql($tkh_mula)." "; }
$strAddStDate=((strlen($tkh_mula)>0)?" AND C.startdate >= ".tosql(DBDate($tkh_mula))." ":"");
$strAddEndDate=((strlen($tkh_tamat)>0)?" AND C.enddate <= ".tosql(DBDate($tkh_tamat))." ":"");
$strPusat=((strlen($pusat)>0)?" AND BranchCd = ".tosql($pusat)." ":"");
$strGred=((strlen($grade)>0)?" AND f_title_grade = ".tosql($grade)." ":"");

?>
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
              <td align="center"><B>LAPORAN KURSUS YANG DIHADIRI</B></td>
            </tr>
        </table>
    </td></tr>
</table>
<?
//$conn->debug=true;
$ic=isset($_REQUEST["ic"])?$_REQUEST["ic"]:"";
$sqlp = "SELECT * FROM _tbl_peserta WHERE f_peserta_noic=".tosql($ic); 
$rs = $conn->execute($sqlp)
?>
<table width="<?=$width?>" border="0" align="center" cellpadding="4" cellspacing="0" class="data" >
    <tr><td colspan="1" width="30%" align="right"><b>Nama Pegawai : </b></td>
    <td width="70%" align="left"><?php print $rs->fields['f_peserta_nama'];?></td></tr>
    <tr><td colspan="1" align="right"><b>No KP : </b></td>
    <td align="left"><?php print $rs->fields['f_peserta_noic'];?></td></tr>
    <tr><td colspan="1" align="right"><b>Jawatan : </b></td>
    <td align="left"><?php print dlookup2("_ref_titlegred","f_gred_code","f_gred_name","f_gred_id=".tosql($rs->fields['f_title_grade']));?></td></tr>
    <tr><td colspan="1" align="right"><b>Ttempat Bertugas : </b></td>
    <td align="left"><?php print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rs->fields['BranchCd']));?></td></tr>
</table>
<br>
<table width="<?=$width;?>" class="data" border="1" cellpadding="3" cellspacing="0">
	<tr><td colspan="5"><b>KURSUS ANJURAN ILIM</b></td></tr>
	<tr bgcolor="#CCCCCC">
    	<td rowspan="1" width="5%" align="center"><b>Bil</b></td>
        <td rowspan="1" width="50%" align="center"><b>Nama Kursus</b></td>
        <td rowspan="1" width="15%" align="center"><b>Tarikh</b></td>
        <td rowspan="1" width="15%" align="center"><b>Tempat</b></td>
        <td rowspan="1" width="15%" align="center"><b>Penganjur</b></td>
    </tr>
<?
//$conn->debug=true;
$sql = "SELECT A.*, B.startdate, B.enddate, C.coursename FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B, _tbl_kursus C 
WHERE A.EventId=B.id AND B.courseid=C.id AND A.is_deleted=0 AND A.peserta_icno=".tosql($ic); //AND A.is_sijil=1
$sql .= " AND B.startdate<".tosql(date("Y=m-d")); 
$sql .= " ORDER BY B.startdate ASC";
$rsdet = &$conn->execute($sql);
$conn->debug=false;
if(!$rsdet->EOF){
	while(!$rsdet->EOF){
	$bil++;
	$bilik_kuliah = dlookup("_tbl_bilikkuliah","f_bilik_nama","f_bilikid=".tosql($rs->fields['bilik_kuliah']));
	if(empty($bilik_kuliah)){ $bilik_kuliah='ILIM'; }
?>
    <tr height="25">
    	<td align="right" valign="top"><? print $bil;?>.&nbsp;</td>
        <td align="left" valign="top"><? print $rsdet->fields['coursename'];?>&nbsp;</td>
        <td align="center" valign="top"><? print DisplayDate($rsdet->fields['startdate']) . " - " . DisplayDate($rsdet->fields['enddate']);?>&nbsp;</td>
        <td align="center" valign="top"><? print $bilik_kuliah;?>&nbsp;</td>
        <td align="center" valign="top">ILIM&nbsp;</td>
    </tr>
<?
		$rsdet->movenext();
	}	
}
?>
</table>
<br>
<table width="<?=$width;?>" class="data" border="1" cellpadding="3" cellspacing="0">
	<tr><td colspan="5"><b>KURSUS LUARAN</b></td></tr>
	<tr bgcolor="#CCCCCC">
    	<td rowspan="1" width="5%" align="center"><b>Bil</b></td>
        <td rowspan="1" width="50%" align="center"><b>Nama Kursus</b></td>
        <td rowspan="1" width="15%" align="center"><b>Tarikh</b></td>
        <td rowspan="1" width="15%" align="center"><b>Tempat</b></td>
        <td rowspan="1" width="15%" align="center"><b>Penganjur</b></td>
    </tr>
<?
//$conn->debug=true;
$sql = "SELECT * FROM _tbl_peserta_kursusluar WHERE id_peserta=".tosql($rs->fields['id_peserta']);
$rsdet = &$conn->execute($sql);
$conn->debug=false;
if(!$rsdet->EOF){
	while(!$rsdet->EOF){
	$bil++;
?>
    <tr height="25">
    	<td align="right" valign="top"><? print $bil;?>.&nbsp;</td>
        <td align="left" valign="top"><? print $rsdet->fields['nama_kursus'];?>&nbsp;</td>
        <td align="center" valign="top"><? print DisplayDate($rsdet->fields['startdate']) . " - " . DisplayDate($rsdet->fields['enddate']);?>&nbsp;</td>
        <td align="center" valign="top"><? print $rsdet->fields['tempat_kursus'];?>&nbsp;</td>
        <td align="center" valign="top"><? print $rsdet->fields['anjuran'];?>&nbsp;</td>
    </tr>
<?
		$rsdet->movenext();
	}	
}
?>
</table>
<div class="printButton" align="center">
	<form name="ilim" method="post" action="">
    <input type="button" value="Salin Ke Excel" onClick="do_open('kursus_dihadiri_detail_excel.php?ic=<?=$ic;?>')" style="cursor:pointer" />
    <input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup window" style="cursor:pointer">
    </form>
</div>
</body>
</html>