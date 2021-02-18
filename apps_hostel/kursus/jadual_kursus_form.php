<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//if(isset($_GET['load_pages'])){
$bg1=''; $bg2=''; $bg3=''; $bg4=''; $bg5='';
$pct = intval(100/3);
$load_pages = $_GET['load_pages'];
$href_link = "modal_form.php?win=".base64_encode('kursus/jadual_kursus_form.php;'.$id);
if(empty($load_pages)){ $disp_pages = 'kursus/jadual_kursus_masa.php'; $bg1='#CCCCCC'; }
else if($load_pages=='peserta'){ $disp_pages = 'kursus/jadual_kursus_peserta.php'; $bg2='#CCCCCC'; }
else if($load_pages=='bilik'){ $disp_pages = 'kursus/jadual_kursus_bilik.php'; $bg5='#CCCCCC'; }
//else if($load_pages=='penceramah'){ $disp_pages = 'kursus/jadual_kursus_ceramah.php'; $bg3='#CCCCCC'; }
//else if($load_pages=='kriteria'){ $disp_pages = 'kursus/jadual_kursus_kriteria.php'; $bg4='#CCCCCC'; }
//}
//print "LP:".$disp_pages;
$start_kursus = dlookup("_tbl_kursus_jadual","startdate","id = ".tosql($id,"Text"));
$btn_display=1;
if(!empty($start_kursus) && $start_kursus>=date("Y-m-d")){
	$btn_display=1;
	//print "Start:".$start_kursus;
}
?>
<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar2.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js"></script>
<script LANGUAGE="JavaScript">
function form_back(URL){
	parent.emailwindow.hide();
}
function do_hapus(jenis,idh){
	var URL = 'include/proses_hapus.php?jenis='+jenis+'&idh='+idh;
	if(confirm("Adakah anda pasti untuk menghapuskan data yang dipilih daripada senarai?")){
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Hapus Maklumat', 'width=200px,height=200px,center=1,resize=1,scrolling=0')
	}
}
</script>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="6" class="title" height="25">SELENGGARA MAKLUMAT JADUAL KURSUS
        <div style="float:right"><input type="button" value="Tutup" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan disiplin" onClick="form_back()" ></div>
        </td>
    </tr>
	<?php if(!empty($id)){ ?>
        <tr height="25">
            <td width="<?=$pct;?>%" align="center" bgcolor="<?=$bg1;?>"><a href="<?=$href_link;?>&load_pages="><b>Maklumat Kursus</b></a></td>
            <td width="<?=$pct;?>%" align="center" bgcolor="<?=$bg2;?>"><a href="<?=$href_link;?>&load_pages=peserta"><b>Maklumat Peserta</b></a></td>
            <td width="<?=$pct;?>%" align="center" bgcolor="<?=$bg5;?>"><a href="<?=$href_link;?>&load_pages=bilik"><b>Maklumat Tempahan Bilik</b></a></td>
        </tr>
    <?php } ?>
	<tr><td colspan="6">
    	<? include $disp_pages; ?>
    </td></tr>
</table>
<div align="center"><br />
<input type="button" value="Tutup" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan disiplin" onClick="form_back()" >
</div>
