<?php
//$conn->debug=true;
$blok_id=isset($_REQUEST["blok_id"])?$_REQUEST["blok_id"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$sSQL="SELECT A.*, B.f_bb_desc, C.f_ab_desc FROM _tbl_bilikkuliah A, _ref_blok_bangunan B, _ref_aras_bangunan C 
WHERE A.f_bb_id=B.f_bb_id AND A.f_ab_id=C.f_ab_id AND A.is_deleted=0 ";
$sSQL .= $sql_filter;
if(!empty($blok_id)){ $sSQL .= " AND B.f_bb_id=".tosql($blok_id); }
if($_SESSION['SESS_KAMPUS']<>'99'){ $sSQL .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($search)){ $sSQL.=" AND (A.f_bilik_nama LIKE '%".$search."%' OR B.f_bb_desc LIKE '%".$search."%' OR C.f_ab_desc LIKE '%".$search."%' )"; } 
$sSQL .= " ORDER BY B.f_bb_desc, C.f_ab_desc, A.f_bilik_nama";
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
	<?php $sqlb = "SELECT A.*, B.kampus_kod FROM _ref_blok_bangunan A, _ref_kampus B 
        WHERE A.kampus_id=B.kampus_id AND A.is_deleted=0 AND A.f_bb_status=0";
    if(!empty($sql_kampus)){ $sqlb .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
    $sqlb .= $sql_filter;
    $sqlb .= " ORDER BY B.kampus_id";
    $rs_kb = &$conn->Execute($sqlb);
    ?>
    <tr>
        <td width="30%" align="right"><b>Blok Bangunan : </b></td>
        <td width="60%" align="left">&nbsp;&nbsp;
            <select name="blok_id" style="width:80%" onchange="do_page('<?=$href_search;?>')" style="cursor:pointer">
            	<option value="">-- semua blok bangunan --</option>
            <?php while(!$rs_kb->EOF){ ?>
                <option value="<?php print $rs_kb->fields['f_bb_id'];?>" <?php if($rs_kb->fields['f_bb_id']==$blok_id){ print 'selected="selected"';}?>><?php print $rs_kb->fields['kampus_kod']." - ".$rs_kb->fields['f_bb_desc'];?></option>
            <?php $rs_kb->movenext(); } ?>
            </select>
        </td>
    </tr>
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
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT BILIK KULIAH</strong></font>
        	<div style="float:right">
			<? $new_page = "modal_form.php?win=".base64_encode($href_directory.'maintenance/bilik_kuliah_form.php;');?>
        	<input type="button" value="Tambah Maklumat Bilik Kuliah" style="cursor:pointer" 
            onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Bilik Kuliah',700,400)" />&nbsp;&nbsp;</div>
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
                		$href_link = "modal_form.php?win=".base64_encode($href_directory.'maintenance/bilik_kuliah_form.php;'.$rs->fields['f_bilikid']);
						$cntk = dlookup("_tbl_kursus_jadual","count(*)","bilik_kuliah=".tosql($rs->fields['f_bilikid'],"Number"));
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['f_bilik_nama']);?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo $rs->fields['f_bb_desc'];?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo $rs->fields['f_ab_desc'];?>&nbsp;</td>
                            <td valign="top" align="center">
                            	<?php if($rs->fields['f_status']=='0'){ print 'Boleh Digunakan'; }
									else if($rs->fields['f_status']=='1'){ print 'Dalam penyelengaraan'; } 
									else { print '&nbsp;'; }
								?>
                            </td>
                            <td align="center">
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Bilik Kuliah',700,400)" />
                                <?php if($cntk==0){ ?>
                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data"
                                onclick="do_hapus('_tbl_bilikkuliah','<?=$rs->fields['f_bilikid'];?>','<?=$href_directory;?>')" />
                                <?php } ?>
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
