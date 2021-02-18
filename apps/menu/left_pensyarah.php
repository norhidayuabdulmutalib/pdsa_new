<link rel="stylesheet" href="menu/menu.css" type="text/css">
<?
//$conn->debug=true;
$_SESSION['sub_menu'] = $submenu;
//echo "SD: ".$_SESSION['sub_menu'];
?>
    <ul class="menu6">
        <li class="curr">
            <a href="index.php?data=<? print base64_encode('user;default.php;default');?>"><b>MENU UTAMA SISTEM</b></a></li>
    </ul>
    <div id="menu12">
        <ul>
    	<li <? if($_SESSION['sub_menu']=='default'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;default_pensyarah.php;penceramah;default');?>"><b>Laman Utama</b></a></li>
    	<li <? if($_SESSION['sub_menu']=='biodata'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;penceramah/penceramah_form.php;penceramah;biodata');?>"><b>Biodata Penceramah</b></a></li>
    	<li <? if($_SESSION['sub_menu']=='kursus'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;penceramah/kursus_diattach.php;penceramah;kursus');?>"><b>Maklumat Kursus</b></a></li>
    	<li <? if($_SESSION['sub_menu']=='penilaian'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;penceramah/kursus_penilaian_ceramah.php;penceramah;penilaian');?>"><b>Maklumat Penilaian Kursus</b></a></li>
    	<li <? if($_SESSION['sub_menu']=='pass'){ print 'class="current"'; }?>>
            <a href="index.php?data=<? print base64_encode('user;../include/penceramah_pass.php');?>"><b>Tukar Katalaluan</b></a></li>
        </ul>	
    </div>
<br />
&nbsp;<a href="index.php?data=<? print base64_encode(';../logout.php');?>"><img src="../images/door02.gif" width="15" height="15" border="0"></a>&nbsp;
<a href="index.php?data=<? print base64_encode(';../logout.php');?>">
<font face="Verdana" size="2" color="#000000"><b>Log Keluar</b></font></a>