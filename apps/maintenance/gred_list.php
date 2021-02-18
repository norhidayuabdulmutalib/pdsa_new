<?
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$sSQL="SELECT * FROM _ref_titlegred WHERE is_deleted=0 ";
if(!empty($search)){ $sSQL.=" AND (f_gred_name LIKE '%".$search."%' OR f_gred_code LIKE '%".$search."%') "; } 
$sSQL .= "ORDER BY f_gred_code";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode('user;maintenance/gred_list.php;admin;gred');
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
<? include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>
	<? include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT GRED JAWATAN</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        	<? $new_page = "modal_form.php?win=".base64_encode('maintenance/gred_form.php;');?>
        	<input type="button" value="Tambah Maklumat Gred Jawatan" style="cursor:pointer" 
            onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Gred Jawatan',700,400)" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <!--<td width="10%" align="center"><b>Kod Gred</b></td>-->
                    <td width="15%" align="center"><b>Gred Jawatan</b></td>
                    <td width="45%" align="center"><b>Diskripsi Gred Jawatan</b></td>
                    <td width="15%" align="center"><b>Kumpulan Jawatan</b></td>
                    <td width="10%" align="center"><b>Status</b></td>
                    <td width="10%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode('maintenance/gred_form.php;'.$rs->fields['f_gred_id']);
						$cntk = dlookup("_tbl_peserta","count(*)","f_title_grade=".tosql($rs->fields['f_gred_id'],"Number"));
						$pos = $rs->fields['f_jawatan'];
                        ?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['f_gred_code']);?>&nbsp;</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['f_gred_name']);?>&nbsp;</td>
            				<!--<td valign="top" align="left"><? //echo stripslashes($rs->fields['f_gred_desc']);?>&nbsp;</td>-->
                            <td valign="top" align="center">
                            	<? if($pos=='1'){ print 'Sokongan'; } 
									else if($pos=='2'){ print 'P&P'; } 
									else if($pos=='3'){ print 'Jusa'; } 
									else { print '&nbsp;'; }
								?>
                            </td>
                            <td valign="top" align="center">
                            	<? if($rs->fields['f_status']=='0'){ print 'Aktif'; }
									else if($rs->fields['f_status']=='1'){ print 'Tidak Aktif'; } 
									else { print '&nbsp;'; }
								?>
                            </td>
                            <td align="center">
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Gred Jawatan',700,400)" />
                                <?php if($cntk==0){ ?>
                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data"
                                onclick="do_hapus('_ref_titlegred','<?=$rs->fields['f_gred_id'];?>')" />
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
                <? } ?>                   
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
