<?
$conn->debug=true;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$sSQL="SELECT * FROM _tbl_nilai_bahagian WHERE pset_id=".tosql($id);
$sSQL .= " ORDER BY nilai_sort";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$href_bahagian = "modal_form.php?win=".base64_encode('penilaian/set_penilaian_kursus_bahagian.php;')."&pset_id=".$id;
?>
<? include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="80%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="4" valign="middle" width="80%">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT RUJUKAN PENILAIAN KURSUS</strong></font>
        </td>
        <td width="20%" align="right" valign="middle">
       	  <input type="button" value="Tambah Maklumat Bahagian" style="cursor:pointer" 
            onclick="open_modal('<?=$href_bahagian;?>','Penambahan Maklumat bahagian',70,70)" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr><td colspan="5">&nbsp;</td></tr>
	<?
    if(!$rs->EOF) {
        $cnt = 1;
        $bil = $StartRec;
        while(!$rs->EOF  && $cnt <= $pg) {
            $bil = $cnt + ($PageNo-1)*$PageSize;
            $kat_blok = dlookup("_ref_kategori_blok","f_kb_desc","f_kb_id=".tosql($rs->fields['f_kb_id'],"Number"));
            ?>
	<tr height="25px" bgcolor="#666666">
    	<td colspan="4">&nbsp;&nbsp;<b><? echo stripslashes($rs->fields['nilai_keterangan']);?></b></td>
    	<td align="right"><input type="button" value="Tambah Maklumat" style="cursor:pointer" />&nbsp;</td>
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
            </table> 
        </td>
    </tr>
			<?
            $cnt = $cnt + 1;
            $bil = $bil + 1;
            $rs->movenext();
        } 
    } ?>                   
    <tr><td colspan="5">	
<?
if($cnt<>0){
	$sFileName=$href_search;
	include_once 'include/list_footer.php'; 
}
?> 
</td></tr>
<tr><td width="8%">        
</td><td width="8%"></td>
</table> 
</form>
