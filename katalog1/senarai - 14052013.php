<?
//$conn->debug=true;
$href_search = "index.php";

$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$subkategori=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd AS SUB, B.subcategory_code FROM _tbl_kursus_jadual A, _tbl_kursus B WHERE A.courseid=B.id AND B.is_deleted=0 AND year(A.enddate)=".tosql(date("Y"));
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
$sSQL .= $strSort; //"ORDER BY B.coursename";
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
<table width="99%" align="center" cellpadding="2" cellspacing="0" border="0">
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
	<!--<tr>
		<td width="30%" align="right"><b>Tarikh Kursus : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
        	Mula : 
			<input type="text" size="13" name="tkh_mula" value="<? echo $tkh_mula;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="18" height="18" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
            &nbsp;&nbsp;&nbsp;Tamat : 
			<input type="text" size="13" name="tkh_tamat" value="<? echo $tkh_tamat;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="18" height="18" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/> [dd/mm/yyyy]
		</td>
	</tr>-->
</table>	
<? include_once 'apps/include/list_head.php'; ?>
<table width="100%" align="center" cellpadding="2" cellspacing="0" border="0">
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
                    <td width="20%" align="center"><b>Tarikh Kursus</b></td>
                    <td width="20%" align="center"><b>Status</b></td>
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
						if($rs->fields['startdate']<=date("Y-m-d")){ $disp = '<font color="#FF0000">Tutup</font>'; } else { $disp='Buka'; }
						if($rs->fields['status']=='2'){ $disp = '<font color="#FF0000"><b>Telah Dibatalkan</b></font>'; }
						else if($rs->fields['status']=='1'){ $disp = '<font color="#FF0000">Tutup</font>'; }
                        ?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="center">
							<label onclick="open_modal('<?=$href_link;?>','Katalog Kursus',80,80)" style="cursor:pointer">
                            <u><b><? echo stripslashes($rs->fields['courseid']);?></b></u></label>&nbsp;</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['coursename']);?>&nbsp;</td>
            				<td valign="top" align="center"><? echo DisplayDate($rs->fields['startdate'])?><br />-<br />
                            <? echo DisplayDate($rs->fields['enddate'])?>&nbsp;</td>
                            <td valign="top" align="center"><? echo stripslashes($disp);?>&nbsp;</td>
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