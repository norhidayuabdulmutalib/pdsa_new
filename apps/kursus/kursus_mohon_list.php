<?
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$subkategori=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
//$sSQL="SELECT * FROM _tbl_kursus WHERE is_deleted=0 ";
$sSQL="SELECT A.*, B.startdate, B.enddate, C.coursename, C.courseid, C.SubCategoryCd, C.category_code, C.subcategory_code, B.id 
FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B, _tbl_kursus C 
WHERE A.EventId=B.id AND B.courseid=C.id AND C.id=B.courseid AND A.approve_ilim=0 ";
if(!empty($search)){ $sSQL.=" AND (C.coursename LIKE '%".$search."%' OR C.courseid  LIKE '%".$search."%') "; } 
if(!empty($kategori)){ $sSQL.=" AND C.category_code=".tosql($kategori,"Text"); } 
if(!empty($subkategori)){ $sSQL.=" AND C.subcategory_code=".tosql($subkategori,"Text"); } 
$sSQL .= " GROUP BY C.courseid ORDER BY coursename";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;
$href_search = "index.php?data=".base64_encode('user;kursus/kursus_mohon_list.php;kursus;peserta');
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
	<?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
		$rskk = &$conn->Execute($sqlkk);
	?>
	<tr>
		<td width="30%" align="right"><b>Kategori Kursus : </b></td> 
		<td width="60%" align="left">
        	<select name="kategori"  onchange="do_page('<?=$href_search;?>')">
            	<option value="">-- Sila pilih kategori --</option>
                <?php while(!$rskk->EOF){ ?>
                <option value="<?php print $rskk->fields['id'];?>" <?php if($kategori==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
                <?php $rskk->movenext(); } ?>
            </select>
		</td>
	</tr>
	<?php 
		$sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 ORDER BY SubCategoryNm";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td align="right"><b>Pusat / Unit : </b></td> 
        <td align="left" colspan="2" >
            <select name="subkategori" onchange="do_page('<?=$href_search;?>')">
                <option value="">-- Sila pilih sub-kategori --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['id'];?>" <?php if($subkategori==$rskks->fields['id']){ print 'selected'; }?>><?php print pusat_list($rskks->fields['id']);?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </td>
    </tr>
	<tr>
		<td width="30%" align="right"><b>Nama Kursus : </b></td> 
		<td width="60%" align="left">
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>
	<? include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT KURSUS</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">&nbsp;&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="10%" align="center"><b>Kod Kursus</b></td>
                    <td width="40%" align="center"><b>Diskripsi Kursus</b></td>
                    <td width="15%" align="center"><b>Kategori Kursus</b></td>
                    <td width="20%" align="center"><b>Pusat / Unit</b></td>
                    <td width="5%" align="center"><b>Jumlah Pemohon</b></td>
                    <td width="5%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$del='';
						$bil = $cnt + ($PageNo-1)*$PageSize;
						$href_link = "modal_form.php?win=".base64_encode('kursus/kursus_mohon_form.php;'.$rs->fields['id']);
						//$href_link = "kursus/kursus_mohon_form.php?id=".$rs->fields['id'];
						//$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['subcategory_code'],"Text"));
						$unit = pusat_kursus($rs->fields['subcategory_code']);
						$jumlah = dlookup("_tbl_kursus_jadual_peserta","count(*)","EventId=".tosql($rs->fields['id']));
						?>
						<tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
							<td valign="top" align="right"><?=$bil;?>.</td>
							<td valign="top" align="left"><? echo stripslashes($rs->fields['courseid']);?>&nbsp;</td>
							<td valign="top" align="left"><? echo stripslashes($rs->fields['coursename']);?>&nbsp;</td>
							<td valign="top" align="left"><? echo dlookup("_tbl_kursus_cat","categorytype",
								"id=".tosql($rs->fields['category_code'],"Number"));?>&nbsp;</td>
							<td valign="top" align="center"><? echo stripslashes($unit);?>&nbsp;</td>
							<td valign="top" align="center"><? echo number_format($jumlah,0);?>&nbsp;</td>
							<td align="center">
								<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
								onclick="open_modal('<?=$href_link;?>','Paparan maklumat permohonan peserta kursus',1,1)" />
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
