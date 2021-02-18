<?
//$conn->debug=true;
$sSQL="SELECT B.startdate, B.enddate, C.coursename, C.courseid, A.*, C.SubCategoryCd 
FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B, _tbl_kursus C 
WHERE A.EventId=B.id AND B.courseid=C.id AND A.approve_ilim=1 AND A.InternalStudentAccepted>0 AND A.peserta_icno=".tosql($_SESSION["s_logid"],"Text");
$sSQL .= " AND (B.startdate>=".tosql(date("Y-m-d"))." OR B.enddate <= ".tosql(date("Y-m-d")).") ORDER BY B.startdate DESC";
//OR ".tosql(date("Y-m-d"))." BETWEEN B.startdate AND B.enddate 
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;

$href_search = "index.php?data=".base64_encode('user;peserta/kursus_dlmproses.php;peserta;kursus');
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
<? include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
	<? include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="5" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI KURSUS YANG DIDAFTARKAN UNTUK DIIKUTI</strong></font>
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
                    <td width="17%" align="center"><b>Status Kehadiran</b>&nbsp;</td>
                    <td width="5%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode('peserta/kursus_dlmproses_sah.php;'.$rs->fields['InternalStudentId']);
						$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","SubCategoryCd=".tosql($rs->fields['SubCategoryCd'],"Text"));
                        ?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['courseid']);?>&nbsp;</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['coursename']);?>&nbsp;</td>
            				<td valign="top" align="center"><? echo stripslashes($unit);?>&nbsp;</td>
            				<td valign="top" align="center"><? echo DisplayDate($rs->fields['startdate'])?>&nbsp;</td>
            				<td valign="top" align="center"><? echo DisplayDate($rs->fields['enddate'])?>&nbsp;</td>
            				<td valign="top" align="center"><?
								if($rs->fields['InternalStudentAccepted']=='0'){ print 'Tiada pengesahan'; }
                            	else if($rs->fields['InternalStudentAccepted']=='1'){ print 'Hadir'; }
                            	elseif($rs->fields['InternalStudentAccepted']=='2'){ 
									print '<font color="#FF0000">Tidak Hadir</font>'; 
									print "<br><i>".$rs->fields['InternalStudentReason']."</i>";
								}
							?>&nbsp;</td>
                            <td align="center">
                            <?php if($rs->fields['enddate']>=date("Y-m-d")){ ?>
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengesahan kehadiran" 
                                onclick="open_modal('<?=$href_link;?>','Pengesahan Kehadiran Kursus',70,70)" />
                            <?php } ?>
                            &nbsp;</td>
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
