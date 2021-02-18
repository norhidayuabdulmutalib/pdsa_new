<?
//$conn->debug=true;
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$sSQL="SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 ";
if(!empty($kategori)){ $sSQL.=" AND ref_ktid =".tosql($kategori); } 
if(!empty($search)){ $sSQL.=" AND f_tempat_nama LIKE '%".$search."%' OR f_tbcode LIKE '%".$search."%' "; } 
$sSQL .= "ORDER BY f_tbcode";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode($userid.';apps/maintenance/tempat_list.php;admin;tempat');
?>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}

function do_hapus(jenis,idh){
	var URL = 'include/proses_hapus.php?jenis='+jenis+'&idh='+idh;
	if(confirm("Adakah anda pasti untuk menghapuskan data yang dipilih daripada senarai?")){
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Hapus Maklumat', 'width=200px,height=200px,center=1,resize=1,scrolling=0')
	}
}
</script>
<?php include_once '../maintenance/include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
    <?php $sqlkk = "SELECT * FROM _ref_tempat_kategori WHERE ref_kt_status=0 ORDER BY ref_ktid";
        $rskk = &$conn->Execute($sqlkk);
    ?>
    <tr>
        <td align="right"><b>KATEGORI AGENSI : </b></td> 
        <td align="left" colspan="2" >&nbsp;&nbsp;
            <select name="kategori" onchange="do_page('<?=$href_search;?>')">
                <option value="">-- Sila pilih kategori --</option>
                <?php while(!$rskk->EOF){ ?>
                <option value="<?php print $rskk->fields['ref_ktid'];?>" <?php if($kategori==$rskk->fields['ref_ktid']){ print 'selected'; }?>><?php print $rskk->fields['ref_kt_nama'];?></option>
                <?php $rskk->movenext(); } ?>
            </select>
        </td>
    </tr>
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>
	<?php include_once '../maintenance/include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT TEMPAT BERTUGAS</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        	<?php $new_page = "modal_form.php?win=".base64_encode('maintenance/tempat_form.php;');?>
        	<input type="button" value="Tambah Maklumat Tempat Bertugas" style="cursor:pointer" 
            onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Tempat Bertugas',700,400)" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="10%" align="center"><b>Kod Tempat</b></td>
                    <td width="40%" align="center"><b>Tempat Bertugas</b></td>
                    <td width="25%" align="center"><b>Kategori Agensi</b></td>
                    <td width="10%" align="center"><b>Status</b></td>
                    <td width="10%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode('maintenance/tempat_form.php;'.$rs->fields['f_tbcode']);
						$cntk = dlookup("_tbl_peserta","count(*)","BranchCd=".tosql($rs->fields['f_tbcode'],"Number"));
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="center"><?php echo stripslashes($rs->fields['f_tbcode']);?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['f_tempat_nama']);?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo stripslashes(dlookup("_ref_tempat_kategori","ref_kt_nama","ref_ktid=".tosql($rs->fields['ref_ktid'])));?>&nbsp;</td>
                            <td valign="top" align="center">
                            	<?php if($rs->fields['f_status']=='0'){ print 'Aktif'; }
									else if($rs->fields['f_status']=='1'){ print 'Tidak Aktif'; } 
									else { print '&nbsp;'; }
								?>
                            </td>
                            <td align="center">
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Tempat Bertugas',700,400)" />
                                <?php if($cntk==0){ ?>
                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data"
                                onclick="do_hapus('_ref_tempatbertugas','<?=$rs->fields['f_tbcode'];?>')" />
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
