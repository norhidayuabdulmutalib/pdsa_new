<?
$j=$_POST['j'];
$search=$_POST['search'];
//$conn->debug=true;
$sSQL="SELECT * FROM _sis_tblstaff WHERE staff_id<>'' AND is_deleted=0 ";
if(!empty($j)){ $sSQL.=" AND fld_jawatan='P' "; } 
if(!empty($search)){ $sSQL.=" AND fld_staff LIKE '%".$search."%' "; } else { $sSQL.=" AND flduser_name<>'admin' "; }
$sSQL .= " ORDER BY fld_staff"; 
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;

$href_search = "index.php?data=".base64_encode($userid.';apps/staff/user_list.php;admin;user');
?>
<link rel="stylesheet" href="../staff/modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="../staff/modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../staff/modalwindow/dhtmlwindow.js">

/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<script type="text/javascript" src="../staff/modalwindow/modal.js"></script>
<script type="text/javascript">
function opennewsletter(kid, staff){
	var URL = "staff/staff_menu.php";
	URL = URL + '?kid=' + kid;
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Maklumat Capaian Menu - ' + staff, 'width=750px,height=500px,center=1,resize=0,scrolling=1')
} //End "opennewsletter" function
function reset_pass(kid, staff){
	var URL = "staff/staff_reset_pwd.php";
	URL = URL + '?kid=' + kid;
	if(confirm("Adakah anda pasti untuk menjana katalaluan baru kepada pengguna ini " + staff )){
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Menjana katalaluan baru - ' + staff, 'width=750px,height=500px,center=1,resize=0,scrolling=1')
	}
} //End "opennewsletter" function
</script>
<script language="javascript" type="text/javascript">
function do_open(URL){
	document.ilim.action = URL;
	document.ilim.submit();
}
</script>
<?php include_once '../staff/include/list_head.php'; ?>
<form name="ilim" method="post">
<?php include_once '../staff/include/page_list.php'; ?>
<table width="100%" align="center" cellpadding="0" cellspacing="1" border="0">
    <tr valign="top"> 
        <td height="30" colspan="5" align="center" valign="middle" bgcolor="#80ABF2"><font size="2" face="Arial, Helvetica, sans-serif">
        &nbsp;&nbsp;&nbsp;&nbsp;<strong>SENARAI MAKLUMAT PENGGUNA SISTEM</strong></font></td>
    </tr>
    <tr>
        <td colspan="4" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="40%" align="center"><b>Nama Pengguna</b></td>
                    <td width="15%" align="center"><b>No. K/P</b></td>
                    <td width="25%" align="center"><b>Jawatan</b></td>
                    <td width="10%" align="center"><b>ID Pengguna</b></td>
                    <td width="5%" align="center"><b>Menu Pengguna</b></td>
                    <td width="5%" align="center"><b>Reset Katalaluan</b></td>
                </tr>
                <?php if($_SESSION["s_UserID"]=='admin'){ ?>
                    <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                        <td valign="top" align="right">0.</td>
                        <td valign="top" align="left"><a href="<?=$href_link;?>">Administrator</a>&nbsp;</td>
                        <td valign="top">-&nbsp;</td>
                        <td valign="top">&nbsp;</td>
                        <td valign="top">Administrator&nbsp;</td>
                        <td align="center"><img src="../staff/images/btn_file-manager_bg.gif" width="25" height="25" border="0" style="cursor:pointer" 
                        onclick="opennewsletter('admin','Administrator'); return false"  /></td>
                        <td align="center"><img src="../staff/images/key.gif" border="0" style="cursor:pointer" 
                        onclick="reset_pass('admin','Administrator'); return false"  /></td>
                    </tr>
                <?php } ?>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = 0;
                    while(!$rs->EOF  && $cnt <= $pg) {
                   // while(!$rs->EOF) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
						$href_link = "index.php?data=".base64_encode($userid.';apps/staff/user_form.php;admin;user;'.$rs->fields['staff_id']);
						
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
			             	<td valign="top" align="left"><a href="<?=$href_link;?>"><?php echo stripslashes($rs->fields['fld_staff']);?></a>&nbsp;</td>
                            <td valign="top"><?php echo $rs->fields['fld_kp'];?>&nbsp;</td>
                            <td valign="top">
                             	<?php 	if($rs->fields['is_pensyarah']=='Y'){ print 'Pensyarah, '; }
									if($rs->fields['is_gg_pensyarah']=='Y'){ print 'Pensyarah Jenputan, '; } 
									if($rs->fields['is_gtasmik']=='Y'){ print 'Pensyarah Tasmik, '; } 
									if($rs->fields['is_gg_tasmik']=='Y'){ print 'Pensyarah Tasmik Jemputan, '; } 
									if($rs->fields['is_tutor']=='Y'){ print 'Tutor, '; } 
									if($rs->fields['is_warden']=='Y'){ print 'Penyelia Asrama, '; } 
									if($rs->fields['is_hep']=='Y'){ print 'HEP,'; } 
								?>
                            &nbsp;</td>
                            <td valign="top"><?php echo $rs->fields['flduser_name'];?>&nbsp;</td>
    						<td align="center"><img src="../staff/images/btn_file-manager_bg.gif" width="25" height="25" border="0" style="cursor:pointer" 
                            onclick="opennewsletter('<?=$rs->fields['staff_id'];?>','<?php print addslashes($rs->fields['fld_staff']);?>'); return false"  /></td>
    						<td align="center"><img src="../staff/images/key.gif" border="0" style="cursor:pointer" 
                            onclick="reset_pass('<?=$rs->fields['staff_id'];?>','<?php print addslashes($rs->fields['fld_staff']);?>'); return false"  /></td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>No Record Found.</b></td></tr>
                <?php } ?>
                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5">	
<?
$sFileName=$href_search;
?>
<?php include_once '../staff/include/list_footer.php'; ?> </td></tr>
<tr><td>        
<!--<input type="hidden" name="PageNo" value="<?=$PageNo;?>">--> 
</td></td>
</table> 
</form>
