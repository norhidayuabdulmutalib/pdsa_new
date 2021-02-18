<?
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
/*$sSQL="SELECT A.*, B.f_penilaian FROM _ref_penilaian_maklumat A, _ref_penilaian_kategori B WHERE A.f_penilaianid=B.f_penilaianid AND A.is_deleted=0 ";
if(!empty($kategori)){ $sSQL.=" AND A.f_penilaianid =".tosql($kategori,"Number"); } 
if(!empty($search)){ $sSQL.=" AND A.f_penilaian_desc LIKE '%".$search."%' "; } 
$sSQL .= " ORDER BY A.f_penilaianid, A.f_penilaian_desc";*/

$sSQL="SELECT * FROM _ref_penilaian_maklumat WHERE is_deleted=0 ";
if(!empty($kategori)){ $sSQL.=" AND f_penilaianid =".tosql($kategori,"Text"); } 
if(!empty($search)){ $sSQL.=" AND f_penilaian_desc LIKE '%".$search."%' "; } 
$sSQL .= " ORDER BY f_penilaianid, f_penilaian_desc";

$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode($userid.';apps/penilaian/penilaian_list.php;nilai;penilaian');
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
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Hapus Maklumat Penilaian', 'width=200px,height=200px,center=1,resize=1,scrolling=0')
	}
}
</script>
<?php include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
	<?php $sqlb = "SELECT * FROM _ref_penilaian_kategori WHERE is_deleted=0";
    $rs_kb = &$conn->Execute($sqlb);
    ?>
    <tr>
        <td width="30%" align="right"><b>Kategori Penilaian : </b></td>
        <td width="60%">&nbsp;
            <select name="kategori">
            	<option value="">-- Sila pilih --</option>
            <?php while(!$rs_kb->EOF){ ?>
                <option value="<?php print $rs_kb->fields['f_penilaianid'];?>" <?php if($rs_kb->fields['f_penilaianid']==$kategori){ print 'selected="selected"';}?>><?php print $rs_kb->fields['f_penilaian'];?></option>
            <?php $rs_kb->movenext(); } ?>
                <option value="A" <?php if($rs->fields['f_penilaianid']=='A'){ print 'selected'; }?>>Keseluruhan Kursus</option>
                <option value="B" <?php if($rs->fields['f_penilaianid']=='B'){ print 'selected'; }?>>Cadangan Penambahbaikan</option>
            </select>
        </td>
    </tr>
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;
			<input type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>
	<?php include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT RUJUKAN PENILAIAN</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        	<?php $new_page = "modal_form.php?win=".base64_encode('penilaian/penilaian_form.php;');?>
        	<input type="button" value="Tambah Maklumat Rujukan Penilaian" style="cursor:pointer" 
            onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Rujukan Penilaian',80,80)" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="45%" align="center"><b>Maklumat Penilaian</b></td>
                    <td width="20%" align="center"><b>Kategori Penilaian</b></td>
                    <td width="15%" align="center"><b>Set Penilaian</b></td>
                    <td width="6%" align="center"><b>Status</b></td>
                    <td width="14%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode('penilaian/penilaian_form.php;'.$rs->fields['f_penilaian_detailid']);
						$kat_penilaian = dlookup("_ref_penilaian_kategori","f_penilaian","f_penilaianid=".tosql($rs->fields['f_penilaianid']));
						$cntk = dlookup("_tbl_nilai_bahagian_detail","count(*)","f_penilaian_detailid=".tosql($rs->fields['f_penilaianid'],"Number"));

						if($rs->fields['f_penilaianid']=='A'){ $kat_penilaian='Keseluruhan Kursus'; }
						else if($rs->fields['f_penilaianid']=='B'){ $kat_penilaian='Cadangan Penambahbaikan'; }
						
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['f_penilaian_desc']);?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo $kat_penilaian;?>&nbsp;</td>
                            <td valign="top" align="center">
                            	<?php if($rs->fields['f_penilaian_jawab']=='1'){ print 'Set 5 Pilihan'; }
									else if($rs->fields['f_penilaian_jawab']=='2'){ print 'Set Ya / Tidak'; } 
									else if($rs->fields['f_penilaian_jawab']=='3'){ print 'Set Jawapan Bertulis '; } 
									else { print '&nbsp;'; }
								?>
                            </td>
                            <td valign="top" align="center">
                            	<?php if($rs->fields['f_penilaian_status']=='0'){ print 'Aktif'; }
									else if($rs->fields['f_penilaian_status']=='1'){ print 'Tidak Aktif'; } 
									else { print '&nbsp;'; }
								?>
                            </td>
                            <td align="center">
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Rujukan Penilaian',80,80)" />
                                <?php if($cntk==0){ ?>
                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data"
                                onclick="do_hapus('_ref_penilaian_maklumat','<?=$rs->fields['f_penilaian_detailid'];?>')" />
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
