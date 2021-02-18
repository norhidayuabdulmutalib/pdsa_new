<link rel="stylesheet" href="menu/menu.css" type="text/css">
<?
//$conn->debug=true;
$_SESSION['sub_menu'] = $submenu;
//echo "SD: ".$_SESSION['sub_menu'];
?>
    <ul class="menu6">
        <li class="curr">
            <a href="index.php?data=<?php print base64_encode($userid.';apps/default.php;default');?>"><b>MENU UTAMA SISTEM</b></a></li>
    </ul>
    <div id="menu12">
        <ul>
    	<li <?php if($_SESSION['sub_menu']=='default'){ print 'class="current"'; }?>>
            <a href="index.php?data=<?php print base64_encode($userid.';apps/default_peserta.php;default;default');?>"><b>Laman Utama</b></a></li>
    	<!--<li <?php if($_SESSION['sub_menu']=='biodata'){ print 'class="current"'; }?>>
            <a href="index.php?data=<?php print base64_encode($userid.';apps/peserta/biodata.php;peserta;biodata');?>"><b>Biodata Peserta</b></a></li>
    	<li <?php if($_SESSION['sub_menu']=='senarai'){ print 'class="current"'; }?>>
            <a href="index.php?data=<?php print base64_encode($userid.';apps/kursus/senarai_kursus_tahunan.php;peserta;senarai');?>"><b>Senarai Kursus Ditawarkan</b></a></li>
    	<li <?php if($_SESSION['sub_menu']=='mohon'){ print 'class="current"'; }?>>
            <a href="index.php?data=<?php print base64_encode($userid.';apps/peserta/kursus_dipohon.php;peserta;mohon');?>"><b>Maklumat Pendaftaran Kursus</b></a></li>
    	<li <?php if($_SESSION['sub_menu']=='kursus'){ print 'class="current"'; }?>>
            <a href="index.php?data=<?php print base64_encode($userid.';apps/peserta/kursus_dlmproses.php;peserta;kursus');?>"><b>Maklumat Kursus Diikuti</b></a></li>
            -->
    	<li <?php if($_SESSION['sub_menu']=='penilaian'){ print 'class="current"'; }?>>
            <a href="index.php?data=<?php print base64_encode($userid.';apps/peserta/kursus_penilaian.php;peserta;penilaian');?>"><b>Penilaian Kursus</b></a></li>
    	<!--<li <?php if($_SESSION['sub_menu']=='pass'){ print 'class="current"'; }?>>
            <a href="index.php?data=<?php print base64_encode($userid.';apps/../include/peserta_pass.php');?>"><b>Tukar Katalaluan</b></a></li>-->
        </ul>	
    </div>
<br />
&nbsp;<a href="index.php?data=<?php print base64_encode(';../logout.php');?>"><img src="../images/door02.gif" width="15" height="15" border="0"></a>&nbsp;
<a href="index.php?data=<?php print base64_encode(';../logout.php');?>">
<font face="Verdana" size="2" color="#000000"><b>Log Keluar</b></font></a>