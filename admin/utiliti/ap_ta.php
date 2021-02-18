<script language="javascript">
	function do_submit(URL){
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
</script>
<?php
$sort=isset($_REQUEST["sort"])?$_REQUEST["sort"]:"";
$cari=isset($_REQUEST["cari"])?$_REQUEST["cari"]:"";
if(!empty($_GET['cari'])){ $cari = $_GET['cari']; }

if($sort=='nama'){
	$sorder = " ORDER BY A.nama_ap";
} else if($sort=='kod'){
	$sorder = " ORDER BY A.kod_kaw_ap";
} else if($sort=='kaw'){
	$sorder = " ORDER BY B.p_nama";
} else {
	$sorder = " ORDER BY A.kod_kaw_ap";
}

//if(!empty($cari)){ $scari = " WHERE nama = '" . $cari ."' "; } else { $scari = " "; }
if(!empty($cari)){ $scari = " AND (A.nama_ap LIKE '%" . addslashes($cari) ."%' OR A.kod_kaw_ap LIKE '%" . addslashes($cari) ."%') "; } else { $scari = " "; }

$sSQL = "SELECT A.*, B.p_nama FROM ahliparlimen A, kod_parlimen B WHERE A.type='AP' AND A.kod_kaw_ap=B.p_kod AND A.status_ap=1" . $scari . $sorder;
$rs = &$conn->execute($sSQL);

include 'include/pageconf.inc.php'; // execute query
//echo $strSQL;
//$result = &$conn->Execute($sql);
//if(!$result){ echo "Invalid query : " . mysql_errno(); }
$pagepaparan = 'index.php?data='.base64_encode('4;utiliti/ap_ta.php');
?>
<div><h2>SENARAI MAKLUMAT NAMA AHLI DEWAN RAKYAT - Tidak Aktif</h2></div>
<table width="95%" cellpadding="0" cellspacing="0" align="center">
	<tr><td>
<table width="100%" cellpadding="5" cellspacing="1">
	<tr>
    	<td width="100%">Maklumat Carian : 
        <input type="text" name="cari" value="<?php echo $cari;?>" />
        &nbsp;&nbsp;
        <input type="button" id="button" value="Cari"  onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/ap_ta.php;')?>')"/>
        </td>
    </tr>
</table>
<br />
<?php include_once 'include/pagepaparan.inc.php';// display record count and list?>
  <table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr align="center" class="table_head">
    <td width="5%"><strong>Bil</strong></td>
    <td width="5%"><strong>Kod Kawasan</strong></td>
    <td width="30%"><strong>Kawasan</strong></td>
    <td width="40%"><strong>Nama Ahli Dewan Rakyat</strong></td>
    <td width="10%"><strong>Tarikh Mula</strong></td>
    <td width="10%"><strong>Tarikh Tamat</strong></td>
    <!-- td width="5%">Status</td -->
  </tr>
<?php
if(!$rs->EOF){
	$cnt = 1;
	$bil = $StartRec;
	while(!$rs->EOF  && $cnt <= $pg) {
		$bil = $cnt + ($PageNo-1)*$PageSize;
		$i++;
?>
  <tr>
    <td align="right"><?=$bil;?>.</td>
    <td align="center"><a href="index.php?data=<?=base64_encode('4;utiliti/ap_ta_form.php;'.$rs->fields['id_ap']);?>&PageNo=<?php echo $PageNo;?>"><?php print $rs->fields['kod_kaw_ap']?></a></td>
    <td><?php print $rs->fields['p_nama']?></td>
    <td align="left"><?php echo $rs->fields['nama_ap']?></td>
    <td align="center"><?php echo displaydate($rs->fields['tkh_mula'])?></td>
    <td align="center"><?php echo displaydate($rs->fields['tkh_tamat'])?></td>
    <!-- td align="center"><?php if($rs->fields['status_ap']=='0'){ print 'Aktif'; } else { print 'Tidak Aktif'; } ?></td -->
  </tr>
<?php
		$cnt = $cnt + 1;
		$bil = $bil + 1;
		$rs->movenext();
	}
}
?>
</table>
<br />
<?php 
$namafail =  $pagepaparan;  
$syarat = "pglst=$PageQUERY&cari=$cari"; 
include_once 'include/paging.inc.php';
?>
</td></tr>
</table>
