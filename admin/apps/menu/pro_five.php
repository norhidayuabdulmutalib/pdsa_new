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
<?
if(!empty($menu)){
	$_SESSION['menu']=$menu;
}
$sql_menu = "SELECT DISTINCT C.grp_name, C.grp_kod, B.menu_link 
FROM _tbl_menu_user A, _tbl_menu B, ref_grpmenu C 
WHERE C.status=0 AND B.menu_status=0 AND A.menu_id=B.menu_id AND B.grp_id=C.grp_id AND A.id_kakitangan=".tosql($_SESSION["s_userid"],"Text"). " 
GROUP BY C.grp_name ORDER BY C.sort, B.sort DESC";
$rs_menu = &$conn->Execute($sql_menu);
//echo $sql_menu;
if(!$rs_menu->EOF){
?>
<ul class="menu5">
	<div style="float:left">
    <li <?php if($_SESSION['menu']=='default'){ print 'class="current"'; }?>>
    	<a href="index.php?data=<?php print base64_encode($userid.';apps/default.php;default');?>"><b>Muka Hadapan</b></a></li>
<?php while(!$rs_menu->EOF){ ?>
    <li <?php if($_SESSION['menu']==$rs_menu->fields['grp_kod']){ print 'class="current"'; }?>>
    	<a href="index.php?data=<?php print base64_encode($rs_menu->fields['menu_link']);?>"><b><?php print $rs_menu->fields['grp_name'];?><?//=$rs_menu->fields['grp_kod'];?></b></a></li>
<?php 		$rs_menu->movenext();
	}
?>
	</div>
    
    <div style="float:right">
    &nbsp;<a href="index.php?data=<?php print base64_encode(';../logout.php');?>"><img src="../images/door02.gif" width="25" height="25" border="0"></a>
    <a href="index.php?data=<?php print base64_encode(';../logout.php');?>">
    <font face="Verdana" size="2" color="#000000"><b>Logout</b></font></a>
	</div>
</ul>
<?php } ?>
