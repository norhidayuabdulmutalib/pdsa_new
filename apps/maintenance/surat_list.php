<?php
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$sSQL="SELECT A.*, B.kampus_kod FROM ref_surat A, _ref_kampus B WHERE A.kampus_id=B.kampus_id AND A.is_delete=0 ";
if(!empty($search)){ $sSQL.=" AND surat_tajuk LIKE '%".$search."%' "; } 
if(!empty($sql_kampus)){ $sSQL .= " AND B.kampus_id=".tosql($_SESSION['SESS_KAMPUS']); }
$sSQL .= " ORDER BY surat_tajuk";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode('user;maintenance/surat_list.php;admin;surat');
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
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>
	<?php include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="3" valign="middle">
        	<font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT RUJUKAN SURAT</strong></font>
        	<!--<div style="float:right">
			<?php $new_page = "modal_form.php?win=".base64_encode($href_directory.'maintenance/surat_form.php;');?>
        	<input type="button" value="Tambah Rujukan Aras Bangunan" style="cursor:pointer" 
            onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Rujukan Aras Bangunan',700,400)" />&nbsp;&nbsp;</div>-->
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="10%" align="center"><b>Pusat Latihan</b></td>
                    <td width="50%" align="center"><b>Tajuk</b></td>
                    <td width="25%" align="center"><b>No. Rujukan</b></td>
                    <td width="10%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?php
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode($href_directory.'maintenance/surat_form.php;'.$rs->fields['surat_id']);
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="center"><?php echo stripslashes($rs->fields['kampus_kod']);?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['surat_tajuk']);?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo $rs->fields['surat_ruj_fail'];?>&nbsp;</td>
                            <td align="center">
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" 
                                title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Surat',1,1)" />
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
