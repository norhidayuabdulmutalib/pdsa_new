<?php include 'header_old.php'; ?> 
<!--- CONTENT ---> 
<tr>
    <td background="../img/b_left.gif">&nbsp;</td>
    <td valign="top">
        <table width="100%" height="400px" cellpadding="2" cellspacing="0" border="1">
			<?php if($_SESSION["s_usertype"]=='SYSTEM'){  ?>
           	<tr><td colspan="2" valign="top" width="100%"> 
                <div style="float:left;width:100%">
                <?php include 'menu/pro_five.php'; ?>
				</div>
                <!--<div style="float:right">
                &nbsp;<a href="index.php?data=<?// print base64_encode(';../logout.php');?>"><img src="../images/door02.gif" width="25" height="25" border="0"></a>
                <a href="index.php?data=<? //print base64_encode(';../logout.php');?>">
                <font face="Verdana" size="2" color="#000000"><b>Logout</b></font></a>
                </div>-->
			</td></tr>
			<?php } ?>
            <tr>
                <td valign="top" width="20%">
                    <?php 
						if($_SESSION["s_usertype"]=='PESERTA'){ 
							include 'menu/left_peserta.php';
						} else if($_SESSION["s_usertype"]=='PENSYARAH'){ 
							include 'menu/left_pensyarah.php';
						} else { 
							include 'menu/left_menu.php';
						}
					?>
                </td>
                <td align="center" bgcolor="#FFFFFF" width="80%" valign="top" height="100%"><br />
                <? 
				if(!empty($page)){ 
                    include $page; //"utiliti/bahagian.php";
                } else { 
                    include 'home.php';
                } ?>
                </td>
           </tr>
        </table>
    </td>
    <td background="../img/b_right.gif">&nbsp;</td>
</tr>
<!--- CONTENT ---> 
<?php include 'footer_old.php'; ?>