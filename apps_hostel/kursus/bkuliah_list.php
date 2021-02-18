<?php 
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$sSQL="SELECT A.*, B.f_bb_desc FROM _tbl_bilikkuliah A, _ref_blok_bangunan B WHERE A.f_bb_id=B.f_bb_id AND A.is_deleted=0 ";
if(!empty($search)){ $sSQL.=" AND f_bilik_nama LIKE '%".$search."%' "; } 
$sSQL .= "ORDER BY B.f_bb_desc, A.f_bilik_nama";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

if(!empty($href_directory)){
	$href_search = "index.php?data=".base64_encode('user;asrama/menu_asrama.php;asrama;bkuliah;;../apps/maintenance/bilik_kuliah_list.php');
} else {
	$href_search = "index.php?data=".base64_encode('user;maintenance/bilik_kuliah_list.php;admin;bkuliah');
} 
?>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}

function do_hapus(jenis,idh,dir){
	var URL = dir+'include/proses_hapus.php?jenis='+jenis+'&idh='+idh;
	if(confirm("Adakah anda pasti untuk menghapuskan data yang dipilih daripada senarai?")){
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Hapus Maklumat', 'width=200px,height=200px,center=1,resize=1,scrolling=0')
	}
}
</script>
<?php include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?php print $href_search;?>')">
		</td>
	</tr>
	<?php include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="3" valign="middle">
        	<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<strong>SENARAI MAKLUMAT BILIK KULIAH</strong></font>
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="35%" align="center"><b>Maklumat Bilik Kuliah</b></td>
                    <td width="20%" align="center"><b>Blok</b></td>
                    <td width="15%" align="center"><b>Aras</b></td>
                    <td width="15%" align="center"><b>Status</b></td>
                    <td width="10%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?php 
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode('kursus/bkuliah_pengunaan.php;'.$rs->fields['f_bilikid']);
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?php print $bil;?>.</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['f_bilik_nama']);?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo $rs->fields['f_bb_desc'];?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo dlookup("_ref_aras_bangunan","f_ab_desc","f_ab_id=".tosql($rs->fields['f_ab_id'],"Number"));?>&nbsp;</td>
                            <td valign="top" align="center">
                            	<?php if($rs->fields['f_status']=='0'){ print 'Boleh Digunakan'; }
									else if($rs->fields['f_status']=='1'){ print 'Dalam penyelengaraan'; } 
									else { print '&nbsp;'; }
								?>
                            </td>
                            <td align="center">
                            	<img src="../images/btn_calendar.gif" width="28" height="20" style="cursor:pointer" title="Sila klik untuk paparan penggunaan bilik kuliah" 
                                onclick="open_modal('<?php print $href_link;?>','Paparan Penggunaan Bilik Kuliah',1,1)" />
                            </td>
                        </tr>
                        <?php 
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <?php } ?>                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5">	
<?php 
if($cnt<>0){
	$sFileName=$href_search;
	include_once 'include/list_footer.php'; 
}
?> 
</td></tr>
<tr><td>        
</td></td>
</table> 
</form>
