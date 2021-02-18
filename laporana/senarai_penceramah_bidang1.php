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
function do_post(pro){
	var URL = 'senarai_penceramah_bidang.php?pos='+pro;
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
$width="100%";
$pos=isset($_REQUEST["pos"])?$_REQUEST["pos"]:"";
$inskategori=isset($_REQUEST["inskategori"])?$_REQUEST["inskategori"]:"";
$inpakar_bidang=isset($_REQUEST["inpakar_bidang"])?$_REQUEST["inpakar_bidang"]:"";
$inpakar_khusus=isset($_REQUEST["inpakar_khusus"])?$_REQUEST["inpakar_khusus"]:"";
$penceramah=isset($_REQUEST["penceramah"])?$_REQUEST["penceramah"]:"";
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";

//if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sql_tkh = " AND startdate >= ".tosql($tkh_mula)." "; }
$strAddStDate=((strlen($tkh_mula)>0)?" AND B.startdate >= ".tosql(DBDate($tkh_mula))." ":"");
$strAddEndDate=((strlen($tkh_tamat)>0)?" AND B.enddate <= ".tosql(DBDate($tkh_tamat))." ":"");
$strPusat=((strlen($penceramah)>0)?" AND ingenid = ".tosql($penceramah)." ":"");
$strGred=((strlen($inskategori)>0)?" AND inskategori = ".tosql($inskategori)." ":"");

?>
<form name="ilim" method="post" action="">
<div class="printButton" align="center">
<table width="<?=$width?>" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr><td colspan="2" align="center"><b>PROSES CETAKAN LAPORAN PENCERAMAH</b><BR /></td></tr>
	<?php
    $sqlp = "SELECT * FROM _ref_titlegred WHERE is_deleted=0 AND f_status=0 ORDER BY f_gred_code";
    $rspg = &$conn->execute($sqlp);
    ?>
    <tr><td  width="30%"align="right">Kategori Penceramah : </td>
        <td width="70%" align="left">
        <select name="inskategori"  onchange="do_post('')" style="cursor:pointer" title="Sila buat pilihan untuk penyenaraian nama penceramah">
        	<option value="">-- Semua kategori --</option>
		<?php	
            $r_kat = &$conn->execute("SELECT * FROM _ref_kategori_penceramah ORDER BY f_kp_sort");
            while (!$r_kat->EOF){ ?>
            <option value="<?=$r_kat->fields['f_kp_id'] ?>" <?php if($inskategori == $r_kat->fields['f_kp_id']) echo "selected"; ?> >
            <?=$r_kat->fields['f_kp_kenyataan']?></option>
            <?php $r_kat->movenext(); }?>        
           </select>
        </td></tr>
		<tr>
            <td align="right">Bidang Kepakaran : </td>
            <td>
                <select name="inpakar_bidang" onChange="do_post('')" >
                <option value=""></option>
                <?php 
                //$r_gred = dlookupList('_ref_kepakaran', 'f_pakar_code,f_pakar_nama', '', 'f_pakar_nama');
                $r_gred = &$conn->execute("SELECT * FROM _ref_kepakaran ORDER BY f_pakar_nama");
                while (!$r_gred->EOF){ ?>
                <option value="<?=$r_gred->fields['f_pakar_code'] ?>" <?php if($inpakar_bidang == $r_gred->fields['f_pakar_code']) echo "selected"; ?> >
                <?=$r_gred->fields['f_pakar_nama']?></option>
                <?php $r_gred->movenext(); }?>        
               </select></td>
        </tr>    
        <!--<tr>
        <td align="right">Pilih Tarikh Mula : </td>
        <td><input type="text" size="13" name="tkh_mula" value="<? echo $tkh_mula;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
            &nbsp;&nbsp;&nbsp;Tamat : 
            <input type="text" size="13" name="tkh_tamat" value="<? echo $tkh_tamat;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/> [dd/mm/yyyy]
        </td>   
    </tr>-->
    <tr>
        <td align="center" colspan="2">
        <input type="button" value="Proses" onClick="do_post('PRO')" style="cursor:pointer" />
        <input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
	    <input type="button" value="Salin Ke Excel" onClick="do_open('laporan_penceramah_excel.php?pos=<?=$pos;?>&inskategori=<?=$inskategori;?>&penceramah=<?=$penceramah;?>&tkh_mula=<?=$tkh_mula;?>&tkh_tamat=<?=$tkh_tamat;?>')" style="cursor:pointer" />
        <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup window" style="cursor:pointer">
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
                <div><h3><I><B>INSTITUT LATIHAN ISLAM MALAYSIA<BR>JABATAN KEMAJUAN ISLAM MALAYSIA</B></I></h3></div>
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
              <td align="center"><B>LAPORAN PENCERAMAH BERDASARKAN BIDANG
              <?php if(!empty($pusat)){ print "<br>NAMA PENCERAMAH : " . dlookup("_tbl_instructor","insname","ingenid=".tosql($penceramah)); }?>
              <?php if(!empty($grade)){ print "<br>KATEGORI : " . dlookup("_ref_kategori_penceramah","f_kp_kenyataan","f_kp_id=".tosql($inskategori)); }?>
              <?php if(!empty($tkh_mula) && !empty($tkh_tamat)){ print '<br>TARIKH '.$tkh_mula.' - '.$tkh_tamat; }
             	else if(!empty($tkh_mula) && empty($tkh_tamat)){ print '<br>TARIKH '.$tkh_mula.' - '.date("d/m/Y"); }?>
              </B></td>
            </tr>
        </table>
    </td></tr>
</table>

<table width="<?=$width;?>" class="data" border="1" cellpadding="3" cellspacing="0">
	<tr bgcolor="#CCCCCC">
    	<td rowspan="1" width="5%" align="center"><b>Bil</b></td>
        <td rowspan="1" width="30%" align="center"><b>Nama<br>No. KP</b></td>
        <td rowspan="1" width="25%" align="center"><b>Tempat Bertugas</b></td>
        <td rowspan="1" width="40%" align="center"><b>Bidang Kepakaran</b></td>
    </tr>
<?php
//$conn->debug=true;
$sql = "SELECT * FROM _tbl_instructor A ";
if(!empty($inpakar_bidang)){ $sql .= ", _tbl_instructor_kepakaran B "; }
$sql .= " WHERE A.is_deleted=0 ";
if(!empty($inpakar_bidang)){ $sql .= " AND A.ingenid=B.ingenid AND B.inpakar_bidang=".tosql($inpakar_bidang); }
$sql .= $strPusat . $strGred;
$sql .= " ORDER BY A.insname";
$rs = &$conn->execute($sql);
//$conn->debug=false;
if(!$rs->EOF){
	while(!$rs->EOF){
	$bil++;
	$sql1 = "SELECT A.*, B.f_pakar_nama 
	FROM _tbl_instructor_kepakaran A, _ref_kepakaran B
	WHERE A.inpakar_bidang=B.f_pakar_code AND A.ingenid=".tosql($rs->fields['ingenid']);
	if(!empty($inpakar_bidang)){ $sql1 .= " AND A.inpakar_bidang=".tosql($inpakar_bidang); }
	//$sql1 .= $strAddStDate.$strAddEndDate;
	//$sql1 .= " ORDER BY startdate ";
	$rs1 = $conn->execute($sql1);
	$bilg=0;
?>
    <tr height="25">
    	<td align="right" valign="top"><?php print $bil;?>.&nbsp;</td>
        <td align="left" valign="top"><?php print $rs->fields['insname'];?><br><? print $rs->fields['insid'];?>&nbsp;</td>
        <td align="left" valign="top"><?php print $rs->fields['insorganization'];?>&nbsp;</td>
        <td align="left" valign="top">
            <?php while(!$rs1->EOF){ ?>
                        Bidang: <?php print $rs1->fields['f_pakar_nama'];?><br>
                        Pengkususan: <?php print $rs1->fields['inpakar_pengkhususan'];?>&nbsp;
                        <?php if($bilg>0){ print '<br><hr>'; } ?>
            <?php $rs1->movenext(); $bilg++; } ?>
        </td>
    </tr>
<?php
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