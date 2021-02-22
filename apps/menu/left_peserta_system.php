<?php 
$_SESSION['sub_menu'] = $submenu;
?>
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.php?data=<?php print base64_encode($userid.';default;main;;');?>"><img src="../images/logo_ilim.jpg" style="width:30px; height: 30px;"> Sistem PDSA</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html" style="color:#000">PDSA</a>
        </div>
        <ul class="sidebar-menu">
            <!-- <ul> -->
                <li <? if($_SESSION['sub_menu']=='default'){ print 'class="current"'; }?>>
                    <a href="index.php?data=<? print base64_encode('user;default_peserta.php;default;default');?>"><b>Laman Utama</b></a></li>
                <!--<li <? if($_SESSION['sub_menu']=='biodata'){ print 'class="current"'; }?>>
                    <a href="index.php?data=<? print base64_encode('user;peserta/biodata.php;peserta;biodata');?>"><b>Biodata Peserta</b></a></li>
                <li <? if($_SESSION['sub_menu']=='senarai'){ print 'class="current"'; }?>>
                    <a href="index.php?data=<? print base64_encode('user;kursus/senarai_kursus_tahunan.php;peserta;senarai');?>"><b>Senarai Kursus Ditawarkan</b></a></li>
                <li <? if($_SESSION['sub_menu']=='mohon'){ print 'class="current"'; }?>>
                    <a href="index.php?data=<? print base64_encode('user;peserta/kursus_dipohon.php;peserta;mohon');?>"><b>Maklumat Pendaftaran Kursus</b></a></li>
                <li <? if($_SESSION['sub_menu']=='kursus'){ print 'class="current"'; }?>>
                    <a href="index.php?data=<? print base64_encode('user;peserta/kursus_dlmproses.php;peserta;kursus');?>"><b>Maklumat Kursus Diikuti</b></a></li>
                    -->
                <li <? if($_SESSION['sub_menu']=='penilaian'){ print 'class="current"'; }?>>
                    <a href="index.php?data=<? print base64_encode('user;peserta/kursus_penilaian.php;peserta;penilaian');?>"><b>Penilaian Kursus</b></a></li>
                <!--<li <? if($_SESSION['sub_menu']=='pass'){ print 'class="current"'; }?>>
                    <a href="index.php?data=<? print base64_encode('user;../include/peserta_pass.php');?>"><b>Tukar Katalaluan</b></a></li>-->
            <!-- </ul> -->

            <li>
                <a href="index.php?data=<? print base64_encode(';../logout.php');?>">
                    <b>Log Keluar</b>
                </a>
            </li>
        </ul>
    </aside>
</div>