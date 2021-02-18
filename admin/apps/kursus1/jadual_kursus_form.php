<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//if(isset($_GET['load_pages'])){
$bg1=''; $bg2=''; $bg3=''; $bg4=''; $bg5='';
$load_pages = $_GET['load_pages'];
$href_link = "modal_form.php?win=".base64_encode('kursus/jadual_kursus_form.php;'.$id);
if(empty($load_pages)){ $disp_pages = 'kursus/jadual_kursus_masa.php'; $bg1='#CCCCCC'; }
else if($load_pages=='maklumat'){ $disp_pages = 'kursus/jadual_kursus_maklumat.php'; $bg2='#CCCCCC'; }
else if($load_pages=='penceramah'){ $disp_pages = 'kursus/jadual_kursus_ceramah.php'; $bg3='#CCCCCC'; }
else if($load_pages=='kriteria'){ $disp_pages = 'kursus/jadual_kursus_kriteria.php'; $bg4='#CCCCCC'; }
else if($load_pages=='peserta'){ $disp_pages = 'kursus/jadual_kursus_peserta.php'; $bg5='#CCCCCC'; }
else if($load_pages=='nilai'){ $disp_pages = 'penilaian/set_penilaian_kursus_list.php'; $bg6='#CCCCCC'; }
//}
//print "LP:".$disp_pages;
//$start_kursus = dlookup("_tbl_kursus_jadual","startdate","id = ".tosql($id,"Text"));
$start_kursus = dlookup("_tbl_kursus_jadual","enddate","id = ".tosql($id,"Text"));
$btn_display=0;
if($_SESSION['SESS_DEL']==1){ 
	$btn_display=1; 
} else if(!empty($start_kursus) && $start_kursus>=date("Y-m-d")){
	$btn_display=1; 
}
//print "SESS:".$_SESSION['SESS_DEL'];
//print "Start:".$start_kursus;
?>
<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar2.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js"></script>
<script LANGUAGE="JavaScript">
function form_back1(URL){
	//alert("ss");
	refresh = parent.location; 
	parent.location = refresh;
}
function do_hapus(jenis,idh){
	var URL = 'include/proses_hapus.php?jenis='+jenis+'&idh='+idh;
	if(confirm("Adakah anda pasti untuk menghapuskan data yang dipilih daripada senarai?")){
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Hapus Maklumat', 'width=200px,height=200px,center=1,resize=1,scrolling=0')
	}
}
function open_windows(URL){
	//window.open (URL, "mywindow","location=1,status=1,scrollbars=1, width=90%,height=90%");
	window.showModalDialog(URL,"","dialogWidth:1100px;dialogHeight:700px");
} //End "opennewsletter" function
</script>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="6" class="title" height="25">
        <div style="float:left">SELENGGARA MAKLUMAT JADUAL KURSUS</div>
        <div style="float:right"><input type="button" value="Tutup" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan disiplin" onClick="form_back1()" ></div>
        </td>
    </tr>
	<?php if(!empty($id)){ ?>
        <tr height="25">
            <td width="17%" align="center" bgcolor="<?=$bg1;?>"><a href="<?=$href_link;?>&load_pages="><b>Maklumat Kursus</b></a></td>
            <td width="17%" align="center" bgcolor="<?=$bg3;?>"><a href="<?=$href_link;?>&load_pages=penceramah"><b>Maklumat Penceramah</b></a></td>
            <td width="17%" align="center" bgcolor="<?=$bg2;?>"><a href="<?=$href_link;?>&load_pages=maklumat"><b>Maklumat Jadual & Kandungan</b></a></td>
            <td width="17%" align="center" bgcolor="<?=$bg4;?>"><a href="<?=$href_link;?>&load_pages=kriteria"><b>Kriteria Pemilihan</b></a></td>
            <td width="15%" align="center" bgcolor="<?=$bg5;?>"><a href="<?=$href_link;?>&load_pages=peserta"><b>Maklumat Peserta</b></a></td>
            <td width="17%" align="center" bgcolor="<?=$bg6;?>"><a href="<?=$href_link;?>&load_pages=nilai"><b>Maklumat Penilaian Kursus</b></a></td>
        </tr>
    <?php } ?>
	<tr><td colspan="6">
    	<?php include $disp_pages; ?>
    </td></tr>
</table>
<!--<div align="center"><br />
<input type="button" value="Tutup" class="button_disp" title="Sila klik untuk kembali ke senarai jadual kursus" onClick="form_back()" >
</div>-->
