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
/*if(!empty($_SESSION['bhg']) && empty($_GET['bhg'])){
	$bhg = $_SESSION['bhg'];
	print "1";
} else if(!empty($_GET['bhg'])){ 
	$bhg = $_GET['bhg']; 
	$_SESSION['bhg']= $bhg;
	print "2";
}*/
if(!empty($_POST['get_bahagian'])){ $get_bahagian = $_POST['get_bahagian']; } else { $get_bahagian = $_GET['get_bahagian']; }


if($sort=='nama'){
	$sorder = " ORDER BY A.nama_unit";
} else if($sort=='get_bahagian'){
	$sorder = " ORDER BY B.nama_bahagian";
} else {
	$sorder = " ORDER BY B.nama_bahagian";
}

//if(!empty($cari)){ $scari = " WHERE nama = '" . $cari ."' "; } else { $scari = " "; }
//if(!empty($bhg)){ $scari = " WHERE nama = '" . $cari ."' "; } else { $scari = " "; }
if(!empty($get_bahagian)){ $scari = " AND A.id_bahagian = " .tosql($get_bahagian,"Number"); } else { $scari = " "; }
$sSQL = "SELECT A.*, B.nama_bahagian FROM kod_unit A, kod_bahagian B WHERE A.id_bahagian=B.id_bahagian " . $scari . $sorder;
//echo $sSQL;
include 'include/pageconf.inc.php'; // execute query
$pagepaparan = 'index.php?data='.base64_encode('utiliti/unit.php');
?>
<br />
<form name="frm" method="post" action="<?=$pagepaparan;?>">
<table width="95%" cellpadding="0" cellspacing="0" align="center">
    <tr>
    <td width="20%" align="left">Bahagian :</td>
    <td width="80%" align="left">
	<?	$sql_b = "SELECT * FROM kod_bahagian WHERE status=0 ORDER BY nama_bahagian";
        $rs_b = &$conn->Execute($sql_b);
    ?>
        <select name="get_bahagian">
            <option value=""> -- Sila pilih -- </option>
            <?php while($row_b = mysql_fetch_assoc($rs_b)){ ?>
            <option value="<?=$row_b['id_bahagian'];?>" <?php if($row_b['id_bahagian']==$get_bahagian){ print 'selected'; } ?>
            ><?php print $row_b['nama_bahagian'];?></option>
            <?php } ?>
        </select>
        &nbsp;&nbsp;
        <input type="submit" id="button" value="Cari" style="cursor:pointer" />
    </td>
    </tr>
	<tr><td width="100%" colspan="2">
      <?php include_once 'include/pagepaparan.inc.php';// display record count and list?>
<table width="100%" cellpadding="0" cellspacing="0" align="center">
	<tr><td width="100%" colspan="2">
      <?php include_once 'include/pagepaparan.inc.php';// display record count and list?>
  <table width="100%" border="0" cellspacing="1" cellpadding="5"  bgcolor="#000000">
    <tr class="listhead">
      <td width="100%" colspan="4">SENARAI NAMA UNIT</td>
    </tr>
    <tr class="listhead" align="center">
      <td width="7%">Bil</td>
      <td width="40%">Nama Unit</td>
      <td width="40%">Nama Bahagian</td>
      <td width="13%">Status</td>
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
      <td align="left"><a href="index.php?data=<?=base64_encode('utiliti/unit_form.php;'.$row['id_unit']);?>&PageNo=<?php echo $PageNo;?>"><?php echo $row['nama_unit']?></a></td>
      <td align="left"><?=$row['nama_bahagian']?></td>
      <td align="center"><?php if($row['status_unit']=='0'){ print 'Aktif'; } else { print 'Tidak Aktif'; } ?></td>
    </tr>
    <?
} // end loop
?>
  </table>
<?php
$namafail =  $pagepaparan;  
$syarat = "pglst=$PageQUERY&bhg=$id_bahagian&cari=$cari"; 
include_once 'include/paging.inc.php';
?>
<div align="center"><input type="button" id="button" value="Tambah" onclick="do_submit('index.php?data=<?=base64_encode('utiliti/unit_form.php;')?>')" style="cursor:pointer" /></div>
</td></tr>
</table>
</form>
</td></tr>
</table>
