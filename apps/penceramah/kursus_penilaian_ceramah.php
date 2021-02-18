<?
//$conn->debug=true;
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$subkategori=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
$varSort=isset($_REQUEST["sb"])?$_REQUEST["sb"]:"startdate";
$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd, B.subcategory_code 
FROM _tbl_kursus_jadual A, _tbl_kursus B,  _tbl_kursus_jadual_det C 
WHERE A.courseid=B.id AND A.id=C.event_id AND B.is_deleted=0 AND C.instruct_id=".tosql($_SESSION["s_userid"]);
if(!empty($search)){ $sSQL.=" AND B.coursename LIKE '%".$search."%' "; } 
if(!empty($kategori)){ $sSQL.=" AND B.category_code=".tosql($kategori,"Text"); } 
if(!empty($subkategori)){ $sSQL.=" AND B.subcategory_code=".tosql($subkategori,"Text"); } 
if(!empty($tkh_mula) && empty($tkh_tamat)){ $sSQL.=" AND A.startdate>=".tosql(DBDate($tkh_mula),"Text"); } 
if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sSQL.=" AND A.startdate BETWEEN ".tosql(DBDate($tkh_mula),"Text")." AND ".tosql(DBDate($tkh_tamat),"Text"); } 
//$strSort=((strlen($varSort)>0)?"ORDER BY $varSort ":"ORDER BY coursename ");
if($varSort=='coursename'){ 
	$strSort=((strlen($varSort)>0)?" ORDER BY $varSort ASC":" ORDER BY startdate DESC");
} else {
	$strSort=((strlen($varSort)>0)?" ORDER BY $varSort DESC":" ORDER BY startdate DESC");
}
//$strSort=((strlen($varSort)>0)?"ORDER BY $enddate ":"ORDER BY enddate ");
$sSQL .= $strSort; //"ORDER BY B.coursename";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;

$href_search = "index.php?data=".base64_encode('user;penceramah/kursus_penilaian_ceramah.php;penceramah;penilaian');
?>
<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar2.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js"></script>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
</script>
<? include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="2" cellspacing="0" border="0">
	<?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
		$rskk = &$conn->Execute($sqlkk);
	?>
	<tr>
		<td width="30%" align="right"><b>Kategori Kursus : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
        	<select name="kategori">
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
        <td align="left" colspan="2" >&nbsp;&nbsp;
            <select name="subkategori" onchange="do_page('<?=$href_search;?>')">
                <option value="">-- Sila pilih sub-kategori --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['id'];?>" <?php if($subkategori==$rskks->fields['id']){ print 'selected'; }?>><?php print $rskks->fields['SubCategoryNm'];?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </td>
    </tr>
	<tr>
		<td width="30%" align="right"><b>Tarikh Kursus: </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
        	Mula : 
			<input type="text" size="13" name="tkh_mula" value="<? echo $tkh_mula;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
            &nbsp;&nbsp;&nbsp;Tamat : 
			<input type="text" size="13" name="tkh_tamat" value="<? echo $tkh_tamat;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/> [dd/mm/yyyy]
		</td>
	</tr>
	<tr>
		<td width="30%" align="right"><b>Nama Kursus: </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>
	<? include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="5" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT KURSUS (PENILAIAN KURSUS BAGI PENCERAMAH)</strong></font>
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="1" cellpadding="4" cellspacing="0">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="8%" align="center"><b>Kod Kursus</b></td>
                    <td width="50%" align="center">
                    <a href="<?php echo $href_search."../penilaian/&sb=coursename&search=$search&tkh_mula=$tkh_mula&tkh_tamat=$tkh_tamat"; ?>"><b>Diskripsi Kursus</b></a>&nbsp;
					<?php echo (($varSort=="coursename")?"<img src=\"../images/down_arrow.gif\">":"");?></td>
                    <td width="10%" align="center"><b>Pusat/Unit</b></td>
                    <td width="10%" align="center"><a href="<?php echo $href_search."../penilaian/&sb=startdate&tkh_mula=$tkh_mula&tkh_tamat=$tkh_tamat&search=$search"; ?>"><b>Tarikh Mula</b></a>&nbsp;
					<?php echo (($varSort=="startdate")?"<img src=\"../images/down_arrow.gif\">":"");?></td>
                    <td width="10%" align="center"><a href="<?php echo $href_search."../penilaian/&sb=enddate&tkh_mula=$tkh_mula&tkh_tamat=$tkh_tamat&search=$search"; ?>"><b>Tarikh Tamat</b></a>&nbsp;
					<?php echo (($varSort=="enddate")?"<img src=\"../images/down_arrow.gif\">":"");?></td>
                    <td width="5%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
						$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm",
						"SubCategoryCd=".tosql($rs->fields['SubCategoryCd'],"Text")." OR id=".tosql($rs->fields['sub_category_code'],"Text"));
						$href_borang = "modal_form.php?win=".base64_encode('penceramah/view_peratusan_penilaian.php;'.$rs->fields['id']);
                        ?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['courseid']);?>&nbsp;</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['coursename']);?>&nbsp;</td>
            				<td valign="top" align="center"><? echo stripslashes($unit);?>&nbsp;</td>
            				<td valign="top" align="center"><? echo DisplayDate($rs->fields['startdate'])?>&nbsp;</td>
            				<td valign="top" align="center"><? echo DisplayDate($rs->fields['enddate'])?>&nbsp;</td>
                            <td align="center">
                            <?php if($_SESSION["s_jabatan"]==$rs->fields['subcategory_code'] || $_SESSION["s_level"]==1){ ?>
                            	<img src="../images/printer_icon1.jpg" width="25" height="25" style="cursor:pointer" 
				                onclick="open_modal('<?=$href_borang;?>','Cetak borang penilaian kursus',1,1)" title="Cetak borang penilaian kursus" />
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
                <tr><td colspan="7" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
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
