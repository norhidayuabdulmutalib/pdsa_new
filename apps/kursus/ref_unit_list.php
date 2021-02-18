<?php
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";

$sSQL="SELECT A.*, B.categorytype, C.kampus_kod FROM _tbl_kursus_catsub A, _tbl_kursus_cat B, _ref_kampus C 
WHERE A.f_category_code=B.id AND A.kampus_id=C.kampus_id AND A.is_deleted=0 ";
$sSQL .= $sql_filter;
if(!empty($search)){ $sSQL.=" AND (A.SubCategoryNm LIKE '%".$search."%' OR A.SubCategoryDesc LIKE '%".$search."%') "; } 
if(!empty($kategori)){ $sSQL.=" AND A.f_category_code =".tosql($kategori); } 
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND A.kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sSQL.=" AND A.kampus_id=".$kampus_id; }
$sSQL .= " ORDER BY A.kampus_id, f_category_code";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode('user;kursus/ref_unit_list.php;kursus;unit');
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
            <select name="kampus_id" style="width:80%" onchange="do_page('<?=$href_search;?>')">
                <option value="">-- Sila pilih kampus --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($kampus_id==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </td>
    </tr>
    <?php } ?>

    <?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ";
			if($_SESSION["s_level"]<>'99'){ $sqlkk .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
			if(!empty($kampus_id)){ $sqlkk.=" AND kampus_id=".$kampus_id; }
		  $sqlkk .= " ORDER BY category_code";
        $rskk = &$conn->Execute($sqlkk);
    ?>
    <tr>
        <td align="right"><b>Kategori Kursus : </b></td> 
        <td align="left" colspan="2" >&nbsp;
            <select name="kategori" onchange="do_page('<?=$href_search;?>')">
                <option value="">-- Sila pilih kategori --</option>
                <?php while(!$rskk->EOF){ ?>
                <option value="<?php print $rskk->fields['id'];?>" <?php if($kategori==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
                <?php $rskk->movenext(); } ?>
            </select>
        </td>
    </tr>
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>
	<?php include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT PUSAT / UNIT KURSUS</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        	<?php $new_page = "modal_form.php?win=".base64_encode('kursus/ref_unit_form.php;');?>
        	<input type="button" value="Tambah Maklumat Unit / Pusat Kursus" style="cursor:pointer" 
            onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Unit / Pusat Kursus',700,400)" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="15%" align="center"><b>Kategori Kursus</b></td>
                    <td width="20%" align="center"><b>Kod Pusat / Unit Kursus</b></td>
                    <td width="30%" align="center"><b>Diskripsi Pusat / Unit Kursus</b></td>
                    <td width="10%" align="center"><b>Pusat</b></td>
                    <td width="10%" align="center"><b>Status</b></td>
                    <td width="10%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode('kursus/ref_unit_form.php;'.$rs->fields['id']);
						//$conn->debug=true;
						$cntk = dlookup("_tbl_kursus_jadual","count(*)","sub_category_code=".tosql($rs->fields['id'],"Number"));
						$conn->debug=false;
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.<?//=$rs->fields['id'];?></td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['categorytype']);?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['SubCategoryNm']);?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['SubCategoryDesc']);?>&nbsp;</td>
            				<td valign="top" align="center"><?php print $rs->fields['kampus_kod'];?>&nbsp;</td>
                            <td valign="top" align="center">
                            	<?php if($rs->fields['f_status']=='0'){ print 'Aktif'; }
									else if($rs->fields['f_status']=='1'){ print 'Tidak Aktif'; } 
									else { print '&nbsp;'; }
								?>
                            </td>
                            <td align="center">
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Kategori Kursus',700,400)" />
                                <?php if($cntk==0){ ?>
                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data"
                                onclick="do_hapus('tbl_kursus_catsub','<?=$rs->fields['id'];?>')" />
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
