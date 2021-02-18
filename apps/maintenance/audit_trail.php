<?php
$conn->debug=true;
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";

if(!empty($proses) && $proses=='DEL'){
	$sql=isset($_REQUEST["sql"])?$_REQUEST["sql"]:"";
	$sqldel = "DELETE FROM auditrail ".$sql;
	//print $sqldel;
	$conn->Execute($sqldel);
	print '<script language=javascript>alert("Maklumat telah dihapuskan");</script>';
}
//if(!empty($kampus_id)){
//	$sSQL="SELECT A.* FROM auditrail A, _tbl_user B WHERE A.aid<>0 AND A.id_user=B.id_user "; 
//} else {
	$sSQL="SELECT A.* FROM auditrail A WHERE A.aid<>0 "; 
//}
if(!empty($tkh_mula) && empty($tkh_tamat)){ $sSQL1.=" AND A.trans_date>=".tosql(DBDate($tkh_mula)." 00:00:00"); } 
if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sSQL1.=" AND A.trans_date BETWEEN ".tosql(DBDate($tkh_mula)." 00:00:00")." 
	AND ".tosql(DBDate($tkh_tamat)." 00:00:00"); } 
if(!empty($search)){ $sSQL1.=" AND ( A.log_user LIKE '%".$search."%' OR A.id_user LIKE '%".$search."%' 
	OR A.remarks LIKE '%".$search."%' )"; } 
//if(!empty($kampus_id)){ $sSQL1.=" AND B.kampus_id=".$kampus_id; }
$sSQL .= $sSQL1." ORDER BY A.trans_date DESC";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode('user;maintenance/audit_trail.php;admin;audit');
?>
<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar2.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js"></script>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
	function do_hapus(URL){
		var rec = document.ilim.jum_rec.value;
		if(confirm("Sebanyak "+rec+" rekod tersenarai dalam carian anda.\nAdakah anda pasti untuk menghapuskan kesemua "+rec+" rekod ini daripada senarai?")){
			document.ilim.action = URL;
			document.ilim.target = '_self';
			document.ilim.submit();
		}
	}
</script>
<?php include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
	<?php if($_SESSION["s_level"]=='99'){
	  //$conn->debug=true;
        $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td width="30%" align="right"><b>Pusat Latihan : </b></td>
        <td width="70%" align="left">
            <select name="kampus_id" style="width:80%" onchange="do_page('<?=$href_search;?>')">
                <option value="">-- Sila pilih kampus --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($kampus_id==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </td>
    </tr>
    <?php } ?>
	<tr>
		<td width="30%" align="right"><b>Tarikh Transaksi : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
        	Mula : 
			<input type="text" size="13" name="tkh_mula" value="<? echo $tkh_mula;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
            &nbsp;&nbsp;&nbsp;Tamat : 
			<input type="text" size="13" name="tkh_tamat" value="<?php echo $tkh_tamat;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/> [dd/mm/yyyy]
		</td>
	</tr>
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
            &nbsp;&nbsp;
			<input type="button" name="Hapus" value="  Hapus  " onClick="do_hapus('<?=$href_search;?>&pro=DEL')">
            <input type="hidden" name="sql" value="<?=$sSQL1;?>" size="100" />
            <input type="hidden" name="jum_rec" value="<?=$RecordCount;?>" />
		</td>
	</tr>
	<?php include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT AUDIT TRAIL</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="60%" align="center"><b>Maklumat Proses</b></td>
                    <td width="20%" align="center"><b>Pengguna & Masa</b></td>
                    <td width="10%" align="center"><b>IP</b></td>
                    <!--<td width="5%" align="center"><b>&nbsp;</b></td>-->
                </tr>
				<?php
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['remarks']);?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['log_user']);?><br />
							<i><?php echo stripslashes($rs->fields['trans_date']);?></i>&nbsp;</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['ip']);?>&nbsp;</td>
                            <!--<td align="center">
                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data" />
                            </td>-->
                        </tr>
                        <?php
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="4" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
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
