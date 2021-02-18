<?
//$conn->debug=true;
$sSQL="SELECT D.id, A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate, F.ingenid 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D, _tbl_kursus_jadual_det E, _tbl_instructor F 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id=E.event_id 
AND E.instruct_id=F.ingenid AND F.insid = ".tosql($_SESSION["s_logid"],"Text");
$sSQL.= " ORDER BY enddate DESC";

//$sSQL = "SELECT A.*, B.insname, B.insorganization 
//FROM _tbl_kursus_jadual_det A, _tbl_instructor B 
//WHERE A.instruct_id=B.ingenid AND A.event_id=".tosql($id,"Text");
//$sSQL .= " AND (D.startdate>=".tosql(date("Y-m-d"))." OR D.enddate <= ".tosql(date("Y-m-d")).") ORDER BY D.startdate DESC";
//OR ".tosql(date("Y-m-d"))." BETWEEN B.startdate AND B.enddate 
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;

$href_search = "index.php?data=".base64_encode($userid.';apps/penceramah/kursus_diattach.php;penceramah;kursus');
?>
<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar.js"></script>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
</script>
<?php include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
	<?php include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="5" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI KURSUS YANG DIDAFTARKAN</strong></font>
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="8%" align="center"><b>Kod Kursus</b></td>
                    <td width="35%" align="center"><b>Diskripsi Kursus</b>&nbsp;</td>
                    <td width="10%" align="center"><b>Pusat/Unit</b></td>
                    <td width="10%" align="center"><b>Tarikh Mula</b>&nbsp;</td>
                    <td width="10%" align="center"><b>Tarikh Tamat</b>&nbsp;</td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		//$href_link = "modal_form.php?win=".base64_encode('peserta/kursus_dlmproses_sah.php;'.$rs->fields['InternalStudentId']);
						$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","SubCategoryCd=".tosql($rs->fields['SubCategoryCd'],"Text"));
						$href_link = "modal_form.php?win=".base64_encode('kursus/view_jadual_kursus.php;'.$rs->fields['id']);
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left">
							<label onclick="open_modal('<?=$href_link;?>&idk=<?=$rs->fields['id'];?>&idnama=<?=$rs->fields['ingenid'];?>','Katalog Kursus',80,80)" style="cursor:pointer">
							<u><b><?php echo stripslashes($rs->fields['courseid']);?></b></u></label>&nbsp;</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['coursename']);?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo stripslashes($unit);?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo DisplayDate($rs->fields['startdate'])?></td>
            				<td valign="top" align="center"><?php echo DisplayDate($rs->fields['enddate'])?></td>
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
