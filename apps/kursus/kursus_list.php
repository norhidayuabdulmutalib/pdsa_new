<?php
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$subkategori=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
$bidang_id=isset($_REQUEST["bidang_id"])?$_REQUEST["bidang_id"]:"";

$sSQL="SELECT * FROM _tbl_kursus WHERE is_deleted=0 ";
if(!empty($search)){ $sSQL.=" AND (coursename LIKE '%".$search."%' OR courseid  LIKE '%".$search."%') "; } 
if(!empty($kategori)){ $sSQL.=" AND category_code=".tosql($kategori,"Text"); } 
if(!empty($subkategori)){ $sSQL.=" AND subcategory_code=".tosql($subkategori,"Text"); } 
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sSQL.=" AND kampus_id=".$kampus_id; }
if(!empty($bidang_id)){ $sSQL.=" AND bidang_id=".tosql($bidang_id); }
$sSQL .= " ORDER BY courseid, coursename";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
//print $sSQL;
$href_search = "index.php?data=".base64_encode($userid.';kursus/kursus_list.php;kursus;kursus');
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
<table width="99%" align="center" cellpadding="3" cellspacing="0" border="0">
	<?php if($_SESSION["s_level"]=='99'){
	  //$conn->debug=true;
        $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td width="30%" align="right"><b>Pusat Latihan : </b></td>
        <td width="70%" align="left">&nbsp;
            <select name="kampus_id" style="width:90%" style="width:90%" onchange="do_page('<?=$href_search;?>')">
                <option value="">-- Sila pilih kampus --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($kampus_id==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </td>
    </tr>
    <?php } ?>
	<!--<?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
		$rskk = &$conn->Execute($sqlkk);
	?>
	<tr>
		<td width="30%" align="right"><b>Kategori Kursus : </b></td> 
		<td width="60%" align="left">&nbsp;
        	<select name="kategori"  onchange="do_page('<?=$href_search;?>')">
            	<option value="">-- Sila pilih kategori --</option>
                <?php while(!$rskk->EOF){ ?>
                <option value="<?php print $rskk->fields['id'];?>" <?php if($kategori==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
                <?php $rskk->movenext(); } ?>
            </select>
		</td>
	</tr>-->
    <tr>
        <td align="right"><b>Bidang : </b></td>
        <td>&nbsp;
            <select name="bidang_id" style="width:90%" onchange="do_page('<?=$href_search;?>')">
            <option value="">-- Sila pilih bidang --</option>
            <?php 
            $r_gred = &$conn->execute("SELECT * FROM _ref_kepakaran ORDER BY f_pakar_nama");
            while (!$r_gred->EOF){ ?>
            <option value="<?=$r_gred->fields['f_pakar_code'] ?>" 
            <?php if($bidang_id==$r_gred->fields['f_pakar_code']){ print "selected"; }?>><?=$r_gred->fields['f_pakar_nama']?></option>
            <?php $r_gred->movenext(); }?>        
           </select>
        </td>
    </tr>
	<?php 
		$sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 AND f_status=0 ";
		if($_SESSION["s_level"]<>'99'){ $sqlkks .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
		if(!empty($kampus_id)){ $sqlkks.=" AND kampus_id=".$kampus_id; }
		$sqlkks .=" ORDER BY SubCategoryNm";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td align="right"><b>Pusat / Unit : </b></td> 
        <td align="left" colspan="2" >&nbsp;
            <select name="subkategori" style="width:90%" onchange="do_page('<?=$href_search;?>')">
                <option value="">-- Sila pilih sub-kategori --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['id'];?>" <?php if($subkategori==$rskks->fields['id']){ print 'selected'; }?>><?php print pusat_list($rskks->fields['id']);?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </td>
    </tr>
	<tr>
		<td width="30%" align="right"><b>Nama Kursus : </b></td> 
		<td width="60%" align="left">&nbsp;
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>
	<?php include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT KURSUS</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        	<? $new_page = "modal_form.php?win=".base64_encode('kursus/kursus_form.php;');?>
        	<input type="button" value="Tambah Maklumat Kursus" style="cursor:pointer" 
            onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Kursus',1,1)" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="10%" align="center"><b>Kod Kursus</b></td>
                    <td width="40%" align="center"><b>Diskripsi Kursus</b></td>
                    <td width="15%" align="center"><b>Kategori Kursus</b></td>
                    <td width="15%" align="center"><b>Bidang</b></td>
                    <td width="5%" align="center"><b>Pusat / Unit</b></td>
                    <td width="10%" align="center"><b>Status</b></td>
                    <td width="5%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?php
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$del='';
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode('kursus/kursus_form.php;'.$rs->fields['id']);
						$cntk = dlookup("_tbl_kursus_jadual","count(*)","courseid=".tosql($rs->fields['id'],"Text"));
						$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['subcategory_code'],"Text"));
						//$unit = pusat_kursus($rs->fields['subcategory_code']);
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['courseid']);?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['coursename']);?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo dlookup("_tbl_kursus_cat","categorytype","id=".tosql($rs->fields['category_code'],"Number"));?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo dlookup("_ref_kepakaran","f_pakar_nama","f_pakar_code=".tosql($rs->fields['bidang_id']));?>&nbsp;</td>
                            <td valign="top" align="center"><?php echo stripslashes($unit);?>&nbsp;</td>
                            <td valign="top" align="center">
                            	<?php 
									if($rs->fields['status']=='0'){ print 'Aktif'; }
									else if($rs->fields['status']=='1'){ print 'Tidak Aktif'; } 
									else { print '&nbsp;'; }
								?>
                            </td>
                            <td align="center">
                            	<?php if($_SESSION["s_jabatan"]==$rs->fields['subcategory_code'] || 
									$_SESSION["s_level"]==1 || $_SESSION["s_level"]==99){ ?>
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Kursus',1,1)" />
                                <?php } ?>
                            	 <?php if($cntk==0){ ?>
                                	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data"
                                	onclick="do_hapus('tbl_kursus','<?=$rs->fields['id'];?>')" />
                                <?php } else { ?>
                                	<!--<img src="../img/ico-cancel_x.gif" width="30" height="30" style="cursor:pointer" title="Data tidak boleh dihapuskan" />-->
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
