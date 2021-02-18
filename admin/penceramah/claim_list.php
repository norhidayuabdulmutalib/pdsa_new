<?
$j=$_POST['j'];
$search=$_POST['search'];
?>
<link rel="stylesheet" href="modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="modalwindow/dhtmlwindow.js">
/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<script type="text/javascript" src="modalwindow/modal.js"></script>
<script type="text/javascript">
function opennewsletter(kid, staff){
	var URL = "staff/staff_menu.php";
	//var id = document.ilim.mohon_id.value;
	//var tid = document.ilim.tid.value;
	URL = URL + '?kid=' + kid;
	//alert(URL);
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Maklumat Capaian Menu - ' + staff, 'width=750px,height=500px,center=1,resize=0,scrolling=1')
} //End "opennewsletter" function
</script>
<script language="javascript" type="text/javascript">
function do_open(URL){
	document.ilim.action = URL;
	document.ilim.submit();
}
</script>
<?php
//$conn->debug=true;
$sql = "SELECT * FROM _tbl_instructor WHERE ingenid=".tosql($id);
$rs = $conn->execute($sql);
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="1" border="0">
	<tr>
		<td width="30%" align="right"><b>Nama Penceramah : </b>&nbsp;</td> 
		<td width="60%" align="left"><?php print $rs->fields['insname'];?></td>
	</tr>
	<tr>
		<td align="right"><b>Kategori Penceramah : </b>&nbsp;</td> 
		<td align="left"><?php print dlookup("_ref_kategori_penceramah","f_kp_kenyataan","f_kp_id=".$rs->fields['inskategori']);?></td>
	</tr>
	<tr>
		<td align="right"><b>Jabatan/Unit/Pusat : </b>&nbsp;</td> 
		<td align="left"><?php print $rs->fields['insorganization'];?></td>
	</tr>
	<tr>
		<td align="right"><b>No. HP : </b>&nbsp;</td> 
		<td align="left"><?php print $rs->fields['insmobiletel'];?></td>
	</tr>
<?php
//$conn->debug=true;
$sSQL="SELECT * FROM _tbl_claim WHERE is_deleted <> 1 and cl_ins_id = ".tosql($rs->fields['ingenid'],"Text");
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;
$href_search = "index.php?data=".base64_encode($userid.';apps/penceramah/penceramah_list.php;penceramah;daftar');
?>
<?php include_once 'include/list_head.php'; ?>
<?php include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI TUNTUTAN</strong></font>        </td>
			<td colspan="2" valign="middle" align="right">
        	<?php $new_page = "index.php?data=".base64_encode($userid.';apps/penceramah/claim_form.php;penceramah;tuntutan;');?>
        	<input type="button" value="Tambah Maklumat Tuntutan" style="cursor:pointer" onclick="do_page('<?=$new_page;?>&ingid=<?=$id;?>')" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="4" align="center">
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="30%" align="center"><b>Bulan</b></td>
                    <td width="15%" align="center"><b>Tahun</b></td>
                    <td width="5%" align="center">&nbsp;</td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
                    //while(!$rs->EOF) {
						//$bil = $cnt + ($PageNo-1)*$PageSize;
						$href_link = "index.php?data=".base64_encode($userid.';apps/penceramah/claim_form.php;penceramah;tuntutan;'.$rs->fields['cl_id']);
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
			             	<td valign="top" align="left"><?=dlookup("ref_month", "desc_mal", " id_month = ".$rs->fields['cl_month'])?>&nbsp;</td>
                            <td valign="top" align="center"><?php echo $rs->fields['cl_year'];?>&nbsp;</td>
                            <td align="center">
                            	<a href="<?=$href_link;?>&ingid=<?=$id;?>"><img src="../img/icon-info1.gif" width="20" height="20" style="cursor:pointer" 
                                title="Sila klik untuk pengemaskinian data" border="0"/></a>
                            </td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
					$rs->Close();
                } else {
                ?>
                <tr><td colspan="4" width="100%" bgcolor="#FFFFFF"><b>No Record Found.</b></td></tr>
                <?php } ?>
            </table> 
        </td>
    </tr>
    <tr><td colspan="5">	
<?
$sFileName=$href_search;
?>
<?php include_once 'include/list_footer.php'; ?> </td></tr>
<tr><td>        
</td></td>
</table> 
</form>