<?
//$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$sSQL="SELECT A.*, B.f_penilaian, C.pset_detailid FROM _ref_penilaian_maklumat A, _ref_penilaian_kategori B, _tbl_penilaian_det_detail C 
WHERE A.f_penilaianid=B.f_penilaianid AND A.is_deleted=0 AND A.f_penilaian_detailid=C.f_penilaian_detailid AND C.pset_id=".tosql($id);
$sSQL .= " ORDER BY A.f_penilaianid, A.f_penilaian_desc";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

?>
<? include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="80%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT RUJUKAN PENILAIAN</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        	<input type="button" value="Tambah Maklumat Penilaian" style="cursor:pointer" 
            onclick="open_modal('<?=$href_link;?>','Penambahan Maklumat Penilaian',80,80)" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="65%" align="center"><b>Maklumat Penilaian</b></td>
                    <td width="25%" align="center"><b>Kategori Penilaian</b></td>
                    <td width="5%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
						$kat_blok = dlookup("_ref_kategori_blok","f_kb_desc","f_kb_id=".tosql($rs->fields['f_kb_id'],"Number"));
                        ?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['f_penilaian_desc']);?>&nbsp;</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['f_penilaian']);?>&nbsp;</td>
                            <td align="center"><img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data"
                            onclick="open_modal('<?=$href_link;?>&iddel=<?=$rs->fields['pset_detailid'];?>&proses=DEL','Hapus Maklumat Penilaian',20,20)" /></td>
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
