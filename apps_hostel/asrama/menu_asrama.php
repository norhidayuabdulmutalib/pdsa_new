<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
<link rel="stylesheet" href="menu/menu.css" type="text/css">
<tr>
	<td align="left" width="18%" valign="top">
	<?
    //$conn->debug=true;
    //echo "SD: ".$_SESSION['sub_menu'];
	if(empty($sub_tab)){ $sub_tab='../apps/asrama/bilik_list.php'; $submenu='bilik'; }
    $_SESSION['sub_menu'] = $submenu;
	$href_directory='../apps/';
    ?>
    <div id="menu12">
        <ul>
    	<li <? if($_SESSION['sub_menu']=='blok'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;asrama/menu_asrama.php;asrama;blok;;../apps/maintenance/blok_list.php');?>"><b>Rujukan Blok Bangunan</b></a></li>
    	<li <? if($_SESSION['sub_menu']=='kblok'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;asrama/menu_asrama.php;asrama;kblok;;../apps/maintenance/kblok_list.php');?>"><b>Rujukan Kategori Blok</b></a></li>
    	<li <? if($_SESSION['sub_menu']=='aras_bangunan'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;asrama/menu_asrama.php;asrama;aras_bangunan;;../apps/maintenance/aras_bangunan_list.php');?>">
            <b>Rujukan Aras Bangunan</b></a></li>
    	<li <? if($_SESSION['sub_menu']=='bkuliah'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;asrama/menu_asrama.php;asrama;bkuliah;;../apps/maintenance/bilik_kuliah_list.php');?>"><b>Maklumat Bilik Kuliah</b></a></li>
    	<li <? if($_SESSION['sub_menu']=='bilik'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;asrama/menu_asrama.php;asrama;bilik;;../apps/asrama/bilik_list.php');?>"><b>Maklumat Bilik Asrama</b></a></li>
    	<li <? if($_SESSION['sub_menu']=='pbilik'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;asrama/menu_asrama.php;asrama;pbilik;;asrama/penggunabilik_list.php');?>"><b>Maklumat Penggunaan Bilik</b></a></li>
    	<li <? if($_SESSION['sub_menu']=='bkuliah_list'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;asrama/menu_asrama.php;asrama;bkuliah_list;;kursus/bkuliah_list.php');?>"><b>Maklumat Penggunaan Bilik Kuliah</b></a></li>
    	<li <? if($_SESSION['sub_menu']=='paparan'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;asrama/menu_asrama.php;asrama;paparan;;paparan_asrama.php');?>"><b>Maklumat Paparan Asrama</b></a></li>
    	<li <? if($_SESSION['sub_menu']=='laporan'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;asrama/menu_asrama.php;asrama;laporan;;../laporand/laporan_list.php');?>"><b>Laporan Asrama</b></a></li>
    	<li <? if($_SESSION['sub_menu']=='kursus'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;asrama/menu_asrama.php;asrama;kursus;;kursus/senarai_kursus_lepas.php');?>"><b>Maklumat Kursus Lepas</b></a></li>
        </ul>	
    </div>
    </td>
	<td width="82%" valign="top">
    <?php include $sub_tab;?>
    </td>    
    
    </tr>
</table> 