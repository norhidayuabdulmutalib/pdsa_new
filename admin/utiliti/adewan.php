<script language="javascript">
	function do_submit(URL){
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
</script>
<?
$sort = isset($_REQUEST['sort'])?$_REQUEST['sort']:"";
$cari = isset($_REQUEST['cari'])?$_REQUEST['cari']:"";
if(!empty($_REQUEST['cari'])){ $cari = $_REQUEST['cari']; }

if($sort=='nama'){
	$sorder = " ORDER BY A.nama_ap";
} else if($sort=='kod'){
	$sorder = " ORDER BY A.kod_kaw_ap";
} else if($sort=='kaw'){
	$sorder = " ORDER BY B.p_nama";
} else {
	$sorder = " ORDER BY A.nama_ap";
}

//if(!empty($cari)){ $scari = " WHERE nama = '" . $cari ."' "; } else { $scari = " "; }
if(!empty($cari)){ $scari = " AND A.nama_ap LIKE '%" . addslashes($cari) ."%' "; } else { $scari = " "; }

$sSQL = "SELECT A.* FROM ahliparlimen A WHERE A.type='AD' AND A.is_deleted=0 " . $scari . $sorder;
$rs = &$conn->execute($sSQL);

include 'include/pageconf.inc.php'; // execute query

$pagepaparan = 'index.php?data='.base64_encode('4;utiliti/adewan.php').'&cari='.$cari;
$_SESSION['referer'] = $pagepaparan.'&PageNo='.$PageNo;
?>
<div><h2>SENARAI NAMA AHLI YANG BERHORMAT - DEWAN NEGARA</h2></div>
<table width="95%" cellpadding="0" cellspacing="0" align="center">
	<tr><td>
<form name="cari" method="post">
<table width="100%" cellpadding="3" cellspacing="0">
	<tr>
    	<td width="100%"><strong>Maklumat Carian :</strong> 
        <input type="text" name="cari" value="<?php echo $cari;?>" size="50" />
        &nbsp;&nbsp;
        <input type="button" id="button" value="Cari" onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/adewan.php;')?>')"/>
        &nbsp;&nbsp;
        <input type="button" id="button" value="Tambah" onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/adewan_form.php;')?>')" />
        </td>
    </tr>
</table>
</form>
<br />
<?php include_once 'include/pagepaparan.inc.php';// display record count and list?>
  <table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr align="center" class="table_head">
    <td width="5%"><strong>Bil</strong></td>
    <td width="40%"><strong>Nama Ahli Dewan Negara</strong></td>
    <td width="35%"><strong>Lantikan</strong></td>
    <td width="10%"><strong>Status</strong></td>
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
    <td align="left"><a href="index.php?data=<?=base64_encode('4;utiliti/adewan_form.php;'.$rs->fields['id_ap']);?>&PageNo=<?php echo $PageNo;?>"><?php echo $rs->fields['nama_ap']?></a></td>
    <td><?php print $rs->fields['kawasan_ap']?></td>
    <td align="center"><?php if($rs->fields['status_ap']=='0'){ print 'Aktif'; } else { print 'Tidak Aktif'; } ?></td>
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
<div align="center"><input type="button" id="button" value="Tambah" onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/adewan_form.php;')?>')" /></div>
</td></tr>
</table>
