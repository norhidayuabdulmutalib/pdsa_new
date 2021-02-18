<style type="text/css">
/*Credits: CSSpplay */
/*URL: http://www.cssplay.co.uk/menus/pro_five */
.menu5 {padding:2px 0 0 0.2em; margin:0; list-style:none; height:40px; position:relative; background:transparent url(menu/image_menu/pro_five_0c.gif) repeat-x left bottom; font-size:11px;}
.menu5 li {float:left; height:40px; margin-right:1px;}
.menu5 li a {display:block; float:left; height:40px; line-height:35px; color:#333; text-decoration:none; font-family:arial, verdana, sans-serif; font-weight:bold; text-align:center; padding:0 0 0 4px; cursor:pointer; background:url(menu/image_menu/pro_five_0a.gif) no-repeat;}
.menu5 li a b {float:left; display:block; padding:0 16px 5px 12px; background:url(menu/image_menu/pro_five_0b.gif) no-repeat right top;}
.menu5 li.current a {color:#000; background:url(menu/image_menu/pro_five_2a.gif) no-repeat;}
.menu5 li.current a b {background:url(menu/image_menu/pro_five_2b.gif) no-repeat right top;}
.menu5 li a:hover {color:#000; background: url(menu/image_menu/pro_five_1a.gif) no-repeat;}
.menu5 li a:hover b {background:url(menu/image_menu/pro_five_1b.gif) no-repeat right top;}
.menu5 li.current a:hover {color:#000; background: url(menu/image_menu/pro_five_2a.gif) no-repeat; cursor:default;}
.menu5 li.current a:hover b {background:url(menu/image_menu/pro_five_2b.gif) no-repeat right top;}

</style>
<ul class="menu5">
	<div style="float:left">
    <li <? if($menu=='default'){ print 'class="current"'; }?>>
    	<a href="index.php?data=<? print base64_encode('user;/default_asrama.php;default');?>"><b>Muka Hadapan</b></a></li>
    <li <? if($menu=='masuk'){ print 'class="current"'; }?>>
    	<a href="index.php?data=<? print base64_encode('user;daftar/daftar_masuk.php;masuk;masuk');?>"><b>Daftar Masuk</b></a></li>
    <li <? if($menu=='keluar'){ print 'class="current"'; }?>>
    	<a href="index.php?data=<? print base64_encode('user;daftar/daftar_keluar.php;keluar;keluar');?>"><b>Daftar Keluar</b></a></li>
    <li <? if($menu=='penghuni'){ print 'class="current"'; }?>>
    	<a href="index.php?data=<? print base64_encode('user;asrama/penghuni_list.php;penghuni;penghuni');?>"><b>Senarai Penghuni</b></a></li>
    <li <? if($menu=='peserta'){ print 'class="current"'; }?>>
    	<a href="index.php?data=<? print base64_encode('user;asrama/dmasuk_list.php;peserta;peserta');?>"><b>Senarai Peserta Kursus</b></a></li>
    <li <? if($menu=='pass'){ print 'class="current"'; }?>>
    	<a href="index.php?data=<? print base64_encode('user;../include/user_pass.php;pass;pass');?>"><b>Tukar Katalaluan</b></a></li>
	</div>
    
    <div style="float:right">
    &nbsp;<a href="index.php?data=<? print base64_encode(';../logout.php');?>"><img src="../images/door02.gif" width="25" height="25" border="0"></a>
    <a href="index.php?data=<? print base64_encode(';../logout.php');?>">
    <font face="Verdana" size="2" color="#000000"><b>Logout</b></font></a>
</div>
</ul>
