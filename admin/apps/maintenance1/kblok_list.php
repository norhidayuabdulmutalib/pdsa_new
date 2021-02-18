<?
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$sSQL="SELECT * FROM _ref_kategori_blok WHERE is_deleted=0 ";
if(!empty($search)){ $sSQL.=" AND f_kb_desc LIKE '%".$search."%' "; } 
$sSQL .= "ORDER BY f_kb_desc";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

if(!empty($href_directory)){
	$href_search = "index.php?data=".base64_encode($userid.';apps/asrama/menu_asrama.php;asrama;kblok;;../apps/maintenance/kblok_list.php');
} else {
	$href_search = "index.php?data=".base64_encode($userid.';apps/maintenance/kblok_list.php;admin;kblok');
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
<?php include_once '../maintenance/include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>
	<?php include_once '../maintenance/include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="3" valign="middle">
        	<font size="2" face="Arial, Helvetica, sans-serif"><strong>SENARAI MAKLUMAT RUJUKAN KATEGORI BLOK BANGUNAN</strong></font>
        	<div style="float:right">
			<?php $new_page = "modal_form.php?win=".base64_encode($href_directory.'maintenance/kblok_form.php;');?>
        	<input type="button" value="Tambah Rujukan Kategori Blok Bangunan" style="cursor:pointer" 
            onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Rujukan Kategori Blok Bangunan',700,400)" />&nbsp;&nbsp;</div>
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="75%" align="center"><b>Maklumat Kategori Blok Bangunan</b></td>
                    <td width="10%" align="center"><b>Status</b></td>
                    <td width="10%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode($href_directory.'maintenance/kblok_form.php;'.$rs->fields['f_kb_id']);
						$cntk = dlookup("_ref_blok_bangunan","count(*)","f_kb_id=".tosql($rs->fields['f_kb_id'],"Number"));
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['f_kb_desc']);?>&nbsp;<?//=$cntk;?></td>
                            <td valign="top" align="center">
                            	<?php if($rs->fields['f_kb_status']=='0'){ print 'Aktif'; }
									else if($rs->fields['f_kb_status']=='1'){ print 'Tidak Aktif'; } 
									else { print '&nbsp;'; }
								?>
                            </td>
                            <td align="center">
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Rujukan Kategori Blok',700,400)" />
                                <?php if($cntk==0){ ?>
                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data"
                                onclick="do_hapus('_ref_kategori_blok','<?=$rs->fields['f_kb_id'];?>','<?=$href_directory;?>')" />
                                <?php } ?>
                            </td>
                        </tr>
                        <?
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
<?
if($cnt<>0){
	$sFileName=$href_search;
	include_once '../maintenance/include/list_footer.php'; 
}
?> 
</td></tr>
<tr><td>        
</td></td>
</table> 
</form>
