<?
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$subkategori=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
$sSQL="SELECT * FROM _tbl_kursus WHERE is_deleted=0 ";
if(!empty($search)){ $sSQL.=" AND (coursename LIKE '%".$search."%' OR courseid  LIKE '%".$search."%') "; } 
if(!empty($kategori)){ $sSQL.=" AND category_code=".tosql($kategori,"Text"); } 
if(!empty($subkategori)){ $sSQL.=" AND subcategory_code=".tosql($subkategori,"Text"); } 
$sSQL .= "ORDER BY coursename";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode('user;senarai.php;kursus;');
?>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
</script>
<br />
<? include_once 'apps/include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="2" cellspacing="0" border="0">
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
                <option value="<?php print $rskks->fields['id'];?>" <?php if($subkategori==$rskks->fields['id']){ print 'selected'; }?>><?php print $rskks->fields['SubCategoryNm'];?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </td>
    </tr>
	<!--<tr>
		<td width="30%" align="right"><b>Nama Kursus : </b></td> 
		<td width="60%" align="left">
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>-->
	<? include_once 'apps/include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="5" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT KATALOG KURSUS</strong></font>
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="10%" align="center"><b>Kod Kursus</b></td>
                    <td width="45%" align="center"><b>Diskripsi Kursus</b></td>
                    <td width="20%" align="center"><b>Kategori Kursus</b></td>
                    <td width="20%" align="center"><b>Pusat / Unit</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$del='';
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode('katalog/view_katalog.php;'.$rs->fields['id']);
						/*$cntk = dlookup("_tbl_kursus_jadual","count(*)","courseid=".tosql($rs->fields['id'],"Text"));*/
						$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['subcategory_code'],"Text"));
                        ?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left">
							<label onclick="open_modal('<?=$href_link;?>','Katalog Kursus Kursus',80,80)" style="cursor:pointer">
                            <u><b><? echo stripslashes($rs->fields['courseid']);?></b></u></label>&nbsp;</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['coursename']);?>&nbsp;</td>
            				<td valign="top" align="left"><? echo dlookup("_tbl_kursus_cat","categorytype","id=".tosql($rs->fields['category_code'],"Number"));?>&nbsp;</td>
                            <td valign="top" align="center"><? echo stripslashes($unit);?>&nbsp;</td>
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
	include_once 'apps/include/list_footer.php'; 
}
?> 
</td></tr>
<tr><td>        
</td></td>
</table> 
</form>
