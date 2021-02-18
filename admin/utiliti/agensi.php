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
} else if($sort=='status'){
	$sorder = " ORDER BY status";
} else {
	$sorder = " ORDER BY nama_agensi";
}

//if(!empty($cari)){ $scari = " WHERE nama = '" . $cari ."' "; } else { $scari = " "; }
if(!empty($cari)){ $scari = " WHERE nama_agensi LIKE '%" . $cari ."%' "; } else { $scari = " "; }
$sSQL = "SELECT * FROM kod_agensi " . $scari . $sorder;
include 'include/pageconf.inc.php'; // execute query
$pagepaparan = 'index.php?data='.base64_encode('utiliti/agensi.php');
?>
<br />
<table width="95%" cellpadding="0" cellspacing="0" align="center">
	<tr><td width="100%">
      <?php include_once 'include/pagepaparan.inc.php';// display record count and list?>
<form name="frm" method="post">
  <table width="100%" border="0" cellspacing="1" cellpadding="5"  bgcolor="#000000">
    <tr class="listhead">
      <td width="7%">Bil</td>
      <td width="64%"><a href="<?=$pagepaparan?>&sort=nama">Nama Agensi</a></td>
      <td width="29%"><a href="<?=$pagepaparan?>&sort=status">Status</a></td>
    </tr>
    <?
$i = 1;
$bil = 0;
while ($row=mysql_fetch_array($result,MYSQL_BOTH)){
	$bil = $i + ($PageNo-1)*$PageSize;
	$i++;
?>
    <tr class="list" bgcolor="<?php if ($i%2 == 1) echo $bg1; else echo $bg2 ?>">
      <td align="right"><?=$bil;?>.</td>
      <td><a href="index.php?data=<?=base64_encode('utiliti/agensi_form.php;'.$row['id_agensi']);?>&PageNo=<?php echo $PageNo;?>"><?php echo $row['nama_agensi']?></a></td>
      <td><?=$row['status']?></td>
    </tr>
    <?
} // end loop
?>
  </table>
<?php
$namafail =  $pagepaparan;  
$syarat = "pglst=$PageQUERY&cari=$cari"; 
include_once 'include/paging.inc.php';
?>
<div align="center"><input type="button" value="Tambah" onclick="do_submit('index.php?data=<?=base64_encode('utiliti/agensi_form.php;')?>')" /></div>
</form>
</td></tr>
</table>
