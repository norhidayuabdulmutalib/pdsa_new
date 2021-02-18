<?
//$conn->debug=true;
if(!empty($_REQUEST['pro_daftar']) && $_REQUEST['pro_daftar']=='pro'){
	session_start();
	include '../../common.php';
	extract($_POST);
	print $_SESSION["s_logid"];
	$EventId = $_REQUEST["ids"];
	//print 'daftar';
	$sqli = "INSERT INTO _tbl_kursus_jadual_peserta(peserta_icno, EventId, InternalStudentSelectedDt, 
	InternalStudentAccepted, InternalStudentInputDt, InternalStudentInputBy)
	VALUES(".tosql($_SESSION["s_logid"]).", ".tosql($EventId).", ".tosql(date("Y-m-d H:i:s")).", 
	0, ".tosql(date("Y-m-d H:i:s")).", ".tosql($_SESSION["s_logid"]).")";
	//print $sqli;
	$conn->Execute($sqli);
	print '<script language="javascript">alert("Pendaftaran kursus sedang dalam proses.");parent.emailwindow.hide();</script>';
	exit;
}

//print $_SESSION["s_logid"];
$types=isset($_REQUEST["types"])?$_REQUEST["types"]:"";
if($types=='NEXT'){
	//$this_mth = date("m",strtotime("+1 months")); $this_year = date("Y",strtotime("+1 months"));
	$next_mth_start = date("m",strtotime("+1 months")); $next_year_start = date("Y",strtotime("+1 months"));
	$next_mth_end = date("m",strtotime("+2 months")); $next_year_end = date("Y",strtotime("+2 months"));
	$start_date=$next_year_start."-".$next_mth_start."-01";
	$end_date=$next_year_end."-".$next_mth_end."-31";
	//$jum_bln_depan = dlookup("_tbl_kursus_jadual","count(*)","startdate BETWEEN ".tosql($start_date)." AND ".tosql($end_date));
	//$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd FROM _tbl_kursus_jadual A, _tbl_kursus B WHERE A.courseid=B.id AND B.is_deleted=0 
	//AND startdate BETWEEN ".tosql($start_date)." AND ".tosql($end_date);
	$sSQL="SELECT A.* FROM _tbl_kursus_jadual A WHERE startdate BETWEEN ".tosql($start_date)." AND ".tosql($end_date);
} else {
	$this_mth = date("m"); $this_year=date("Y");
	//$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd FROM _tbl_kursus_jadual A, _tbl_kursus B WHERE A.courseid=B.id AND B.is_deleted=0 
	//AND month(startdate)='$this_mth' AND year(startdate)='$this_year' AND A.category_code=1";
	$sSQL="SELECT A.* FROM _tbl_kursus_jadual A WHERE month(startdate)='$this_mth' AND year(startdate)='$this_year'";
	//$sSQL.=((strlen($varSort)>0)?" ORDER BY $varSort ":" ORDER BY A.startdate ");
	 // AND startdate>=".tosql(date("Y-m-d"));
	/*$sSQL.=" UNION ";
	$sSQL.=" SELECT A.*, A.courseid, A.acourse_name AS coursename, A.sub_category_code AS SubCategoryCd 
	FROM _tbl_kursus_jadual A WHERE month(startdate)='$this_mth' AND year(startdate)='$this_year' AND category_code=2";
	$sSQL.=((strlen($varSort)>0)?" ORDER BY $varSort ":" ORDER BY startdate ");*/
}
//$strSort=((strlen($varSort)>0)?" ORDER BY $varSort ":" ORDER BY A.startdate ");
//$sSQL .= $strSort; //"ORDER BY B.coursename";
//print $sSQL;
//$conn->debug=true;
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
//$conn->debug=false;
?>
<script language="JavaScript1.2" type="text/javascript">
function daftar(ids){
	document.ilim.pro_daftar.value='pro';
	document.ilim.action = 'kursus/senarai_kursus.php?ids='+ids;
	document.ilim.submit();
}

function form_back(URL){
	parent.emailwindow.hide();
}
</script>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT KURSUS (PENJADUALAN)</strong></font>
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="8%" align="center"><b>Kod Kursus</b></td>
                    <td width="40%" align="center"><b>Diskripsi Kursus</b>&nbsp;</td>
                    <td width="10%" align="center"><b>Pusat/Unit</b></td>
                    <td width="10%" align="center"><b>Tarikh Mula</b>&nbsp;</td>
                    <td width="10%" align="center"><b>Tarikh Tamat</b>&nbsp;</td>
                    <td width="10%" align="center"><b>Bil. Peserta Daftar</b>&nbsp;</td>
					<?php if($_SESSION["s_user"]=='PESERTA'){ ?>
                    <td width="5%" align="center"><b>Daftar</b>&nbsp;</td>
                    <?php } ?>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
						//$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","SubCategoryCd=".tosql($rs->fields['SubCategoryCd'],"Text"));
						//$conn->debug=true;
						if(!empty($rs->fields['courseid'])){
							$sqlk = "SELECT courseid, coursename, SubCategoryCd FROM _tbl_kursus WHERE id=".tosql($rs->fields['courseid']);
							$rsk = &$conn->execute($sqlk);
							$nama_kursus = $rsk->fields['coursename'];
							$kod_kursus = $rsk->fields['courseid'];
						} else {
							$nama_kursus = $rs->fields['acourse_name']."<br><i>[".$rs->fields['nama_agensi']."]</i>";
							$kod_kursus = "-";
						}
						$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['sub_category_code'],"Text"));
						//$conn->debug=false;
						$pcount = dlookup("_tbl_kursus_jadual_peserta","count(*)","EventId=".tosql($rs->fields['id'],"Text"));
						$ucount = dlookup("_tbl_kursus_jadual_peserta","count(*)","peserta_icno=".tosql($_SESSION["s_logid"])." AND EventId=".tosql($rs->fields['id']));
						$sah_window = "modal_form.php?win=".base64_encode('peserta/kursus_permohonan.php;'.$rs_marque->fields['InternalStudentId']);
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="center"><?php echo stripslashes($kod_kursus);?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo stripslashes($nama_kursus);?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo stripslashes($unit);?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo DisplayDate($rs->fields['startdate'])?></td>
            				<td valign="top" align="center"><?php echo DisplayDate($rs->fields['enddate'])?></td>
            				<td valign="top" align="center"><?php echo $pcount;?></td>
							<?php if($_SESSION["s_user"]=='PESERTA'){ ?>
                            <td valign="top" align="center"><?php if($ucount==0){ ?>
                            	<!--<img src="../images/boxin1.gif" height="20" width="20" title="Sila klik untuk pendaftaran" style="cursor:pointer" 
                                onclick="daftar('<?=$rs->fields['id'];?>')" />-->
                            	<img src="../images/boxin1.gif" height="20" width="20" title="Sila klik untuk pendaftaran" style="cursor:pointer" 
                                onclick="open_modal('<?=$sah_window;?>&idkursus=<?=$rs->fields['id'];?>','Senarai peserta kursus pada hari ini <?=date("d/m/Y");?>',1,1)" />
								<?php } else { print 'Telah Mendaftar'; } ?>
                            </td>
                            <?php }?>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="7" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <?php } ?>                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5" align="center"><br />
    	<input type="button" value="Tutup" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan disiplin" onClick="form_back()" >	
        <input type="hidden" name="pro_daftar" />
	</td></tr>
</table> 
</form>
