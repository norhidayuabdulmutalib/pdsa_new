<link rel="stylesheet" href="menu/menu.css" type="text/css">
<?
//$conn->debug=true;
$_SESSION['sub_menu'] = $submenu;
//echo "SD: ".$_SESSION['sub_menu'];
?>
<?php if($_SESSION['menu']=='default'){ ?>
    <ul class="menu6">
        <li class="curr"><a href="#"><b>MENU UTAMA SISTEM</b></a></li>
    </ul>
    <?
    $sql_menu = "SELECT DISTINCT C.grp_name, B.menu_link FROM _tbl_menu_user A, _tbl_menu B, ref_grpmenu C
    WHERE C.status=0 AND B.menu_status=0 AND A.menu_id=B.menu_id AND B.grp_id=C.grp_id AND A.id_kakitangan=".tosql($_SESSION["s_userid"],"Text").
    " GROUP BY C.grp_name ORDER BY C.sort, B.sort";
    $rs_menu = &$conn->Execute($sql_menu);
    //echo $sql_menu;
	$cnt = $rs_menu->recordcount();
    ?>
    <div id="menu12">
        <ul>
    <?php if(!$rs_menu->EOF){
			while(!$rs_menu->EOF){ ?>
			<li <?php if($_SESSION['menu']=='mohon'){ print 'class="current"'; }?>>
				<a href="index.php?data=<?php print base64_encode($rs_menu->fields['menu_link']);?>"><b><?php print $rs_menu->fields['grp_name'];?></b></a></li>
		<?php 		$rs_menu->movenext();
			}
	   } else {
	   		print '<font color="#FFFFFF">Tiada Maklumat Menu</font><br><br>'; 
	   }
    ?>
    	<li <?php if($_SESSION['menu']=='mohon'){ print 'class="current"'; }?>>
            <a href="index.php?data=<?php print base64_encode($userid.';apps/../include/user_pass.php');?>"><b>Tukar Katalaluan</b></a></li>
        </ul>	
    </div>
<?php } else { ?>
    <?
    $sql_menu = "SELECT DISTINCT B.menu_name, B.menu_link, B.sub_menu, C.grp_name FROM _tbl_menu_user A, _tbl_menu B, ref_grpmenu C
    WHERE A.menu_id=B.menu_id AND B.grp_id=C.grp_id AND A.id_kakitangan=".tosql($_SESSION["s_userid"],"Text"). " 
	AND C.grp_kod=".tosql($_SESSION["menu"],"Text")." AND B.menu_status=0 ORDER BY B.sort, B.menu_id";
    $rs_menu = &$conn->Execute($sql_menu);
    //echo $sql_menu;
    if(!$rs_menu->EOF){
    ?>
    <ul class="menu6">
        <li class="curr"><a href="#"><b><?=$rs_menu->fields['grp_name'];?></b></a></li>
    </ul>
    <div id="menu12">
        <ul>
		<?php while(!$rs_menu->EOF){ ?>
                <li <?php if($_SESSION['sub_menu']==$rs_menu->fields['sub_menu']){ print 'class="current"'; }?>><?//=$_SESSION['sub_menu'];?>
                    <a href="index.php?data=<?php print base64_encode($rs_menu->fields['menu_link']);?>&dq_cari=M"><b><?php print $rs_menu->fields['menu_name'];?></b></a></li>
        <?php 		$rs_menu->movenext();
            }
        ?>
        </ul>
    </div>
    <?php } ?>
<?php } 
$conn->debug=false;
?>
<br />
&nbsp;<a href="index.php?data=<?php print base64_encode(';../logout.php');?>"><img src="../images/door02.gif" width="15" height="15" border="0"></a>&nbsp;
<a href="index.php?data=<?php print base64_encode(';../logout.php');?>">
<font face="Verdana" size="2" color="#000000"><b>Log Keluar</b></font></a>
<br /><br />
<!--Senarai Pengguna Aktif :<br />-->
<?php
?>