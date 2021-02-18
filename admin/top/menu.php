<?php if(empty($idk)){ ?>
	<script language="javascript" type="text/javascript">
		window.open('main.php','_parent')
	</script>
<?php } ?>
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" media="all" type="text/css" href="top/pro_variable3.css" />
<?php if($browse['name']=='msie'){?>
<link rel="stylesheet" media="all" type="text/css" href="top/pro_variable3_ie6.css" />
<?php }?>
<div class="menu2">
<ul type="circle">
	
<?php 	$sql = "SELECT distinct C.grp_id, C.grp_name FROM tbl_menu_user A, tbl_menu B, kod_grpmenu C 
	WHERE A.menu_id=B.menu_id AND B.grp_id=C.grp_id AND B.menu_status=0 AND A.id_kakitangan=".tosql($idk,"Number")."
	ORDER BY C.grp_id";
	$rs_menu = &$conn->Execute($sql);
	//echo $sql;
	while($rowm = mysql_fetch_assoc($rs_menu)){
?>
    <li><a class="submenu" href="#nogo"><?php print $rowm['grp_name'];?>
    <!--[if IE 8]><!--></a><!--<![endif]-->
        <table><tr><td>
        <ul>
		<?php 	$sqld = "SELECT B.menu_name, B.menu_link FROM tbl_menu_user A, tbl_menu B, kod_grpmenu C 
            WHERE A.menu_id=B.menu_id AND B.grp_id=C.grp_id AND B.menu_status=0 AND B.grp_id=".tosql($rowm['grp_id'],"Number")." AND A.id_kakitangan=".$idk." ORDER BY B.sort";
            $rs_menud = &$conn->Execute($sqld);
            //echo $sql;
            while($rowmd = mysql_fetch_assoc($rs_menud)){
        ?>
            <li><a href="index.php?data=<?php print base64_encode($rowmd['menu_link']);?>"><?php print $rowmd['menu_name'];?></a></li>
		<?php } ?>
        </ul>
        </td></tr></table>
    <!--[if lte IE 6]></a><![endif]-->
    </li>
<?php } ?>
    <li><a class="submenu" href="#nogo">Rujukan
    <!--[if IE 8]><!--></a><!--<![endif]-->
        <table><tr><td>
        <ul>
            <li><a href="index.php?data=<?php print base64_encode('utiliti/doc_view_list.php');?>">Dokumen Rujukan</a></li>
        </ul>
        </td></tr></table>
    <!--[if lte IE 6]></a><![endif]-->
    </li>
	<li><a  class="menu2one" href="index.php?data=<?php print base64_encode('carian/carian.php');?>">Carian</a> </li>
    <?php //if(!empty($_SESSION['session_id_kakitangan'])){ ?>
     
    <?php //} ?>
</ul>
</div>