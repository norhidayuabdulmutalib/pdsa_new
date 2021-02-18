<?
require_once '../include/dbconnect.php';
?>
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<ul id="MenuBar1" class="MenuBarHorizontal">
    <li><a href="index.php?data=<?php print base64_encode('home.php');?>">Halaman Utama</a> </li>
<?php 	$sql = "SELECT distinct C.grp_id, C.grp_name FROM tbl_menu_user A, tbl_menu B, kod_grpmenu C 
	WHERE A.menu_id=B.menu_id AND B.grp_id=C.grp_id AND B.menu_status=0 AND A.id_kakitangan=7
	ORDER BY C.grp_id";
	$rs_menu = &$conn->Execute($sql);
	//echo $sql;
	while($rowm = mysql_fetch_assoc($rs_menu)){
?>
  <li><a href="#"><?php print $rowm['grp_name'];?></a>
      <ul>
		<?php 	$sqld = "SELECT B.menu_name, B.menu_link FROM tbl_menu_user A, tbl_menu B, kod_grpmenu C 
            WHERE A.menu_id=B.menu_id AND B.grp_id=C.grp_id AND B.menu_status=0 AND B.grp_id=".$rowm['grp_id']." AND A.id_kakitangan=7 ORDER BY B.sort";
            $rs_menud = &$conn->Execute($sqld);
            //echo $sql;
            while($rowmd = mysql_fetch_assoc($rs_menud)){
        ?>
            <li><a href="index.php?data=<?php print base64_encode($rowmd['menu_link']);?>"><?php print $rowmd['menu_name'];?></a></li>
		<?php } ?>
      </ul>
  </li>
<?php } ?>

  <?php if(!empty($_SESSION['session_status']) && $_SESSION['session_status']=='A'){ ?>
  <li><a class="MenuBarItemSubmenu" href="#">Utiliti</a>
      <ul>
        <li><a href="../utiliti/kakitangan1.php">Senarai Kakitangan</a></li>
        <li><a href="../utiliti/agensi.php">Senarai Agensi</a></li>
        <li><a href="../utiliti/bahagian.php">Senarai Bahagian</a></li>
        <li><a href="../utiliti/harga.php">Senarai Harga</a></li>
      </ul>
  </li>
  <?php } ?>
  <?php if(!empty($_SESSION['session_id_kakitangan'])){ ?>
  <li><a href="../login.php?log=LOGOUT">Keluar</a></li>
  <?php } ?>
</ul>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
