<?php
//$conn->debug=true;
$tomorrow  = MySQLDateOffset(date("Y-m-d"),0,0,-120); 
//$esok  = MySQLDateOffset(date("Y-m-d"),0,0,+1); 
$today = date("Y-m-d");
$sSQL="SELECT DISTINCT B.startdate, B.enddate, B.id, C.coursename, C.courseid, A.*, C.SubCategoryCd, C.subcategory_code 
FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B, _tbl_kursus C, _tbl_set_penilaian_peserta D 
WHERE A.EventId=B.id AND B.courseid=C.id  AND A.is_selected IN (1) AND A.is_deleted=0 AND A.peserta_icno=".tosql($_SESSION["s_logid"],"Text");
//$sSQL .= " AND A.InternalStudentAccepted=1 ";
//$sSQL .= " AND A.InternalStudentAccepted=1 AND A.is_nilai=0 ";
//$sSQL.=" AND B.enddate_nilai>".tosql($tomorrow);
$sSQL.=" AND B.enddate_nilai >'{$tomorrow}'  "; //AND B.enddate_nilai < '{$today}'

$sSQL.=" ORDER BY B.startdate DESC";
//$sSQL .= " AND B.enddate<=".tosql(date("Y-m-d"))." AND B.enddate_nilai>=".tosql(date("Y-m-d"))." ORDER BY B.startdate DESC";
//print $sSQL; 
//AND D.id_peserta=A.InternalStudentId

$rs = $conn->query($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;

$href_search = "index.php?data=".base64_encode($userid.';peserta/kursus_penilaian.php;peserta;penilaian');
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
	        &nbsp;&nbsp;<strong>SENARAI KURSUS YANG TELAH DIIKUTI DAN PERLU PENILAIAN PESERTA</strong></font>
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="1" cellpadding="4" cellspacing="0">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="5%" align="center"><b>Tindakan</b></td>
                    <td width="8%" align="center"><b>Kod Kursus</b></td>
                    <td width="35%" align="center"><b>Diskripsi Kursus</b>&nbsp;</td>
                    <td width="10%" align="center"><b>Pusat/Unit</b></td>
                    <td width="10%" align="center"><b>Tarikh Mula</b>&nbsp;</td>
                    <td width="10%" align="center"><b>Tarikh Tamat</b>&nbsp;</td>
                    <td width="5%" align="center"><b>Status Kehadiran</b>&nbsp;</td>
                    <td width="12%" align="center"><b>Status Serahan</b>&nbsp;</td>
                </tr>
				<?php
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                		$href_link = "modal_form.php?win=".base64_encode('peserta/kursus_penilaian_list.php;'.$rs->fields['InternalStudentId']);
						//$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","SubCategoryCd=".tosql($rs->fields['SubCategoryCd'],"Text"));
						$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['subcategory_code'],"Text"));
						$icno=$_SESSION["s_logid"];
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
                            <td align="center">
                            <?php if($rs->fields['InternalStudentAccepted']=='1'){ ?>
                            	<img src="../img/icon-info1.gif" width="25" height="25" style="cursor:pointer" title="Sila klik untuk proses penilaian kursus" 
                                onclick="open_modal('<?=$href_link;?>&kursus_id=<?=$rs->fields['id'];?>&ic=<?=$icno;?>','Proses Penilaian Kursus',90,90)" />
							<?php } else {
									print 'Sila buat pengesahan kehadiran';
								}
							?>
                            </td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['courseid']);?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['coursename']);?><br />
                            <?php print $rs->fields['InternalStudentId'];?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo stripslashes($unit);?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo DisplayDate($rs->fields['startdate'])?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo DisplayDate($rs->fields['enddate'])?>&nbsp;</td>
            				<td valign="top" align="center"><?
								if($rs->fields['InternalStudentAccepted']=='0'){ print 'Tiada pengesahan'; }
                            	else if($rs->fields['InternalStudentAccepted']=='1'){ print 'Hadir'; }
                            	elseif($rs->fields['InternalStudentAccepted']=='2'){ 
									print '<font color="#FF0000">Tidak Hadir</font>'; 
									print "<br><i>".$rs->fields['InternalStudentReason']."</i>";
								}
							?>&nbsp;</td>
            				<td valign="top" align="center"><?
								if($rs->fields['is_nilai']=='0'){ print '<font color=red>Belum Membuat Serahan</font>'; }
								else if($rs->fields['is_nilai']=='1'){ print 'Serahan telah dilakukan'; }
							?>&nbsp;</td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="9" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
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
<tr><td align="left" colspan="5">
<b>NOTA:</b>
<br />- Sila klik pada ikon <img src="../img/icon-info1.gif" width="25" height="25"  /> untuk membuat penilaian kepada kursus yang telah dihadiri. 
<br />- Senarai kursus yang dipaparkan adalah berdasarkan kepada kursus yang ditawarkan bagi tempoh 4 bulan kebelakang.
<br />- Mana-mana kursus yang dihadiri tiada dalam senarai bagi tujuan penilaian, sila pastikan status kehadiran peserta telah <b>disahkan hadir</b>. Sila semak senarai maklumat kursus bagi tujuan semakan pengesahan kehadiran.       
</td></td>
</table> 
</form>
