<link href="css/menu.css" rel="stylesheet" type="text/css" />
<div class="menu2">
<ul type="circle">
	<li><a  class="menu2one" href="index.php?data=<?php print base64_encode('home.php');?>">Halaman Utama</a> </li>
<?php 	$sql = "SELECT distinct C.grp_id, C.grp_name FROM tbl_menu_user A, tbl_menu B, kod_grpmenu C 
	WHERE A.menu_id=B.menu_id AND B.grp_id=C.grp_id AND B.menu_status=0 AND A.id_kakitangan=".$idk."
	ORDER BY C.grp_id";
	$rs_menu = &$conn->Execute($sql);
	//echo $sql;
	while($rowm = mysql_fetch_assoc($rs_menu)){
?>
    <li><a class="submenu" href="#nogo"><?php print $rowm['grp_name'];?>
    <!--[if IE 7]><!--></a><!--<![endif]-->
        <table><tbody><tr><td>
        <ul>
		<?php 	$sqld = "SELECT B.menu_name, B.menu_link FROM tbl_menu_user A, tbl_menu B, kod_grpmenu C 
            WHERE A.menu_id=B.menu_id AND B.grp_id=C.grp_id AND B.menu_status=0 AND B.grp_id=".$rowm['grp_id']." AND A.id_kakitangan=".$idk." ORDER BY B.sort";
            $rs_menud = &$conn->Execute($sqld);
            //echo $sql;
            while($rowmd = mysql_fetch_assoc($rs_menud)){
        ?>
            <li><a href="index.php?data=<?php print base64_encode($rowmd['menu_link']);?>"><?php print $rowmd['menu_name'];?></a></li>
		<?php } ?>
        </ul>
        </td></tr></tbody></table>
    <!--[if lte IE 6]></a><![endif]-->
    </li>
<?php } ?>
    <li><a class="submenu" href="#nogo">Carian 
    <!--[if IE 7]><!--></a><!--<![endif]-->
        <table><tbody><tr><td>
        <ul>
            <li><a href="index.php?data=<?php print base64_encode('carian/carian_semua.php');?>">Carian Semua Soalan</a></li>
            <li><a href="index.php?data=<?php print base64_encode('carian/carian_bahagian.php');?>">Carian Mengikut Bahagian</a></li>
            <li><a href="index.php?data=<?php print base64_encode('carian/carian_kategori.php');?>">Carian Mengikut Kategori</a></li>
        </ul>
        </td></tr></tbody></table>
    <!--[if lte IE 6]></a><![endif]-->
    </li>
    <li><a class="submenu" href="#nogo">Rujukan
    <!--[if IE 7]><!--></a><!--<![endif]-->
        <table><tbody><tr><td>
        <ul>
            <li><a href="index.php?data=<?php print base64_encode('utiliti/doc_view_list.php');?>">Dokumen Rujukan</a></li>
        </ul>
        </td></tr></tbody></table>
    <!--[if lte IE 6]></a><![endif]-->
    </li>
    <?php //if(!empty($_SESSION['session_id_kakitangan'])){ ?>
      <li><a href="logout.php">Keluar</a></li>
    <?php //} ?>
</ul>
</div>
