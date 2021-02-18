<script language="javascript">
	function do_submit(URL){
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
</script>
<?php
$sort = $_GET['sort'];
$cari = $_POST['cari'];
if(!empty($_GET['cari'])){ $cari = $_GET['cari']; }

if($sort=='nama'){
	$sorder = " ORDER BY nama_bahagian";
} else if($sort=='no_akaun_pukal'){
	$sorder = " ORDER BY no_akaun_pukal";
} else {
	$sorder = " ORDER BY nama_bahagian";
}

//if(!empty($cari)){ $scari = " WHERE nama = '" . $cari ."' "; } else { $scari = " "; }
if(!empty($cari)){ $scari = " WHERE nama_bahagian LIKE '%" . addslashes($cari) ."%' "; } else { $scari = " "; }
$sSQL = "SELECT * FROM kod_bahagian " . $scari . $sorder;
$rs = &$conn->execute($sSQL);
include 'include/pageconf.inc.php'; // execute query
$pagepaparan = 'index.php?data='.base64_encode('4;utiliti/bahagian.php');
?>
<div><h2>SENARAI MAKLUMAT BAHAGIAN</h2></div>
<table width="95%" cellpadding="0" cellspacing="0" align="center">
	<tr><td width="100%">
      <?php include_once 'include/pagepaparan.inc.php';// display record count and list?>
  <table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr align="center" class="table_head">
      <td width="7%"><strong>Bil</strong></td>
      <td width="64%"><strong>Nama Bahagian</strong></td>
      <td width="9%"><strong>Kod Bahagian</strong></td>
      <td width="20%"><strong>Status</strong></td>
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
      <td align="left"><a href="index.php?data=<?=base64_encode('4;utiliti/bahagian_form.php;'.$rs->fields['id_bahagian']);?>&PageNo=<?php echo $PageNo;?>"><?php echo $rs->fields['nama_bahagian']?></a></td>
      <td align="left"><?php echo $rs->fields['kod_bahagian']?></td>
     <td align="center"><?php if($rs->fields['status']=='0'){ print 'Aktif'; } else { print 'Tidak Aktif'; } ?></td>
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
<div align="center"><input type="button" id="button" value="Tambah" onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/bahagian_form.php;')?>')" /></div>
</td></tr>
</table>
