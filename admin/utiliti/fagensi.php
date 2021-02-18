<?
include "../top/top.php";
?>
<script language="javascript">
	function do_submit(URL){
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
</script>
<?
$sort = $_GET['sort'];
$cari = $_POST['cari'];
if(!empty($_GET['cari'])){ $cari = $_GET['cari']; }

if($sort=='nama'){
	$sorder = " ORDER BY nama_agensi";
} else if($sort=='ic'){
	$sorder = " ORDER BY no_pendaftaran";
} else {
	$sorder = " ORDER BY nama_agensi";
}

//if(!empty($cari)){ $scari = " WHERE nama = '" . $cari ."' "; } else { $scari = " "; }
if(!empty($cari)){ $scari = " WHERE nama_agensi LIKE '%" . $cari ."%' "; } else { $scari = " "; }

$sSQL = "SELECT * FROM agensi " . $scari . $sorder;

//echo $sSQL;

include '../include/pageconf.inc.php'; // execute query
//echo $strSQL;
//$result = &$conn->Execute($sql);
//if(!$result){ echo "Invalid query : " . mysql_errno(); }
$pagepaparan = 'agensi1.php';
?>
<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td>
<form name="cari" method="post" action="kakitangan1.php">
<table width="100%" cellpadding="5" cellspacing="1">
	<tr>
    	<td width="100%">Maklumat Carian : 
        <input type="text" name="cari" value="<?php echo $cari;?>" />
        &nbsp;&nbsp;
        <input type="submit" value="Cari" />
        </td>
    </tr>
</table>
</form>
<?php include_once '../include/pagepaparan.inc.php';// display record count and list?>
<form name="frm" method="post">
<table width="100%" border="1" cellspacing="1" cellpadding="5">
  <tr class="listhead">
    <td width="3%">Bil</td>
    <td width="23%"><a href="<?=$pagepaparan?>?sort=nama">Nama Agensi</a></td>
    <td width="19%"><a href="<?=$pagepaparan?>?sort=ic">No Pendaftaran</a></td>
    <td width="17%">No Tel</td>
    <td width="16%">Status</td>
    <td width="15%">Pegawai</td>
  
  </tr>
<?
$i = 1;
$bil = 0;
while ($row=mysql_fetch_array($result,MYSQL_BOTH)){
	$bil = $i + ($PageNo-1)*$PageSize;
	$i++;
?>
  <tr class="list" bgcolor="<?php if ($i%2 == 1) echo $bg1; else echo $bg2 ?>">
    <td><?=$bil;?></td>
    <td><a href="agensi_form.php?id=<?php echo $row['id_agensi']?>&PageNo=<?php echo $PageNo;?>"><?php echo $row['nama_agensi']?></a></td>
    <td><?=$row['no_pendaftaran']?></td>
    <td><?php print $row['no_tel']?></td>
    <td><?php print $row['status']?></td>
  <td> <?php print $row['pegawai_agensi']?></td>
  </tr>
<?
} // end loop
?>
</table>
<?php 
$syarat = "pglst=$PageQUERY&cari=$cari"; 
include_once '../include/paging.inc.php';
?>
<div align="center"><input type="button" value="Tambah" onclick="do_submit('agensi_form.php')" /></div>
</form>
</td></tr>
</table>
<?php include "../top/footer.php"; ?>
