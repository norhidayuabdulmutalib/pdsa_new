<?php include 'header.php';?> 
<?
$data = base64_decode($_GET['data']);
$get_data = explode(";", $data);
$pro = $get_data[0]; // piece1
$page = $get_data[1]; // piece1
$get_page = $get_data[1]; // piece1
$menu = $get_data[2]; // piece2
$submenu = $get_data[3]; // piece2
$id = $get_data[4]; // piece2
$sub_tab = $get_data[5]; // piece2
//print $_SESSION["s_userid"];
if($_SESSION["s_userid"]=='1'){
	echo "<font color=#000000>PROSES:".$pro.";PG:".$page.";MENU:".$menu.";SUBMENU:".$submenu.";ID:".$id.";SUBTAB:".$sub_tab."</font>";
}
/*if(!empty($pro) && empty($_SESSION["s_userid"])){
	$url = 'index.php';
	print "<meta http-equiv=\"refresh\" content=\"1; URL=".$url."\">"; 
	exit;
}*/
?>
<!--- CONTENT ---> 
<tr>
    <td background="../img/b_left.gif">&nbsp;</td>
    <td valign="top">
        <table width="100%" height="400px" cellpadding="2" cellspacing="0" border="0">
           	<tr><td colspan="2" valign="top"> <? include 'menu/pro_five.php'; ?></td></tr>
            <tr>
                <td align="center" width="100%" valign="top" height="100%">
                <? 
				//print $page;
				if(!empty($page)){ 
                    include $page; //"utiliti/bahagian.php";
                } else { 
                    include 'default_asrama.php';
                } ?>
                <br />
                <?php if($page!='paparan_asrama.php'){ ?>
                <a href="index.php?data=<? print base64_encode('user;paparan_asrama.php;default');?>">Paparan Asrama</a>
                <br /><br />
                <?php } else { ?>
                <a href="index.php?data=<? print base64_encode('user;../apps/default.php;default');?>">Paparan Utama</a>
                <br /><br />
				<?php } ?>
                </td>
           </tr>
        </table>
    </td>
    <td background="../img/b_right.gif">&nbsp;</td>
</tr>
<!--- CONTENT ---> 
<?php include 'footer.php'; ?>