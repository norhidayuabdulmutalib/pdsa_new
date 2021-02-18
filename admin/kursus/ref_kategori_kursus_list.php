<?
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$sSQL="SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ";
if(!empty($search)){ $sSQL.=" AND categorytype LIKE '%".$search."%' "; } 
$sSQL .= "ORDER BY id";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode($userid.';apps/kursus/ref_kategori_kursus_list.php;kursus;c');
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
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT KATEGORI KURSUS</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        	<?php $new_page = "modal_form.php?win=".base64_encode('kursus/ref_kategori_kursus_form.php;');?>
        	<input type="button" value="Tambah Maklumat Kategori Kursus" style="cursor:pointer" 
            onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Kategori Kursus',700,400)" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="10%" align="center"><b>Kod Kategori Kursus</b></td>
                    <td width="60%" align="center"><b>Diskripsi Kategori Kursus</b></td>
                    <td width="15%" align="center"><b>Status</b></td>
                    <td width="10%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode('kursus/ref_kategori_kursus_form.php;'.$rs->fields['id']);
						$cntk = dlookup("_tbl_kursus","count(*)","category_code=".tosql($rs->fields['id'],"Number"));
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['category_code']);?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['categorytype']);?>&nbsp;</td>
                            <td valign="top" align="center">
                            	<?php if($rs->fields['status']=='0'){ print 'Aktif'; }
									else if($rs->fields['status']=='1'){ print 'Tidak Aktif'; } 
									else { print '&nbsp;'; }
								?>
                            </td>
                            <td align="center">
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Kategori Kursus',700,400)" />
                                <?php if($cntk==0){ ?>
                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data"
                                onclick="do_hapus('ref_kategori_kursus','<?=$rs->fields['id'];?>')" />
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
	include_once 'include/list_footer.php'; 
}
?> 
</td></tr>
<tr><td>        
</td></td>
</table> 
</form>
