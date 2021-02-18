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
	var URL = 'laporan_penceramah.php?pos='+pro;
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
 	<?php
	$sqlp = "SELECT * FROM _tbl_instructor WHERE is_deleted=0 ";
	if(!empty($inskategori)){ $sqlp .= " AND inskategori=".tosql($inskategori); } 
	$sqlp .= " ORDER BY insname";
	$rspu = &$conn->execute($sqlp);
	?>
    <tr><td align="right">Nama Penceramah : </td>
    	<td><select name="penceramah" style="cursor:pointer" title="Sila pilih maklumat untuk carian" onChange="do_post('PRO')">
        	<option value="">-- Sila pilih --</option>
            <?php while(!$rspu->EOF){ ?>
            <option value="<?php print $rspu->fields['ingenid'];?>" <?php if($rspu->fields['ingenid']==$penceramah){ print 'selected'; }?>><?php print $rspu->fields['insname'];?></option>
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
              <td align="center"><B>LAPORAN PENCERAMAH BERDASARKAN KURSUS
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
        <td rowspan="1" width="25%" align="center"><b>Nama<br>No. KP</b></td>
        <td rowspan="1" width="20%" align="center"><b>Tempat Bertugas</b></td>
        <td rowspan="1" width="50%" align="center"><b>Tajuk Ceramah/Kursus&nbsp;<i>[Jumlah Jam]</i></b></td>
    </tr>
<?php
//$conn->debug=true;
$sql = "SELECT * FROM _tbl_instructor WHERE is_deleted=0";
$sql .= $strPusat . $strGred;
$sql .= " ORDER BY insname";
$rs = &$conn->execute($sql);
//$conn->debug=false;
if(!$rs->EOF){
	while(!$rs->EOF){
	$bil++;
	$sql1 = "SELECT A.tajuk, timediff(A.masa_tamat, A.masa_mula) AS masa, A.masa_mula, A.masa_tamat, C.coursename, B.startdate, B.enddate 
	FROM _tbl_kursus_jadual_masa A, _tbl_kursus_jadual B, _tbl_kursus C
	WHERE A.event_id=B.id AND B.courseid=C.id AND A.id_pensyarah=".tosql($rs->fields['ingenid']);
	$sql1 .= $strAddStDate.$strAddEndDate;
	$sql1 .= " ORDER BY startdate ";
	$rs1 = $conn->execute($sql1);
?>
    <tr height="25">
    	<td align="right" valign="top"><?php print $bil;?>.&nbsp;</td>
        <td align="left" valign="top"><?php print $rs->fields['insname'];?><br><? print $rs->fields['insid'];?>&nbsp;</td>
        <td align="left" valign="top"><?php print $rs->fields['insorganization'];?>&nbsp;</td>
        <td align="center" valign="top">
        	<table width="100%" cellpadding="2" cellspacing="0" border="1" class="data">
            <?php while(!$rs1->EOF){ 
				$masa = $rs1->fields['masa'];
				if($masa=='00:00:00'){ $masa_disp = '-'; }
				else {
					$masa_disp = intval(substr($masa,0,2)). " Jam "; 
					$masa_disp .= ": ".substr($masa,3,2). " minit"; 
				}
			?>
            	<tr>
                	<td width="80%">
                        Kursus: <?php print $rs1->fields['coursename'];?><br>
                        Tarikh: <?php print DisplayDate($rs1->fields['startdate']);?>-<?php print DisplayDate($rs1->fields['enddate']);?><br>
                        Tajuk: <?php print $rs1->fields['tajuk'];?>&nbsp;
                    </td>
                    <td width="20%" align="center"><?php print $masa_disp;?>&nbsp;</td>
                </tr>
            <?php $rs1->movenext(); } ?>
            </table>
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