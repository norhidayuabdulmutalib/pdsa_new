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
$rs = &$conn->execute($sSQL);
include 'include/pageconf.inc.php'; // execute query
$pagepaparan = 'index.php?data='.base64_encode('4;utiliti/unit.php');
?>
<div><h2>SENARAI MAKLUMAT NAMA UNIT</h2></div>
<table width="95%" cellpadding="0" cellspacing="0" align="center">
    <form name="frm" method="post" action="">
    <tr>
    <td width="20%" align="left"><strong>Bahagian :</strong></td>
    <td width="80%" align="left">
	<?	$sql_b = "SELECT * FROM kod_bahagian WHERE status=0 ORDER BY nama_bahagian";
        $rs_b = &$conn->Execute($sql_b);
    ?>
        <select name="get_bahagian" onchange="do_submit('<?=$pagepaparan;?>')">
            <option value=""> -- Sila pilih -- </option>
            <?php while(!$rs_b->EOF){ ?>
            <option value="<?=$rs_b->fields['id_bahagian'];?>" <?php if($rs_b->fields['id_bahagian']==$get_bahagian){ print 'selected'; } ?>
            ><?php print $rs_b->fields['nama_bahagian'];?></option>
            <?php $rs_b->movenext(); } ?>
        </select>
        &nbsp;&nbsp;
        <!--<input type="submit" id="button" value="Cari" style="cursor:pointer" /> &nbsp;&nbsp;-->
        <input type="button" id="button" value="Tambah" onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/unit_form.php;')?>')" style="cursor:pointer" />
    <br /><br />
    </td>
    </tr>
    </form>
	<tr><td width="100%" colspan="2">
      <?php include_once 'include/pagepaparan.inc.php';// display record count and list?>
  <table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr align="center" class="table_head">
      <td width="7%"><strong>Bil</strong></td>
      <td width="40%"><strong>Nama Unit</strong></td>
      <td width="40%"><strong>Nama Bahagian</strong></td>
      <td width="13%"><strong>Status</strong></td>
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
      <td align="left"><a href="index.php?data=<?=base64_encode('4;utiliti/unit_form.php;'.$rs->fields['id_unit']);?>&PageNo=<?php echo $PageNo;?>"><?php echo $rs->fields['nama_unit']?></a></td>
      <td align="left"><?=$rs->fields['nama_bahagian']?></td>
      <td align="center"><?php if($rs->fields['status_unit']=='0'){ print 'Aktif'; } else { print 'Tidak Aktif'; } ?></td>
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
$syarat = "pglst=$PageQUERY&bhg=$id_bahagian&cari=$cari"; 
include_once 'include/paging.inc.php';
?>
<div align="center"><input type="button" id="button" value="Tambah" onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/unit_form.php;')?>')" style="cursor:pointer" /></div>
</td></tr>
</table>
