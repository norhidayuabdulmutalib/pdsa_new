<?
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$sSQL="SELECT * FROM _tbl_penilaian_set WHERE is_deleted=0 ";
if(!empty($search)){ $sSQL.=" AND pset_tajuk LIKE '%".$search."%' "; } 
$sSQL .= "ORDER BY create_dt DESC";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode($userid.';apps/penilaian_set/set_penilaian_kursus.php;nilai;set_nilai');
?>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
</script>
<?php include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>
	<?php include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT SET PENILAIAN</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        	<?php $new_page = "index.php?data=".base64_encode($userid.';apps/penilaian_set/set_penilaian_kursus_form.php;nilai;set_nilai');?>
        	<input type="button" value="Tambah Maklumat Set Penilaian" style="cursor:pointer" 
            onclick="do_page('<?=$new_page;?>')" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="45%" align="center"><b>Tajuk Penilaian</b></td>
                    <td width="10%" align="center"><b>Tarikh Jana</b></td>
                    <td width="10%" align="center"><b>Status</b></td>
                    <td width="10%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "index.php?data=".base64_encode($userid.';apps/penilaian_set/set_penilaian_kursus_form.php;nilai;set_nilai;'.$rs->fields['pset_id']);
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['pset_tajuk']);?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo stripslashes(DisplayDate($rs->fields['create_dt']));?>&nbsp;</td>
                            <td valign="top" align="center">
                            	<?php if($rs->fields['pset_status']=='0'){ print 'Aktif'; }
									else if($rs->fields['pset_status']=='1'){ print 'Tidak Aktif'; } 
									else { print '&nbsp;'; }
								?>
                            </td>
                            <td align="center">
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="do_page('<?=$href_link;?>')" />
                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data" />
                            </td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="5" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <?php } ?>                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5">	
<?
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
