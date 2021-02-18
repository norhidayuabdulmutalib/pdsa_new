<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<ul id="MenuBar1" class="MenuBarHorizontal">
<?php 	$sql = "SELECT distinct C.grp_id, C.grp_name FROM tbl_menu_user A, tbl_menu B, kod_grpmenu C 
	WHERE A.menu_id=B.menu_id AND B.grp_id=C.grp_id AND B.menu_status=0 AND A.id_kakitangan=".tosql($idk,"Number")."
	ORDER BY C.grp_id";
	$rs_menu = &$conn->Execute($sql);
	//echo $sql;
	while($rowm = mysql_fetch_assoc($rs_menu)){
?>
  <li><a class="MenuBarItemSubmenu" href="#"><?php print $rowm['grp_name'];?><!--[if IE 7]><!--></a><!--<![endif]-->
      <ul>
		<?php 	$sqld = "SELECT B.menu_name, B.menu_link FROM tbl_menu_user A, tbl_menu B, kod_grpmenu C 
            WHERE A.menu_id=B.menu_id AND B.grp_id=C.grp_id AND B.menu_status=0 AND B.grp_id=".tosql($rowm['grp_id'],"Number")." 
			AND A.id_kakitangan=".tosql($idk,"Number")." ORDER BY B.sort";
            $rs_menud = &$conn->Execute($sqld);
            //echo $sql;
            while($rowmd = mysql_fetch_assoc($rs_menud)){
        ?>
        <li><a href="index.php?data=<?php print base64_encode($rowmd['menu_link']);?>"><?php print $rowmd['menu_name'];?><!--[if IE 7]><!--></a><!--<![endif]--></li>
        <?php } ?>
      </ul>
  </li>
<?php } ?>
  <li><a class="MenuBarItemSubmenu" href="#">Rujukan<!--[if IE 7]><!--></a><!--<![endif]-->
      <ul>
        <li><a href="index.php?data=<?php print base64_encode('utiliti/doc_view_list.php');?>">Dokumen Rujukan<!--[if IE 7]><!--></a><!--<![endif]--></li>
	  </ul>
  </li>
  <li><a  class="menu2one" href="index.php?data=<?php print base64_encode('carian/carian.php');?>">Carian</a> </li>
</ul>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>
